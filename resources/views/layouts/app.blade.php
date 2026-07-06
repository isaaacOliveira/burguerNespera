
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurguerNêspera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3075/3075977.png">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="{{ route('home') }}"><i class="fa-solid fa-burger" style="color: rgb(255, 212, 59);"></i>  BurguerNêspera</a>
            <div class="navbar-nav ms-auto">
                @guest
                    <a class="nav-link btn btn-outline-warning text-white  px-3 me-2" href="{{ route('login') }}">Entrar</a>
                    <a class="nav-link btn btn-warning text-white px-3 fw-bold" href="{{ route('register') }}">Criar Conta</a>
                @else
                    @if(Auth::user()->role === 'admin')
                        <a class="nav-link text-warning fw-bold me-3" href="{{ route('admin.dashboard') }}">Painel Admin</a>
                    @endif
                    <span class="navbar-text text-white me-3">Olá, {{ Auth::user()->name }}</span>
                    <a class="nav-link text-danger" href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @endguest
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
