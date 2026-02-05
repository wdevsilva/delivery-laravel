<div class="modal right fade" id="modal-faixa-cep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title text-center text-danger">
                    <i class="fa fa-warning text-danger"></i>
                    ATENÇÃO
                </h3>
            </div>
            <div class="modal-body">
                <h4 class="text-center">
                    <strong>
                        <br>
                        Desculpe, no momento não realizamos entrega na região informada!<br><br><br>
                        Dúvidas: <br><br>
                        <i class="fa fa-phone"></i>
                        <?= $data['config']->config_fone1 ?> &nbsp;
                        <?= ($data['config']->config_fone2 != "") ? $data['config']->config_fone2 : '' ?> &nbsp;
                    </strong>
                </h4>
            </div>
        </div>
    </div>
</div>
</div>