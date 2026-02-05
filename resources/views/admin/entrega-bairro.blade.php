<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.datatables/bootstrap-adapter/css/datatables.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3>Bairros Disponíveis para Entregas</h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/entrega/bairro_add/" method="post" class>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <label>Bairro</label>
                                        <input type="hidden" name="bairro_id" id="bairro_id" value="" />
                                        <input type="text" name="bairro_nome" id="bairro_nome" class="form-control" required placeholder="ex: Centro" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Cidade <small class="text-muted">(opcional)</small></label>
                                        <input type="text" name="bairro_cidade" id="bairro_cidade" class="form-control" placeholder="ex: São Paulo" />
                                    </div>
                                    <div class="col-md-1">
                                        <label>Taxa R$</label>
                                        <input type="text" name="bairro_preco" id="bairro_preco" class="form-control money" required placeholder="2.00" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Tempo <small class="text-muted">(opcional)</small></label>
                                        <input type="text" name="bairro_tempo" id="bairro_tempo" class="form-control" placeholder="40 min" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Observação <small class="text-muted">(opcional)</small></label>
                                        <input type="text" name="bairro_obs" id="bairro_obs" class="form-control" placeholder="Difícil acesso" />
                                    </div>
                                    <div class="col-md-1">
                                        <label>Status</label>
                                        <select name="bairro_ativo" id="bairro_ativo" class="form-control">
                                            <option value="1">Ativo</option>
                                            <option value="0">Inativo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-block btn-primary btn-submit" style="margin-top: 26px;"><i class="fa fa-save"></i> Cadastrar</button>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </form>
                        <div class="table-responsivse">
                            <table class="table table-bordered table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Bairro</th>
                                        <th>Cidade</th>
                                        <th>Valor</th>
                                        <th>Tempo estimado</th>
                                        <th>Observações</th>
                                        <th width="80" class="text-center">Status</th>
                                        <th width="140" class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data[0])) : ?>
                                        <?php foreach ($data as $obj) : ?>
                                            <tr class="gradeA" id="tr-<?= $obj->bairro_id ?>">
                                                <td id="td-bairro"><?= $obj->bairro_nome ?></td>
                                                <td id="td-cidade"><?= $obj->bairro_cidade ?></td>
                                                <td id="td-valor"><?= $obj->bairro_preco ?></td>
                                                <td id="td-tempo"><?= $obj->bairro_tempo ?></td>
                                                <td id="td-obs"><?= $obj->bairro_obs ?></td>
                                                <td class="text-center">
                                                    <?php 
                                                    $ativo = isset($obj->bairro_ativo) ? $obj->bairro_ativo : 1;
                                                    if ($ativo == 1): 
                                                    ?>
                                                        <span class="label label-success">Ativo</span>
                                                    <?php else: ?>
                                                        <span class="label label-danger">Inativo</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <button class="btn btn-sm btn-primary btn-edit" 
                                                        data-id="<?= $obj->bairro_id ?>" 
                                                        data-nome="<?= $obj->bairro_nome ?>" 
                                                        data-cidade="<?= $obj->bairro_cidade ?>" 
                                                        data-preco="<?= $obj->bairro_preco ?>" 
                                                        data-tempo="<?= $obj->bairro_tempo ?>" 
                                                        data-obs="<?= $obj->bairro_obs ?>"
                                                        data-ativo="<?= $ativo ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <a title="Remover" data-toggle="tooltip" class="btn btn-sm btn-danger btn-remover" data-id="<?= $obj->bairro_id ?>">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade colored-header warning md-effect-10" id="modal-remove" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Remover Registro</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                            <h4>Atenção!</h4>
                            <p>Ao deletar um bairro, você ira deletar também todos os endereços de clientes do mesmo.</p>
                            <p>Esta ação não pode ser desfeita. Deseja realmente prosseguir?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form name="form-remove" id="form-remove" action="<?php echo $baseUri; ?>/entrega/bairro_remove/<?= $obj->bairro_id ?>/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-warning btn-flat btn-confirma-remove">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script src="js/jquery.js"></script>
        <script src="js/jquery.cooki/jquery.cooki.js"></script>
        <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
        <script type="text/javascript" src="js/behaviour/core.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery.datatables/jquery.datatables.min.js"></script>
        <script type="text/javascript" src="js/jquery.datatables/bootstrap-adapter/js/datatables.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script src="app-js/main.js"></script>
        <script type="text/javascript" src="js/jquery.mask.js"></script>
        <script type="text/javascript">
            

            $('.btn-remover').on('click', function() {
                var id = $(this).data('id');

                $('#modal-remove').modal('show');
                $('.btn-confirma-remove').on('click', function() {
                    var url = $('#form-remove').attr('action');
                    $.post(url, {
                        categoria_id: id
                    }, function(rs) {
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

            $('.money').mask("#.##0,00", {
                reverse: true
            });
            $('#menu-config-bairro').addClass('active');
            oDt.fnSort([
                [0, 'desc']
            ]); //ordem da tabela   
            <?php if (isset($_GET['success'])) : ?>
                _alert_success();
            <?php endif; ?>

            $('#datatable').on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                var nome = $(this).data('nome');
                var cidade = $(this).data('cidade');
                var preco = $(this).data('preco');
                var tempo = $(this).data('tempo');
                var obs = $(this).data('obs');
                var ativo = $(this).data('ativo');
                
                $('#bairro_id').val(id);
                $('#bairro_nome').val(nome);
                $('#bairro_cidade').val(cidade);
                $('#bairro_preco').val(preco);
                $('#bairro_tempo').val(tempo);
                $('#bairro_obs').val(obs);
                $('#bairro_ativo').val(ativo);
                
                $('.btn-submit').html('<i class="fa fa-refresh"></i> Atualizar');
            });
        </script>
</body>

</html>