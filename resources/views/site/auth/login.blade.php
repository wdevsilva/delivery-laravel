@php
@session_start();
$baseUri = url('/');
$isMobile = preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $config->config_nome ?? 'Delivery' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/jquery.gritter/css/jquery.gritter.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/3.3.5/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery.select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('midias/logo/' . session('base_delivery') . '/' . $config->config_foto) }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/tema.php') }}?{{ $config->config_colors }}" type="text/css" />
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
</head>

<body>
    <div class="container" id="home-content">
        @include('site.components.menu')

        <form action="{{ url('/cliente-login-entrar') }}{{ $fromCarrinho ? '?carrinho=1' : '' }}" method="post" role="form" autocomplete="off">
            @csrf
            <div class="{{ !$isMobile ? 'col-md-offset-2 col-md-8' : '' }}" style="background-color: rgba(255, 255, 255, 0.5);">
                <div class="form-group">
                    <hr>
                    <label for="cliente_fone">Digite o número do seu celular</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
                        <input type="tel" name="cliente_fone" id="cliente_fone" class="form-control" data-mask="cell" placeholder="(99) 99999-9999" required>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">
                        <i class="fa fa-check-circle-o"></i>
                        CONTINUAR
                    </button>
                </div>
            </div>
        </form>
    </div>

    @include('site.components.footer')
    @include('site.carrinho.side-carrinho')
    @include('site.components.footer-core-js')

    <script type="text/javascript" src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('view/site/app-js/number.js') }}"></script>
    <script src="{{ asset('view/site/app-js/howler.js') }}"></script>
    <script type="text/javascript" src="{{ asset('view/site/app-js/carrinho.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendor/jquery.gritter/js/jquery.gritter.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendor/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <script type="text/javascript" src="{{ asset('view/site/app-js/cliente.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            @if(session('error'))
                $.gritter.add({
                    time: 2000,
                    position: 'center',
                    title: 'Erro',
                    text: '{{ session('error') }}',
                    class_name: 'danger'
                });
            @endif

            @if(session('success'))
                $.gritter.add({
                    title: 'Sucesso',
                    text: '{{ session('success') }}',
                    class_name: 'success'
                });
            @endif
        });
        rebind_reload();
    </script>

</body>
</html>
