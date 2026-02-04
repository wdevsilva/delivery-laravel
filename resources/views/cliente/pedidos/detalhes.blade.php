@extends('layouts.app')

@section('title', 'Detalhes do Pedido #' . $pedido->pedido_id)

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('cliente.pedidos') }}" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
        <h2><i class="bi bi-receipt"></i> Pedido #{{ $pedido->pedido_id }}</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Itens do Pedido -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-basket"></i> Itens do Pedido</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qtd</th>
                                <th>Preço Unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->itens as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->lista_item_nome }}</strong>
                                        @if($item->lista_opcao_nome)
                                            <br><small class="text-muted">+ {{ $item->lista_opcao_nome }}</small>
                                        @endif
                                        @if($item->lista_item_obs)
                                            <br><small class="text-muted"><i>Obs: {{ $item->lista_item_obs }}</i></small>
                                        @endif
                                    </td>
                                    <td>{{ $item->lista_qtde }}x</td>
                                    <td>R$ {{ number_format($item->lista_item_preco, 2, ',', '.') }}</td>
                                    <td><strong>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Observações -->
        @if($pedido->pedido_obs)
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-chat-left-text"></i> Observações</h6>
                </div>
                <div class="card-body">
                    {{ $pedido->pedido_obs }}
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Status do Pedido -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-truck"></i> Status</h5>
            </div>
            <div class="card-body text-center">
                @if($pedido->pedido_status == 1)
                    <i class="bi bi-clock-history text-warning" style="font-size: 3rem;"></i>
                    <h4 class="mt-2">Pendente</h4>
                    <p class="text-muted">Aguardando confirmação</p>
                @elseif($pedido->pedido_status == 2)
                    <i class="bi bi-fire text-info" style="font-size: 3rem;"></i>
                    <h4 class="mt-2">Em Preparo</h4>
                    <p class="text-muted">Seu pedido está sendo preparado</p>
                @elseif($pedido->pedido_status == 3)
                    <i class="bi bi-truck text-primary" style="font-size: 3rem;"></i>
                    <h4 class="mt-2">Saiu para Entrega</h4>
                    <p class="text-muted">Pedido a caminho!</p>
                @elseif($pedido->pedido_status == 4)
                    <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                    <h4 class="mt-2">Entregue</h4>
                    <p class="text-muted">Pedido concluído</p>
                @else
                    <i class="bi bi-x-circle text-danger" style="font-size: 3rem;"></i>
                    <h4 class="mt-2">Cancelado</h4>
                    <p class="text-muted">Pedido cancelado</p>
                @endif
            </div>
        </div>

        <!-- Resumo do Pedido -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-calculator"></i> Resumo</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <strong>R$ {{ number_format($pedido->pedido_total - $pedido->pedido_entrega, 2, ',', '.') }}</strong>
                </div>
                @if($pedido->pedido_desconto > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Desconto:</span>
                        <strong>- R$ {{ number_format($pedido->pedido_desconto, 2, ',', '.') }}</strong>
                    </div>
                @endif
                @if($pedido->pedido_entrega > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Taxa de entrega:</span>
                        <strong>R$ {{ number_format($pedido->pedido_entrega, 2, ',', '.') }}</strong>
                    </div>
                @endif
                <hr>
                <div class="d-flex justify-content-between">
                    <h5>Total:</h5>
                    <h5 class="text-primary">R$ {{ number_format($pedido->pedido_total, 2, ',', '.') }}</h5>
                </div>

                <hr>

                <p class="mb-1"><small><i class="bi bi-calendar"></i> Data do pedido:</small></p>
                <p><strong>{{ $pedido->pedido_data ? $pedido->pedido_data->format('d/m/Y H:i') : '-' }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
