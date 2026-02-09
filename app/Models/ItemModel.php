<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'item_id';
    public $timestamps = false;

    protected $fillable = [
        'item_categoria',
        'item_nome',
        'item_desc',
        'item_foto',
        'item_preco',
        'item_codigo',
        'item_ativo',
        'item_promo',
        'item_estoque',
    ];

    protected $casts = [
        'item_preco' => 'decimal:2',
        'item_ativo' => 'boolean',
        'item_promo' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaModel::class, 'item_categoria', 'categoria_id');
    }

    public function opcoes()
    {
        return $this->hasMany(OpcaoModel::class, 'opcao_produto', 'item_id');
    }

    public function scopeAtivo($query)
    {
        return $query->where('item_ativo', 1);
    }

    public function scopePromocao($query)
    {
        return $query->where('item_promo', 1);
    }
}
