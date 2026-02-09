/**
 * Modal Produto - JavaScript de Interação
 * Script reutilizável para os modais de produto
 */

// Gerenciamento de itens selecionados (GLOBAL para acesso do carrinho.js)
window.selectedItemsByModal = window.selectedItemsByModal || {};
var selectedItems = {};

// Adiciona classe 'selected' aos cards de opções quando selecionados
$(document).on('change', '.opcao-card input[type="checkbox"], .opcao-card input[type="radio"]', function() {
    var $card = $(this).closest('.opcao-card');
    var $input = $(this);

    if ($input.is(':checked')) {
        $card.addClass('selected');
        // Feedback visual ao selecionar
        $card.css('animation', 'pulse-select 0.3s ease');
        setTimeout(function() {
            $card.css('animation', '');
        }, 300);

        // Adiciona animação de voo para barra superior
        var itemId = $input.data('item');
        var grupoId = $input.data('grupo');
        var opcaoId = $input.data('id');
        var itemKey = 'opt-' + grupoId + '-' + opcaoId;
        var itemName = $input.data('nome');
        var itemPrice = parseFloat($input.data('preco_real')) || 0;

        // Para radio, remove seleção anterior do mesmo grupo da barra
        if ($input.attr('type') === 'radio') {
            var name = $input.attr('name');
            $('input[name="' + name + '"]').not($input).each(function() {
                var oldKey = 'opt-' + $(this).data('grupo') + '-' + $(this).data('id');
                delete selectedItems[oldKey];
            });
        }

        flyItemToBar($card[0], itemId, itemKey, itemName, itemPrice);

        // Verifica se deve rolar para próxima seção
        var limite = parseInt($input.data('limite')) || 0;
        var isRadio = $input.attr('type') === 'radio';
        var grupoClass = '.grupo-' + grupoId + ' input:checked';
        var selectedCount = $(grupoClass).length;

        // Pega o nome da seção para verificar se é BORDA
        var $currentSection = $card.closest('.opcoes-section');
        var $titleElement = $currentSection.find('.opcoes-section-title span').first();
        var sectionTitle = $titleElement.length ? $titleElement.text().trim().toUpperCase() : '';
        var isBordaSection = sectionTitle.includes('BORDA');

        var shouldScroll = false;

        if (isBordaSection && isRadio) {
            shouldScroll = true;
        } else if (isRadio) {
            shouldScroll = true;
        } else if (limite > 0 && limite < 100 && selectedCount >= limite) {
            shouldScroll = true;
        }

        if (shouldScroll) {
            setTimeout(function() {
                scrollToNextSection($currentSection, true);
            }, 400);
        }
    } else {
        $card.removeClass('selected');

        // Remove da barra ao desmarcar
        var grupoId = $input.data('grupo');
        var opcaoId = $input.data('id');
        var itemKey = 'opt-' + grupoId + '-' + opcaoId;
        var itemId = $input.data('item');
        removeItemFromBar(itemKey, itemId);
    }

    // Para radios, remove selected de outros cards do mesmo grupo
    if ($(this).attr('type') === 'radio') {
        var name = $(this).attr('name');
        $('.opcao-card').has('input[name="' + name + '"]').not($card).removeClass('selected');
    }
});

