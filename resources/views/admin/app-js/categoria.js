$(function () {
    $("[data-mask='phone']").mask("(99) 9999-9999?9");
    $("[data-mask='cpf']").mask("999.999.999-99");
    $("[data-mask='cep']").mask("99999-999");
    $("[data-mask='cnpj']").mask("99.999.999/9999-99");
    $('#categoria_cep').keyup(function () {
        var cep = $(this).val();
        cep = cep.replace(/_/g, '');
        if (cep.length >= 9) {
            var url = 'http://cep.republicavirtual.com.br/web_cep.php?cep=' + cep + '&formato=json';
            $.getJSON(url, {}, function (rs) {
                if (rs.resultado == 1) {
                    new dgCidadesEstados({
                        cidade: document.getElementById('categoria_cidade'),
                        estado: document.getElementById('categoria_uf'),
                        estadoVal: rs.uf,
                        cidadeVal: rs.cidade
                    });
                    $('#categoria_bairro').val(rs.bairro);
                    $('#categoria_endereco').val(rs.tipo_logradouro + ' ' + rs.logradouro);
                    $('#categoria_numero').focus();
                }
            });
        }
    });
    $('.btn-remover').on('click', function () {
        var id = $(this).data('id');
        $('#modal-remove').modal('show');
        $('.btn-confirma-remove').on('click', function () {
            var url = $('#form-remove').attr('action');
            $.post(url, {categoria_id: id}, function (rs) {
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

    $('#datatable').on('change','.mudar-ordem',function () {
        var id = $(this).attr('id');
        var pos = parseInt( $(this).val() );
        var url = baseUri + '/categoria/altera_pos/';
        $.post(url,{categoria_id: id, categoria_pos: pos},function(rs){
            _alert_success();
        })
    })

    $('#datatable').on('click','.btn-banner',function () {
        var id = $(this).data('id');
        var url = baseUri + '/categoria/img_remove/';
        $.post(url,{id: id},function(rs){
            _alert_success();
        })
    })

    $('#datatable').on('click','.btn-status',function () {
        var id = $(this).data('id');
        var status = $(this).data('status');
        var status_id = status;
        if(status == 1){
            $('#status-exibe-nome').html('Desativar');
            status = 'Desativado';
        }else{
            $('#status-exibe-nome').html('Ativar');
            status = 'Ativado';
        }
        $('#modal-status').modal('show');
        $('.btn-confirma-status').on('click', function () {
            var url = $('#form-status').attr('action');
            $.post(url, {item_id: id, status: status_id}).then(function (rs) {
                $('#modal-status').modal('hide');
                $.gritter.add({
                    title: 'Procedimento Realizado',
                    text: 'Registro ' + status + ' com sucesso!',
                    class_name: 'success',
                    before_open: function () {
                        if ($('.gritter-item-wrapper').length == 1) {
                            return false;
                        }
                    }
                });
                setTimeout(function () {
                    location.reload();
                },100);
            });
            return false;
        });
    });

    $('#datatable').on('click','.btn-cozinha',function () {
        var id = $(this).data('id');
        var cozinha = $(this).data('cozinha');
        var url = baseUri + '/categoria/altera_cozinha/';
        $.post(url,{categoria_id: id, requer_cozinha: cozinha},function(rs){
            _alert_success();
            location.reload(); // Reload to show updated status
        })
    })

    function _alert_success(){
        $.gritter.add({
            title: 'Procedimento Realizado',
            text: 'Alteração realizada com sucesso!',
            class_name: 'success',
            before_open: function () {
                if ($('.gritter-item-wrapper').length == 1) {
                    return false;
                }
            }
        });
    }

});