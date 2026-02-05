<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet'
          type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css"/>
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css"/>
    <link href="css/style-prusia.css" rel="stylesheet"/>
    <link href="css/btn-upload.css" rel="stylesheet"/>
</head>
<body class="animated">
<div id="cl-wrapper">
    <div class="cl-sidebar">
        <?php require_once 'side-menu.php'; ?>
    </div>
    <div class="container-fluid" id="pcont">
        <?php require_once 'top-menu.php'; ?>
        <div class="cl-mcont">
            <div class="block-flat">
                <div class="header">
                    <h3>Banner's</h3>
                </div>
                <?php if (isset($data['config'])): ?>
                <div class="content">
                    <form action="<?php echo $baseUri; ?>/banner/upload/" method="post" role="form"
                          autocomplete="off" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="fileinput fileinput-new text-left" data-provides="fileinput"
                                     style="margin-left: -3px">
                                    <button class="btn btn-primary btn-file btn-block text-uppercase">
                                        <input type="file" id="banner_url" name="banner_url" class="form-control">
                                        <span class="fileinput-exists"> <i
                                                    class="fa fa-picture-o"></i> Selecione uma Imagem  </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <button type="submit" class="btn btn-block btn-success">
                                    <i
                                            class="fa fa-cloud-upload text-uppercase"></i>
                                    ENVIAR IMAGEM SELECIONADA
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php if (isset($data['banner'][0])): ?>
                        <table class="datatable table table-hover table-striped table-bordered"
                               width="100%">
                            <thead>
                            <tr>
                                <th width="100">Posição</th>
                                <th>Banner</th>
                                <th width="80" class="d-print-none text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data['banner'] as $obj): ?>
                                <tr class="gradeA" id="tr-<?= $obj->banner_id ?>">
                                    <td id="td-pos" style="vertical-align: middle">
                                        <input type="number" id="<?= $obj->banner_id ?>"
                                               class="form-control text-center banner-pos"
                                               data-id="<?= $obj->banner_id ?>"
                                               data-url="<?= $obj->banner_url ?>"
                                               value="<?= $obj->banner_pos ?>"
                                        />
                                    </td>
                                    <td id="td-nome" style="vertical-align: middle"><?= $obj->banner_url ?></td>
                                    <td id="td-action" style="vertical-align: middle" class="text-center">
                                        <button
                                                type="button"
                                                data-id="<?= $obj->banner_id ?>"
                                                data-url="<?= $obj->banner_url ?>"
                                                title="Remover"
                                                data-toggle="tooltip"
                                                class="btn btn-sm btn-danger btn-remover">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <br><br>
                </div>
            </div>
            <?php endif; ?>
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
<script src="app-js/main.js"></script>
<script type="text/javascript">
    $('#menu-banner').addClass('active');
    <?php if (isset($_GET['success'])): ?>
    _alert_success();
    <?php endif; ?>

    $('.btn-remover').on('click', function () {
        let banner_id = $(this).data('id');
        let url = baseUri + '/banner/remove/';
        $.post(url, {banner_id: banner_id}, (rs) => {
        }).then(() => {
            $('#tr-' + banner_id).fadeOut();
        })
    });
    $('.banner-pos').on('change', function () {
        let banner_id = $(this).data('id');
        let banner_pos = $(this).val();
        let url = baseUri + '/banner/posicao/';
        $.post(url, {banner_id: banner_id, banner_pos: banner_pos}, (rs) => {
            _alert_success();
        })
    })
</script>
<script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
<script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>
</html>
