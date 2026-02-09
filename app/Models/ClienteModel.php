<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ClienteModel extends Authenticatable
{
    protected $table = 'cliente';
    protected $primaryKey = 'cliente_id';
    public $timestamps = false;

    protected $fillable = [
        'cliente_nome',
        'cliente_email',
        'cliente_fone',
        'cliente_fone2',
        'cliente_cpf',
        'cliente_senha',
        'cliente_nasc',
        'cliente_status',
        'cliente_marketing_whatssapp',
    ];

    protected $hidden = [
        'cliente_senha',
        'cliente_token',
    ];

    public function getAuthPassword()
    {
        return $this->cliente_senha;
    }

    // Relacionamentos
    public function enderecos()
    {
        return $this->hasMany(EnderecoModel::class, 'endereco_cliente', 'cliente_id');
    }

    public function pedidos()
    {
        return $this->hasMany(PedidoModel::class, 'cliente_id', 'cliente_id');
    }
}
