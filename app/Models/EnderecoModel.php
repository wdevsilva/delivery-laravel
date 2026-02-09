<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnderecoModel extends Model
{
    protected $table = 'endereco';
    protected $primaryKey = 'endereco_id';
    public $timestamps = false;

    protected $fillable = [
        'endereco_cliente',
        'endereco_nome',
        'endereco_endereco',
        'endereco_numero',
        'endereco_bairro',
        'endereco_cidade',
        'endereco_uf',
        'endereco_cep',
        'endereco_referencia',
        'endereco_complemento',
        'endereco_lat',
        'endereco_lng',
    ];

    public function cliente()
    {
        return $this->belongsTo(ClienteModel::class, 'endereco_cliente', 'cliente_id');
    }

    public function getEnderecoCompletoAttribute()
    {
        return $this->endereco_endereco . ', ' . $this->endereco_numero . ' - ' . $this->endereco_bairro;
    }
}
