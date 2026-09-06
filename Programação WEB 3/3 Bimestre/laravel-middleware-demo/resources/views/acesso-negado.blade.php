<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Acesso Negado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .caixa {
            background: #fff;
            border-left: 6px solid #d9534f;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 480px;
        }
        h1 {
            color: #d9534f;
            margin-bottom: 10px;
        }
        p {
            color: #333;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="caixa">
        <h1>{{ $mensagem }}</h1>
        <p>{{ $submensagem }}</p>
    </div>
</body>
</html>
