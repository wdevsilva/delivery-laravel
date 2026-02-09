<?php

namespace App\Http\Controllers;

use App\Repositories\ConfigRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProdutoRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $configRepository;
    protected $categoriaRepository;
    protected $produtoRepository;

    public function __construct(
        ConfigRepository $configRepository,
        CategoriaRepository $categoriaRepository,
        ProdutoRepository $produtoRepository
    ) {
        $this->configRepository = $configRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->produtoRepository = $produtoRepository;

        // Definir base_delivery na sessão se não existir
        @session_start();
        if (!isset($_SESSION['base_delivery'])) {
            $config = $configRepository->getConfig();
            $_SESSION['base_delivery'] = $config->config_token ?? 'default';
            session(['base_delivery' => $_SESSION['base_delivery']]);
        }
    }

    public function index()
    {
        $config = $this->configRepository->getConfig();
        $categorias = $this->categoriaRepository->getAtivas();
        $maisVendidos = $this->produtoRepository->produtosMaisVendidos();
        $promocoes = collect($maisVendidos)->where('item_promo', 1)->take(10);

        $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
        $baseUri = url('/');
        $baseDelivery = session('base_delivery', '');

        return view('site.index', compact(
            'config',
            'categorias',
            'maisVendidos',
            'promocoes',
            'isMobile',
            'baseUri',
            'baseDelivery'
        ));
    }
}
