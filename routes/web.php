<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\AlerteController;
use Illuminate\Support\Facades\Route;

// ─── PAGE D'ACCUEIL ───────────────────────────────────────────────────────────
Route::get('/', [AnnonceController::class, 'index'])->name('home');

// ─── PAGES PUBLIQUES ──────────────────────────────────────────────────────────
Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
Route::get('/location', [AnnonceController::class, 'location'])->name('annonces.location');
Route::get('/vente', [AnnonceController::class, 'vente'])->name('annonces.vente');
Route::get('/commerces', [AnnonceController::class, 'commerces'])->name('annonces.commerces');

// Message public (sans connexion)
Route::post('/annonces/{annonce}/messages', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store')->middleware('auth');

// Page à propos
Route::get('/a-propos', function () {
    $stats = [
        'annonces' => \App\Models\Annonce::where('statut', 'active')->count(),
        'users'    => \App\Models\User::count(),
        'villes'   => 7,
    ];
    return view('apropos', compact('stats'));
})->name('apropos');

// Contact
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::post('/contact/bloque', [App\Http\Controllers\ContactController::class, 'bloque'])->name('contact.bloque');

// ─── WEBHOOK CINETPAY — sans auth (appelé par les serveurs CinetPay) ──────────
Route::post('/paiement/webhook', [App\Http\Controllers\PaiementController::class, 'webhook'])
    ->name('paiement.webhook');

// ─── PAGES PROTÉGÉES ─────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Annonces — create AVANT {annonce}
    Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
    Route::post('/annonces', [AnnonceController::class, 'store'])->name('annonces.store');
    Route::get('/annonces/{annonce}/edit', [AnnonceController::class, 'edit'])->name('annonces.edit');
    Route::put('/annonces/{annonce}', [AnnonceController::class, 'update'])->name('annonces.update');
    Route::delete('/annonces/{annonce}', [AnnonceController::class, 'destroy'])->name('annonces.destroy');

    // Paiement retour (après redirection CinetPay)
    Route::patch('/messages/{message}/marquer', [App\Http\Controllers\MessageController::class, 'marquer'])
        ->name('messages.marquer');
    Route::get('/paiement/retour', [App\Http\Controllers\PaiementController::class, 'retour'])
        ->name('paiement.retour');
    Route::get('/annonces/{annonce}/booster', [App\Http\Controllers\PaiementController::class, 'boosterForm'])
        ->name('annonces.booster');
    Route::post('/annonces/{annonce}/booster', [App\Http\Controllers\PaiementController::class, 'boosterPay'])
        ->name('annonces.booster.pay');

    // Favoris
    Route::get('/favoris', [FavoriController::class, 'index'])->name('favoris.index');
    Route::post('/favoris/{annonce}', [FavoriController::class, 'store'])->name('favoris.store');
    Route::delete('/favoris/{annonce}', [FavoriController::class, 'destroy'])->name('favoris.destroy');
    Route::post('/favoris/{annonce}/toggle', [FavoriController::class, 'toggle'])->name('favoris.toggle');

    // Alertes
    Route::post('/alertes', [AlerteController::class, 'store'])->name('alertes.store');
    Route::delete('/alertes/{alerte}', [AlerteController::class, 'destroy'])->name('alertes.destroy');

    // QR Code pancarte
    Route::get('/annonces/{annonce}/pancarte', [App\Http\Controllers\QrCodeController::class, 'telecharger'])->name('annonces.pancarte');

    // Contrats & score
    Route::get('/contrats', [App\Http\Controllers\ContratController::class, 'index'])->name('contrats.index');
    Route::get('/contrats/{contrat}', [App\Http\Controllers\ContratController::class, 'show'])->name('contrats.show');
    Route::post('/annonces/{annonce}/contrat', [App\Http\Controllers\ContratController::class, 'proposer'])->name('contrats.proposer');
    Route::get('/annonces/{annonce}/contrat', fn() => redirect()->route('contrats.index'));
    Route::patch('/contrats/{contrat}/confirmer', [App\Http\Controllers\ContratController::class, 'confirmer'])->name('contrats.confirmer');
    Route::post('/contrats/{contrat}/paiement', [App\Http\Controllers\ContratController::class, 'declarerPaiement'])->name('contrats.paiement');
    Route::patch('/paiements/{paiement}/confirmer', [App\Http\Controllers\ContratController::class, 'confirmerReception'])->name('paiements.confirmer');
    Route::post('/contrats/{contrat}/fermer', [App\Http\Controllers\ContratController::class, 'fermer'])->name('contrats.fermer');

    // Messages — messagerie interne
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{annonce}/{interlocuteur}', [App\Http\Controllers\MessageController::class, 'conversation'])->name('messages.conversation');
    Route::post('/messages/{annonce}/{interlocuteur}/repondre', [App\Http\Controllers\MessageController::class, 'repondre'])->name('messages.repondre');
    Route::patch('/messages/{message}/marquer', [App\Http\Controllers\MessageController::class, 'marquer'])->name('messages.marquer');
    Route::put('/messages/{message}/lu', [App\Http\Controllers\MessageController::class, 'marquerLu'])->name('messages.lu');

    // Profil
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update']);
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // ─── ADMIN ───────────────────────────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->middleware(['is_admin'])->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');

        Route::get('/annonces', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'index'])->name('annonces');
        Route::post('/annonces/{annonce}/valider', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'valider'])->name('annonces.valider');
        Route::post('/annonces/{annonce}/rejeter', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'rejeter'])->name('annonces.rejeter');
        Route::delete('/annonces/{annonce}', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'destroy'])->name('annonces.destroy');
        Route::post('/annonces/{annonce}/verifier', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'verifier'])->name('annonces.verifier');
        Route::get('/annonces/{annonce}/verifier', fn() => redirect()->route('admin.dashboard'))->name('annonces.verifier.get');
        Route::get('/annonces/{annonce}/valider', fn() => redirect()->route('admin.dashboard'));
        Route::get('/annonces/{annonce}/rejeter', fn() => redirect()->route('admin.dashboard'));
        Route::delete('/annonces/expirees/supprimer', [App\Http\Controllers\Admin\AdminAnnonceController::class, 'supprimerExpirees'])->name('annonces.expirees');

        // Vérification annonce

        Route::get('/users', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users');
        Route::put('/users/{user}/bloquer', [App\Http\Controllers\Admin\AdminUserController::class, 'bloquer'])->name('users.bloquer');
        Route::put('/users/{user}/promouvoir', [App\Http\Controllers\Admin\AdminUserController::class, 'promouvoir'])->name('users.promouvoir');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('/contacts', [App\Http\Controllers\Admin\AdminContactController::class, 'index'])->name('contacts');
        Route::put('/contacts/{contact}/lu', [App\Http\Controllers\Admin\AdminContactController::class, 'marquerLu'])->name('contacts.lu');
    });
});

// ─── SHOW PUBLIC — après le groupe auth ──────────────────────────────────────
Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])->name('annonces.show');

require __DIR__.'/auth.php';