<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Delivery')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Original do Sistema -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/produto.css') }}">

    @stack('styles')
</head>
<body>
    <!-- Navbar Fixa no Topo -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-shop"></i> Delivery System
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="text-white text-decoration-none">
                    <i class="bi bi-house"></i> Início
                </a>
                <a href="{{ route('carrinho.index') }}" class="text-white text-decoration-none">
                    <i class="bi bi-cart3"></i> Carrinho
                </a>
                <a href="{{ route('cliente.login') }}" class="text-white text-decoration-none">
                    <i class="bi bi-person"></i> Entrar
                </a>
            </div>
        </div>
    </nav>

    <!-- Content Area -->
    <main style="padding-top: 60px; padding-bottom: 80px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Rodapé Fixo -->
    <footer style="position: fixed; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); padding: 20px 0; text-align: center; z-index: 5;">
        <div class="container">
            <a href="{{ route('home') }}" class="text-white text-decoration-none me-3">
                <i class="bi bi-house-fill"></i> Início
            </a>
            <a href="{{ route('carrinho.index') }}" class="text-white text-decoration-none">
                <i class="bi bi-cart-fill"></i> Carrinho
            </a>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
