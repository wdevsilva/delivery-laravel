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
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap.summernote/dist/summernote.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="css/btn-upload.css" rel="stylesheet" />
    <script type="text/javascript" src="js/main.js" charset="UTF-8"></script>
    <script src="js/jquery.js"></script>
    <link href="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
    <script src="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.js"></script>
</head>
<style>
    .form-control[readonly] {
        background-color: #fff
    }

    .textOnInput {
        position: relative;
    }

    .textOnInput label {
        position: absolute;
        top: -15px;
        left: 13px;
        padding: 2px;
        z-index: 1;
    }

    .textOnInput label:after {
        content: " ";
        background-color: #fff;
        width: 100%;
        height: 13px;
        position: absolute;
        left: 0;
        bottom: 0;
        z-index: -1;
    }

    label {
        font-size: 16px;
        font-weight: 500;
        display: inline-block;
        margin-bottom: .5rem;
    }

    .form-control {
        box-shadow: none !important;
    }

    fieldset.scheduler-border {
        border: 1px solid lightgrey;
        /*border: 1px groove #ddd !important;*/
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
        border-radius: 5px;
    }

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width: auto;
        padding: 0 10px;
        border-bottom: none;
    }

    form button {
        background: #4666F7;
        padding: 10px;
        border: 0;
        margin-top: 20px;
        color: #fff;
        border-radius: 5px;
        outline: 0;
        cursor: pointer;
        transition-duration: 200ms;
        box-shadow: 0 2.8px 2.2px rgba(70, 102, 247, 0.034),
            0 6.7px 5.3px rgba(70, 102, 247, 0.048),
            0 12.5px 10px rgba(70, 102, 247, 0.06),
            0 22.3px 17.9px rgba(70, 102, 247, 0.072),
            0 41.8px 33.4px rgba(70, 102, 247, 0.086),
            0 100px 80px rgba(70, 102, 247, 0.12);
    }

    form button:hover {
        background: #263fb1;
        transition-duration: 200ms;
    }

    form button:disabled {
        background: #5b5e78;
        cursor: not-allowed;
    }

    :placeholder-shown {
        font-size: small;
    }
</style>

