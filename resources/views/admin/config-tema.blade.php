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
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
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
                <h3 class="text-center"></h3>
                <div class="block-flat">
                    <div class="header">
                        <h3>Aparência do site</h3>
                    </div>
                    <?php if (isset($data['config'])) : ?>
                        <div class="content">
                            <form action="<?php echo $baseUri; ?>/configuracao/tema_update/" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                                <input type="hidden" name="config_id" id="config_id" value="<?= $data['config']->config_id ?>">
                                <input type="hidden" name="config_foto" id="config_foto" value="<?= $data['config']->config_foto ?>">
                                <input type="hidden" name="config_foto_capa" id="config_foto_capa" value="<?= $data['config']->config_foto_capa ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3><b>Formato da fotos</b></h3>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="foto-round" data-round="50" style="border-radius: 50%;background-color: #476077;width: 100px;height: 100px;cursor: pointer"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="foto-round" data-round="25" style="border-radius: 25%;background-color: #476077;width: 100px;height: 100px;cursor: pointer"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="foto-round" data-round="10" style="border-radius: 10%;background-color: #476077;width: 100px;height: 100px;cursor: pointer"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="foto-round" data-round="0" style="border-radius: 0%;background-color: #476077;width: 100px;height: 100px;cursor: pointer"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h3 style="text-align: center;"><b>Altere sua Logo</b></h3>
                                        <div class="form-group" style="text-align: center;">
                                            <?php if ($data['config']->config_foto != "") : ?>
                                                <img src="<?php echo $baseUri; ?>/assets/thumb.php?zc=1&w=170&h=160&src=logo/<?= $_SESSION['base_delivery'] ?>/<?= $data['config']->config_foto; ?>" alt="Foto"/>
                                            <?php else : ?>
                                                <img src="<?php echo $baseUri; ?>/assets/thumb.php?zc=1&w=170&h=160&src=img/sem_foto.jpg" alt="Foto"/>
                                            <?php endif; ?>
                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn btn-warning btn-file btn-block">
                                                <span class="fileinput-exists">
                                                    <i class="fa fa-retweet"></i>
                                                    Trocar Logo
                                                </span>
                                                <input type="file" id="config_foto" name="config_foto" class="form-control">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3><b>Cores do Topo e Menu</b></h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Cor de Fundo (Topo) </label>
                                                <div class="color-picker input-append colorpicker-component">
                                                    <input type="color" name="config_color_top" value="<?= $data['config']->config_color_top ?>" class="form-control input-lg" />
                                                    <span class="add-on"><i></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h3><b>Quantidade de itens exibidos</b></h3>
                                        <div class="form-group" style="margin-top: 20px">
                                            <label for="config_nome">Itens por categoria na home </label>
                                            <input type="number" min="1" name="config_home_qtde" id="config_home_qtde" class="form-control input-lg" value="<?= $data['config']->config_home_qtde ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <br>
                                    <p class="text-center" style="margin-top: 5% !important;">
                                        <button class="btn btn-primary btn-lg text-uppercase" type="submit"><i class="fa fa-check-circle-o"></i> Atualizar configurações
                                        </button>
                                    </p>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
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
    <script type="text/javascript" src="js/jquery.select2/dist/js/select2.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/uf-combo/cidades-estados-1.4-utf8.js" charset="utf-8"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/bootstrap.summernote/dist/summernote.min.js"></script>

    <script src="app-js/main.js"></script>
    <script src="app-js/config.js"></script>
    <script type="text/javascript">
        $('#menu-config-tema').addClass('active');
        <?php if (isset($_GET['success'])) : ?>
            _alert_success();
        <?php endif; ?>


    </script>
    <script>
        $('#config_taxa_entrega').mask("#.##0.00", {
            reverse: true
        });
        $('#config_retirada').val(<?= $data['config']->config_retirada ?>);
        $('.foto-round').on('click', function() {
            var url = "<?php echo $baseUri; ?>/configuracao/update_foto_round/";
            var foto_round = $(this).data('round');
            $('.foto-round').css('background-color', '#476077');
            $(this).css('background-color', '#272930');
            $.post(url, {
                config_foto_round: foto_round,
                config_id: 1
            }, function(rs) {})
        })
        $('[data-round="<?= $data['config']->config_foto_round ?>"]').css('background-color', '#272930');
    </script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>
