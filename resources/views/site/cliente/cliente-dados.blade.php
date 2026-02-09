@extends('layouts.site')

@section('content')
<div class="container" id="home-content">
    <br>
    <div class="content <?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
        <form action="{{ url('/dados/salvar') }}" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <br>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(request()->get('error') == 'cpf-email')
                <div class="alert alert-danger">
                    CPF ou E-mail já está sendo utilizado por outro cliente.
                </div>
            @endif

            @if(request()->get('error') == 'email-pix')
                <div class="alert alert-danger">
                    Para pagamentos via PIX, é obrigatório informar o e-mail
                </div>
            @endif

            <h5 class="text-uppercase">Dados Pessoais
                <span class="pull-right">
                    <a class="btn btn-primary btn-sm text-uppercase" href="{{ url('/meus-enderecos') }}">
                        <i class="fa fa-map-marker"></i>
                        Ver meus endereços
                    </a>
                </span>
            </h5>

            <div class="form-group">
                <label for="cliente_nome" class="text-muted">Nome</label>
                <input type="hidden" name="cliente_id" value="<?= $cliente->cliente_id ?>" />
                <input type="text" name="cliente_nome" id="cliente_nome" class="form-control" value="<?= $cliente->cliente_nome ?>" placeholder="Informe seu nome completo" required>
            </div>

            <div class="form-group">
                <label for="cliente_nasc" class="text-muted">Data de Nascimento</label>
                <input disabled type="text" data-mask="date" name="cliente_nasc" id="cliente_nasc" value="<?= $cliente->cliente_nasc ?>" class="form-control" placeholder="Informe sua data de nascimento">
            </div>

            <div class="form-group">
                <label for="cliente_cpf" class="text-muted">CPF</label>
                <input type="text" data-mask="cpf" name="cliente_cpf" id="cliente_cpf" value="<?= $cliente->cliente_cpf ?>" class="form-control" placeholder="Informe o número do documento">
            </div>

            <div class="form-group">
                <label for="cliente_email" class="text-muted">E-mail</label>
                <input type="email" name="cliente_email" id="cliente_email" value="<?= $cliente->cliente_email ?>" class="form-control" placeholder="Informe o e-mail">
            </div>

            <h5 class="text-uppercase" style="margin-top: 25px">Dados de Contato</h5>

            <div class="form-group">
                <label for="cliente_fone2" class="text-muted">Celular</label>
                <input disabled type="tel" data-mask="cell" placeholder="(99) 99999-9999" name="cliente_fone2" id="cliente_fone2" value="<?= $cliente->cliente_fone2 ?>" required class="form-control">
            </div>
            <br />

            <div class="form-group">
                <label for="cliente_marketing_whatssapp" class="text-muted">Receber mensagens de marketing no Whatsapp?</label>
                <select name="cliente_marketing_whatssapp" class="form-control">
                    <option value="1" <?= ($cliente->cliente_marketing_whatssapp == 1) ?  'selected' : '' ?>>Sim</option>
                    <option value="0" <?= ($cliente->cliente_marketing_whatssapp == 0) ?  'selected' : '' ?>>Não</option>
                </select>
            </div>
            <br />

            <div class="form-group">
                <button class="btn btn-success btn-block text-uppercase" type="submit">
                    <i class="fa fa-refresh"></i>
                    Atualizar Cadastro
                </button>
            </div>
        </form>
    </div>
    <br>
</div>

<script type="text/javascript">
    var currentUri = 'dados';
    var baseUri = '{{ url('/') }}';

    @if(request()->get('success'))
        __alert__success();
    @endif

    @if(request()->get('error') == 'cpf-email')
        __alert__error('CPF ou E-mail já está sendo utilizado por outro cliente.');
    @endif

    @if(request()->get('error') == 'email-pix')
        __alert__error('Para pagamentos via PIX, é necessário informar o e-mail.');
    @endif
</script>
@endsection
