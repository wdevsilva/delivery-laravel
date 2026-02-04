<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'categoria_id';
    public $timestamps = false;

    protected $fillable = [
        'categoria_nome',
        'categoria_pos',
        'categoria_ordem',
        'categoria_ativa',
        'requer_cozinha',
        'categoria_img',
    ];

    protected $casts = [
        'categoria_ativa' => 'boolean',
        'requer_cozinha' => 'boolean',
    ];

    public function itens()
    {
        return $this->hasMany(Item::class, 'item_categoria', 'categoria_id');
    }

    public function scopeAtiva($query)
    {
        return $query->where('categoria_ativa', 1);
    }
}
