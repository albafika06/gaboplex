<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $annonces = Annonce::where('user_id', Auth::id())
                           ->with('photoPrincipale')
                           ->latest()
                           ->get();

        return view('dashboard', compact('annonces'));
    }
}