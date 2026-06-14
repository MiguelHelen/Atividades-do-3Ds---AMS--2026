<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InscricaoController;
use Illuminate\Support\Facades\Route;

// ===== Vitrine Pública =====
Route::get('/', [EventoController::class, 'index'])->name('home');
Route::get('/eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');

// ===== Auth =====
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ===== Backoffice do Organizador =====
Route::middleware(['auth', 'organizador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('eventos', EventController::class)->except(['show']);
    });

// ===== Motor de Inscrições =====
Route::middleware(['auth', 'participante'])->group(function () {
    Route::get('/minhas-inscricoes', [InscricaoController::class, 'index'])->name('inscricoes.index');
    Route::post('/eventos/{evento}/inscrever', [InscricaoController::class, 'store'])->name('inscricoes.store');
    Route::delete('/eventos/{evento}/cancelar', [InscricaoController::class, 'destroy'])->name('inscricoes.destroy');
});