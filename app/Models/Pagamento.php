<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $table = 'pagamento';
    protected $primaryKey = 'pagamento_id';
    public $timestamps = false;

    protected $fillable = [
        'pagamento_nome',
        'pagamento_status',
        'pagamento_tipo',
        'pagamento_gw',
        'pagamento_usuario',
        'pagamento_senha',
    ];
}
