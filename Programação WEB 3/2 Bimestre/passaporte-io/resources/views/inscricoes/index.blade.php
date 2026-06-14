@extends('layouts.app')

@section('title', 'Minhas Inscrições - Passaporte.io')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Minhas Inscrições</h1>
    <p class="text-base-content/60 mt-1">Seus ingressos e eventos confirmados</p>
</div>

@if($inscricoes->isEmpty())
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body items-center text-center py-16">
            <span class="text-5xl mb-2">🎟️</span>
            <h2 class="text-xl font-semibold">Você ainda não tem inscrições</h2>
            <p class="text-base-content/60 max-w-md">
                Explore a vitrine de eventos e garanta seu ingresso para os próximos acontecimentos.
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary rounded-full mt-2">
                Explorar eventos
            </a>
        </div>
    </div>
@else
    <div class="grid md:grid-cols-2 gap-4">
        @foreach($inscricoes as $evento)
            <div class="card bg-base-100 shadow-sm border border-base-300">
                <div class="card-body">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <span class="badge badge-soft badge-secondary mb-2">{{ $evento->category->name }}</span>
                            <h2 class="card-title">{{ $evento->title }}</h2>
                            <p class="text-sm text-base-content/60 mt-1">
                                📅 {{ $evento->date_time->format('d/m/Y \à\s H:i') }}
                            </p>
                            <p class="text-sm text-base-content/60">
                                📍 {{ $evento->location }}
                            </p>
                            <p class="text-sm text-base-content/60">
                                🏢 Organizado por {{ $evento->organizador->name }}
                            </p>
                        </div>
                        <a href="{{ route('eventos.show', $evento) }}" class="btn btn-sm btn-ghost">Ver</a>
                    </div>

                    <div class="divider my-2"></div>

                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <div>
                            <span class="text-xs text-base-content/50 block">Código do ingresso</span>
                            <span class="font-mono font-bold text-lg tracking-wider text-primary">
                                {{ $evento->pivot->ticket_code }}
                            </span>
                        </div>
                        <span class="badge badge-success badge-soft">{{ ucfirst($evento->pivot->status) }}</span>
                    </div>

                    <form method="POST" action="{{ route('inscricoes.destroy', $evento) }}"
                          onsubmit="return confirm('Tem certeza que deseja cancelar sua inscrição no evento &quot;{{ $evento->title }}&quot;? Seu ingresso será invalidado.');"
                          class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline btn-error w-full rounded-full">
                            Cancelar Inscrição
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $inscricoes->links() }}
    </div>
@endif
@endsection