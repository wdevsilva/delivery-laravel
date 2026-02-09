@extends('layouts.site')

@section('content')
<div class="container" id="home-content">
    <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
        <form action="{{ url('/endereco/salvar') }}" method="post" role="form" autocomplete="off">
            @csrf
            <input type="hidden" name="endereco_id" value="<?= $endereco->endereco_id ?>" />
            <br />
            <h4 class="text-danger text-uppercase text-center">
                <i class="fa fa-map-marker"></i> Alterar endereço
            </h4>
            <br />

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-group">
                <label for="endereco_nome">Local / Apelido </label>
                <span class="pull-right">
                    <small><b class="fa fa-info-circle"> Ex: Casa da Praia, Escritório...</b></small>
                </span>
                <input type="text" name="endereco_nome" id="endereco_nome" class="form-control"
                    placeholder="Informe uma descrição para o endereço ex: Casa, Escritório, Praia"
                    value="<?= $endereco->endereco_nome ?>" required />
            </div>

            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="endereco_cep">CEP</label>
                        <input type="text" name="endereco_cep" id="endereco_cep" placeholder="00000-000"
                            value="<?= $endereco->endereco_cep ?>" class="form-control" data-mask="cep" />
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="endereco_bairro">Bairro</label>
                        <span class="pull-right">
                            <small class="text-danger">* obrigatório</small>
                        </span>
                        <select name="endereco_bairro" id="endereco_bairro" class="form-control" required>
                            <option value="">Bairros atendidos ...</option>
                            @foreach($bairros as $b)
                                <option value="<?= $b->bairro_nome ?>"
                                    data-cidade="<?= $b->bairro_cidade ?>"
                                    data-bairro="<?= $b->bairro_id ?>"
                                    <?= ($endereco->endereco_bairro == $b->bairro_nome) ? 'selected' : '' ?>>
                                    <?= $b->bairro_nome ?> - <?= $b->bairro_cidade ?>
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="endereco_cidade" id="endereco_cidade" value="<?= $endereco->endereco_cidade ?>">
                        <input type="hidden" name="endereco_bairro_id" id="endereco_bairro_id" value="<?= $endereco->endereco_bairro_id ?>">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="endereco_endereco">Endereço</label>
                        <input type="text" placeholder="Ex: Avenida Paulista" name="endereco_endereco"
                            id="endereco_endereco" class="form-control" value="<?= $endereco->endereco_endereco; ?>" required>
                        <input type="hidden" name="endereco_lat" id="endereco_lat" value="<?= $endereco->endereco_lat; ?>">
                        <input type="hidden" name="endereco_lng" id="endereco_lng" value="<?= $endereco->endereco_lng; ?>">
                    </div>
                </div>
                <div class="col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="endereco_numero">Número</label>
                        <input type="text" placeholder="Ex: 500" name="endereco_numero"
                            id="endereco_numero" class="form-control" required value="<?= $endereco->endereco_numero; ?>">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="endereco_complemento">Complemento</label>
                        <input type="text" placeholder="Ex: Bloco 5 - Apto 51" name="endereco_complemento"
                            id="endereco_complemento" class="form-control" value="<?= $endereco->endereco_complemento; ?>">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="endereco_referencia">Referência</label>
                        <input type="text" placeholder="Ex: Hospital Central" name="endereco_referencia"
                            id="endereco_referencia" class="form-control" value="<?= $endereco->endereco_referencia; ?>">
                    </div>
                </div>
            </div>
            <br />

            <div class="form-group">
                <button class="btn btn-success btn-block text-uppercase" type="submit">
                    <i class="fa fa-refresh"></i>
                    Atualizar endereço
                </button>
            </div>

            <div class="form-group">
                <a href="{{ url('/meus-enderecos') }}" class="btn btn-default btn-block text-uppercase">
                    <i class="fa fa-arrow-left"></i>
                    Voltar para lista de endereços
                </a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var currentUri = 'endereco';
    var baseUri = '{{ url('/') }}';

    // Quando selecionar o bairro, preencher automaticamente a cidade
    $('#endereco_bairro').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var cidade = selectedOption.data('cidade');
        var bairroId = selectedOption.data('bairro');

        $('#endereco_cidade').val(cidade);
        $('#endereco_bairro_id').val(bairroId);
    });
</script>
@endsection