<body class="animated">
    <?php
    require_once 'cobranca.php';
    //require_once 'bloqueio.php';
    ?>
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <!-- TOP NAVBAR -->
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3>Contactar via Whatsapp</h3>
                        <?php
                        if (isset($data[0])) {
                        ?>
                            Você tem <?= count($data) ?> clientes para contactar
                        <?php } ?>
                        <div class="col-sm-3">
                            <form class="form-horizontal">
                                <div class="form-group" style="display: none;">
                                    <div class="textOnInput">
                                        <label for="session">Session Name:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="session" name="session" value="<?=$data['config']->config_token?>" placeholder="Nome para identificação da sessão">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <div class="textOnInput">
                                        <label for="apitoken">API Token:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="apitoken" name="apitoken" value="ApiGratisToken2021" placeholder="Token da API para autenticação de acesso">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <div class="textOnInput">
                                        <label for="sessionkey">Session KEY:</label>
                                        <div class="col-sm-10">
                                            <input type="sessionkey" class="form-control" id="sessionkey" name="sessionkey" value="<?=$data['config']->config_token?>" placeholder="Chave de autorização para requisições na API.">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <div class="textOnInput">
                                        <label for="wh_status">Webhook Send Messages:</label>
                                        <div class="col-sm-10">
                                            <input type="wh_status" class="form-control" id="wh_status" name="wh_status" placeholder="URL que recebe o Webhooks dos status das mensagens enviadas">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <div class="textOnInput">
                                        <label for="wh_message">Webhook Received Messages:</label>
                                        <div class="col-sm-10">
                                            <input type="wh_message" class="form-control" id="wh_message" name="wh_message" placeholder="URL que recebe o Webhooks dos status das mensagens recebidas">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <div class="textOnInput">
                                        <label for="wh_connect">Webhook Status Connection:</label>
                                        <div class="col-sm-10">
                                            <input type="wh_connect" class="form-control" id="wh_connect" name="wh_connect" placeholder="URL que recebe o status da conexão">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <div class="textOnInput">
                                        <label for="wh_qrcode">Webhook QRCode:</label>
                                        <div class="col-sm-10">
                                            <input type="wh_qrcode" class="form-control" id="wh_qrcode" name="wh_qrcode" placeholder="URL que recebe o webhooks do QRCODE do cliente">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="button" id="send-btn" onclick="if (!window.__cfRLUnblockHandlers) return false; alterSession(document.getElementById('session').value)" data-cf-modified-13abae17f8c39ac77a69840a-="">
                                            Conectar no Whatsapp
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-4" style="margin-top: 10px;">
                            <img id="image" src="images/loading.gif" draggable="false" alt="qr-code" style="width: 150px; height: 130px;">
                        </div>
                    </div>
                    <div class="content">
                        <form action="#" autocomplete="off" name="add_mensagem" id="add_mensagem">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="link">Enviar mensagens para</label>
                                            <select name="tipo" class="form-control">
                                                <option value="todos">TODOS OS CLIENTES</option>
                                                <option value="semcompra" selected>CLIENTES COM AUSÊNCIA DE COMPRAS</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="link">Link <span class="text-danger">*</span></label>
                                            <input type="text" name="link" id="link" class="form-control" placeholder="Informe o endereço link do seu delivery" value="https://pediuzap.com.br/delivery/index?token=<?= $data['config']->config_token ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                        <?php
                                        $hr = date(" H ");
                                        if ($hr >= 12 && $hr < 18) {
                                            $resp = "Boa tarde ☀️";
                                        } else if ($hr >= 0 && $hr < 12) {
                                            $resp = "Bom dia ☀️";
                                        } else {
                                            $resp = "Boa noite 🌛";
                                        }
                                        ?>
                                        <p><strong>Exemplo de mensagem, (Edite com conforme a sua necessidade). Variaveis: [cliente]</strong></p>
                                        <p><?= $resp ?> [cliente]! %20</p>
                                        <p>Preparamos um *CUPOM DE DESCONTO* especial para você. 😉 %20</p>
                                        <p>Faça o seu pedido clicando nesta mensagem e utilize o *CUPOM DELICIA* e surpreenda-se 😍! %20</p>                                        
                                        <p>Não precisa instalar nada, é só acessar e realizar seu pedido! 🍕🍔🥤 %20</p>
                                        <p>Aguardamos o seu pedido! 🛵 🍔 🍕</p>
                                        <div class="form-group">
                                            <label for="smtp_email">Mensagem <span class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="15" name="mensagem" id="mensagem"></textarea>
                                        </div>
                                        <button type="button" class="btn btn-sm emoji">☀️</button>
                                        <button type="button" class="btn btn-sm emoji">🌛</button>
                                        <button type="button" class="btn btn-sm emoji">😁</button>
                                        <button type="button" class="btn btn-sm emoji">😂</button>
                                        <button type="button" class="btn btn-sm emoji">😃</button>
                                        <button type="button" class="btn btn-sm emoji">😄</button>
                                        <button type="button" class="btn btn-sm emoji">😅</button>
                                        <button type="button" class="btn btn-sm emoji">😆</button>
                                        <button type="button" class="btn btn-sm emoji">😉</button>
                                        <button type="button" class="btn btn-sm emoji">😊</button>
                                        <button type="button" class="btn btn-sm emoji">😋</button>
                                        <button type="button" class="btn btn-sm emoji">😌</button>
                                        <button type="button" class="btn btn-sm emoji">😍</button>
                                        <button type="button" class="btn btn-sm emoji">😏</button>
                                        <button type="button" class="btn btn-sm emoji">😒</button>
                                        <button type="button" class="btn btn-sm emoji">😓</button>
                                        <button type="button" class="btn btn-sm emoji">😔</button>
                                        <button type="button" class="btn btn-sm emoji">😖</button>
                                        <button type="button" class="btn btn-sm emoji">😘</button>
                                        <button type="button" class="btn btn-sm emoji">😚</button>
                                        <button type="button" class="btn btn-sm emoji">😜</button>
                                        <button type="button" class="btn btn-sm emoji">😝</button>
                                        <button type="button" class="btn btn-sm emoji">😞</button>
                                        <button type="button" class="btn btn-sm emoji">😠</button>
                                        <button type="button" class="btn btn-sm emoji">😢</button>
                                        <button type="button" class="btn btn-sm emoji">😤</button>
                                        <button type="button" class="btn btn-sm emoji">😥</button>
                                        <button type="button" class="btn btn-sm emoji">😨</button>
                                        <button type="button" class="btn btn-sm emoji">😩</button>
                                        <button type="button" class="btn btn-sm emoji">😪</button>
                                        <button type="button" class="btn btn-sm emoji">😫</button>
                                        <button type="button" class="btn btn-sm emoji">😭</button>
                                        <button type="button" class="btn btn-sm emoji">😰</button>
                                        <button type="button" class="btn btn-sm emoji">😱</button>
                                        <button type="button" class="btn btn-sm emoji">😲</button>
                                        <button type="button" class="btn btn-sm emoji">😳</button>
                                        <button type="button" class="btn btn-sm emoji">😵</button>
                                        <button type="button" class="btn btn-sm emoji">😷</button>
                                        <button type="button" class="btn btn-sm emoji">😸</button>
                                        <button type="button" class="btn btn-sm emoji">😹</button>
                                        <button type="button" class="btn btn-sm emoji">😺</button>
                                        <button type="button" class="btn btn-sm emoji">😻</button>
                                        <button type="button" class="btn btn-sm emoji">😼</button>
                                        <button type="button" class="btn btn-sm emoji">😽</button>
                                        <button type="button" class="btn btn-sm emoji">😾</button>
                                        <button type="button" class="btn btn-sm emoji">😿</button>
                                        <button type="button" class="btn btn-sm emoji">🙀</button>
                                        <button type="button" class="btn btn-sm emoji">🙅</button>
                                        <button type="button" class="btn btn-sm emoji">🙆</button>
                                        <button type="button" class="btn btn-sm emoji">🙇</button>
                                        <button type="button" class="btn btn-sm emoji">🙈</button>
                                        <button type="button" class="btn btn-sm emoji">🙉</button>
                                        <button type="button" class="btn btn-sm emoji">🙊</button>
                                        <button type="button" class="btn btn-sm emoji">🙋</button>
                                        <button type="button" class="btn btn-sm emoji">🙌</button>
                                        <button type="button" class="btn btn-sm emoji">🙍</button>
                                        <button type="button" class="btn btn-sm emoji">🙎</button>
                                        <button type="button" class="btn btn-sm emoji">🙏</button>
                                        <button type="button" class="btn btn-sm emoji">🛵</button>
                                        <button type="button" class="btn btn-sm emoji">🏠</button>
                                        <button type="button" class="btn btn-sm emoji">🍽</button>
                                        <button type="button" class="btn btn-sm emoji">🥐</button>
                                        <button type="button" class="btn btn-sm emoji">🍔</button>
                                        <button type="button" class="btn btn-sm emoji">🍟</button>
                                        <button type="button" class="btn btn-sm emoji">🍕</button>
                                        <button type="button" class="btn btn-sm emoji">🌭</button>
                                        <button type="button" class="btn btn-sm emoji">🥪</button>
                                        <button type="button" class="btn btn-sm emoji">🌮</button>
                                        <button type="button" class="btn btn-sm emoji">🍤</button>
                                        <button type="button" class="btn btn-sm emoji">🎂</button>
                                        <button type="button" class="btn btn-sm emoji">🍫</button>
                                        <button type="button" class="btn btn-sm emoji">🥤</button>
                                        <button type="button" class="btn btn-sm emoji">🍾</button>
                                        <button type="button" class="btn btn-sm emoji">🍻</button>
                                    </div>
                                    <div class="row">
                                        <p class="text-center">
                                            <button type="button" class="btn btn-success btn-lg enviar" id="enviar">
                                                <i class="fa fa-paper-plane enviar" id="enviar" aria-hidden="true"></i> Disparar mensagens
                                            </button>
                                        </p>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal enviar -->
    <div class="modal fade" id="ModalEnviar" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Envio de mensagens para o Whatsapp</h4>
                    Total: <span id="total_para_enviar">0</span>
                    |
                    Enviados: <span id="total_enviado">0</span>
                    |
                    Erros: <span id="total_erro">0</span>
                    | Status: <span id="status"></span>
                </div>
                <div class="modal-body">
                    <div id="dados_enviar"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- conexão whatsappapi -->
    <script src="js/axios.min.js" type="text/javascript"></script>
    <script src="js/socket.io.js" type="text/javascript"></script>
    <script type="text/javascript">
        let url;
        let host = 'localhost'
        let host_ssl = 'whatsapp-v2.apibrasil.com.br'
        let port = '9197'
        url = host_ssl == '' ? `http://${host}:${port}` : `https://${host_ssl}`

        document.getElementById('image').style.visibility = "hidden";

        async function getSession(session) {
            const config = {
                headers: {
                    apitoken: document.getElementById("apitoken").value,
                    sessionkey: document.getElementById("sessionkey").value
                }
            }

            const data = {
                session: document.getElementById("session").value,
                wh_status: document.getElementById("wh_status").value,
                wh_message: document.getElementById("wh_message").value,
                wh_qrcode: document.getElementById("wh_qrcode").value,
                wh_connect: document.getElementById("wh_connect").value,
            }
            axios.post(url + "/start", data, config)
                .then((value) => {
                    //alert(value)
                })
                .catch((err) => {
                    //alert(err)
                })
        }

        async function alterSession(session) {
            if (!session) {
                alert("Digite o nome da sessão antes de continuar...")
            } else
            if (!document.getElementById('apitoken').value) {
                alert("Digite o TOKEN da API antes de continuar...")
            } else
            if (!document.getElementById('sessionkey').value) {
                alert("Digite a SESSION KEY da sessão antes de continuar...")
            } else {
                document.getElementById('image').style.visibility = "visible";
                document.getElementById('send-btn').disabled = true;
                await getSession(session)
            }
        }

        const socket = io(url + '/', {
            transports: ['websocket']
        });

        socket.on('msg', (msg) => {
            if (msg) {
                document.getElementById('image').style.visibility = "hidden";
                document.getElementById('send-btn').disabled = false;
                alert(msg.reason)
            }
        })

        socket.on('qrCode', (qrCode) => {
            let session = document.getElementById('session').value
            if (session === qrCode.session) {
                document.getElementById('image').src = qrCode.data;
            }
        })

        socket.on('whatsapp-status', (status) => {
            if (status) {
                //alert('Whatsapp Aberto com sucesso')
                $("#send-btn").html('Conectado');
                document.getElementById('send-btn').disabled = true;
                document.getElementById('image').src = "images/ok.jpg";
            } else {
                document.getElementById('send-btn').disabled = false;
                document.getElementById('image').src = "images/error.jpg";
            }
        })
    </script>
    <script src="js/rocket-loader.min.js" data-cf-settings="13abae17f8c39ac77a69840a-|49" defer=""></script>
    <script defer src="js/v652eace1692a40cfa3763df669d7439c1639079717194.js" crossorigin="anonymous"></script>
    <!-- fim conexão whatsappapi -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $('#menu-config-email').addClass('active');
        <?php if (isset($_GET['success'])) : ?>
            _alert_success();
        <?php endif; ?>

        $(".emoji").click(function() {
            var emoji = $(this).text();
            $('#mensagem').val($('#mensagem').val() + emoji);
        });

        $(function() {

            $(".enviar").click(function(e) {

                var result = confirm("Tem certeza de deseja continuar? Esta ação não podera ser desfeita");
                if (result) {

                    if (document.getElementById("mensagem").value == '') {
                        alert('Favor informe a mensagem a ser enviada');
                        $('#mensagem').focus();
                        return false;
                    }

                    $('#ModalEnviar').modal('show');

                    $.ajax({
                        type: "POST",
                        url: "<?php echo $baseUri; ?>/marketing/enviarMensagen",
                        data: $('#add_mensagem').serialize(),
                        beforeSend: function() {
                            document.getElementById("dados_enviar").innerHTML = '';
                            document.getElementById("dados_enviar").innerHTML = '<p style="margin-left: 45%;"><img src="images/loading.gif" width="50" height="50"></p>';
                        },
                        success: function(data) {
                            $('#dados_enviar').html(data);
                        }
                    });
                    return false;
                }
            });

            $(".close").click(function(e) {
                location.reload();
            });
        });
    </script>
</body>

</html>