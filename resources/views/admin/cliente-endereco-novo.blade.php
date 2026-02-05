<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="css/btn-upload.css" rel="stylesheet" />
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <!-- TOP NAVBAR -->
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3>Endereço de entrega
                            <span class="pull-right"><a href="<?php echo $baseUri; ?>/admin/venda_livre_produtos?cli=<?= $_SESSION['__CLIENTE__ID__'] ?>" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Voltar</a></span>
                        </h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/admin/gravar/<?= (isset($data['return']) && $data['return'] != "") ? '?return=' . $data['return'] : ''; ?>" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="endereco_cliente" id="endereco_cliente" value="<?= $data['cliente']->cliente_id ?>">
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
            </div>
        </div>
    </div>
    <!-- Right Chat-->
    <?php //require_once 'side-right-chat.php'; 
    ?>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="app-js/main.js"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="app-js/cliente.js"></script>
    <script type="text/javascript">
        $('#menu-cliente').addClass('active');
    </script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/endereco.js"></script>
    <script type="text/javascript">
        
    </script>
</body>

</html>