$(function () {
    $("[data-mask='phone']").mask("(99) 9999-9999?9");
    $("[data-mask='cpf']").mask("999.999.999-99");
    //$("[data-mask='rg']").mask("99.999.999-99");
    $('#tecnico_nome').on('keyup', function () {
        var nome = $.trim($(this).val());
        var id = $.trim($('#tecnico_id').val());
        if (id === "" || id === 0) {
            nome = strip_accents(nome);
            nome.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
            nome_splited = nome.split(" ");
            login_sugest = "";
            for (i = 0; i <= nome_splited.length - 1; i++) {
                login_sugest += nome_splited[i] + '.';
            }
            $('#tecnico_login').val(login_sugest.substr(0, login_sugest.length - 1));
        }
    });
    $('.btn-remover').on('click', function () {
        var id = $(this).data('id');
        $('#modal-remove').modal('show');
        $('.btn-confirma-remove').on('click', function () {
            var url = $('#form-remove').attr('action');
            $.post(url, {tecnico_id: id}, function (rs) {
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

