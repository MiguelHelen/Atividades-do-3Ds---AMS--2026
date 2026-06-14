@extends('layouts.app')

@section('title', 'Criar Conta - Passaporte.io')

@section('content')
<div class="hero min-h-[70vh]">
    <div class="hero-content flex-col w-full max-w-md">
        <div class="text-center mb-2">
            <div class="text-5xl mb-2">🎫</div>
            <h1 class="text-3xl font-bold">Criar sua conta</h1>
            <p class="text-base-content/60 mt-1">Junte-se ao Passaporte.io</p>
        </div>

        <div class="card w-full bg-base-100 shadow-xl">
            <div class="card-body">
                <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf

                    <div class="form-control">
                        <label class="label" for="name">
                            <span class="label-text font-medium">Nome completo</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="input input-bordered w-full @error('name') input-error @enderror"
                               placeholder="Seu nome" required autofocus>
                        @error('name')
                            <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label" for="email">
                            <span class="label-text font-medium">E-mail</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="input input-bordered w-full @error('email') input-error @enderror"
                               placeholder="seu@email.com" required>
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

                    <div class="form-control">
                        <label class="label" for="password_confirmation">
                            <span class="label-text font-medium">Confirmar senha</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="input input-bordered w-full"
                               placeholder="••••••••" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Perfil de acesso</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="participante" class="hidden peer"
                                       {{ old('role', 'participante') === 'participante' ? 'checked' : '' }}>
                                <div class="card border-2 border-base-300 peer-checked:border-primary peer-checked:bg-primary/10 transition-all p-4 text-center">
                                    <span class="text-2xl block mb-1">🙋</span>
                                    <span class="font-medium text-sm">Participante</span>
                                    <p class="text-xs text-base-content/60 mt-1">Quero me inscrever em eventos</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="organizador" class="hidden peer"
                                       {{ old('role') === 'organizador' ? 'checked' : '' }}>
                                <div class="card border-2 border-base-300 peer-checked:border-primary peer-checked:bg-primary/10 transition-all p-4 text-center">
                                    <span class="text-2xl block mb-1">🏢</span>
                                    <span class="font-medium text-sm">Organizador</span>
                                    <p class="text-xs text-base-content/60 mt-1">Quero criar e gerenciar eventos</p>
                                </div>
                            </label>
                        </div>
                        @error('role')
                            <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-full rounded-full mt-2">
                        Criar conta
                    </button>
                </form>

                <div class="divider text-sm">ou</div>

                <p class="text-center text-sm">
                    Já tem uma conta?
                    <a href="{{ route('login') }}" class="link link-primary font-medium">Entrar</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection