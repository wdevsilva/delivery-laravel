<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    use HasFactory;

    public $table = 'config';
    public $primaryKey = 'config_id';
    public $timestamps = false;

    public $fillable = ['*'];
}
