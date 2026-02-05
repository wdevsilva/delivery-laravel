// Version: 2026-01-17-v2 - Atualiza contadores dos badges automaticamente
var podt = $(".datatable").DataTable({
    retrieve: true,
    responsive: true,
    dom: 'Bfrtip',
    buttons: datatable_buttons,
    "displayLength": 30,
    "order": [
        [0, "desc"]
    ],
    "oLanguage": lang
});

// Mapeamento de status para cores e ícones
var statusConfig = {
    1: { color: 'warning', icon: '<i class="fa fa-hourglass-o"></i> Pendente', text: 'Pendente' },
    2: { color: 'info', icon: '<i class="fa fa-hourglass-2"></i> Em Produção', text: 'Em Produção' },
    3: { color: 'info', icon: '<i class="fa fa-motorcycle"></i> Saiu para entrega', text: 'Saiu para entrega' },
    4: { color: 'success', icon: '<i class="fa fa-check-circle-o"></i> Entregue', text: 'Entregue' },
    5: { color: 'danger', icon: '<i class="fa fa-remove"></i> Cancelado', text: 'Cancelado' },
    6: { color: 'success', icon: '<i class="fa fa-check-circle-o"></i> Disponível para retirada', text: 'Disponível para retirada' },
    7: { color: 'warning', icon: '<i class="fa fa-clock-o"></i> Aguardando Pagamento Pix', text: 'Aguardando Pagamento Pix' },
    8: { color: 'success', icon: '<i class="fa fa-calendar"></i> Pedido Agendado', text: 'Pedido Agendado' },
    9: { color: 'info', icon: '<i class="fa fa-check"></i> Pronto Para Retirada', text: 'Pronto Para Retirada' }
};

// 🎯 FUNÇÃO PARA ATUALIZAR CONTADORES DOS BADGES
function atualizarContadoresBadges(statusAntigo, statusNovo) {
    // Decrementar badge do status antigo
    if (statusAntigo && statusAntigo != statusNovo) {
        var $badgeAntigo = $('.filter-chip[data-status="' + statusAntigo + '"] .badge');
        if ($badgeAntigo.length) {
            var valorAntigo = parseInt($badgeAntigo.text()) || 0;
            if (valorAntigo > 0) {
                $badgeAntigo.text(valorAntigo - 1);
            }
        }
    }
    
    // Incrementar badge do status novo
    var $badgeNovo = $('.filter-chip[data-status="' + statusNovo + '"] .badge');
    if ($badgeNovo.length) {
        var valorNovo = parseInt($badgeNovo.text()) || 0;
        $badgeNovo.text(valorNovo + 1);
        
        // Animação visual
        $badgeNovo.css({
            'background': '#28a745',
            'color': 'white',
            'transform': 'scale(1.3)',
            'transition': 'all 0.3s ease'
        });
        setTimeout(function() {
            $badgeNovo.css({
                'background': '',
                'color': '',
                'transform': '',
                'transition': ''
            });
        }, 800);
    }
}

// Função para atualizar visualmente a linha do pedido
function atualizarLinhaPedido(pedidoId, novoStatus, entregadorNome) {
    var $row = $('#tr-' + pedidoId);
    var config = statusConfig[novoStatus];
    
    if (!$row.length || !config) return;
    
    // Pegar status antigo antes de atualizar
    var statusAntigo = parseInt($row.attr('data-status')) || 0;
    
    // Atualizar contadores dos badges
    if (statusAntigo != novoStatus) {
        atualizarContadoresBadges(statusAntigo, novoStatus);
    }
    
    // Remover classes de status antigas e adicionar nova
    $row.removeClass(function(index, className) {
        return (className.match(/(^|\s)status-\d+/g) || []).join(' ');
    }).addClass('status-' + novoStatus);
    
    // Atualizar data-status
    $row.attr('data-status', novoStatus);
    $row.attr('data-stat', novoStatus);
    
    // Atualizar cor de fundo de todas as células (EXCETO a coluna de ações)
    $row.find('td').not(':last').each(function() {
        $(this).removeClass(function(index, className) {
            return (className.match(/(^|\s)bg-\w+/g) || []).join(' ');
        }).addClass('bg-' + config.color);
    });
    
    // Atualizar coluna de status usando a classe específica
    $row.find('.col-status-pedido').html(config.icon);
    
    // Atualizar entregador se informado
    if (entregadorNome) {
        $row.find('.col-entregador').html('<i class="fa fa-motorcycle" aria-hidden="true"></i> ' + entregadorNome);
    }
    
    // Se cancelado, esconder botões de ação de status no dropdown
    if (novoStatus == 5) {
        $row.find('.btn-entrega, .btn-entregue, .btn-cancelado').closest('li').hide();
        $row.find('.btn-entrega, .btn-entregue, .btn-cancelado').closest('li').prev('.divider').hide();
    }
    
    // Efeito visual de destaque
    $row.css('transition', 'background-color 0.5s ease');
    $row.addClass('highlight-update');
    setTimeout(function() {
        $row.removeClass('highlight-update');
    }, 2000);
}

