<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlerteController extends Controller
{
    // ─── CRÉER UNE ALERTE ────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'type'         => 'nullable|in:location,vente_maison,vente_terrain,commerce',
            'ville'        => 'nullable|string|max:100',
            'prix_max'     => 'nullable|integer|min:0',
            'nb_chambres'  => 'nullable|integer|min:1|max:10',
        ]);

        // Limiter à 5 alertes par utilisateur
        $nbAlertes = Alerte::where('user_id', Auth::id())->count();
        if ($nbAlertes >= 5) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Limite de 5 alertes atteinte.'], 422);
            }
            return back()->with('error', 'Vous avez atteint la limite de 5 alertes. Supprimez-en une pour en créer une nouvelle.');
        }

        // Éviter les doublons exacts
        $doublon = Alerte::where('user_id', Auth::id())
            ->where('type',        $request->type)
            ->where('ville',       $request->ville)
            ->where('prix_max',    $request->prix_max)
            ->where('nb_chambres', $request->nb_chambres)
            ->exists();

        if ($doublon) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Cette alerte existe déjà.'], 422);
            }
            return back()->with('error', 'Vous avez déjà une alerte identique.');
        }

        Alerte::create([
            'user_id'     => Auth::id(),
            'type'        => $request->type,
            'ville'       => $request->ville,
            'prix_max'    => $request->prix_max,
            'nb_chambres' => $request->nb_chambres,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'created']);
        }

        return back()->with('success', 'Alerte créée ! Vous serez notifié par email lors de nouvelles annonces correspondantes.');
    }

    // ─── SUPPRIMER UNE ALERTE ────────────────────────────────────────────────
    public function destroy(Alerte $alerte)
    {
        if ($alerte->user_id !== Auth::id()) {
            abort(403);
        }

        $alerte->delete();

        return back()->with('success', 'Alerte supprimée.');
    }
}