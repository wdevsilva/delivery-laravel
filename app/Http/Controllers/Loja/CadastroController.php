<?php

namespace App\Http\Controllers\Loja;

use App\Http\Controllers\Controller;

use App\Models\ClienteModel;
use App\Models\ConfigModel;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    /**
     * Página de Cadastro
     */
    public function index(Request $request)
    {
        $config = ConfigModel::first();
        $fone = $request->input('fone', '');

        $dados = [
            'config' => $config,
            'fone' => $fone,
        ];

        return view('site.cadastro.index', $dados);
    }

    /**
     * Gravar Cadastro
     */
    public function gravar(Request $request)
    {
        @session_start();

        $validated = $request->validate([
            'cliente_nome' => 'required|string|max:200',
            'cliente_fone2' => 'required|string',
        ]);

        // Remover formatação do telefone
        $cliente_fone2 = preg_replace('/[^0-9]/', '', $validated['cliente_fone2']);

        // Verificar se já existe
        $existe = ClienteModel::where('cliente_fone2', $cliente_fone2)->first();

        if ($existe) {
            return redirect()->back()->with('error', 'Telefone já cadastrado!');
        }

        // Criar novo cliente
        $cliente = ClienteModel::create([
            'cliente_nome' => $validated['cliente_nome'],
            'cliente_fone2' => $cliente_fone2,
            'cliente_status' => 1,
        ]);

        // Fazer login automático
        $_SESSION['__CLIENTE__LOGADO__'] = true;
        $_SESSION['__CLIENTE__GOOGLE__'] = false;
        $_SESSION['__CLIENTE__ID__'] = $cliente->cliente_id;
        $_SESSION['__CLIENTE__NOME__'] = $cliente->cliente_nome;
        $_SESSION['__CLIENTE__'] = $cliente;

        // Redirecionar para o checkout se veio do carrinho
        if ($request->has('carrinho') || session('from_carrinho')) {
            return redirect('/pedido');
        }

        return redirect()->route('home')->with('success', 'Cadastro realizado com sucesso!');
    }
}
