@extends('layouts.app')

@section('title', 'Dashboard Admin - Delicias no Pote')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-speedometer2"></i> Dashboard Administrativo</h2>
        <p class="text-muted">Visão geral do sistema - Delicias no Pote</p>
    </div>
</div>

<!-- Cards de Estatísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Pedidos</h6>
                        <h2 class="mb-0">{{ number_format($totalPedidos, 0, ',', '.') }}</h2>
                        <small>{{ $pedidosHoje }} hoje</small>
                    </div>
                    <i class="bi bi-bag-check" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Faturamento Total</h6>
                        <h2 class="mb-0">R$ {{ number_format($faturamentoTotal, 2, ',', '.') }}</h2>
                        <small>R$ {{ number_format($faturamentoHoje, 2, ',', '.') }} hoje</small>
                    </div>
                    <i class="bi bi-currency-dollar" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Clientes</h6>
                        <h2 class="mb-0">{{ number_format($totalClientes, 0, ',', '.') }}</h2>
                        <small>cadastrados</small>
                    </div>
                    <i class="bi bi-people" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Produtos</h6>
                        <h2 class="mb-0">{{ number_format($totalProdutos, 0, ',', '.') }}</h2>
                        <small>no cardápio</small>
                    </div>
                    <i class="bi bi-basket" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Últimos Pedidos -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Últimos Pedidos</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosPedidos as $pedido)
                                <tr>
                                    <td><strong>#{{ $pedido->pedido_id }}</strong></td>
                                    <td>{{ $pedido->cliente ? $pedido->cliente->cliente_nome : 'N/A' }}</td>
                                    <td>{{ $pedido->pedido_data ? $pedido->pedido_data->format('d/m/Y H:i') : '-' }}</td>
                                    <td><strong>R$ {{ number_format($pedido->pedido_total, 2, ',', '.') }}</strong></td>
                                    <td>
                                        @if($pedido->pedido_status == 1)
                                            <span class="badge bg-warning">Pendente</span>
                                        @elseif($pedido->pedido_status == 2)
                                            <span class="badge bg-info">Em Preparo</span>
                                        @elseif($pedido->pedido_status == 3)
                                            <span class="badge bg-primary">Saiu para Entrega</span>
                                        @elseif($pedido->pedido_status == 4)
                                            <span class="badge bg-success">Entregue</span>
                                        @else
                                            <span class="badge bg-danger">Cancelado</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Nenhum pedido encontrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Produtos Mais Vendidos -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-trophy"></i> Mais Vendidos</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($produtosMaisVendidos as $index => $produto)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-primary me-2">{{ $index + 1 }}º</span>
                                <strong>{{ $produto->item_nome }}</strong>
                            </div>
                            <span class="badge bg-success rounded-pill">{{ $produto->total_vendido }} vendidos</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            Nenhum produto vendido ainda
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-success">
            <h5><i class="bi bi-check-circle"></i> Sistema Laravel Funcionando!</h5>
            <ul class="mb-0">
                <li>✅ Conectado ao banco: <strong>pediuzap10_deliciasnopote</strong></li>
                <li>✅ Models Eloquent com relacionamentos funcionando</li>
                <li>✅ Dashboard com dados reais da loja</li>
                <li>✅ Sistema pronto para desenvolvimento completo</li>
            </ul>
        </div>
    </div>
</div>
@endsection
