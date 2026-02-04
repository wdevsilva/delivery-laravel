<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'endereco';
    protected $primaryKey = 'endereco_id';
    public $timestamps = false;

    protected $fillable = [
        'endereco_cliente',
        'endereco_endereco',
        'endereco_numero',
        'endereco_bairro',
        'endereco_cidade',
        'endereco_uf',
        'endereco_cep',
        'endereco_referencia',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'endereco_cliente', 'cliente_id');
    }

    public function getEnderecoCompletoAttribute()
    {
        return $this->endereco_endereco . ', ' . $this->endereco_numero . ' - ' . $this->endereco_bairro;
    }
}
