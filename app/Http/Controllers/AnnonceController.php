<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AnnonceController extends Controller
{
    use AuthorizesRequests;

    // ─── HELPER : JSON pour la carte Leaflet ─────────────────────────────────
    private function buildCarteJson($query)
    {
        return $query->clone()
            ->with('photoPrincipale')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(fn($a) => [
                'id'       => $a->id,
                'titre'    => $a->titre,
                'prix'     => $a->prix,
                'type'     => $a->type,
                'ville'    => $a->ville,
                'quartier' => $a->quartier,
                'lat'      => $a->latitude,
                'lng'      => $a->longitude,
                'photo'    => $a->photoPrincipale ? asset('storage/'.$a->photoPrincipale->url) : null,
                'url'      => route('annonces.show', $a->id),
            ]);
    }

    // ─── LISTE / PAGE D'ACCUEIL ───────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Annonce::with('photos', 'photoPrincipale', 'user')
                        ->where('statut', 'active');

        if ($request->type)           $query->where('type', $request->type);
        if ($request->ville)          $query->where('ville', $request->ville);
        if ($request->prix_max)       $query->where('prix', '<=', $request->prix_max);
        if ($request->nb_chambres)    $query->where('nb_chambres', '>=', $request->nb_chambres);
        if ($request->meuble)         $query->where('meuble', true);
        if ($request->parking)        $query->where('parking', true);
        if ($request->prix_min)       $query->where('prix', '>=', $request->prix_min);
        if ($request->titre_foncier)  $query->where('titre_foncier', true);
        if ($request->etat_bien)      $query->where('etat_bien', $request->etat_bien);
        if ($request->sous_type)      $query->where('sous_type', $request->sous_type);
        if ($request->superficie_min) $query->where('superficie', '>=', $request->superficie_min);
        if ($request->prix_negotiable) $query->where('prix_negotiable', true);

        switch ($request->tri) {
            case 'prix_asc':  $query->orderBy('prix', 'asc'); break;
            case 'prix_desc': $query->orderBy('prix', 'desc'); break;
            case 'plus_vus':  $query->orderBy('vues', 'desc'); break;
            default:          $query->latest(); break;
        }

        $annonces          = $query->paginate(12);
        $annoncesCarteJson = $this->buildCarteJson($query);

        return view('annonces.index', compact('annonces', 'annoncesCarteJson'));
    }

    // ─── PAGE LOCATION ────────────────────────────────────────────────────────
    public function location(Request $request)
    {
        $query = Annonce::with('photos', 'photoPrincipale', 'user')
                        ->where('statut', 'active')
                        ->where('type', 'location');

        if ($request->ville)          $query->where('ville', $request->ville);
        if ($request->prix_max)       $query->where('prix', '<=', $request->prix_max);
        if ($request->nb_chambres)    $query->where('nb_chambres', '>=', $request->nb_chambres);
        if ($request->meuble)         $query->where('meuble', true);
        if ($request->parking)        $query->where('parking', true);
        if ($request->titre_foncier)  $query->where('titre_foncier', true);
        if ($request->etat_bien)      $query->where('etat_bien', $request->etat_bien);
        if ($request->sous_type)      $query->where('sous_type', $request->sous_type);
        if ($request->superficie_min) $query->where('superficie', '>=', $request->superficie_min);

        switch ($request->tri) {
            case 'prix_asc':  $query->orderBy('prix', 'asc'); break;
            case 'prix_desc': $query->orderBy('prix', 'desc'); break;
            case 'plus_vus':  $query->orderBy('vues', 'desc'); break;
            default:          $query->latest(); break;
        }

        $annonces          = $query->paginate(12);
        $annoncesCarteJson = $this->buildCarteJson($query);

        return view('annonces.location', [
            'annonces'          => $annonces,
            'annoncesCarteJson' => $annoncesCarteJson,
            'typeActif'         => 'location',
            'pageTitle'         => 'Location immobilière au Gabon — GaboPlex',
        ]);
    }

    // ─── PAGE VENTE ───────────────────────────────────────────────────────────
    public function vente(Request $request)
    {
        $query = Annonce::with('photos', 'photoPrincipale', 'user')
                        ->where('statut', 'active')
                        ->whereIn('type', ['vente_maison', 'vente_terrain']);

        if ($request->ville)           $query->where('ville', $request->ville);
        if ($request->prix_max)        $query->where('prix', '<=', $request->prix_max);
        if ($request->sous_type)       $query->where('sous_type', $request->sous_type);
        if ($request->titre_foncier)   $query->where('titre_foncier', true);
        if ($request->prix_negotiable) $query->where('prix_negotiable', true);
        if ($request->etat_bien)       $query->where('etat_bien', $request->etat_bien);
        if ($request->nb_chambres)     $query->where('nb_chambres', '>=', $request->nb_chambres);
        if ($request->parking)         $query->where('parking', true);
        if ($request->superficie_min)  $query->where('superficie', '>=', $request->superficie_min);

        switch ($request->tri) {
            case 'prix_asc':  $query->orderBy('prix', 'asc'); break;
            case 'prix_desc': $query->orderBy('prix', 'desc'); break;
            case 'plus_vus':  $query->orderBy('vues', 'desc'); break;
            default:          $query->latest(); break;
        }

        $annonces          = $query->paginate(12);
        $annoncesCarteJson = $this->buildCarteJson($query);

        return view('annonces.vente', [
            'annonces'          => $annonces,
            'annoncesCarteJson' => $annoncesCarteJson,
            'typeActif'         => 'vente_maison',
            'pageTitle'         => 'Vente immobilière au Gabon — GaboPlex',
        ]);
    }

    // ─── PAGE COMMERCES ───────────────────────────────────────────────────────
    public function commerces(Request $request)
    {
        $query = Annonce::with('photos', 'photoPrincipale', 'user')
                        ->where('statut', 'active')
                        ->where('type', 'commerce');

        if ($request->ville)          $query->where('ville', $request->ville);
        if ($request->prix_max)       $query->where('prix', '<=', $request->prix_max);
        if ($request->sous_type)      $query->where('sous_type', $request->sous_type);
        if ($request->parking)        $query->where('parking', true);
        if ($request->superficie_min) $query->where('superficie', '>=', $request->superficie_min);

        switch ($request->tri) {
            case 'prix_asc':  $query->orderBy('prix', 'asc'); break;
            case 'prix_desc': $query->orderBy('prix', 'desc'); break;
            case 'plus_vus':  $query->orderBy('vues', 'desc'); break;
            default:          $query->latest(); break;
        }

        $annonces          = $query->paginate(12);
        $annoncesCarteJson = $this->buildCarteJson($query);

        return view('annonces.commerces', [
            'annonces'          => $annonces,
            'annoncesCarteJson' => $annoncesCarteJson,
            'typeActif'         => 'commerce',
            'pageTitle'         => 'Locaux commerciaux au Gabon — GaboPlex',
        ]);
    }

    // ─── DÉTAIL ANNONCE ───────────────────────────────────────────────────────
    public function show(Annonce $annonce)
    {
        $sessionKey = 'vue_annonce_' . $annonce->id;
        if (!session()->has($sessionKey)) {
            $annonce->increment('vues');
            session()->put($sessionKey, true);
        }

        $annonce->load('photos', 'user');

        $estFavori = Auth::check()
            ? $annonce->estEnFavori(Auth::id())
            : false;

        return view('annonces.show', compact('annonce', 'estFavori'));
    }

    // ─── CRÉATION ────────────────────────────────────────────────────────────
    public function create()
    {
        $nbGratuites = Annonce::where('user_id', Auth::id())
            ->where('is_premium', false)
            ->whereNull('expire_at')
            ->whereIn('statut', ['active', 'en_attente'])
            ->count();

        // 2 annonces gratuites max, la 3ème est payante
        $aDejaGratuite = $nbGratuites >= 2;
        $nbAnnoncesGratuites = $nbGratuites;

        return view('annonces.create', compact('aDejaGratuite', 'nbAnnoncesGratuites'));
    }

    // ─── ENREGISTRER ─────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'            => 'required|string|max:255',
            'description'      => 'required|string',
            'type'             => 'required|in:location,vente_maison,vente_terrain,commerce',
            'sous_type'        => 'nullable|string|max:100',
            'prix'             => 'required|integer|min:0',
            'superficie'       => 'nullable|integer|min:0',
            'ville'            => 'required|string|max:100',
            'quartier'         => 'required|string|max:100',
            'whatsapp'         => 'nullable|string|max:30',
            'nom_affiche'      => 'nullable|string|max:100',
            'latitude'         => 'nullable|numeric',
            'longitude'        => 'nullable|numeric',
            'nb_chambres'      => 'nullable|integer|min:0|max:20',
            'nb_sdb'           => 'nullable|integer|min:0|max:10',
            'meuble'           => 'nullable|boolean',
            'parking'          => 'nullable|boolean',
            'caution'          => 'nullable|integer|min:0',
            'charges_incluses' => 'nullable|boolean',
            'disponible_le'    => 'nullable|date',
            'etat_bien'        => 'nullable|in:neuf,bon_etat,a_renover',
            'titre_foncier'    => 'nullable|boolean',
            'prix_negotiable'  => 'nullable|boolean',
            'photos'           => 'nullable|array|max:10',
            'photos.*'         => 'image|max:2048',
        ]);

        $offre   = $request->input('offre', 'gratuit');
        $modePay = $request->input('mode_paiement', 'airtel_money');

        if ($offre === 'gratuit') {
            $nbGratuites = Annonce::where('user_id', Auth::id())
                ->where('is_premium', false)
                ->whereNull('expire_at')
                ->whereIn('statut', ['active', 'en_attente'])
                ->count();

            if ($nbGratuites >= 2) {
                return back()->withErrors([
                    'offre' => 'Vous avez atteint la limite de 2 annonces gratuites. Choisissez une offre payante pour continuer.'
                ])->withInput();
            }
        }

        $validated['user_id']          = Auth::id();
        $validated['statut']           = 'en_attente';
        $validated['meuble']           = $request->boolean('meuble');
        $validated['parking']          = $request->boolean('parking');
        $validated['charges_incluses'] = $request->boolean('charges_incluses');
        $validated['titre_foncier']    = $request->boolean('titre_foncier');
        $validated['prix_negotiable']  = $request->boolean('prix_negotiable');

        $annonce = Annonce::create($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('annonces', 'public');
                $annonce->photos()->create(['url' => $path, 'ordre' => $index]);
            }
        }

        if ($offre !== 'gratuit') {
            $paymentUrl = PaiementController::initier($annonce, $offre, $modePay);

            if ($paymentUrl) {
                return redirect($paymentUrl);
            }

            $annonce->delete();
            return back()->with('error', 'Erreur lors de l\'initialisation du paiement. Veuillez réessayer.');
        }

        return redirect()->route('dashboard')
                         ->with('success', 'Annonce soumise ! Elle sera visible après validation.');
    }

    // ─── MODIFICATION ─────────────────────────────────────────────────────────
    public function edit(Annonce $annonce)
    {
        $this->authorize('update', $annonce);
        $annonce->load('photos');
        return view('annonces.edit', compact('annonce'));
    }

    // ─── METTRE À JOUR ────────────────────────────────────────────────────────
    public function update(Request $request, Annonce $annonce)
    {
        $this->authorize('update', $annonce);

        $validated = $request->validate([
            'titre'            => 'required|string|max:255',
            'description'      => 'required|string',
            'type'             => 'required|in:location,vente_maison,vente_terrain,commerce',
            'sous_type'        => 'nullable|string|max:100',
            'prix'             => 'required|integer|min:0',
            'superficie'       => 'nullable|integer|min:0',
            'ville'            => 'required|string|max:100',
            'quartier'         => 'required|string|max:100',
            'whatsapp'         => 'nullable|string|max:30',
            'nom_affiche'      => 'nullable|string|max:100',
            'latitude'         => 'nullable|numeric',
            'longitude'        => 'nullable|numeric',
            'nb_chambres'      => 'nullable|integer|min:0|max:20',
            'nb_sdb'           => 'nullable|integer|min:0|max:10',
            'meuble'           => 'nullable|boolean',
            'parking'          => 'nullable|boolean',
            'caution'          => 'nullable|integer|min:0',
            'charges_incluses' => 'nullable|boolean',
            'disponible_le'    => 'nullable|date',
            'etat_bien'        => 'nullable|in:neuf,bon_etat,a_renover',
            'titre_foncier'    => 'nullable|boolean',
            'prix_negotiable'  => 'nullable|boolean',
            'photos.*'         => 'nullable|image|max:2048',
        ]);

        $validated['meuble']           = $request->boolean('meuble');
        $validated['parking']          = $request->boolean('parking');
        $validated['charges_incluses'] = $request->boolean('charges_incluses');
        $validated['titre_foncier']    = $request->boolean('titre_foncier');
        $validated['prix_negotiable']  = $request->boolean('prix_negotiable');

        $annonce->update($validated);

        if ($request->supprimer_photos) {
            foreach ($request->supprimer_photos as $photoId) {
                $photo = $annonce->photos()->find($photoId);
                if ($photo) {
                    Storage::disk('public')->delete($photo->url);
                    $photo->delete();
                }
            }
        }

        if ($request->hasFile('photos')) {
            $ordre = $annonce->photos()->count();
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('annonces', 'public');
                $annonce->photos()->create(['url' => $path, 'ordre' => $ordre++]);
            }
        }

        return redirect()->route('dashboard')
                         ->with('success', 'Annonce mise à jour avec succès !');
    }

    // ─── SUPPRIMER ────────────────────────────────────────────────────────────
    public function destroy(Annonce $annonce)
    {
        $this->authorize('delete', $annonce);

        foreach ($annonce->photos as $photo) {
            Storage::disk('public')->delete($photo->url);
        }

        $annonce->delete();

        return redirect()->route('dashboard')->with('success', 'Annonce supprimée.');
    }
}