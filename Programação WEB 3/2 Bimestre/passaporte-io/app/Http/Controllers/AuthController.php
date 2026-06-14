<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * RF01 - Tela de registro
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * RF01 - Registro de novos usuários
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'], // RN08
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:participante,organizador'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'As senhas não coincidem.',
            'role.required' => 'Selecione um perfil de acesso.',
            'role.in' => 'Perfil de acesso inválido.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // RNF03
            'role' => $validated['role'],
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Conta criada com sucesso! Bem-vindo(a), ' . $user->name . '.');
    }

    /**
     * RF02 - Tela de login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * RF02 - Autenticação de identidade
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Credenciais inválidas. Verifique seu e-mail e senha.'])
                ->withInput($request->only('email')); // RNF11
        }

        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Login realizado com sucesso!');
    }

    /**
     * RF03 - Encerramento de sessão
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Você saiu da sua conta com segurança.');
    }
}