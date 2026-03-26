<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Alerte;
use Illuminate\Http\Request;

class AdminAnnonceController extends Controller
{
    public function index(Request $request)
    {
        $query = Annonce::with('user', 'photoPrincipale')->latest();

        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        $annonces = $query->paginate(15);

        return view('admin.annonces', compact('annonces'));
    }

    // ─── VALIDER ──────────────────────────────────────────────────────────────
    public function valider(Annonce $annonce)
    {
        $annonce->update([
            'statut'      => 'active',
            'motif_rejet' => null,
        ]);

        try {
            \Mail::send('emails.annonce-validee', ['annonce' => $annonce], function ($m) use ($annonce) {
                $m->to($annonce->user->email)
                  ->subject('Votre annonce a été validée — GaboPlex');
            });
        } catch (\Exception $e) {}

        $this->envoyerAlertes($annonce);

        return back()->with('success', 'Annonce validée et publiée !');
    }

    // ─── REJETER ──────────────────────────────────────────────────────────────
    public function rejeter(Request $request, Annonce $annonce)
    {
        $request->validate([
            'motif' => 'required|string|max:500',
        ]);

        $annonce->update([
            'statut'      => 'rejetee',
            'motif_rejet' => $request->motif,
        ]);

        try {
            \Mail::send('emails.annonce-rejetee', [
                'annonce' => $annonce,
                'motif'   => $request->motif,
            ], function ($m) use ($annonce) {
                $m->to($annonce->user->email)
                  ->subject('Votre annonce a été rejetée — GaboPlex');
            });
        } catch (\Exception $e) {}

        return back()->with('success', 'Annonce rejetée. Le propriétaire a été notifié.');
    }

    // ─── VÉRIFIER ────────────────────────────────────────────────────────────
    public function verifier(Annonce $annonce)
    {
        $annonce->update(['verifie' => !$annonce->verifie]);
        $msg = $annonce->verifie ? 'Annonce marquée comme vérifiée.' : 'Vérification retirée.';
        return back()->with('success', $msg);
    }

    // ─── SUPPRIMER ───────────────────────────────────────────────────────────
    public function destroy(Annonce $annonce)
    {
        foreach ($annonce->photos as $photo) {
            \Storage::disk('public')->delete($photo->url);
        }
        $annonce->delete();
        return back()->with('success', 'Annonce supprimée.');
    }

    // ─── SUPPRIMER EXPIRÉES ───────────────────────────────────────────────────
    public function supprimerExpirees()
    {
        $count = Annonce::where('statut', 'expiree')->count();
        foreach (Annonce::where('statut', 'expiree')->get() as $annonce) {
            foreach ($annonce->photos as $photo) {
                \Storage::disk('public')->delete($photo->url);
            }
            $annonce->delete();
        }
        return back()->with('success', $count . ' annonce(s) expirée(s) supprimée(s).');
    }

    // ─── PRIVATE : alertes email ──────────────────────────────────────────────
    private function envoyerAlertes(Annonce $annonce): void
    {
        $alertes = Alerte::with('user')
            ->where('type', $annonce->type)
            ->where(function ($q) use ($annonce) {
                $q->whereNull('ville')->orWhere('ville', $annonce->ville);
            })
            ->where(function ($q) use ($annonce) {
                $q->whereNull('prix_max')->orWhere('prix_max', '>=', $annonce->prix);
            })
            ->where(function ($q) use ($annonce) {
                $q->whereNull('nb_chambres');
                if (!is_null($annonce->nb_chambres)) {
                    $q->orWhere('nb_chambres', '<=', $annonce->nb_chambres);
                }
            })
            ->where('user_id', '!=', $annonce->user_id)
            ->get();

        foreach ($alertes as $alerte) {
            try {
                \Mail::send('emails.alerte-nouvelle-annonce', [
                    'alerte'  => $alerte,
                    'annonce' => $annonce,
                ], function ($m) use ($alerte) {
                    $m->to($alerte->user->email)
                      ->subject('Nouvelle annonce correspond à votre alerte — GaboPlex');
                });
            } catch (\Exception $e) {}
        }
    }
}