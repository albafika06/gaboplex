<?php

namespace App\Services;

use App\Models\User;
use App\Models\Contrat;
use App\Models\ScoreHistorique;

class ScoreService
{
    // ── Définition des points par action ──────────────────────────────────────
    const POINTS = [
        'inscription'                 =>  0,
        'profil_complet'              => 15,
        'paiement_complet_airtel'     =>  6,
        'paiement_complet_moov'       =>  6,
        'paiement_complet_cash'       =>  3,
        'paiement_partiel'            =>  2,
        'paiement_avance'             =>  8,
        'retard_paiement'             => -5,
        'non_paiement'                => -10,
        'litige_ouvert'               => -15,
        'litige_resolu_faveur'        => 10,
        'litige_perdu'                => -20,
        'avis_positif'                => 10,
        'avis_negatif'                => -8,
        'contrat_ferme_solde'         => 10,
        'photo_signalee'              => -15,
        'annonce_verifiee'            =>  5,
    ];

    /**
     * Appliquer une action au score d'un utilisateur
     */
    public static function appliquer(
        User    $user,
        string  $action,
        ?Contrat $contrat = null,
        ?string $detail = null
    ): void {
        $points = self::POINTS[$action] ?? 0;
        if ($points === 0 && $action !== 'inscription') return;

        $avant  = $user->score;
        $apres  = max(0, min(100, $avant + $points));

        // Sauvegarder l'historique
        ScoreHistorique::create([
            'user_id'     => $user->id,
            'contrat_id'  => $contrat?->id,
            'action'      => $action,
            'points'      => $points,
            'score_avant' => $avant,
            'score_apres' => $apres,
            'detail'      => $detail ?? self::labelAction($action),
        ]);

        // Mettre à jour le score
        $user->update(['score' => $apres]);
    }

    /**
     * Appelé quand un paiement est confirmé des deux côtés
     */
    public static function onPaiementConfirme(
        \App\Models\PaiementContrat $paiement,
        Contrat $contrat
    ): void {
        $locataire     = $contrat->locataire;
        $proprietaire  = $contrat->proprietaire;

        // Déterminer l'action selon le mode et le statut
        $actionLocataire = match(true) {
            $paiement->statut === 'avance'   => 'paiement_avance',
            $paiement->statut === 'partiel'  => 'paiement_partiel',
            $paiement->mode === 'airtel_money' => 'paiement_complet_airtel',
            $paiement->mode === 'moov_money'   => 'paiement_complet_moov',
            default                            => 'paiement_complet_cash',
        };

        $periode = $paiement->periode_label ?? $paiement->periode;

        self::appliquer(
            $locataire,
            $actionLocataire,
            $contrat,
            'Paiement ' . $periode . ' confirmé — ' . number_format($paiement->montant_paye, 0, ',', ' ') . ' FCFA'
        );

        // Le propriétaire gagne aussi des points quand il confirme
        self::appliquer(
            $proprietaire,
            'paiement_complet_cash', // même logique côté propriétaire
            $contrat,
            'Réception loyer ' . $periode . ' confirmée'
        );
    }

    /**
     * Appelé quand un retard est détecté automatiquement
     */
    public static function onRetard(Contrat $contrat, string $periode): void
    {
        self::appliquer(
            $contrat->locataire,
            'retard_paiement',
            $contrat,
            'Retard de paiement — ' . $periode
        );
    }

    /**
     * Appelé quand un non-paiement est constaté après délai
     */
    public static function onNonPaiement(Contrat $contrat, string $periode): void
    {
        self::appliquer(
            $contrat->locataire,
            'non_paiement',
            $contrat,
            'Non-paiement constaté — ' . $periode
        );
    }

    /**
     * Appelé quand un litige est ouvert
     */
    public static function onLitigeOuvert(Contrat $contrat, User $plaignant): void
    {
        // La partie contre qui le litige est ouvert perd des points
        $adverse = $plaignant->id === $contrat->locataire_id
            ? $contrat->proprietaire
            : $contrat->locataire;

        self::appliquer(
            $adverse,
            'litige_ouvert',
            $contrat,
            'Litige ouvert à votre encontre'
        );
    }

    /**
     * Appelé quand un contrat est fermé proprement (tout soldé)
     */
    public static function onContratFerme(Contrat $contrat): void
    {
        self::appliquer(
            $contrat->locataire,
            'contrat_ferme_solde',
            $contrat,
            'Contrat terminé et soldé — ' . $contrat->annonce->titre
        );

        self::appliquer(
            $contrat->proprietaire,
            'contrat_ferme_solde',
            $contrat,
            'Contrat terminé et soldé — ' . $contrat->annonce->titre
        );
    }

    /**
     * Appelé quand un avis est laissé en fin de contrat
     */
    public static function onAvisRecu(User $user, int $note, Contrat $contrat): void
    {
        $action = $note >= 3 ? 'avis_positif' : 'avis_negatif';
        self::appliquer($user, $action, $contrat, 'Avis ' . $note . '/5 reçu');
    }

    /**
     * Appelé à l'inscription pour monter rapidement avec le profil
     */
    public static function onProfilComplet(User $user): void
    {
        // Vérifier qu'on n'a pas déjà donné ces points
        $dejaGagne = ScoreHistorique::where('user_id', $user->id)
            ->where('action', 'profil_complet')
            ->exists();

        if (!$dejaGagne) {
            self::appliquer($user, 'profil_complet', null, 'Profil complété — photo + numéro vérifié');
        }
    }

    /**
     * Badge affiché selon le score
     */
    public static function badge(int $score): array
    {
        return match(true) {
            $score >= 90 => ['label' => 'Elite GaboPlex',  'bg' => '#042C53', 'color' => 'white'],
            $score >= 75 => ['label' => 'De confiance',    'bg' => '#185FA5', 'color' => 'white'],
            $score >= 60 => ['label' => 'Fiable',          'bg' => '#EAF3DE', 'color' => '#27500A'],
            $score >= 40 => ['label' => 'Profil actif',    'bg' => '#E6F1FB', 'color' => '#0C447C'],
            default      => ['label' => 'Profil basique',  'bg' => '#f1f5f9', 'color' => '#64748b'],
        };
    }

    // ── Labels lisibles ───────────────────────────────────────────────────────
    private static function labelAction(string $action): string
    {
        return match($action) {
            'profil_complet'             => 'Profil complété',
            'paiement_complet_airtel'    => 'Loyer payé via Airtel Money',
            'paiement_complet_moov'      => 'Loyer payé via Moov Money',
            'paiement_complet_cash'      => 'Loyer payé en cash confirmé',
            'paiement_partiel'           => 'Paiement partiel confirmé',
            'paiement_avance'            => 'Paiement en avance',
            'retard_paiement'            => 'Retard de paiement',
            'non_paiement'               => 'Non-paiement constaté',
            'litige_ouvert'              => 'Litige ouvert',
            'litige_resolu_faveur'       => 'Litige résolu en votre faveur',
            'litige_perdu'               => 'Litige perdu',
            'avis_positif'               => 'Avis positif reçu',
            'avis_negatif'               => 'Avis négatif reçu',
            'contrat_ferme_solde'        => 'Contrat terminé et soldé',
            'photo_signalee'             => 'Photos signalées comme trompeuses',
            'annonce_verifiee'           => 'Annonce vérifiée par GaboPlex',
            default                      => $action,
        };
    }
}