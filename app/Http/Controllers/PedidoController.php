<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // Área Admin
    public function admin()
    {
        $pedidos = Pedido::with('cliente')
            ->orderBy('pedido_id', 'desc')
            ->paginate(20);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'endereco', 'itens.item'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function atualizarStatus(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $validated = $request->validate([
            'pedido_status' => 'required|integer|min:1|max:5',
        ]);

        $pedido->update($validated);

        return redirect()->back()->with('success', 'Status atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return redirect()->route('admin.pedidos')->with('success', 'Pedido removido com sucesso!');
    }

    // Área do Cliente
    public function lista()
    {
        // TODO: Usar cliente autenticado
        $cliente = Cliente::first();

        $pedidos = Pedido::where('pedido_cliente', $cliente->cliente_id)
            ->orderBy('pedido_id', 'desc')
            ->paginate(10);

        return view('cliente.pedidos.lista', compact('pedidos'));
    }

    public function detalhes($id)
    {
        $pedido = Pedido::with(['itens'])->findOrFail($id);

        // TODO: Verificar se pedido pertence ao cliente autenticado

        return view('cliente.pedidos.detalhes', compact('pedido'));
    }

    // API de rastreamento
    public function track($code)
    {
        // TODO: Implementar rastreamento
        return view('tracking.track', compact('code'));
    }

    public function trackApi($code)
    {
        // TODO: Implementar API de rastreamento
        return response()->json([
            'code' => $code,
            'status' => 'Em desenvolvimento'
        ]);
    }

    public function statusApi($id)
    {
        $pedido = Pedido::findOrFail($id);

        return response()->json([
            'pedido_id' => $pedido->pedido_id,
            'status' => $pedido->pedido_status,
            'total' => $pedido->pedido_total,
        ]);
    }
}
