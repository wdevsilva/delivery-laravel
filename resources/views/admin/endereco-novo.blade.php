<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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
                <h3 class="text-center">Cadastrar Endereço</h3>
                <div class="block-flat">
                    <div class="header">
                        <h3><?= $data['cliente']->cliente_nome ?> - <span class="text-info">Novo Endereço</span>
                            <span class="pull-right"><a href="<?php echo $baseUri; ?>/endereco/lista/<?= $data['cliente']->cliente_id ?>/" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Listar Endereços</a></span>
                        </h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/endereco/gravar/" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="endereco_cliente" id="endereco_cliente" value="<?= $data['cliente']->cliente_id ?>">
                            <div class="form-group">
                                <label for="endereco_cliente">Local / Apelido </label>
                                <span class="pull-right">
                                    <small><b class="fa fa-info-circle"> Ex: Casa da Praia, Escritório, Tia Maria</b></small>
                                </span>
                                <input type="text" name="endereco_nome" id="endereco_nome" class="form-control" placeholder="Informe uma descrição para o endereço ex: Casa, Escritório, Praia" />
                            </div>
                            <div class="header">
                                <h4>Endereço</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="endereco_cep">CEP</label>
                                        <input type="text" data-mask="cep" placeholder="EX: 11700-000" name="endereco_cep" id="endereco_cep" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="endereco_uf">Estado</label>
                                        <select name="endereco_uf" id="endereco_uf" class="form-control" required>
                                            <option value=""> Selecione um estado...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="endereco_cidade">Cidade</label>
                                        <select name="endereco_cidade" id="endereco_cidade" class="form-control" required></select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="endereco_bairro">Bairro</label>
                                        <input type="text" placeholder="Ex: Centro" name="endereco_bairro" id="endereco_bairro" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-xs-12">
                                        <label for="endereco_endereco">Endereço</label>
                                        <input type="text" placeholder="Ex: Avenida Paulista" name="endereco_endereco" id="endereco_endereco" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3 col-xs-12">
                                            <label for="endereco_numero">Número</label>
                                            <input type="text" placeholder="Ex: 500" name="endereco_numero" id="endereco_numero" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3 col-xs-12">
                                        <label for="endereco_complemento">Complemento</label>
                                        <input type="text" placeholder="Ex: Bloco 5 - Apto 51" name="endereco_complemento" id="enddereco_complemento" class="form-control">
                                    </div>
                                </div>
                            </div><br />
                            <div class="form-group text-center">
                                <button class="btn btn-primary btn-lg" type="submit"><i class="fa fa-check-circle-o"></i> Gravar Dados</button>
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
    <script src="<?php echo $baseUri; ?>/assets/vendor/uf-combo/cidades-estados-1.4-utf8.js" charset="utf-8"></script>

    <script type="text/javascript" src="js/jquery.datatables/jquery.datatables.min.js"></script>
    <script type="text/javascript" src="js/jquery.datatables/bootstrap-adapter/js/datatables.js"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="app-js/endereco.js"></script>
    <script type="text/javascript">
        $('#menu-cliente').addClass('active');
        $(function() {
            new dgCidadesEstados({
                cidade: document.getElementById('endereco_cidade'),
                estado: document.getElementById('endereco_uf')
            });
        });

        
    </script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>