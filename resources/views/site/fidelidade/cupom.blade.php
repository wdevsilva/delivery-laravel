<?php

$cupom = $data['cupom'][0] ?? null;

if (!empty($cupom->status) && $cupom->status == 1) {

    $cupomModel = new cupomModel();
    $clienteId  = $_SESSION['__CLIENTE__ID__'] ?? null;

    // Verifica se cliente já utilizou
    $dadosCupom = $cupomModel->get_by_numero_cupom($cupom->cupom_id, $clienteId);
    if (!empty($dadosCupom)) {
        return; // já usou, não mostra
    }

    /**
     * Helper para checar validade do cupom
     */
    function isDateExpired($dateStart, $days = 1): bool
    {
        $timestampNow     = time();
        $timestampExpired = strtotime("+{$days} day", strtotime($dateStart));
        return $timestampExpired > $timestampNow;
    }

    // Define desconto como texto
    $desconto = $cupom->cupom_tipo == 1
        ? 'R$' . Currency::moeda($cupom->cupom_valor)
        : $cupom->cupom_percent . '%';

    // Verificações de quantidade e validade
    $expirado     = !isDateExpired($cupom->cupom_validade, 1);
    $semQuantidade = ($cupom->cupom_quantidade <= 0);
    $jaTemCupom   = !empty($_COOKIE['popupcupom']) && $_COOKIE['popupcupom'] == $cupom->cupom_id;
    $jaTemSessao  = !empty($_SESSION['__CUPOM__']);
    
    // ⚠️ NOVO: Verificar valor mínimo do pedido
    $valorCarrinho = 0;
    if (!empty($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $item) {
            $valorCarrinho += ($item->valor_item * $item->quantidade);
        }
    }
    $carrinhoInsuficiente = ($cupom->cupom_valor_minimo > 0 && $valorCarrinho < $cupom->cupom_valor_minimo);

    if (!$semQuantidade && !$expirado && !$jaTemCupom && !$jaTemSessao && !$carrinhoInsuficiente) { ?>
        <script type="text/javascript">
            x0p({
                title: 'Cupom# <?= $cupom->cupom_nome ?>',
                text: 'Parabéns! Você ganhou um desconto de <?= $desconto ?> \n deseja ativar o cupom?',
                animationType: 'slideUp',
                icon: 'custom',
                iconURL: '<?= $baseUri; ?>/assets/img/cupomsdesconto.png',
                buttons: [{
                        type: 'error',
                        key: 49,
                        text: 'Não Obrigado'
                    },
                    {
                        type: 'info',
                        key: 50,
                        text: 'Ativar Desconto'
                    }
                ]
            }).then(function(data) {
                const userId = '<?= $clienteId ?: 1 ?>';
                if (data.button === 'error') {
                    $.post('', {
                        user_id: userId,
                        idcupom: '<?= $cupom->cupom_id ?>'
                    });
                } else if (data.button === 'info') {
                    $.post('', {
                            codigodocupom: '<?= $cupom->cupom_nome ?>',
                            user_id: userId
                        })
                        .done(function(resp) {
                            const erros = {
                                erro0: 'Cupom inválido!',
                                erro1: 'Cupom vencido!',
                                erro2: 'Esse cupom expirou!',
                                erro3: 'Ocorreu um erro ao validar!',
                                erro4: 'Você já tem um desconto ativo!'
                            };
                            if (resp.startsWith('erro')) {
                                x0p('Opss...', erros[resp] || 'Erro desconhecido!', 'error', false);
                            } else {
                                x0p('Parabéns!', 'Desconto aplicado! 😍', 'ok', false);
                            }
                        });
                }
            });
        </script>
<?php }

    // ---- TRATAMENTO DO POST ----
    $idcupom = $_POST['idcupom']   ?? '';
    $userid  = $_POST['user_id']   ?? '';
    $getCupom = $_POST['codigodocupom'] ?? '';

    // Marca o cookie quando fecha popup
    if ($idcupom && $userid) {
        setcookie("popupcupom", $cupom->cupom_id, time() + (86400 * 7));
        return;
    }

    // Ativa o cupom
    if ($getCupom && $userid) {
        if ($cupom->cupom_quantidade <= 0) {
            echo "erro1";
            exit;
        }
        if (!isDateExpired($cupom->cupom_validade, 1)) {
            echo "erro2";
            exit;
        }
        if (!empty($_SESSION['desconto_cupom'])) {
            echo "erro4";
            exit;
        }

        // Cria cookie e session
        setcookie("popupcupom", $cupom->cupom_id, time() + (86400 * 7));
        echo "true";

        $dados = $cupomModel->get_by_nome($getCupom);
        if (!empty($dados->cupom_id) && empty($_SESSION['__CUPOM__'])) {
            $_SESSION['__CUPOM__'] = $dados;
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }
}
