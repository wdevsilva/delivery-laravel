<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoModel extends Model
{
    use HasFactory;

    public $table = 'promocao';
    public $primaryKey = 'promocao_id';
    public $timestamps = false;

    public $fillable = ['*'];
}
