$(function () {
    $("[data-mask='phone']").mask("(99) 9999-9999?9");

    $('.fileinput').fileinput();

    $('#modal-novo  #usuario_nome').on('keyup', function () {
        var nome = $.trim($(this).val());
        var id = $.trim($('#modal-novo #usuario_id').val());
        if (id === "" || id === 0) {
            nome = strip_accents(nome);
            nome.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
            nome_splited = nome.split(" ");
            login_sugest = "";
            for (i = 0; i <= nome_splited.length - 1; i++) {
                login_sugest += nome_splited[i] + '.';
            }
            $('#modal-novo #usuario_login').val(login_sugest.substr(0, login_sugest.length - 1));
        }
    });


    $('#form-editar').on('submit', function () {
        var img = $(".fileinput-preview img").attr('src');
        if (img != 'undefined') {
            $('#usuario_avatar').val(img);
        }
    });

    $('.btn-remover').on('click', function () {
        var id = $(this).data('id');
        $('#modal-remove').modal('show');
        $('.btn-confirma-remove').on('click', function () {
            var url = $('#form-remove').attr('action');
            $.post(url, {usuario_id: id}, function (rs) {
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

    $('.btn-editar').on('click', function () {
        $('#imgeditarteste').remove();
        var id = $(this).data('id');
        var nome = $(this).data('nome');
        var email = $(this).data('email');
        var login = $(this).data('login');
        var fone = $(this).data('fone');
        var img = $(this).data('image');

        $('#modal-editar #usuario_nome').val(nome);
        $('#modal-editar #usuario_email').val(email);
        $('#modal-editar #usuario_login').val(login);
        $('#modal-editar #usuario_fone').val(fone);
        $('#modal-editar #usuario_id').val(id);
        $('#modal-editar #usuario_senha').val('');
        $('<img id="imgeditarteste" />').attr('src', img).appendTo($('#imgeditar'));
        $('#modal-editar').modal('show');
    });
    $('.btn-novo').on('click', function () {
        $('#modal-novo #usuario_nome').val('');
        $('#modal-novo #usuario_email').val('');
        $('#modal-novo #usuario_login').val('');
        $('#modal-novo #usuario_fone').val('');
        $('#modal-novo #usuario_id').val('');
        $('#modal-novo #usuario_senha').val('');
        $('#modal-novo').modal('show');
    });
});

