$('.btn-endereco-remove').on('click', function() {
    var endereco_id = $('#endereco_id').val()
    $('#modal-endereco-remove').modal('show');
    $('.btn-confirma-remove').on('click', function() {
        var url = $('#form-remove').attr('action');
        $.post(url, { endereco_id: endereco_id }, function(rs) {
            window.location = baseUri + '/meus-enderecos/?success';
        });
        return false;
    });
});

$("[data-mask='cep']").mask("99999-999");
$('#endereco_cep').keyup(function() {
    var cep = $(this).val();
    var ori_cep = cep;
    cep = cep.replace(/_/g, '');
    if (cep.length >= 9) {
        var url = 'https://viacep.com.br/ws/' + cep + '/json/';
        $.getJSON(url, function(rs) {
            if (rs) {
                $('#endereco_bairro').val(rs.bairro);
                get_bairro_by_name(rs.bairro);
                if (rs.logradouro != "") {
                    $('#endereco_endereco').val(rs.logradouro);
                    $('#endereco_numero').focus();
                } else {
                    $('#endereco_endereco').focus();
                }
                $('#endereco_cep').val(ori_cep);
                $('#endereco_bairro').trigger('change');
            }
        });
    }
});

function get_bairro_by_name(bairro) {
    var url = baseUri + '/local/get_bairro_by_name/';
    $.post(url, { bairro: bairro }, function(rs) {
        if (rs == '-1') {
            $("#modal-faixa-cep").modal('show');
            $('.btn-endereco-gravar').attr('disabled', 'disabled');
            $('#endereco_cep').val('');
        } else {
            $('.btn-endereco-gravar').removeAttr('disabled');
        }
    });
}
//
// $('#endereco_cep').change(function () {
//     var cep = $(this).val();
//     if (cep.length >= 9) {
//         var url = baseUri + '/local/get_bairro_by_name/';
//         $.post(url, {cep: cep}, function (rs) {
//             if (rs == '-1') {
//                 $("#modal-faixa-cep").modal('show');
//                 $('.btn-endereco-gravar').attr('disabled', 'disabled');
//             } else {
//                 $('.btn-endereco-gravar').removeAttr('disabled');
//             }
//         });
//     }
// });

$('#endereco_bairro').change(function() {
    var cidade = $('#endereco_bairro option:selected').data('cidade');
    var bairro = $('#endereco_bairro option:selected').data('bairro');
    $('#endereco_cidade').val(cidade);
    $('#endereco_bairro_id').val(bairro);
    $
});