<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="js/jquery.dataTables/css/jquery.dataTables.min.css" />
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="block-flat">
                            <div class="header">
                                <h3>
                                    <i class="fa fa-gift"></i> Histórico de Descontos de Fidelidade
                                    <a href="<?php echo $baseUri; ?>/fidelidade/" class="btn btn-default btn-sm pull-right">
                                        <i class="fa fa-arrow-left"></i> Voltar
                                    </a>
                                </h3>
                            </div>
                            <div class="content">
                                <?php
                                $total_descontos = 0;
                                $total_pedidos_com_desconto = 0;
                                $valor_medio_desconto = 0;
                                
                                if (isset($data['historico']) && count($data['historico']) > 0):
                                    foreach ($data['historico'] as $item) {
                                        $total_descontos += $item->valor_desconto;
                                        $total_pedidos_com_desconto++;
                                    }
                                    $valor_medio_desconto = $total_descontos / $total_pedidos_com_desconto;
                                ?>
                                
                                <!-- Estatísticas -->
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-4">
                                        <div class="panel panel-success">
                                            <div class="panel-body text-center">
                                                <h4><i class="fa fa-money"></i> Total em Descontos</h4>
                                                <h2 style="color: #27ae60;">R$ <?= number_format($total_descontos, 2, ',', '.') ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="panel panel-info">
                                            <div class="panel-body text-center">
                                                <h4><i class="fa fa-shopping-cart"></i> Pedidos com Desconto</h4>
                                                <h2 style="color: #3498db;"><?= $total_pedidos_com_desconto ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="panel panel-warning">
                                            <div class="panel-body text-center">
                                                <h4><i class="fa fa-calculator"></i> Desconto Médio</h4>
                                                <h2 style="color: #f39c12;">R$ <?= number_format($valor_medio_desconto, 2, ',', '.') ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabela de Histórico -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="tabelaDescontos">
                                        <thead>
                                            <tr>
                                                <th width="80">Pedido #</th>
                                                <th>Cliente</th>
                                                <th width="100">Telefone</th>
                                                <th width="120">Valor Desconto</th>
                                                <th width="100">Percentual</th>
                                                <th width="150">Data</th>
                                                <th width="80">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data['historico'] as $item): ?>
                                            <tr>
                                                <td><strong><?= $item->pedido_numero_entrega ?></strong></td>
                                                <td><?= $item->cliente_nome ?></td>
                                                <td style="white-space: nowrap;"><?= $item->cliente_fone2 ?></td>
                                                <td><span class="label label-success">R$ <?= number_format($item->valor_desconto, 2, ',', '.') ?></span></td>
                                                <td><?= number_format($item->percentual_desconto, 0) ?>%</td>
                                                <td><?= date('d/m/Y H:i', strtotime($item->data_criacao)) ?></td>
                                                <td>
                                                    <a href="<?= $baseUri ?>/admin/pedido/<?= $item->pedido_id ?>" 
                                                       class="btn btn-sm btn-primary" 
                                                       title="Ver Pedido">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Nenhum desconto de fidelidade foi concedido ainda.
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables/js/jquery.dataTables.min.js"></script>
    <script src="js/scripts.js"></script>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#tabelaDescontos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json"
            },
            "order": [[5, "desc"]], // Ordenar por data decrescente
            "pageLength": 25
        });
    });
    </script>
</body>
</html>
