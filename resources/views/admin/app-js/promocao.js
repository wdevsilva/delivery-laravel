/**
 * Promoções - JavaScript
 * Sistema de promoções com AJAX
 * 
 * Nota: A maior parte da lógica foi movida para as views
 * Este arquivo é mantido para compatibilidade e funções auxiliares
 */

$(function() {
    'use strict';
    
    // Função auxiliar para exibir notificações
    window.showPromoNotification = function(message, type) {
        type = type || 'success';
        $.gritter.add({
            title: type === 'success' ? 'Sucesso!' : 'Atenção!',
            text: message,
            class_name: type === 'success' ? 'success' : 'danger',
            time: 3000,
            before_open: function() {
                if ($('.gritter-item-wrapper').length >= 3) {
                    return false;
                }
            }
        });
    };
    
    // Função auxiliar para formatar moeda
    window.formatCurrency = function(value) {
        return parseFloat(value).toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
    };
    
    // Função auxiliar para confirmar ações
    window.confirmAction = function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    };
});