<?php

namespace App\Http\Controllers\Loja;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CupomController extends Controller
{
    /**
     * API para buscar cupom ativo
     * GET /api-cupom-ativo.php
     */
    public function apiCupomAtivo()
    {
        try {
            // Buscar cupom ativo
            $cupom = DB::table('cupom')
                ->where('status', 1)
                ->where('cupom_validade', '>=', DB::raw('CURDATE()'))
                ->whereRaw('cupom_quantidade > cupom_usado')
                ->orderBy('cupom_criado_em', 'desc')
                ->first();

            if ($cupom) {
                return response()->json($cupom);
            } else {
                return response()->json(['error' => 'Nenhum cupom ativo'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno: ' . $e->getMessage()], 500);
        }
    }
}
