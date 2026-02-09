<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProdutoRepository;
use Illuminate\Support\Facades\Session;
use App\Repositories\CategoriaRepository;
use App\Repositories\ConfigRepository;

class CategoriaController extends Controller
{
    protected $categoria_repository;
    protected $produto_repository;
    protected $config_repository;

    public function __construct(CategoriaRepository $cr, ProdutoRepository $pr, ConfigRepository $configr)
    {
        $this->categoria_repository = $cr;
        $this->produto_repository = $pr;
        $this->config_repository = $configr;

        // Definir base_delivery na sessão se não existir
        @session_start();
        if (!isset($_SESSION['base_delivery'])) {
            $config = $configr->getConfig();
            $_SESSION['base_delivery'] = $config->config_token ?? 'default';
            session(['base_delivery' => $_SESSION['base_delivery']]);
        }
    }
    public function show($id)
    {
        $config = $this->config_repository->getConfig();
        $categoria = $this->categoria_repository->getCategoriaPorId($id);

        $produtos = $this->produto_repository->produtos($categoria, $config->config_home_qtde);

        $dados = [
            'config' => $config,
            'categoria' => $categoria,
            'lista' => $produtos
        ];

        $baseUri = url('/');
        $baseDelivery = config('database.connections.mysql.database');
        $isMobile = request()->header('User-Agent') && preg_match('/(android|iphone|ipad|mobile)/i', request()->header('User-Agent'));

        return view('site.produto.produto-categoria', compact(
            'dados',
            'baseUri',
            'baseDelivery',
            'isMobile',
            'config'));
    }
}
