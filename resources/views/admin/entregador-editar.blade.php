<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar entregador</title>
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
                <h3 class="text-center">Editar Entregador</h3>
                <div class="block-flat">
                    <div class="header">
                        <h3>Dados Entregador
                            <span class="pull-right"><a href="<?php echo $baseUri; ?>/entregador/" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Listar entregadores</a></span>
                        </h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/entregador/gravar/" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="entregador_id" id="entregador_id" value="<?= $data['entregador']->entregador_id ?>">
                            <div class="form-group">
                                <label for="entregador_nome">Nome completo</label>
                                <input type="text" name="entregador_nome" id="entregador_nome" class="form-control" placeholder="Informe o nome do contato responsável" value="<?= $data['entregador']->entregador_nome ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="entregador_cpf">CPF <small>(opcional)</small></label>
                                <input type="text" data-mask="cpf" name="entregador_cpf" id="entregador_cpf" class="form-control" placeholder="Informe o número do documento" value="<?= $data['entregador']->entregador_cpf ?>">
                            </div>
                            <div class="form-group">
                                <label for="entregador_fone">Celular</label>
                                <input type="text" data-mask="cell" placeholder="(99) 99999-9999" name="entregador_fone" id="entregador_fone" class="form-control" value="<?= $data['entregador']->entregador_fone ?>">
                            </div>
                            <div class="form-group">
                                <label for="entregador_status">Status</label>
                                <select name="entregador_status" id="entregador_status" class="form-control">
                                    <option value="1">ATIVO</option>
                                    <option value="0">INATIVO</option>
                                </select>
                            </div>
                            <p class="text-center">
                                <button class="btn btn-primary btn-lg" type="submit"><i class="fa fa-check-circle-o"></i> Gravar Dados
                                </button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="js/datatables-button/dataTables.buttons.min.js"></script>
    <script src="js/datatables-button/buttons.print.min.js"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="app-js/main.js"></script>
    <script src="app-js/datatables.js"></script>
    <script src="app-js/entregador.js"></script>
    <script type="text/javascript">
        $('#menu-entregador').addClass('active');
        $('#entregador_status').val(<?= $data['entregador']->entregador_status ?>);

        
    </script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>