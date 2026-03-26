<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
{
    // ─── PAGE FAVORIS ─────────────────────────────────────────────────────────
    public function index()
    {
        $favoris = Favori::where('user_id', Auth::id())
            ->with(['annonce.photos', 'annonce.user'])
            ->orderByDesc('created_at')
            ->get()
            ->filter(fn($f) => $f->annonce !== null); // Exclure les annonces supprimées

        $alertes = \App\Models\Alerte::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('favoris.index', compact('favoris', 'alertes'));
    }

    // ─── AJOUTER AUX FAVORIS ─────────────────────────────────────────────────
    public function store(Annonce $annonce)
    {
        $existant = Favori::where('user_id', Auth::id())
            ->where('annonce_id', $annonce->id)
            ->first();

        if (!$existant) {
            Favori::create([
                'user_id'    => Auth::id(),
                'annonce_id' => $annonce->id,
            ]);
        }

        return back()->with('success', 'Annonce ajoutée à vos favoris.');
    }

    // ─── RETIRER DES FAVORIS ─────────────────────────────────────────────────
    public function destroy(Annonce $annonce)
    {
        Favori::where('user_id', Auth::id())
            ->where('annonce_id', $annonce->id)
            ->delete();

        return back()->with('success', 'Annonce retirée de vos favoris.');
    }

    // ─── TOGGLE (AJAX) ────────────────────────────────────────────────────────
    public function toggle(Annonce $annonce)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Non authentifié'], 401);
        }

        $existant = Favori::where('user_id', Auth::id())
            ->where('annonce_id', $annonce->id)
            ->first();

        if ($existant) {
            $existant->delete();
            return response()->json(['status' => 'removed']);
        }

        Favori::create([
            'user_id'    => Auth::id(),
            'annonce_id' => $annonce->id,
        ]);

        return response()->json(['status' => 'added']);
    }
}