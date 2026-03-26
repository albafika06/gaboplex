<?php

namespace App\Services;

use App\Models\Alerte;
use App\Models\Annonce;
use Illuminate\Support\Facades\Mail;

class AlerteService
{
    /**
     * Appelé après la validation d'une annonce (dans AdminAnnonceController@valider).
     * Parcourt toutes les alertes actives et envoie un email aux utilisateurs concernés.
     */
    public static function notifier(Annonce $annonce): void
    {
        // Uniquement pour les annonces qui viennent d'être activées
        if ($annonce->statut !== 'active') return;

        $alertes = Alerte::with('user')->get();

        foreach ($alertes as $alerte) {
            // Pas de notification au propriétaire lui-même
            if ($alerte->user_id === $annonce->user_id) continue;

            // Vérifier si l'annonce correspond aux critères de l'alerte
            if (!$alerte->correspondA($annonce)) continue;

            // Envoyer l'email
            try {
                Mail::send(
                    'emails.alerte-nouvelle-annonce',
                    ['alerte' => $alerte, 'annonce' => $annonce],
                    function ($m) use ($alerte) {
                        $m->to($alerte->user->email, $alerte->user->name)
                          ->subject('GaboPlex — Nouvelle annonce correspondant à votre alerte');
                    }
                );
            } catch (\Exception $e) {
                // Ne pas bloquer si l'email échoue
                \Log::warning('AlerteService: email échec pour alerte #' . $alerte->id . ' — ' . $e->getMessage());
            }
        }
    }
}