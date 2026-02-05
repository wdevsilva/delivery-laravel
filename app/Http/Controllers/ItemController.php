<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function categoria(string $id)
    {
        Session::put('busca', false);

        // Buscar config
        $config = DB::table('config')->where('config_id', 1)->first();

        // Buscar categoria
        $categoria = DB::table('categoria')
            ->where('categoria_ativa', 1)
            ->where('categoria_id', $id)
            ->orderBy('categoria_pos', 'ASC')
            ->get();

        // Buscar produtos da categoria
        $produtos = $this->lista($categoria, $config->config_home_qtde ?? 1000);
        $produtos_busca = $this->lista($categoria);

        // Buscar cupons ativos
        $cupom = DB::table('cupom')->where('status', 1)->get();

        // Buscar cliente da sessão
        $cliente_id = Session::get('__LOGIN__CLIENTE__');
        $cliente = [];
        if ($cliente_id) {
            $cliente = DB::table('cliente')->where('cliente_id', $cliente_id)->get();
        }

        // Buscar promoções ativas com prêmio
        $promocoes = DB::table('promocao')
            ->where('status', 1)
            ->orderBy('promocao_descricao', 'ASC')
            ->get();

        // Buscar produtos mais vendidos
        $maisVendidos = DB::table('item')
            ->select('item.*', DB::raw('COUNT(pedido_item.item_id) as total_vendas'))
            ->leftJoin('pedido_item', 'item.item_id', '=', 'pedido_item.item_id')
            ->where('item.item_ativo', 1)
            ->groupBy('item.item_id')
            ->orderBy('total_vendas', 'DESC')
            ->limit(10)
            ->get();

        // Buscar pedidos recentes do cliente
        $pedidosRecentes = null;
        if ($cliente_id > 0) {
            $pedidosRecentes = DB::table('pedido')
                ->select('pedido.*', DB::raw('COUNT(pedido_item.pedido_id) as total_items'))
                ->leftJoin('pedido_item', 'pedido.pedido_id', '=', 'pedido_item.pedido_id')
                ->where('pedido.cliente_id', $cliente_id)
                ->groupBy('pedido.pedido_id')
                ->orderBy('pedido.pedido_id', 'DESC')
                ->limit(6)
                ->get();
        }

        $dados = [
            'config' => $config,
            'categoria' => $categoria,
            'lista_combo' => $produtos_busca,
            'lista' => $produtos,
            'promocoes' => $promocoes,
            'cupom' => $cupom,
            'cliente' => $cliente,
            'maisVendidos' => $maisVendidos,
            'pedidosRecentes' => $pedidosRecentes
        ];

        $baseUri = url('/');

        return view('site.produto.produto-categoria', compact('dados', 'baseUri'));
    }

    private function lista($categoria, $limit = 1000)
    {
        if (empty($categoria) || $categoria->isEmpty()) {
            return [];
        }

        $cat_item = [];
        $k = 0;

        foreach ($categoria as $cat) {
            // Buscar itens da categoria
            $itens = DB::table('item')
                ->where('item_categoria', $cat->categoria_id)
                ->where('item_ativo', 1)
                ->limit($limit)
                ->get();

            // Buscar todos os itens (sem limite)
            $itensAll = DB::table('item')
                ->where('item_categoria', $cat->categoria_id)
                ->where('item_ativo', 1)
                ->get();

            // Buscar opções da categoria
            $opcoes = DB::table('opcao')
                ->join('item', 'opcao.item_id', '=', 'item.item_id')
                ->where('item.item_categoria', $cat->categoria_id)
                ->select('opcao.*')
                ->get();

            if ($itens->isNotEmpty()) {
                $cat_item[$k] = [
                    'categoria' => $cat->categoria_nome,
                    'categoria_id' => $cat->categoria_id,
                    'categoria_meia' => $cat->categoria_meia ?? 1,
                    'categoria_img' => $cat->categoria_img ?? '',
                    'item' => $itens,
                    'itemAll' => $itensAll,
                    'opcoes' => $opcoes
                ];
                $k++;
            }
        }

        return $cat_item;
    }

    public function promocoes()
    {
        // Retornar view temporária ou redirecionar para home
        return redirect('/');
    }
}
