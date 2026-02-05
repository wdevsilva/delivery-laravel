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
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style.css" rel="stylesheet" />
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
                        <h3>Mensalidades</h3>
                    </div>
                    <div class="content">
                        <div id="cupom-grid">
                            <?php if (isset($data['mensalidade'])) : ?>
                                <div class="table-responsive">
                                    <table>
                                        <thead>
                                            <th style="text-align: center;"><strong>Período</strong></th>
                                            <th style="text-align: center;"><strong>Data Pagamento</strong></th>
                                            <th style="text-align: center;"><strong>Data Vencimento</strong></th>
                                            <th style="text-align: center;"><strong>Valor</strong></th>
                                            <th style="text-align: center;"><strong>Cód. Boleto</strong></th>
                                            <th style="text-align: center;"><strong>Situação</strong></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($data['mensalidade'] as $r) :

                                                $data = explode('-', $r->periodo);
                                                $ano = $data[0];
                                                $mes = $data[1];
                                            ?>
                                                <tr>
                                                    <td align="center"><?= date('d/m/Y', strtotime($r->periodo)) . ' à ' . date('d/m/Y', strtotime($r->data_vencimento)) ?></td>
                                                    <td align="center"><?= ($r->data_pagamento == '') ? 'Pendente' : date('d/m/Y', strtotime($r->data_pagamento)) ?></td>
                                                    <td align="center"><?= date('d/m/Y', strtotime($r->data_vencimento)) ?></td>
                                                    <td>R$<?= number_format($r->valor, 2, ',', '.') ?></td>
                                                    <td align="center">
                                                        <?php if ($r->codigo_barra != '') { ?>
                                                            <a><?= $r->codigo_barra ?></a>
                                                        <?php } ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php if ($r->status == 0) { ?>
                                                            <a class="btn btn-xs btn-warning"> <i class="fa fa-warning"></i></a>
                                                        <?php } else { ?>
                                                            <a class="btn btn-xs btn-success"> <i class="fa fa-check"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
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
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <?php require_once 'switch-color.php'; ?>
    <script src="app-js/main.js"></script>
    <script>
        $(document).ready(function() {
            $('#menu-mensalidade').addClass('active');
        });
    </script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>