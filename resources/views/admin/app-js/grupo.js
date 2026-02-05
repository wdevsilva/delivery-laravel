$(function() {

    $('#form-editar').on('submit', function() {
        var dados = $(this).serialize();
        var url = $(this).attr('action');
        $.post(url, dados, function(rs) {
            var nome = $('#modal-editar #grupo_nome').val();
            $('#td-nome').text(nome);
            $('#tr-' + $('#modal-editar #grupo_id').val() + ' .btn-editar').attr('data-nome', nome)
            $('#modal-editar').modal('hide');
            $.gritter.add({
                title: 'Procedimento Realizado',
                text: 'Dados alterados com sucesso!',
                class_name: 'success',
                before_open: function() {
                    if ($('.gritter-item-wrapper').length == 1) {
                        // prevents new gritter 
                        return false;
                    }
                }
            });
        });
        return false;
    });
    $('#form-novo').on('submit', function() {
        var dados = $(this).serialize();
        var url = $(this).attr('action');
        $.post(url, dados, function(rs) {
            window.location.reload();
        });
        return false;
    });

    $('.btn-remover').on('click', function() {
        var id = $(this).data('id');
        $('#modal-remove').modal('show');
        $('.btn-confirma-remove').on('click', function() {
            var url = $('#form-remove').attr('action');
            $.post(url, { grupo_id: id }, function(rs) {
                $('#modal-remove').modal('hide');
                $('#tr-' + id).fadeOut();
                $.gritter.add({
                    title: 'Procedimento Realizado',
                    text: 'Registro removido com sucesso!',
                    class_name: 'success',
                    before_open: function() {
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
    $('.btn-editar').on('click', function() {
        var id = $(this).data('id');
        var nome = $(this).data('nome');
        $('#modal-editar #grupo_nome').val(nome);
        $('#modal-editar #grupo_id').val(id);
        $('#modal-editar').modal('show');
    });
    $('.btn-novo').on('click', function() {
        $('#modal-novo #grupo_nome').val('');
        $('#modal-novo #grupo_id').val('');
        $('#modal-novo').modal('show');
    });
    $('#datatable').on('click', '.btn-status', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        var status_id = status;
        if (status == 1) {
            $('#status-exibe-nome').html('Desativar');
            status = 'Desativado';
        } else {
            $('#status-exibe-nome').html('Ativar');
            status = 'Ativado';
        }
        $('#modal-status').modal('show');
        $('.btn-confirma-status').on('click', function() {
            var url = $('#form-status').attr('action');
            $.post(url, { item_id: id, status: status_id }).then(function(rs) {
                $('#modal-status').modal('hide');
                $.gritter.add({
                    title: 'Procedimento Realizado',
                    text: 'Registro ' + status + ' com sucesso!',
                    class_name: 'success',
                    before_open: function() {
                        if ($('.gritter-item-wrapper').length == 1) {
                            return false;
                        }
                    }
                });
                setTimeout(function() {
                    location.reload();
                }, 100);
            });
            return false;
        });
    });
});