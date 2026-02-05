<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CarrinhoController extends Controller
{
    public function reload(Request $request)
    {
        // Verificar se a sessão do carrinho existe e está vazia
        $carrinho = session()->get('__APP__CART__', []);

        if (empty($carrinho)) {
            // Retornar HTML do carrinho vazio
            return response()->view('site.carrinho.side-carrinho-partial');
        }

        // Carrinho com itens - retornar partial com produtos
        return response()->view('site.carrinho.side-carrinho-partial');
    }

    public function getCountJs(Request $request)
    {
        $carrinho = session()->get('__APP__CART__', []);
        $count = count($carrinho);
        return response('<span class="badge">' . $count . '</span>')->header('Content-Type', 'text/html');
    }

    public function getCountBag(Request $request)
    {
        $carrinho = session()->get('__APP__CART__', []);
        $count = count($carrinho);
        return response('<span class="cart-count">' . $count . '</span>')->header('Content-Type', 'text/html');
    }

    public function dispensarBebidas(Request $request)
    {
        session(['__BEBIDA_DISPENSADA__' => true]);
        return response()->json(['success' => true]);
    }
}