// Adiciona feedback visual aos sabores
$(document).on('change', '.lista-sabores input[type="checkbox"]', function() {
    var $label = $(this).closest('label');
    var itemId = $(this).data('item-id');
    var maxSabores = parseInt($('#sabores-' + itemId).val()) || 1;
    var $container = $('.lista-sab-' + itemId);
    var $thisCheckbox = $(this);
    var isChecked = $thisCheckbox.is(':checked');

    // NOVO: Para sabor único (meia = 1), desmarca outros sabores antes de selecionar um novo
    if (isChecked && maxSabores === 1) {
        var $modal = $('#item-' + itemId);
        
        // Encontra e desmarca qualquer outro sabor selecionado
        var $outrosSabores = $modal.find('.sabores[data-item-id="' + itemId + '"]:checked').not($thisCheckbox);
        
        $outrosSabores.each(function() {
            var $otherCheckbox = $(this);
            var $otherLabel = $otherCheckbox.closest('label');
            var otherSaborId = $otherCheckbox.data('id');
            var otherSaborNome = $otherCheckbox.data('nome');
            var otherItemKey = 'sab-' + otherSaborId;
            
            // Remove visualmente
            $otherCheckbox.prop('checked', false);
            $otherLabel.removeClass('selected');
            
            // Remove da sacola
            removeItemFromBar(otherItemKey, itemId);
        });
        
        // Remove o produto principal anterior
        if (selectedItems['produto-principal']) {
            delete selectedItems['produto-principal'];
        }
        
        // Remove TODOS os adicionais anteriores
        $modal.find('.opcao-card input:checked').each(function() {
            var $opcInput = $(this);
            var grupoId = $opcInput.data('grupo');
            var opcaoId = $opcInput.data('id');
            var opcKey = 'opt-' + grupoId + '-' + opcaoId;
            
            // Remove da sacola
            delete selectedItems[opcKey];
            
            // Desmarca visualmente
            $opcInput.prop('checked', false);
            $opcInput.closest('.opcao-card').removeClass('selected');
        });
    }
    
    var selectedCount = $('.sabores[data-item-id="' + itemId + '"]:checked').length;

    if (isChecked) {
        $label.addClass('selected');
        $label.css('animation', 'pulse-select 0.3s ease');
        setTimeout(function() {
            $label.css('animation', '');
        }, 300);

        // ATUALIZA O HEADER com o sabor ATUAL selecionado
        var saborNome = $thisCheckbox.data('nome');
        var saborPreco = parseFloat($thisCheckbox.data('preco')) || 0;
        var $header = $('#produto-info-' + itemId);

        // Atualiza nome e preço
        $header.find('.produto-nome').text(saborNome);
        $header.find('.produto-preco').text('R$ ' + saborPreco.toFixed(2).replace('.', ','));
        $header.fadeIn(300);
        
        // CORRIGIDO: Adiciona o produto principal à sacola quando seleciona um sabor (meia = 1)
        if (maxSabores === 1) {
            // Remove produto anterior se houver
            if (selectedItems['produto-principal']) {
                delete selectedItems['produto-principal'];
            }
            
            // Adiciona novo produto com preço
            selectedItems['produto-principal'] = {
                name: saborNome,
                price: saborPreco,
                element: null,
                isPrincipal: true
            };
            updateSelectedItemsBar(itemId);
        }

        // Se atingiu o limite, DESMARCA e esconde os sabores não selecionados
        if (selectedCount >= maxSabores) {
            $container.parent().find('.lista-sabores input:not(:checked)').each(function() {
                // DESMARCA o checkbox antes de esconder
                $(this).prop('checked', false).removeAttr('checked');
                $(this).closest('.lista-sabores').slideUp(300);
            });
        }
    } else {
        $label.removeClass('selected');
        
        // NOVO: Ao desmarcar, remove o sabor da sacola
        var saborId = $thisCheckbox.data('id');
        var itemKey = 'sab-' + saborId;
        removeItemFromBar(itemKey, itemId);
        
        // NOVO: Remove o produto principal da sacola (se existir)
        if (selectedItems['produto-principal']) {
            delete selectedItems['produto-principal'];
        }
        
        // NOVO: Remove TODOS os adicionais quando desmarca o sabor
        var $modal = $('#item-' + itemId);
        $modal.find('.opcao-card input:checked').each(function() {
            var $opcInput = $(this);
            var grupoId = $opcInput.data('grupo');
            var opcaoId = $opcInput.data('id');
            var opcKey = 'opt-' + grupoId + '-' + opcaoId;
            
            // Remove da sacola
            delete selectedItems[opcKey];
            
            // Desmarca visualmente
            $opcInput.prop('checked', false);
            $opcInput.closest('.opcao-card').removeClass('selected');
        });
        
        // Atualiza a sacola
        updateSelectedItemsBar(itemId);

        // Se desmarcou TODOS os sabores, esconde o header
        if (selectedCount === 0) {
            $('#produto-info-' + itemId).fadeOut(300);
        }

        // Se desmarcou e estava no limite, mostra todos novamente
        if (selectedCount < maxSabores) {
            $container.parent().find('.lista-sabores').slideDown(300);
        }
    }

    // Se atingiu o limite, aguarda a animação de esconder e rola para próxima seção
    if (selectedCount >= maxSabores) {
        setTimeout(function() {
            var $currentSection = $label.closest('.opcoes-section');
            scrollToNextSection($currentSection, true); // Sabores sempre rolam quando atingem limite
        }, 400); // Aguarda slideUp completar
    }
});

