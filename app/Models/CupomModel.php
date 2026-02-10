<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CupomModel extends Model
{
    public $table = 'cupom';
    public $primaryKey = 'cupom_id';
    public $timestamps = false;

    public $fillable = ['*'];
}
