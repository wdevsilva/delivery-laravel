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
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
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
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                <h3 class="text-center">Novo Grupo</h3>
                <div class="block-flat">
                    <div class="header">
                        <h3>Dados do Grupo
                            <span class="pull-right"><a href="<?php echo $baseUri; ?>/grupo/" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Listar Grupos</a></span>
                        </h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/grupo/gravar/" method="post" role="form" autocomplete="off">
                            <input type="hidden" name="grupo_id" id="grupo_id" value="">
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="grupo_nome">Nome Externo (exibido no site)</label>
                                    <input type="text" name="grupo_nome" id="grupo_nome" class="form-control" placeholder="Informe o nome de exibição" value="" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="grupo_nome">Nome Interno (controle adm)</label>
                                    <input type="text" name="grupo_desc" id="grupo_desc" class="form-control" placeholder="Informe o nome interno" value="" required />
                                </div>
                            </div>

                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="grupo_tipo">Tipo</label>
                                    <select name="grupo_tipo" id="grupo_tipo" class="form-control">
                                        <option value="2">Opcional</option>
                                        <option value="1">Obrigatório</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="grupo_limite">Limite <small>(0 = ilimitado)</small></label>
                                    <input type="number" name="grupo_limite" id="grupo_limite" min="0" class="form-control" placeholder="Limite de opções" value="0" />
                                </div>
                            </div>

                            <div class="text-center">
                                <br><br><br><br>
                                <button class="btn btn-primary btn-lg" type="submit" style="margin-top: 25px;">
                                    <i class="fa fa-check-circle-o"></i> Gravar Dados</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Chat-->
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
        <script src="app-js/grupo.js"></script>
        <script type="text/javascript">
            $('#menu-grupo').addClass('active');
            $('#grupo_tipo').on('change', function() {
                if ($(this).val() == 2) {
                    $('#grupo_limite').removeAttr('disabled');
                } else {
                    $('#grupo_limite').attr('disabled', 'disabled');
                }
            });
        </script>
        <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
        <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>