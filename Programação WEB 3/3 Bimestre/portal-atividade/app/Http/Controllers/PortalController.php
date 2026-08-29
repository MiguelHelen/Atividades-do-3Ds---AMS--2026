<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    
    public function index(Request $request)
    {
        return view('portal', [
            'mensagem'    => $request->attributes->get('mensagem'),
            'submensagem' => null,
            'autorizado'  => true,
            'usuario'     => $request->attributes->get('usuario'),
        ]);
    }
}
