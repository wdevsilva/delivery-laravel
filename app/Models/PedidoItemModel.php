<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoItemModel extends Model
{
    protected $table = 'pedido_lista';
    protected $primaryKey = 'lista_id';
    public $timestamps = false;

    protected $fillable = [
        'lista_pedido',
        'lista_item',
        'lista_item_nome',
        'lista_item_preco',
        'lista_opcao',
        'lista_opcao_preco',
        'lista_opcao_nome',
        'lista_qtde',
        'lista_item_obs',
    ];

    protected $casts = [
        'lista_item_preco' => 'decimal:2',
        'lista_opcao_preco' => 'decimal:2',
    ];

    public function pedido()
    {
        return $this->belongsTo(PedidoModel::class, 'lista_pedido', 'pedido_id');
    }

    public function item()
    {
        return $this->belongsTo(ItemModel::class, 'lista_item', 'item_id');
    }

    public function getSubtotalAttribute()
    {
        return ($this->lista_item_preco + $this->lista_opcao_preco) * $this->lista_qtde;
    }
}
