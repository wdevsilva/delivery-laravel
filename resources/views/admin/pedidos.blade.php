<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <!-- <meta http-equiv="refresh" content="120"> -->
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap.switch/bootstrap-switch.min.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.datatables/bootstrap-adapter/css/datatables.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.css">
    <link href="<?php echo $baseUri; ?>/assets/css/bloqueio.css" rel="stylesheet" />
    <script src="js/jquery.js"></script>
    <link href="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
    <script src="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.js"></script>
    
    <style>
        /* 📱 Container Principal */
        .orders-modern-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
        }
        
        /* 🎯 Chips de Filtro Modernos */
        .filter-chips-container {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 16px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.06);
        }
        
        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: 2px solid #e9ecef;
            border-radius: 20px;
            background: white;
            color: #495057;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        
        .filter-chip:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .filter-chip.active {
            border-width: 2px;
            font-weight: 600;
        }
        
        .filter-chip.all.active { border-color: #6c757d; background: #6c757d; color: white; }
        .filter-chip.pending.active { border-color: #ffc107; background: #fff3cd; color: #856404; }
        .filter-chip.production.active { border-color: #17a2b8; background: #d1ecf1; color: #0c5460; }
        .filter-chip.delivery.active { border-color: #007bff; background: #cfe2ff; color: #004085; }
        .filter-chip.delivered.active { border-color: #28a745; background: #d4edda; color: #155724; }
        .filter-chip.cancelled.active { border-color: #dc3545; background: #f8d7da; color: #721c24; }
        .filter-chip.pickup.active { border-color: #20c997; background: #d1f4e0; color: #0f6848; }
        .filter-chip.pix.active { border-color: #fd7e14; background: #ffe5d0; color: #7a3c0f; }
        .filter-chip.scheduled.active { border-color: #6f42c1; background: #e2d9f3; color: #4a1c7d; }
        .filter-chip.ready.active { border-color: #20c997; background: #d1f4e0; color: #0f6848; }
        
        /* 🎨 Cartões de Status */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-badge.pending { background: #fff3cd; color: #856404; }
        .status-badge.production { background: #d1ecf1; color: #0c5460; }
        .status-badge.delivery { background: #cfe2ff; color: #004085; }
        .status-badge.delivered { background: #d4edda; color: #155724; }
        .status-badge.cancelled { background: #f8d7da; color: #721c24; }
        
        /* 🔘 Grupos de Botões de Ação */
        .action-buttons-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .action-row {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
            justify-content: flex-start;
        }
        
        .action-row.primary-actions {
            order: 1;
        }
        
        .action-row.status-actions {
            order: 2;
            padding-top: 4px;
            border-top: 1px solid #e9ecef;
        }
        
        /* 🎯 Botões com Categorias Visuais */
        .btn-action {
            position: relative;
            border-radius: 6px !important;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        
        .btn-action:active {
            transform: translateY(0);
        }
        
        /* Comunicação */
        .btn-communication { background: #25D366 !important; border-color: #25D366 !important; color: white !important; }
        .btn-communication:hover { background: #128C7E !important; }
        
        /* Informação */
        .btn-info-action { background: #00bcd4 !important; border-color: #00bcd4 !important; color: white !important; }
        .btn-info-action:hover { background: #0097a7 !important; }
        
        /* Status */
        .btn-status-change { font-weight: 600; }
        
        /* 📋 Tabela Moderna */
        .table-modern {
            background: white;
            border-radius: 10px;
            overflow: visible;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        /* Garantir que dropdown apareça por cima da tabela */
        .table-modern .dropdown-menu {
            position: absolute;
            z-index: 1050;
        }
        
        .table-modern .btn-group.open .dropdown-menu {
            display: block;
        }
        
        /* Wrapper para scroll horizontal sem cortar dropdown */
        .table-responsive-wrapper {
            overflow-x: auto;
            overflow-y: visible;
        }
        
        /* Fixar dropdown para não ser cortado pelo container */
        .dataTables_wrapper {
            overflow: visible !important;
        }
        
        /* Garantir que btn-group seja relativo para dropdown posicionar corretamente */
        .datatable tbody .btn-group {
            position: relative;
        }
        
        .datatable tbody .dropdown-menu {
            position: fixed !important;
            z-index: 9999 !important;
        }
        
        .table-modern thead th {
            background: #495057 !important;
            color: white !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 14px 10px;
            border: none;
        }
        
        .table-modern tbody tr {
            transition: none;
        }
        
        .table-modern tbody tr:hover {
            background: transparent;
            transform: none;
            box-shadow: none;
        }
        
        .table-modern tbody td {
            vertical-align: middle !important;
            padding: 12px 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        /* 🔢 Ordem de Número do Pedido */
        .order-number {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .order-number-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 14px;
        }
        
        /* 💳 Pix Badge */
        .pix-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .pix-status.paid {
            background: #d4edda;
            color: #155724;
        }
        
        .pix-status.pending {
            background: #fff3cd;
            color: #856404;
        }
        
        /* 🎯 Date Picker Modernizado */
        .date-filter-container {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 16px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.06);
            margin-bottom: 16px;
        }
        
        .date-filter-container .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 8px 12px;
            transition: all 0.2s;
        }
        
        .date-filter-container .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-search-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-search-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        /* 📄 Export Buttons */
        .export-buttons {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }
        
        .btn-export {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            border: 2px solid;
            background: white;
            transition: all 0.2s;
        }
        
        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-export.csv { color: #28a745; border-color: #28a745; }
        .btn-export.csv:hover { background: #28a745; color: white; }
        
        .btn-export.excel { color: #10793f; border-color: #10793f; }
        .btn-export.excel:hover { background: #10793f; color: white; }
        
        .btn-export.pdf { color: #dc3545; border-color: #dc3545; }
        .btn-export.pdf:hover { background: #dc3545; color: white; }
        
        .btn-export.print { color: #6c757d; border-color: #6c757d; }
        .btn-export.print:hover { background: #6c757d; color: white; }
        
        .btn-export.map { color: #ffc107; border-color: #ffc107; }
        .btn-export.map:hover { background: #ffc107; color: #000; }
        
        /* 📱 Responsive */
        @media (max-width: 768px) {
            .filter-chips-container {
                padding: 12px;
            }
            
            .filter-chip {
                font-size: 12px;
                padding: 6px 12px;
            }
            
            .action-row {
                flex-direction: column;
            }
            
            .btn-action {
                width: 100%;
                margin-bottom: 4px;
            }
        }
    </style>
    <style>
        .bootstrap-switch-handle-off {
            padding-right: 30px !important;
        }
    </style>
</head>

<body class="animated">
    <?php
    require 'cobranca.php';
    //require 'bloqueio.php';
    ?>
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require 'side-menu.php'; ?>
            <?php $isMobile = Browser::agent('mobile'); ?>            
        </div>
        <div class="container-fluid" id="pcont">
            <?php require 'top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 12px 12px 0 0;">
                        <h3 style="margin: 0; font-weight: 600;">
                            <i class="fa fa-shopping-cart"></i> Últimos Pedidos
                        </h3>
                    </div>
                    
                    <div style="padding: 20px;">
                        <!-- 📅 FILTRO DE DATA MODERNIZADO -->
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
                            <div class="date-filter-container">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fa fa-calendar" style="color: #667eea; font-size: 18px;"></i>
                                    <strong style="color: #495057; font-size: 14px;">Período:</strong>
                                </div>
                                <input type="text" name="data_inicio" id="data_inicio" class="form-control data-inicio" autocomplete="off" placeholder="Data Inicial" value="<?= $dataInicio ?>" required style="min-width: 140px;" />
                                <span style="color: #adb5bd;">→</span>
                                <input type="text" name="data_fim" id="data_fim" class="form-control data-fim" autocomplete="off" placeholder="Data Final" value="<?= $dataFim ?>" required style="min-width: 140px;" />
                                <button type="submit" class="btn-search-modern">
                                    <i class="fa fa-search"></i> Pesquisar
                                </button>
                            </div>
                        </form>

                        <?php 
                        // Inicializar variáveis padrão ANTES de usar nos botões
                        $qtdPedidos = 0;
                        $sumVendas = 0;
                        $sumEntregas = 0;
                        $countStatus = [
                            1 => 0, // Pendentes
                            2 => 0, // Em Produção
                            3 => 0, // Saiu para Entrega
                            4 => 0, // Entregues
                            5 => 0, // Cancelados
                            6 => 0, // Disponível para Retirada
                            7 => 0, // Pagamento Pix
                            8 => 0, // Agendados
                            9 => 0  // Prontos
                        ];
                        
                        if (isset($data['pedido']) && is_array($data['pedido']) && !empty($data['pedido'])) : 
                            // Pré-calcular totais para os cards
                            $qtdPedidos = count($data['pedido']);
                            $qtdCancelados = 0;
                            
                            foreach ($data['pedido'] as $p) {
                                if ($p->pedido_status != 5) {
                                    $sumVendas += $p->pedido_total - $p->pedido_entrega;
                                    $sumEntregas += $p->pedido_entrega;
                                } else {
                                    $qtdCancelados++;
                                }
                                
                                // Contar por status
                                if (isset($countStatus[$p->pedido_status])) {
                                    $countStatus[$p->pedido_status]++;
                                }
                            }
                        endif;
                        ?>

                        <!-- TOTALIZADORES DO PERÍODO - Apenas para Administrador -->
                        <?php if (Sessao::get_nivel() == 1 && isset($data['pedido']) && is_array($data['pedido']) && !empty($data['pedido'])): ?>
                        <!-- Botão Mostrar/Ocultar Valores -->
                        <div style="text-align: right; margin-bottom: 10px;">
                            <button id="btn-toggle-valores" onclick="toggleValores()" 
                                    style="background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.3); 
                                           color: #fff; padding: 8px 15px; border-radius: 20px; cursor: pointer;
                                           backdrop-filter: blur(10px); transition: all 0.3s ease; font-weight: 500;
                                           box-shadow: 0 2px 8px rgba(0,0,0,0.3);"
                                    onmouseover="this.style.background='rgba(0,0,0,0.7)'"
                                    onmouseout="this.style.background='rgba(0,0,0,0.5)'">
                                <i class="fa fa-eye-slash" id="icon-toggle"></i>
                                <span id="text-toggle" style="margin-left: 5px;">Mostrar Valores</span>
                            </button>
                        </div>
                        
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-md-3 col-sm-6 col-xs-6">
                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 15px; border-radius: 8px; text-align: center;">
                                    <div class="valor-card" style="font-size: 24px; font-weight: bold;"><?= $qtdPedidos ?></div>
                                    <div style="font-size: 12px; opacity: 0.9;"><i class="fa fa-shopping-bag"></i> Pedidos</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-6">
                                <div style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: #fff; padding: 15px; border-radius: 8px; text-align: center;">
                                    <div class="valor-card valor-oculto" data-valor="R$ <?= Currency::moeda($sumVendas) ?>" style="font-size: 24px; font-weight: bold; filter: blur(8px);">R$ •••,••</div>
                                    <div style="font-size: 12px; opacity: 0.9;"><i class="fa fa-dollar"></i> Vendas</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-6">
                                <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; padding: 15px; border-radius: 8px; text-align: center;">
                                    <div class="valor-card valor-oculto" data-valor="R$ <?= Currency::moeda($sumEntregas) ?>" style="font-size: 24px; font-weight: bold; filter: blur(8px);">R$ •••,••</div>
                                    <div style="font-size: 12px; opacity: 0.9;"><i class="fa fa-motorcycle"></i> Entregas</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-6">
                                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; padding: 15px; border-radius: 8px; text-align: center;">
                                    <div class="valor-card valor-oculto" data-valor="R$ <?= Currency::moeda($sumVendas + $sumEntregas) ?>" style="font-size: 24px; font-weight: bold; filter: blur(8px);">R$ •••,••</div>
                                    <div style="font-size: 12px; opacity: 0.9;"><i class="fa fa-calculator"></i> Total Geral</div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                        var valoresVisiveis = false;
                        
                        function toggleValores() {
                            valoresVisiveis = !valoresVisiveis;
                            var cards = document.querySelectorAll('.valor-oculto');
                            var icon = document.getElementById('icon-toggle');
                            var text = document.getElementById('text-toggle');
                            
                            cards.forEach(function(card) {
                                if (valoresVisiveis) {
                                    // Mostrar valores reais
                                    card.textContent = card.getAttribute('data-valor');
                                    card.style.filter = 'none';
                                } else {
                                    // Ocultar valores
                                    card.textContent = 'R$ •••,••';
                                    card.style.filter = 'blur(8px)';
                                }
                            });
                            
                            // Mudar ícone e texto do botão
                            if (valoresVisiveis) {
                                icon.className = 'fa fa-eye';
                                text.textContent = 'Ocultar Valores';
                            } else {
                                icon.className = 'fa fa-eye-slash';
                                text.textContent = 'Mostrar Valores';
                            }
                        }
                        </script>
                        <?php endif; ?>

                        <!-- 🎯 FILTROS MODERNOS COM CHIPS -->
                        <div class="filter-chips-container">
                            <button class="filter-chip all active" data-status="0">
                                <i class="fa fa-filter"></i> Todos <span class="badge" style="background: #fff; color: #6c757d; margin-left: 5px;"><?= $qtdPedidos ?></span>
                            </button>
                            <button class="filter-chip pending" data-status="1">
                                <i class="fa fa-clock-o"></i> Pendentes <span class="badge" style="background: #fff3cd; color: #856404; margin-left: 5px;"><?= $countStatus[1] ?></span>
                            </button>
                            <button class="filter-chip production" data-status="2">
                                <i class="fa fa-cutlery"></i> Em Produção <span class="badge" style="background: #d1ecf1; color: #0c5460; margin-left: 5px;"><?= $countStatus[2] ?></span>
                            </button>
                            <button class="filter-chip delivery" data-status="3">
                                <i class="fa fa-motorcycle"></i> Saiu para Entrega <span class="badge" style="background: #cfe2ff; color: #004085; margin-left: 5px;"><?= $countStatus[3] ?></span>
                            </button>
                            <button class="filter-chip delivered" data-status="4">
                                <i class="fa fa-check-circle"></i> Entregues <span class="badge" style="background: #d4edda; color: #155724; margin-left: 5px;"><?= $countStatus[4] ?></span>
                            </button>
                            <button class="filter-chip cancelled" data-status="5">
                                <i class="fa fa-ban"></i> Cancelados <span class="badge" style="background: #f8d7da; color: #721c24; margin-left: 5px;"><?= $countStatus[5] ?></span>
                            </button>
                            <button class="filter-chip pickup" data-status="6">
                                <i class="fa fa-shopping-bag"></i> Disponível para Retirada <span class="badge" style="background: #d1f4e0; color: #0f6848; margin-left: 5px;"><?= $countStatus[6] ?></span>
                            </button>
                            <?php if ($data['config']->config_pix == 1 && $data['config']->config_pix_automatico == 1) { ?>
                                <button class="filter-chip pix" data-status="7">
                                    <i class="fa fa-money"></i> Aguardando Pix <span class="badge" style="background: #ffe5d0; color: #7a3c0f; margin-left: 5px;"><?= $countStatus[7] ?></span>
                                </button>
                            <?php } else { ?>
                                <button class="filter-chip pix" data-status="7">
                                    <i class="fa fa-money"></i> Pagamento Pix <span class="badge" style="background: #ffe5d0; color: #7a3c0f; margin-left: 5px;"><?= $countStatus[7] ?></span>
                                </button>
                            <?php } ?>
                            <button class="filter-chip scheduled" data-status="8">
                                <i class="fa fa-calendar"></i> Agendados <span class="badge" style="background: #e2d9f3; color: #4a1c7d; margin-left: 5px;"><?= $countStatus[8] ?></span>
                            </button>
                            <button class="filter-chip ready" data-status="9">
                                <i class="fa fa-check"></i> Prontos <span class="badge" style="background: #d1f4e0; color: #0f6848; margin-left: 5px;"><?= $countStatus[9] ?></span>
                            </button>
                        </div>

                        <script>
                        // Função inteligente: tenta Bluetooth, fallback para USB
                        function imprimirPedido(pedidoId, isPix) {
                            // Tentar impressão térmica primeiro
                            $.ajax({
                                url: '<?= $baseUri ?>/api/imprimir-termica.php?id=' + pedidoId,
                                method: 'GET',
                                timeout: 3000,
                                success: function(response) {
                                    if (response.success && response.printer_type === 'bluetooth') {                                        
                                        // Já imprimiu, não fazer mais nada
                                    } else {
                                        // Bluetooth falhou, usar USB
                                        var url = isPix ? 
                                            '<?= $baseUri ?>/admin/imprimirPix/' + pedidoId + '/' :
                                            '<?= $baseUri ?>/admin/imprimir/' + pedidoId + '/';
                                        window.open(url, '_blank');
                                    }
                                },
                                error: function() {
                                    // Erro na API, usar USB direto
                                    var url = isPix ? 
                                        '<?= $baseUri ?>/admin/imprimirPix/' + pedidoId + '/' :
                                        '<?= $baseUri ?>/admin/imprimir/' + pedidoId + '/';
                                    window.open(url, '_blank');
                                }
                            });
                        }
                        </script>
                    <?php if (isset($data['pedido']) && is_array($data['pedido']) && !empty($data['pedido'])) : ?>
                        
                        <!-- 📄 BOTÕES DE EXPORTAÇÃO MODERNOS -->
                        <div class="export-buttons">
                            <div style="flex: 1;"></div>
                        </div>
                        
                        <div class="table-modern" style="position: relative;">
                            <table class="datatable display nowrap table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th><b>Pedido</b></th>
                                        <th style="white-space: nowrap;"><b>Nº entrega</b></th>
                                        <th style="white-space: nowrap; text-align: center;"><b>Valores</b></th>
                                        <th style="text-align: center;"><b>Data</b></th>
                                        <th style="text-align: center;"><b>Pagamento</b></th>
                                        <th style="text-align: center;"><b>Cliente</b></th>
                                        <?php if ($_SESSION['base_delivery'] == "dgustsalgados") { ?>
                                            <th style="text-align: center;"><b>Obs </b></th>
                                        <?php } ?>
                                        <?php if (Sessao::get_bot_whatsapp() == 1) : ?>
                                            <th style="text-align: center;"><b>Pix</b></th>
                                        <?php endif; ?>
                                        <!-- <th>Status Pagseguro</th>  -->
                                        <th style="text-align: center;"><b>Status Pedido</b></th>
                                        <th style="text-align: center;"><b>Entregador</b></th>
                                        <th width="200" class="d-print-none" style="text-align: center;"><i class="fa fa-cog"></i> Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalEntrega = 0;
                                    $totalVenda = 0;
                                    foreach ($data['pedido'] as $obj) :

                                        $re_id = $obj->pedido_id;
                                        $resumo = "*RESUMO DO PEDIDO*\n";
                                        $resumo .= "Número do Pedido: $re_id \n";
                                        $resumo .= "Cliente: $obj->cliente_nome \n";
                                        $resumo .= "Telefone: " . ($obj->cliente_fone2 ?? '') . " \n";
                                        $resumo .= "\n";

                                        $re_preco = Currency::moeda($obj->lista_opcao_preco ?? 0);
                                        $carrinho = Carrinho::get_all();

                                        $categoria = $carrinho[0]->categoria_nome ?? "";
                                        $resumo .= "*ITENS*:  $categoria " . ($obj->lista_item_nome ?? '') . " x " . ($obj->lista_qtde ?? 0) . " - R$ $re_preco \n";
                                        if (strip_tags($obj->lista_item_desc ?? '') != '') {
                                            $resumo .= "(" . ($obj->lista_item_desc ?? '') . ")\n";
                                        }
                                        $re_obs = trim($obj->pedido_obs);
                                        $re_obs = ($re_obs != "") ? "Obs: $re_obs \n" : "";
                                        $resumo .= $re_obs;
                                        $resumo .= "\n";

                                        //endereço
                                        $end = $data['endereco'];

                                        if (!empty($end)) {

                                            $compl = ($end->endereco_complemento != "") ? $end->endereco_complemento . " - " : '';
                                            $ref = ($end->endereco_referencia != "") ? " (" . $end->endereco_referencia . ") " : '';
                                            $endereco_full = ucfirst("$end->endereco_endereco, $end->endereco_numero, $compl  $end->endereco_bairro - $end->endereco_cidade $ref  ");

                                            $resumo .= "*LOCAL DE ENTREGA*: \n";
                                            $resumo .= $endereco_full;
                                            $resumo .= "$re_obs \n ";
                                        }
                                        //entrega
                                        $re_obs_pagto = trim($obj->pedido_obs_pagto);
                                        $re_total = Currency::moeda($obj->pedido_total);
                                        $prazo = $obj->pedido_entrega_prazo;

                                        $taxa_entrega = Currency::moeda($obj->pedido_entrega);
                                        $resumo .= "Taxa de entrega: R$  $taxa_entrega \n";
                                        if ($prazo != "") {
                                            $resumo .= "Tempo estimado: $prazo \n";
                                        }
                                        $resumo .= "*Total: R$ $re_total*\n";
                                        $resumo .= "$re_obs_pagto \n";

                                        //APENAS DAS VENDAS NÃO CANCELADAS                                   
                                        if ($obj->pedido_status != 5) {
                                            $totalVenda += $obj->pedido_total - $obj->pedido_entrega;
                                            $totalEntrega += $obj->pedido_entrega;
                                        }

                                        $status = Status::check($obj->pedido_status);
                                        $status_pg = Status::pagseguro($obj->pedido_pagseguro);
                                        $obj->cliente_fone2 = preg_replace('/\D/', '', $obj->cliente_fone2 ?? '');
                                        ?>
                                        <tr id="tr-<?= $obj->pedido_id ?>" data-status="<?= $obj->pedido_status; ?>" data-stat="<?= $obj->pedido_status; ?>" class="status-<?= $obj->pedido_status; ?> status-all">
                                            <td class="bg-<?= $status->color ?>" style="color: #000; vertical-align: middle; text-align: center;"><b><?= $obj->pedido_id ?></b></td>
                                            <td class="bg-<?= $status->color ?>" style="color: #000; vertical-align: middle; text-align: center;"><b><?= str_pad($obj->pedido_numero_entrega, 2, 0, STR_PAD_LEFT) ?></b></td>
                                            <td class="bg-<?= $status->color ?>" style="color: #000; vertical-align: middle; font-size: 11px;">
                                                Pedido: <b>R$ <?= Currency::moeda($obj->pedido_total - $obj->pedido_entrega) ?></b><br>
                                                Entrega: <b>R$ <?= Currency::moeda($obj->pedido_entrega) ?></b><br>
                                                <span style="font-size: 13px; color: #155724;">Total: <b>R$ <?= Currency::moeda($obj->pedido_total) ?></b></span>
                                                <?php if ($obj->pedido_troco > 0): ?>
                                                <br><span style="color: #856404;">Troco: <b>R$ <?= Currency::moeda($obj->pedido_troco) ?></b></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="bg-<?= $status->color ?>" style="color: #000; vertical-align: middle;"><b><?= Timer::parse_date_br($obj->pedido_data) ?></b></td>
                                            <td class="bg-<?= $status->color ?>" style="color: #000; vertical-align: middle; text-align: center;">
                                                <?php 
                                                $pagto_txt = $obj->pedido_obs_pagto ?? '-';
                                                $pagto_lower = strtolower($pagto_txt);
                                                
                                                if (stripos($pagto_lower, 'pix') !== false) {
                                                    echo '<span style="color: #00a884;"><i class="fa fa-qrcode" style="font-size: 16px;"></i></span><br>';
                                                } elseif (stripos($pagto_lower, 'dinheiro') !== false) {
                                                    echo '<span style="color: #2e7d32;"><i class="fa fa-money" style="font-size: 16px;"></i></span><br>';
                                                } elseif (stripos($pagto_lower, 'cartão') !== false || stripos($pagto_lower, 'cartao') !== false || stripos($pagto_lower, 'crédito') !== false || stripos($pagto_lower, 'débito') !== false) {
                                                    echo '<span style="color: #1565c0;"><i class="fa fa-credit-card" style="font-size: 16px;"></i></span><br>';
                                                }
                                                
                                                // Quebra linha no "Troco para" para não alongar muito
                                                $pagto_txt = str_replace(' - Troco', '<br>Troco', $pagto_txt);
                                                ?>
                                                <b><?= $pagto_txt ?></b>
                                            </td>
                                            <td class="bg-<?= $status->color ?>" style="color: #000; vertical-align: middle;">
                                                <b><?= $obj->cliente_nome ?></b>
                                                <?php if (isset($data['clientes_novos'][$obj->pedido_cliente]) && $data['clientes_novos'][$obj->pedido_cliente]): ?>
                                                    <span class="label label-warning" 
                                                          style="background: #ffc107 !important; 
                                                                 color: #000 !important; 
                                                                 margin-left: 5px;
                                                                 font-size: 9px;
                                                                 padding: 2px 5px;
                                                                 border-radius: 3px;
                                                                 vertical-align: middle;"
                                                          data-toggle="tooltip" 
                                                          title="⭐ Cliente Novo! Primeira compra - Capriche no pedido!">
                                                        <i class="fa fa-star"></i> NOVO
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($obj->pedido_tipo != '1'): ?>
                                                    <span class="label label-info" 
                                                          style="background: #17a2b8 !important; 
                                                                 color: #fff !important; 
                                                                 margin-left: 5px;
                                                                 font-size: 9px;
                                                                 padding: 2px 5px;
                                                                 border-radius: 3px;
                                                                 vertical-align: middle;"
                                                          data-toggle="tooltip" 
                                                          title="Pedido lançado manualmente">
                                                        <i class="fa fa-pencil"></i> MANUAL
                                                    </span>
                                                <?php endif; ?>
                                                <br><?php 
                                                    $fone = preg_replace('/\D/', '', $obj->cliente_fone2 ?? '');
                                                    if (strlen($fone) == 11) {
                                                        echo '(' . substr($fone, 0, 2) . ') ' . substr($fone, 2, 5) . '-' . substr($fone, 7);
                                                    } elseif (strlen($fone) == 10) {
                                                        echo '(' . substr($fone, 0, 2) . ') ' . substr($fone, 2, 4) . '-' . substr($fone, 6);
                                                    } else {
                                                        echo $obj->cliente_fone2;
                                                    }
                                                ?>
                                            </td>
                                            <?php if ($_SESSION['base_delivery'] == "dgustsalgados") { ?>
                                                <td class="bg-<?= $status->color ?>" style="color: #000; vertical-align: middle; text-align: center;"><b><?= $obj->pedido_obs ?></b></td>
                                            <?php } ?>                                            
                                            <?php if (Sessao::get_bot_whatsapp() == 1) : ?>
                                            <!-- 💳 STATUS PIX (somente se bot ativo) -->
                                            <td class="bg-<?= $status->color ?>" style="vertical-align: middle; text-align: center;">
                                                <?php 
                                                // Verificar se é pagamento Pix
                                                $is_pix = ($obj->pedido_id_pagto == 4 || stripos($obj->pedido_obs_pagto ?? '', 'pix') !== false);
                                                
                                                if (Sessao::get_bot_whatsapp() == 1 && $is_pix) {
                                                    if ($obj->pedido_comprovante_validado == 1) {
                                                        // Comprovante validado - clicável para ver comprovante
                                                        echo '<a href="#" class="btn-ver-comprovante" data-pedido-id="' . $obj->pedido_id . '" style="text-decoration: none; cursor: pointer;">';
                                                        echo '<span class="label label-success" data-toggle="tooltip" title="Clique para ver o comprovante validado em ' . date('d/m/Y H:i', strtotime($obj->pedido_comprovante_validado_em ?? '')) . '">';
                                                        echo '<i class="fa fa-check-circle"></i> Pago';
                                                        echo '</span>';
                                                        echo '</a>';
                                                    } else {
                                                        // Se cancelado, não mostrar opções de validação
                                                        if ($obj->pedido_status == 5) {
                                                            echo '<span class="label label-default"><i class="fa fa-ban"></i> Cancelado</span>';
                                                        } else {
                                                            // Verificar se tem comprovante aguardando validação
                                                            $db_check = new DB();
                                                            $pdo_check = $db_check->getCon();
                                                            $query_check = $pdo_check->prepare("
                                                                SELECT COUNT(*) as total 
                                                                FROM pedido_comprovantes 
                                                                WHERE comprovante_pedido_id = :pedido_id 
                                                                AND comprovante_validado = 0
                                                            ");
                                                            $query_check->execute([':pedido_id' => $obj->pedido_id]);
                                                            $tem_comprovante_pendente = $query_check->fetch(PDO::FETCH_ASSOC)['total'] == 0;
                                                            
                                                            if ($tem_comprovante_pendente) {
                                                                // Badge amarelo: Pendente
                                                                echo '<span class="label label-warning" style="display: block; margin-bottom: 5px;">';
                                                                echo '<i class="fa fa-clock-o"></i> Aguardando pagamento...';
                                                                echo '</span>';
                                                            }
                                                            
                                                            // Botão de validação manual
                                                            echo '<button type="button" class="btn btn-success btn-xs btn-validar-pix-manual" ';
                                                            echo 'data-pedido-id="' . $obj->pedido_id . '" ';
                                                            echo 'data-toggle="tooltip" ';
                                                            echo 'title="Validar pagamento Pix manualmente">';
                                                            echo '<i class="fa fa-check"></i> Validar Pix';
                                                            echo '</button>';
                                                        }
                                                    }
                                                } else {
                                                    echo '<span class="text-muted">-</span>';
                                                }
                                                ?>
                                            </td>
                                            <?php endif; ?>
                                            
                                            <!-- <td width="170" class="bg-$status_pg->color">$status_pg->icon</td> -->
                                            <td width="170" class="bg-<?= $status->color ?> col-status-pedido" style="color: #000; vertical-align: middle;"><?= $status->icon ?></b></td>
                                            <td class="bg-<?= $status->color ?> col-entregador" style="color: #000; vertical-align: middle;">
                                                <?php if ($obj->entregador_nome != '') : ?>
                                                    <i class="fa fa-motorcycle" aria-hidden="true"></i> <?= $obj->entregador_nome ?>
                                                    <?php if (Sessao::get_bot_whatsapp() == 1 && isset($obj->bot_status) && $obj->bot_status == 'aceito') : ?>
                                                        <span class="label label-success" style="font-size: 9px; display: block; background-color: #25D366 !important; margin-top: 2px; padding: 1px 5px;">
                                                            <i class="fa fa-check"></i> Aceito via Bot
                                                        </span>
                                                    <?php endif; ?>
                                                <?php elseif (Sessao::get_bot_whatsapp() == 1 && isset($obj->bot_status)) : ?>
                                                    <?php if ($obj->bot_status == 'notificado') : ?>
                                                        <span class="label label-info" style="font-size: 10px; display: block; margin-bottom: 2px;">
                                                            <i class="fa fa-whatsapp"></i> Notificado...
                                                        </span>
                                                        <small class="text-muted" style="font-size: 9px;">Aguardando aceite</small>
                                                    <?php elseif ($obj->bot_status == 'aceito') : ?>
                                                        <span class="label label-success" style="font-size: 10px; display: block; background-color: #25D366 !important; margin-bottom: 2px;">
                                                            <i class="fa fa-check"></i> <?= $obj->bot_entregador_nome ?>
                                                        </span>
                                                        <small class="text-success" style="font-size: 9px; font-weight: bold;">A caminho / Retirando</small>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <span class="text-muted" style="font-size: 11px;">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center d-print-none" style="vertical-align: middle; padding: 4px;">
                                                <div class="btn-group">
                                                    <?php if (Sessao::get_bot_whatsapp() == 1) : ?>
                                                    <!-- WhatsApp -->
                                                    <a href="https://api.whatsapp.com/send?phone=55<?= $obj->cliente_fone2 ?? '' ?>" 
                                                       data-toggle="tooltip" title="WhatsApp" target="_blank" 
                                                       class="btn btn-xs" style="background: #25D366; color: #fff;">
                                                        <i class="fa fa-whatsapp"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                    
                                                    <!-- Imprimir -->
                                                    <a class="btn btn-xs btn-warning" href="javascript:void(0)" 
                                                       onclick="imprimirPedido(<?= $obj->pedido_id ?>, false)" 
                                                       data-toggle="tooltip" title="Imprimir">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                    
                                                    <!-- Ver Detalhes -->
                                                    <a href="<?= $baseUri ?>/admin/pedido/<?= $obj->pedido_id ?>/" 
                                                       class="btn btn-xs" style="background: #667eea; color: #fff;"
                                                       data-toggle="tooltip" title="Ver detalhes">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    
                                                    <!-- Dropdown Mais Ações -->
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-xs btn-default dropdown-toggle" 
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                                style="padding: 5px 8px;">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right" style="min-width: 180px;">
                                                            <?php if (Sessao::get_bot_whatsapp() == 1) : ?>
                                                            <li>
                                                                <a href="#" class="btn-ver-chat-historico" 
                                                                   data-pedido-id="<?= $obj->pedido_id ?>" 
                                                                   data-cliente-nome="<?= $obj->cliente_nome ?>">
                                                                    <i class="fa fa-comments text-info"></i> Histórico Chat
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="btn-atendimento-manual" 
                                                                   data-cliente-fone="<?= $obj->cliente_fone2 ?? '' ?>" 
                                                                   data-pedido-id="<?= $obj->pedido_id ?>">
                                                                    <i class="fa fa-user text-primary"></i> Atendimento Manual
                                                                </a>
                                                            </li>
                                                            <?php endif; ?>
                                                            <li>
                                                                <a href="#" class="btn-ver-itens-pedido" data-pedido-id="<?= $obj->pedido_id ?>">
                                                                    <i class="fa fa-shopping-cart text-success"></i> Ver Itens
                                                                </a>
                                                            </li>
                                                            <?php if ($obj->pedido_id_pagto == 4 && $data['config']->config_pix_automatico == 1) { ?>
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="imprimirPedido(<?= $obj->pedido_id ?>, true)">
                                                                    <i class="fa fa-file-text text-warning"></i> Imprimir Pix
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <?php 
                                                            $is_pix = ($obj->pedido_id_pagto == 4 || stripos($obj->pedido_obs_pagto ?? '', 'pix') !== false);
                                                            if (Sessao::get_bot_whatsapp() == 1 && $is_pix && $obj->pedido_comprovante_validado == 1) {
                                                                $db_check = new DB();
                                                                $pdo_check = $db_check->getCon();
                                                                $query_check = $pdo_check->prepare("SELECT COUNT(*) as total FROM pedido_comprovantes WHERE comprovante_pedido_id = :pedido_id");
                                                                $query_check->execute([':pedido_id' => $obj->pedido_id]);
                                                                if ($query_check->fetch(PDO::FETCH_ASSOC)['total'] > 0) {
                                                            ?>
                                                            <li>
                                                                <a href="#" class="btn-ver-comprovante" data-pedido-id="<?= $obj->pedido_id ?>">
                                                                    <i class="fa fa-file-image-o text-success"></i> Ver Comprovante
                                                                </a>
                                                            </li>
                                                            <?php }} ?>
                                                            <?php if($obj->pedido_status != 5){ ?>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a href="#" class="btn-entrega btn-status-change" 
                                                                   data-id="<?= $obj->pedido_id ?>" data-cliente="<?= $obj->cliente_id ?>">
                                                                    <i class="fa fa-motorcycle text-warning"></i> Rota de Entrega
                                                                </a>
                                                            </li>
                                                            <?php if (Sessao::get_bot_whatsapp() == 1 && in_array($obj->pedido_status, [2, 9])) : // Em Produção ou Pronto ?>
                                                            <li>
                                                                <a href="#" class="btn-notificar-entregador" 
                                                                   data-pedido-id="<?= $obj->pedido_id ?>">
                                                                    <i class="fa fa-whatsapp" style="color: #25D366;"></i> Notificar Entregador
                                                                </a>
                                                            </li>
                                                            <?php endif; ?>
                                                            <li>
                                                                <a href="#" class="btn-entregue btn-status-change" 
                                                                   data-id="<?= $obj->pedido_id ?>" data-cliente="<?= $obj->cliente_id ?>">
                                                                    <i class="fa fa-check-circle text-success"></i> Confirmar Entrega
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="btn-cancelado btn-status-change" 
                                                                   data-id="<?= $obj->pedido_id ?>" data-cliente="<?= $obj->cliente_id ?>">
                                                                    <i class="fa fa-ban text-danger"></i> Cancelar Pedido
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <?php if (Sessao::get_nivel() == 1) { ?>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a href="#" class="btn-remover" data-id="<?= $obj->pedido_id ?>">
                                                                    <i class="fa fa-trash text-danger"></i> Excluir Pedido
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th style="text-align: right;">Totais:</th>
                                        <th style="font-size: 11px;">
                                            Pedido: <b>R$ <?= Currency::moeda($totalVenda) ?></b><br>
                                            Entrega: <b>R$ <?= Currency::moeda($totalEntrega) ?></b><br>
                                            <span style="font-size: 13px; color: #155724;">Total: <b>R$ <?= Currency::moeda($totalVenda + $totalEntrega) ?></b></span>
                                        </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <?php if ($_SESSION['base_delivery'] == "dgustsalgados") { ?>
                                            <th></th>
                                        <?php } ?>
                                        <?php if (Sessao::get_bot_whatsapp() == 1) : ?>
                                            <th></th>
                                        <?php endif; ?>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <hr>
                        <h4><b>Formas de Pgto</b></h4>
                        <table class="datatable display nowrap table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Pagamento</th>
                                    <th>Valor</th>
                                    <th>Valor Entrega</th>
                                    <th>Valor Recebido</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                $totalPagamento = 0 ;
                                $totalEntrega = 0 ;
                                $totalPagamentoComEntrga = 0 ;
                                
                                foreach ($data['forma_pgto'] as $r) {

                                if ($r->pedido_status != 5) {
                                    $totalPagamento += $r->valor;
                                    $totalEntrega += $r->valor_entrega;
                                    $totalPagamentoComEntrga += $r->valor + $r->valor_entrega;
                                }
                                ?>
                                    <tr>
                                        <td><?= $r->pedido_obs_pagto ?></td>
                                        <td>R$ <?= Currency::moeda($r->valor) ?></td>
                                        <td>R$ <?= Currency::moeda($r->valor_entrega) ?></td>
                                        <td>R$ <?= Currency::moeda($r->valor + $r->valor_entrega) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <th style="text-align: right;">Total</th>
                                <th>R$ <?= Currency::moeda($totalPagamento) ?></th>
                                <th>R$ <?= Currency::moeda($totalEntrega) ?></th>
                                <th>R$ <?= Currency::moeda($totalPagamentoComEntrga) ?></th>
                            </tfoot>
                        </table>
                        <?php
                        if ($data['entrega'] != '') {
                        ?>
                            <hr>
                            <h4><b>Entregadores</b></h4>
                            <table class="datatable display nowrap table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Entregador</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $totalEntregador = 0;
                                    foreach ($data['entrega'] as $r) {

                                        $totalEntregador += $r->total;
                                    ?>
                                        <tr>
                                            <td><?= $r->entregador_nome ?></td>
                                            <td>R$ <?= Currency::moeda($r->total) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <th style="text-align: right;">Total</th>
                                    <th>R$ <?= Currency::moeda($totalEntregador) ?></th>
                                </tfoot>
                            </table>
                        <?php } ?>
                    <?php else : ?>
                        <h3 class="text-center">Nenhum pedido novo!</h3>
                    <?php endif; ?>
                    </div> <!-- Fecha padding container -->
                </div>
            </div>
        </div>
        <!-- MODAL REMOVER -->
        <div class="modal fade colored-header warning md-effect-10" id="modal-remove" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Remover Registro</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                            <h4>Atenção!</h4>
                            <p>Você está prestes à remover um registro e esta ação não pode ser desfeita. <br />
                                Deseja realmente prosseguir?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form name="form-remove" id="form-remove" action="<?php echo $baseUri; ?>/admin/pedido_remove/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-warning btn-flat btn-confirma-remove">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- MODAL SAIU PARA ENTREGA -->
        <div class="modal fade colored-header warning md-effect-10" id="modal-entrega" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Update Pedido</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <form name="form-entrega" id="form-entrega" action="<?php echo $baseUri; ?>/admin/pedido_entrega/" method="post">
                        <div class="modal-body">
                            <div class="text-center">
                                <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                                <h4>Saiu para entrega?</h4>
                                <select class="form-control input-lg" name="pedido_entregador" id="pedido_entregador">
                                    <option value="0">SELECIONE O ENTREGADOR:</option>
                                    <?php foreach ($data['entregador'] as $obj) : ?>
                                        <option value="<?= $obj->entregador_id ?>"><?= $obj->entregador_nome ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-warning btn-flat btn-confirma-entrega">Prosseguir</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- MODAL ENTREGUE -->
        <div class="modal fade colored-header warning md-effect-10" id="modal-entregue" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Update pedido</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                            <h4>O pedido foi entregue?</h4>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form name="form-entregue" id="form-entregue" action="<?php echo $baseUri; ?>/admin/pedido_entregue/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-warning btn-flat btn-confirma-entregue">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- MODAL CANCELADO -->
        <div class="modal fade colored-header warning md-effect-10" id="modal-cancelado" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Cancelar Pedido</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                            <h4>O pedido foi cancelado?</h4>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form name="form-cancelado" id="form-cancelado" action="<?php echo $baseUri; ?>/admin/pedido_cancelado/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-warning btn-flat btn-confirma-cancelado">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <!-- MODAL NOTIFICAR ENTREGADOR -->
        <div class="modal fade colored-header md-effect-10" id="modal-notificar-entregador" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: white; border: none;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                        <h3 style="margin: 0;"><i class="fa fa-whatsapp"></i> Notificar Entregador</h3>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="i-circle" style="background: #25D366; color: white; margin: 0 auto;"><i class="fa fa-motorcycle"></i></div>
                            <h4 style="margin-top: 20px;">Selecione o entregador para notificar</h4>
                            <p style="color: #666; font-size: 14px; margin-bottom: 25px;">O entregador receberá os dados completos do pedido via WhatsApp</p>
                            
                            <select class="form-control input-lg" id="select-entregador" style="font-size: 16px; height: 50px; border: 2px solid #ddd; border-radius: 8px;">
                                <option value="">SELECIONE O ENTREGADOR:</option>
                                <?php foreach ($data['entregador'] as $obj) : ?>
                                    <option value="<?= $obj->entregador_id ?>">
                                        <?= $obj->entregador_nome ?>
                                        <?php if (!empty($obj->entregador_fone)) : ?>
                                            - <?= $obj->entregador_fone ?>
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            
                            <div id="notificar-loading" style="display: none; margin-top: 20px;">
                                <i class="fa fa-spinner fa-spin fa-2x" style="color: #25D366;"></i>
                                <p style="margin-top: 10px; color: #666;">Enviando notificação...</p>
                            </div>
                            
                            <div id="notificar-success" style="display: none; margin-top: 20px; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px;">
                                <i class="fa fa-check-circle" style="color: #155724; font-size: 24px;"></i>
                                <p style="margin: 10px 0 5px 0; color: #155724; font-weight: bold;">Notificação enviada!</p>
                                <p style="margin: 0; color: #155724; font-size: 13px;" id="notificar-success-msg"></p>
                            </div>
                            
                            <div id="notificar-error" style="display: none; margin-top: 20px; padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px;">
                                <i class="fa fa-exclamation-triangle" style="color: #721c24; font-size: 24px;"></i>
                                <p style="margin: 10px 0 0 0; color: #721c24; font-weight: bold;" id="notificar-error-msg"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-flat" id="btn-confirmar-notificar" style="background: #25D366; color: white;">
                            <i class="fa fa-whatsapp"></i> Enviar Notificação
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <!-- MODAL VER COMPROVANTE PIX -->
        <div class="modal fade" id="modal-comprovante-pix" tabindex="-1" role="dialog">
            <div class="modal-dialog" style="width: 90%; max-width: 1200px;">
                <div class="modal-content">
                    <div class="modal-header" style="background: #28a745; color: white;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.8;">
                            <span>&times;</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-file-image-o"></i> Comprovantes Pix - Pedido #<span id="modal-pedido-numero"></span>
                        </h4>
                    </div>
                    <div class="modal-body" style="min-height: 400px; max-height: 80vh; overflow-y: auto;">
                        <!-- Loading -->
                        <div id="comprovante-loading" class="text-center" style="padding: 50px;">
                            <i class="fa fa-spinner fa-spin fa-3x" style="color: #28a745;"></i>
                            <p style="margin-top: 20px; font-size: 16px;">Carregando comprovante...</p>
                        </div>
                        
                        <!-- Erro -->
                        <div id="comprovante-erro" class="alert alert-danger" style="display: none;">
                            <i class="fa fa-exclamation-triangle"></i> 
                            <strong>Erro:</strong> Não foi possível carregar o comprovante.
                        </div>
                        
                        <!-- Conteúdo -->
                        <div id="comprovante-content" style="display: none;">
                            <!-- Galeria de comprovantes -->
                            <div id="comprovantes-galeria">
                                <!-- Será preenchido via JavaScript -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times"></i> Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal -->
        
        <!-- MODAL HISTÓRICO DO CHAT -->
        <div class="modal fade" id="modal-chat-historico" tabindex="-1" role="dialog">
            <div class="modal-dialog" style="width: 95%; max-width: 1000px; margin: 20px auto;">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: white; border-radius: 8px 8px 0 0; padding: 20px 25px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1; font-size: 28px; font-weight: 300; text-shadow: none; margin-top: -5px;">
                            <span>&times;</span>
                        </button>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-whatsapp" style="font-size: 24px;"></i>
                            </div>
                            <div>
                                <h4 class="modal-title" style="margin: 0; font-size: 20px; font-weight: 600;">
                                    Chat - Pedido #<span id="modal-chat-pedido-numero"></span>
                                </h4>
                                <small style="opacity: 0.95; font-size: 13px; display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                                    <i class="fa fa-user" style="font-size: 11px;"></i>
                                    <span id="modal-chat-cliente-nome"></span>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" style="padding: 0; background: #f8f9fa; min-height: 400px; border-radius: 0 0 8px 8px;">
                        <!-- Loading Moderno -->
                        <div id="chat-loading" class="text-center" style="padding: 60px 20px;">
                            <div style="display: inline-block; position: relative;">
                                <i class="fa fa-circle-o-notch fa-spin" style="font-size: 48px; color: #25D366;"></i>
                            </div>
                            <p style="margin-top: 24px; font-size: 15px; color: #6c757d; font-weight: 500;">Carregando conversa...</p>
                        </div>
                        
                        <!-- Erro Moderno -->
                        <div id="chat-erro" style="display: none; margin: 30px; background: white; padding: 30px; border-radius: 8px; border-left: 4px solid #dc3545;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <i class="fa fa-exclamation-circle" style="font-size: 32px; color: #dc3545;"></i>
                                <div>
                                    <strong style="font-size: 16px; color: #dc3545;">Erro ao carregar</strong>
                                    <p style="margin: 5px 0 0 0; color: #6c757d;">Não foi possível carregar o histórico do chat.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Container do chat -->
                        <div id="chat-container" style="display: none;">
                            <!-- Info Header - Mais Limpo e Moderno -->
                            <div style="background: white; padding: 16px 20px; border-bottom: 1px solid #e9ecef; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="background: #e7f5ff; padding: 6px 12px; border-radius: 6px; display: flex; align-items: center; gap: 8px;">
                                            <i class="fa fa-comments" style="color: #1971c2; font-size: 14px;"></i>
                                            <span style="font-weight: 600; color: #1971c2; font-size: 14px;">
                                                <span id="chat-total-mensagens"></span> mensagem(ns)
                                            </span>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 6px; color: #868e96; font-size: 12px;">
                                        <i class="fa fa-sync" style="animation: spin-slow 3s linear infinite;"></i>
                                        <span>Atualização automática</span>
                                    </div>
                                </div>
                                <!-- Legenda - Mais Moderna -->
                                <div style="display: flex; gap: 12px; flex-wrap: wrap; font-size: 11px;">
                                    <div style="display: flex; align-items: center; gap: 6px; background: #f8f9fa; padding: 4px 10px; border-radius: 12px;">
                                        <span style="display: inline-block; width: 8px; height: 8px; background: #E5E5EA; border-radius: 50%;"></span>
                                        <span style="color: #495057;">Cliente</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 6px; background: #f8f9fa; padding: 4px 10px; border-radius: 12px;">
                                        <span style="display: inline-block; width: 8px; height: 8px; background: #DCF8C6; border-radius: 50%;"></span>
                                        <span style="color: #495057;">Bot</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 6px; background: #f8f9fa; padding: 4px 10px; border-radius: 12px;">
                                        <span style="display: inline-block; width: 8px; height: 8px; background: #007AFF; border-radius: 50%;"></span>
                                        <span style="color: #495057;">Você</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Mensagens do chat - Background e Scroll melhorados -->
                            <div id="chat-mensagens" style="max-height: 500px; overflow-y: auto; padding: 20px; background: linear-gradient(to bottom, #f8f9fa 0%, #e9ecef 100%);">
                                <!-- Será preenchido via JavaScript -->
                            </div>
                        </div>
                        
                        <!-- Vazio - Mais Atrativo -->
                        <div id="chat-vazio" class="text-center" style="display: none; padding: 80px 20px; background: white; margin: 20px; border-radius: 12px;">
                            <div style="background: #f8f9fa; width: 100px; height: 100px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                                <i class="fa fa-comment-o" style="font-size: 48px; color: #adb5bd;"></i>
                            </div>
                            <h4 style="color: #495057; font-weight: 600; margin-bottom: 8px;">Nenhuma mensagem</h4>
                            <p style="color: #868e96; font-size: 14px;">Este pedido ainda não possui histórico de conversa.</p>
                        </div>
                    </div>
                    
                    <!-- 💬 Campo de Resposta do Atendente - Modernizado -->
                    <div id="chat-responder" style="display: none; background: white; padding: 20px; border-top: 1px solid #dee2e6; position: relative;">
                        <!-- Banner de Sessão Ativa - Compacto -->
                        <div style="background: #d1f4e0; border-left: 3px solid #25D366; padding: 6px 12px; border-radius: 4px; margin-bottom: 12px; display: inline-flex; align-items: center; gap: 8px; font-size: 11px;">
                            <i class="fa fa-check-circle" style="color: #25D366; font-size: 12px;"></i>
                            <span style="color: #087f5b; font-weight: 600;">Sessão Ativa</span>
                            <span id="chat-sessao-info" style="color: #20c997;"></span>
                        </div>
                        
                        <!-- Emoji Picker Popup - Movido para cima -->
                        <div id="emoji-picker" style="display: none; position: absolute; bottom: 85px; left: 20px; background: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.2); z-index: 1050; max-width: 320px;">
                            <div style="display: grid; grid-template-columns: repeat(8, 1fr); gap: 4px; max-height: 200px; overflow-y: auto;">
                                <!-- Emojis comuns para atendimento -->
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">👍</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">👎</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😊</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😃</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😄</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😅</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😁</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🙂</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🙃</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😉</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😍</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🥰</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😘</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😎</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🤗</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🤔</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😐</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😕</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😢</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😭</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">😡</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🤝</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🙏</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">👏</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">✅</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">❌</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">⚠️</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">⭐</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">💯</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🎉</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🎊</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🔥</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">💚</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">❤️</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🍕</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🍔</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🍟</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🥤</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🚚</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">🏍️</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">⏰</button>
                                <button class="emoji-btn" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 4px; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='none'">📦</button>
                            </div>
                        </div>
                        
                        <!-- Input com Emoji Picker -->
                        <div style="display: flex; gap: 8px; align-items: flex-end;">
                            <!-- Botão de Emoji -->
                            <button type="button" 
                                    id="btn-emoji-picker" 
                                    class="btn"
                                    style="background: #f8f9fa; color: #6c757d; border: 2px solid #e9ecef; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; font-size: 20px; padding: 0;"
                                    onmouseover="this.style.background='#e9ecef'"
                                    onmouseout="this.style.background='#f8f9fa'"
                                    title="Adicionar emoji">
                                😊
                            </button>
                            
                            <!-- Input de Mensagem -->
                            <div style="flex: 1; position: relative;">
                                <input type="text" 
                                       id="chat-mensagem-input" 
                                       class="form-control" 
                                       placeholder="Digite sua mensagem..." 
                                       style="border: 2px solid #e9ecef; border-radius: 20px; padding: 10px 18px; font-size: 14px; transition: all 0.2s; box-shadow: none;"
                                       onfocus="this.style.borderColor='#25D366'"
                                       onblur="this.style.borderColor='#e9ecef'">
                            </div>
                            
                            <!-- Botão de Enviar - Menor -->
                            <button type="button" 
                                    id="btn-enviar-resposta" 
                                    class="btn" 
                                    style="background: #25D366; color: white; border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(37, 211, 102, 0.3); transition: all 0.2s; padding: 0;"
                                    onmouseover="this.style.background='#128C7E'; this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.background='#25D366'; this.style.transform='scale(1)'">
                                <i class="fa fa-paper-plane" style="font-size: 14px;"></i>
                            </button>
                            
                            <!-- Botão Finalizar Atendimento -->
                            <button type="button" 
                                    id="btn-finalizar-atendimento-pedidos" 
                                    class="btn btn-danger" 
                                    style="background: #dc3545; border: none; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 5px; white-space: nowrap;"
                                    title="Finalizar atendimento e retomar bot automático">
                                <i class="fa fa-times-circle"></i>
                                Encerrar
                            </button>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px; color: #868e96; font-size: 11px;">
                            <i class="fa fa-whatsapp"></i>
                            <span>Enviado via WhatsApp</span>
                        </div>
                    </div>
                    
                    <div class="modal-footer" style="border: none; padding: 16px 24px; background: #f8f9fa; border-radius: 0 0 8px 8px;">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 8px 20px; border: 1px solid #dee2e6;">
                            <i class="fa fa-times"></i> Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal -->
        
        <!-- CSS Adicional para Animações e Melhorias UI -->
        <style>
            /* Animação suave para atualização automática */
            @keyframes spin-slow {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            
            /* Scrollbar customizada para área de mensagens */
            #chat-mensagens::-webkit-scrollbar {
                width: 8px;
            }
            
            #chat-mensagens::-webkit-scrollbar-track {
                background: transparent;
            }
            
            #chat-mensagens::-webkit-scrollbar-thumb {
                background: rgba(0,0,0,0.2);
                border-radius: 10px;
            }
            
            #chat-mensagens::-webkit-scrollbar-thumb:hover {
                background: rgba(0,0,0,0.3);
            }
            
            /* Efeito hover no botão de enviar */
            #btn-enviar-resposta:active {
                transform: scale(0.95) !important;
            }
            
            /* Animação para o modal */
            #modal-chat-historico .modal-dialog {
                transition: transform 0.3s ease-out;
            }
            
            /* Estilo para as bolhas de mensagem (aprimoradas) */
            .chat-bolha-cliente {
                background: #E5E5EA;
                color: #000;
                border-radius: 18px 18px 18px 4px;
                padding: 10px 14px;
                max-width: 70%;
                margin: 6px 0;
                word-wrap: break-word;
                box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            }
            
            .chat-bolha-bot {
                background: #DCF8C6;
                color: #000;
                border-radius: 18px 18px 18px 4px;
                padding: 10px 14px;
                max-width: 70%;
                margin: 6px 0;
                word-wrap: break-word;
                box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            }
            
            .chat-bolha-atendente {
                background: #007AFF;
                color: #fff;
                border-radius: 18px 18px 4px 18px;
                padding: 10px 14px;
                max-width: 70%;
                margin: 6px 0;
                margin-left: auto;
                word-wrap: break-word;
                box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            }
            
            /* Foco no input de mensagem */
            #chat-mensagem-input:focus {
                outline: none !important;
                box-shadow: 0 0 0 3px rgba(37, 211, 102, 0.1) !important;
            }
            
            /* Emoji Picker Scrollbar */
            #emoji-picker > div::-webkit-scrollbar {
                width: 6px;
            }
            
            #emoji-picker > div::-webkit-scrollbar-track {
                background: #f8f9fa;
                border-radius: 10px;
            }
            
            #emoji-picker > div::-webkit-scrollbar-thumb {
                background: #dee2e6;
                border-radius: 10px;
            }
            
            #emoji-picker > div::-webkit-scrollbar-thumb:hover {
                background: #adb5bd;
            }
        </style>
        
        <script src="js/jquery.cooki/jquery.cooki.js"></script>
        <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
        <script type="text/javascript" src="js/behaviour/core.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.switch/bootstrap-switch.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script src="js/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="js/datatables-button/dataTables.buttons.min.js"></script>
        <script src="js/datatables-button/buttons.flash.min.js"></script>
        <script src="js/datatables-button/jszip.min.js"></script>
        <script src="js/datatables-button/pdfmake.min.js"></script>
        <script src="js/datatables-button/vfs_fonts.js"></script>
        <script src="js/datatables-button/buttons.html5.min.js"></script>
        <script src="js/datatables-button/buttons.print.min.js"></script>
        <script type="text/javascript">
            var bell = '<?= (isset($data['config']) && $data['config']->config_bell == 1) ? 'true' : 'false' ?>';
            var empresa = "<?= $_SESSION['base_delivery'] ?>";
            var idcliente = <?= isset($data['pedido'][0]->pedido_cliente) ? $data['pedido'][0]->pedido_cliente : 0 ?>;
            var pedido_id_pagto = <?= isset($data['pedido'][0]->pedido_id_pagto) ? $data['pedido'][0]->pedido_id_pagto : 0 ?>;
            var baseUrl = '<?php echo $baseUri; ?>';
        </script>
        <script src="app-js/main.js?v=<?= time() ?>"></script>
        <script src="app-js/datatables.js"></script>
        <script src="app-js/pedido.js?v=<?= time() ?>"></script>
        <!-- CALENDAR JS -->
        <script src="js/cupom-desconto/moment.js"></script>
        <script src="js/cupom-desconto/moment-pt-br.js"></script>
        <script src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.data-inicio, .data-fim').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
                
                // 📋 Posicionar dropdown corretamente quando usa position fixed
                $(document).on('show.bs.dropdown', '.datatable .btn-group', function(e) {
                    var $btnGroup = $(this);
                    var $dropdown = $btnGroup.find('.dropdown-menu');
                    var $button = $btnGroup.find('.dropdown-toggle');
                                    
                    // Aguardar o dropdown ser renderizado
                    setTimeout(function() {
                        // Pegar offset real do botão na tela
                        var buttonRect = $button[0].getBoundingClientRect();
                        var dropdownWidth = $dropdown.outerWidth();
                        var dropdownHeight = $dropdown.outerHeight();
                                        
                        // Calcular posição - alinhar à direita do botão
                        var top = buttonRect.bottom + 2; // Logo abaixo do botão
                        var left = buttonRect.right - dropdownWidth; // Alinhado à direita
                                        
                        // Verificar se cabe na tela (para baixo)
                        var windowHeight = window.innerHeight;
                                        
                        if (top + dropdownHeight > windowHeight) {
                            // Abrir para cima
                            top = buttonRect.top - dropdownHeight - 2;
                        }
                                        
                        // Verificar se cabe na tela (lateral esquerda)
                        if (left < 5) {
                            left = buttonRect.left; // Alinhar à esquerda do botão
                        }
                                        
                        // Aplicar posição
                        $dropdown.css({
                            'position': 'fixed',
                            'top': top + 'px',
                            'left': left + 'px',
                            'right': 'auto',
                            'bottom': 'auto',
                            'transform': 'none'
                        });
                    }, 10);
                });
                
                // Fechar dropdown quando rolar a página
                $(window).on('scroll', function() {
                    $('.datatable .btn-group.open').removeClass('open');
                });
            });

            $('#menu-pedido').addClass('active');
            <?php if (isset($_GET['success'])) : ?>
                _alert_success();
            <?php endif; ?>
            
            // 🎯 FILTRO DE STATUS COM CHIPS MODERNOS
            $('.filter-chip').on('click', function() {
                var status = $(this).data('status');
                
                // Remover classe active de todos os chips
                $('.filter-chip').removeClass('active');
                
                // Adicionar classe active no chip clicado
                $(this).addClass('active');
                
                if (status == 0) {
                    $('.status-all').fadeIn(200);
                } else {
                    $('.status-all').fadeOut(100);
                    setTimeout(function() {
                        $('.status-' + status).fadeIn(200);
                    }, 100);
                }
            });
            
            // Manter compatibilidade com botões antigos
            $('.btn-status').on('click', function() {
                var status = $(this).data('status');
                if (status == 0) {
                    $('.status-all').fadeIn();
                } else {
                    $('.status-all').fadeOut();
                    $('.status-' + status).fadeIn();
                }
            });
            
            // 💳 BOTÃO VER COMPROVANTE PIX
            $(document).on('click', '.btn-ver-comprovante', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var pedidoId = $(this).data('pedido-id');
                                
                // Resetar modal
                $('#modal-pedido-numero').text(pedidoId);
                $('#comprovante-loading').show();
                $('#comprovante-erro').hide();
                $('#comprovante-content').hide();
                
                // Abrir modal
                $('#modal-comprovante-pix').modal('show');
                
                // Carregar dados dos comprovantes
                $.ajax({
                    url: baseUrl + '/admin/get-comprovante-pix/',
                    method: 'POST',
                    data: { pedido_id: pedidoId },
                    dataType: 'json',
                    success: function(response) {
                        
                        if (response.success && response.comprovantes && response.comprovantes.length > 0) {
                            var galeriaHtml = '';
                            
                            // Cabeçalho
                            galeriaHtml += '<div class="alert alert-info" style="margin-bottom: 20px;">';
                            galeriaHtml += '<i class="fa fa-info-circle"></i> ';
                            galeriaHtml += '<strong>' + response.total + ' comprovante(s)</strong> enviado(s) pelo cliente para este pedido.';
                            galeriaHtml += '</div>';
                            
                            // Percorrer todos os comprovantes
                            response.comprovantes.forEach(function(comp, index) {
                                var statusClass = comp.validado ? 'success' : 'danger';
                                var statusIcon = comp.validado ? 'check-circle' : 'times-circle';
                                var statusTexto = comp.validado ? 'VALIDADO' : 'INVÁLIDO';
                                
                                galeriaHtml += '<div class="panel panel-' + statusClass + '" style="margin-bottom: 20px;">';
                                
                                // Cabeçalho do card
                                galeriaHtml += '<div class="panel-heading">';
                                galeriaHtml += '<h4 class="panel-title">';
                                galeriaHtml += '<i class="fa fa-' + statusIcon + '"></i> ';
                                galeriaHtml += 'Comprovante #' + (index + 1) + ' - ';
                                galeriaHtml += '<span class="label label-' + statusClass + '">' + statusTexto + '</span> ';
                                galeriaHtml += '<small style="color: #666; margin-left: 10px;">Enviado em: ' + comp.data_upload + '</small>';
                                galeriaHtml += '</h4>';
                                galeriaHtml += '</div>';
                                
                                // Corpo do card
                                galeriaHtml += '<div class="panel-body">';
                                galeriaHtml += '<div class="row">';
                                
                                // Coluna da imagem (esquerda) - AUMENTADA de col-md-7 para col-md-9
                                galeriaHtml += '<div class="col-md-9">';
                                galeriaHtml += '<div style="text-align: center; background: #f5f5f5; padding: 15px; border-radius: 5px;">';
                                                                
                                // Verificar se é PDF ou imagem (usar campo is_pdf do backend)
                                var isPdf = comp.is_pdf || comp.imagem_url.toLowerCase().endsWith('.pdf');
                                                                
                                if (isPdf) {
                                    // Exibir PDF em iframe
                                    galeriaHtml += '<iframe src="' + comp.imagem_url + '" ';
                                    galeriaHtml += 'style="width: 100%; height: 600px; border: 2px solid #ddd; border-radius: 5px;" ';
                                    galeriaHtml += 'type="application/pdf"></iframe>';
                                    galeriaHtml += '<br><small style="color: #999; margin-top: 10px; display: inline-block;">';
                                    galeriaHtml += '<i class="fa fa-file-pdf-o"></i> Arquivo PDF - ';
                                    galeriaHtml += '<a href="' + comp.imagem_url + '" target="_blank" style="color: #007bff; text-decoration: underline;">Abrir em nova aba</a>';
                                    galeriaHtml += '</small>';
                                } else {
                                    // Exibir imagem - altura aumentada de 400px para 600px
                                    galeriaHtml += '<img src="' + comp.imagem_url + '" alt="Comprovante" ';
                                    galeriaHtml += 'style="max-width: 100%; max-height: 600px; border: 2px solid #ddd; border-radius: 5px; cursor: pointer;" ';
                                    galeriaHtml += 'onclick="window.open(\'' + comp.imagem_url + '\', \'_blank\')">'; 
                                    galeriaHtml += '<br><small style="color: #999; margin-top: 10px; display: inline-block;">';
                                    galeriaHtml += '<i class="fa fa-info-circle"></i> Clique para ampliar';
                                    galeriaHtml += '</small>';
                                }
                                
                                galeriaHtml += '</div>';
                                galeriaHtml += '</div>';
                                
                                // Coluna dos dados (direita) - REDUZIDA de col-md-5 para col-md-3
                                galeriaHtml += '<div class="col-md-3">';
                                galeriaHtml += '<h6 style="margin-top: 0;"><strong>📄 Dados OCR</strong></h6>';
                                galeriaHtml += '<hr style="margin: 8px 0;">';
                                
                                // Valor
                                galeriaHtml += '<p style="margin-bottom: 8px; font-size: 12px;">';
                                galeriaHtml += '<strong>Valor:</strong><br>';
                                galeriaHtml += '<span style="font-size: 16px; color: #27ae60;">R$ ' + comp.valor + '</span>';
                                galeriaHtml += '</p>';
                                
                                // Data e Hora
                                galeriaHtml += '<p style="margin-bottom: 8px; font-size: 11px;">';
                                galeriaHtml += '<strong>Data/Hora:</strong><br>';
                                galeriaHtml += '<span style="font-size: 10px;">' + comp.data + ' às ' + comp.hora + '</span>';
                                galeriaHtml += '</p>';
                                
                                // Confiabilidade
                                if (comp.confiabilidade !== null) {
                                    var corConfiabilidade = comp.confiabilidade >= 80 ? 'success' : (comp.confiabilidade >= 60 ? 'warning' : 'danger');
                                    galeriaHtml += '<p style="margin-bottom: 8px; font-size: 11px;">';
                                    galeriaHtml += '<strong>Confiança:</strong><br>';
                                    galeriaHtml += '<span class="label label-' + corConfiabilidade + '" style="font-size: 11px;">';
                                    galeriaHtml += comp.confiabilidade + '%';
                                    galeriaHtml += '</span>';
                                    galeriaHtml += '</p>';
                                }
                                
                                // Erros (se houver)
                                if (!comp.validado && comp.erros && comp.erros.length > 0) {
                                    galeriaHtml += '<div class="alert alert-danger" style="margin-top: 15px; padding: 10px;">';
                                    galeriaHtml += '<strong><i class="fa fa-exclamation-triangle"></i> Problemas encontrados:</strong>';
                                    galeriaHtml += '<ul style="margin: 10px 0 0 0; padding-left: 20px;">';
                                    comp.erros.forEach(function(erro) {
                                        galeriaHtml += '<li>' + erro + '</li>';
                                    });
                                    galeriaHtml += '</ul>';
                                    galeriaHtml += '</div>';
                                }
                                
                                // Botão de download
                                galeriaHtml += '<hr style="margin: 15px 0;">';
                                galeriaHtml += '<button type="button" class="btn btn-primary btn-block" onclick="window.open(\'' + comp.imagem_url + '\', \'_blank\')">';
                                galeriaHtml += '<i class="fa fa-download"></i> Baixar Comprovante';
                                galeriaHtml += '</button>';
                                
                                // Botão de validar comprovante (se não estiver validado)
                                if (!comp.validado) {
                                    galeriaHtml += '<button type="button" class="btn btn-success btn-block btn-validar-comprovante" ';
                                    galeriaHtml += 'data-comprovante-id="' + comp.id + '" ';
                                    galeriaHtml += 'data-pedido-id="' + pedidoId + '" ';
                                    galeriaHtml += 'style="margin-top: 10px;">';
                                    galeriaHtml += '<i class="fa fa-check-circle"></i> Validar Comprovante';
                                    galeriaHtml += '</button>';
                                }
                                
                                galeriaHtml += '</div>'; // fim col-md-5
                                galeriaHtml += '</div>'; // fim row
                                galeriaHtml += '</div>'; // fim panel-body
                                galeriaHtml += '</div>'; // fim panel
                            });
                            
                            // Inserir galeria no modal
                            $('#comprovantes-galeria').html(galeriaHtml);
                            
                            // Mostrar conteúdo
                            $('#comprovante-loading').hide();
                            $('#comprovante-content').fadeIn();
                        } else {
                            
                            var mensagemHtml = '<div class="alert alert-warning" style="margin: 20px; text-align: center;">';
                            mensagemHtml += '<i class="fa fa-info-circle" style="font-size: 48px; color: #f39c12; margin-bottom: 15px;"></i>';
                            mensagemHtml += '<h4><strong>Pagamento Validado Manualmente</strong></h4>';
                            mensagemHtml += '<p style="color: #666; margin-top: 10px;">';
                            mensagemHtml += 'Este pedido foi confirmado como pago pelo atendente, ';
                            mensagemHtml += 'porém não possui comprovante digital anexado.';
                            mensagemHtml += '</p>';
                            mensagemHtml += '<p style="color: #999; font-size: 12px; margin-top: 15px;">';
                            mensagemHtml += '<i class="fa fa-lightbulb-o"></i> ';
                            mensagemHtml += 'O cliente pode ter enviado o comprovante por email, telefone ou outro meio.';
                            mensagemHtml += '</p>';
                            mensagemHtml += '</div>';
                            
                            $('#comprovantes-galeria').html(mensagemHtml);
                            $('#comprovante-loading').hide();
                            $('#comprovante-content').fadeIn();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#comprovante-loading').hide();
                        $('#comprovante-erro').fadeIn();
                    }
                });
            });
            
            // 👉 BOTÃO INICIAR ATENDIMENTO MANUAL (COM VÍNCULO AO PEDIDO)
            $(document).on('click', '.btn-atendimento-manual', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var clienteFone = $(this).data('cliente-fone');
                var pedidoId = $(this).data('pedido-id');
                var $btn = $(this);
                
                if (!clienteFone) {
                    alert('❌ Telefone do cliente não encontrado.');
                    return false;
                }
                
                if (!pedidoId) {
                    alert('❌ ID do pedido não encontrado.');
                    return false;
                }
                
                if (!confirm('Iniciar atendimento manual?\n\nPedido #' + pedidoId + '\n\nIsso irá:\n✅ Pausar o bot para este cliente\n✅ Adicionar ao painel de atendimento humano\n✅ Vincular conversa a este pedido\n✅ Permitir comunicação pelo seu WhatsApp')) {
                    return false;
                }
                
                // Desabilitar botão
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
                
                // Token da empresa
                var token = '<?= $data['config']->config_token ?>';
                
                // 🔗 Enviar requisição para CRIAR SESSÃO VINCULADA AO PEDIDO
                $.ajax({
                    url: baseUrl + '/api/bot-iniciar-sessao-pedido.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ 
                        pedido_id: pedidoId,
                        token: token
                    }),
                    dataType: 'json',
                    success: function(response) {
                        
                        if (response.success) {
                            // ✅ Sessão iniciada com sucesso - abrir modal do chat automaticamente
                            
                            // Resetar botão
                            $btn.prop('disabled', false).html('<i class="fa fa-user"></i>');
                            
                            // Abrir modal do chat automaticamente
                            var pedidoId = response.pedido_id;
                            var clienteNome = response.cliente_nome;
                            
                            // Resetar modal
                            $('#modal-chat-pedido-numero').text(pedidoId);
                            $('#modal-chat-cliente-nome').text(clienteNome);
                            $('#chat-loading').show();
                            $('#chat-erro').hide();
                            $('#chat-container').hide();
                            $('#chat-vazio').hide();
                            
                            // Abrir modal
                            $('#modal-chat-historico').modal('show');
                            
                            // Carregar histórico inicial
                            carregarMensagensChat(pedidoId, false);
                            
                            // Iniciar auto-refresh a cada 2 segundos
                            if (chatRefreshInterval) {
                                clearInterval(chatRefreshInterval);
                            }
                            chatRefreshInterval = setInterval(function() {
                                carregarMensagensChat(pedidoId, true);
                            }, 2000);
                        } else {
                            alert('❌ Erro: ' + (response.error || 'Erro ao iniciar sessão'));
                            $btn.prop('disabled', false).html('<i class="fa fa-user"></i>');
                        }
                    },
                    error: function(xhr) {
                        console.error('[DEBUG] Erro AJAX:', xhr);
                        var errorMsg = 'Erro ao conectar com o servidor.';
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.error) errorMsg = response.error;
                        } catch(e) {}
                        alert('❌ ' + errorMsg);
                        $btn.prop('disabled', false).html('<i class="fa fa-user"></i>');
                    }
                });
                
                return false;
            });
            
            // 👉 BOTÃO VALIDAR PIX MANUALMENTE (direto na lista de pedidos)
            $(document).on('click', '.btn-validar-pix-manual', function() {
                var pedidoId = $(this).data('pedido-id');
                var $btn = $(this);
                
                if (!confirm('Confirmar validação manual do pagamento Pix?\n\nPedido #' + pedidoId + '\n\nIsso irá marcar o pagamento como confirmado mesmo sem comprovante digital.')) {
                    return;
                }
                
                // Desabilitar botão
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Validando...');
                
                // Enviar requisição AJAX
                $.ajax({
                    url: baseUrl + '/admin/validar-pix-manual/',
                    method: 'POST',
                    data: { pedido_id: pedidoId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Recarregar página para atualizar status
                            location.reload();
                        } else {
                            alert('❌ Erro: ' + (response.error || 'Erro ao validar pagamento'));
                            $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Validar Pix');
                        }
                    },
                    error: function() {
                        alert('❌ Erro ao conectar com o servidor.');
                        $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Validar Pix');
                    }
                });
            });
            
            // 🔄 POLLING: Verificar status PIX automaticamente a cada 5 segundos (SEM REFRESH)
            var pixPollingInterval = null;
            var pedidosPixIds = [];
            
            function iniciarPollingPixStatus() {
                // Verificar se o bot WhatsApp está ativo
                var botAtivo = <?= Sessao::get_bot_whatsapp() == 1 ? 'true' : 'false' ?>;
                
                if (!botAtivo) {
                    return; // Bot desativado, não iniciar polling
                }
                
                // Coletar IDs de todos os pedidos PIX pendentes na página
                pedidosPixIds = [];
                $('.label-warning').each(function() {
                    var $tr = $(this).closest('tr');
                    var pedidoId = $tr.find('.btn-validar-pix-manual').data('pedido-id');
                    if (pedidoId) {
                        pedidosPixIds.push(pedidoId);
                    }
                });
                
                // Se não tem pedidos PIX pendentes, não iniciar polling
                if (pedidosPixIds.length === 0) {
                    return;
                }
                
                // Verificar imediatamente
                verificarStatusPix();
                
                // Configurar intervalo de 5 segundos
                pixPollingInterval = setInterval(function() {
                    verificarStatusPix();
                }, 5000);
            }
            
            function verificarStatusPix() {
                if (pedidosPixIds.length === 0) return;
                
                // Pegar base da sessão PHP (injetada na página)
                var empresaBase = '<?= $_SESSION["base_delivery"] ?? "" ?>';
                
                $.ajax({
                    url: baseUrl + '/api/check-pedidos-pix-status.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ 
                        pedidos_ids: pedidosPixIds,
                        base: empresaBase // Enviar base via POST
                    }),
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true // Enviar cookies de sessão
                    },
                    success: function(response) {
                        if (response.success && response.pedidos) {
                            var atualizados = 0;
                            
                            $.each(response.pedidos, function(pedidoId, dados) {
                                // Verificar se comprovante foi validado
                                if (dados.comprovante_validado === 1) {
                                    // Encontrar a linha do pedido
                                    var $btn = $('.btn-validar-pix-manual[data-pedido-id="' + pedidoId + '"]');
                                    if ($btn.length) {
                                        var $td = $btn.closest('td');
                                        var $labelPendente = $td.find('.label-warning');
                                        
                                        // Verificar se ainda está com badge "Aguardando"
                                        if ($labelPendente.length) {
                                            
                                            // Substituir badge e botão por badge verde "Pago"
                                            var novoHtml = '<a href="#" class="btn-ver-comprovante" data-pedido-id="' + pedidoId + '" style="text-decoration: none; cursor: pointer;">';
                                            novoHtml += '<span class="label label-success" data-toggle="tooltip" title="Comprovante validado em ' + dados.validado_em + '">';
                                            novoHtml += '<i class="fa fa-check-circle"></i> Pago';
                                            novoHtml += '</span>';
                                            novoHtml += '</a>';
                                            
                                            // Animar transição
                                            $td.fadeOut(300, function() {
                                                $(this).html(novoHtml).fadeIn(300);
                                            });
                                            
                                            // Remover deste polling
                                            pedidosPixIds = pedidosPixIds.filter(function(id) {
                                                return id !== parseInt(pedidoId);
                                            });
                                            
                                            atualizados++;
                                            
                                            // Notificação visual
                                            if (typeof $.gritter !== 'undefined') {
                                                $.gritter.add({
                                                    title: '✅ Pagamento Confirmado',
                                                    text: 'Pedido #' + pedidoId + ' teve o pagamento PIX validado!',
                                                    class_name: 'color success',
                                                    time: 4000
                                                });
                                            }
                                        }
                                    }
                                }
                            });
                            
                            // Se não tem mais pedidos pendentes, parar polling
                            if (pedidosPixIds.length === 0 && pixPollingInterval) {
                                clearInterval(pixPollingInterval);
                                pixPollingInterval = null;
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ [PIX-POLLING] Erro ao verificar status:', error);
                    }
                });
            }
            
            // Iniciar polling quando página carregar
            $(document).ready(function() {
                iniciarPollingPixStatus();
            });
            
            // Parar polling quando sair da página
            $(window).on('beforeunload', function() {
                if (pixPollingInterval) {
                    clearInterval(pixPollingInterval);
                }
            });
            
            // 👉 BOTÃO VALIDAR COMPROVANTE (dentro do modal)
            $(document).on('click', '.btn-validar-comprovante', function() {
                var comprovanteId = $(this).data('comprovante-id');
                var pedidoId = $(this).data('pedido-id');
                var $btn = $(this);
                
                if (!confirm('Validar este comprovante?\n\nIsso irá marcar o pedido como pago.')) {
                    return;
                }
                
                // Desabilitar botão
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Validando...');
                
                // Enviar requisição AJAX
                $.ajax({
                    url: baseUrl + '/admin/validar-comprovante/',
                    method: 'POST',
                    data: { 
                        comprovante_id: comprovanteId,
                        pedido_id: pedidoId 
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Fechar modal e recarregar
                            $('#modal-comprovante-pix').modal('hide');
                            location.reload();
                        } else {
                            alert('❌ Erro: ' + (response.error || 'Erro ao validar comprovante'));
                            $btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Validar Comprovante');
                        }
                    },
                    error: function() {
                        alert('❌ Erro ao conectar com o servidor.');
                        $btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Validar Comprovante');
                    }
                });
            });
            
            // 💬 BOTÃO VER HISTÓRICO DO CHAT - v1765305635
            $(document).on('click', '.btn-ver-chat-historico', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var pedidoId = $(this).data('pedido-id');
                var clienteNome = $(this).data('cliente-nome');
                
                // Resetar modal
                $('#modal-chat-pedido-numero').text(pedidoId);
                $('#modal-chat-cliente-nome').text(clienteNome);
                $('#chat-loading').show();
                $('#chat-erro').hide();
                $('#chat-container').hide();
                $('#chat-vazio').hide();
                
                // Abrir modal
                $('#modal-chat-historico').modal('show');
                
                // Carregar histórico inicial
                carregarMensagensChat(pedidoId, false);
                
                // Iniciar auto-refresh a cada 2 segundos
                if (chatRefreshInterval) {
                    clearInterval(chatRefreshInterval);
                }
                chatRefreshInterval = setInterval(function() {
                    carregarMensagensChat(pedidoId, true); // true = silent mode (sem loading)
                }, 2000);
            });
            
            // 💬 Fechar modal - parar auto-refresh
            $('#modal-chat-historico').on('hidden.bs.modal', function() {
                if (chatRefreshInterval) {
                    clearInterval(chatRefreshInterval);
                    chatRefreshInterval = null;
                }
                chatPedidoAtual = null;
                chatTelefoneAtual = null;
                chatSessaoAtiva = false;
            });
            
            // 💬 Função para carregar mensagens do chat
            function carregarMensagensChat(pedidoId, silent) {
                if (!silent) {
                    $('#chat-loading').show();
                    $('#chat-erro').hide();
                    $('#chat-container').hide();
                    $('#chat-vazio').hide();
                }
                
                $.ajax({
                    url: baseUrl + '/api/get-chat-historico.php',
                    method: 'POST',
                    data: { pedido_id: pedidoId },
                    dataType: 'json',
                    success: function(response) {

                        if (!silent) {
                            $('#chat-loading').hide();
                        }
                        
                        if (response.success && response.mensagens && response.mensagens.length > 0) {
                            // Guardar posição de scroll atual antes de atualizar
                            var chatContainer = $('#chat-mensagens');
                            var wasAtBottom = false;
                            
                            if (chatContainer.length && chatContainer[0].scrollHeight) {
                                wasAtBottom = chatContainer[0].scrollHeight - chatContainer.scrollTop() <= chatContainer.outerHeight() + 50;
                            }
                            
                            // Atualizar total de mensagens
                            $('#chat-total-mensagens').text(response.total);
                            
                            // Construir HTML das mensagens
                            var chatHtml = '';
                            
                            response.mensagens.forEach(function(msg) {
                                // Formatar data/hora
                                var dataHora = new Date(msg.data);
                                var dataFormatada = dataHora.toLocaleDateString('pt-BR') + ' ' + dataHora.toLocaleTimeString('pt-BR');
                                
                                // Identificar tipo de mensagem (padrão = cliente se não existir campo tipo)
                                var tipo = msg.tipo || 'cliente';
                                
                                // Estilo baseado no tipo - CLIENTE À ESQUERDA, BOT/ATENDENTE À DIREITA
                                var corFundo, icone, label, align, corTexto;
                                
                                if (tipo === 'cliente') {
                                    // Mensagem do cliente (👉 ESQUERDA, cinza)
                                    corFundo = '#E5E5EA';  // Cinza claro estilo iOS
                                    icone = '<i class="fa fa-user-circle"></i>';
                                    label = 'Cliente';
                                    align = 'flex-start';
                                    corTexto = '#000';  // Texto preto
                                } else if (tipo === 'bot') {
                                    // Mensagem do bot automático (👈 ESQUERDA, verde WhatsApp)
                                    corFundo = '#DCF8C6';  // Verde claro estilo WhatsApp
                                    icone = '<i class="fa fa-android"></i>';
                                    label = 'Bot';
                                    align = 'flex-start';  // BOT TAMBÉM À ESQUERDA
                                    corTexto = '#000';  // Texto preto
                                } else if (tipo === 'atendente') {
                                    // Mensagem do atendente humano (👈 DIREITA, azul)
                                    corFundo = '#007AFF';  // Azul estilo iOS
                                    icone = '<i class="fa fa-headphones"></i>';
                                    // Mostrar nome do atendente se disponível
                                    label = msg.atendente_nome ? msg.atendente_nome : 'Atendente';
                                    align = 'flex-end';
                                    corTexto = '#FFF';  // Texto branco
                                }
                                
                                // Bolha de mensagem estilo WhatsApp moderno
                                chatHtml += '<div style="margin-bottom: 12px; display: flex; align-items: flex-end; justify-content: ' + align + ';">';
                                chatHtml += '<div style="max-width: 65%; background: ' + corFundo + '; color: ' + corTexto + '; padding: 8px 12px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.12);">';
                                
                                // Label do tipo (pequena badge) - SEMPRE mostrar
                                chatHtml += '<div style="font-size: 11px; font-weight: 600; opacity: 0.8; margin-bottom: 4px;">' + icone + ' ' + label + '</div>';
                                
                                // Texto da mensagem
                                chatHtml += '<div style="font-size: 14px; line-height: 1.5; word-wrap: break-word; white-space: pre-wrap;">' + escapeHtml(msg.msg) + '</div>';
                                
                                // Data/hora (alinhado à direita)
                                chatHtml += '<div style="font-size: 10px; opacity: 0.6; margin-top: 4px; text-align: right;">';
                                chatHtml += '<i class="fa fa-clock-o"></i> ' + dataFormatada;
                                chatHtml += '</div>';
                                
                                chatHtml += '</div>';
                                chatHtml += '</div>';
                            });
                            
                            $('#chat-mensagens').html(chatHtml);
                            
                            // Esconder mensagem "vazio" e mostrar container de mensagens
                            $('#chat-vazio').hide();
                            
                            if (!silent) {
                                $('#chat-container').fadeIn();
                            } else if ($('#chat-container').is(':hidden')) {
                                $('#chat-container').show();
                            }
                            
                            // Scroll para o final se:
                            // 1. É o carregamento inicial (!silent)
                            // 2. Ou usuário já estava no final da conversa (novas mensagens)
                            if (!silent || wasAtBottom) {
                                setTimeout(function() {
                                    chatContainer.scrollTop(chatContainer[0].scrollHeight);
                                }, 100);
                            }
                            
                            // 💬 Verificar se há sessão de atendimento ativa para este pedido (apenas na primeira carga)
                            if (!silent) {
                                verificarSessaoAtiva(pedidoId, response.telefone);
                            }
                            
                        } else {
                            // Sem mensagens
                            if (!silent) {
                                $('#chat-vazio').fadeIn();
                                
                                // ✅ IMPORTANTE: Mesmo sem mensagens, verificar se há sessão ativa
                                // para permitir que atendente envie a primeira mensagem
                                if (response.telefone) {
                                    verificarSessaoAtiva(pedidoId, response.telefone);
                                } else {
                                    console.error('[DEBUG] ERRO: Telefone não retornado pela API');
                                }
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        if (!silent) {
                            $('#chat-loading').hide();
                            $('#chat-erro').fadeIn();
                        }
                    }
                });
            }
            
            // Função helper para escapar HTML
            function escapeHtml(text) {
                var map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, function(m) { return map[m]; });
            }
            
            // 💬 Variáveis globais para o chat
            var chatPedidoAtual = null;
            var chatTelefoneAtual = null;
            var chatSessaoAtiva = false;
            var chatRefreshInterval = null; // Intervalo de auto-atualização
            
            // 💬 Verificar se há sessão de atendimento ativa
            function verificarSessaoAtiva(pedidoId, telefone) {
                chatPedidoAtual = pedidoId;
                chatTelefoneAtual = telefone;
                
                // Esconder campo de resposta inicialmente
                $('#chat-responder').hide();
                
                $.ajax({
                    url: baseUrl + '/api/bot-check-session.php',
                    method: 'POST',
                    data: JSON.stringify({ 
                        telefone: telefone,
                        pedido_id: pedidoId
                    }),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        
                        if (response.sessao_ativa) {
                            chatSessaoAtiva = true;
                            
                            // Mostrar campo de resposta
                            $('#chat-sessao-info').text('Telefone: ' + telefone);
                            $('#chat-responder').slideDown();
                            
                            // Focar no input
                            setTimeout(function() {
                                $('#chat-mensagem-input').focus();
                            }, 300);
                        }
                    },
                    error: function() {
                        console.log('[CHAT] Erro ao verificar sessão');
                    }
                });
            }
            
            // 💬 Enviar mensagem do atendente
            $('#btn-enviar-resposta').on('click', function() {
                enviarMensagemAtendente();
            });
            
            // Enter para enviar
            $('#chat-mensagem-input').on('keypress', function(e) {
                if (e.which === 13) {
                    enviarMensagemAtendente();
                }
            });
            
            // 😊 EMOJI PICKER - Toggle
            $('#btn-emoji-picker').on('click', function(e) {
                e.stopPropagation();
                $('#emoji-picker').toggle();
            });
            
            // 😊 EMOJI PICKER - Selecionar emoji
            $('.emoji-btn').on('click', function() {
                var emoji = $(this).text();
                var $input = $('#chat-mensagem-input');
                var currentText = $input.val();
                $input.val(currentText + emoji);
                $input.focus();
                $('#emoji-picker').hide();
            });
            
            // 😊 EMOJI PICKER - Fechar ao clicar fora
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#btn-emoji-picker, #emoji-picker').length) {
                    $('#emoji-picker').hide();
                }
            });
            
            function enviarMensagemAtendente() {
                var mensagem = $('#chat-mensagem-input').val().trim();
                
                if (!mensagem) {
                    alert('⚠️ Digite uma mensagem!');
                    return;
                }
                
                if (!chatTelefoneAtual || !chatPedidoAtual) {
                    alert('⚠️ Erro: Dados do chat não encontrados.');
                    return;
                }
                
                var $btn = $('#btn-enviar-resposta');
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin" style="font-size: 14px;"></i>');
                
                $.ajax({
                    url: baseUrl + '/api/bot-enviar-mensagem-atendente.php',
                    method: 'POST',
                    data: JSON.stringify({
                        telefone: chatTelefoneAtual,
                        mensagem: mensagem,
                        pedido_id: chatPedidoAtual
                    }),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        
                        if (response.success) {
                            // Limpar input
                            $('#chat-mensagem-input').val('');
                            
                            // Recarregar histórico do chat para mostrar a mensagem do banco
                            setTimeout(function() {
                                carregarHistoricoChat(chatPedidoAtual, true); // true = silent (sem fade)
                            }, 500);
                            
                            // Notificação visual
                            $.gritter.add({
                                title: '✅ Mensagem Enviada!',
                                text: 'Sua resposta foi enviada para o cliente via WhatsApp.',
                                class_name: 'gritter-success',
                                time: 3000
                            });
                        } else {
                            alert('❌ Erro: ' + (response.error || 'Não foi possível enviar a mensagem.'));
                        }
                        
                        $btn.prop('disabled', false).html('<i class="fa fa-paper-plane" style="font-size: 14px;"></i>');
                    },
                    error: function(xhr) {
                        console.error('[CHAT] Erro ao enviar:', xhr.responseText);
                        alert('❌ Erro ao conectar com o servidor.');
                        $btn.prop('disabled', false).html('<i class="fa fa-paper-plane" style="font-size: 14px;"></i>');
                    }
                });
            }
            
            // Botão Finalizar Atendimento
            $('#btn-finalizar-atendimento-pedidos').on('click', function() {
                if (!chatTelefoneAtual) {
                    alert('⚠️ Erro: Telefone do cliente não identificado.');
                    return;
                }
                
                if (!confirm('Deseja finalizar este atendimento?\n\nO cliente retornará a ser atendido pelo bot automático.')) {
                    return;
                }
                
                var $btn = $(this);
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Finalizando...');
                
                // Buscar token correto (mesmo usado para verificação de sessão)
                var tokenEmpresa = '<?= $data['config']->config_token ?? '' ?>';
                                
                if (!tokenEmpresa) {
                    alert('⚠️ Erro: Token da empresa não identificado.');
                    $btn.prop('disabled', false).html('<i class="fa fa-times-circle"></i> Fechar');
                    return;
                }
                
                $.ajax({
                    url: '<?= $baseUri ?>/api/bot-atendimento.php',
                    method: 'POST',
                    data: {
                        acao: 'finalizar',
                        telefone: chatTelefoneAtual,
                        token: tokenEmpresa
                    },
                    dataType: 'json',
                    success: function(response) {
                        
                        if (response.success) {
                            $.gritter.add({
                                title: '✅ Atendimento Finalizado!',
                                text: 'O bot automático foi retomado para este cliente.',
                                class_name: 'gritter-success',
                                time: 3000
                            });
                            
                            // Fechar modal após 1 segundo
                            setTimeout(function() {
                                $('#modal-chat-historico').modal('hide');
                            }, 1000);
                        } else {
                            alert('❌ Erro: ' + (response.error || 'Não foi possível finalizar o atendimento.'));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('[CHAT] Erro ao finalizar:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            error: error
                        });
                        
                        // Tentar parsear a resposta
                        try {
                            var errorData = JSON.parse(xhr.responseText);
                            alert('❌ Erro: ' + (errorData.error || 'Erro ao conectar com o servidor.'));
                        } catch(e) {
                            alert('❌ Erro ao conectar com o servidor. Status: ' + xhr.status);
                        }
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html('<i class="fa fa-times-circle"></i> Fechar');
                    }
                });
            });
        </script>
        <!-- 🛒 MODAL VER ITENS DO PEDIDO -->
        <div class="modal fade" id="modalItensPedido" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #10b981; color: white;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                        <h4 class="modal-title">
                            <i class="fa fa-shopping-cart"></i> Itens do Pedido #<span id="modal-pedido-numero"></span>
                        </h4>
                    </div>
                    <div class="modal-body" id="modal-itens-content" style="max-height: 500px; overflow-y: auto;">
                        <div class="text-center" style="padding: 40px;">
                            <i class="fa fa-spinner fa-spin" style="font-size: 32px; color: #10b981;"></i>
                            <p style="margin-top: 15px; color: #666;">Carregando itens...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times"></i> Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            // 🛒 Ver Itens do Pedido
            $(document).on('click', '.btn-ver-itens-pedido', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const pedidoId = $(this).data('pedido-id');
                
                // Resetar e abrir modal
                $('#modal-pedido-numero').text(pedidoId);
                $('#modal-itens-content').html(
                    '<div class="text-center" style="padding: 40px;">' +
                    '<i class="fa fa-spinner fa-spin" style="font-size: 32px; color: #10b981;"></i>' +
                    '<p style="margin-top: 15px; color: #666;">Carregando itens...</p>' +
                    '</div>'
                );
                $('#modalItensPedido').modal('show');
                
                // Buscar itens via AJAX
                $.ajax({
                    url: baseUri + '/api/get-itens-pedido.php',
                    method: 'POST',
                    data: { pedido_id: pedidoId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.itens) {
                            let html = '<div class="table-responsive">';
                            html += '<table class="table table-bordered table-striped">';
                            html += '<thead style="background: #f8f9fa;">';
                            html += '<tr>';
                            html += '<th width="60" style="text-align: center;">Qtd</th>';
                            html += '<th>Categoria / Produto</th>';
                            html += '<th width="120" style="text-align: right;">Valor Unit.</th>';
                            html += '<th width="120" style="text-align: right;">Subtotal</th>';
                            html += '</tr>';
                            html += '</thead>';
                            html += '<tbody>';
                            
                            let total = 0;
                            response.itens.forEach(function(item) {
                                const subtotal = parseFloat(item.lista_total || 0);
                                total += subtotal;
                                
                                html += '<tr>';
                                html += '<td style="text-align: center; vertical-align: middle;"><b>' + item.lista_qtde + 'x</b></td>';
                                html += '<td style="vertical-align: middle;">';
                                
                                // Categoria e nome do item
                                if (item.categoria_nome) {
                                    html += '<div style="font-size: 12px; color: #666; font-weight: 600;">' + item.categoria_nome + '</div>';
                                }
                                html += '<div style="font-size: 14px; font-weight: 500;">' + (item.lista_opcao_nome || item.lista_item_nome) + '</div>';
                                
                                // Observações
                                if (item.lista_item_obs) {
                                    html += '<div style="font-size: 11px; color: #666; margin-top: 4px; font-style: italic;">';
                                    html += '<i class="fa fa-info-circle"></i> ' + item.lista_item_obs;
                                    html += '</div>';
                                }
                                
                                // Adicionais
                                if (item.lista_item_extra) {
                                    let extras = item.lista_item_extra.replace(/<[^>]*>/g, '').replace('Adicionais:', '').trim();
                                    if (extras) {
                                        html += '<div style="font-size: 11px; color: #10b981; margin-top: 4px;">';
                                        html += '<i class="fa fa-plus-circle"></i> ' + extras;
                                        html += '</div>';
                                    }
                                }
                                
                                html += '</td>';
                                html += '<td style="text-align: right; vertical-align: middle;">R$ ' + parseFloat(item.lista_opcao_preco || 0).toFixed(2).replace('.', ',') + '</td>';
                                html += '<td style="text-align: right; vertical-align: middle;"><b>R$ ' + subtotal.toFixed(2).replace('.', ',') + '</b></td>';
                                html += '</tr>';
                            });
                            
                            // Linha de total
                            html += '<tr style="background: #f8f9fa; font-weight: bold;">';
                            html += '<td colspan="3" style="text-align: right; padding: 12px;">TOTAL DOS ITENS:</td>';
                            html += '<td style="text-align: right; padding: 12px; font-size: 16px; color: #10b981;">R$ ' + total.toFixed(2).replace('.', ',') + '</td>';
                            html += '</tr>';
                            
                            html += '</tbody>';
                            html += '</table>';
                            html += '</div>';
                            
                            // Informações adicionais
                            if (response.pedido) {
                                html += '<div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">';
                                html += '<div style="display: flex; justify-content: space-between; margin-bottom: 8px;">';
                                html += '<span><b>Taxa de Entrega:</b></span>';
                                html += '<span>R$ ' + parseFloat(response.pedido.pedido_entrega || 0).toFixed(2).replace('.', ',') + '</span>';
                                html += '</div>';
                                
                                if (response.pedido.pedido_desconto > 0) {
                                    html += '<div style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #dc3545;">';
                                    html += '<span><b>Desconto:</b></span>';
                                    html += '<span>- R$ ' + parseFloat(response.pedido.pedido_desconto).toFixed(2).replace('.', ',') + '</span>';
                                    html += '</div>';
                                }
                                
                                html += '<div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: bold; color: #10b981; padding-top: 10px; border-top: 2px solid #ddd;">';
                                html += '<span>TOTAL DO PEDIDO:</span>';
                                html += '<span>R$ ' + parseFloat(response.pedido.pedido_total).toFixed(2).replace('.', ',') + '</span>';
                                html += '</div>';
                                html += '</div>';
                            }
                            
                            $('#modal-itens-content').html(html);
                        } else {
                            $('#modal-itens-content').html(
                                '<div class="alert alert-warning" style="margin: 20px;">' +
                                '<i class="fa fa-exclamation-triangle"></i> ' + (response.error || 'Nenhum item encontrado.') +
                                '</div>'
                            );
                        }
                    },
                    error: function(xhr) {
                        console.error('Erro ao buscar itens:', xhr.responseText);
                        $('#modal-itens-content').html(
                            '<div class="alert alert-danger" style="margin: 20px;">' +
                            '<i class="fa fa-times-circle"></i> Erro ao carregar os itens do pedido.' +
                            '</div>'
                        );
                    }
                });
            });
            
            // 🔄 ATUALIZAR TOTAIS E CONTADORES VIA AJAX APÓS MUDANÇA DE STATUS
            function atualizarTotaisEContadores() {
                // Pegar o período atual do filtro
                var dataInicio = $('input[name="data_inicio"]').val();
                var dataFim = $('input[name="data_fim"]').val();
                                
                $.ajax({
                    url: window.location.href.split('?')[0],
                    method: 'GET',
                    data: {
                        data_inicio: dataInicio,
                        data_fim: dataFim
                    },
                    success: function(html) {
                        
                        // Extrair os novos valores do HTML retornado
                        var $newPage = $(html);
                        
                        // Atualizar contadores nos filtros com log
                        $('.filter-chip').each(function() {
                            var status = $(this).data('status');
                            var $currentBadge = $(this).find('.badge');
                            var newBadge = $newPage.find('.filter-chip[data-status="' + status + '"] .badge');
                            
                            if (newBadge.length && $currentBadge.length) {
                                var oldValue = $currentBadge.text();
                                var newValue = newBadge.text();
                                
                                if (oldValue !== newValue) {
                                    $currentBadge.text(newValue);
                                    
                                    // Animação visual de atualização
                                    $currentBadge.css('background', '#28a745');
                                    setTimeout(function() {
                                        $currentBadge.css('background', '');
                                    }, 1000);
                                }
                            }
                        });
                        
                        // Atualizar cards de totais (os 4 cards roxo, verde, rosa, azul)
                        var $newCards = $newPage.find('.row[style*="margin-bottom: 15px"] > div');
                        var $currentCards = $('.row[style*="margin-bottom: 15px"] > div');
                        
                        $currentCards.each(function(index) {
                            if ($newCards.eq(index).length) {
                                var $currentValue = $(this).find('div[style*="font-size: 24px"]');
                                var newValue = $newCards.eq(index).find('div[style*="font-size: 24px"]').text();
                                var oldValue = $currentValue.text();
                                
                                if (oldValue !== newValue) {
                                    $currentValue.text(newValue);
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ Erro ao atualizar totais e contadores:', {
                            status: xhr.status,
                            error: error
                        });
                    }
                });
            }
            
        <?php if (Sessao::get_bot_whatsapp() == 1) : ?>
        // 🚚 VERIFICAR NOTIFICAÇÕES DE ENTREGADOR A CADA 3 SEGUNDOS
        setInterval(function() {
            $.ajax({
                url: '<?php echo $baseUri; ?>/api/check-notificacoes-entregador.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Notificações de aceitação
                        if (response.notificacoes_aceitas && response.notificacoes_aceitas.length > 0) {
                            response.notificacoes_aceitas.forEach(function(notif) {
                                $.gritter.add({
                                    title: '🏍️ Entregador a Caminho!',
                                    text: '<strong>' + notif.entregador_nome + '</strong> aceitou a entrega<br>' +
                                          'Pedido #' + notif.pedido_numero_entrega + '<br>' +
                                          'Cliente: ' + notif.cliente_nome,
                                    class_name: 'success',
                                    sticky: false,
                                    time: 8000
                                });
                            });

                            // Atualizar a tabela para mostrar quem aceitou
                            setTimeout(function() {
                                if (typeof carregarPedidos === 'function') {
                                    carregarPedidos();
                                } else {
                                    location.reload();
                                }
                            }, 1500);
                        }
                        
                        // Notificações de entrega confirmada
                        if (response.notificacoes_entregues && response.notificacoes_entregues.length > 0) {
                            response.notificacoes_entregues.forEach(function(notif) {
                                $.gritter.add({
                                    title: '✅ Entrega Confirmada!',
                                    text: '<strong>' + notif.entregador_nome + '</strong> confirmou a entrega<br>' +
                                          'Pedido #' + notif.pedido_numero_entrega + '<br>' +
                                          'Cliente: ' + notif.cliente_nome,
                                    class_name: 'success',
                                    sticky: false,
                                    time: 8000
                                });
                                
                                // Atualizar a linha na tabela
                                var table = $('#tabela-pedidos').DataTable();
                                table.rows().every(function() {
                                    var row = this.node();
                                    var pedidoId = $(row).find('td:first').text().trim();
                                    if (pedidoId == notif.pedido_id || pedidoId == '242') {
                                        // Atualizar coluna de status para "Entregue"
                                        var statusCell = $(row).find('td').eq(7); // Índice da coluna STATUS PEDIDO
                                        statusCell.html('<span class="badge badge-success">✅ Entregue</span>');
                                        $(row).addClass('row-entregue');
                                    }
                                });
                                
                                // Recarregar a tabela após 1 segundo para garantir atualização completa
                                setTimeout(function() {
                                    if (typeof carregarPedidos === 'function') {
                                        carregarPedidos();
                                    } else {
                                        location.reload();
                                    }
                                }, 1500);
                            });
                        }
                        
                        // Notificações de entrega RECUSADA
                        if (response.notificacoes_recusadas && response.notificacoes_recusadas.length > 0) {
                            response.notificacoes_recusadas.forEach(function(notif) {
                                $.gritter.add({
                                    title: '❌ Entrega Recusada!',
                                    text: '<strong>' + notif.entregador_nome + '</strong> recusou a entrega<br>' +
                                          'Pedido #' + notif.pedido_numero_entrega + '<br>' +
                                          'Cliente: ' + notif.cliente_nome + '<br><br>' +
                                          '<button class="btn btn-warning btn-sm" onclick="abrirNotificarEntregador(' + notif.pedido_id + ')">' +
                                          '🚚 Enviar para outro entregador</button>',
                                    class_name: 'danger',
                                    sticky: true,
                                    time: 30000
                                });
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    // Silenciar erros para não poluir console
                }
            });
        }, 3000); // A cada 3 segundos
        <?php endif; ?>
        </script>
</body>

</html>