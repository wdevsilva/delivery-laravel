<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="washington mendes">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap.switch/bootstrap-switch.min.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.easypiechart/jquery.easy-pie-chart.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.datatables/bootstrap-adapter/css/datatables.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="<?php echo $baseUri; ?>/assets/css/bloqueio.css" rel="stylesheet" />
    <link href="<?php echo $baseUri; ?>/assets/css/matrix-style.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="css/export.css" type="text/css" media="all" />
    <script src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/amcharts/amcharts.js"></script>
    <script type="text/javascript" src="js/amcharts/pie.js"></script>
    <script type="text/javascript" src="js/amcharts/serial.js"></script>
    <script type="text/javascript" src="js/amcharts/animate.min.js"></script>
    <script type="text/javascript" src="js/amcharts/plugins/export/export.min.js"></script>
    <script type="text/javascript" src="js/amcharts/themes/light.js"></script>
</head>

<body class="animated">
    <?php
    require_once 'cobranca.php';
    require_once 'bloqueio.php';
    ?>
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="block-flat">
                    <form action="" method="post">
                        <?php
                        
                        Post::change('data_fim', date('d/m/Y', strtotime(str_replace('/', '-', Post::get('data_fim')))));

                        if (isset($_POST['data_inicio']) && isset($_POST['data_fim'])) {
                            
                            $dataInicio = explode('/', $_POST['data_fim']);
                            $dataInicio = '01'.'/'.$dataInicio[1].'/'.$dataInicio[2];
                            $dataFim = $_POST['data_fim'];

                            Post::change('data_inicio', $dataInicio);

                        } else {
                            $dataInicio = date('01/m/Y');
                            $dataFim = date('d/m/Y');
                        }

                        ?>
                        <div class="col-md-3 form-group">
                            <input type="text" name="data_inicio" id="data_inicio" class="form-control  data-inicio" autocomplete="off" placeholder="Data Inicial" value="<?= $dataInicio ?>" readonly required />
                        </div>
                        <div class="col-md-3 form-group">
                            <input type="text" name="data_fim" id="data_fim" class="form-control data-fim" autocomplete="off" placeholder="Data Final" value="<?= $dataFim ?>" required />
                        </div>
                        <div class="col-md-3 form-group">
                            <button type="submit" class="btn btn-status" data-status="6">
                                <i class="fa fa-search"></i> Pesquisar</button>
                        </div>
                    </form>
                    <?php
                    require_once  'dashboards/linear-venda-diaria.php';
                    require_once  'dashboards/linear-venda-13meses.php';
                    require_once  'dashboards/barra-faturamento-anual.php';
                    require_once  'dashboards/linear-13meses-ticket.php';
                    require_once  'dashboards/barra-top10-produtos.php';
                    require_once  'dashboards/barra-top10-clientes.php';
                    
                    // NOVOS DASHBOARDS
                    require_once  'dashboards/pizza-taxa-conversao.php';
                    require_once  'dashboards/barra-horarios-pico.php';
                    require_once  'dashboards/pizza-formas-pagamento.php';
                    ?>
                    <br>
                    <?php if (isset($data['estoque'][0])) : ?>
                        <div class="header">
                            <h3>Itens com estoque baixo</h3>
                        </div>
                        <table class="table table-bordered table-striped datatable" id="datatabler">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Categoria</th>
                                    <th>Quantidade</th>
                                    <th width="60"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['estoque'] as $obj) : ?>
                                    <tr>
                                        <td><?= $obj->item_nome ?></td>
                                        <td><?= $obj->categoria_nome ?></td>
                                        <td width="120" class=" text-center bg-<?= ($obj->item_estoque < 10) ? 'danger' : ''; ?>"><?= $obj->item_estoque ?></td>
                                        <td width="60" class="text-center"><a href="<?php echo $baseUri; ?>/item/editar/<?= $obj->item_id ?>/" title="repor" data-toggle="tooltip" class="btn btn-xs btn-prusia"><i class="fa fa-refresh"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <br> <br>
                    <?php if (isset($data['cliente'][0])) : ?>
                        <div class="header">
                            <h3>Últimos Clientes Cadastrados</h3>
                        </div>
                        <table class="table table-bordered table-striped datatable" id="datatablex">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Fone</th>
                                    <th>Cidade</th>
                                    <th>Bairro</th>
                                    <th width="60"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['cliente'] as $obj) : ?>
                                    <tr>
                                        <td><?= $obj->cliente_id ?></td>
                                        <td><?= $obj->cliente_nome ?></td>
                                        <td><?= $obj->cliente_email ?></td>
                                        <td><?= ($obj->cliente_fone != '') ? $obj->cliente_fone : $obj->cliente_fone2; ?></td>
                                        <td><?= $obj->endereco_cidade ?></td>
                                        <td><?= $obj->endereco_bairro ?></td>
                                        <td width="60" class="text-center"><a href="<?php echo $baseUri; ?>/cliente/editar/<?= $obj->cliente_id ?>/" class="btn btn-xs btn-prusia"><i class="fa fa-search"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        $last_pedido = 0;
        if (isset($data['pedido'][0])) :
            $last_pedido = end($data['pedido']);
            $last_pedido = $last_pedido->pedido_id;
        endif;
        ?>
        <input type="hidden" id="last-pedido" value="<?= $last_pedido ?>">
        <?php //require_once 'side-right-chat.php'; 
        ?>
        <script src="js/jquery.cooki/jquery.cooki.js"></script>
        <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
        <script type="text/javascript" src="js/behaviour/core.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.switch/bootstrap-switch.js"></script>
        <script type="text/javascript" src="js/jquery.datatables/jquery.datatables.min.js"></script>
        <script type="text/javascript" src="js/jquery.datatables/bootstrap-adapter/js/datatables.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script src="app-js/main.js"></script>
        <script src="js/cupom-desconto/moment.js"></script>
        <script src="js/cupom-desconto/moment-pt-br.js"></script>
        <script src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.data-inicio, .data-fim').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
            });

            var baseUrl = '<?php echo $baseUri; ?>';
            $("#cl-wrapper").removeClass("sb-collapsed");
            $('#menu-dashboard').addClass('active');
            $('.switch').bootstrapSwitch();
            if (oDt) {
                oDt.fnSort([
                    [0, 'desc']
                ]);
            }
        </script>
</body>

</html>