<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function loginForm()
    {
        return view('login');
    }

    public function cadastroForm()
    {
        return view('cadastro');
    }

    public function cadastrar(Request $request)
    {

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return redirect('/login');
    }

    public function login(Request $request)
    {

        $user = DB::table('users')
            ->where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        if ($user) {
            return view('poslogin', ['user' => $user]);
        }

        return redirect('/login')->with('erro','Login inválido');
    }

}