@extends('layouts.site')

@section('content')
<div class="container" id="home-content">
    <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
        <form action="{{ url('/endereco/salvar') }}" method="post" role="form" autocomplete="off">
            @csrf
            <br />
            <h4 class="text-danger text-uppercase text-center">
                <i class="fa fa-map-marker"></i>
                Cadastrar endereço
            </h4>
            <br />

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="endereco_nome">Local / Apelido </label>
                <span class="pull-right">
                    <small><b class="fa fa-info-circle"> Ex: Casa da Praia, Escritório...</b></small>
                </span>
                <input type="text" name="endereco_nome" id="endereco_nome" class="form-control"
                    placeholder="Informe uma descrição para o endereço ex: Casa, Escritório, Praia"
                    value="{{ old('endereco_nome') }}" required />
            </div>

            <div class="row">
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
                                    data-bairro="<?= $b->bairro_id ?>">
                                    <?= $b->bairro_nome ?> - <?= $b->bairro_cidade ?>
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="endereco_cidade" id="endereco_cidade" value="{{ old('endereco_cidade') }}">
                        <input type="hidden" name="endereco_bairro_id" id="endereco_bairro_id" value="{{ old('endereco_bairro_id') }}">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="endereco_endereco">Endereço</label>
                        <span class="pull-right">
                            <small class="text-danger">* obrigatório</small>
                        </span>
                        <input type="text" placeholder="Ex: Avenida Souza" name="endereco_endereco"
                            id="endereco_endereco" class="form-control" value="{{ old('endereco_endereco') }}" required>
                        <input type="hidden" name="endereco_lat" id="endereco_lat" value="{{ old('endereco_lat') }}">
                        <input type="hidden" name="endereco_lng" id="endereco_lng" value="{{ old('endereco_lng') }}">
                    </div>
                </div>
                <div class="col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="endereco_numero">Número</label>
                        <span class="pull-right">
                            <small class="text-danger">* obrigatório</small>
                        </span>
                        <input type="text" placeholder="Ex: 600" name="endereco_numero"
                            id="endereco_numero" class="form-control" required value="{{ old('endereco_numero') }}">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="endereco_complemento">Complemento</label>
                        <input type="text" placeholder="Ex: Bloco 5 - Apto 33" name="endereco_complemento"
                            id="endereco_complemento" class="form-control" value="{{ old('endereco_complemento') }}">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="endereco_referencia">Referência</label>
                        <input type="text" placeholder="Ex: Hospital Central" name="endereco_referencia"
                            id="endereco_referencia" class="form-control" value="{{ old('endereco_referencia') }}">
                    </div>
                </div>
            </div>
            <br />

            <div class="form-group">
                <button class="btn btn-success btn-block text-uppercase" type="submit">
                    <i class="fa fa-save"></i>
                    Cadastrar endereço
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
