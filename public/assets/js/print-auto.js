/**
 * Sistema de impressão USB
 */

function imprimirPedido(pedidoId, isPix) {
    isPix = isPix || false;
    var baseUri = '/delivery'; // Ajustar conforme necessário
    var url = isPix ? 
        baseUri + '/admin/imprimirPix/' + pedidoId + '/' :
        baseUri + '/admin/imprimir/' + pedidoId + '/';
    window.open(url, '_blank');
}

// Função de compatibilidade para código legado
function imprimirTermica(pedidoId) {
    imprimirPedido(pedidoId, false);
}
