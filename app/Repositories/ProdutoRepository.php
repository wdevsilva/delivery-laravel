<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProdutoRepository
{

    public function produtosMaisVendidos()
    {
        $results = DB::select("
            -- CTE para média de vendas
            WITH vendas_por_item AS (
                SELECT
                    l.lista_item,
                    COUNT(*) / 2 AS total_vendido
                FROM pedido p
                JOIN pedido_lista l ON p.pedido_id = l.lista_pedido
                WHERE p.pedido_data >= DATE_FORMAT(CURDATE() - INTERVAL 2 MONTH, '%Y-%m-01')
                AND p.pedido_data <= LAST_DAY(CURDATE())
                AND p.pedido_status != '5'
                GROUP BY l.lista_item
            ),
            media_vendas AS (
                SELECT AVG(total_vendido) AS media_geral
                FROM vendas_por_item
            )
            -- Itens mais vendidos acima da média
            SELECT
                i.item_id,
                i.item_nome,
                i.item_foto,
                i.item_preco,
                i.item_estoque,
                i.item_obs,
                i.item_desc,
                i.item_codigo,
                i.item_promo,
                FLOOR(v.total_vendido) AS media_vendida,
                c.categoria_id,
                c.categoria_nome,
                c.categoria_meia,
                c.categoria_img
            FROM vendas_por_item v
            JOIN item i ON i.item_id = v.lista_item
            JOIN categoria c ON i.item_categoria = c.categoria_id
            JOIN media_vendas mv ON 1=1
            WHERE v.total_vendido > mv.media_geral
            AND i.item_ativo = 1
            AND c.categoria_ativa = 1
            UNION ALL
            -- Itens em promoção
            SELECT
                i.item_id,
                i.item_nome,
                i.item_foto,
                i.item_preco,
                i.item_estoque,
                i.item_obs,
                i.item_desc,
                i.item_codigo,
                i.item_promo,
                0 AS media_vendida,
                c.categoria_id,
                c.categoria_nome,
                c.categoria_meia,
                c.categoria_img
            FROM item i
            JOIN categoria c ON i.item_categoria = c.categoria_id
            WHERE i.item_promo = 1
            AND i.item_ativo = 1
            AND c.categoria_ativa = 1
            ORDER BY RAND()
            LIMIT 20
        ");

        $dados = array_map(function($item) {
            return (array) $item;
        }, $results);

        $cat_item = [];
        $k = 0;
        foreach ($dados as $cat) {
            $cat = (object) $cat;
            $itensAll = self::get_by_categoria($cat->categoria_id);
            $itens = self::get_by_categoria($cat->categoria_id, 1000);
            $opcoes = self::get_opcoes_by_categoria($cat->categoria_id);
            if (isset($itens[0]->item_id)) {
                $cat_item[$k]['item_id'] = $cat->item_id;
                $cat_item[$k]['item_nome'] = $cat->item_nome;
                $cat_item[$k]['item_foto'] = $cat->item_foto;
                $cat_item[$k]['item_preco'] = $cat->item_preco;
                $cat_item[$k]['item_estoque'] = $cat->item_estoque;
                $cat_item[$k]['item_obs'] = $cat->item_obs;
                $cat_item[$k]['item_desc'] = $cat->item_desc;
                $cat_item[$k]['item_codigo'] = $cat->item_codigo ?? '';
                $cat_item[$k]['item_promo'] = $cat->item_promo;
                $cat_item[$k]['media_vendida'] = $cat->media_vendida;
                $cat_item[$k]['categoria'] = $cat->categoria_nome;
                $cat_item[$k]['categoria_id'] = $cat->categoria_id;
                $cat_item[$k]['categoria_meia'] = $cat->categoria_meia;
                $cat_item[$k]['categoria_img'] = $cat->categoria_img;
                $cat_item[$k]['item'] = $itens->toArray();
                $cat_item[$k]['itemAll'] = $itensAll->toArray();
                $cat_item[$k]['opcoes'] = $opcoes;
                $k++;
            }
        }

        return $cat_item;
    }

    public function produtos($categoria, $limit = 1000)
    {
        if (empty($categoria)) {
            return false;
        }

        $cat_item = [];
        $k = 0;
        foreach ($categoria as $cat) {
            $itens = self::get_by_categoria($cat->categoria_id);
            $opcoes = self::get_opcoes_by_categoria($cat->categoria_id);
            if ($itens->isNotEmpty()) {
                $cat_item[$k]['categoria'] = $cat->categoria_nome;
                $cat_item[$k]['categoria_id'] = $cat->categoria_id;
                $cat_item[$k]['categoria_meia'] = $cat->categoria_meia;
                $cat_item[$k]['categoria_img'] = $cat->categoria_img;
                $cat_item[$k]['item'] = $itens->toArray();
                $cat_item[$k]['opcoes'] = $opcoes;
                $k++;
            }
        }

        return $cat_item;
    }

    public function get_by_categoria($id)
    {
        $query = DB::table("item")
            ->select(
                "item_id",
                "item_categoria",
                "item_nome",
                "item_obs",
                "item_desc",
                "item_foto",
                "item_preco",
                "item_codigo",
                "categoria_nome",
                "categoria_id",
                "categoria_meia",
                "item_estoque"
            )
            ->from("item")
            ->join("categoria", "categoria_id", "=", "item_categoria")
            ->where("item_id", ">=", 1)
            ->where("item_ativo", "=", 1)
            ->where("item.item_categoria", "=", $id)
            ->orderBy("item_nome", "ASC")
            ->get();

        return $query;
    }

    public function get_opcoes_by_categoria($id)
    {
        $grupos = DB::table('grupo')
            ->join('relprod', 'grupo_id', '=', 'relprod_grupo')
            ->where('relprod_categoria', $id)
            ->where('grupo_ativa', 1)
            ->groupBy('relprod_grupo', 'relprod_pos')
            ->orderBy('relprod_pos', 'ASC')
            ->pluck('grupo_id');

        $opcoes = [];
        if ($grupos->isNotEmpty()) {
            foreach ($grupos as $grupo_id) {
                $data = DB::table('opcao')
                    ->join('grupo', 'grupo_id', '=', 'opcao_grupo')
                    ->where('opcao_grupo', $grupo_id)
                    ->where('opcao_status', 1)
                    ->orderBy('opcao_preco', 'ASC')
                    ->select('opcao_id', 'opcao_nome', 'opcao_preco', 'grupo_tipo', 'grupo_selecao', 'grupo_id', 'grupo_nome', 'grupo_limite')
                    ->get();
                if ($data->isNotEmpty()) {
                    $opcoes[] = $data->toArray();
                }
            }
        }
        return !empty($opcoes) ? $opcoes : null;
    }
}
