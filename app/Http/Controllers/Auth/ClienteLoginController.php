<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ClienteModel;
use App\Models\ConfigModel;
use Illuminate\Http\Request;

class ClienteLoginController extends Controller
{
    /**
     * Página de Login do Cliente
     */
    public function index(Request $request)
    {
        $config = ConfigModel::first();

        // Verifica se veio do carrinho
        $fromCarrinho = $request->has('carrinho');

        $dados = [
            'config' => $config,
            'fromCarrinho' => $fromCarrinho,
        ];

        return view('site.auth.login', $dados);
    }

    /**
     * Processar Login
     */
    public function entrar(Request $request)
    {
        @session_start();

        $cliente_fone = $request->input('cliente_fone');

        if (empty($cliente_fone)) {
            return redirect()->back()->with('error', 'Telefone é obrigatório!');
        }

        // Tentar buscar primeiro com formatação (como veio)
        $cliente = ClienteModel::where('cliente_fone2', $cliente_fone)->first();

        // Se não achou, tentar sem formatação
        if (!$cliente) {
            $cliente_fone_limpo = preg_replace('/[^0-9]/', '', $cliente_fone);
            $cliente = ClienteModel::where('cliente_fone2', $cliente_fone_limpo)->first();
        }

        if ($cliente) {
            // Cliente existe - fazer login
            $_SESSION['__CLIENTE__LOGADO__'] = true;
            $_SESSION['__CLIENTE__GOOGLE__'] = false;
            $_SESSION['__CLIENTE__ID__'] = $cliente->cliente_id;
            $_SESSION['__CLIENTE__NOME__'] = $cliente->cliente_nome;
            $_SESSION['__CLIENTE__'] = $cliente;

            // Se veio do carrinho, redireciona para checkout
            if ($request->has('carrinho')) {
                return redirect('/pedido');
            }

            return redirect()->route('home');
        } else {
            // Cliente não existe - redirecionar para cadastro
            $fone_para_cadastro = preg_replace('/[^0-9]/', '', $cliente_fone);
            return redirect('/cadastro?fone=' . $fone_para_cadastro);
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        @session_start();

        unset($_SESSION['__CLIENTE__ID__']);
        unset($_SESSION['__CLIENTE__']);

        return redirect()->route('home')->with('success', 'Logout realizado com sucesso!');
    }

    /**
     * Recuperar Senha
     */
    public function recuperaSenha()
    {
        $config = ConfigModel::first();
        return view('site.auth.recupera-senha', compact('config'));
    }

    /**
     * Processar Nova Senha
     */
    public function novaSenha(Request $request)
    {
        // TODO: Implementar lógica de recuperação de senha
        return redirect('/entrar')->with('success', 'Senha alterada com sucesso!');
    }
}
