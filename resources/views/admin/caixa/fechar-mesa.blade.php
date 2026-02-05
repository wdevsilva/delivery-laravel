<?php extract($data); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
     <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Caixa - Fechamento de Mesas">
    <meta name="author" content="">

    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="css/caixa-fechar-mesa.css" rel="stylesheet" />
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="container-fluid" id="pcont">
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3>
                            <i class="fa fa-money"></i> Fechamento da Mesa <?= $mesa->mesa_numero ?>
                            <span class="pull-right">
                                <a href="<?php echo $baseUri; ?>/admin/caixa/" class="btn btn-default btn-sm">
                                    <i class="fa fa-arrow-left"></i> Voltar
                                </a>
                            </span>
                        </h3>
                    </div>
                    <div class="content">

                        <!-- Info da Mesa -->
                        <div class="mesa-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4><i class="fa fa-table"></i> Mesa <?= $mesa->mesa_numero ?></h4>
                                    <p><strong>Cliente:</strong> <?= htmlspecialchars($mesa->cliente_nome ?? 'N/I') ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Garçom:</strong> <?= htmlspecialchars($mesa->garcon_nome ?? 'N/I') ?></p>
                                    <p><strong>Pessoas:</strong> <?= $mesa->numero_pessoas ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Tempo:</strong> <?= $mesa->tempo_ocupacao ?></p>
                                    <p><strong>Itens:</strong> <?= $mesa->total_itens ?></p>
                                </div>
                                <div class="col-md-3">
                                    <div class="valor-total-mesa" style="margin: 0; padding: 10px;">
                                        R$ <?= number_format(floatval($mesa->valor_total ?? 0), 2, ',', '.') ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Pedidos -->
                            <div class="col-md-8">
                                <h4><i class="fa fa-list"></i> Pedidos da Mesa</h4>

                                <?php foreach ($mesa->pedidos as $pedido): ?>
                                    <div class="pedido-item">
                                        <div class="pedido-header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>Pedido #<?= $pedido->pedido_mesa_id ?> - <?= date('H:i', strtotime($pedido->pedido_data)) ?></h5>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <strong>R$ <?= number_format(floatval($pedido->pedido_total ?? 0), 2, ',', '.') ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="padding: 15px;">
                                            <!-- Header row -->
                                            <div class="item-linha" style="background: #f8f9fa; font-weight: bold; border-bottom: 2px solid #dee2e6; margin-bottom: 5px;">
                                                <div class="item-nome">Item</div>
                                                <div class="item-quantidade">Qtd</div>
                                                <div class="item-preco">Valor</div>
                                                <div class="item-acoes">Ação</div>
                                            </div>
                                            <?php foreach ($pedido->itens as $item): ?>
                                                <div class="item-linha <?= isset($item->item_removido) && $item->item_removido == 1 ? 'item-removido' : '' ?>">
                                                    <div class="item-nome">
                                                        <?= htmlspecialchars($item->lista_item_nome ?? 'Item sem nome') ?>
                                                        <?php if (isset($item->item_removido) && $item->item_removido == 1): ?>
                                                            <small class="text-muted"> (Removido em <?= date('H:i', strtotime($item->removido_em)) ?>)</small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="item-quantidade"><?= $item->lista_qtde ?>x</div>
                                                    <div class="item-preco">
                                                        <?php if (isset($item->item_removido) && $item->item_removido == 1): ?>
                                                            <span class="item-preco-removido">R$ <?= number_format(floatval($item->lista_total ?? 0), 2, ',', '.') ?></span>
                                                        <?php else: ?>
                                                            R$ <?= number_format(floatval($item->lista_total ?? 0), 2, ',', '.') ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="item-acoes">
                                                        <?php if (!isset($item->item_removido) || $item->item_removido == 0): ?>
                                                            <?php if ($item->lista_qtde > 1): ?>
                                                                <div class="quantity-controls">
                                                                    <button class="btn btn-warning btn-xs" onclick="reduzirQuantidade(<?= $item->lista_id ?>, 1)" title="Remover 1 unidade">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                    <span class="quantity-display"><?= $item->lista_qtde ?></span>
                                                                    <button class="btn btn-danger btn-xs" onclick="removerItem(<?= $item->lista_id ?>)" title="Remover tudo">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            <?php else: ?>
                                                                <button class="btn btn-danger btn-xs" onclick="removerItem(<?= $item->lista_id ?>)" title="Remover item">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <span class="text-muted"><i class="fa fa-ban"></i></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Pagamento -->
                            <div class="col-md-4">
                                <div class="payment-section">
                                    <h4><i class="fa fa-credit-card"></i> Pagamento</h4>
                                    <form id="formPagamento">
                                        <input type="hidden" id="ocupacaoId" value="<?= $mesa->ocupacao_id ?>">
                                        <input type="hidden" id="mesaId" value="<?= $mesa->mesa_id ?>">

                                        <div class="form-group">
                                            <label>Forma de Pagamento *</label>
                                            <select class="form-control" id="formaPagamento" required>
                                                <option value="">Selecione...</option>
                                                <?php foreach ($formas_pagamento as $id => $nome): ?>
                                                    <option value="<?= $id ?>"><?= htmlspecialchars($nome ?? 'Forma de pagamento') ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Desconto (R$)</label>
                                            <input type="number" class="form-control" id="valorDesconto"
                                                placeholder="0,00" step="0.01" min="0" onchange="calcularTotal()">
                                        </div>

                                        <div class="form-group">
                                            <label>Observações</label>
                                            <textarea class="form-control" id="observacaoPagamento" rows="3"></textarea>
                                        </div>

                                        <div class="alert alert-info">
                                            <h4>Valor Final: <span id="valorFinal">R$ <?= number_format(floatval($mesa->valor_total ?? 0), 2, ',', '.') ?></span></h4>
                                        </div>

                                        <button type="submit" class="btn btn-finalizar btn-block">
                                            <i class="fa fa-check"></i> Finalizar Mesa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <h2 style="color: white; text-align: center; padding-top: 20%;"><i class="fa fa-spinner fa-spin"></i> Processando...</h2>
    </div>

    <!-- Scripts -->
    <script src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.cooki/jquery.cooki.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.ui/jquery-ui.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/behaviour/core.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.select2/dist/js/select2.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.maskedinput/jquery.maskedinput.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.mask.js"></script>
    
    <?php require_once __DIR__ . '/../switch-color.php'; ?>
    <script src="<?php echo $baseUri; ?>/view/admin/app-js/main.js"></script>

    <script>
        var baseUri = '<?= $baseUri; ?>';
        var valorTotalOriginal = <?= floatval($mesa->valor_total ?? 0) ?>;

        $(document).ready(function() {
            $('#formPagamento').submit(function(e) {
                e.preventDefault();
                finalizarMesa();
            });
        });

        function calcularTotal() {
            var desconto = parseFloat($('#valorDesconto').val()) || 0;
            var valorFinal = valorTotalOriginal - desconto;
            if (valorFinal < 0) valorFinal = 0;
            $('#valorFinal').text('R$ ' + valorFinal.toFixed(2).replace('.', ','));
        }

        function removerItem(listaId) {
            if (!confirm('Confirma a remoção de TODOS os itens desta linha?')) return;

            $.post(baseUri + '/admin/caixa/remover-item/', {
                lista_id: listaId
            }, function(response) {
                if (response.status === 'success') {
                    alert('Item removido!');
                    location.reload();
                } else {
                    alert('Erro: ' + response.message);
                }
            }, 'json');
        }

        function reduzirQuantidade(listaId, quantidadeRemover) {
            if (!confirm('Confirma a remoção de ' + quantidadeRemover + ' unidade(s) deste item?')) return;

            $.post(baseUri + '/admin/caixa/reduzir-quantidade/', {
                lista_id: listaId,
                quantidade: quantidadeRemover
            }, function(response) {
                if (response.status === 'success') {
                    alert('Quantidade reduzida!');
                    location.reload();
                } else {
                    alert('Erro: ' + response.message);
                }
            }, 'json');
        }

        function finalizarMesa() {
            var formaPagamento = $('#formaPagamento').val();
            var desconto = parseFloat($('#valorDesconto').val()) || 0;
            var observacao = $('#observacaoPagamento').val();

            if (!formaPagamento) {
                alert('Selecione a forma de pagamento!');
                return;
            }

            $('#loadingOverlay').show();

            $.post(baseUri + '/admin/caixa/processar-fechamento/', {
                ocupacao_id: $('#ocupacaoId').val(),
                mesa_id: $('#mesaId').val(),
                forma_pagamento: formaPagamento,
                valor_pago: valorTotalOriginal - desconto,
                desconto: desconto,
                observacao_pagamento: observacao
            }, function(response) {
                $('#loadingOverlay').hide();

                if (response.status === 'success') {
                    alert('Mesa fechada com sucesso!');
                    window.location.href = baseUri + '/admin/caixa/';
                } else {
                    alert('Erro: ' + response.message);
                }
            }, 'json').fail(function() {
                $('#loadingOverlay').hide();
                alert('Erro de comunicação!');
            });
        }
    </script>
</body>

</html>