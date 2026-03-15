<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [AuthController::class, 'loginForm']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/cadastro', [AuthController::class, 'cadastroForm']);

Route::post('/cadastro', [AuthController::class, 'cadastrar']);