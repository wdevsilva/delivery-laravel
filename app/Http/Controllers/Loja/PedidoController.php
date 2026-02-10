<?php

namespace App\Http\Controllers\Loja;

use App\Http\Controllers\Controller;

use App\Models\PedidoModel;
use App\Models\ClienteModel;
use App\Models\EnderecoModel;
use App\Models\ConfigModel;
use App\Models\PagamentoModel;
use App\Models\CupomModel;
use App\Models\StatusModel;
use App\Helpers\Currency;
use App\Services\Pix\Payload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Construtor - Verifica autenticação para rotas de checkout
     */
    public function __construct()
    {
        // Middleware de autenticação apenas para checkout e finalização
        // Não aplica para rotas públicas como lista e detalhes

        // Definir base_delivery na sessão se não existir
        @session_start();
        if (!isset($_SESSION['base_delivery'])) {
            $config = ConfigModel::first();
            $_SESSION['base_delivery'] = $config->config_token ?? 'default';
            session(['base_delivery' => $_SESSION['base_delivery']]);
        }
    }
    // Área Admin
    public function admin()
    {
        $pedidos = PedidoModel::with('cliente')
            ->orderBy('pedido_id', 'desc')
            ->paginate(20);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = PedidoModel::with(['cliente', 'endereco', 'itens.item'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function atualizarStatus(Request $request, $id)
    {
        $pedido = PedidoModel::findOrFail($id);

        $validated = $request->validate([
            'pedido_status' => 'required|integer|min:1|max:5',
        ]);

        $pedido->update($validated);

        return redirect()->back()->with('success', 'Status atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $pedido = PedidoModel::findOrFail($id);
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
        $cliente = ClienteModel::find($cliente_id);

        if (!$cliente) {
            return redirect('/entrar/?carrinho');
        }

        // Verificar se tem itens no carrinho
        if (!isset($_SESSION['__APP__CART__']) || empty($_SESSION['__APP__CART__'])) {
            return redirect()->route('home')->with('error', 'Seu carrinho está vazio!');
        }

        // Buscar dados necessários
        $config = ConfigModel::first();

        // Buscar endereços com JOIN na tabela bairro para pegar o tempo de entrega
        $enderecos = DB::table('endereco')
            ->leftJoin('bairro', 'endereco.endereco_bairro_id', '=', 'bairro.bairro_id')
            ->select('endereco.*', 'bairro.bairro_tempo')
            ->where('endereco.endereco_cliente', $cliente_id)
            ->get();

        $pagamentos = PagamentoModel::where('pagamento_status', 1)->get();

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

        // Taxa de entrega não é fixa - será calculada no JavaScript quando escolher o endereço
        $taxaEntrega = 0;
        $desconto = $_SESSION['__CUPOM__DESCONTO__'] ?? 0;
        $total = $subtotal - $desconto;

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
     * Confirmar e criar o pedido
     */
    public function confirmar(Request $request)
    {
        @session_start();

        // Verificar se tem itens no carrinho
        if (!isset($_SESSION['__APP__CART__']) || empty($_SESSION['__APP__CART__'])) {
            return redirect()->route('home')->with('error', 'Seu carrinho está vazio!');
        }

        $cart = $_SESSION['__APP__CART__'];
        $cliente_id = $_SESSION['__CLIENTE__ID__'];
        $config = ConfigModel::first();

        // Validar dados do pedido
        $pedido_local = $request->input('pedido_local', 0);
        $pedido_bairro = $request->input('pedido_bairro');
        $pedido_total = $this->convertMoeda($request->input('pedido_total'));
        $pedido_troco = $this->convertMoeda($request->input('pedido_troco', '0'));
        $forma_pagamento = $request->input('forma_pagamento');

        // Calcular taxa de entrega
        if ($pedido_local == 0) {
            $entrega_valor = 0;
        } else {
            $bairro = DB::table('bairro')->where('bairro_id', $pedido_bairro)->first();
            $entrega_valor = $bairro ? $bairro->bairro_preco : 0;
        }

        // Preparar dados do pedido
        $pedido_data = [
            'pedido_cliente' => $cliente_id,
            'pedido_data' => now(),
            'pedido_local' => $pedido_local,
            'pedido_total' => $pedido_total,
            'pedido_troco' => $pedido_troco,
            'pedido_entrega' => $entrega_valor,
            'pedido_entrega_prazo' => $request->input('pedido_entrega_prazo'),
            'pedido_tipo' => 1, // Pedido feito pelo próprio cliente
            'pedido_taxa_cartao' => $request->input('pedido_taxa_cartao', 0),
            'pedido_desconto' => 0,
            'pedido_obs' => $request->input('pedido_obs', ''),
            'pedido_id_pagto' => $forma_pagamento,
            'pedido_obs_pagto' => $request->input('pedido_obs_pagto', ''),
            'pedido_status' => 1,
        ];

        // Processar cupom de desconto
        $desconto_fidelidade = 0;
        if (isset($_SESSION['__CUPOM__']) && !empty($_SESSION['__CUPOM__'])) {
            $cupom = $_SESSION['__CUPOM__'];

            $total_sem_entrega = $pedido_total - $entrega_valor;
            $desconto_cupom = 0;

            if ($cupom->cupom_tipo == 1) {
                // Desconto fixo
                $desconto_cupom = (float)$cupom->cupom_valor;
                $cupom_valor = "R$ " . number_format($desconto_cupom, 2, ',', '.');
            } else {
                // Desconto percentual
                $desconto_cupom = ($total_sem_entrega * (float)$cupom->cupom_percent) / 100;

                // Verificar desconto máximo
                if (isset($cupom->cupom_desconto_maximo) && $cupom->cupom_desconto_maximo > 0) {
                    if ($desconto_cupom > $cupom->cupom_desconto_maximo) {
                        $desconto_cupom = (float)$cupom->cupom_desconto_maximo;
                    }
                }

                $cupom_valor = (intval($cupom->cupom_percent)) . "%";
            }

            $pedido_data['pedido_desconto'] = $desconto_cupom;
            $str_cupom = '<br>Cupom ' . $cupom->cupom_nome . ' - ' . $cupom_valor;
            $pedido_data['pedido_obs'] .= $str_cupom;
        }

        // Criar pedido
        $pedido_id = DB::table('pedido')->insertGetId($pedido_data);

        if ($pedido_id > 0) {
            // Salvar identificador PIX se necessário
            if ($forma_pagamento == 4) {
                $txid = 'PED' . $pedido_id;
                $txid = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', $txid), 0, 25));
                DB::table('pedido')->where('pedido_id', $pedido_id)->update(['pedido_pix_identificador' => $txid]);
            }

            // Registrar movimento do cupom
            if (isset($_SESSION['__CUPOM__']) && !empty($_SESSION['__CUPOM__'])) {
                $cupom = $_SESSION['__CUPOM__'];
                DB::table('cupom_movimento')->insert([
                    'cupom_id' => $cupom->cupom_id,
                    'cliente_id' => $cliente_id,
                    'pedido_id' => $pedido_id
                ]);

                // Atualizar contador de uso
                DB::table('cupom')
                    ->where('cupom_id', $cupom->cupom_id)
                    ->decrement('cupom_quantidade');
                DB::table('cupom')
                    ->where('cupom_id', $cupom->cupom_id)
                    ->increment('cupom_usado');

                unset($_SESSION['__CUPOM__']);
            }

            // Salvar itens do pedido
            foreach ($cart as $item) {
                $lista_data = [
                    'lista_pedido' => $pedido_id,
                    'lista_item' => $item->item_id,
                    'lista_qtde' => $item->qtde,
                    'lista_item_nome' => $item->item_nome ?? '',
                    'lista_opcao_nome' => $item->item_nome ?? '',
                    'lista_opcao_preco' => $item->total ?? $item->item_preco ?? 0,
                    'lista_item_desc' => $item->desc ?? '',
                    'lista_item_obs' => $item->item_obs ?? '',
                    'lista_item_extra' => $item->extra ?? '',
                    'lista_item_extra_vals' => $item->extra_vals ?? '',
                    'lista_item_codigo' => $item->item_codigo ?? '',
                ];

                DB::table('pedido_lista')->insert($lista_data);

                // Atualizar estoque
                DB::table('item')
                    ->where('item_id', $item->item_id)
                    ->decrement('item_estoque', $item->qtde);
            }

            // Limpar carrinho
            unset($_SESSION['__APP__CART__']);
            $_SESSION['__LAST__PEDIDO__']['ID'] = $pedido_id;
            $_SESSION['__LAST__PEDIDO__']['STATUS'] = 1;

            // Redirecionar para página de detalhes do pedido
            return redirect("/detalhes-do-pedido/$pedido_id/?new");
        } else {
            return redirect('/pedido/?error')->with('error', 'Erro ao criar pedido!');
        }
    }

    /**
     * Converter valor de moeda BR para US (R$ 10,50 -> 10.50)
     */
    private function convertMoeda($value)
    {
        if (empty($value)) return '0.00';

        // Se já é um número, formata e retorna
        if (is_numeric($value)) {
            return number_format((float)$value, 2, '.', '');
        }

        // Remove R$ e espaços
        $value = str_replace(['R$', ' '], '', $value);
        // Remove pontos (separadores de milhares) e converte vírgula para ponto
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return number_format((float)$value, 2, '.', '');
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

        // if (empty($cupom_codigo)) {
        //     return response()->json(['error' => 'Código do cupom é obrigatório'], 400);
        // }

        // Buscar cupom
        $cupom = CupomModel::where('cupom_nome', $cupom_codigo)
            ->where('status', 1)
            ->where('cupom_quantidade', '>', 0)
            ->first();

        if (!$cupom) {
            return response()->json([
                'error' => true,
                'message' => 'Cupom inválido ou expirado'
            ]);
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

    /**
     * Exibir detalhes do pedido (para o cliente)
     */
    public function detalhesPedido($id)
    {
        @session_start();

        // Verificar se cliente está logado
        if (!isset($_SESSION['__CLIENTE__ID__'])) {
            return redirect()->route('home')->with('error', 'Faça login para ver seus pedidos!');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];

        // Buscar pedido E verificar se pertence ao cliente logado
        $pedido = DB::table('pedido')
            ->leftJoin('cliente', 'pedido.pedido_cliente', '=', 'cliente.cliente_id')
            ->leftJoin('endereco', 'pedido.pedido_local', '=', 'endereco.endereco_id')
            ->where('pedido.pedido_id', $id)
            ->where('pedido.pedido_cliente', $cliente_id) // VALIDAÇÃO DE SEGURANÇA
            ->select('pedido.*', 'cliente.*', 'endereco.*', 'pedido.pedido_id')
            ->first();

        if (!$pedido) {
            return redirect('/meus-pedidos')->with('error', 'Pedido não encontrado ou você não tem permissão para visualizá-lo!');
        }

        // Buscar itens do pedido
        $lista = DB::table('pedido_lista')
            ->join('item', 'pedido_lista.lista_item', '=', 'item.item_id')
            ->join('categoria', 'item.item_categoria', '=', 'categoria.categoria_id')
            ->where('pedido_lista.lista_pedido', $id)
            ->select('pedido_lista.*', 'item.*', 'categoria.*')
            ->get();

        // Buscar endereço
        $endereco = null;
        if ($pedido->pedido_local > 0) {
            $endereco = DB::table('endereco')
                ->where('endereco_id', $pedido->pedido_local)
                ->first();
        }

        // Buscar configuração
        $config = ConfigModel::first();

        // Buscar cliente
        $cliente = DB::table('cliente')
            ->where('cliente_id', $pedido->pedido_cliente)
            ->first();

        // Calcular status
        $status = StatusModel::check($pedido->pedido_status);

        // Detectar se é mobile
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));

        // Gerar PIX se necessário
        $pixData = null;
        if ($pedido->pedido_id_pagto == 4 && $config->config_pix == 1 && $config->config_pix_automatico == 0) {
            if ($pedido->pedido_status != 5 && $pedido->pedido_status != 4) {
                $pixData = $this->generatePixQrCode($pedido, $config);
            }
        }

        return view('site.pedido.pedido-exibir', [
            'pedido' => $pedido,
            'lista' => $lista,
            'endereco' => $endereco,
            'config' => $config,
            'cliente' => $cliente,
            'status' => $status,
            'isMobile' => $isMobile,
            'pixData' => $pixData,
        ]);
    }

    /**
     * Gerar QR Code PIX
     */
    private function generatePixQrCode($pedido, $config)
    {
        // Formatar chave PIX baseado no tipo
        $pixKey = '';
        if ($config->config_tipo_chave == 1) {
            $pixKey = str_replace('.', '', str_replace('-', '', $config->config_chave_pix));
        } elseif ($config->config_tipo_chave == 2) {
            $celular = str_replace('(', '', str_replace(')', '', str_replace(' ', '', str_replace('-', '', $config->config_chave_pix))));
            $pixKey = "+55$celular";
        } elseif ($config->config_tipo_chave == 3) {
            $pixKey = $config->config_chave_pix;
        }

        // TxID único por empresa
        $baseEmpresa = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', $_SESSION['base_delivery'] ?? 'DEF'), 0, 6));
        $txid = $baseEmpresa . 'P' . $pedido->pedido_id;
        $txid = strtoupper(substr($txid, 0, 20));

        // Criar payload PIX
        $obPayload = (new Payload())
            ->setPixKey($pixKey)
            ->setDescription('Pedido #' . $pedido->pedido_id)
            ->setMerchantName(substr(str_replace("'", '', $config->config_nome), 0, 25))
            ->setMerchantCity(substr('Pacajus', 0, 15))
            ->setAmount($pedido->pedido_total)
            ->setTxid($txid)
            ->setUniquePayment(true);

        try {
            $payloadQrcode = $obPayload->getPayload();

            // Gerar QR Code usando mpdf/qrcode
            $obQrCode = new \Mpdf\QrCode\QrCode($payloadQrcode);
            $image = (new \Mpdf\QrCode\Output\Png)->output($obQrCode, 200, [255, 255, 255], [0, 0, 0]);

            return [
                'payload' => $payloadQrcode,
                'image' => base64_encode($image),
            ];
        } catch (\Exception $e) {
            error_log("[PIX ERROR] Pedido #{$pedido->pedido_id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * API para verificar status do pedido (AJAX)
     */
    public function statusApi($id)
    {
        $pedido = DB::table('pedido')->where('pedido_id', $id)->first();

        if (!$pedido) {
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado']);
        }

        $status = StatusModel::check($pedido->pedido_status);

        return response()->json([
            'success' => true,
            'status' => $pedido->pedido_status,
            'color' => $status->color,
            'icon' => $status->icon,
        ]);
    }

    public function lista()
    {
        @session_start();

        // Buscar cliente da sessão
        if (!isset($_SESSION['__CLIENTE__ID__'])) {
            return redirect()->route('home')->with('error', 'Faça login para ver seus pedidos!');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];

        // Buscar pedidos do cliente
        $pedidos = DB::table('pedido')
            ->where('pedido_cliente', $cliente_id)
            ->orderBy('pedido_id', 'desc')
            ->get();

        // Buscar configuração
        $config = ConfigModel::first();

        // Buscar cliente
        $cliente = DB::table('cliente')
            ->where('cliente_id', $cliente_id)
            ->first();

        // Detectar se é mobile
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));

        return view('site.pedido.pedido-lista', [
            'pedidos' => $pedidos,
            'cliente' => $cliente,
            'config' => $config,
            'isMobile' => $isMobile,
        ]);
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
}
