@extends('layout')

@section('conteudo')

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card">

<div class="card-header">
<h4>Cadastro</h4>
</div>

<div class="card-body">

<form method="POST" action="/cadastro">

@csrf

<div class="mb-3">
<label>Nome</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Senha</label>
<input type="password" name="password" class="form-control" required>
</div>

<button class="btn btn-success w-100">
Cadastrar
</button>

</form>

</div>
</div>

</div>
</div>

@endsection