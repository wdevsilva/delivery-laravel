<?php

namespace App\Http\Controllers;

use App\Models\ConfigModel;
use App\Models\ClienteModel;
use Illuminate\Http\Request;
use App\Models\EnderecoModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = ClienteModel::orderBy('cliente_id', 'desc')->paginate(20);
        return view('cliente.index', compact('clientes'));
    }

    public function create()
    {
        return view('cliente.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_nome' => 'required|string|max:200',
            'cliente_email' => 'required|email|max:200',
            'cliente_fone' => 'required|string|max:20',
            'cliente_senha' => 'required|string|min:6',
        ]);

        $validated['cliente_senha'] = Hash::make($validated['cliente_senha']);

        ClienteModel::create($validated);

        return redirect()->route('cliente.login')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function show(ClienteModel $cliente)
    {
        return view('cliente.show', compact('cliente'));
    }

    public function edit(ClienteModel $cliente)
    {
        return view('cliente.edit', compact('cliente'));
    }

    public function update(Request $request, ClienteModel $cliente)
    {
        $validated = $request->validate([
            'cliente_nome' => 'required|string|max:200',
            'cliente_email' => 'required|email|max:200',
            'cliente_fone' => 'required|string|max:20',
        ]);

        $cliente->update($validated);

        return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
    }

    public function destroy(ClienteModel $cliente)
    {
        $cliente->delete();
        return redirect()->route('cliente.index')->with('success', 'Cliente removido com sucesso!');
    }

    // Métodos específicos da área do cliente
    public function dados()
    {
        @session_start();

        // Verificar se cliente está logado
        if (!isset($_SESSION['__CLIENTE__ID__'])) {
            return redirect()->route('home')->with('error', 'Faça login para acessar seus dados!');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];

        // Buscar cliente
        $cliente = ClienteModel::find($cliente_id);

        if (!$cliente) {
            return redirect()->route('home')->with('error', 'Cliente não encontrado!');
        }

        // Buscar configuração
        $config = ConfigModel::first();

        // Detectar se é mobile
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));

        return view('site.cliente.cliente-dados', [
            'cliente' => $cliente,
            'config' => $config,
            'isMobile' => $isMobile,
        ]);
    }

    public function salvarDados(Request $request)
    {
        @session_start();

        // Verificar se cliente está logado
        if (!isset($_SESSION['__CLIENTE__ID__'])) {
            return redirect()->route('home')->with('error', 'Faça login para atualizar seus dados!');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];

        // Buscar cliente
        $cliente = ClienteModel::find($cliente_id);

        if (!$cliente) {
            return redirect()->route('home')->with('error', 'Cliente não encontrado!');
        }

        // Validar campos
        $validated = $request->validate([
            'cliente_nome' => 'nullable|string|max:200',
            'cliente_cpf' => 'nullable|string|max:14',
            'cliente_email' => 'nullable|email|max:200',
            'cliente_marketing_whatssapp' => 'nullable|in:0,1',
        ]);

        // Sempre incluir marketing_whatssapp se vier no request
        if ($request->has('cliente_marketing_whatssapp')) {
            $validated['cliente_marketing_whatssapp'] = $request->input('cliente_marketing_whatssapp');
        }

        // Remover campos vazios (não atualizar se não mudou)
        // Mas manter '0' do campo marketing_whatssapp
        $validated = array_filter($validated, function($value, $key) {
            if ($key === 'cliente_marketing_whatssapp') {
                return true; // Sempre atualizar este campo
            }
            return $value !== null && $value !== '';
        }, ARRAY_FILTER_USE_BOTH);

        // Atualizar dados
        $cliente->update($validated);

        return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
    }

    public function enderecos()
    {
        @session_start();

        // Verificar se cliente está logado
        if (!isset($_SESSION['__CLIENTE__ID__'])) {
            return redirect()->route('home')->with('error', 'Faça login para acessar seus endereços!');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];

        // Buscar cliente e endereços
        $cliente = ClienteModel::find($cliente_id);

        if (!$cliente) {
            return redirect()->route('home')->with('error', 'Cliente não encontrado!');
        }

        $enderecos = $cliente->enderecos;

        // Buscar configuração
        $config = \App\Models\ConfigModel::first();

        // Detectar se é mobile
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));

        return view('site.endereco.cliente-endereco-lista', [
            'enderecos' => $enderecos,
            'config' => $config,
            'isMobile' => $isMobile,
        ]);
    }

    public function salvarEndereco(Request $request)
    {
        @session_start();

        // Verificar se cliente está logado
        if (!isset($_SESSION['__CLIENTE__ID__'])) {
            return redirect()->route('home')->with('error', 'Faça login!');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];

        $validated = $request->validate([
            'endereco_nome' => 'required|string|max:200',
            'endereco_endereco' => 'required|string|max:200',
            'endereco_numero' => 'required|string|max:200',
            'endereco_bairro' => 'required|string|max:200',
            'endereco_cidade' => 'required|string|max:200',
            'endereco_referencia' => 'nullable|string|max:200',
            'endereco_complemento' => 'nullable|string|max:200',
            'endereco_cep' => 'nullable|string|max:10',
            'endereco_lat' => 'nullable|string|max:50',
            'endereco_lng' => 'nullable|string|max:50',
        ]);

        $validated['endereco_cliente'] = $cliente_id;

        // Se tiver endereco_id, é edição
        if ($request->has('endereco_id') && $request->endereco_id) {
            $endereco = EnderecoModel::where('endereco_id', $request->endereco_id)
                ->where('endereco_cliente', $cliente_id)
                ->first();

            if ($endereco) {
                $endereco->update($validated);
                return redirect('/meus-enderecos')->with('success', 'Endereço atualizado!');
            }

            return redirect('/meus-enderecos')->with('error', 'Endereço não encontrado!');
        }

        // Senão, é criação
        EnderecoModel::create($validated);

        return redirect('/meus-enderecos')->with('success', 'Endereço adicionado!');
    }

    public function removerEndereco($id)
    {
        $endereco = EnderecoModel::findOrFail($id);
        $endereco->delete();

        return redirect()->back()->with('success', 'Endereço removido!');
    }

    /**
     * Exibir formulário para novo endereço
     */
    public function novoEndereco()
    {
        @session_start();

        // Verificar se cliente está logado
        if (!isset($_SESSION['__CLIENTE__ID__'])) {
            return redirect()->route('home')->with('error', 'Faça login para adicionar um endereço!');
        }

        $config = ConfigModel::first();
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));

        // Buscar bairros
        $bairros = \Illuminate\Support\Facades\DB::table('bairro')
            ->orderBy('bairro_nome')
            ->get();

        return view('site.endereco.cliente-endereco-novo', [
            'config' => $config,
            'isMobile' => $isMobile,
            'bairros' => $bairros,
        ]);
    }

    /**
     * Exibir formulário para editar endereço
     */
    public function editarEndereco($id)
    {
        @session_start();

        // Verificar se cliente está logado
        if (!isset($_SESSION['__CLIENTE__ID__'])) {
            return redirect()->route('home')->with('error', 'Faça login para editar endereços!');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];

        // Buscar endereço e verificar se pertence ao cliente
        $endereco = EnderecoModel::where('endereco_id', $id)
            ->where('endereco_cliente', $cliente_id)
            ->first();

        if (!$endereco) {
            return redirect('/meus-enderecos')->with('error', 'Endereço não encontrado ou você não tem permissão para editá-lo!');
        }

        $config = ConfigModel::first();
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));

        // Buscar bairros
        $bairros = \Illuminate\Support\Facades\DB::table('bairro')
            ->orderBy('bairro_nome')
            ->get();

        return view('site.endereco.cliente-endereco-editar', [
            'endereco' => $endereco,
            'config' => $config,
            'isMobile' => $isMobile,
            'bairros' => $bairros,
        ]);
    }
}
