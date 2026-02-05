$(function () {

    $("[data-mask='phone']").mask("(99) 9999-9999?9");
    $("[data-mask='cpf']").mask("999.999.999-99");
    $("[data-mask='cep']").mask("99999-999");
    $("[data-mask='cnpj']").mask("99.999.999/9999-99");
    $('#opcao_preco').mask("#.##0,00", {reverse: true});
    $('#opcao_cep').keyup(function () {
        var cep = $(this).val();
        cep = cep.replace(/_/g, '');
        if (cep.length >= 9) {
            var url = 'http://cep.republicavirtual.com.br/web_cep.php?cep=' + cep + '&formato=json';
            $.getJSON(url, {}, function (rs) {
                if (rs.resultado == 1) {
                    new dgCidadesEstados({
                        cidade: document.getElementById('opcao_cidade'),
                        estado: document.getElementById('opcao_uf'),
                        estadoVal: rs.uf,
                        cidadeVal: rs.cidade
                    });
                    $('#opcao_bairro').val(rs.bairro);
                    $('#opcao_endereco').val(rs.tipo_logradouro + ' ' + rs.logradouro);
                    $('#opcao_numero').focus();
                }
            });
        }
    });
    $('.btn-remover').on('click', function () {
        var id = $(this).data('id');
        $('#modal-remove').modal('show');
        $('.btn-confirma-remove').on('click', function () {
            var url = $('#form-remove').attr('action');
            $.post(url, {opcao_id: id}, function (rs) {
                $('#modal-remove').modal('hide');
                $('#tr-' + id).fadeOut();
                $.gritter.add({
                    title: 'Procedimento Realizado',
                    text: 'Registro removido com sucesso!',
                    class_name: 'success',
                    before_open: function () {
                        if ($('.gritter-opcao-wrapper').length == 1) {
                            // prevents new gritter 
                            return false;
                        }
                    }
                });
            });
            return false;
        });
    });
});