// Inicializa cards já selecionados
$('.opcao-card input:checked').each(function() {
    $(this).closest('.opcao-card').addClass('selected');
});

// Inicializa sabores já selecionados
$('.lista-sabores input:checked').each(function() {
    $(this).closest('label').addClass('selected');
});

// Pré-seleciona sabor quando modal é aberto
$('.modal-itens').on('show.bs.modal', function(e) {
    var $modal = $(this);
    var $trigger = $(e.relatedTarget);
    var saborId = $trigger.data('sabor-id');

    // LIMPEZA COMPLETA ao abrir o modal
    $modal.find('.sabores').prop('checked', false).removeAttr('checked');
    $modal.find('.lista-sabores label').removeClass('selected');
    $modal.find('.lista-sabores').show().css('display', '');
    
    // SÓ esconde o header se ele tiver ID (pizzas com múltiplos sabores)
    var $header = $modal.find('.produto-info-header');
    if ($header.attr('id')) {
        $header.hide();
    }
    
    // Adiciona o produto principal à sacola flutuante automaticamente
    // EXCETO para categorias com múltiplos sabores (meia > 1)
    var itemId = $modal.attr('id').replace('item-', '');
    var $saboresInput = $modal.find('#sabores-' + itemId);
    var numSabores = $saboresInput.length ? parseInt($saboresInput.val()) : 0;
    
    var produtoNome = $header.find('.produto-nome').text();
    var produtoPrecoText = $header.find('.produto-preco').text().replace('R$ ', '').replace(',', '.');
    var produtoPreco = parseFloat(produtoPrecoText) || 0;
    
    // Reseta itens selecionados
    selectedItems = {};
    
    // REMOVIDO: Não adiciona produto principal ao abrir modal
    // O produto será adicionado quando o usuário selecionar um sabor (evento 'change')
    
    updateSelectedItemsBar(itemId);

    if (saborId) {
        $modal.data('pre-selected-flavor', saborId);

        var $checkbox = $modal.find('.sabores[value="' + saborId + '"]');

        if ($checkbox.length > 0) {
            setTimeout(function() {
                $checkbox.prop('checked', true).trigger('change');

                var itemId = $checkbox.data('item-id');
                $('#produto-info-' + itemId).fadeIn(300);
            }, 100);
        }
    }
});

function scrollToNextSection(currentSection, shouldScroll) {
    if (!shouldScroll) {
        return;
    }

    var $modalBody = $('.modal-itens:visible .modal-body');
    var sections = $modalBody.find('.opcoes-section');
    var currentIndex = sections.index(currentSection);

    if (currentIndex >= 0 && currentIndex < sections.length - 1) {
        var $nextSection = sections.eq(currentIndex + 1);
        var modalBodyScrollTop = $modalBody.scrollTop();
        var nextSectionOffsetTop = $nextSection[0].offsetTop;

        $modalBody.animate({
            scrollTop: nextSectionOffsetTop - 20
        }, 600, 'swing');
    }
}

