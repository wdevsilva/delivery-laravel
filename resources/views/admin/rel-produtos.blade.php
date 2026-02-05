<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.css">
    <link href="<?php echo $baseUri; ?>/assets/css/bloqueio.css" rel="stylesheet" />
    <script src="js/jquery.js"></script>
    <link href="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
    <script src="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.js"></script>
    <!-- datatables-->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUri; ?>/view/admin/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUri; ?>/view/admin/css/buttons.dataTables.min.css">
</head>

<body class="animated">
    <?php
    require 'cobranca.php';
    //require 'bloqueio.php';
    ?>
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <?php require 'top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3>
                            <span class="pull-left">
                                Relatório de Produtos
                                <form action="" method="post">
                                    <?php
                                    Post::change('data_inicio', date('d/m/Y', strtotime(str_replace('/', '-', Post::get('data_inicio')))));
                                    Post::change('data_fim', date('d/m/Y', strtotime(str_replace('/', '-', Post::get('data_fim')))));

                                    if (isset($_POST['data_inicio']) && isset($_POST['data_fim'])) {
                                        $dataInicio = $_POST['data_inicio'];
                                        $dataFim = $_POST['data_fim'];
                                    } else {
                                        $dataInicio = date('d/m/Y');
                                        $dataFim = date('d/m/Y');
                                    }

                                    ?>
                                    <div class="col-md-3 form-group">
                                        <input type="text" name="data_inicio" id="data_inicio" class="form-control  data-inicio" autocomplete="off" placeholder="Data Inicial" value="<?= $dataInicio ?>" required />
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <input type="text" name="data_fim" id="data_fim" class="form-control data-fim" autocomplete="off" placeholder="Data Final" value="<?= $dataFim ?>" required />
                                    </div>
                                    <!-- <div class="col-md-3 form-group">
                                        <select class="form-control" name="tipo_pagamento">
                                            <option value="" selected>Tipo Pagamento.</option>
                                            <option value="1" <?=($_POST['tipo_pagamento'] == '1') ? 'selected' : ''?>>Dinheiro</option>
                                            <option value="4" <?=($_POST['tipo_pagamento'] == '4') ? 'selected' : ''?>>Pix</option>
                                            <option value="2" <?=($_POST['tipo_pagamento'] == '2') ? 'selected' : ''?>>Cartão de Débito</option>
                                            <option value="3" <?=($_POST['tipo_pagamento'] == '3') ? 'selected' : ''?>>Cartão de Cédito</option>
                                        </select>
                                    </div> -->
                                    <div class="col-md-3 form-group">
                                        <button type="submit" class="btn btn-status" data-status="6">
                                            <i class="fa fa-search"></i> Pesquisar</button>
                                    </div>
                                </form>
                            </span>
                            <div class="row hidden-desktop"></div>
                        </h3>
                    </div>
                    <?php 
                    
                    if (isset($data['pedido'][0])) : ?>
                        <br>
                        <table class="datatable display nowrap table table-hover table-striped table-bordered" id="relprodutos">
                            <thead>
                                <tr>
                                    <th><b>Cagtegoria</b></th>
                                    <th><b>Produto</b></th>
                                    <th style="white-space: nowrap;"><b>Quantidade</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data['pedido'] as $obj) :

                                    if(!empty($obj->pedido_id)){
                                    ?>
                                    <tr id="tr-<?= $obj->pedido_id ?>" class="status-all">
                                        <td style="color: #000; vertical-align: middle; text-align: left;"><b><?= $obj->categoria_nome ?></b></td>
                                        <td style="color: #000; vertical-align: middle; text-align: left;"><b><?= $obj->lista_item_nome ?></b></td>
                                        <td style="color: #000; vertical-align: middle; text-align: center;"><b><?= $obj->total ?></b></td>
                                    </tr>
                                <?php
                                    }
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h3 class="text-center">Nenhum produto foi vendido no pedíodo informado</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script src="js/jquery.cooki/jquery.cooki.js"></script>
        <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
        <script type="text/javascript" src="js/behaviour/core.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script type="text/javascript">
            var bell = '<?= (isset($data['config']) && $data['config']->config_bell == 1) ? 'true' : 'false' ?>';
            var empresa = "<?= $_SESSION['base_delivery'] ?>";
            var idcliente = '<?= $obj->pedido_cliente ?>';
            var baseUrl = '<?php echo $baseUri; ?>';
        </script>
        <script src="app-js/main.js"></script>
        <!-- CALENDAR JS -->
        <script src="js/cupom-desconto/moment.js"></script>
        <script src="js/cupom-desconto/moment-pt-br.js"></script>
        <script src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.js"></script>

        <script type="text/javascript" language="javascript" src="<?php echo $baseUri; ?>/view/admin/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $baseUri; ?>/view/admin/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $baseUri; ?>/view/admin/js/pdfmake.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $baseUri; ?>/view/admin/js/vfs_fonts.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $baseUri; ?>/view/admin/js/buttons.html5.min.js"></script>
        <script type="text/javascript">
            

            $(document).ready(function() {
                $('.data-inicio, .data-fim').datetimepicker({
                    format: 'DD/MM/YYYY'
                });

                $('#relprodutos').DataTable({
                    retrieve: true,
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [{
                        text: '<i class="fa fa-file-pdf-o"></i> <span class="hidden-xs-down">PDF</span>',
                        extend: 'pdf',
                        //message: 'oiiiiiiiiiiiii',
                        className: 'btn-sm',
                        footer: true,
                        messageTop: '<?= ($data['config']->config_cnpj != '') ? 'CNPJ: ' . $data['config']->config_cnpj : '' ?>',
                        //orientation: 'landscape',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.pageMargins = [15, 15, 15, 30]; //left, top, right, footer
                            doc.styles.title.fontSize = 14;
                            doc.styles.tableHeader.fontSize = 10;
                            doc.defaultStyle.fontSize = 10;
                            // Remove spaces around page title
                            doc.content[0].text = doc.content[0].text.trim();
                            // Create a footer
                            doc['footer'] = (function(page, pages) {
                                return {
                                    columns: [
                                        'Data : <?=date('d/m/Y')?>, Período: <?=$dataInicio?> à <?=$dataFim?>',
                                        {
                                            // This is the right column
                                            alignment: 'right',
                                            text: ['página ', {
                                                text: page.toString()
                                            }, ' de ', {
                                                text: pages.toString()
                                            }]
                                        }
                                    ],
                                    margin: [10, 0]
                                }
                            });
                            // Styling the table: create style object
                            var objLayout = {};
                            // Horizontal line thickness
                            objLayout['hLineWidth'] = function(i) {
                                return .5;
                            };
                            // Vertikal line thickness
                            objLayout['vLineWidth'] = function(i) {
                                return .5;
                            };
                            // Horizontal line color
                            objLayout['hLineColor'] = function(i) {
                                return '#aaa';
                            };
                            // Vertical line color
                            objLayout['vLineColor'] = function(i) {
                                return '#aaa';
                            };
                            // Left padding of the cell
                            objLayout['paddingLeft'] = function(i) {
                                return 4;
                            };
                            // Right padding of the cell
                            objLayout['paddingRight'] = function(i) {
                                return 4;
                            };
                            // Inject the object in the document
                            doc.content[1].layout = objLayout;
                        }
                    }]
                });
            });

            $('#menu-rel-produtos').addClass('active');
            <?php if (isset($_GET['success'])) : ?>
                _alert_success();
            <?php endif; ?>
            $('.btn-status').on('click', function() {
                var status = $(this).data('status');
                if (status == 0) {
                    $('.status-all').fadeIn();
                } else {
                    $('.status-all').fadeOut();
                    $('.status-' + status).fadeIn();
                }
            });
        </script>
</body>

</html>