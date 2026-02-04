<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';
    protected $primaryKey = 'config_id';
    public $timestamps = false;

    protected $fillable = [
        'config_nome',
        'config_foto',
        'config_desc',
        'config_aberto',
        'config_fone1',
        'config_fone2',
        'config_endereco',
        'config_taxa_entrega',
    ];
}
