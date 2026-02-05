<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PromocaoRepository
{

    /**
     * Busca todas promoções (admin)
     */
    public function get_all_admin($order = 'promocao_prioridade ASC, promocao_titulo ASC')
    {
        $query = DB::query("SELECT p.*,
            i.item_nome as premio_produto_nome,
            i.item_preco as premio_produto_preco,
            c.categoria_nome
            FROM promocao p
            LEFT JOIN item i ON i.item_id = p.promocao_premio_item_id
            LEFT JOIN categoria c ON c.categoria_id = p.promocao_categoria
            ORDER BY $order");

        return $query->fetch();
    }

    /**
     * Busca promoções ativas no momento (respeitando datas, horários, limites)
     */
    public function get_all_ativas($dia_semana = null)
    {
        if ($dia_semana === null) {
            $dia_semana = date('w');
        }

        $hora_atual = date('H:i:s');
        $data_atual = date('Y-m-d');

        $query = DB::query("SELECT p.*,
            i.item_nome as premio_produto_nome,
            i.item_estoque as premio_produto_estoque
            FROM promocao p
            LEFT JOIN item i ON i.item_id = p.promocao_premio_item_id
            WHERE p.status = 1
            AND FIND_IN_SET('$dia_semana', p.promocao_dias_semana) > 0
            ORDER BY p.promocao_id ASC");

        return $query->fetch();
    }

    /**
     * Busca promoção por ID com informações completas
     */
    public function get_by_id($id)
    {
        $query = DB::query("SELECT p.*,
            i.item_nome as premio_produto_nome,
            i.item_preco as premio_produto_preco,
            i.item_estoque as premio_produto_estoque,
            c.categoria_nome
            FROM promocao p
            LEFT JOIN item i ON i.item_id = p.promocao_premio_item_id
            LEFT JOIN categoria c ON c.categoria_id = p.promocao_categoria
            WHERE p.promocao_id = $id");
        $data = $query->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    /**
     * Busca promoções por categoria
     */
    public function get_by_categoria($categoria_id)
    {
        $dia_semana = date('w');
        $query = DB::query("SELECT p.*,
            i.item_nome as premio_produto_nome
            FROM promocao p
            LEFT JOIN item i ON i.item_id = p.promocao_premio_item_id
            WHERE p.promocao_categoria = '$categoria_id'
            AND p.status = '1'
            AND p.promocao_tipo = 'quantidade_categoria'
            AND FIND_IN_SET('$dia_semana', p.promocao_dias_semana) > 0");
        return $query->fetch();
    }

    /**
     * Busca promoções por valor mínimo
     */
    public function get_by_valor_minimo($valor_pedido)
    {
        $dia_semana = date('w');
        $query = DB::query("SELECT p.*,
            i.item_nome as premio_produto_nome,
            i.item_id as premio_produto_id
            FROM promocao p
            LEFT JOIN item i ON i.item_id = p.promocao_premio_item_id
            WHERE p.promocao_tipo = 'valor_minimo'
            AND p.status = 1
            AND p.promocao_valor_minimo <= $valor_pedido
            AND FIND_IN_SET('$dia_semana', p.promocao_dias_semana) > 0
            ORDER BY p.promocao_prioridade ASC");
        return $query->fetch();
    }

    /**
     * Busca promoções do tipo combo
     */
    public function get_combos_ativos()
    {
        $dia_semana = date('w');
        $query = DB::query("SELECT p.*,
            i.item_nome as premio_produto_nome,
            i.item_id as premio_produto_id
            FROM promocao p
            LEFT JOIN item i ON i.item_id = p.promocao_premio_item_id
            WHERE p.promocao_tipo IN ('combo', 'produto_especifico')
            AND p.status = 1
            AND FIND_IN_SET('$dia_semana', p.promocao_dias_semana) > 0
            ORDER BY p.promocao_prioridade ASC");
        return $query->fetch();
    }

    /**
     * Busca todas promoções ativas com nome do produto premiado
     * Para exibição na página inicial
     */
    public function get_ativas_com_premio()
    {
        $dia_semana = date('w'); // 0 = Domingo, 6 = Sábado
        $query = DB::query("SELECT p.promocao_id, p.promocao_tipo, p.promocao_titulo,
            p.promocao_descricao, p.promocao_descricao_fim, p.promocao_premio_mensagem,
            p.promocao_premio_qtd, p.promocao_premio_produto, p.promocao_premio_item_id,
            p.promocao_produtos_compra, p.promocao_prioridade, p.promocao_valor_minimo,
            p.promocao_qtd_compra, p.promocao_categoria, p.promocao_desconta_estoque,
            p.promocao_data_inicio, p.promocao_data_fim, p.promocao_dias_semana,
            p.promocao_limite_uso, p.promocao_limite_cliente,
            i.item_nome as premio_produto_nome,
            c.categoria_nome as premio_categoria_nome
            FROM promocao p
            LEFT JOIN item i ON i.item_id = p.promocao_premio_item_id
            LEFT JOIN categoria c ON c.categoria_id = i.item_categoria
            WHERE p.status = 1
            AND FIND_IN_SET('$dia_semana', p.promocao_dias_semana) > 0
            ORDER BY p.promocao_prioridade ASC, p.promocao_titulo ASC");
        return $query->fetch();
    }

    /**
     * Verifica se os produtos do carrinho atendem ao combo
     * @param array $produtos_compra - JSON decodificado da promoção
     * @param array $carrinho - Itens do carrinho
     * @return array ['atende' => bool, 'falta' => array]
     */
    public function verificar_combo($produtos_compra, $carrinho)
    {
        if (is_string($produtos_compra)) {
            // Limpar quebras de linha e espaços extras que invalidam o JSON
            $produtos_compra = preg_replace('/[\r\n]+/', ' ', $produtos_compra);
            $produtos_compra = preg_replace('/\s+/', ' ', $produtos_compra);
            $produtos_compra = json_decode($produtos_compra, true);
        }

        // Suporta dois formatos:
        // 1. {"produtos": [{"id":1,...}], "qtd_cada": 1}
        // 2. [{"id":1,...}] (array direto)
        if (isset($produtos_compra['produtos']) && is_array($produtos_compra['produtos'])) {
            $produtos_necessarios = $produtos_compra['produtos'];
            $qtd_cada = $produtos_compra['qtd_cada'] ?? 1;
            $escolha_minimo = $produtos_compra['escolha_minimo'] ?? count($produtos_necessarios);
        } elseif (is_array($produtos_compra) && isset($produtos_compra[0]['id'])) {
            // Formato array direto (produto_especifico)
            $produtos_necessarios = $produtos_compra;
            $qtd_cada = $produtos_compra[0]['qtd'] ?? 1;
            $escolha_minimo = count($produtos_necessarios);
        } else {
            return ['atende' => false, 'falta' => []];
        }

        // Mapear produtos do carrinho por ID
        $carrinho_map = [];
        foreach ($carrinho as $item) {
            $item_id = $item->item_id ?? $item['item_id'] ?? null;
            if ($item_id) {
                $item_id = (int)$item_id; // Forçar int para comparação
                if (!isset($carrinho_map[$item_id])) {
                    $carrinho_map[$item_id] = 0;
                }
                $carrinho_map[$item_id] += (int)($item->qtde ?? $item['qtde'] ?? 1);
            }
        }

        // Verificar se tem os produtos necessários
        $produtos_encontrados = 0;
        $falta = [];

        foreach ($produtos_necessarios as $prod) {
            $prod_id = isset($prod['id']) ? (int)$prod['id'] : null; // Forçar int
            if (!$prod_id) continue;

            $qtd_necessaria = $qtd_cada;
            $qtd_no_carrinho = $carrinho_map[$prod_id] ?? 0;

            if ($qtd_no_carrinho >= $qtd_necessaria) {
                $produtos_encontrados++;
            } else {
                $falta[] = [
                    'id' => $prod_id,
                    'nome' => $prod['nome'] ?? 'Produto ' . $prod_id,
                    'qtd_necessaria' => $qtd_necessaria,
                    'qtd_tem' => $qtd_no_carrinho,
                    'qtd_falta' => $qtd_necessaria - $qtd_no_carrinho
                ];
            }
        }

        // Verifica se atende ao mínimo necessário
        $atende = ($produtos_encontrados >= $escolha_minimo);

        return [
            'atende' => $atende,
            'falta' => $falta,
            'produtos_encontrados' => $produtos_encontrados,
            'escolha_minimo' => $escolha_minimo,
            'tipo' => $escolha_minimo == count($produtos_necessarios) ? 'exato' : 'escolha'
        ];
    }

    /**
     * Grava promoção (nova ou atualização)
     */
    public function gravar($dados)
    {
        // Sanitização
        $id = isset($dados['id']) ? (int)$dados['id'] : null;
        $tipo = $dados['tipo'] ?? 'quantidade_categoria';
        $titulo = Filter::antiSQL($dados['titulo']);
        $descricao = Filter::antiSQL($dados['descricao']);
        $descricao_fim = Filter::antiSQL($dados['descricao_fim']);
        $premio_mensagem = Filter::antiSQL($dados['premio_mensagem']);
        $dias_semana = $dados['dias_semana'];

        // Campos numéricos
        $categoria = isset($dados['categoria']) ? Filter::antiSQL($dados['categoria']) : null; // String para múltiplas categorias
        $qtd_compra = isset($dados['qtd_compra']) ? (int)$dados['qtd_compra'] : 0;
        $premio_qtd = isset($dados['premio_qtd']) ? (int)$dados['premio_qtd'] : 1;
        $premio_item_id = isset($dados['premio_item_id']) ? (int)$dados['premio_item_id'] : null;
        $desconta_estoque = isset($dados['desconta_estoque']) ? (int)$dados['desconta_estoque'] : 0;
        $prioridade = isset($dados['prioridade']) ? (int)$dados['prioridade'] : 1;
        $acumulativa = isset($dados['acumulativa']) ? (int)$dados['acumulativa'] : 1;

        // Campos de valor e controle
        $valor_minimo = isset($dados['valor_minimo']) ? floatval($dados['valor_minimo']) : 0.00;
        $premio_produto = isset($dados['premio_produto']) ? Filter::antiSQL($dados['premio_produto']) : '';

        // Limpar JSON de produtos antes de salvar
        if (isset($dados['produtos_compra'])) {
            $json_clean = json_encode($dados['produtos_compra']);
            // Remover quebras de linha e espaços extras
            $json_clean = preg_replace('/[\r\n]+/', '', $json_clean);
            $json_clean = preg_replace('/\s{2,}/', ' ', $json_clean);
            $produtos_compra = $json_clean;
        } else {
            $produtos_compra = null;
        }

        // Datas e horários
        $data_inicio = isset($dados['data_inicio']) && !empty($dados['data_inicio']) ? "'".$dados['data_inicio']."'" : 'NULL';
        $data_fim = isset($dados['data_fim']) && !empty($dados['data_fim']) ? "'".$dados['data_fim']."'" : 'NULL';
        $hora_inicio = isset($dados['hora_inicio']) && !empty($dados['hora_inicio']) ? "'".$dados['hora_inicio']."'" : 'NULL';
        $hora_fim = isset($dados['hora_fim']) && !empty($dados['hora_fim']) ? "'".$dados['hora_fim']."'" : 'NULL';

        // Limites
        $limite_uso = isset($dados['limite_uso']) && $dados['limite_uso'] > 0 ? (int)$dados['limite_uso'] : 'NULL';
        $limite_cliente = isset($dados['limite_cliente']) && $dados['limite_cliente'] > 0 ? (int)$dados['limite_cliente'] : 'NULL';

        if ($id != null) {
            // UPDATE
            $query = "UPDATE promocao SET
                promocao_tipo = '$tipo',
                promocao_titulo = '$titulo',
                promocao_descricao = '$descricao',
                promocao_descricao_fim = '$descricao_fim',
                promocao_categoria = '$categoria',
                promocao_dias_semana = '$dias_semana',
                promocao_qtd_compra = $qtd_compra,
                promocao_valor_minimo = $valor_minimo,
                promocao_premio_mensagem = '$premio_mensagem',
                promocao_premio_qtd = $premio_qtd,
                promocao_premio_produto = '$premio_produto',
                promocao_premio_item_id = " . ($premio_item_id ? $premio_item_id : 'NULL') . ",
                promocao_desconta_estoque = $desconta_estoque,
                promocao_produtos_compra = " . ($produtos_compra ? "'$produtos_compra'" : 'NULL') . ",
                promocao_data_inicio = $data_inicio,
                promocao_data_fim = $data_fim,
                promocao_hora_inicio = $hora_inicio,
                promocao_hora_fim = $hora_fim,
                promocao_limite_uso = $limite_uso,
                promocao_limite_cliente = $limite_cliente,
                promocao_prioridade = $prioridade,
                promocao_acumulativa = $acumulativa
                WHERE promocao_id = $id";
        } else {
            // INSERT
            $query = "INSERT INTO promocao (
                promocao_tipo, promocao_titulo, promocao_descricao, promocao_descricao_fim,
                promocao_categoria, promocao_dias_semana, promocao_qtd_compra, promocao_valor_minimo,
                promocao_premio_mensagem, promocao_premio_qtd, promocao_premio_produto,
                promocao_premio_item_id, promocao_desconta_estoque, promocao_produtos_compra,
                promocao_data_inicio, promocao_data_fim, promocao_hora_inicio, promocao_hora_fim,
                promocao_limite_uso, promocao_limite_cliente, promocao_prioridade, promocao_acumulativa,
                status
            ) VALUES (
                '$tipo', '$titulo', '$descricao', '$descricao_fim',
                '$categoria', '$dias_semana', $qtd_compra, $valor_minimo,
                '$premio_mensagem', $premio_qtd, '$premio_produto',
                " . ($premio_item_id ? $premio_item_id : 'NULL') . ", $desconta_estoque, " . ($produtos_compra ? "'$produtos_compra'" : 'NULL') . ",
                $data_inicio, $data_fim, $hora_inicio, $hora_fim,
                $limite_uso, $limite_cliente, $prioridade, $acumulativa,
                1
            )";
        }

        $this->db->query($query);
        return $id ?: $this->db->lastId;
    }

    /**
     * Registra uso de promoção no histórico
     */
    public function registrar_uso($promocao_id, $pedido_id, $cliente_id, $premio_qtd, $premio_item_id = null, $premio_descricao = '', $valor_pedido = 0)
    {
        $query = "INSERT INTO promocao_historico (
            promocao_id, pedido_id, cliente_id, premio_qtd,
            premio_item_id, premio_descricao, valor_pedido
        ) VALUES (
            $promocao_id, $pedido_id, $cliente_id, $premio_qtd,
            " . ($premio_item_id ? $premio_item_id : 'NULL') . ",
            '" . Filter::antiSQL($premio_descricao) . "',
            $valor_pedido
        )";
        $this->db->query($query);
    }

    /**
     * Verifica quantas vezes o cliente usou determinada promoção
     */
    public function get_uso_cliente($promocao_id, $cliente_id)
    {
        $query = "SELECT COUNT(*) as total
                  FROM promocao_historico
                  WHERE promocao_id = $promocao_id
                  AND cliente_id = $cliente_id";
        $this->db->query = $query;
        $result = $this->db->fetch();
        return $result[0]->total ?? 0;
    }

    /**
     * Valida se promoção pode ser aplicada
     */
    public function validar_promocao($promocao_id, $cliente_id = null)
    {
        $promocao = $this->get_by_id($promocao_id);

        if (!$promocao || $promocao->status != 1) {
            return ['valido' => false, 'motivo' => 'Promoção inativa'];
        }

        // Verificar limite global
        if ($promocao->promocao_limite_uso && $promocao->promocao_uso_atual >= $promocao->promocao_limite_uso) {
            return ['valido' => false, 'motivo' => 'Promoção esgotada'];
        }

        // Verificar limite por cliente
        if ($cliente_id && $promocao->promocao_limite_cliente) {
            $uso_cliente = $this->get_uso_cliente($promocao_id, $cliente_id);
            if ($uso_cliente >= $promocao->promocao_limite_cliente) {
                return ['valido' => false, 'motivo' => 'Você já usou esta promoção o máximo de vezes permitido'];
            }
        }

        // Verificar estoque do prêmio (se desconta estoque)
        if ($promocao->promocao_desconta_estoque && $promocao->promocao_premio_item_id) {
            if (!isset($promocao->premio_produto_estoque) || $promocao->premio_produto_estoque < $promocao->promocao_premio_qtd) {
                return ['valido' => false, 'motivo' => 'Prêmio sem estoque'];
            }
        }

        return ['valido' => true];
    }

    /**
     * Altera status ativo/inativo
     */
    public function altera_status($id, $status)
    {
        $status = ($status == 1) ? 0 : 1;
        $this->db->query("UPDATE promocao SET status = '$status' WHERE promocao_id = $id;");
    }

    /**
     * Remove promoção
     */
    public function remove($id)
    {
        // Primeiro remove histórico relacionado
        $this->db->query("DELETE FROM promocao_historico WHERE promocao_id = $id;");
        // Depois remove a promoção
        $this->db->query("DELETE FROM promocao WHERE promocao_id = $id;");
    }

    public function __destruct()
    {
        //
    }
}
