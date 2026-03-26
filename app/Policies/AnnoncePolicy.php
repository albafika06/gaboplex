<?php

namespace App\Policies;

use App\Models\Annonce;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnoncePolicy
{
    use HandlesAuthorization;

    /**
     * Peut-on modifier cette annonce ?
     * → Propriétaire de l'annonce OU admin.
     */
    public function update(User $user, Annonce $annonce): bool
    {
        return $user->id === $annonce->user_id || $user->is_admin;
    }

    /**
     * Peut-on supprimer cette annonce ?
     * → Propriétaire de l'annonce OU admin.
     */
    public function delete(User $user, Annonce $annonce): bool
    {
        return $user->id === $annonce->user_id || $user->is_admin;
    }

    /**
     * Peut-on voir cette annonce en détail ?
     * → Toujours oui (les annonces actives sont publiques).
     * → Le propriétaire et l'admin voient aussi les annonces en attente.
     */
    public function view(?User $user, Annonce $annonce): bool
    {
        if ($annonce->statut === 'active') {
            return true;
        }

        // Annonces non actives : seulement propriétaire ou admin
        return $user && ($user->id === $annonce->user_id || $user->is_admin);
    }
}