<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.datatables/bootstrap-adapter/css/datatables.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <style>
        /* Cards de Promoção */
        .promo-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .promo-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }
        .promo-card.inactive { opacity: 0.7; }
        .promo-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .promo-card-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
        }
        .promo-card-body { padding: 20px; }
        .promo-card-footer {
            padding: 15px 20px;
            background: #f9f9f9;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Status Badge */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-badge.active { background: #d4edda; color: #155724; }
        .status-badge.inactive { background: #f8d7da; color: #721c24; }
        
        /* Tipo Badge */
        .tipo-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
        }
        .tipo-badge.quantidade_categoria { background: #e3f2fd; color: #1565c0; }
        .tipo-badge.valor_minimo { background: #fff3e0; color: #e65100; }
        .tipo-badge.produto_especifico { background: #f3e5f5; color: #7b1fa2; }
        .tipo-badge.combo { background: #e8f5e9; color: #2e7d32; }
        
        /* Info Row */
        .promo-info-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 13px;
            color: #666;
        }
        .promo-info-row i { width: 20px; color: #999; margin-right: 8px; }
        .promo-info-row strong { color: #333; margin-right: 5px; }
        
        /* Dias da Semana */
        .dias-semana-tags { display: flex; flex-wrap: wrap; gap: 4px; }
        .dia-tag {
            background: #f0f0f0;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            color: #666;
        }
        .dia-tag.active { background: #3498db; color: #fff; }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .empty-state i { font-size: 64px; margin-bottom: 20px; color: #ddd; }
        
        /* Header Stats */
        .stats-bar {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
        }
        .stat-item {
            background: #fff;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .stat-item .number { font-size: 24px; font-weight: 700; color: #2c3e50; }
        .stat-item .label { font-size: 12px; color: #999; text-transform: uppercase; }
        
        /* Button Actions */
        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            margin-left: 5px;
            transition: all 0.2s;
        }
        .btn-action:hover { transform: scale(1.1); }
        
        /* Modal melhorado */
        .modal-content { border-radius: 12px; border: none; }
        .modal-header { border-bottom: none; padding: 25px 25px 0; }
        .modal-body { padding: 25px; text-align: center; }
        .modal-footer { border-top: none; padding: 0 25px 25px; justify-content: center; }
        .modal-icon { font-size: 48px; margin-bottom: 15px; }
        .modal-icon.warning { color: #f39c12; }
        .modal-icon.danger { color: #e74c3c; }
    </style>
</head>
<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                
                <?php
                // Contar promoções por status
                $total = count($data['promocao'] ?? []);
                $ativas = 0;
                $inativas = 0;
                if (isset($data['promocao'])) {
                    foreach ($data['promocao'] as $p) {
                        if ($p->status == 1) $ativas++;
                        else $inativas++;
                    }
                }
                
                // Mapeamento de tipos
                $tipos_label = [
                    'quantidade_categoria' => 'Por Categoria',
                    'valor_minimo' => 'Por Valor',
                    'produto_especifico' => 'Produto Específico',
                    'combo' => 'Combo'
                ];
                
                // Mapeamento de dias
                $dias_map = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
                ?>
                
                <!-- Header -->
                <div class="block-flat" style="margin-bottom: 20px;">
                    <div class="header" style="border-bottom: 0;">
                        <h3>
                            <i class="fa fa-gift text-success"></i> Promoções
                            <a href="<?= $baseUri ?>/promo/novo/" class="btn btn-success pull-right">
                                <i class="fa fa-plus"></i> Nova Promoção
                            </a>
                        </h3>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="stats-bar">
                    <div class="stat-item">
                        <div class="number"><?= $total ?></div>
                        <div class="label">Total</div>
                    </div>
                    <div class="stat-item">
                        <div class="number text-success"><?= $ativas ?></div>
                        <div class="label">Ativas</div>
                    </div>
                    <div class="stat-item">
                        <div class="number text-danger"><?= $inativas ?></div>
                        <div class="label">Inativas</div>
                    </div>
                </div>
                
                <!-- Lista de Promoções -->
                <?php if (empty($data['promocao'])): ?>
                    <div class="empty-state">
                        <i class="fa fa-gift"></i>
                        <h4>Nenhuma promoção cadastrada</h4>
                        <p>Crie sua primeira promoção para começar a atrair clientes!</p>
                        <a href="<?= $baseUri ?>/promo/novo/" class="btn btn-success btn-lg">
                            <i class="fa fa-plus"></i> Criar Promoção
                        </a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($data['promocao'] as $promo): ?>
                            <?php
                            $dias = explode(',', $promo->promocao_dias_semana ?? '');
                            $tipo = $promo->promocao_tipo ?? 'quantidade_categoria';
                            $premio = !empty($promo->premio_produto_nome) ? $promo->premio_produto_nome : $promo->promocao_premio_produto;
                            ?>
                            <div class="col-md-6 col-lg-4" id="promo-card-<?= $promo->promocao_id ?>">
                                <div class="promo-card <?= $promo->status == 0 ? 'inactive' : '' ?>">
                                    <div class="promo-card-header">
                                        <h4>
                                            <i class="fa fa-tag text-warning"></i>
                                            <?= htmlspecialchars($promo->promocao_titulo ?? 'Sem título') ?>
                                        </h4>
                                        <span class="status-badge <?= $promo->status == 1 ? 'active' : 'inactive' ?>">
                                            <?= $promo->status == 1 ? 'Ativa' : 'Inativa' ?>
                                        </span>
                                    </div>
                                    
                                    <div class="promo-card-body">
                                        <div class="promo-info-row">
                                            <i class="fa fa-cog"></i>
                                            <span class="tipo-badge <?= $tipo ?>">
                                                <?= $tipos_label[$tipo] ?? 'Outro' ?>
                                            </span>
                                        </div>
                                        
                                        <div class="promo-info-row">
                                            <i class="fa fa-gift"></i>
                                            <strong>Prêmio:</strong>
                                            <span><?= $promo->promocao_premio_qtd ?>x <?= htmlspecialchars($premio ?: 'Não definido') ?></span>
                                        </div>
                                        
                                        <?php if ($tipo == 'quantidade_categoria' && !empty($promo->categoria_nome)): ?>
                                        <div class="promo-info-row">
                                            <i class="fa fa-folder"></i>
                                            <strong>Categoria:</strong>
                                            <span><?= htmlspecialchars($promo->categoria_nome) ?> (<?= $promo->promocao_qtd_compra ?>+ itens)</span>
                                        </div>
                                        <?php elseif ($tipo == 'valor_minimo' && $promo->promocao_valor_minimo > 0): ?>
                                        <div class="promo-info-row">
                                            <i class="fa fa-money"></i>
                                            <strong>Valor mínimo:</strong>
                                            <span>R$ <?= number_format($promo->promocao_valor_minimo, 2, ',', '.') ?></span>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="promo-info-row">
                                            <i class="fa fa-calendar"></i>
                                            <div class="dias-semana-tags">
                                                <?php for ($i = 0; $i < 7; $i++): ?>
                                                    <span class="dia-tag <?= in_array($i, $dias) ? 'active' : '' ?>">
                                                        <?= $dias_map[$i] ?>
                                                    </span>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        
                                        <?php if (!empty($promo->promocao_data_inicio) || !empty($promo->promocao_data_fim)): ?>
                                        <div class="promo-info-row">
                                            <i class="fa fa-clock-o"></i>
                                            <span>
                                                <?= !empty($promo->promocao_data_inicio) ? date('d/m/Y', strtotime($promo->promocao_data_inicio)) : 'Sem data' ?>
                                                até
                                                <?= !empty($promo->promocao_data_fim) ? date('d/m/Y', strtotime($promo->promocao_data_fim)) : 'Indeterminado' ?>
                                            </span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="promo-card-footer">
                                        <div>
                                            <small class="text-muted">
                                                <i class="fa fa-sort-numeric-asc"></i> Prioridade: <?= $promo->promocao_prioridade ?? 1 ?>
                                            </small>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-action btn-<?= $promo->status == 1 ? 'success' : 'danger' ?> btn-status"
                                                    data-id="<?= $promo->promocao_id ?>"
                                                    data-status="<?= $promo->status ?>"
                                                    title="<?= $promo->status == 1 ? 'Desativar' : 'Ativar' ?>">
                                                <i class="fa fa-<?= $promo->status == 1 ? 'check' : 'ban' ?>"></i>
                                            </button>
                                            <a href="<?= $baseUri ?>/promo/editar/<?= $promo->promocao_id ?>/" 
                                               class="btn btn-action btn-primary" title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-action btn-danger btn-remover"
                                                    data-id="<?= $promo->promocao_id ?>"
                                                    data-titulo="<?= htmlspecialchars($promo->promocao_titulo ?? '') ?>"
                                                    title="Excluir">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Modal Remover -->
    <div class="modal fade" id="modal-remove" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Excluir Promoção</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-icon warning">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <h5>Tem certeza que deseja excluir?</h5>
                    <p class="text-muted" id="promo-titulo-remover"></p>
                    <p class="text-danger"><small>Esta ação não pode ser desfeita.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btn-confirmar-remover">
                        <i class="fa fa-trash"></i> Excluir
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Status -->
    <div class="modal fade" id="modal-status" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alterar Status</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-icon warning">
                        <i class="fa fa-power-off"></i>
                    </div>
                    <h5 id="status-msg">Deseja alterar o status desta promoção?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn-confirmar-status">
                        <i class="fa fa-check"></i> Confirmar
                    </button>
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
    <script type="text/javascript" src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="app-js/main.js"></script>
    <script type="text/javascript">
    var baseUri = '<?= $baseUri ?>';
    var promoIdToRemove = null;
    var promoIdToStatus = null;
    var promoStatusAtual = null;
    
    $(document).ready(function() {
        $('#menu-promocoes').addClass('active');
        $('[title]').tooltip();
        
        // Mostrar mensagem de sucesso
        <?php if (isset($_GET['success'])): ?>
        showNotification('Promoção salva com sucesso!', 'success');
        <?php endif; ?>
        
        // ========== REMOVER ==========
        $(document).on('click', '.btn-remover', function() {
            promoIdToRemove = $(this).data('id');
            var titulo = $(this).data('titulo');
            $('#promo-titulo-remover').text('"' + titulo + '"');
            $('#modal-remove').modal('show');
        });
        
        $('#btn-confirmar-remover').on('click', function() {
            if (!promoIdToRemove) return;
            
            var $btn = $(this);
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Excluindo...');
            
            $.ajax({
                url: baseUri + '/promo/remove/',
                type: 'POST',
                data: { promocao_id: promoIdToRemove },
                dataType: 'json',
                success: function(response) {
                    $('#modal-remove').modal('hide');
                    
                    if (response.success) {
                        $('#promo-card-' + promoIdToRemove).fadeOut(300, function() {
                            $(this).remove();
                        });
                        showNotification(response.message, 'success');
                    } else {
                        showNotification(response.message || 'Erro ao excluir', 'danger');
                    }
                },
                error: function() {
                    $('#modal-remove').modal('hide');
                    showNotification('Erro ao excluir promoção', 'danger');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="fa fa-trash"></i> Excluir');
                    promoIdToRemove = null;
                }
            });
        });
        
        // ========== STATUS ==========
        $(document).on('click', '.btn-status', function() {
            promoIdToStatus = $(this).data('id');
            promoStatusAtual = $(this).data('status');
            
            var msg = promoStatusAtual == 1 ? 'Deseja DESATIVAR esta promoção?' : 'Deseja ATIVAR esta promoção?';
            $('#status-msg').text(msg);
            $('#modal-status').modal('show');
        });
        
        $('#btn-confirmar-status').on('click', function() {
            if (!promoIdToStatus) return;
            
            var $btn = $(this);
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            $.ajax({
                url: baseUri + '/promo/altera_status/',
                type: 'POST',
                data: { promocao_id: promoIdToStatus, status: promoStatusAtual },
                dataType: 'json',
                success: function(response) {
                    $('#modal-status').modal('hide');
                    
                    if (response.success) {
                        // Atualizar visual do card
                        var $card = $('#promo-card-' + promoIdToStatus);
                        var $promoCard = $card.find('.promo-card');
                        var $statusBtn = $card.find('.btn-status');
                        var $statusBadge = $card.find('.status-badge');
                        
                        if (response.novo_status == 1) {
                            $promoCard.removeClass('inactive');
                            $statusBtn.removeClass('btn-danger').addClass('btn-success');
                            $statusBtn.find('i').removeClass('fa-ban').addClass('fa-check');
                            $statusBtn.data('status', 1).attr('title', 'Desativar');
                            $statusBadge.removeClass('inactive').addClass('active').text('Ativa');
                        } else {
                            $promoCard.addClass('inactive');
                            $statusBtn.removeClass('btn-success').addClass('btn-danger');
                            $statusBtn.find('i').removeClass('fa-check').addClass('fa-ban');
                            $statusBtn.data('status', 0).attr('title', 'Ativar');
                            $statusBadge.removeClass('active').addClass('inactive').text('Inativa');
                        }
                        
                        showNotification(response.message, 'success');
                    } else {
                        showNotification(response.message || 'Erro ao alterar status', 'danger');
                    }
                },
                error: function() {
                    $('#modal-status').modal('hide');
                    showNotification('Erro ao alterar status', 'danger');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Confirmar');
                    promoIdToStatus = null;
                    promoStatusAtual = null;
                }
            });
        });
    });
    
    function showNotification(message, type) {
        $.gritter.add({
            title: type === 'success' ? 'Sucesso!' : 'Atenção!',
            text: message,
            class_name: type === 'success' ? 'success' : 'danger',
            time: 3000
        });
    }
    </script>
</body>
</html>