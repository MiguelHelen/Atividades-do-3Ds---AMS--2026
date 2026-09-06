<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rota protegida pela middleware CheckAccessMiddleware
|--------------------------------------------------------------------------
| O apelido 'check.access' precisa estar registrado
| (veja instruções no README.md deste projeto).
*/

Route::get('/', [SiteController::class, 'index'])
    ->middleware('check.access');
