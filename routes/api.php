<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login',          [ApiController::class, 'login']);
Route::get('/annonces',        [ApiController::class, 'annonces']);
Route::get('/annonces/{id}',   [ApiController::class, 'annonce']);

Route::middleware('api.auth')->group(function () {
    Route::get('/favoris',                  [ApiController::class, 'favoris']);
    Route::post('/favoris/{annonce_id}',    [ApiController::class, 'ajouterFavori']);
    Route::delete('/favoris/{annonce_id}',  [ApiController::class, 'supprimerFavori']);
});
