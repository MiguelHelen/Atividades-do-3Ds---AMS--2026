<div class="navbar bg-base-100 shadow-sm sticky top-0 z-50 px-4 lg:px-8">
    <div class="navbar-start">
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold">
            <span class="text-2xl">🎫</span>
            <span class="text-hero-gradient font-extrabold">Passaporte.io</span>
        </a>
    </div>

    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 gap-1">
            <li><a href="{{ route('home') }}" class="font-medium">Eventos</a></li>
            @auth
                @if(auth()->user()->role === 'organizador')
                    <li><a href="{{ route('admin.eventos.index') }}" class="font-medium">Meu Painel</a></li>
                @elseif(auth()->user()->role === 'participante')
                    <li><a href="{{ route('inscricoes.index') }}" class="font-medium">Minhas Inscrições</a></li>
                @endif
            @endauth
        </ul>
    </div>

    <div class="navbar-end gap-2">
        @guest
            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Entrar</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-full px-5">Cadastrar</a>
        @else
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-sm gap-2">
                    <div class="avatar avatar-placeholder">
                        <div class="bg-primary text-primary-content rounded-full w-8">
                            <span class="text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                </div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-50 w-52 p-2 shadow-lg mt-3 border border-base-300">
                    <li class="menu-title text-xs">
                        {{ auth()->user()->role === 'organizador' ? 'Organizador' : 'Participante' }}
                    </li>
                    <li class="lg:hidden">
                        <a href="{{ route('home') }}">Eventos</a>
                    </li>
                    @if(auth()->user()->role === 'organizador')
                        <li class="lg:hidden"><a href="{{ route('admin.eventos.index') }}">Meu Painel</a></li>
                        <li><a href="{{ route('admin.eventos.create') }}">+ Novo Evento</a></li>
                    @else
                        <li class="lg:hidden"><a href="{{ route('inscricoes.index') }}">Minhas Inscrições</a></li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-error w-full text-left">Sair</button>
                        </form>
                    </li>
                </ul>
            </div>
        @endguest
    </div>
</div>