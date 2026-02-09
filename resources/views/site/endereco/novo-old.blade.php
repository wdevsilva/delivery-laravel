@extends('layouts.site')

@section('content')
@php
@session_start();
$isMobile = preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
@endphp
    <div class="container" id="home-content">
        @include('site.components.menu')
        <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
            <form action="{{ url('/endereco/gravar') }}{{ ($return != '') ? '?return=' . $return : '' }}" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="endereco_cliente" id="endereco_cliente" value="<?= $cliente->cliente_id ?>">
                <br />
                <h4 class="text-danger text-uppercase text-center">
                    <i class="fa fa-map-marker"></i>
                    Cadastrar endereço
                </h4>
                <br />
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_nome">Local / Apelido </label>
                            <span class="pull-right">
                                <small><b class="fa fa-info-circle"> Ex: Casa da Praia, Escritório...</b></small>
                            </span>
                            <input type="text" name="endereco_nome" id="endereco_nome" required class="form-control" placeholder="ex: Casa, Escritório, Praia" />
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 hide">
                        <div class="form-group">
                            <label for="endereco_cep">CEP</label>
                            <input type="text" name="endereco_cep" id="endereco_cep" placeholder="00000-000" class="form-control" data-mask="cep" />
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
                                <?php if (isset($data['bairro'])) : ?>
                                    <?php foreach ($data['bairro'] as $b) : ?>
                                        <option value="<?= $b->bairro_nome ?>" data-cidade="<?= $b->bairro_cidade ?>" data-bairro="<?= $b->bairro_id ?>">
                                            <?= $b->bairro_nome ?> - <?= $b->bairro_cidade ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <input type="hidden" name="endereco_cidade" id="endereco_cidade" value="">
                            <input type="hidden" name="endereco_bairro_id" id="endereco_bairro_id" value="">
                        </div>
                    </div>

                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_endereco">Endereço</label>
                            <span class="pull-right">
                                <small class="text-danger">* obrigatório</small>
                            </span>
                            <input type="text" placeholder="Ex: Avenida Souza" name="endereco_endereco" id="endereco_endereco" class="form-control" required>
                            <input type="hidden" name="endereco_lat" id="endereco_lat" value="">
                            <input type="hidden" name="endereco_lng" id="endereco_lng" value="">
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_numero">Número</label>
                            <span class="pull-right">
                                <small class="text-danger">* obrigatório</small>
                            </span>
                            <input type="number" placeholder="Ex: 600" name="endereco_numero" id="endereco_numero" min="1" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_complemento">Complemento</label>
                            <input type="text" placeholder="Ex: Bloco 5 - Apto 33" name="endereco_complemento" id="endereco_complemento" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_referencia">Referência</label>
                            <input type="text" placeholder="Ex: Hospital Central" name="endereco_referencia" id="endereco_referencia" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <br />
                    <button class="btn btn-success btn-block btn-endereco-gravar" type="submit">
                        <i class="fa fa-check-circle-o"></i> CADASTRAR
                        <?= (isset($data['return']) && $data['return'] != "pedido") ? 'ENDEREÇO ' : ' E CONCLUIR PEDIDO'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php
    require 'modal-cep-entrega.php';
    require_once 'footer.php';
    require 'side-carrinho.php';
    ?>
    <script type="text/javascript">
        var currentUri = 'index';
    </script>
    <?php require_once 'footer-core-js.php'; ?>
    <script type="text/javascript" src="<?php echo {{ url("/") }}; ?>/view/site/app-js/endereco.js"></script>
    <script type="text/javascript" src="<?php echo {{ url("/") }}; ?>/view/site/app-js/pedido.js"></script>
    <script type="text/javascript" src="<?php echo {{ url("/") }}; ?>/view/site/app-js/number.js"></script>
    <script src="<?php echo {{ url("/") }}; ?>/view/site/app-js/howler.js"></script>
    <script type="text/javascript" src="<?php echo {{ url("/") }}; ?>/view/site/app-js/carrinho.js"></script>
    <script type="text/javascript">


        rebind_reload();
    </script>
</body>

</html>@endsection
