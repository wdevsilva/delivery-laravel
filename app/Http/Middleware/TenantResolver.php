<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class TenantResolver
{
    public function handle(Request $request, Closure $next)
    {
        $token = null;

        // 1. Verificar token na URL
        if ($request->has('token') && !empty($request->get('token'))) {
            $token = preg_replace('/[^[:alnum:]_]/', '', $request->get('token'));
        }
        // 2. Verificar token no cookie
        elseif ($request->hasCookie('delivery_token') && !empty($request->cookie('delivery_token'))) {
            $token = preg_replace('/[^[:alnum:]_]/', '', $request->cookie('delivery_token'));
        }
        // 3. Verificar token na sessão
        elseif (session()->has('delivery_token')) {
            $token = session('delivery_token');
        }

        if ($token) {
            try {
                // Conecta ao banco principal para buscar a base do tenant
                $mainConnection = DB::connection('mysql_main');

                // Tenta buscar pelo token (hash)
                $base = $mainConnection->table('bases')
                    ->where('token', $token)
                    ->where('ativo', '1')
                    ->first(['base', 'prefix']);

                // Se não encontrou pelo hash, tenta pelo nome_base_token
                if (!$base) {
                    $base = $mainConnection->table('bases')
                        ->where('nome_base_token', $token)
                        ->where('ativo', '1')
                        ->first(['base', 'prefix']);
                }

                if ($base) {
                    // Armazena na sessão
                    session([
                        'base_delivery' => $base->base,
                        'prefix_delivery' => $base->prefix ?? '',
                        'delivery_token' => $token
                    ]);

                    // Define cookie para 30 dias
                    Cookie::queue('delivery_token', $token, 60 * 24 * 30);

                    // Reconecta ao banco do tenant
                    $this->switchTenantDatabase($base->base, $base->prefix ?? '');
                }
            } catch (\Exception $e) {
                // Log erro mas continua com base padrão
                Log::error('Erro ao resolver tenant: ' . $e->getMessage());
            }
        }

        // Se não tem token ou não encontrou, usa base da sessão ou padrão
        if (!session()->has('base_delivery')) {
            $defaultBase = explode(',', env('BASES', 'default'))[0];
            session(['base_delivery' => $defaultBase]);
            $this->switchTenantDatabase($defaultBase, '');
        } else {
            $this->switchTenantDatabase(
                session('base_delivery'),
                session('prefix_delivery', '')
            );
        }

        return $next($request);
    }

    protected function switchTenantDatabase($base, $prefix = '')
    {
        $databaseName = $prefix . $base;

        // Atualiza a configuração da conexão mysql padrão
        Config::set('database.connections.mysql.database', $databaseName);

        // Reconecta para aplicar a mudança
        DB::purge('mysql');
        DB::reconnect('mysql');

        // Define sql_mode removendo ONLY_FULL_GROUP_BY
        try {
            DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");
        } catch (\Exception $e) {
            Log::warning('Não foi possível ajustar sql_mode: ' . $e->getMessage());
        }
    }
}
