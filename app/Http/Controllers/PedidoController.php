<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\ConfigModel;
use App\Models\Pagamento;
use App\Models\Cupom;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Construtor - Verifica autenticação para rotas de checkout
     */
    public function __construct()
    {
        // Middleware de autenticação apenas para checkout e finalização
        // Não aplica para rotas públicas como lista e detalhes
    }
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

    /**
     * Página de Checkout - Finalizar Pedido
     */
    public function checkout()
    {
        @session_start();

        // Verificar se cliente está logado (igual ao sistema antigo)
        if (!isset($_SESSION['__CLIENTE__ID__']) || $_SESSION['__CLIENTE__ID__'] <= 0) {
            return redirect('/entrar/?carrinho');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];
        $cliente = Cliente::find($cliente_id);

        if (!$cliente) {
            return redirect('/entrar/?carrinho');
        }

        // Verificar se tem itens no carrinho
        if (!isset($_SESSION['__APP__CART__']) || empty($_SESSION['__APP__CART__'])) {
            return redirect()->route('home')->with('error', 'Seu carrinho está vazio!');
        }

        // Buscar dados necessários
        $config = ConfigModel::first();
        $enderecos = Endereco::where('endereco_cliente', $cliente_id)->get();
        $pagamentos = Pagamento::where('pagamento_status', 1)->get();

        // Se não tem endereço, redireciona para cadastrar
        if ($enderecos->count() == 0) {
            return redirect('/novo-endereco')->with('info', 'Cadastre um endereço para continuar');
        }

        // Calcular totais do carrinho
        $subtotal = 0;
        $itens = $_SESSION['__APP__CART__'];

        foreach ($itens as $item) {
            $subtotal += ($item->item_preco ?? 0) * ($item->qtde ?? 1);
        }

        $taxaEntrega = $config->config_taxa_entrega ?? 0;
        $desconto = $_SESSION['__CUPOM__DESCONTO__'] ?? 0;
        $total = $subtotal + $taxaEntrega - $desconto;

        $dados = [
            'config' => $config,
            'cliente' => $cliente,
            'enderecos' => $enderecos,
            'pagamentos' => $pagamentos,
            'itens' => $itens,
            'subtotal' => $subtotal,
            'taxaEntrega' => $taxaEntrega,
            'desconto' => $desconto,
            'total' => $total,
        ];

        return view('site.carrinho.checkout', $dados);
    }

    /**
     * Finalizar o pedido
     */
    public function finalizar(Request $request)
    {
        @session_start();

        // Validar dados
        $validated = $request->validate([
            'endereco_id' => 'required|integer',
            'pagamento_id' => 'required|integer',
            'pedido_obs' => 'nullable|string',
            'pedido_local' => 'required|integer', // 0=delivery, 1=retirada
        ]);

        // TODO: Implementar lógica de finalização
        // 1. Criar pedido no banco
        // 2. Criar itens do pedido
        // 3. Limpar carrinho
        // 4. Enviar notificações

        return response()->json(['success' => true, 'message' => 'Pedido finalizado!']);
    }

    /**
     * Aplicar cupom de desconto
     */
    public function aplicaCupom(Request $request)
    {
        @session_start();

        $cupom_codigo = $request->input('cupom');

        if (empty($cupom_codigo)) {
            return response()->json(['error' => 'Código do cupom é obrigatório'], 400);
        }

        // Buscar cupom
        $cupom = Cupom::where('cupom_nome', $cupom_codigo)
            ->where('cupom_status', 1)
            ->where('cupom_quantidade', '>', 0)
            ->first();

        if (!$cupom) {
            return response()->json(['error' => 'Cupom inválido ou expirado'], 404);
        }

        // Aplicar desconto na sessão
        $_SESSION['__CUPOM__'] = $cupom;
        $_SESSION['__CUPOM__DESCONTO__'] = $cupom->cupom_desconto;

        return response()->json([
            'success' => true,
            'desconto' => $cupom->cupom_desconto,
            'message' => 'Cupom aplicado com sucesso!'
        ]);
    }

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
