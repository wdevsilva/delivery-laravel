<?php

namespace App\Http\Controllers\Loja;

use App\Http\Controllers\Controller;

use App\Models\ConfigModel;
use App\Models\ClienteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocalController extends Controller
{
    public function __construct()
    {
        // Definir base_delivery na sessão se não existir
        @session_start();
        if (!isset($_SESSION['base_delivery'])) {
            $config = ConfigModel::first();
            $_SESSION['base_delivery'] = $config->config_token ?? 'default';
            session(['base_delivery' => $_SESSION['base_delivery']]);
        }
    }

    /**
     * Retorna o preço de entrega baseado no bairro
     * POST /local/get_preco_entrega
     */
    public function getPrecoEntrega(Request $request)
    {
        $bairro_id = $request->input('bairro');

        if (!$bairro_id) {
            return response()->json(['error' => 'Bairro não informado'], 400);
        }

        // Buscar preço do bairro
        $bairro = DB::table('bairro')
            ->where('bairro_id', $bairro_id)
            ->first();

        if (!$bairro) {
            return response('0.00', 200);
        }

        // Retornar preço no formato US (com ponto decimal)
        $preco = number_format((float)$bairro->bairro_preco, 2, '.', '');

        return response($preco, 200);
    }

    /**
     * Retorna o bairro por nome
     * POST /local/get_bairro_by_name
     */
    public function getBairroByName(Request $request)
    {
        $bairro_nome = $request->input('bairro');

        if (!$bairro_nome) {
            return response('-1', 200);
        }

        $bairro_lower = strtolower($bairro_nome);

        $bairro = DB::table('bairro')
            ->where('bairro_nome', 'like', "%{$bairro_nome}%")
            ->orWhere(DB::raw('LOWER(bairro_nome)'), 'like', "%{$bairro_lower}%")
            ->first();

        return response($bairro ? '1' : '-1', 200);
    }

    /**
     * Retorna a taxa de entrega baseada na faixa de CEP
     * POST /local/getfaixa
     */
    public function getFaixaCep(Request $request)
    {
        $cep = $request->input('cep');

        if (!$cep) {
            return response('-1', 200);
        }

        // Limpar CEP (apenas números)
        $cep_numerico = (int)preg_replace('/\D+/', '', $cep);

        // Buscar faixas de CEP
        $faixas = DB::table('entrega')
            ->orderBy('entrega_inicio')
            ->get();

        $taxa = '-1';

        foreach ($faixas as $faixa) {
            $min = (int)$faixa->entrega_inicio;
            $max = (int)$faixa->entrega_fim;

            if ($cep_numerico >= $min && $cep_numerico <= $max) {
                $taxa = (string)$faixa->entrega_taxa;
                break;
            }
        }

        return response($taxa, 200);
    }

    /**
     * Exibe formulário para novo endereço
     * GET /novo-endereco
     */
    public function novoEndereco(Request $request)
    {
        @session_start();

        // Verificar se cliente está logado
        if (!isset($_SESSION['__CLIENTE__ID__']) || $_SESSION['__CLIENTE__ID__'] <= 0) {
            return redirect('/entrar');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];
        $return = $request->input('return', '');

        $config = ConfigModel::first();
        $cliente = ClienteModel::find($cliente_id);

        // Buscar bairros atendidos
        $bairros = DB::table('bairro')
            ->orderBy('bairro_nome')
            ->get();

        return view('site.endereco.cliente-endereco-novo', [
            'config' => $config,
            'cliente' => $cliente,
            'bairros' => $bairros,
            'return' => $return
        ]);
    }

    /**
     * Lista endereços do cliente
     * GET /meus-enderecos
     */
    public function listaEnderecos()
    {
        @session_start();

        // Verificar se cliente está logado
        if (!isset($_SESSION['__CLIENTE__ID__']) || $_SESSION['__CLIENTE__ID__'] <= 0) {
            return redirect('/entrar');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];

        $config = ConfigModel::first();
        $cliente = ClienteModel::find($cliente_id);

        // Buscar endereços do cliente com informações do bairro
        $enderecos = DB::table('endereco')
            ->leftJoin('bairro', 'endereco.endereco_bairro_id', '=', 'bairro.bairro_id')
            ->select('endereco.*', 'bairro.bairro_nome', 'bairro.bairro_tempo')
            ->where('endereco.endereco_cliente', $cliente_id)
            ->get();

        return view('site.endereco.lista', [
            'config' => $config,
            'cliente' => $cliente,
            'enderecos' => $enderecos
        ]);
    }

    /**
     * Gravar novo endereço
     * POST /endereco/gravar
     */
    public function gravarEndereco(Request $request)
    {
        @session_start();

        // Verificar se cliente está logado
        if (!isset($_SESSION['__CLIENTE__ID__']) || $_SESSION['__CLIENTE__ID__'] <= 0) {
            return redirect('/entrar');
        }

        $cliente_id = $_SESSION['__CLIENTE__ID__'];

        try {
            // Validar dados
            $validated = $request->validate([
                'endereco_nome' => 'required|string|max:100',
                'endereco_endereco' => 'required|string|max:200',
                'endereco_numero' => 'required|string|max:20',
                'endereco_bairro' => 'required|string|max:100',
                'endereco_bairro_id' => 'required|integer|min:1',
                'endereco_cidade' => 'nullable|string|max:100',
                'endereco_complemento' => 'nullable|string|max:200',
                'endereco_referencia' => 'nullable|string|max:200',
                'endereco_cep' => 'nullable|string|max:20',
            ], [
                'endereco_bairro_id.required' => 'Por favor, selecione um bairro da lista.',
                'endereco_bairro_id.min' => 'Por favor, selecione um bairro válido.',
            ]);

            // Buscar informações do bairro
            $bairro = DB::table('bairro')->where('bairro_id', $validated['endereco_bairro_id'])->first();

            if (!$bairro) {
                return back()->withErrors(['erro' => 'Bairro não encontrado'])->withInput();
            }

            // Inserir endereço
            $endereco_id = DB::table('endereco')->insertGetId([
                'endereco_cliente' => $cliente_id,
                'endereco_nome' => $validated['endereco_nome'],
                'endereco_endereco' => $validated['endereco_endereco'],
                'endereco_numero' => $validated['endereco_numero'],
                'endereco_bairro_id' => $validated['endereco_bairro_id'],
                'endereco_bairro' => $validated['endereco_bairro'],
                'endereco_cidade' => $validated['endereco_cidade'] ?? $bairro->bairro_cidade ?? '',
                'endereco_complemento' => $validated['endereco_complemento'] ?? '',
                'endereco_referencia' => $validated['endereco_referencia'] ?? '',
                'endereco_cep' => $validated['endereco_cep'] ?? '',
            ]);

            // Se veio do pedido, redirecionar para checkout
            $return = $request->input('return', '');

            if ($return == 'pedido') {
                $_SESSION['__LOCAL__'] = $endereco_id;
                return redirect('/pedido')->with('success', 'Endereço cadastrado com sucesso!');
            }

            return redirect('/meus-enderecos')->with('success', 'Endereço cadastrado com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Erro ao gravar endereço: ' . $e->getMessage());
            return back()->withErrors(['erro' => 'Erro ao cadastrar endereço. Tente novamente.'])->withInput();
        }
    }
}
