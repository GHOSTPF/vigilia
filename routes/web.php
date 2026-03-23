<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Rotas do Google
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// Rota de Usuário Comum
// Rota Admin (Aponta para a pasta admin arquivo painel)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('admin.painel'); 
    })->name('dashboard.admin');
});

// Rota Usuário (Aponta para o arquivo dashboard na raiz das views)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/user', function () {
        return view('dashboard');
    })->name('dashboard.user');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