function updateSelectedItemsBar(itemId) {
    var count = Object.keys(selectedItems).length;
    var $badge = $('#floating-cart-' + itemId);
    var $counter = $('#cart-count-' + itemId);
    var $popupBody = $('#popup-body-' + itemId);
    var $popupTotal = $('#popup-total-' + itemId);
    
    // Sempre mostra a sacola se houver pelo menos o produto principal
    if (count === 0) {
        $badge.removeClass('show');
        $('#popup-' + itemId).removeClass('show');
    } else {
        $badge.addClass('show');
        $counter.text(count);

        $popupBody.empty();
        var totalGeral = 0;

        $.each(selectedItems, function(key, item) {
            var price = parseFloat(item.price) || 0;
            var isPrincipal = item.isPrincipal || false;
            
            // Soma TUDO no total (produto + extras)
            totalGeral += price;

            var priceText = '';
            if (isPrincipal) {
                priceText = 'R$ ' + price.toFixed(2).replace('.', ','); // Mostra preço do produto
            } else {
                priceText = price > 0 ? '+ R$ ' + price.toFixed(2).replace('.', ',') : 'Grátis';
            }

            var row = $('<div class="selected-item-row' + (isPrincipal ? ' produto-principal' : '') + '">' +
                '<span class="item-name">' + item.name + '</span>' +
                '<span class="item-price">' + priceText + '</span>' +
                (isPrincipal ? '' : '<button class="remove-btn" data-key="' + key + '" data-item-id="' + itemId + '">×</button>') +
                '</div>');

            $popupBody.append(row);
        });
       
        $popupTotal.text('R$ ' + totalGeral.toFixed(2).replace('.', ','));
    }
}

// Evento de clique no badge
$(document).on('click', '.floating-cart-badge', function(e) {
    e.stopPropagation();
    var itemId = $(this).attr('id').replace('floating-cart-', '');
    var $popup = $('#popup-' + itemId);
    $popup.toggleClass('show');
});

// Fecha o popup ao clicar fora
$(document).on('click', function(e) {
    if (!$(e.target).closest('.floating-cart-badge').length &&
        !$(e.target).closest('.selected-items-popup').length) {
        $('.selected-items-popup').removeClass('show');
    }
});

// Impede que cliques dentro do popup o fechem
$(document).on('click', '.selected-items-popup', function(e) {
    e.stopPropagation();
});

// Remove item do popup
$(document).on('click', '.remove-btn', function(e) {
    e.stopPropagation();
    var key = $(this).data('key');
    var itemId = $(this).data('item-id');
    removeItemFromBar(key, itemId);
});

function flyItemToBar(element, itemId, itemKey, itemName, itemPrice) {
    var $original = $(element);
    var $clone = $original.clone();

    var offset = $original.offset();
    var targetBar = $('#selected-items-bar-' + itemId);
    var targetOffset = targetBar.length ? targetBar.offset() : {
        top: 60,
        left: window.innerWidth / 2
    };

    $clone.addClass('flying-item');
    $clone.css({
        'position': 'fixed',
        'top': offset.top + 'px',
        'left': offset.left + 'px',
        'width': $original.outerWidth() + 'px',
        'height': $original.outerHeight() + 'px',
        'z-index': '10001'
    });

    $('body').append($clone);

    setTimeout(function() {
        $clone.css({
            'top': targetOffset.top + 'px',
            'left': targetOffset.left + 'px',
            'opacity': '0',
            'transform': 'scale(0.3)'
        });

        setTimeout(function() {
            $clone.remove();

            selectedItems[itemKey] = {
                name: itemName,
                price: itemPrice,
                element: element
            };

            updateSelectedItemsBar(itemId);
        }, 600);
    }, 50);
}

function removeItemFromBar(itemKey, itemId) {
    if (selectedItems[itemKey]) {
        var item = selectedItems[itemKey];
        var $element = $(item.element);

        delete selectedItems[itemKey];

        var $input = $element.find('input');
        if ($input.length) {
            $input.prop('checked', false);

            $element.removeClass('selected');
            if ($element.is('label')) {
                $element.removeClass('selected');
            } else {
                $element.closest('.opcao-card').removeClass('selected');
            }

            if ($input.hasClass('sabores')) {
                var itemModalId = $input.data('item-id');
                var $modal = $('#item-' + itemModalId);

                if ($modal.length) {
                    var $allFlavors = $modal.find('.lista-sabores');

                    $allFlavors.each(function() {
                        var $flavor = $(this);
                        var isHidden = $flavor.is(':hidden');

                        if (isHidden) {
                            $flavor.slideDown(300);
                        } else {
                            $flavor.css('display', 'block').show();
                        }
                    });

                    $modal.find('.modal-body').animate({
                        scrollTop: 0
                    }, 400, 'swing');
                }
            }
        }

        updateSelectedItemsBar(itemId);
    }
}

