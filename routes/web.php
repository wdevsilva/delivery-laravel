<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\FidelidadeController;
use App\Http\Controllers\CozinhaController;
use App\Http\Controllers\Mesa\MesaController;
use App\Http\Controllers\Mesa\GarconController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Manifest PWA
Route::get('/generate-manifest.php', function() {
    ob_start();
    include public_path('generate-manifest.php');
    $content = ob_get_clean();
    return response($content)->header('Content-Type', 'application/json');
});

// Autenticação Admin
Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/entrar', [LoginController::class, 'entrar'])->name('login.entrar');
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::get('/solicitar-reset', [LoginController::class, 'solicitarReset'])->name('login.solicitar-reset');
    Route::get('/redefinir-senha', [LoginController::class, 'redefinirSenha'])->name('login.redefinir-senha');
    Route::post('/processar-redefinir-senha', [LoginController::class, 'processarRedefinirSenha'])->name('login.processar-redefinir');
});

// Autenticação Cliente
Route::prefix('cliente')->group(function () {
    Route::get('/entrar', [ClienteLoginController::class, 'index'])->name('cliente.login');
    Route::post('/login', [ClienteLoginController::class, 'entrar'])->name('cliente.entrar');
    Route::get('/sair', [ClienteLoginController::class, 'logout'])->name('cliente.logout');
    Route::get('/recupera-senha', [ClienteLoginController::class, 'recuperaSenha'])->name('cliente.recupera-senha');
    Route::post('/nova-senha', [ClienteLoginController::class, 'novaSenha'])->name('cliente.nova-senha');
});

// Rotas Públicas - Cardápio e Produtos
Route::get('/promocoes', [ItemController::class, 'promocoes'])->name('promocoes');
Route::get('/item/{id}', [ItemController::class, 'show'])->name('item.show');
Route::get('/categoria/{id}', [App\Http\Controllers\CategoriaController::class, 'show'])->name('categoria.show');

