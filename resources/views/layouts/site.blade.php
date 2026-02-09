<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <title>{{ $config->config_nome ?? 'Delivery System' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="application-name" content="{{ $config->config_nome ?? '' }}" />
    <meta name="description" content="{{ $config->config_site_description ?? '' }}" />
    <meta name="keywords" content="{{ $config->config_site_keywords ?? '' }}" />

    <!-- Open Graph / WhatsApp Preview -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $config->config_nome ?? '' }}" />
    <meta property="og:description" content="{{ $config->config_site_description ?? 'Cardápio Completo' }}" />
    <meta property="og:image"
        content="{{ asset('assets/logo/' . session('base_delivery') . '/' . $config->config_foto) }}" />
    <meta property="og:image:width" content="200" />
    <meta property="og:image:height" content="200" />
    <meta property="og:url" content="{{ url('/') }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{ $config->config_nome ?? '' }}" />
    <meta name="twitter:description" content="{{ $config->config_site_description ?? 'Cardápio Completo' }}" />
    <meta name="twitter:image"
        content="{{ asset('assets/logo/' . session('base_delivery') . '/' . $config->config_foto) }}" />

    <link rel="manifest" id="mainManifest"
        href="{{ url('/generate-manifest.php?token=' . ($config->config_token ?? '')) }}" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery.gritter/css/jquery.gritter.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/3.3.5/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery.select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/produto.css') }}?v={{ time() }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/modal-produto.css') }}?v={{ time() }}" />
    <link rel="icon" type="image/png"
        href="{{ asset('assets/logo/' . session('base_delivery') . '/' . $config->config_foto) }}" />
    <link rel="stylesheet" href="{{ url('/assets/css/tema.php?' . ($config->config_colors ?? '')) }}"
        type="text/css" />
    <link href="{{ asset('assets/css/main.css') }}?v={{ time() }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/fidelidade-badge.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}" />

    <!-- jQuery ANTES de tudo -->
    <script src="{{ asset('assets/vendor/jquery/jquery-2.1.4.min.js') }}"></script>

    <link href="{{ asset('assets/css/x0popup-master/dist/x0popup.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/css/x0popup-master/dist/x0popup.min.js') }}"></script>

    @stack('styles')
</head>

<body>
    <!-- Loading Screen -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-container">
            <img src="{{ asset('assets/logo/' . session('base_delivery') . '/' . $config->config_foto) }}"
                alt="Logo" class="loader-logo">
            <div class="loader-text">Carregando...</div>
            <div class="loader-spinner"></div>
        </div>
    </div>

    @include('site.components.menu')

    @yield('content')

    <!-- Footer -->
    @include('site.components.footer')

    <!-- Modal do Carrinho -->
    @include('site.carrinho.side-carrinho')

    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/howler.js') }}"></script>
    <script src="{{ asset('assets/js/modal-produto.js') }}"></script>
    <script src="{{ asset('assets/js/carrinho.js') }}"></script>

    <script>
        // Esconder loader quando página carregar
        window.addEventListener('load', function() {
            const loader = document.getElementById('pageLoader');
            setTimeout(function() {
                loader.classList.add('hidden');
            }, 500);
        });

        // Variáveis globais
        var baseUrl = '{{ url('/') }}';
        var baseUri = baseUrl; // Alias para compatibilidade com scripts legados
        var isMobile =
            {{ request()->header('User-Agent') && strpos(request()->header('User-Agent'), 'Mobile') !== false ? 'true' : 'false' }};

        // Configurar jQuery AJAX para enviar cookies de sessão
        $.ajaxSetup({
            xhrFields: {
                withCredentials: true
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>

    <!-- Botão Flutuante WhatsApp -->
    @if (!empty($config->config_fone1))
        <a href="https://api.whatsapp.com/send?phone=55{{ preg_replace('/\D/', '', $config->config_fone1) }}&text=Olá, vim do site e gostaria de mais informações!"
            class="whatsapp-float" target="_blank" title="Fale conosco no WhatsApp">
            <i class="fa fa-whatsapp"></i>
        </a>

        <style>
            /* Botão Flutuante WhatsApp */
            .whatsapp-float {
                position: fixed;
                bottom: 80px;
                right: 20px;
                width: 60px;
                height: 60px;
                background: #25D366;
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 32px;
                box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
                z-index: 1000;
                transition: all 0.3s ease;
                text-decoration: none;
                animation: pulse-whatsapp 2s infinite;
            }

            .whatsapp-float:hover {
                background: #20BA5A;
                transform: scale(1.1);
                box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
                color: white;
                text-decoration: none;
            }

            .whatsapp-float i {
                line-height: 60px;
            }

            /* Animação de pulso */
            @keyframes pulse-whatsapp {
                0% {
                    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
                }

                50% {
                    box-shadow: 0 4px 20px rgba(37, 211, 102, 0.7);
                }

                100% {
                    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
                }
            }

            /* Responsivo para mobile */
            @media (max-width: 768px) {
                .whatsapp-float {
                    bottom: 90px;
                    right: 15px;
                    width: 55px;
                    height: 55px;
                    font-size: 28px;
                }
            }
        </style>
    @endif

    @stack('scripts')
</body>

</html>
