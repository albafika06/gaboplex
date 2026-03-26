<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Support\Facades\Auth;

class QrCodeController extends Controller
{
    /**
     * Génère et télécharge la pancarte PDF avec QR code.
     *
     * Dépendances à installer :
     *   composer require barryvdh/laravel-dompdf
     *   composer require simplesoftwareio/simple-qrcode
     */
    public function telecharger(Annonce $annonce)
    {
        // Vérifier que c'est bien le propriétaire ou un admin
        if ($annonce->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        // L'annonce doit être active (validée)
        if ($annonce->statut !== 'active') {
            return back()->with('error', 'La pancarte n\'est disponible que pour les annonces actives et validées.');
        }

        // URL publique de l'annonce
        $url = route('annonces.show', $annonce->id);

        // Générer le QR code en SVG (ne nécessite ni GD ni Imagick)
        $qrCode = \QrCode::format('svg')
            ->size(280)
            ->errorCorrection('H')
            ->margin(1)
            ->generate($url);

        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCode);

        // Informations de l'annonce
        $typeLabel = match($annonce->type) {
            'location'      => 'Location',
            'vente_maison'  => 'Vente',
            'vente_terrain' => 'Terrain à vendre',
            'commerce'      => 'Local commercial',
            default         => ucfirst($annonce->type),
        };

        $prixFormate = number_format($annonce->prix, 0, ',', ' ');
        $suffixPrix  = $annonce->type === 'location' ? '/mois' : '';
        $whatsapp    = $annonce->whatsapp ?: ($annonce->user->whatsapp ?? null);

        // Couleur selon le type
        $couleur = match($annonce->type) {
            'location'      => '#1D9E75',
            'vente_maison',
            'vente_terrain' => '#185FA5',
            'commerce'      => '#534AB7',
            default         => '#042C53',
        };

        // Générer le PDF via DomPDF
        $pdf = \PDF::loadView('annonces.pancarte-pdf', compact(
            'annonce',
            'qrBase64',
            'typeLabel',
            'prixFormate',
            'suffixPrix',
            'whatsapp',
            'couleur',
            'url'
        ))->setPaper('A4', 'portrait');

        $nomFichier = 'pancarte-gaboplex-' . $annonce->id . '.pdf';

        return $pdf->download($nomFichier);
    }
}