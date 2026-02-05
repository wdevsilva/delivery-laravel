$(function() {
    $('.select2').select2({
        "language": "pt-BR",
        width: '100%',
        //minimumInputLength: 3,
        placeholder: "O que deseja pedir?",
    });
    if (!isMobile) {
        var containerW = $('#home-content').width();
        $('#form-busca').css('width', containerW + 'px');
    } else {
        $('#form-busca').css('width', '100%');
    }
    // $('.busca_live').select2({
    //     "language": "pt-BR",
    //     width: (isMobile == 'true') ? '100%' : '100%',
    //     minimumInputLength: 3,
    //     placeholder: "O que deseja pedir?",
    //     ajax: {
    //         url: baseUri+'/index/search/',
    //         dataType: 'json',
    //         data: function (params) {
    //             var query = {
    //                 busca: params.term,
    //                 type: 'public'
    //             }
    //             return query;
    //         },
    //         processResults: function (data) {
    //             return {
    //                 results: data.itens
    //             };
    //         },
    //     }
    // });

    $('.btns-buy button').tooltip();
    $('#busca').on('change', function() {
        var desc = $('#busca option:selected').data('desc');
        var obs = $('#busca option:selected').data('obs');
        var cod = $('#busca option:selected').data('cod');
        var item = $('#busca option:selected').val();
        var term = item;
        if (desc != "") {
            term += '|#|' + desc;
        }
        if (cod != "") {
            term += '|#|' + cod;
        }
        if (obs != "") {
            term += '|#|' + obs;
        }
        $('#ipt-busca').val(term);
        $('#ipt-nome').val(item);
        $('#ipt-desc').val(desc);
        $('#ipt-cod').val(cod);
        $('#ipt-obs').val(obs);
        if ($('#busca').val() != "") {
            $('#form-busca').submit();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    $('.sel-option').on('change', function() {
        var item_id = $(this).data('id');
        var item_preco = $(this).data('preco');
        if ($('#sel-' + item_id)) {
            var opc_preco = 0;
            var element = $('#sel-' + item_id + ' option:selected');
            const values = Array.from(element).map(el => el);
            values.forEach(function(v) {
                opc_preco = opc_preco + parseFloat($(v).data('preco'));
            });
        }
        if (opc_preco > 0) {
            var item_opc_preco = number_format(parseFloat(item_preco) + parseFloat(opc_preco), 2, ',', '.');
        } else {
            var item_opc_preco = number_format(parseFloat(item_preco), 2, ',', '.');
        }
        $('#sp-' + item_id + ' b').html('R$ ' + item_opc_preco);
    });
    $('#btn-busca-clear').on('click', function() {
        $('#busca').val('');
        window.location = baseUri;
    });
});


function __alert__(title, text, color) {
    $.gritter.add({
        title: title,
        text: text,
        class_name: color,
        before_open: function() {
            if ($('.gritter-item-wrapper').length == 1) {
                // prevents new gritter
                return false;
            }
        }
    });
}

function __alert__success() {
    $.gritter.add({
        title: 'Procedimento Realizado',
        text: 'Registro atualizado com sucesso!',
        class_name: 'success',
        before_open: function() {
            if ($('.gritter-item-wrapper').length == 1) {
                return false;
            }
        }
    });
}

function __alert__error(msg) {
    $.gritter.add({
        title: 'Atenção',
        text: msg,
        class_name: 'danger',
        before_open: function() {
            if ($('.gritter-item-wrapper').length == 1) {
                return false;
            }
        }
    });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function scroll_to(to) {
    $('html, body').animate({
        scrollTop: $('#' + to).offset().top - 60
    }, 1300);
}

$('.scroll-to-up').on('click', function() {
    scroll_to('topo');
});