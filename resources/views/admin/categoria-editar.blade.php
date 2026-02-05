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
            <!-- TOP NAVBAR -->
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                <h3 class="text-center">Editar Categoria</h3>
                <div class="block-flat">
                    <div class="header">
                        <h3>Dados Categoria
                            <span class="pull-right"><a href="<?php echo $baseUri; ?>/categoria/" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Listar Categorias</a></span>
                        </h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/categoria/gravar/" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="categoria_id" id="categoria_id" value="<?= $data['categoria']
                                                                                                    ->categoria_id ?>">

                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="categoria_nome">Nome da Categoria</label>
                                    <input type="text" name="categoria_nome" id="categoria_nome" class="form-control" placeholder="Informe o nome da categoria" value="<?= $data['categoria']->categoria_nome; ?>" required />
                                </div>
                            </div>

                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="categoria_img">Imagem de Capa (opcional)</label>
                                    <input type="file" name="categoria_img" id="categoria_img" class="form-control" placeholder="Selecione uma imagem de capa" />
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="categoria_meia">Quantos Sabores?</label>
                                    <select name="categoria_meia" id="categoria_meia" class="form-control">
                                        <option value="1">1 Sabor</option>
                                        <option value="2">2 Sabores</option>
                                        <option value="3">3 Sabores</option>
                                        <option value="4">4 Sabores</option>
                                        <option value="5">5 Sabores</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="categoria_pos">Ordem de Exibição</label>
                                        <input type="number" name="categoria_pos" id="categoria_pos" class="form-control" placeholder="Informe a posição da categoria" value="<?= $data['categoria']->categoria_pos ?>" required>
                                    </div>
                                </div>
                            </div>
                            <br><br><br>
                            <p class="text-center">
                                <br><br><br>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-refresh"></i> Atualizar Categoria</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Chat-->
        <?php
        //require_once 'side-right-chat.php';
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
        <script src="app-js/main.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script src="app-js/categoria.js"></script>
        <script type="text/javascript">
            $('#menu-categoria').addClass('active');
            $('#categoria_meia').val('<?= $data['categoria']->categoria_meia ?>');
        </script>
        <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
        <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>