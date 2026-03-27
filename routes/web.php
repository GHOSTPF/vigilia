<?php
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return redirect('login');
});


// Rotas do Google
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// Rota de Usuário Comum
// Rota Admin (Aponta para a pasta admin arquivo painel)
// Altere esta parte no seu web.php
Route::middleware(['auth', 'admin'])->group(function () {
    // Mudamos o nome para 'admin.painel' ou o que você preferir, 
    // mas vamos usar o que está no formulário para facilitar
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->name('seu-dashboard.index'); 
});

// Rota Usuário (Aponta para o arquivo dashboard na raiz das views)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');
    Route::post('/cadastro/salvar', [UserController::class, 'salvarCadastro'])->name('cadastro.salvar');

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
