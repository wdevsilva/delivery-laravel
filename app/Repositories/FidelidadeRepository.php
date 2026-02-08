<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class FidelidadeRepository
{
    private $config;

    public function __construct()
    {
        $configRepo = new ConfigRepository();
        $this->config = $configRepo->get_config();
    }

    public function get_saldo_cliente($cliente_id)
    {
        if (!$this->is_ativo()) {
            return null;
        }

        $fidelidade = DB::table('cliente_fidelidade')
            ->where('cliente_id', $cliente_id)
            ->first();

        // Se não existe, criar
        if (!$fidelidade) {
            $this->criar_registro_cliente($cliente_id);
            return $this->get_saldo_cliente($cliente_id);
        }

        return $fidelidade;
    }

    public function is_ativo()
    {
        return isset($this->config->config_fidelidade_ativo) && $this->config->config_fidelidade_ativo == 1;
    }

    private function criar_registro_cliente($cliente_id)
    {
        DB::table('cliente_fidelidade')->insert([
            'cliente_id' => $cliente_id,
            'pontos' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
