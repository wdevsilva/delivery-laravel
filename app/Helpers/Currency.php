<?php

namespace App\Helpers;

class Currency
{
    public static function moeda($valor, $decimals = 2, $dec_point = ',', $thousands_sep = '.')
    {
        return number_format((float)$valor, $decimals, $dec_point, $thousands_sep);
    }

    public static function moedaUS($valor)
    {
        $v = str_replace('.', '', $valor);
        $v = str_replace(',', '.', $v);
        return $v;
    }
}
