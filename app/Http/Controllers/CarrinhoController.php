<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Helpers\Filter;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Models\PromocaoModel;
use App\Repositories\ItemRepository;
use App\Repositories\ConfigRepository;
use Illuminate\Support\Facades\Session;
use App\Repositories\CategoriaRepository;

class CarrinhoController extends Controller
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

    static public function _show()
    {
        Filter::pre($_SESSION['__APP__CART__']);
    }

    static public function isfull()
    {
        if (isset($_SESSION['__APP__CART__']) && !empty($_SESSION['__APP__CART__'])) {
            return true;
        } else {
            return false;
        }
    }

    static public function count()
    {
        if (isset($_SESSION['__APP__CART__']) && !empty($_SESSION['__APP__CART__'])) {
            return count($_SESSION['__APP__CART__']);
        } else {
            return 0;
        }
    }

    static public function get_count()
    {
        if (isset($_SESSION['__APP__CART__']) && count($_SESSION['__APP__CART__']) >= 1) {
            return '<span class="badge">' . count($_SESSION['__APP__CART__']) . '</span>';
        } else {
            return '';
        }
    }

    static public function get_all()
    {
        if (isset($_SESSION['__APP__CART__'])) {
            return $_SESSION['__APP__CART__'];
        } else {
            return false;
        }
    }

    static public function get_promocoes()
    {
        $promocoes = PromocaoModel::orderBy('promocao_descricao ASC')->get();
        $dados = [
            'promocao' => $promocoes
        ];
        return $dados;
    }

    public function adicionar(Request $request)
    {
        // CRÍTICO: Suprimir QUALQUER output antes do JSON
        @ini_set('display_errors', '0');
        error_reporting(0);

        // Limpar TODOS os buffers existentes
        while (ob_get_level()) {
            ob_end_clean();
        }
        ob_start();

        // Definir header IMEDIATAMENTE
        header('Content-Type: application/json; charset=utf-8');

        try {
            $data = $request->all();
            if (!empty($data) && isset($data['item_id'])) {

                $object = new \stdClass();
                foreach ($data as $key => $value) {
                    $object->$key = Filter::trim_str($value);
                }

                // Remove itens temporários do mesmo produto se flag estiver ativa
                if (isset($data['remove_temp']) && $data['remove_temp'] == 1) {
                    if (isset($_SESSION['__APP__CART__'])) {
                        foreach ($_SESSION['__APP__CART__'] as $k => $cart_item) {
                            if ($cart_item->item_id == $data['item_id'] &&
                                isset($cart_item->temp_preview) && $cart_item->temp_preview == 1) {
                                unset($_SESSION['__APP__CART__'][$k]);
                            }
                        }
                        // Reindexar array
                        $_SESSION['__APP__CART__'] = array_values($_SESSION['__APP__CART__']);
                    }
                }

                // IMPORTANTE: Buscar o estoque do produto do banco de dados
                if (isset($object->item_id)) {
                    $itemDB = Item::find($object->item_id);
                    if ($itemDB) {
                        $object->item_estoque = intval($itemDB->item_estoque ?? 9999);
                    } else {
                        $object->item_estoque = 9999; // Estoque ilimitado se não encontrar
                    }
                    error_log("[CARRINHO] Estoque do produto {$object->item_id}: {$object->item_estoque}");
                }

                if (isset($object->item_preco) && isset($object->item_nome)) {
                    // Accept qtde from POST, default to 1 if not provided
                    $qtde_adicionar = isset($data['qtde']) && intval($data['qtde']) > 0 ? intval($data['qtde']) : 1;

                    // Verificar se o produto já existe no carrinho (mesmo item_id e extras)
                    $item_existente = null;
                    $item_key = null;
                    $extra_post = isset($data['extra']) ? $data['extra'] : '';

                    if (isset($_SESSION['__APP__CART__'])) {
                        foreach ($_SESSION['__APP__CART__'] as $k => $cart_item) {
                            // Verifica se é o mesmo produto E tem os mesmos extras
                            if ($cart_item->item_id == $object->item_id &&
                                (isset($cart_item->extra) ? $cart_item->extra : '') == $extra_post) {
                                $item_existente = $cart_item;
                                $item_key = $k;
                                break;
                            }
                        }
                    }

                    // Se o item já existe, incrementar quantidade
                    if ($item_existente !== null && $item_key !== null) {

                        // Verificar estoque
                        $nova_qtde = intval($item_existente->qtde) + $qtde_adicionar;
                        $object->qtde = $nova_qtde; // Usar para check_exist

                        if (self::check_exist($object)) {
                            $_SESSION['__APP__CART__'][$item_key]->qtde = $nova_qtde;
                            echo json_encode(['success' => true, 'message' => 'Quantidade atualizada']);
                            exit;
                        } else {
                            echo json_encode(['success' => false, 'error' => 'Estoque insuficiente']);
                            exit;
                        }
                    } else {
                        // Item novo, adicionar ao carrinho
                        $object->qtde = $qtde_adicionar;
                        $object->item_hash = uniqid(time());

                        // IMPORTANTE: Calcular e armazenar o total do item (preço + extras)
                        $preco_base = floatval($object->item_preco ?? 0);
                        $preco_extras = floatval($object->extra_preco ?? 0);
                        $object->total = $preco_base + $preco_extras;

                        if (self::check_exist($object)) {
                            $_SESSION['__APP__CART__'][] = $object;

                            // Retornar sucesso em JSON
                            echo json_encode(['success' => true, 'message' => 'Produto adicionado']);
                            exit;
                        } else {
                            echo json_encode(['success' => false, 'error' => 'Produto esgotado ou quantidade excedida']);
                            exit;
                        }
                    }
                }
            }

            // Se chegou aqui, algo deu errado
            echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
            exit;

        } catch (\Exception $e) {
            error_log("[CARRINHO] Exceção: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Erro interno: ' . $e->getMessage()]);
            exit;
        }
    }

    public static function verifica_item($item = null)
    {
        if (isset($_SESSION['__APP__CART__'])) {
            foreach ($_SESSION['__APP__CART__'] as $k => $v) {
                if ($_SESSION['__APP__CART__'][$k]->item_id === $item->item_id) {
                    return true;
                }
            }
        }
    }

    /**
     * Verifica e aplica promoções no carrinho
     * Suporta múltiplos tipos: quantidade_categoria, valor_minimo, produto_especifico, combo
     */
    static public function check_promocao()
    {
        $promoModel = new PromocaoModel();
        $carrinho = self::get_all();
        $promocoes_aplicadas = [];

        if (empty($carrinho)) {
            return [];
        }

        // Buscar promoções ativas
        $promocoes = $promoModel->get_all_ativas();

        if (empty($promocoes)) {
            return [];
        }

        // Calcular total do pedido para promoções por valor
        $total_pedido = self::get_total();

        // Agrupar produtos do carrinho por categoria e por ID
        $por_categoria = [];
        $por_produto = [];

        foreach ($carrinho as $item) {
            // Por categoria
            if (!isset($por_categoria[$item->categoria_id])) {
                $por_categoria[$item->categoria_id] = ['qtd' => 0, 'itens' => []];
            }
            $por_categoria[$item->categoria_id]['qtd'] += $item->qtde;
            $por_categoria[$item->categoria_id]['itens'][] = $item;

            // Por produto
            if (!isset($por_produto[$item->item_id])) {
                $por_produto[$item->item_id] = ['qtd' => 0, 'item' => $item];
            }
            $por_produto[$item->item_id]['qtd'] += $item->qtde;
        }

        // Processar cada promoção
        foreach ($promocoes as $promocao) {
            $premio = null;

            // Validar promoção
            $cliente_id = $_SESSION['__CLIENTE__ID__'] ?? null;
            $validacao = $promoModel->validar_promocao($promocao->promocao_id, $cliente_id);

            if (!$validacao['valido']) {
                continue;
            }

            // Aplicar conforme o tipo
            switch ($promocao->promocao_tipo) {
                case 'quantidade_categoria':
                    $premio = self::aplicar_promo_categoria($promocao, $por_categoria);
                    break;

                case 'valor_minimo':
                    $premio = self::aplicar_promo_valor($promocao, $total_pedido);
                    break;

                case 'produto_especifico':
                case 'combo':
                    $premio = self::aplicar_promo_combo($promocao, $carrinho, $promoModel);
                    break;
            }

            if ($premio) {
                $promocoes_aplicadas[] = $premio;

                // Se não é acumulativa, para aqui
                if (!$promocao->promocao_acumulativa) {
                    break;
                }
            }
        }

        // Renderizar promoções aplicadas
        self::renderizar_promocoes($promocoes_aplicadas);

        // Retornar array para ser salvo no pedido
        if ($_SERVER['REQUEST_URI'] == '/pedido/confirmar/') {
            return $promocoes_aplicadas;
        }

        return $promocoes_aplicadas;
    }

    /**
     * Aplica promoção por quantidade de categoria
     */
    private static function aplicar_promo_categoria($promocao, $por_categoria)
    {
        // Categorias podem ser múltiplas (separadas por vírgula)
        $categorias_ids = explode(',', $promocao->promocao_categoria);
        $categorias_ids = array_map('trim', $categorias_ids);

        $qtd_necessaria = $promocao->promocao_qtd_compra;
        $maior_qtd_encontrada = 0;

        // Verificar qual categoria tem mais itens
        foreach ($categorias_ids as $cat_id) {
            if (isset($por_categoria[$cat_id])) {
                $qtd_comprada = $por_categoria[$cat_id]['qtd'];
                if ($qtd_comprada > $maior_qtd_encontrada) {
                    $maior_qtd_encontrada = $qtd_comprada;
                }
            }
        }

        // Verificar se atingiu a quantidade necessária em qualquer categoria
        if ($maior_qtd_encontrada < $qtd_necessaria) {
            return null;
        }

        // Calcular quantos prêmios ganha
        $qtd_ganha = floor($maior_qtd_encontrada / $qtd_necessaria) * $promocao->promocao_premio_qtd;

        return [
            'id' => $promocao->promocao_id,
            'tipo' => 'quantidade_categoria',
            'titulo' => $promocao->promocao_titulo,
            'descricao' => $promocao->promocao_descricao,
            'descricao_fim' => $promocao->promocao_descricao_fim,
            'produto' => $promocao->promocao_premio_produto ?: ($promocao->premio_produto_nome ?? 'Brinde'),
            'produto_id' => $promocao->promocao_premio_item_id,
            'qtd' => $qtd_ganha,
            'mensagem' => $promocao->promocao_premio_mensagem ?? 'PARABÉNS! VOCÊ GANHOU'
        ];
    }

    /**
     * Aplica promoção por valor mínimo
     */
    private static function aplicar_promo_valor($promocao, $total_pedido)
    {
        if ($total_pedido < $promocao->promocao_valor_minimo) {
            return null;
        }

        return [
            'id' => $promocao->promocao_id,
            'tipo' => 'valor_minimo',
            'titulo' => $promocao->promocao_titulo,
            'descricao' => $promocao->promocao_descricao,
            'descricao_fim' => $promocao->promocao_descricao_fim,
            'produto' => $promocao->promocao_premio_produto ?: ($promocao->premio_produto_nome ?? 'Brinde'),
            'produto_id' => $promocao->promocao_premio_item_id,
            'qtd' => $promocao->promocao_premio_qtd,
            'mensagem' => $promocao->promocao_premio_mensagem ?? 'PARABÉNS! VOCÊ GANHOU',
            'valor_minimo' => $promocao->promocao_valor_minimo
        ];
    }

    /**
     * Aplica promoção combo ou produto específico
     */
    private static function aplicar_promo_combo($promocao, $carrinho, $promoModel)
    {
        $produtos_compra = $promocao->promocao_produtos_compra;

        if (empty($produtos_compra)) {
            return null;
        }

        $resultado = $promoModel->verificar_combo($produtos_compra, $carrinho);

        if (!$resultado['atende']) {
            return null;
        }

        return [
            'id' => $promocao->promocao_id,
            'tipo' => $promocao->promocao_tipo,
            'titulo' => $promocao->promocao_titulo,
            'descricao' => $promocao->promocao_descricao,
            'descricao_fim' => $promocao->promocao_descricao_fim,
            'produto' => $promocao->promocao_premio_produto ?: ($promocao->premio_produto_nome ?? 'Brinde'),
            'produto_id' => $promocao->promocao_premio_item_id,
            'qtd' => $promocao->promocao_premio_qtd,
            'mensagem' => $promocao->promocao_premio_mensagem ?? 'PARABÉNS! VOCÊ GANHOU',
            'produtos_combo' => $resultado
        ];
    }

    /**
     * Renderiza promoções aplicadas na tela
     */
    private static function renderizar_promocoes($promocoes)
    {
        if (empty($promocoes)) {
            return;
        }

        $uri = $_SERVER['REQUEST_URI'] ?? '';

        foreach ($promocoes as $promo) {
            // No checkout (carrinho/pedido)
            if (strpos($uri, '/pedido/') !== false) {
                ?>
                <p class="text-capitalize">
                    <span class="badge badge-success"><i class="fa fa-gift"></i></span>
                    <span><?= $promo['qtd'] ?></span>
                    <small class="text-muted">x</small>
                    <?= $promo['produto'] ?>
                    <span class="pull-right text-success"><strong>GRÁTIS</strong></span>
                </p>
                <?php
            }

            // No modal de carrinho
            if (strpos($uri, '/carrinho/reload/') !== false) {
                ?>
                <div class="alert alert-success text-center">
                    <i class="fa fa-gift fa-2x"></i><br>
                    <strong><?= $promo['mensagem'] ?></strong><br>
                    <b><?= $promo['qtd'] . ' ' . $promo['produto'] ?></b>
                </div>
                <?php
            }
        }
    }

    static public function check_exist($item = null)
    {
        $qtde = 0;
        $flag = false;
        if (isset($_SESSION['__APP__CART__'])) {
            foreach ($_SESSION['__APP__CART__'] as $k => $v) {
                if ($_SESSION['__APP__CART__'][$k]->item_id == $item->item_id) {
                    $qtde += $_SESSION['__APP__CART__'][$k]->qtde;
                    $flag = true;
                }
            }
        }
        $qtde = (!$flag) ? 0 : $qtde;

        // Usar qtde do item atual ao invés de +1 fixo
        $qtde_adicionar = isset($item->qtde) ? intval($item->qtde) : 1;

        if (($qtde + $qtde_adicionar) <= $item->item_estoque) {
            return true;
        } else {
            return false;
        }
    }

    public function addMore(Request $request)
    {
        $hash = $request->input('hash');
        $item = new \stdClass;
        $item->item_id = $request->input('id');
        $item->item_estoque = $request->input('estoque');
        if (!$this->check_exist($item)) {
            echo '-1';
            exit;
        }
        if ($item->item_id > 0) {
            $carrinho = session('__APP__CART__', []);
            foreach ($carrinho as $k => $v) {
                if ($carrinho[$k]->item_hash == $hash) {
                    if ($carrinho[$k]->qtde + 1 <= $item->item_estoque) {
                        $carrinho[$k]->qtde++;
                        session(['__APP__CART__' => $carrinho]);
                        if ($carrinho[$k]->qtde <= 9) {
                            echo "0" . $carrinho[$k]->qtde;
                        } else {
                            echo $carrinho[$k]->qtde;
                        }
                    } else {
                        echo '-1';
                    }
                }
            }
        }
    }

    public function delMore(Request $request)
    {
        $hash = $request->input('hash');
        $id = $request->input('id');
        if ($id > 0) {
            if (isset($_SESSION['__APP__CART__'])) {
                foreach ($_SESSION['__APP__CART__'] as $k => $v) {
                    if ($_SESSION['__APP__CART__'][$k]->item_hash == $hash) {
                        if ($_SESSION['__APP__CART__'][$k]->qtde > 1) {
                            $_SESSION['__APP__CART__'][$k]->qtde--;
                            if ($_SESSION['__APP__CART__'][$k]->qtde <= 9)
                                echo "0" . $_SESSION['__APP__CART__'][$k]->qtde;
                            else
                                echo $_SESSION['__APP__CART__'][$k]->qtde;
                        } else {
                            if (isset($_SESSION['__APP__CART__'][$k])) {
                                unset($_SESSION['__APP__CART__'][$k]);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Remove completamente um item do carrinho pelo hash
     * Usado quando o usuário clica no X para remover o item
     */
    static public function del(Request $request)
    {
        $hash = $request->input('hash');

        if ($hash && isset($_SESSION['__APP__CART__'])) {
            foreach ($_SESSION['__APP__CART__'] as $k => $v) {
                if ($_SESSION['__APP__CART__'][$k]->item_hash == $hash) {
                    unset($_SESSION['__APP__CART__'][$k]);
                    // Reindexar o array
                    $_SESSION['__APP__CART__'] = array_values($_SESSION['__APP__CART__']);
                    echo 'OK';
                    return;
                }
            }
        }
        echo 'ERROR';
    }

    static public function clear()
    {
        if (isset($_SESSION['__APP__CART__'])) {
            unset($_SESSION['__APP__CART__']);
        }
        if (isset($_SESSION['__CUPOM__'])) {
            unset($_SESSION['__CUPOM__']);
        }
        if (isset($_SESSION['__LOCAL__'])) {
            unset($_SESSION['__LOCAL__']);
        }
        if (isset($_SESSION['__OBS__'])) {
            unset($_SESSION['__OBS__']);
        }
    }

    static public function get_total()
    {
        if (isset($_SESSION['__APP__CART__'])) {
            $total = 0;
            foreach ($_SESSION['__APP__CART__'] as $k) {
                $total += (floatval($k->item_preco) + floatval($k->extra_preco)) * intval($k->qtde);
            }
            if (isset($_SESSION['__CUPOM__']) && !empty($_SESSION['__CUPOM__'])) {
                if ($_SESSION['__CUPOM__']->cupom_tipo == 1) {
                    $total = $total - floatval($_SESSION['__CUPOM__']->cupom_valor);
                } else {
                    $desconto = (($total * intval($_SESSION['__CUPOM__']->cupom_percent)) / 100);
                    $total = $total - $desconto;
                }
            }
            return $total;
        }
    }

    static public function __show()
    {
        if (isset($_SESSION['__APP__CART__'])) {
            Filter::pre($_SESSION['__APP__CART__']);
        }
    }

    /**
     * Retorna o contador de itens do carrinho para o badge JS
     */
    public function getCountJs()
    {
        $carrinho = session('__APP__CART__', []);
        if (!empty($carrinho)) {
            echo '<span class="badge">' . count($carrinho) . '</span>';
        } else {
            echo '';
        }
    }

    /**
     * Retorna o contador de itens do carrinho para o ícone de sacola
     */
    public function getCountBag()
    {
        $carrinho = session('__APP__CART__', []);
        if (!empty($carrinho)) {
            echo '<span class="badge">' . count($carrinho) . '</span>';
        } else {
            echo '';
        }
    }

    public function reload()
    {
        $carrinho = session('__APP__CART__', []);

        return view('site.carrinho.side-carrinho-partial', [
            'carrinho' => $carrinho
        ]);
    }

    static public function minimo()
    {
        $total = self::get_total();
        $minimo = $this->configRepository->get_valor_min();
        $diff = Filter::moeda($total - $minimo, 'USD');
        $flag = (($total - $minimo) >= 0) ? 'true' : 'false';
        $json = ['total' => $total, 'minimo' => $minimo, 'diff' => $diff, 'flag' => $flag];
        echo json_encode($json);
    }

    /**
     * Remove todos os itens de uma categoria específica do carrinho
     * Usado para categorias de sabor único, onde ao adicionar um novo sabor,
     * o anterior da mesma categoria deve ser removido
     */
    static public function remove_by_category()
    {
        $categoria_id = Req::post('categoria_id');
        $removed_count = 0;

        if (isset($_SESSION['__APP__CART__']) && $categoria_id > 0) {
            foreach ($_SESSION['__APP__CART__'] as $k => $v) {
                if ($_SESSION['__APP__CART__'][$k]->categoria_id == $categoria_id) {
                    unset($_SESSION['__APP__CART__'][$k]);
                    $removed_count++;
                }
            }
            // Reindexar o array após remoção
            $_SESSION['__APP__CART__'] = array_values($_SESSION['__APP__CART__']);
        }

        echo $removed_count;
    }

    /**
     * Retorna os dados do carrinho em formato JSON
     * Usado pela interface PDV para obter o estado atual do carrinho
     */
    static public function get_json()
    {
        // CRÍTICO: Suprimir QUALQUER output antes do JSON
        @ini_set('display_errors', '0');
        error_reporting(0);

        // Limpar TODOS os buffers existentes
        while (ob_get_level()) {
            ob_end_clean();
        }
        ob_start();

        // Definir header IMEDIATAMENTE
        header('Content-Type: application/json; charset=utf-8');

        try {
            $itens = [];
            $total = 0;

            if (isset($_SESSION['__APP__CART__']) && !empty($_SESSION['__APP__CART__'])) {
                foreach ($_SESSION['__APP__CART__'] as $item) {
                    $itens[] = [
                        'item_id' => $item->item_id ?? '',
                        'item_nome' => $item->item_nome ?? '',
                        'item_hash' => $item->item_hash ?? '',
                        'categoria_id' => $item->categoria_id ?? '',
                        'categoria_nome' => $item->categoria_nome ?? '',
                        'item_preco' => floatval($item->item_preco ?? 0),
                        'extra' => $item->extra ?? '',
                        'extra_preco' => floatval($item->extra_preco ?? 0),
                        'qtde' => intval($item->qtde ?? 1),
                        'total' => floatval($item->item_preco ?? 0) + floatval($item->extra_preco ?? 0)
                    ];
                    $total += (floatval($item->item_preco ?? 0) + floatval($item->extra_preco ?? 0)) * intval($item->qtde ?? 1);
                }
            }

            echo json_encode([
                'success' => true,
                'itens' => $itens,
                'total' => $total,
                'count' => count($itens)
            ]);
            exit;

        } catch (Exception $e) {
            error_log("[CARRINHO] Exceção em get_json: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'error' => 'Erro ao carregar carrinho'
            ]);
            exit;
        }
    }

    /**
     * Aplicar pontos de fidelidade no carrinho
     */
    public function aplicar_pontos()
    {
        header('Content-Type: application/json');

        try {
            // Verificar se cliente está logado
            if (!isset($_SESSION['__CLIENTE__ID__'])) {
                echo json_encode(['success' => false, 'message' => 'Você precisa estar logado']);
                exit;
            }

            $pontos = (int)($_POST['pontos'] ?? 0);

            if ($pontos <= 0) {
                echo json_encode(['success' => false, 'message' => 'Quantidade de pontos inválida']);
                exit;
            }

            // Buscar configurações
            $config = (new configModel)->get_config();
            $pontos_minimo = (int)$config->config_pontos_para_resgatar;
            $valor_resgate = (float)$config->config_valor_resgate_pontos;
            $max_desconto = (float)$config->config_fidelidade_max_desconto;
            $tipo_programa = $config->config_fidelidade_tipo; // 'pontos', 'cashback', 'ambos'

            // Validar mínimo
            if ($pontos < $pontos_minimo) {
                echo json_encode(['success' => false, 'message' => "Mínimo de {$pontos_minimo} pontos"]);
                exit;
            }

            // Validar se cliente tem pontos suficientes
            $fidelidadeModel = new fidelidadeModel();
            $saldo_data = $fidelidadeModel->get_saldo_cliente($_SESSION['__CLIENTE__ID__']);
            $pontos_disponiveis = (int)$saldo_data['saldo_atual'];

            if ($pontos > $pontos_disponiveis) {
                echo json_encode(['success' => false, 'message' => 'Pontos insuficientes']);
                exit;
            }

            // Calcular desconto
            $desconto = ($pontos / $pontos_minimo) * $valor_resgate;

            // Validar desconto máximo APENAS para "Pontos + Cashback"
            if ($tipo_programa === 'ambos' && $max_desconto > 0 && $desconto > $max_desconto) {
                $max_pontos = (int)(($max_desconto / $valor_resgate) * $pontos_minimo);
                echo json_encode([
                    'success' => false,
                    'message' => "Desconto máximo de R$ " . number_format($max_desconto, 2, ',', '.') . " por pedido! Use no máximo {$max_pontos} pontos."
                ]);
                exit;
            }

            // Salvar na sessão
            $_SESSION['__PONTOS_USADOS__'] = $pontos;
            $_SESSION['__DESCONTO_PONTOS__'] = $desconto;

            echo json_encode([
                'success' => true,
                'message' => 'Pontos aplicados com sucesso!',
                'pontos' => $pontos,
                'desconto' => $desconto
            ]);

        } catch (Exception $e) {
            error_log('[FIDELIDADE] Erro ao aplicar pontos: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erro ao aplicar pontos']);
        }

        exit;
    }

    /**
     * Marca que o usuário dispensou a sugestão de bebidas
     */
    public function dispensar_bebidas()
    {
        $_SESSION['__BEBIDA_DISPENSADA__'] = true;
        echo json_encode(['success' => true]);
        exit;
    }

    /**
     * Remover pontos de fidelidade do carrinho
     */
    public function remover_pontos()
    {
        header('Content-Type: application/json');

        try {
            unset($_SESSION['__PONTOS_USADOS__']);
            unset($_SESSION['__DESCONTO_PONTOS__']);

            echo json_encode([
                'success' => true,
                'message' => 'Pontos removidos com sucesso!'
            ]);

        } catch (Exception $e) {
            error_log('[FIDELIDADE] Erro ao remover pontos: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erro ao remover pontos']);
        }

        exit;
    }
}
