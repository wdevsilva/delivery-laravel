@extends('layouts.app')

@section('title', 'Meus Pedidos')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-bag-check"></i> Meus Pedidos</h2>
        <p class="text-muted">Acompanhe seus pedidos</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if($pedidos->count() > 0)
            @foreach($pedidos as $pedido)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="card-title">
                                    Pedido #{{ $pedido->pedido_id }}
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
                                </h5>
                                <p class="mb-1">
                                    <i class="bi bi-calendar"></i>
                                    {{ $pedido->pedido_data ? $pedido->pedido_data->format('d/m/Y H:i') : '-' }}
                                </p>
                                <p class="mb-0">
                                    <strong>Total:</strong> R$ {{ number_format($pedido->pedido_total, 2, ',', '.') }}
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="{{ route('cliente.pedido.detalhes', $pedido->pedido_id) }}" class="btn btn-primary">
                                    <i class="bi bi-eye"></i> Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center">
                {{ $pedidos->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Você ainda não fez nenhum pedido.
            </div>
        @endif
    </div>
</div>
@endsection
