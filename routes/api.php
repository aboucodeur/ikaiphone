<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\IphoneController;
use App\Http\Controllers\ModeleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Deportations des routes du web
Route::resource('client', ClientController::class);

Route::resource('modele', ModeleController::class);
Route::resource('iphone', IphoneController::class);
Route::resource('fournisseur', FournisseurController::class);

Route::get('/test', function () {
    return 'Bonjour le monde';
});
