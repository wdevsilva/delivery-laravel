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
    <link rel="stylesheet" type="text/css" href="js/bootstrap.summernote/dist/summernote.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
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
                <h3 class="text-center">Editar Opção</h3>
                <div class="block-flat">
                    <div class="header">
                        <h3>
                            <?= $data['opcao']->grupo_desc ?>
                            <small> (<?= $data['opcao']->grupo_nome ?>) </small>

                            <span class="pull-right"><a href="<?php echo $baseUri; ?>/grupo/opcao/<?= $data['opcao']->opcao_grupo ?>/" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Listar Opções</a></span>
                        </h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/opcao/gravar/" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="opcao_id" id="opcao_id" value="<?= $data['opcao']->opcao_id ?>">
                            <input type="hidden" name="opcao_grupo" value="<?= $data['opcao']->opcao_grupo ?>">
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="opcao_nome">Nome da opção <span class="text-danger">*</span></label>
                                        <input type="text" name="opcao_nome" id="opcao_nome" class="form-control" placeholder="Informe o nome da opção" value="<?= $data['opcao']->opcao_nome ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="opcao_preco">Preço <span class="text-danger">*</span></label>
                                        <input type="text" name="opcao_preco" id="opcao_preco" class="form-control" placeholder="Informe o preço" value="<?= Currency::moeda($data['opcao']->opcao_preco) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="grupo_ativa">Status</label>
                                        <select name="opcao_status" id="opcao_status" class="form-control">
                                            <option value="1" <?= ($data['opcao']->opcao_status) == 1 ? 'selected' : '' ?>>Ativo</option>
                                            <option value="0" <?= ($data['opcao']->opcao_status) == 0 ? 'selected' : '' ?>>Inativo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center">
                                <br>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-check-circle-o"></i> Gravar Dados</button>
                            </p>
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
    <script src="app-js/item.js"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/bootstrap.summernote/dist/summernote.min.js"></script>
    <script type="text/javascript" src="js/jquery.select2/dist/js/select2.js"></script>

    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script src="app-js/opcao.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#opcao_nome').focus();
            $('#menu-opcao').addClass('active');
            //$('#opcao_desc').summernote({height: 200});
        });
    </script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>