$(function() {
    // Adicionar CSS para efeito de destaque
    if (!$('#pedido-ajax-styles').length) {
        $('head').append('<style id="pedido-ajax-styles">' +
            '.highlight-update { animation: highlightFade 2s ease; }' +
            '@keyframes highlightFade { 0% { box-shadow: inset 0 0 0 3px #28a745; } 100% { box-shadow: none; } }' +
        '</style>');
    }
    
    // 🔒 FECHAR DROPDOWN ao clicar em qualquer item do menu
    $(document).on('click', '.dropdown-menu li a', function() {
        $(this).closest('.btn-group').removeClass('open');
    });
    
    // Usar delegação de eventos para funcionar com dropdown
    $(document).on('click', '.btn-remover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#modal-remove').modal('show');
        var id = $(this).data('id');
        
        $('.btn-confirma-remove').off('click').on('click', function() {
            var url = $('#form-remove').attr('action');
            $.post(url, { pedido_id: id }, function(rs) {
                $('#modal-remove').modal('hide');
                $('#tr-' + id).fadeOut(400, function() {
                    $(this).remove();
                });
                $.gritter.add({
                    title: '✅ Pedido Excluído',
                    text: 'Pedido #' + id + ' removido com sucesso!',
                    class_name: 'success',
                    time: 4000
                });
            });
            return false;
        });
    });

    // 🚚 SAIU PARA ENTREGA - AJAX sem refresh
    $(document).on('click', '.btn-entrega', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#modal-entrega').modal('show');
        var id = $(this).data('id');
        var cliente = $(this).data('cliente');
        var status = 3;

        $('.btn-confirma-entrega').off('click').on('click', function() {
            var url = $('#form-entrega').attr('action');
            var entregador = $('#pedido_entregador option:selected').val();
            var entregadorNome = $('#pedido_entregador option:selected').text();

            if (entregador == '0') {
                $('#pedido_entregador').focus();
                $.gritter.add({
                    title: '⚠️ Atenção',
                    text: 'Selecione um entregador!',
                    class_name: 'warning',
                    time: 3000
                });
                return false;
            }

            // Mostrar loading no botão
            var $btn = $(this);
            var btnOriginalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processando...');

            $.post(
                url, { pedido_id: id, pedido_entregador: entregador, pedido_cliente: cliente, pedido_status: status },
                function(rs) {
                    $('#modal-entrega').modal('hide');
                    $btn.prop('disabled', false).html(btnOriginalText);
                    
                    // Atualizar linha via AJAX
                    atualizarLinhaPedido(id, status, entregadorNome);
                    
                    $.gritter.add({
                        title: '🚚 Saiu para Entrega',
                        text: 'Pedido #' + id + ' enviado com ' + entregadorNome + '!',
                        class_name: 'success',
                        time: 4000
                    });
                    
                    // Resetar select do entregador
                    $('#pedido_entregador').val('0');
                }
            ).fail(function(xhr, status, error) {
                console.error('Erro na requisição:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status
                });
                
                $('#modal-entrega').modal('hide');
                $btn.prop('disabled', false).html(btnOriginalText);
                
                $.gritter.add({
                    title: '❌ Erro de Comunicação',
                    text: 'Erro ' + xhr.status + ': ' + (error || 'Falha na comunicação com o servidor'),
                    class_name: 'danger',
                    time: 6000
                });
            });
            return false;
        });
    });

    // ✅ CONFIRMAR ENTREGA - AJAX sem refresh
    $(document).on('click', '.btn-entregue', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#modal-entregue').modal('show');
        var id = $(this).data('id');
        var status = 4;
        
        $('.btn-confirma-entregue').off('click').on('click', function() {
            var url = $('#form-entregue').attr('action');
            
            // Mostrar loading no botão
            var $btn = $(this);
            var btnOriginalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processando...');
            
            $.post(url, { pedido_id: id, pedido_status: status }, function(rs) {
                $('#modal-entregue').modal('hide');
                $btn.prop('disabled', false).html(btnOriginalText);
                
                // Atualizar linha via AJAX
                atualizarLinhaPedido(id, status);
                
                $.gritter.add({
                    title: '✅ Entrega Confirmada',
                    text: 'Pedido #' + id + ' marcado como entregue!',
                    class_name: 'success',
                    time: 4000
                });
            }).fail(function(xhr, error, statusText) {
                $('#modal-entregue').modal('hide');
                $btn.prop('disabled', false).html(btnOriginalText);
                
                $.gritter.add({
                    title: '❌ Erro de Comunicação',
                    text: 'Erro ' + xhr.status + ': ' + (statusText || 'Falha na comunicação com o servidor'),
                    class_name: 'danger',
                    time: 6000
                });
            });
            
            return false;
        });
    });

    // ❌ CANCELAR PEDIDO - AJAX sem refresh
    $(document).on('click', '.btn-cancelado', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#modal-cancelado').modal('show');
        var id = $(this).data('id');
        var status = 5;
        
        $('.btn-confirma-cancelado').off('click').on('click', function() {
            var url = $('#form-cancelado').attr('action');
            
            // Mostrar loading no botão
            var $btn = $(this);
            var btnOriginalText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processando...');
            
            $.post(url, { pedido_id: id, pedido_status: status }, function(rs) {
                $('#modal-cancelado').modal('hide');
                $btn.prop('disabled', false).html(btnOriginalText);
                
                // Atualizar linha via AJAX
                atualizarLinhaPedido(id, status);
                
                $.gritter.add({
                    title: '❌ Pedido Cancelado',
                    text: 'Pedido #' + id + ' foi cancelado.',
                    class_name: 'warning',
                    time: 4000
                });
            }).fail(function(xhr, error, statusText) {
                $('#modal-cancelado').modal('hide');
                $btn.prop('disabled', false).html(btnOriginalText);
                
                $.gritter.add({
                    title: '❌ Erro de Comunicação',
                    text: 'Erro ' + xhr.status + ': ' + (statusText || 'Falha na comunicação com o servidor'),
                    class_name: 'danger',
                    time: 6000
                });
            });
            
            return false;
        });
    });
    
    // 🚚 NOTIFICAR ENTREGADOR VIA WHATSAPP
    var pedidoIdParaNotificar = null;
    
    // Função global para abrir modal de notificar entregador (usada nas notificações de recusa)
    window.abrirNotificarEntregador = function(pedidoId) {
        pedidoIdParaNotificar = pedidoId;
        
        // Resetar modal
        $('#select-entregador').val('');
        $('#notificar-loading').hide();
        $('#notificar-success').hide();
        $('#notificar-error').hide();
        $('#btn-confirmar-notificar').show();
        
        // Fechar notificações gritter
        $.gritter.removeAll();
        
        $('#modal-notificar-entregador').modal('show');
    };
    
    $(document).on('click', '.btn-notificar-entregador', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        pedidoIdParaNotificar = $(this).data('pedido-id');
        
        // Resetar modal
        $('#select-entregador').val('');
        $('#notificar-loading').hide();
        $('#notificar-success').hide();
        $('#notificar-error').hide();
        $('#btn-confirmar-notificar').show();
        
        $('#modal-notificar-entregador').modal('show');
    });
    
    $(document).on('click', '#btn-confirmar-notificar', function() {
        var entregadorId = $('#select-entregador').val();
        var entregadorNome = $('#select-entregador option:selected').text();
        
        if (!entregadorId) {
            $.gritter.add({
                title: '⚠️ Atenção',
                text: 'Selecione um entregador!',
                class_name: 'warning',
                time: 3000
            });
            $('#select-entregador').focus();
            return;
        }
        
        // Mostrar loading
        $('#btn-confirmar-notificar').hide();
        $('#notificar-loading').show();
        $('#notificar-success').hide();
        $('#notificar-error').hide();
        
        // Enviar notificação
        $.ajax({
            url: window.baseUri + '/api/bot-notificar-entregador.php',
            method: 'POST',
            data: {
                pedido_id: pedidoIdParaNotificar,
                entregador_id: entregadorId
            },
            dataType: 'json',
            timeout: 15000
        }).done(function(response) {
            $('#notificar-loading').hide();
            
            if (response.success) {
                $('#notificar-success-msg').html(
                    'Entregador <strong>' + entregadorNome + '</strong> notificado!<br>' +
                    'Código de confirmação: <strong>' + response.codigo + '</strong>'
                );
                $('#notificar-success').show();
                
                $.gritter.add({
                    title: '✅ Notificação Enviada!',
                    text: entregadorNome + ' recebeu os dados do pedido via WhatsApp!',
                    class_name: 'success',
                    time: 5000
                });
                
                // Fechar modal e atualizar status na tela
                setTimeout(function() {
                    $('#modal-notificar-entregador').modal('hide');
                    
                    // Atualizar badge de status sem reload
                    var $statusBadge = $('.pedido-' + pedidoId + ' .badge-status');
                    $statusBadge.removeClass('badge-warning').addClass('badge-info').text('Notificado');
                    
                    // Atualizar botão (desabilitar)
                    var $btnNotificar = $('.pedido-' + pedidoId + ' .btn-notificar-entregador');
                    $btnNotificar.prop('disabled', true).html('<i class="fa fa-check"></i> Já Notificado');
                }, 3000);
            } else {
                $('#notificar-error-msg').text(response.message || 'Erro desconhecido');
                $('#notificar-error').show();
                $('#btn-confirmar-notificar').show();
                
                $.gritter.add({
                    title: '❌ Erro ao Notificar',
                    text: response.message || 'Erro ao enviar notificação',
                    class_name: 'danger',
                    time: 5000
                });
            }
        }).fail(function(xhr, status, error) {
            $('#notificar-loading').hide();
            $('#notificar-error-msg').text('Erro de comunicação: ' + (error || 'Falha na conexão'));
            $('#notificar-error').show();
            $('#btn-confirmar-notificar').show();
            
            $.gritter.add({
                title: '❌ Erro de Comunicação',
                text: 'Não foi possível conectar ao servidor. Verifique sua conexão.',
                class_name: 'danger',
                time: 5000
            });
        });
    });
});