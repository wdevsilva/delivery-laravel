$(function () {

    $("[data-mask='cpf']").mask("999.999.999-99");
    $("[data-mask='cell']").mask("(99)99999-9999");

    $(".datatable").DataTable(
    {
        retrieve: true,
        responsive: true,
        dom: 'Bfrtip',
        buttons: datatable_buttons,
        "displayLength": 10,
        "order": [[0, "asc"]],
        "oLanguage": lang
    });

    $('#tbl_entregador').on('click', '.btn-remover', function () {
        var id = $(this).data('id');
        $('#modal-remove').modal('show');
        $('.btn-confirma-remove').on('click', function () {
            var url = $('#form-remove').attr('action');
            $.post(url, { entregador_id: id }, function (rs) {
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