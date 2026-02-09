@extends('layouts.site')

@section('content')
<div class="container" id="home-content">
    <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
        <br /><br />
        <a href="{{ url('/novo-endereco') }}" class="btn btn-success btn-block text-uppercase">
            <i class="fa fa-plus-circle"></i> Novo Endereço
        </a>
        <br />

        @if(count($enderecos) > 0)
            @foreach($enderecos as $end)
                <div data-id="<?= $end->endereco_id ?>" id="tr-<?= $end->endereco_id; ?>">
                    <a class="btn btn-block btn-primary" href="{{ url('/editar-endereco/' . $end->endereco_id) }}">
                        <small class="text-uppercase">
                            <i class="fa fa-map-marker"></i> <b><?= $end->endereco_nome ?> </b>
                            <br>
                            <small>
                                <?= $end->endereco_endereco ?> - <?= $end->endereco_bairro ?>
                            </small>
                        </small>
                    </a>
                    <br>
                </div>
            @endforeach
        @else
            <p class="alert alert-success">Você precisa cadastrar um endereço para entrega!</p>
        @endif

        <div class="form-group">
            <a href="{{ url('/meus-dados') }}" class="btn btn-default btn-block text-uppercase">
                <i class="fa fa-arrow-left"></i>
                Voltar para dados pessoais
            </a>
        </div>
    </div>
</div>

<script type="text/javascript">
    var currentUri = 'enderecos';
    var baseUri = '{{ url('/') }}';
</script>
@endsection
