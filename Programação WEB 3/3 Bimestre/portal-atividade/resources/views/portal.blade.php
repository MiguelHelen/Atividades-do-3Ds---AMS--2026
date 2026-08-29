<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background: #f4f4f4;
        }
        .card {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 420px;
        }
        h1 {
            color: {{ $autorizado ? '#2e7d32' : '#c62828' }};
            font-size: 24px;
        }
        p {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>{{ $mensagem }}</h1>

        @if(!empty($submensagem))
            <p>{{ $submensagem }}</p>
        @endif

        @if($autorizado && isset($usuario))
            <p>Usuário: {{ $usuario->nome }} ({{ $usuario->email }})</p>
        @endif
    </div>
</body>
</html>
