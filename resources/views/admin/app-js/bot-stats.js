// 📊 FUNÇÕES DE MONITORAMENTO DE ESTATÍSTICAS

// Variável para controlar atualização automática
var statsUpdateInterval = null;

// Carregar estatísticas do bot
function carregarEstatisticas() {
    // Verificar se whatsappBaseUri está definida
    if (typeof whatsappBaseUri === 'undefined') {
        console.warn('[BOT-STATS] whatsappBaseUri não está definida. Estatísticas não carregadas.');
        return;
    }
    
    $.ajax({
        url: whatsappBaseUri + '/api/bot-get-stats.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Atualizar cards principais
                $('#stat-msgs-hoje').addClass('stat-update').text(response.hoje.mensagens_enviadas);
                $('#stat-fila-pendente').addClass('stat-update').text(response.fila.pendentes);
                
                // Atualizar status da fila
                if (response.fila.pendentes > 0) {
                    if (response.fila.processando) {
                        $('#stat-fila-status').html('<i class="fa fa-cog fa-spin"></i> Processando...');
                    } else {
                        $('#stat-fila-status').html('<i class="fa fa-pause"></i> Bot desconectado');
                    }
                } else {
                    $('#stat-fila-status').html('<i class="fa fa-check"></i> Fila vazia');
                }
                
                // Atualizar pedidos por status
                $('#pedido-producao').addClass('stat-update').text(response.hoje.por_status.em_producao);
                $('#pedido-saiu-entrega').addClass('stat-update').text(response.hoje.por_status.saiu_entrega);
                $('#pedido-entregue').addClass('stat-update').text(response.hoje.por_status.entregues);
                $('#pedido-cancelado').addClass('stat-update').text(response.hoje.por_status.cancelados);
                $('#pedido-pronto').addClass('stat-update').text(response.hoje.por_status.prontos);
                $('#pedido-total').addClass('stat-update').text(response.hoje.pedidos_total);
                
                // Remover animação após 500ms
                setTimeout(function() {
                    $('.stat-update').removeClass('stat-update');
                }, 500);
                
                // Atualizar rate limits
                renderizarRateLimits(response.rate_limits);
                
            } else {
                console.error('Erro ao carregar estatísticas:', response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Erro ao buscar estatísticas:', error);
        }
    });
}

// Renderizar lista de rate limits
function renderizarRateLimits(rateLimits) {
    var container = $('#rate-limits-container');
    
    if (!rateLimits || rateLimits.length === 0) {
        container.html(
            '<div class="text-center" style="padding: 40px; color: #95a5a6;">' +
            '<i class="fa fa-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>' +
            '<p style="margin: 0; font-size: 14px;">Nenhum envio recente</p>' +
            '</div>'
        );
        return;
    }
    
    var html = '';
    
    rateLimits.forEach(function(limite) {
        // Determinar cor da barra baseada no percentual
        var corHora = '#28a745';
        if (limite.percentual_hora > 75) corHora = '#dc3545';
        else if (limite.percentual_hora > 50) corHora = '#ffc107';
        
        var corDia = '#28a745';
        if (limite.percentual_dia > 75) corDia = '#dc3545';
        else if (limite.percentual_dia > 50) corDia = '#ffc107';
        
        // Formatar telefone
        var telefoneFormatado = limite.telefone;
        if (limite.telefone.length === 13) {
            telefoneFormatado = '+' + limite.telefone.substring(0, 2) + ' (' + limite.telefone.substring(2, 4) + ') ' + limite.telefone.substring(4, 9) + '-' + limite.telefone.substring(9);
        }
        
        html += '<div style="border-bottom: 1px solid #f0f0f0; padding: 15px 0;">';
        html += '  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">';
        html += '    <strong style="font-size: 13px; color: #2c3e50;"><i class="fa fa-user" style="color: #6f42c1; margin-right: 5px;"></i>' + telefoneFormatado + '</strong>';
        html += '  </div>';
        
        // Barra de progresso - Por Hora
        html += '  <div style="margin-bottom: 8px;">';
        html += '    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #6c757d; margin-bottom: 3px;">';
        html += '      <span><i class="fa fa-clock-o"></i> Por Hora</span>';
        html += '      <span><strong>' + limite.msgs_hora + '</strong>/' + limite.limite_hora + ' (' + limite.percentual_hora + '%)</span>';
        html += '    </div>';
        html += '    <div style="height: 6px; background: #e9ecef; border-radius: 3px; overflow: hidden;">';
        html += '      <div style="height: 100%; background: ' + corHora + '; width: ' + limite.percentual_hora + '%; transition: width 0.3s ease;"></div>';
        html += '    </div>';
        html += '  </div>';
        
        // Barra de progresso - Por Dia
        html += '  <div>';
        html += '    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #6c757d; margin-bottom: 3px;">';
        html += '      <span><i class="fa fa-calendar"></i> Por Dia</span>';
        html += '      <span><strong>' + limite.msgs_dia + '</strong>/' + limite.limite_dia + ' (' + limite.percentual_dia + '%)</span>';
        html += '    </div>';
        html += '    <div style="height: 6px; background: #e9ecef; border-radius: 3px; overflow: hidden;">';
        html += '      <div style="height: 100%; background: ' + corDia + '; width: ' + limite.percentual_dia + '%; transition: width 0.3s ease;"></div>';
        html += '    </div>';
        html += '  </div>';
        html += '</div>';
    });
    
    container.html(html);
}

// Botão de atualizar estatísticas
$('#btn-atualizar-stats').click(function() {
    var btn = $(this);
    var icon = btn.find('i');
    
    // Adicionar animação de rotação
    icon.addClass('fa-spin');
    btn.prop('disabled', true);
    
    carregarEstatisticas();
    
    // Remover animação após 1s
    setTimeout(function() {
        icon.removeClass('fa-spin');
        btn.prop('disabled', false);
    }, 1000);
});

// Carregar estatísticas ao iniciar
carregarEstatisticas();

// Atualizar automaticamente a cada 10 segundos
statsUpdateInterval = setInterval(function() {
    carregarEstatisticas();
}, 10000);

// Parar atualização quando sair da página
$(window).on('beforeunload', function() {
    if (statsUpdateInterval) {
        clearInterval(statsUpdateInterval);
    }
});
