<?php

namespace App\Repositories;

use App\Models\ConfigModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ConfigRepository
{
    public function getConfig()
    {
        return ConfigModel::first();
    }

    public function get_all($order = 'config_nome DESC')
    {
        $query = DB::table('config')->orderBy($order);
        return $query->get();
    }

    public function get_config()
    {
        $query = DB::table('config');
        $data = $query->get();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function get_empresa()
    {
        $query = DB::table('empresa');
        $data = $query->get();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function get_valor_min()
    {
        $query = DB::table('config')->where('config_id', 1);
        $data = $query->get();
        return (isset($data[0])) ? $data[0]->config_pedmin : null;
    }

    public function get_by_id()
    {
        $query = DB::table('config')->limit(1);
        $data = $query->get();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function gravar(Request $request, $id = null)
    {
        $dados = $request->all();

        $taxasCategorias = '';
        if(isset($dados['config_taxa_tipo']) && $dados['config_taxa_tipo'] == 'taxa_por_item'){
            $taxasCategorias = (isset($dados['config_taxa_categorias']) && is_array($dados['config_taxa_categorias'])) ? implode(',', $dados['config_taxa_categorias']) : '';
        }

        DB::table('config')->where('config_id', 1)->update([
            'config_taxa_entrega' => str_replace(',', '.', $dados['config_taxa_entrega'] ?? '0.00'),
            'config_nome' => $dados['config_nome'] ?? '',
            'config_endereco' => $dados['config_endereco'] ?? '',
            'config_cep' => $dados['config_cep'] ?? '',
            'config_cnpj' => $dados['config_cnpj'] ?? '',
            'config_retirada' => $dados['config_retirada'] ?? 0,
            'config_entrega_pedido' => $dados['config_entrega_pedido'] ?? 1,
            'config_fone1' => $dados['config_fone1'] ?? '',
            'config_fone2' => $dados['config_fone2'] ?? '',
            'config_resumo_whats' => $dados['config_resumo_whats'] ?? 0,
            'config_divisao_valor_pizza' => $dados['config_divisao_valor_pizza'] ?? 0,
            'config_pix' => $dados['config_pix'] ?? 0,
            'config_pix_automatico' => $dados['config_pix_automatico'] ?? 0,
            'config_token_mercadopago' => $dados['config_token_mercadopago'] ?? '',
            'config_tipo_chave' => $dados['config_tipo_chave'] ?? '',
            'config_chave_pix' => $dados['config_chave_pix'] ?? '',
            'config_bell' => $dados['config_bell'] ?? 0,
            'config_pedmin' => str_replace(',', '.', $dados['config_pedmin'] ?? '0.00'),
            'config_chat' => $dados['config_chat'] ?? 0,
            'config_site_keywords' => $dados['config_site_keywords'] ?? '',
            'config_site_description' => $dados['config_site_description'] ?? '',
            'config_site_ga' => $dados['config_site_ga'] ?? '',
            'config_desc' => $dados['config_desc'] ?? '',
            'config_taxa_tipo' => $dados['config_taxa_tipo'] ?? 'taxa_fixa',
            'config_taxa_categorias' => $taxasCategorias,
            'config_fidelidade_ativo' => (int)($dados['config_fidelidade_ativo'] ?? 0),
            'config_fidelidade_tipo' => $dados['config_fidelidade_tipo'] ?? 'pontos',
            'config_pontos_por_real' => str_replace(',', '.', $dados['config_pontos_por_real'] ?? '5.00'),
            'config_pontos_para_resgatar' => (int)($dados['config_pontos_para_resgatar'] ?? 100),
            'config_valor_resgate_pontos' => str_replace(',', '.', $dados['config_valor_resgate_pontos'] ?? '5.00'),
            'config_cashback_percentual' => str_replace(',', '.', $dados['config_cashback_percentual'] ?? '5.00'),
            'config_cashback_minimo_pedido' => str_replace(',', '.', $dados['config_cashback_minimo_pedido'] ?? '30.00'),
            'config_fidelidade_validade_dias' => (int)($dados['config_fidelidade_validade_dias'] ?? 90),
            'config_fidelidade_renovacao_automatica' => (int)($dados['config_fidelidade_renovacao_automatica'] ?? 1),
            'config_fidelidade_max_desconto' => str_replace(',', '.', $dados['config_fidelidade_max_desconto'] ?? '20.00'),
            'config_bonus_primeira_compra' => (int)($dados['config_bonus_primeira_compra'] ?? 100),
            'config_bonus_aniversario' => (int)($dados['config_bonus_aniversario'] ?? 200),
            'config_bonus_avaliacao' => (int)($dados['config_bonus_avaliacao'] ?? 50),
            'config_bonus_indicacao' => (int)($dados['config_bonus_indicacao'] ?? 150)
        ]);
    }

    public function gravar_tema(Request $request, $id = null)
    {
        $request::drop('redir');
        $post = $request::query_builder();
        if ($id != null) { //atualiza
            //echo $post->sql_update;
            DB::table('config')->where('config_id', $id)->update([
                $post->sql_update
            ]);
        } else { //cadastra
            DB::table('config')->insert([
                $post->sql_insert
            ]);
        }
    }

    public function gravar_horarios($id = 1)
    {
        // Processar horários
        $segundaMostrar = (isset($_POST['seg-check'])) ? 'on' : 'off';
        $segundaDe = $_POST['config_segunda_de'] ?? '00:00';
        $segundaAte = $_POST['config_segunda_ate'] ?? '00:00';

        $tercaMostrar = (isset($_POST['ter-check'])) ? 'on' : 'off';
        $tercaDe = $_POST['config_terca_de'] ?? '00:00';
        $tercaAte = $_POST['config_terca_ate'] ?? '00:00';

        $quartaMostrar = (isset($_POST['qua-check'])) ? 'on' : 'off';
        $quartaDe = $_POST['config_quarta_de'] ?? '00:00';
        $quartaAte = $_POST['config_quarta_ate'] ?? '00:00';

        $quintaMostrar = (isset($_POST['qui-check'])) ? 'on' : 'off';
        $quintaDe = $_POST['config_quinta_de'] ?? '00:00';
        $quintaAte = $_POST['config_quinta_ate'] ?? '00:00';

        $sextaMostrar = (isset($_POST['sex-check'])) ? 'on' : 'off';
        $sextaDe = $_POST['config_sexta_de'] ?? '00:00';
        $sextaAte = $_POST['config_sexta_ate'] ?? '00:00';

        $sabadoMostrar = (isset($_POST['sab-check'])) ? 'on' : 'off';
        $sabadoDe = $_POST['config_sabado_de'] ?? '00:00';
        $sabadoAte = $_POST['config_sabado_ate'] ?? '00:00';

        $domingoMostrar = (isset($_POST['dom-check'])) ? 'on' : 'off';
        $domingoDe = $_POST['config_domingo_de'] ?? '00:00';
        $domingoAte = $_POST['config_domingo_ate'] ?? '00:00';

        // Montar strings de horário
        $config_segunda = ($segundaMostrar == 'off') ? '' : "$segundaMostrar $segundaDe-$segundaAte";
        $config_terca = ($tercaMostrar == 'off') ? '' : "$tercaMostrar $tercaDe-$tercaAte";
        $config_quarta = ($quartaMostrar == 'off') ? '' : "$quartaMostrar $quartaDe-$quartaAte";
        $config_quinta = ($quintaMostrar == 'off') ? '' : "$quintaMostrar $quintaDe-$quintaAte";
        $config_sexta = ($sextaMostrar == 'off') ? '' : "$sextaMostrar $sextaDe-$sextaAte";
        $config_sabado = ($sabadoMostrar == 'off') ? '' : "$sabadoMostrar $sabadoDe-$sabadoAte";
        $config_domingo = ($domingoMostrar == 'off') ? '' : "$domingoMostrar $domingoDe-$domingoAte";

        // Atualizar apenas os campos de horário
        DB::table('config')->where('config_id', $id)->update([
            'config_segunda' => $config_segunda,
            'config_terca' => $config_terca,
            'config_quarta' => $config_quarta,
            'config_quinta' => $config_quinta,
            'config_sexta' => $config_sexta,
            'config_sabado' => $config_sabado,
            'config_domingo' => $config_domingo
        ]);
    }

    public function updateLoja(Request $request, $id = null)
    {
        $request::drop('redir');
        $post = $request::query_builder();

        if ($id != null) { //atualiza
            //echo $post->sql_update;
            DB::table('config')->where('config_id', $id)->update([
                $post->sql_update
            ]);
        }
    }

    public function updateBot(Request $request, $id = null)
    {
        $request::drop('redir');
        $post = $request::query_builder();

        if ($id != null) { //atualiza
            //echo $post->sql_update;
            DB::table('config')->where('config_id', $id)->update([
                $post->sql_update
            ]);
        }
    }

    public function remove($id)
    {
        DB::table('config')->where('config_id', $id)->delete();
    }

    public function getMensalidade()
    {
        return DB::table('mensalidades')
            ->whereYear('data_pagamento', '<=', date('Y'))
            ->where('status', '1')
            ->orderBy('data_vencimento', 'DESC')
            ->first();
    }

    //CONTA QUANTOS PEDIDOS FORAM REALIZADOS NO MES, PARA SABER SE O CLIENTE AINDA ESTA DENTRO DO PLANO CONTRATADO, CASO NÃO ESTEJA, BLOQUEIA O USO
    // 50 reais = até 150 pedidos por mês
    // 100 reais = até 200 pedidos por mês
    // 150 reais = pedidos ilimitados

    public function getPedidosPlano()
    {
        return DB::table('pedido')
            ->selectRaw('COUNT(*) AS total')
            ->selectRaw("CASE
                WHEN COUNT(*) <= 150 THEN '50'
                WHEN COUNT(*) > 150 AND COUNT(*) <= 200 THEN '100'
                ELSE '150'
            END AS plano")
            ->whereMonth('pedido_data', date('m'))
            ->whereYear('pedido_data', date('Y'))
            ->where('pedido_status', '!=', '5')
            ->first();
    }
}
