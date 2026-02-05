<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OpcaoModel extends Model
{
    protected $table = 'opcao';
    protected $primaryKey = 'opcao_id';
    public $timestamps = false;

    public static function get_by_categoria($id)
    {
        $grupos = DB::select(
            "SELECT grupo_id FROM grupo
            JOIN relprod ON (grupo_id = relprod_grupo)
            WHERE relprod_categoria = ? AND grupo_ativa = 1
            GROUP BY relprod_grupo ORDER BY relprod_pos ASC",
            [$id]
        );

        $opcoes = [];
        if (isset($grupos[0])) {
            foreach ($grupos as $grupo) {
                $data = DB::select(
                    "SELECT opcao_id,opcao_nome,opcao_preco,grupo_tipo,grupo_selecao,grupo_id,grupo_nome,grupo_limite
                    FROM opcao
                    JOIN grupo ON (grupo_id = opcao_grupo)
                    WHERE opcao_grupo = ?
                    AND opcao_status = 1
                    ORDER BY opcao_preco ASC",
                    [$grupo->grupo_id]
                );

                if (isset($data[0])) {
                    $opcoes[] = $data;
                }
            }
        }

        return isset($opcoes) ? $opcoes : null;
    }
}
