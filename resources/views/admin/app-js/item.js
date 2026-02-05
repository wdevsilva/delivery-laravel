$(function() {
    $('#item_preco').mask("#.##0,00", { reverse: true });
    $('#datatable').on('click', '.btn-remover', function() {
        var id = $(this).data('id');
        $('#modal-remove').modal('show');
        $('.btn-confirma-remove').on('click', function() {
            var url = $('#form-remove').attr('action');
            $.post(url, { item_id: id }, function(rs) {
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

    $('#datatable').on('click', '.btn-promo', function() {
        var url = baseUri + '/item/promo_update/';
        var item_promo = $(this).data('promo');
        var item_id = $(this).data('id');
        if (item_promo == 0) {
            $(this).data('promo', 1);
            $(this).removeClass('btn-danger').addClass('btn-success').find('i').removeClass('fa-star-o').addClass('fa-star').attr('title', 'Promoção');
            $(this).tooltip('hide').attr('data-original-title', 'Promoção').tooltip('show');
        } else {
            $(this).data('promo', 0);
            $(this).removeClass('btn-success').addClass('btn-danger').find('i').removeClass('fa-star').addClass('fa-star-o');
            $(this).tooltip('hide').attr('data-original-title', 'Padrão').tooltip('show');
        }
        $.post(url, { item_id: item_id, item_promo: item_promo }).then(function(rs) {
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
        });
        return false;
    });

    $('#datatable').on('change', '.update-estoque', function() {
        var id = $(this).attr('id');
        var qtd = parseInt($(this).val());

        var url = baseUri + '/item/update_estoque/';
        $.post(url, { item_id: id, quantidade: qtd }, function(rs) {
            _alert_success();
        })
    })
});