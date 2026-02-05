$(function () {
    $("[data-mask='phone']").mask("(99) 9999-9999?9");
    $("[data-mask='cell']").mask("(99) 99999-9999");
    $("[data-mask='cpf']").mask("999.999.999-99");
    $("[data-mask='cep']").mask("99999-999");
    $("[data-mask='cnpj']").mask("99.999.999/9999-99");
    $("[data-mask='date']").mask("99/99/9999");

    // Destruir instância anterior se existir
    if ($.fn.DataTable.isDataTable('.datatable')) {
        $('.datatable').DataTable().destroy();
    }
    
    $(".datatable").DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: datatable_buttons,
        "displayLength": 10,
        "order": [[1, "asc"]],
        "oLanguage": lang
    });

    $('#cliente_cep').keyup(function () {
        var cep = $(this).val();
        cep = cep.replace(/_/g, '');
        if (cep.length >= 9) {
            var url = 'http://cep.republicavirtual.com.br/web_cep.php?cep=' + cep + '&formato=json';
            $.getJSON(url, {}, function (rs) {
                if (rs.resultado == 1) {
                    new dgCidadesEstados({
                        cidade: document.getElementById('cliente_cidade'),
                        estado: document.getElementById('cliente_uf'),
                        estadoVal: rs.uf,
                        cidadeVal: rs.cidade
                    });
                    $('#cliente_bairro').val(rs.bairro);
                    $('#cliente_endereco').val(rs.tipo_logradouro + ' ' + rs.logradouro);
                    $('#cliente_numero').focus();
                }
            });
        }
    });
    $('#tbl_cliente').on('click','.btn-remover', function () {
        var id = $(this).data('id');
        $('#modal-remove').modal('show');
        $('.btn-confirma-remove').on('click', function () {
            var url = $('#form-remove').attr('action');
            $.post(url, {cliente_id: id}, function (rs) {
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



