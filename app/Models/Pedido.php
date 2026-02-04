<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'pedido_id';
    public $timestamps = false;

    protected $fillable = [
        'pedido_data',
        'pedido_cliente',
        'pedido_local',
        'pedido_status',
        'pedido_obs',
        'pedido_total',
        'pedido_desconto',
        'pedido_entrega',
        'pedido_id_pagto',
    ];

    protected $casts = [
        'pedido_data' => 'datetime',
        'pedido_total' => 'decimal:2',
        'pedido_desconto' => 'decimal:2',
        'pedido_entrega' => 'decimal:2',
    ];

    // Relacionamentos
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'pedido_cliente', 'cliente_id');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'pedido_local', 'endereco_id');
    }

    public function itens()
    {
        return $this->hasMany(PedidoItem::class, 'pedido_id', 'pedido_id');
    }

    public function entregador()
    {
        return $this->belongsTo(Entregador::class, 'pedido_entregador', 'entregador_id');
    }
}
