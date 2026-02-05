/**
 * Sistema de Monitoramento de Cupons Automáticos
 * Detecta quando o carrinho atinge o valor mínimo e exibe popup de cupom
 */

$(document).ready(function() {
    'use strict';
    
    // Obter baseUri
    var BASE_URI = (function() {
        var baseTag = document.querySelector('base');
        if (baseTag && baseTag.href) {
            var url = new URL(baseTag.href);
            return url.pathname.replace(/\/$/, '');
        }
        return window.baseUri || '';
    })();
    
    // Configurações
    var CONFIG = {
        checkInterval: 1000,
        cupomKey: 'cupom_automatico_exibido'
    };
    
    // Estado
    var lastCartValue = 0;
    var cupomData = null;
    var popupJaExibido = false;
    
    /**
     * Busca cupons ativos disponíveis
     */
    function buscarCupomAtivo(callback) {
        var url = BASE_URI + '/api-cupom-ativo.php';
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                callback(data);
            },
            error: function() {
                callback(null);
            }
        });
    }
    
    /**
     * Obtém o valor atual do carrinho
     */
    function getValorCarrinho() {
        var valor = 0;
        
        var pedidoTotalInput = document.getElementById('pedido_total');
        if (pedidoTotalInput && pedidoTotalInput.value) {
            valor = parseFloat(pedidoTotalInput.value.replace(',', '.')) || 0;
            return valor;
        }
        
        var pedidoTotalEl = document.getElementById('pedido-total');
        if (pedidoTotalEl && pedidoTotalEl.textContent) {
            var texto = pedidoTotalEl.textContent.replace('R$', '').replace(/\./g, '').replace(',', '.').trim();
            valor = parseFloat(texto) || 0;
            return valor;
        }
        
        return 0;
    }
    
    /**
     * Verifica se o cupom já foi usado pelo cliente
     */
    function cupomJaUsado() {
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var parts = cookies[i].trim().split('=');
            if (parts[0] === 'popupcupom' && cupomData && parts[1] == cupomData.cupom_id) {
                return true;
            }
        }
        
        var exibido = sessionStorage.getItem(CONFIG.cupomKey);
        if (exibido && cupomData && exibido == cupomData.cupom_id) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Limpa histórico de cupom (para testes)
     */
    window.limparHistoricoCupom = function() {
        document.cookie = 'popupcupom=; path=/; max-age=0';
        sessionStorage.removeItem(CONFIG.cupomKey);
    };
    
    /**
     * Exibe o popup de cupom
     */
    function exibirPopupCupom() {
        if (!cupomData || popupJaExibido || cupomJaUsado()) {
            return;
        }
        
        popupJaExibido = true;
        sessionStorage.setItem(CONFIG.cupomKey, cupomData.cupom_id);
        
        var desconto = cupomData.cupom_tipo == 1 
            ? 'R$ ' + parseFloat(cupomData.cupom_valor).toFixed(2).replace('.', ',')
            : cupomData.cupom_percent + '%';
        
        x0p({
            title: 'Cupom# ' + cupomData.cupom_nome,
            text: 'Parabéns! Você ganhou ' + desconto + ' de desconto!',
            animationType: 'slideUp',
            icon: 'info',
            buttons: [
                {
                    type: 'error',
                    text: 'Cancelar'
                },
                {
                    type: 'ok',
                    text: '<i class="fa fa-check"></i> Ativar Cupom'
                }
            ]
        }).then(function(data) {
            if (data.button === 'ok') {
                ativarCupom();
            } else {
                document.cookie = 'popupcupom=' + cupomData.cupom_id + '; path=/; max-age=' + (86400 * 7);
            }
        });
    }
    
    /**
     * Ativa o cupom via AJAX
     */
    function ativarCupom() {
        var valorAtual = getValorCarrinho();
        var valorMinimo = parseFloat(cupomData.cupom_valor_minimo) || 0;
        
        if (valorMinimo > 0 && valorAtual < valorMinimo) {
            var msg = 'Valor mínimo não atingido! Carrinho: R$ ' + valorAtual.toFixed(2) + ' | Mínimo: R$ ' + valorMinimo.toFixed(2);
            x0p({
                title: 'Opss...',
                text: msg,
                icon: 'error'
            });
            return;
        }
        
        var clienteId = $('[data-cliente-id]').data('cliente-id') || 1;
        
        $.post(BASE_URI + '/api-cupom-ativar.php', {
            codigodocupom: cupomData.cupom_nome,
            user_id: clienteId
        }).done(function(resp) {
            if (typeof resp === 'string') {
                try {
                    resp = JSON.parse(resp);
                } catch(e) {}
            }
            
            var erros = {
                erro0: 'Cupom inválido!',
                erro1: 'Cupom vencido!',
                erro2: 'Esse cupom expirou!',
                erro3: 'Ocorreu um erro ao validar!',
                erro4: 'Você já tem um desconto ativo!'
            };
            
            if (resp && resp.status && resp.status.toString().indexOf('erro') === 0) {
                x0p({
                    title: 'Opss...',
                    text: resp.message || erros[resp.status] || 'Erro desconhecido!',
                    icon: 'error'
                });
            } else {
                document.cookie = 'popupcupom=' + cupomData.cupom_id + '; path=/; max-age=' + (86400 * 7);
                
                x0p({
                    title: 'Parabéns!',
                    text: 'Desconto aplicado! 😍',
                    icon: 'ok'
                }).then(function() {
                    window.location.reload();
                });
            }
        }).fail(function() {
            x0p({
                title: 'Erro',
                text: 'Erro ao ativar cupom. Tente novamente.',
                icon: 'error'
            });
        });
    }
    
    /**
     * Verifica se deve exibir o cupom
     */
    function verificarCupom() {
        var valorAtual = getValorCarrinho();
        
        if (valorAtual === lastCartValue) {
            return;
        }
        
        lastCartValue = valorAtual;
        
        if (!cupomData) {
            buscarCupomAtivo(function(data) {
                cupomData = data;
                if (!cupomData) {
                    return;
                }
                processarCupom(valorAtual);
            });
        } else {
            processarCupom(valorAtual);
        }
    }
    
    function processarCupom(valorAtual) {
        if (cupomJaUsado()) {
            return;
        }
        
        var valorMinimo = parseFloat(cupomData.cupom_valor_minimo) || 0;
        
        if (valorAtual >= valorMinimo && valorAtual > 0) {
            exibirPopupCupom();
        }
    }
    
    // Inicia o monitoramento após 1 segundo
    setTimeout(function() {
        verificarCupom();
        setInterval(verificarCupom, CONFIG.checkInterval);
    }, 1000);
});
