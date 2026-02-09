@php
@session_start();
$baseUri = url("/");
$isMobile = preg_match("/Mobile|Android|iPhone|iPad/", request()->header("User-Agent"));
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Cadastro - {{ $config->config_nome ?? "" }}</title>
<head>
    <meta charset="utf-8">
    <title>Cadastro - {{ $config->config_nome ?? '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/3.3.5/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery.select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('midias/logo/' . session('base_delivery') . '/' . ($config->config_foto ?? 'logo.png')) }}" />
    <link rel="stylesheet" href="{{ asset('view/site/app-css/card.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/tema.php') }}?{{ $config->config_colors ?? '' }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="container" id="home-content">
    @include('site.components.menu')
    <div class="container-fluid" id="home-content">
        <form action="{{ url('/cadastro/gravar') }}" method="post" role="form" style="padding-top: 50px" id="form-cadastro" autocomplete="off">
            @csrf
            <div class="{{ !$isMobile ? 'col-md-offset-2 col-md-8' : '' }}">
                <h4 class="text-uppercase">Dados do cliente</h4>
                <hr>
                <div class="form-group">
                    <label for="cliente_nome">Nome</label>
                    <small class="text-muted pull-right">* obrigatório</small>
                    <input type="text" name="cliente_nome" id="cliente_nome" class="form-control" placeholder="Informe seu nome" required>
                </div>
                <div class="form-group">
                    <label for="cliente_fone2">Celular</label>
                    <small class="text-muted pull-right">* obrigatório</small>
                    <span class="pull-right text-danger" id="exists"></span>
                    <input type="tel" data-mask="cell" placeholder="(99) 99999-9999" name="cliente_fone2" id="cliente_fone2" class="form-control" value="{{ $fone }}" required>
                </div>
                <div class="form-group">
                    <br>
                    <button class="btn btn-success btn-block" type="submit" id="btn-cad">
                        <i class="fa fa-check-circle-o"></i>
                        CONTINUAR
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
@include('site.carrinho.side-carrinho')
@include('site.components.footer-core-js')
<script type="text/javascript" src="{{ asset('') }}/view/site/app-js/number.js"></script>
<script type="text/javascript" src="{{ asset('') }}/view/site/app-js/carrinho.js"></script>
<script type="text/javascript" src="{{ asset('') }}/assets/vendor/jquery.select2/dist/js/select2.js"></script>
<script type="text/javascript" src="{{ asset('') }}/assets/vendor/jquery.maskedinput/jquery.maskedinput.js"></script>
<script type="text/javascript" src="{{ asset('') }}/assets/vendor/jquery.gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="{{ asset('') }}/view/site/app-js/cliente.js"></script>
<script type="text/javascript" src="{{ asset('') }}/view/site/app-js/carrinho.js"></script>
<script>
    rebind_reload();
</script>
<script>
    $('#cliente_nome').focus();
    $('#cliente_fone2').on('change', function() {
        var url = baseUri + '/cadastro/exists/';
        var fone = $('#cliente_fone2').val();
        $.post(url, {
            fone: fone
        }, function(req) {
            if (req == 1) {
                $('#cliente_fone2').focus();
                $('#exists').text('Telefone já cadastrado!');
                $('#btn-cad').attr('disabled', 'disabled');
            } else {
                $('#exists').text('');
                $('#btn-cad').removeAttr('disabled');
            }
        })
    })
</script>

</html>
