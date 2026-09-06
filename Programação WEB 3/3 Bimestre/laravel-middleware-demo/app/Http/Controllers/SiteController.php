<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Página principal do site, protegida pela CheckAccessMiddleware.
     * Se a middleware bloquear, este método nem chega a ser executado.
     */
    public function index()
    {
        return view('site.index', [
            'titulo' => 'Área protegida acessada com sucesso!',
        ]);
    }
}
