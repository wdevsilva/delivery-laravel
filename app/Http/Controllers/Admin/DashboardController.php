<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas gerais
        $totalPedidos = Pedido::count();
        $totalClientes = Cliente::count();
        $totalProdutos = Item::count();

        // Pedidos de hoje
        $pedidosHoje = Pedido::whereDate('pedido_data', today())->count();

        // Faturamento total
        $faturamentoTotal = Pedido::sum('pedido_total');

        // Faturamento hoje
        $faturamentoHoje = Pedido::whereDate('pedido_data', today())->sum('pedido_total');

        // Últimos pedidos
        $ultimosPedidos = Pedido::with('cliente')
            ->orderBy('pedido_id', 'desc')
            ->take(10)
            ->get();

        // Produtos mais vendidos
        $produtosMaisVendidos = DB::table('pedido_lista')
            ->join('item', 'pedido_lista.lista_item', '=', 'item.item_id')
            ->select('item.item_nome', DB::raw('SUM(pedido_lista.lista_qtde) as total_vendido'))
            ->groupBy('item.item_id', 'item.item_nome')
            ->orderBy('total_vendido', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPedidos',
            'totalClientes',
            'totalProdutos',
            'pedidosHoje',
            'faturamentoTotal',
            'faturamentoHoje',
            'ultimosPedidos',
            'produtosMaisVendidos'
        ));
    }
}
