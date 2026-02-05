<?php

namespace App\Repositories;

use App\Models\ConfigModel;
use App\Models\CategoriaModel;

class CategoriaRepository
{
    public function get_config()
    {
        $query = ConfigModel::first();
        return (isset($query[0])) ? $query[0] : null;
    }

    public function getAtivas()
    {
        return CategoriaModel::where("categoria_ativa", 1)->orderBy("categoria_pos", "ASC")->get();
    }

    public function getCategoriaPorId($id)
    {
        $query = CategoriaModel::where("categoria_ativa", 1)->where("categoria_id", $id)
        ->orderBy("categoria_pos", "ASC")->get();

        return $query;
    }
}
