<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login',          [ApiController::class, 'login']);
Route::get('/annonces',        [ApiController::class, 'annonces']);
Route::get('/annonces/{id}',   [ApiController::class, 'annonce']);