// Carrinho (público)
Route::prefix('carrinho')->group(function () {
    Route::get('/', [CarrinhoController::class, 'index'])->name('carrinho.index');
    Route::post('/adicionar', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
    Route::post('/remover', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
    Route::post('/atualizar', [CarrinhoController::class, 'atualizar'])->name('carrinho.atualizar');
    Route::get('/checkout', [CarrinhoController::class, 'checkout'])->name('carrinho.checkout');
    Route::post('/finalizar', [CarrinhoController::class, 'finalizar'])->name('carrinho.finalizar');

    // Rotas AJAX para atualização do carrinho
    Route::match(['GET', 'POST'], '/reload', [CarrinhoController::class, 'reload']);
    Route::post('/get_count_js', [CarrinhoController::class, 'getCountJs']);
    Route::post('/get_count_bag', [CarrinhoController::class, 'getCountBag']);
    Route::post('/dispensar_bebidas', [CarrinhoController::class, 'dispensarBebidas']);
});

// Cupons
Route::prefix('cupom')->group(function () {
    Route::get('/validar/{codigo}', [CupomController::class, 'validar'])->name('cupom.validar');
    Route::post('/aplicar', [CupomController::class, 'aplicar'])->name('cupom.aplicar');
});

// Área do Cliente (SEM AUTH TEMPORÁRIAMENTE)
Route::group([], function () {
    Route::get('/meus-pedidos', [PedidoController::class, 'lista'])->name('cliente.pedidos');
    Route::get('/pedido/{id}', [PedidoController::class, 'detalhes'])->name('cliente.pedido.detalhes');
    Route::get('/meus-enderecos', [ClienteController::class, 'enderecos'])->name('cliente.enderecos');
    Route::post('/endereco/salvar', [ClienteController::class, 'salvarEndereco'])->name('cliente.endereco.salvar');
    Route::delete('/endereco/{id}', [ClienteController::class, 'removerEndereco'])->name('cliente.endereco.remover');
    Route::get('/meus-dados', [ClienteController::class, 'dados'])->name('cliente.dados');
    Route::post('/dados/salvar', [ClienteController::class, 'salvarDados'])->name('cliente.dados.salvar');

    // Fidelidade
    Route::get('/fidelidade', [FidelidadeController::class, 'index'])->name('cliente.fidelidade');
    Route::get('/fidelidade/saldo', [FidelidadeController::class, 'saldo'])->name('cliente.fidelidade.saldo');
    Route::post('/fidelidade/resgatar', [FidelidadeController::class, 'resgatar'])->name('cliente.fidelidade.resgatar');
});

// Área Administrativa (SEM AUTH TEMPORARIAMENTE PARA TESTE)
Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.main');

    // Pedidos
    Route::get('/pedidos', [PedidoController::class, 'admin'])->name('admin.pedidos');
    Route::get('/pedido/{id}', [PedidoController::class, 'show'])->name('admin.pedido.show');
    Route::post('/pedido/{id}/atualizar-status', [PedidoController::class, 'atualizarStatus'])->name('admin.pedido.atualizar-status');
    Route::delete('/pedido/{id}', [PedidoController::class, 'destroy'])->name('admin.pedido.remover');

    // Produtos/Itens
    Route::resource('item', ItemController::class)->names('admin.item');

    // Cupons
    Route::resource('cupom', CupomController::class)->names('admin.cupom');

    // Cozinha
    Route::prefix('cozinha')->group(function () {
        Route::get('/', [CozinhaController::class, 'index'])->name('admin.cozinha');
        Route::get('/display', [CozinhaController::class, 'display'])->name('admin.cozinha.display');
        Route::get('/get-novos-pedidos', [CozinhaController::class, 'getNovos'])->name('admin.cozinha.novos');
        Route::post('/atualizar-status', [CozinhaController::class, 'atualizarStatus'])->name('admin.cozinha.status');
        Route::post('/iniciar-preparo', [CozinhaController::class, 'iniciarPreparo'])->name('admin.cozinha.iniciar');
        Route::post('/marcar-pronto', [CozinhaController::class, 'marcarPronto'])->name('admin.cozinha.pronto');
    });

    // Módulo de Mesas
    Route::prefix('mesa')->group(function () {
        Route::get('/', [MesaController::class, 'index'])->name('admin.mesa');
        Route::get('/lista', [MesaController::class, 'lista'])->name('admin.mesa.lista');
        Route::get('/novo', [MesaController::class, 'novo'])->name('admin.mesa.novo');
        Route::post('/gravar', [MesaController::class, 'gravar'])->name('admin.mesa.gravar');
        Route::get('/editar/{id}', [MesaController::class, 'editar'])->name('admin.mesa.editar');
        Route::delete('/{id}', [MesaController::class, 'remover'])->name('admin.mesa.remover');
        Route::post('/ocupar', [MesaController::class, 'ocupar'])->name('admin.mesa.ocupar');
        Route::post('/liberar', [MesaController::class, 'liberar'])->name('admin.mesa.liberar');
    });

    // Garçons
    Route::prefix('garcon')->group(function () {
        Route::get('/', [GarconController::class, 'lista'])->name('admin.garcon');
        Route::get('/novo', [GarconController::class, 'novo'])->name('admin.garcon.novo');
        Route::post('/salvar', [GarconController::class, 'salvar'])->name('admin.garcon.salvar');
        Route::get('/editar/{id}', [GarconController::class, 'editar'])->name('admin.garcon.editar');
        Route::delete('/{id}', [GarconController::class, 'excluir'])->name('admin.garcon.excluir');
    });
});

// Área do Garçon
Route::prefix('garcon')->middleware(['auth:garcon'])->group(function () {
    Route::get('/', [GarconController::class, 'index'])->name('garcon.index');
    Route::get('/mesas', [GarconController::class, 'mesas'])->name('garcon.mesas');
    Route::get('/cardapio/{mesa_id}', [GarconController::class, 'cardapio'])->name('garcon.cardapio');
    Route::post('/fazer-pedido', [GarconController::class, 'fazerPedido'])->name('garcon.fazer-pedido');
    Route::get('/pedidos-mesa/{mesa_id}', [GarconController::class, 'pedidosMesa'])->name('garcon.pedidos-mesa');
});

// Cozinha Display (sem autenticação para tela dedicada)
Route::prefix('cozinha')->group(function () {
    Route::get('/display', [CozinhaController::class, 'display'])->name('cozinha.display');
    Route::get('/get-novos-pedidos', [CozinhaController::class, 'getNovos'])->name('cozinha.novos');
});

// Rastreamento de Entrega (público)
Route::get('/track/{code}', [PedidoController::class, 'track'])->name('pedido.track');
Route::get('/rastrear/{code}', [PedidoController::class, 'track'])->name('pedido.rastrear');