// Evento de clique no card inteiro
$(document).on('click', '.opcao-card', function(e) {
    if ($(e.target).is('input') || $(e.target).is('label')) {
        return;
    }

    var $card = $(this);
    var $input = $card.find('input');

    if ($input.length === 0) {
        return;
    }

    if ($input.attr('type') === 'radio') {
        if ($input.is(':checked')) {
            return;
        }

        e.preventDefault();
        e.stopPropagation();

        $input.prop('checked', true);
        $input.trigger('change');
        return;
    }

    e.preventDefault();
    e.stopPropagation();

    $input[0].click();
});

// Evento de clique nos sabores
$(document).on('click', '.lista-sabores label', function(e) {
    if ($(e.target).is('input')) {
        return;
    }

    e.preventDefault();
    e.stopPropagation();

    var $label = $(this);
    var $input = $label.find('input');

    if ($input.length === 0) {
        return;
    }

    var isChecked = $input.is(':checked');
    var itemId = $input.data('item-id');
    var maxSabores = parseInt($('#sabores-' + itemId).val()) || 1;
    var saborId = $input.data('id');
    var itemKey = 'sab-' + saborId;
    var itemName = $input.data('nome');
    var itemPrice = parseFloat($input.data('preco')) || 0;

    // PERMITE DESMARCAR quando meia = 1 (sabor único)
    if (isChecked && maxSabores === 1) {
        // Remove o sabor da sacola
        removeItemFromBar(itemKey, itemId);
        
        // NOVO: Remove o produto principal da sacola (se existir)
        if (selectedItems['produto-principal']) {
            delete selectedItems['produto-principal'];
        }
        
        // NOVO: Remove TODOS os adicionais selecionados da sacola
        var $modal = $('#item-' + itemId);
        $modal.find('.opcao-card input:checked').each(function() {
            var $opcInput = $(this);
            var grupoId = $opcInput.data('grupo');
            var opcaoId = $opcInput.data('id');
            var opcKey = 'opt-' + grupoId + '-' + opcaoId;
            
            // Remove da sacola
            delete selectedItems[opcKey];
            
            // Desmarca visualmente
            $opcInput.prop('checked', false);
            $opcInput.closest('.opcao-card').removeClass('selected');
        });
        
        // Atualiza a sacola
        updateSelectedItemsBar(itemId);
        
        // Desmarca o checkbox do sabor
        $input.click();
        return;
    }

    if (!isChecked) {
        var selectedCount = $('.sabores[data-item-id="' + itemId + '"]:checked').length;

        if (selectedCount < maxSabores) {
            // CORRIGIDO: Não chama flyItemToBar quando meia = 1
            // O produto principal já é adicionado no evento 'change'
            if (maxSabores > 1) {
                flyItemToBar($label[0], itemId, itemKey, itemName, 0);
            }
        }
    } else {
        removeItemFromBar(itemKey, itemId);
    }

    $input.click();
});

// Limpa itens selecionados ao fechar o modal
$('.modal-itens').on('hidden.bs.modal', function() {
    var $modal = $(this);
    var itemId = $modal.attr('id').replace('item-', '');

    selectedItems = {};
    updateSelectedItemsBar(itemId);

    $modal.find('.lista-sabores input[type="checkbox"]').prop('checked', false);
    $modal.find('.lista-sabores label').removeClass('selected');
    $modal.find('.lista-sabores').slideDown(300);

    $modal.find('.opcao-card input[type="checkbox"]').prop('checked', false);
    $modal.find('.opcao-card input[type="radio"]').prop('checked', false);
    $modal.find('.opcao-card').removeClass('selected');

    $modal.find('.modal-body').scrollTop(0);
});

// Auto-abre modal se vier do index com direct_modal=1
$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('direct_modal') === '1') {
        var firstModal = $('.modal-itens').first();
        if (firstModal.length) {
            firstModal.modal('show');
        }
    }
});
