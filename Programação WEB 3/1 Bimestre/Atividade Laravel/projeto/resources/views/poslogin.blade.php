@extends('layout')

@section('conteudo')

<div class="card">

<div class="card-body text-center">

<h2>Bem vindo!</h2>

<hr>

<p><strong>Nome:</strong> {{ $user->name }}</p>

<p><strong>Email:</strong> {{ $user->email }}</p>

<a href="/" class="btn btn-secondary">
Voltar para Home
</a>

</div>

</div>

@endsection