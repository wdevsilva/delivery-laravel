<div class="modal right fade" id="modal-carrinho" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title text-center text-danger">
                    <i class="fa fa-shopping-cart fa-1x"></i>
                    &nbsp;Meu Carrinho
                </h3>
            </div>
            <div class="modal-body">
                <div id="carrinho-lista"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Carregar carrinho quando modal abrir
    $('#modal-carrinho').on('show.bs.modal', function () {
        $.get('{{ url("/carrinho/reload") }}', function(data) {
            $('#carrinho-lista').html(data);
        }).fail(function() {
            $('#carrinho-lista').html('<div class="alert alert-danger">Erro ao carregar carrinho</div>');
        });
    });

    // Carregar carrinho imediatamente ao abrir a página
    $.get('{{ url("/carrinho/reload") }}', function(data) {
        $('#carrinho-lista').html(data);
    });
});
</script>
