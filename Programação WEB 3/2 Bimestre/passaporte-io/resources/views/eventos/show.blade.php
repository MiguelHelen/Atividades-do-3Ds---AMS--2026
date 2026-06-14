@extends('layouts.app')

@section('title', $evento->title . ' - Passaporte.io')

@section('content')
<div class="mb-4">
    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">← Voltar para eventos</a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="rounded-box overflow-hidden shadow-lg mb-6">
            <img src="{{ $evento->bannerUrl() }}" alt="{{ $evento->title }}" class="w-full h-64 md:h-96 object-cover">
        </div>

        <div class="flex items-center gap-2 mb-3">
            <span class="badge badge-soft badge-secondary">{{ $evento->category->name }}</span>
            @if($evento->isLotado())
                <span class="badge badge-error">Esgotado</span>
            @endif
        </div>

        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $evento->title }}</h1>

        <div class="prose max-w-none">
            <p class="text-base-content/80 leading-relaxed whitespace-pre-line">{{ $evento->description }}</p>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="card bg-base-100 shadow-xl sticky top-24">
            <div class="card-body">
                <h2 class="card-title">Informações do Evento</h2>

                <div class="space-y-3 mt-2">
                    <div class="flex items-start gap-3">
                        <span class="text-xl">📅</span>
                        <div>
                            <p class="text-xs text-base-content/50">Data e horário</p>
                            <p class="font-medium">{{ $evento->date_time->format('d/m/Y \à\s H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-xl">📍</span>
                        <div>
                            <p class="text-xs text-base-content/50">Localização</p>
                            <p class="font-medium">{{ $evento->location }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-xl">🏢</span>
                        <div>
                            <p class="text-xs text-base-content/50">Organizador</p>
                            <p class="font-medium">{{ $evento->organizador->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-xl">🎟️</span>
                        <div>
                            <p class="text-xs text-base-content/50">Vagas</p>
                            <p class="font-medium">
                                {{ $evento->vagasDisponiveis() }} de {{ $evento->capacity }} disponíveis
                            </p>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                {{-- RF08 / RN04 / RN05 / RN06 - Botão de inscrição com todas as regras --}}
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary w-full rounded-full">
                        Entrar para se inscrever
                    </a>
                @else
                    @if(auth()->user()->isOrganizador())
                        <div class="alert alert-info text-sm">
                            <span>Organizadores não podem se inscrever em eventos.</span>
                        </div>
                    @elseif($jaInscrito)
                        <div class="alert alert-success text-sm mb-3">
                            <span>✅ Você já está inscrito neste evento!</span>
                        </div>
                        <form method="POST" action="{{ route('inscricoes.destroy', $evento) }}"
                              onsubmit="return confirm('Tem certeza que deseja cancelar sua inscrição?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline btn-error w-full rounded-full">
                                Cancelar Inscrição
                            </button>
                        </form>
                        <a href="{{ route('inscricoes.index') }}" class="btn btn-ghost btn-sm w-full mt-2">
                            Ver minhas inscrições
                        </a>
                    @elseif($evento->isLotado())
                        <button class="btn btn-disabled w-full rounded-full" disabled>
                            Vagas Esgotadas
                        </button>
                    @else
                        <form method="POST" action="{{ route('inscricoes.store', $evento) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-full rounded-full">
                                Inscrever-se Agora
                            </button>
                        </form>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection