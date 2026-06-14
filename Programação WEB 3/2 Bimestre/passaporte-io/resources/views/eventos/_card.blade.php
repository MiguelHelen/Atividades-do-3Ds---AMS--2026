<a href="{{ route('eventos.show', $evento) }}" class="card bg-base-100 shadow-sm hover:shadow-xl transition-shadow border border-base-300 group overflow-hidden">
    <figure class="h-48 overflow-hidden relative">
    <img src="{{ $evento->bannerUrl() }}" alt="{{ $evento->title }}"
         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    <div class="absolute top-3 left-3 flex gap-2">
        <span class="badge badge-soft badge-secondary">{{ $evento->category->name }}</span>
        @if($evento->isNovo())
            <span class="badge bg-hero-gradient text-white border-none shadow-sm font-semibold animate-pulse">
                 Novidade
            </span>
        @endif
    </div>
    @if($evento->isLotado())
        <div class="absolute top-3 right-3">
            <span class="badge badge-error">Esgotado</span>
        </div>
    @endif
</figure>
    <div class="card-body">
        <h2 class="card-title text-lg line-clamp-2">{{ $evento->title }}</h2>
        <p class="text-sm text-base-content/60 line-clamp-2">{{ $evento->description }}</p>

        <div class="flex flex-col gap-1 mt-2 text-sm">
            <span class="flex items-center gap-2">
                📅 {{ $evento->date_time->format('d/m/Y \à\s H:i') }}
            </span>
            <span class="flex items-center gap-2">
                📍 {{ $evento->location }}
            </span>
            <span class="flex items-center gap-2">
                🏢 {{ $evento->organizador->name }}
            </span>
        </div>

        <div class="card-actions mt-3">
            <span class="badge {{ $evento->isLotado() ? 'badge-error' : 'badge-success' }} badge-soft">
                {{ $evento->vagasDisponiveis() }} vaga(s) disponível(eis)
            </span>
        </div>
    </div>
</a>