@extends('layouts.app')

@section('title', 'Passaporte.io - Encontre seu próximo evento')

@section('content')
<div class="bg-hero-gradient rounded-box p-8 md:p-12 mb-8 text-white shadow-xl overflow-hidden relative">
    <div class="grid md:grid-cols-2 gap-6 items-center">
        <div class="relative z-10">
            <h1 class="text-3xl md:text-5xl font-bold mb-2">Encontre seu próximo evento</h1>
            <p class="text-white/90 max-w-2xl">
                Descubra eventos de tecnologia, música, negócios e muito mais. Inscreva-se e garanta seu passaporte digital.
            </p>
        </div>
        <div class="hidden md:block relative h-64">
            <div class="absolute inset-0 flex items-center justify-center">
                @include('partials.hero-illustration')
            </div>
        </div>
    </div>
</div>

<div class="flex flex-wrap items-center gap-2 mb-6">
    <a href="{{ route('home') }}"
       class="btn btn-sm rounded-full {{ !request('categoria') ? 'btn-primary' : 'btn-outline' }}">
        Todos
    </a>
    @foreach($categorias as $categoria)
        <a href="{{ route('home', ['categoria' => $categoria->id]) }}"
           class="btn btn-sm rounded-full {{ request('categoria') == $categoria->id ? 'btn-primary' : 'btn-outline' }}">
            {{ $categoria->name }}
        </a>
    @endforeach
</div>

@if($eventos->isEmpty())
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body items-center text-center py-16">
            <span class="text-5xl mb-2">🔍</span>
            <h2 class="text-xl font-semibold">Nenhum evento encontrado</h2>
            <p class="text-base-content/60 max-w-md">
                Não há eventos futuros cadastrados nesta categoria. Tente outra categoria ou volte mais tarde.
            </p>
        </div>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($eventos as $evento)
            @include('eventos._card', ['evento' => $evento])
        @endforeach
    </div>

    <div class="mt-8">
        {{ $eventos->links() }}
    </div>
@endif
@endsection