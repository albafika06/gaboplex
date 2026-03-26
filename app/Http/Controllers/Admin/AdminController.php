<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Contact;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Stats globales
        $stats = [
            'total_annonces'  => Annonce::count(),
            'en_attente'      => Annonce::where('statut', 'en_attente')->count(),
            'actives'         => Annonce::where('statut', 'active')->count(),
            'rejetees'        => Annonce::where('statut', 'rejetee')->count(),
            'expirees'        => Annonce::where('statut', 'expiree')->count(),
            'total_users'     => User::count(),
            'contacts_nonlus' => Contact::where('lu', false)->count(),
            'messages_nonlus' => Message::whereHas('annonce')->where('lu', false)->count(),
            'total_vues'      => Annonce::sum('vues'),
        ];

        // Annonces par mois (12 derniers mois)
        $annoncesParMois = Annonce::select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();

        // Utilisateurs par mois (12 derniers mois)
        $usersParMois = User::select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();

        // Répartition par type
        $repartitionType = Annonce::select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->get();

        // Répartition par ville
        $repartitionVille = Annonce::select('ville', DB::raw('COUNT(*) as total'))
            ->where('statut', 'active')
            ->groupBy('ville')
            ->orderByDesc('total')
            ->take(7)
            ->get();

        // Top 5 annonces les plus vues
        $topAnnonces = Annonce::with('user')
            ->where('statut', 'active')
            ->orderByDesc('vues')
            ->take(5)
            ->get();

        // Dernières annonces en attente
        $annoncesEnAttente = Annonce::with('user')
            ->where('statut', 'en_attente')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'annoncesParMois',
            'usersParMois',
            'repartitionType',
            'repartitionVille',
            'topAnnonces',
            'annoncesEnAttente'
        ));
    }
}