<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Cliente</title>
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
                <h3 class="text-center">Cadastrar Cliente</h3>
                <div class="block-flat">
                    <div class="header">
                        <h3>Dados Cliente
                            <span class="pull-right"><a href="<?php echo $baseUri; ?>/cliente/" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Listar Clientes</a></span>
                        </h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/cliente/gravar/" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="cliente_nome">Nome completo</label>
                                <input type="text" name="cliente_nome" id="cliente_nome" class="form-control" placeholder="Informe o nome do contato responsável" required>
                            </div>
                            <div class="form-group">
                                <label for="cliente_cpf">Data Nascimento <small>(opcional)</small></label>
                                <input type="text" data-mask="date" name="cliente_nasc" id="cliente_nasc" class="form-control" placeholder="Informe a data de nascimento">
                            </div>
                            <div class="form-group">
                                <label for="cliente_cpf">CPF <small>(opcional)</small></label>
                                <input type="text" data-mask="cpf" name="cliente_cpf" id="cliente_cpf" class="form-control" placeholder="Informe o número do documento">
                            </div>
                            <div class="header">
                                <h4>Contato</h4>
                            </div>
                            <div class="form-group">
                                <label for="cliente_fone2">Celular</label>
                                <input type="text" data-mask="cell" required placeholder="(99) 99999-9999" name="cliente_fone2" id="cliente_fone2" class="form-control">
                            </div>
                            <!--
                                <div class="form-group">
                                    <label for="cliente_fone">Fone Fixo</label> 
                                    <input type="text" data-mask="phone" placeholder="(99) 9999-9999"  name="cliente_fone"  id="cliente_fone" class="form-control">
                                </div>                                      
                                <div class="form-group">
                                    <label for="cliente_fone3">Fone Personalizado</label> 
                                    <input type="text" placeholder="(99) 999-999-999 (WhatsApp)"  name="cliente_fone3"  id="cliente_fone3" class="form-control">
                                </div>
                                -->
                            <div class="form-group">
                                <label for="cliente_email">Email <small>(opcional)</small></label>
                                <input type="email" name="cliente_email" id="cliente_email" class="form-control" placeholder="informe um email válido">
                            </div>
                            <div class="form-group">
                                <label for="cliente_senha">Senha</label>
                                <input type="password" name="cliente_senha" id="cliente_senha" class="form-control" placeholder="informe uma senha" required>
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

        <script type="text/javascript" src="js/jquery.datatables/jquery.datatables.min.js"></script>
        <script type="text/javascript" src="js/jquery.datatables/bootstrap-adapter/js/datatables.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script src="app-js/cliente.js"></script>
        <script type="text/javascript">
            $('#menu-cliente').addClass('active');
        </script>
        <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
        <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>