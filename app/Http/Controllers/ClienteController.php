<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('cliente_id', 'desc')->paginate(20);
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

        Cliente::create($validated);

        return redirect()->route('cliente.login')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        return view('cliente.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('cliente.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'cliente_nome' => 'required|string|max:200',
            'cliente_email' => 'required|email|max:200',
            'cliente_fone' => 'required|string|max:20',
        ]);

        $cliente->update($validated);

        return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('cliente.index')->with('success', 'Cliente removido com sucesso!');
    }

    // Métodos específicos da área do cliente
    public function dados()
    {
        // TODO: Implementar autenticação
        $cliente = Cliente::first(); // Temporário
        return view('cliente.dados', compact('cliente'));
    }

    public function salvarDados(Request $request)
    {
        $validated = $request->validate([
            'cliente_nome' => 'required|string|max:200',
            'cliente_fone' => 'required|string|max:20',
        ]);

        // TODO: Usar cliente autenticado
        $cliente = Cliente::first();
        $cliente->update($validated);

        return redirect()->back()->with('success', 'Dados atualizados!');
    }

    public function enderecos()
    {
        // TODO: Implementar autenticação
        $cliente = Cliente::first();
        $enderecos = $cliente->enderecos;
        return view('cliente.enderecos', compact('enderecos'));
    }

    public function salvarEndereco(Request $request)
    {
        $validated = $request->validate([
            'endereco_endereco' => 'required|string|max:200',
            'endereco_numero' => 'required|string|max:200',
            'endereco_bairro' => 'required|string|max:200',
            'endereco_cidade' => 'required|string|max:200',
            'endereco_referencia' => 'nullable|string|max:200',
        ]);

        // TODO: Usar cliente autenticado
        $cliente = Cliente::first();
        $validated['endereco_cliente'] = $cliente->cliente_id;

        Endereco::create($validated);

        return redirect()->back()->with('success', 'Endereço adicionado!');
    }

    public function removerEndereco($id)
    {
        $endereco = Endereco::findOrFail($id);
        $endereco->delete();

        return redirect()->back()->with('success', 'Endereço removido!');
    }
}
