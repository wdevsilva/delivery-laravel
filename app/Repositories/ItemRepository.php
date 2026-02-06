<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemRepository
{
    /**
     * Busca produtos mais vendidos acima da média dos últimos 2 meses
     * + Produtos em promoção
     */
    public function produtosMaisVendidos()
    {
        return DB::select("
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
                c.categoria_nome AS categoria,
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
                c.categoria_nome AS categoria,
                c.categoria_meia,
                c.categoria_img
            FROM item i
            JOIN categoria c ON i.item_categoria = c.categoria_id
            WHERE i.item_promo = 1
            AND i.item_ativo = 1
            AND c.categoria_ativa = 1
            ORDER BY media_vendida DESC, item_promo DESC
        ");
    }

    /**
     * Busca opções/adicionais do item
     */
    public function getOpcoesPorItem($itemId)
    {
        return DB::select("
            SELECT o.*
            FROM opcao o
            WHERE o.opcao_ativa = 1
            AND FIND_IN_SET(?, o.opcao_item) > 0
            ORDER BY o.opcao_ordem
        ", [$itemId]);
    }

    public function getByCategoria($id, $limit = 100000)
    {
        return DB::table('item')
            ->select(
                'item.item_id',
                'item.item_categoria',
                'item.item_nome',
                'item.item_obs',
                'item.item_desc',
                'item.item_foto',
                'item.item_preco',
                'item.item_codigo',
                'item.item_estoque',
                'categoria.categoria_nome',
                'categoria.categoria_id',
                'categoria.categoria_meia'
            )
            ->join('categoria', 'categoria.categoria_id', '=', 'item.item_categoria')
            ->where('item.item_id', '>=', 1)
            ->where('item.item_ativo', '=', 1)
            ->where('item.item_categoria', '=', $id)
            ->orderBy('item.item_nome', 'ASC')
            ->limit($limit)
            ->get();
    }
}
