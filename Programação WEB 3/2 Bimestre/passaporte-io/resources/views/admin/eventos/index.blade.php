@extends('layouts.app')

@section('title', 'Meu Painel - Passaporte.io')

@section('content')
<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <h1 class="text-3xl font-bold">Meu Painel</h1>
        <p class="text-base-content/60 mt-1">Gerencie os eventos que você criou</p>
    </div>
    <a href="{{ route('admin.eventos.create') }}" class="btn btn-primary rounded-full px-6">
        + Novo Evento
    </a>
</div>

@if($eventos->isEmpty())
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body items-center text-center py-16">
            <span class="text-5xl mb-2">📭</span>
            <h2 class="text-xl font-semibold">Nenhum evento criado ainda</h2>
            <p class="text-base-content/60 max-w-md">
                Comece criando seu primeiro evento para que ele apareça na vitrine pública.
            </p>
            <a href="{{ route('admin.eventos.create') }}" class="btn btn-primary rounded-full mt-2">
                Criar meu primeiro evento
            </a>
        </div>
    </div>
@else
    <div class="overflow-x-auto bg-base-100 rounded-box shadow-sm">
        <table class="table">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Categoria</th>
                    <th>Data</th>
                    <th>Vagas</th>
                    <th>Inscritos</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eventos as $evento)
                    <tr class="hover">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="w-12 h-12 rounded-lg">
                                        <img src="{{ $evento->bannerUrl() }}" alt="{{ $evento->title }}">
                                    </div>
                                </div>
                                <div class="font-medium">{{ $evento->title }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-soft badge-secondary">{{ $evento->category->name }}</span>
                        </td>
                        <td class="text-sm">{{ $evento->date_time->format('d/m/Y H:i') }}</td>
                        <td class="text-sm">{{ $evento->capacity }}</td>
                        <td>
                            <span class="badge {{ $evento->participantes_count >= $evento->capacity ? 'badge-error' : 'badge-success' }} badge-soft">
                                {{ $evento->participantes_count }} / {{ $evento->capacity }}
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.eventos.edit', $evento) }}" class="btn btn-sm btn-ghost">Editar</a>
                                <form method="POST" action="{{ route('admin.eventos.destroy', $evento) }}"
                                      onsubmit="return confirm('Tem certeza que deseja excluir o evento &quot;{{ $evento->title }}&quot;? Essa ação não pode ser desfeita.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost text-error">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $eventos->links() }}
    </div>
@endif
@endsection