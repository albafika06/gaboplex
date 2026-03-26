<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user     = Auth::user();
        $annonces = Annonce::where('user_id', $user->id)
                           ->with('photoPrincipale')
                           ->withCount('favoris')
                           ->latest()
                           ->get();
        return view('profile.show', compact('user', 'annonces'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:100',
            'whatsapp' => 'nullable|string|max:30',
            'bio'      => 'nullable|string|max:500',
            'avatar'   => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'whatsapp' => $request->whatsapp,
            'bio'      => $request->bio,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        \App\Models\User::where('id', $user->id)->update($data);

        return redirect()->route('profile.show')
                         ->with('success', 'Profil mis à jour avec succès !');
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        // Vérifier le mot de passe
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Mot de passe incorrect.']);
        }

        // Supprimer les photos des annonces
        foreach ($user->annonces as $annonce) {
            foreach ($annonce->photos as $photo) {
                Storage::disk('public')->delete($photo->url);
            }
        }

        // Supprimer l'avatar
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Déconnecter puis supprimer
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
                         ->with('success', 'Votre compte a été supprimé définitivement.');
    }
}