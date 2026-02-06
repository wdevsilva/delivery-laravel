<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/modal.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/assets/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo $data['config']->config_foto; ?>" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/app.css" />
    <link href="<?php echo $baseUri; ?>/assets/css/main.css?v=<?= filemtime(__DIR__ . '/../../assets/css/main.css') ?>" rel="stylesheet" />
</head>

<body>
    <div class="container" id="home-content">
        <?php require_once 'menu.php'; ?>
        <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
            <form action="<?php echo $baseUri; ?>/local/gravar/" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="endereco_id" id="endereco_id" value="<?= $data['endereco']->endereco_id ?>" />
                <input type="hidden" name="endereco_cliente" id="endereco_cliente" value="<?= $data['endereco']->endereco_cliente ?>" />
                <br />
                <h4 class="text-danger text-uppercase text-center">
                    <i class="fa fa-map-marker"></i> Alterar endereço
                </h4>
                <br />
                <div class="form-group">
                    <label for="endereco_cliente">Local / Apelido </label>
                    <span class="pull-right">
                        <small><b class="fa fa-info-circle"> Ex: Casa da Praia, Escritório...</b></small>
                    </span>
                    <input type="text" name="endereco_nome" id="endereco_nome" class="form-control" placeholder="Informe uma descrição para o endereço ex: Casa, Escritório, Praia" value="<?= $data['endereco']->endereco_nome ?>" />
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_cep">CEP</label>
                            <input type="text" name="endereco_cep" id="endereco_cep" placeholder="00000-000" value="<?= $data['endereco']->endereco_cep ?>" class="form-control" data-mask="cep" />
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_bairro">Bairro</label>
                            <select name="endereco_bairro" id="endereco_bairro" class="form-control" required>
                                <option value="">Selecione ...</option>
                                <?php if (isset($data['bairro'])) : ?>
                                    <?php foreach ($data['bairro'] as $b) : ?>
                                        <option value="<?= $b->bairro_nome ?>" data-bairro="<?= $b->bairro_id ?>" data-cidade="<?= $b->bairro_cidade ?>">
                                            <?= $b->bairro_nome ?> - <?= $b->bairro_cidade ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <input type="hidden" name="endereco_cidade" id="endereco_cidade" value="<?= $data['endereco']->endereco_cidade ?>">
                            <input type="hidden" name="endereco_bairro_id" id="endereco_bairro_id" value="<?= $data['endereco']->endereco_bairro_id ?>">
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_endereco">Endereço</label>
                            <input type="text" placeholder="Ex: Avenida Paulista" name="endereco_endereco" id="endereco_endereco" class="form-control" value="<?= $data['endereco']->endereco_endereco; ?>" required>
                            <input type="hidden" name="endereco_lat" id="endereco_lat" value="<?= $data['endereco']->endereco_lat; ?>">
                            <input type="hidden" name="endereco_lng" id="endereco_lng" value="<?= $data['endereco']->endereco_lng; ?>">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_numero">Número</label>
                            <input type="number" placeholder="Ex: 500" name="endereco_numero" id="endereco_numero" class="form-control" required value="<?= $data['endereco']->endereco_numero; ?>">
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_complemento">Complemento</label>
                            <input type="text" placeholder="Ex: Bloco 5 - Apto 51" name="endereco_complemento" id="endereco_complemento" class="form-control" value="<?= $data['endereco']->endereco_complemento; ?>">
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="endereco_referencia">Referência</label>
                            <input type="text" placeholder="Ex: Hospital Central" name="endereco_referencia" id="endereco_referencia" class="form-control" value="<?= $data['endereco']->endereco_referencia; ?>">
                        </div>
                    </div>
                </div>
                <br />
                <div class="form-group">
                    <button class="btn btn-success btn-block btn-endereco-gravar text-uppercase" type="submit">
                        <i class="fa fa-refresh"></i>
                        Atualizar endereço
                    </button>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger btn-block btn-endereco-remove text-uppercase" type="button">
                        <i class="fa fa-trash"></i>
                        remover endereço
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="modal fade" id="modal-endereco-remove" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Remover Registro</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="i-circle warning"><i class="fa-2x fa fa-warning text-danger"></i></div>
                        <h4 class="text-danger">Atenção!</h4>
                        <p>Deseja realmente remover esse endereço?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <form name="form-remove" id="form-remove" action="<?php echo $baseUri; ?>/cliente-remover-endereco/" method="post">
                        <input type="hidden" name="endereco_id" id="endereco_id" value="<?= $data['endereco']->endereco_id; ?>" />
                        <center>
                            <button type="button" class="btn btn-success" data-dismiss="modal">CANCELAR</button>
                            <button type="button" class="btn btn-danger btn-confirma-remove">REMOVER</button>
                        </center>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <?php require 'modal-cep-entrega.php'; ?>
    <?php 
    require_once 'footer.php'; 
    require 'side-carrinho.php'; 
    ?>
    <script type="text/javascript">
        var currentUri = 'index';
    </script>
    <?php require_once 'footer-core-js.php'; ?>
    <script type="text/javascript" src="{{ asset('assets/js/endereco.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pedido.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/number.js"></script>
    <script src="{{ asset('assets/js/howler.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/carrinho.js"></script>
    <script>
        $('#endereco_bairro').val('<?= $data['endereco']->endereco_bairro; ?>')
        $('#endereco_cidade').val('<?= $data['endereco']->endereco_cidade; ?>')
    </script>
    <script type="text/javascript">
        

        rebind_reload();
    </script>
</body>

</html>