@extends('layouts.app')

@section('title', 'Editar Evento - Passaporte.io')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Editar Evento</h1>
        <p class="text-base-content/60 mt-1">Atualize as informações do seu evento</p>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.eventos.update', $evento) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                @include('admin.eventos._form')

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('admin.eventos.index') }}" class="btn btn-ghost">Cancelar</a>
                    <button type="submit" class="btn btn-primary rounded-full px-6">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection