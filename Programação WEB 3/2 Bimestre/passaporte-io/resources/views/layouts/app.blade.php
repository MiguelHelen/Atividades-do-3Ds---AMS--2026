<!DOCTYPE html>
<html lang="pt-BR" data-theme="passaporte">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Passaporte.io')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 flex flex-col">

    @include('partials.navbar')

    <main class="flex-1">
        <div class="container mx-auto px-4 py-6 max-w-7xl">
            @include('partials.alerts')
            @yield('content')
        </div>
    </main>

    @include('partials.footer')

</body>
</html>