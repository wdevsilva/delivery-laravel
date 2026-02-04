<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EntregadorController;
use App\Http\Controllers\Api\BotWhatsappController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\FidelidadeController;
use App\Http\Controllers\PedidoController;

// API de Autenticação (Sanctum)
Route::post('/login', [EntregadorController::class, 'login']);
Route::post('/register', [EntregadorController::class, 'register']);

// APIs do Entregador (autenticadas)
Route::middleware('auth:sanctum')->prefix('entregador')->group(function () {
    Route::get('/profile', [EntregadorController::class, 'profile']);
    Route::put('/profile', [EntregadorController::class, 'updateProfile']);
    Route::get('/current-orders', [EntregadorController::class, 'currentOrders']);
    Route::get('/latest-orders', [EntregadorController::class, 'latestOrders']);
    Route::post('/accept-order/{id}', [EntregadorController::class, 'acceptOrder']);
    Route::post('/start-delivery/{id}', [EntregadorController::class, 'startDelivery']);
    Route::post('/complete-delivery/{id}', [EntregadorController::class, 'completeDelivery']);
    Route::post('/update-location', [EntregadorController::class, 'updateLocation']);
    Route::get('/stats', [EntregadorController::class, 'stats']);
});

// API do Bot WhatsApp
Route::prefix('bot')->group(function () {
    Route::post('/webhook', [BotWhatsappController::class, 'webhook']);
    Route::post('/get-base', [BotWhatsappController::class, 'getBase']);
    Route::post('/atendimento', [BotWhatsappController::class, 'atendimento']);
    Route::get('/check-aberto', [BotWhatsappController::class, 'checkAberto']);
    Route::post('/send-message', [BotWhatsappController::class, 'sendMessage']);
    Route::post('/validar-comprovante', [BotWhatsappController::class, 'validarComprovante']);
    Route::get('/verificar-pedidos-pix', [BotWhatsappController::class, 'verificarPedidosPix']);
    Route::post('/confirmar-entrega', [BotWhatsappController::class, 'confirmarEntrega']);
    Route::post('/notificar-status-pedido', [BotWhatsappController::class, 'notificarStatusPedido']);
});

// API de Cupons (pública)
Route::prefix('cupom')->group(function () {
    Route::get('/get_cupom_ativo', [CupomController::class, 'getCupomAtivo']);
    Route::post('/ativar', [CupomController::class, 'ativar']);
    Route::post('/validar', [CupomController::class, 'validar']);
});

// API de Fidelidade
Route::prefix('fidelidade')->group(function () {
    Route::get('/saldo/{cliente_id}', [FidelidadeController::class, 'saldo']);
    Route::post('/aplicar-desconto', [FidelidadeController::class, 'aplicarDesconto']);
    Route::post('/resgatar', [FidelidadeController::class, 'resgatar']);
});

// API de Pedidos (pública - rastreamento)
Route::prefix('pedido')->group(function () {
    Route::get('/track/{code}', [PedidoController::class, 'trackApi']);
    Route::get('/status/{id}', [PedidoController::class, 'statusApi']);
});

// API de Avaliações
Route::prefix('avaliacoes')->group(function () {
    Route::get('/por-cliente/{cliente_id}', function($cliente_id) {
        return response()->json(['message' => 'Em desenvolvimento']);
    });
    Route::post('/responder', function() {
        return response()->json(['message' => 'Em desenvolvimento']);
    });
    Route::get('/estatisticas', function() {
        return response()->json(['message' => 'Em desenvolvimento']);
    });
});

// Webhook Mercado Pago
Route::post('/notification', function(Request $request) {
    // Lógica de notificação Mercado Pago
    return response()->json(['status' => 'received']);
});

// User info (Sanctum)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
