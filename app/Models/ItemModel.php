<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemModel extends Model
{
    use HasFactory;

    public $table = 'item';
    public $primaryKey = 'item_id';
    public $timestamps = false;

    public $fillable = ['*'];
}
