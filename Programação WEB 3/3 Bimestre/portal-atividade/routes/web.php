<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// Fluxo: requisição -> Middleware VerificaAcesso -> Controller (se autorizado) -> View
Route::get('/portal', [PortalController::class, 'index'])->middleware('verifica.acesso');
