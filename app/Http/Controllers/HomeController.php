<?php

namespace App\Http\Controllers;

use App\Repositories\ConfigRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\ItemRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $configRepository;
    protected $categoriaRepository;
    protected $itemRepository;

    public function __construct(
        ConfigRepository $configRepository,
        CategoriaRepository $categoriaRepository,
        ItemRepository $itemRepository
    ) {
        $this->configRepository = $configRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->itemRepository = $itemRepository;
    }

    public function index()
    {
        $config = $this->configRepository->getConfig();
        $categorias = $this->categoriaRepository->getAtivas();
        $maisVendidos = $this->itemRepository->produtosMaisVendidos();
        $promocoes = collect($maisVendidos)->where('item_promo', 1)->take(10);

        return view('site.index', compact('config', 'categorias', 'maisVendidos', 'promocoes'));
    }
}
