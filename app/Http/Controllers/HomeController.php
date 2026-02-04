<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Item;
use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Config da loja
        $config = Config::first();

        // Produtos mais pedidos (Mais Vendidos)
        $maisPedidos = Item::ativo()
            ->orderBy('item_id', 'desc')
            ->take(4)
            ->get();

        // Produtos em promoção
        $promocoes = Item::ativo()
            ->promocao()
            ->take(4)
            ->get();

        // Categorias ativas
        $categorias = Categoria::ativa()
            ->orderBy('categoria_ordem')
            ->get();

        return view('home.cardapio', compact(
            'config',
            'maisPedidos',
            'promocoes',
            'categorias'
        ));
    }
}
