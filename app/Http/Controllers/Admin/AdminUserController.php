<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('annonces')->latest();

        if ($request->search) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
        }

        $users = $query->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function bloquer(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Impossible de bloquer un administrateur.');
        }
        $user->update(['bloque' => !$user->bloque]);
        $msg = $user->bloque ? 'Utilisateur bloqué.' : 'Utilisateur débloqué.';
        return back()->with('success', $msg);
    }

    public function promouvoir(User $user)
    {
        $user->update(['is_admin' => !$user->is_admin]);
        $msg = $user->is_admin ? 'Utilisateur promu admin.' : 'Droits admin retirés.';
        return back()->with('success', $msg);
    }

    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Impossible de supprimer un administrateur.');
        }
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }
}