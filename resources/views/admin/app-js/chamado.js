$(function () {
    $("[data-mask='phone']").mask("(99) 9999-9999?9");
    $("[data-mask='cpf']").mask("999.999.999-99");
    $("[data-mask='cep']").mask("99999-999");

    $('#chamado_cep').keyup(function () {
        var cep = $(this).val();
        cep = cep.replace(/_/g, '');
        if (cep.length >= 9) {
            var url = 'http://cep.republicavirtual.com.br/web_cep.php?cep=' + cep + '&formato=json';
            $.getJSON(url, {}, function (rs) {
                if (rs.resultado == 1) {
                    new dgCidadesEstados({
                        cidade: document.getElementById('chamado_cidade'),
                        estado: document.getElementById('chamado_uf'),
                        estadoVal: rs.uf,
                        cidadeVal: rs.cidade
                    });
                    $('#chamado_bairro').val(rs.bairro);
                    $('#chamado_endereco').val(rs.tipo_logradouro + ' ' + rs.logradouro);
                    $('#chamado_numero').focus();
                }
            });
        }
    });
    $('.btn-remover').on('click', function () {
        var id = $(this).data('id');
        $('#modal-remove').modal('show');
        $('.btn-confirma-remove').on('click', function () {
            var url = $('#form-remove').attr('action');
            $.post(url, {chamado_id: id}, function (rs) {
                $('#modal-remove').modal('hide');
                $('#tr-' + id).fadeOut();
                $.gritter.add({
                    title: 'Procedimento Realizado',
                    text: 'Registro removido com sucesso!',
                    class_name: 'success',
                    before_open: function () {
                        if ($('.gritter-item-wrapper').length == 1) {
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



