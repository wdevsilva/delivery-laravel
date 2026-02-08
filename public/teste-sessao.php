<?php
@session_start();

// Teste 1: Adicionar item
if (isset($_GET['add'])) {
    if (!isset($_SESSION['__APP__CART__'])) {
        $_SESSION['__APP__CART__'] = [];
    }

    $item = new stdClass();
    $item->item_id = 18;
    $item->item_nome = 'Coca-cola lata 350 ml';
    $item->item_preco = 6;
    $item->qtde = 1;
    $item->item_hash = uniqid(time());

    $_SESSION['__APP__CART__'][] = $item;

    echo json_encode([
        'success' => true,
        'message' => 'Item adicionado',
        'session_id' => session_id(),
        'total_itens' => count($_SESSION['__APP__CART__'])
    ]);
    exit;
}

// Teste 2: Listar itens
if (isset($_GET['list'])) {
    $carrinho = $_SESSION['__APP__CART__'] ?? [];

    echo json_encode([
        'session_id' => session_id(),
        'total_itens' => count($carrinho),
        'itens' => $carrinho
    ]);
    exit;
}

// Teste 3: Limpar carrinho
if (isset($_GET['clear'])) {
    $_SESSION['__APP__CART__'] = [];

    echo json_encode([
        'success' => true,
        'message' => 'Carrinho limpo',
        'session_id' => session_id()
    ]);
    exit;
}

// Interface HTML
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teste de Sessão</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        button { padding: 10px 20px; margin: 5px; cursor: pointer; }
        #result { margin-top: 20px; padding: 15px; background: #f0f0f0; border-radius: 5px; }
        pre { background: #fff; padding: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h1>Teste de Sessão PHP</h1>

    <button onclick="addItem()">Adicionar Item</button>
    <button onclick="listItems()">Listar Itens</button>
    <button onclick="clearCart()">Limpar Carrinho</button>

    <div id="result"></div>

    <script>
        function addItem() {
            fetch('/teste-sessao.php?add=1')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('result').innerHTML =
                        '<h3>Item Adicionado</h3>' +
                        '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                });
        }

        function listItems() {
            fetch('/teste-sessao.php?list=1')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('result').innerHTML =
                        '<h3>Itens no Carrinho</h3>' +
                        '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                });
        }

        function clearCart() {
            fetch('/teste-sessao.php?clear=1')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('result').innerHTML =
                        '<h3>Carrinho Limpo</h3>' +
                        '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                });
        }
    </script>
</body>
</html>
