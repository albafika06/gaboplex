<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Contrat;
use App\Models\PaiementContrat;
use App\Services\ScoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ContratController extends Controller
{
    // ─── LISTE DES CONTRATS DE L'UTILISATEUR ─────────────────────────────────
    public function index()
    {
        $user = Auth::user();

        // Contrats où l'utilisateur est locataire
        $contratsLocataire = Contrat::where('locataire_id', $user->id)
            ->with(['annonce.photos', 'proprietaire', 'paiements'])
            ->orderByDesc('created_at')
            ->get();

        // Contrats où l'utilisateur est propriétaire
        $contratsProprietaire = Contrat::where('proprietaire_id', $user->id)
            ->with(['annonce.photos', 'locataire', 'paiements'])
            ->orderByDesc('created_at')
            ->get();

        $scoreHistorique = \App\Models\ScoreHistorique::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $badge = ScoreService::badge($user->score);

        return view('contrats.index', compact(
            'contratsLocataire',
            'contratsProprietaire',
            'scoreHistorique',
            'badge'
        ));
    }

    // ─── DÉTAIL D'UN CONTRAT ──────────────────────────────────────────────────
    public function show(Contrat $contrat)
    {
        $this->authorizeContrat($contrat);
        $contrat->load(['annonce.photos', 'locataire', 'proprietaire', 'paiements']);

        $badge = ScoreService::badge(Auth::user()->score);
        $estLocataire = Auth::id() === $contrat->locataire_id;

        // Paiement du mois en cours (location) ou prochain impayé (vente)
        $paiementActuel = null;
        if ($contrat->type === 'location' && $contrat->statut === 'actif') {
            $periode = Contrat::periodeActuelle();
            $paiementActuel = $contrat->paiements()
                ->where('periode', $periode)
                ->first();
        }

        return view('contrats.show', compact(
            'contrat',
            'badge',
            'estLocataire',
            'paiementActuel'
        ));
    }

    // ─── PROPOSER UN CONTRAT (depuis la messagerie) ───────────────────────────
    public function proposer(Request $request, Annonce $annonce)
    {
        $request->validate([
            'type'             => 'required|in:location,vente',
            'montant_mensuel'  => 'required_if:type,location|nullable|integer|min:1',
            'montant_total'    => 'required_if:type,vente|nullable|integer|min:1',
            'caution'          => 'nullable|integer|min:0',
            'date_debut'       => 'required|date|after_or_equal:today',
        ]);

        // Vérifier que le proposant n'est pas le propriétaire
        if ($annonce->user_id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas créer un contrat sur votre propre annonce.');
        }

        // Vérifier qu'il n'y a pas déjà un contrat actif ou terminé (vente)
        $contratExistant = Contrat::where('annonce_id', $annonce->id)
            ->whereIn('statut', ['en_attente', 'actif'])
            ->first();

        if ($contratExistant) {
            return back()->with('error', 'Un contrat est déjà en cours pour cette annonce.');
        }

        // Pour une vente : si un contrat est déjà terminé, le bien est vendu
        if ($request->type === 'vente') {
            $venteTerminee = Contrat::where('annonce_id', $annonce->id)
                ->where('type', 'vente')
                ->where('statut', 'termine')
                ->exists();
            if ($venteTerminee) {
                return back()->with('error', 'Ce bien a déjà été vendu.');
            }
        }

        // Vérifier que l'annonce est active
        if (!in_array($annonce->statut, ['active', 'vendue']) || $annonce->statut === 'vendue') {
            return back()->with('error', "Cette annonce n'est plus disponible.");
        }

        $contrat = Contrat::create([
            'annonce_id'      => $annonce->id,
            'locataire_id'    => Auth::id(),
            'proprietaire_id' => $annonce->user_id,
            'type'            => $request->type,
            'montant_mensuel' => $request->montant_mensuel,
            'montant_total'   => $request->montant_total,
            'caution'         => $request->caution,
            'date_debut'      => $request->date_debut,
            'statut'          => 'en_attente',
            'solde_restant'   => $request->type === 'vente' ? $request->montant_total : 0,
            'confirme_locataire' => true, // le proposant confirme directement
        ]);

        // Notifier le propriétaire
        try {
            \Mail::send('emails.contrat-propose', compact('contrat'), function ($m) use ($contrat) {
                $m->to($contrat->proprietaire->email)
                  ->subject('Proposition de contrat sur votre annonce — GaboPlex');
            });
        } catch (\Exception $e) {}

        return redirect()->route('contrats.show', $contrat)
            ->with('success', 'Proposition envoyée ! En attente de confirmation du propriétaire.');
    }

    // ─── CONFIRMER L'ACCORD (propriétaire) ───────────────────────────────────
    public function confirmer(Contrat $contrat)
    {
        $this->authorizeContrat($contrat);

        if ($contrat->statut !== 'en_attente') {
            return back()->with('error', 'Ce contrat ne peut plus être confirmé.');
        }

        $update = [];

        if (Auth::id() === $contrat->locataire_id) {
            $update['confirme_locataire'] = true;
        } elseif (Auth::id() === $contrat->proprietaire_id) {
            $update['confirme_proprietaire'] = true;
        }

        $contrat->update($update);
        $contrat->refresh();

        // Si les deux ont confirmé → contrat actif
        if ($contrat->confirme_locataire && $contrat->confirme_proprietaire) {
            $contrat->update(['statut' => 'actif']);

            // Créer le premier paiement mensuel (location)
            if ($contrat->type === 'location') {
                $this->creerPaiementMensuel($contrat);
            }

            return redirect()->route('contrats.show', $contrat)
                ->with('success', 'Contrat activé ! Le suivi des paiements démarre maintenant.');
        }

        return back()->with('success', 'Confirmation enregistrée. En attente de l\'autre partie.');
    }

    // ─── DÉCLARER UN PAIEMENT (locataire) ────────────────────────────────────
    public function declarerPaiement(Request $request, Contrat $contrat)
    {
        $this->authorizeContrat($contrat);

        if (Auth::id() !== $contrat->locataire_id) {
            abort(403, 'Seul le locataire peut déclarer un paiement.');
        }

        $request->validate([
            'montant_paye' => 'required|integer|min:1',
            'mode'         => 'required|in:cash,airtel_money,moov_money',
            'periode'      => 'required|string',
            'preuve'       => 'nullable|image|max:2048',
        ]);

        // Trouver ou créer le paiement pour cette période
        $paiement = PaiementContrat::firstOrCreate(
            ['contrat_id' => $contrat->id, 'periode' => $request->periode],
            [
                'montant_du'       => $contrat->montant_mensuel ?? $contrat->montant_total,
                'montant_paye'     => 0,
                'montant_restant'  => $contrat->montant_mensuel ?? $contrat->montant_total,
                'mode'             => $request->mode,
                'statut'           => 'en_attente',
                'date_echeance'    => now()->endOfMonth(),
            ]
        );

        $montantDeja  = $paiement->montant_paye;
        $montantTotal = $paiement->montant_du + $montantDeja; // cumulé avec les partiels précédents
        $nouveauTotal = $montantDeja + $request->montant_paye;
        $restant      = max(0, $paiement->montant_du - $nouveauTotal);

        // Upload preuve si fournie
        $preuveUrl = null;
        if ($request->hasFile('preuve')) {
            $preuveUrl = $request->file('preuve')->store('preuves_paiement', 'public');
        }

        // Déterminer le statut
        $statut = 'partiel';
        if ($restant === 0) {
            $statut = $nouveauTotal > $paiement->montant_du ? 'avance' : 'complet';
        }

        $paiement->update([
            'montant_paye'        => $nouveauTotal,
            'montant_restant'     => $restant,
            'mode'                => $request->mode,
            'statut'              => $statut,
            'confirme_locataire'  => true,
            'date_paiement'       => now(),
            'preuve_url'          => $preuveUrl ?? $paiement->preuve_url,
        ]);

        // Si mobile money : confirmation automatique des deux côtés
        if (in_array($request->mode, ['airtel_money', 'moov_money']) && $restant === 0) {
            $paiement->update(['confirme_proprietaire' => true]);
            ScoreService::onPaiementConfirme($paiement, $contrat);

            // Mettre à jour le solde du contrat
            $this->mettreAJourSolde($contrat);

            return redirect()->route('contrats.show', $contrat)
                ->with('success', 'Paiement via ' . $paiement->mode_label . ' confirmé automatiquement. Score mis à jour !');
        }

        // Cash : notifier le propriétaire pour confirmation
        try {
            \Mail::send('emails.paiement-a-confirmer', compact('paiement', 'contrat'), function ($m) use ($contrat) {
                $m->to($contrat->proprietaire->email)
                  ->subject('Paiement de loyer à confirmer — GaboPlex');
            });
        } catch (\Exception $e) {}

        return redirect()->route('contrats.show', $contrat)
            ->with('success', 'Paiement déclaré. En attente de confirmation du propriétaire.');
    }

    // ─── CONFIRMER RÉCEPTION (propriétaire) ───────────────────────────────────
    public function confirmerReception(Request $request, PaiementContrat $paiement)
    {
        $contrat = $paiement->contrat;
        $this->authorizeContrat($contrat);

        if (Auth::id() !== $contrat->proprietaire_id) {
            abort(403);
        }

        $confirme = $request->boolean('confirme', true);

        if ($confirme) {
            $paiement->update(['confirme_proprietaire' => true]);
            ScoreService::onPaiementConfirme($paiement, $contrat);
            $this->mettreAJourSolde($contrat);

            return redirect()->route('contrats.show', $contrat)
                ->with('success', 'Réception confirmée. Score mis à jour pour les deux parties !');
        }

        // Propriétaire infirme → litige automatique
        $paiement->update(['litige' => true, 'motif_litige' => 'Propriétaire n\'a pas reçu le paiement déclaré']);
        $contrat->update(['statut' => 'litige']);
        ScoreService::onLitigeOuvert($contrat, Auth::user());

        return redirect()->route('contrats.show', $contrat)
            ->with('error', 'Litige ouvert. Un admin GaboPlex va intervenir.');
    }

    // ─── FERMER LE CONTRAT (les deux parties) ─────────────────────────────────
    public function fermer(Request $request, Contrat $contrat)
    {
        $this->authorizeContrat($contrat);

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'avis' => 'nullable|string|max:500',
        ]);

        $estLocataire = Auth::id() === $contrat->locataire_id;

        if ($estLocataire) {
            $contrat->update([
                'note_proprietaire' => $request->note,
                'avis_proprietaire' => $request->avis,
            ]);
            // L'avis du locataire va au propriétaire
            ScoreService::onAvisRecu($contrat->proprietaire, $request->note, $contrat);
        } else {
            $contrat->update([
                'note_locataire' => $request->note,
                'avis_locataire' => $request->avis,
            ]);
            // L'avis du propriétaire va au locataire
            ScoreService::onAvisRecu($contrat->locataire, $request->note, $contrat);
        }

        // Si les deux ont noté → fermer le contrat
        $contrat->refresh();
        if ($contrat->note_locataire && $contrat->note_proprietaire) {
            $contrat->update(['statut' => 'termine', 'date_fin' => now()]);
            ScoreService::onContratFerme($contrat);

            // L'annonce redevient disponible (location) ou passe en vendue (vente)
            if ($contrat->type === 'vente') {
                $contrat->annonce->update(['statut' => 'vendue']);
            } else {
                $contrat->annonce->update(['statut' => 'active']);
            }
        }

        return redirect()->route('contrats.show', $contrat)
            ->with('success', 'Avis enregistré. Merci !');
    }

    // ─── PRIVATE : créer le paiement mensuel automatiquement ─────────────────
    private function creerPaiementMensuel(Contrat $contrat): void
    {
        $periode = Contrat::periodeActuelle();

        PaiementContrat::firstOrCreate(
            ['contrat_id' => $contrat->id, 'periode' => $periode],
            [
                'montant_du'      => $contrat->montant_mensuel,
                'montant_paye'    => 0,
                'montant_restant' => $contrat->montant_mensuel,
                'mode'            => 'cash',
                'statut'          => 'en_attente',
                'date_echeance'   => Carbon::now()->endOfMonth(),
            ]
        );
    }

    // ─── PRIVATE : mettre à jour le solde du contrat ──────────────────────────
    private function mettreAJourSolde(Contrat $contrat): void
    {
        if ($contrat->type === 'location') {
            // Calculer la dette totale des mois impayés ou partiels
            $dette = PaiementContrat::where('contrat_id', $contrat->id)
                ->whereIn('statut', ['en_attente', 'partiel', 'retard'])
                ->sum('montant_restant');

            // Calculer le crédit d'avance
            $credit = PaiementContrat::where('contrat_id', $contrat->id)
                ->where('statut', 'avance')
                ->sum(\Illuminate\Support\Facades\DB::raw('montant_paye - montant_du'));

            $contrat->update([
                'solde_restant' => max(0, $dette),
                'credit_avance' => max(0, $credit),
            ]);

            // Créer le paiement du mois suivant si le mois actuel est soldé
            $periodeActuelle = Contrat::periodeActuelle();
            $paiementActuel  = PaiementContrat::where('contrat_id', $contrat->id)
                ->where('periode', $periodeActuelle)
                ->first();

            if ($paiementActuel && $paiementActuel->statut === 'complet') {
                $prochaineMois = Carbon::now()->addMonth()->format('Y-m');
                $this->creerPaiementMensuel($contrat);
            }
        } else {
            // Vente : recalculer le solde restant
            $totalPaye = PaiementContrat::where('contrat_id', $contrat->id)
                ->where('confirme_proprietaire', true)
                ->sum('montant_paye');

            $restant = max(0, ($contrat->montant_total ?? 0) - $totalPaye);
            $contrat->update(['solde_restant' => $restant]);

            // Si tout est payé → fermer automatiquement
            if ($restant === 0) {
                $contrat->update(['statut' => 'termine', 'date_fin' => now()]);
                ScoreService::onContratFerme($contrat);
                $contrat->annonce->update(['statut' => 'vendue']);
            }
        }
    }

    // ─── PRIVATE : vérifier que l'utilisateur fait partie du contrat ──────────
    private function authorizeContrat(Contrat $contrat): void
    {
        $user = Auth::user();
        if (
            $user->id !== $contrat->locataire_id &&
            $user->id !== $contrat->proprietaire_id &&
            !$user->is_admin
        ) {
            abort(403, 'Accès non autorisé à ce contrat.');
        }
    }
}