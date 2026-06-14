@extends('layouts.app')

@section('title', 'Entrar - Passaporte.io')

@section('content')
<div class="hero min-h-[70vh]">
    <div class="hero-content flex-col w-full max-w-md">
        <div class="text-center mb-2">
            <div class="text-5xl mb-2">🎫</div>
            <h1 class="text-3xl font-bold">Bem-vindo de volta</h1>
            <p class="text-base-content/60 mt-1">Entre na sua conta Passaporte.io</p>
        </div>

        <div class="card w-full bg-base-100 shadow-xl">
            <div class="card-body">
                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    <div class="form-control">
                        <label class="label" for="email">
                            <span class="label-text font-medium">E-mail</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="input input-bordered w-full @error('email') input-error @enderror"
                               placeholder="seu@email.com" required autofocus>
                        @error('email')
                            <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label" for="password">
                            <span class="label-text font-medium">Senha</span>
                        </label>
                        <input type="password" name="password" id="password"
                               class="input input-bordered w-full @error('password') input-error @enderror"
                               placeholder="••••••••" required>
                        @error('password')
                            <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-full rounded-full mt-2">
                        Entrar
                    </button>
                </form>

                <div class="divider text-sm">ou</div>

                <p class="text-center text-sm">
                    Não tem uma conta?
                    <a href="{{ route('register') }}" class="link link-primary font-medium">Cadastre-se</a>
                </p>
            </div>
        </div>

    
    </div>
</div>
@endsection