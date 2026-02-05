<?php 

$baseUri = Http::base(); 

// Variables are accessed through $data array like other views in the system
$mesa = isset($data['mesa']) ? $data['mesa'] : new stdClass();
$categorias = isset($data['categorias']) ? $data['categorias'] : [];
$garcon = isset($data['garcon']) ? $data['garcon'] : new stdClass();
$config = isset($data['config']) ? $data['config'] : new stdClass();

// Set default values for mesa
if (!isset($mesa->mesa_id)) $mesa->mesa_id = 'N/A';
if (!isset($mesa->mesa_numero)) $mesa->mesa_numero = 'N/A';
if (!isset($mesa->ocupacao_id)) $mesa->ocupacao_id = 'N/A';
if (!isset($mesa->garcon_id)) $mesa->garcon_id = 'N/A';
if (!isset($mesa->cliente_nome)) $mesa->cliente_nome = 'Não informado';
if (!isset($mesa->numero_pessoas)) $mesa->numero_pessoas = 'Não informado';

// Set default values for garcon
if (!isset($garcon->garcon_id)) $garcon->garcon_id = 'N/A';
if (!isset($garcon->garcon_nome)) $garcon->garcon_nome = 'N/A';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio - Mesa <?= $mesa->mesa_numero ?> - Sistema Garçon</title>
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/midias/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo $data['config']->config_foto; ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css">    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/garcon-cardapio.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/mesas.css"> 
</head>
<body>
    
    <?php require_once 'menu.php'; ?>

    <div class="container">
        <!-- Header -->
        <div class="main-header">
            <div class="row">
                <div class="col-md-8">
                    <h2><i class="fa fa-cutlery"></i> Cardápio - Mesa <?= $mesa->mesa_numero ?></h2>
                    <p class="mb-0">Garçon: <?= $garcon->garcon_nome ?></p>
                </div>
                <div class="col-md-4 text-right">
                    <h4><?= date('d/m/Y H:i') ?></h4>
                </div>
            </div>
        </div>

        <!-- Botões de Navegação -->
        <div class="btn-group" role="group" style="margin-bottom: 20px;">
            <a href="<?= $baseUri ?>/garcon/mesas/" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Voltar para Mesas
            </a>
            <a href="<?= $baseUri ?>/garcon/pedidos-mesa/<?= $mesa->mesa_id ?>/" class="btn btn-info" style="margin-left: 15px;">
                <i class="fa fa-list"></i> Ver Pedidos
            </a>
        </div>

        <!-- Informações da Mesa -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-info-circle"></i> Informações da Mesa
            </div>
            <div class="card-body">
                <div class="mesa-info">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Mesa:</strong> <?= $mesa->mesa_numero ?>
                        </div>
                        <div class="col-md-3">
                            <strong>Cliente:</strong> <?= $mesa->cliente_nome ?? 'Não informado' ?>
                        </div>
                        <div class="col-md-3">
                            <strong>Pessoas:</strong> <?= $mesa->numero_pessoas ?? 'Não informado' ?>
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong> 
                            <span class="label label-success">Ocupada</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cardápio -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-list"></i> Cardápio
            </div>
            <div class="card-body">
                <?php if ($categorias && count($categorias) > 0): ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <div class="categoria-tab">
                            <div class="categoria-header" data-categoria="<?= $categoria->categoria_id ?>">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h4><i class="fa fa-cutlery"></i> <?= $categoria->categoria_nome ?></h4>
                                        <?php if (!empty($categoria->categoria_descricao)): ?>
                                            <small><?= $categoria->categoria_descricao ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <i class="fa fa-chevron-down toggle-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="categoria-content" id="categoria-<?= $categoria->categoria_id ?>">
                                <div class="loading">
                                    <i class="fa fa-spinner fa-spin"></i> Carregando itens...
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center">
                        <h4>Nenhuma categoria encontrada</h4>
                        <p>Não há itens disponíveis no cardápio no momento.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Carrinho Fixo -->
    <div class="carrinho-fixo" onclick="mostrarCarrinho()" style="display: none;">
        <i class="fa fa-shopping-cart"></i>
        <span class="carrinho-texto">Carrinho</span>
        <span class="carrinho-badge">0</span>
    </div>

    <!-- Modal do Carrinho -->
    <div class="modal fade modal-pedido" id="modal-carrinho" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-shopping-cart"></i> Resumo do Pedido</h4>
                </div>
                <div class="modal-body">
                    <div id="resumo-carrinho">
                        <!-- Itens do carrinho serão inseridos aqui -->
                    </div>
                    <div class="total-geral">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Total do Pedido:</strong>
                            </div>
                            <div class="col-md-6 text-right">
                                <h4 id="total-pedido">R$ 0,00</h4>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Observações Gerais:</label>
                        <textarea id="obs-geral" class="form-control" placeholder="Observações sobre o pedido..." rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" onclick="enviarPedido()">
                        <i class="fa fa-check"></i> Enviar Pedido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="<?= $baseUri ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    
    <script>
        var baseUri = '<?= $baseUri ?>';
        var mesaId = <?= $mesa->mesa_id ?>;
        var ocupacaoId = <?= $mesa->ocupacao_id ?>;
        var carrinho = {};
        var totalPedido = 0;

        $(document).ready(function() {
            // Event listener para categorias
            $('.categoria-header').click(function() {
                var categoriaId = $(this).data('categoria');
                var content = $('#categoria-' + categoriaId);
                var icon = $(this).find('.toggle-icon');
                
                if (content.hasClass('active')) {
                    content.removeClass('active').slideUp();
                    $(this).removeClass('active');
                    icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                } else {
                    // Fechar outras categorias
                    $('.categoria-content.active').removeClass('active').slideUp();
                    $('.categoria-header.active').removeClass('active');
                    $('.toggle-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                    
                    // Abrir categoria selecionada
                    content.addClass('active').slideDown();
                    $(this).addClass('active');
                    icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
                    
                    // Carregar itens da categoria se ainda não foram carregados
                    if (content.find('.loading').length > 0) {
                        carregarItensCategoria(categoriaId);
                    }
                }
            });
        });

        function carregarItensCategoria(categoriaId) {
            $.get(baseUri + '/garcon/get-itens-categoria/', {categoria_id: categoriaId})
                .done(function(data) {
                    
                    var content = $('#categoria-' + categoriaId);
                    var html = '<div class="item-list">';
                    
                    // Check if data is valid and is an array
                    if (data && Array.isArray(data) && data.length > 0) {
                        data.forEach(function(item) {
                            html += `
                                <div class="item-card" data-item-id="${item.item_id}">
                                    <div class="item-nome">${item.item_nome}</div>
                                    <div class="item-descricao">${item.item_descricao || ''}</div>
                                    <div class="item-preco">R$ ${parseFloat(item.item_preco).toFixed(2).replace('.', ',')}</div>
                                    <div class="item-actions">
                                        <div class="qty-control">
                                            <button class="qty-btn" onclick="alterarQuantidade(${item.item_id}, -1)">-</button>
                                            <input type="number" class="qty-input" id="qty-${item.item_id}" value="0" min="0" onchange="atualizarQuantidade(${item.item_id})">
                                            <button class="qty-btn" onclick="alterarQuantidade(${item.item_id}, 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="item-obs">
                                        <textarea id="obs-${item.item_id}" placeholder="Observações para este item..." class="form-control" style="display: none;" onchange="atualizarObservacao(${item.item_id})" onkeyup="atualizarObservacao(${item.item_id})"></textarea>
                                        <button type="button" class="btn btn-xs btn-info" onclick="toggleObservacao(${item.item_id})">
                                            <i class="fa fa-comment"></i> Observações
                                        </button>
                                    </div>
                                </div>
                            `;
                        });
                    } else if (data && typeof data === 'object' && !Array.isArray(data)) {
                        // If data is an object but not an array, show error
                        console.error('Expected array but got object:', data);
                        html += '<div class="text-center text-danger" style="padding: 20px;">Erro: Resposta inválida do servidor.</div>';
                    } else {
                        // No items found
                        html += '<div class="text-center" style="padding: 20px;">Nenhum item encontrado nesta categoria.</div>';
                    }
                    
                    html += '</div>';
                    content.html(html);
                })
                .fail(function(xhr, status, error) {
                    var errorMsg = 'Erro ao carregar itens';
                    if (xhr.status === 404) {
                        errorMsg = 'Rota não encontrada (404)';
                    } else if (xhr.status === 500) {
                        errorMsg = 'Erro interno do servidor (500)';
                    }
                    $('#categoria-' + categoriaId).html('<div class="text-center text-danger" style="padding: 20px;">' + errorMsg + ': ' + error + '</div>');
                });
        }

        function alterarQuantidade(itemId, delta) {
            var input = $('#qty-' + itemId);
            var valor = parseInt(input.val()) + delta;
            if (valor < 0) valor = 0;
            input.val(valor);
            atualizarQuantidade(itemId);
        }

        function atualizarQuantidade(itemId) {
            var quantidade = parseInt($('#qty-' + itemId).val()) || 0;
            var itemCard = $('[data-item-id="' + itemId + '"]');
            var nome = itemCard.find('.item-nome').text();
            var precoText = itemCard.find('.item-preco').text().replace('R$ ', '').replace(',', '.');
            var preco = parseFloat(precoText);
            var observacao = $('#obs-' + itemId).val() || ''; // Always get current observation value

            if (quantidade > 0) {
                carrinho[itemId] = {
                    item_id: itemId,
                    item_nome: nome,
                    quantidade: quantidade,
                    preco: preco,
                    observacao: observacao
                };
            } else {
                delete carrinho[itemId];
            }

            atualizarCarrinho();
        }
        
        function atualizarObservacao(itemId) {
            // Update observation in cart if item is already added
            if (carrinho[itemId]) {
                var observacao = $('#obs-' + itemId).val() || '';
                carrinho[itemId].observacao = observacao;
            }
        }

        function toggleObservacao(itemId) {
            var obs = $('#obs-' + itemId);
            obs.toggle();
        }

        function atualizarCarrinho() {
            var itensCount = Object.keys(carrinho).length;
            var totalQuantidade = 0;
            var carrinhoFixo = $('.carrinho-fixo');
            
            // Calcular total de quantidade e valor
            totalPedido = 0;
            for (var itemId in carrinho) {
                totalQuantidade += carrinho[itemId].quantidade;
                totalPedido += carrinho[itemId].preco * carrinho[itemId].quantidade;
            }
            
            if (itensCount > 0) {
                carrinhoFixo.show();
                $('.carrinho-badge').text(totalQuantidade); // Mostra total de quantidades, não apenas itens diferentes
            } else {
                carrinhoFixo.hide();
            }
            
            $('#total-pedido').text('R$ ' + totalPedido.toFixed(2).replace('.', ','));
        }

        function mostrarCarrinho() {
            var html = '';
            
            for (var itemId in carrinho) {
                var item = carrinho[itemId];
                var subtotal = item.preco * item.quantidade;
                
                html += `
                    <div class="resumo-item">
                        <div class="row">
                            <div class="col-md-8">
                                <strong>${item.item_nome}</strong><br>
                                <small>Quantidade: ${item.quantidade} x R$ ${item.preco.toFixed(2).replace('.', ',')}</small>
                                ${item.observacao ? '<br><small class="text-muted">Obs: ' + item.observacao + '</small>' : ''}
                            </div>
                            <div class="col-md-4 text-right">
                                <strong>R$ ${subtotal.toFixed(2).replace('.', ',')}</strong>
                            </div>
                        </div>
                    </div>
                `;
            }

            $('#resumo-carrinho').html(html);
            $('#modal-carrinho').modal('show');
        }

        function enviarPedido() {
            if (Object.keys(carrinho).length === 0) {
                alert('Adicione pelo menos um item ao pedido!');
                return;
            }

            var itens = [];
            for (var itemId in carrinho) {
                // Get the latest observation value before sending
                var observacaoAtual = $('#obs-' + itemId).val() || '';
                var item = carrinho[itemId];
                item.observacao = observacaoAtual; // Update with current observation
                
                itens.push({
                    item_id: item.item_id,
                    item_nome: item.item_nome,
                    item_codigo: item.item_codigo || '',
                    quantidade: item.quantidade,
                    preco: item.preco,
                    observacao: observacaoAtual
                });
            }

            var dados = {
                mesa_id: mesaId,
                ocupacao_id: ocupacaoId,
                itens: itens,
                observacao: $('#obs-geral').val()
            };

            $.ajax({
                url: baseUri + '/garcon/fazer-pedido/',
                method: 'POST',
                data: dados,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Pedido enviado com sucesso!');
                        $('#modal-carrinho').modal('hide');
                        // Limpar carrinho
                        carrinho = {};
                        $('.qty-input').val('0');
                        $('.carrinho-fixo').hide();
                        $('#obs-geral').val('');
                        $('[id^="obs-"]').val('').hide();
                    } else {
                        alert('Erro: ' + (response.message || 'Erro desconhecido'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error sending order:', xhr.responseText);
                    alert('Erro ao enviar pedido. Tente novamente.');
                }
            });
        }
    </script>
</body>
</html>