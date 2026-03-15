<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Laravel App</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">

<a class="navbar-brand d-flex align-items-center" href="/">

<img src="/imagen/logo.png" width="60" class="me-2">

Meu Sistema

</a>

<div>
<a class="btn btn-outline-light me-2" href="/login">Login</a>
<a class="btn btn-success" href="/cadastro">Cadastro</a>
</div>

</div>
</nav>

<div class="container mt-5">

@yield('conteudo')

</div>

</body>
</html>