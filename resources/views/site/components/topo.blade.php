<header>
    @php
    // 🎄 Ativar chapéu de Papai Noel apenas nos dias 24 e 25 de dezembro
    $diaAtual = (int)date('d');
    $mesAtual = (int)date('m');
    $isNatal = ($mesAtual === 12 && ($diaAtual === 24 || $diaAtual === 25));
    @endphp
    <div class="brand">
        <div class="logo" aria-hidden="true">
            @if($config->config_foto)
                <a href="{{ url('/') }}" id="brand-logo">
                    @if($isNatal)
                    <!-- 🎅 Chapéu de Papai Noel -->
                    <div class="santa-hat">
                        <div class="santa-hat-trim"></div>
                    </div>
                    @endif
                    <img src="{{ asset('logo/' . session('base_delivery') . '/' . $config->config_foto) }}"
                        alt="logo"
                        class="logo-img"
                        onerror="this.src='{{ asset('assets/img/sem_foto.jpg') }}'" />
                </a>
            @else
                <a href="{{ url('/') }}" id="brand-logo">
                    @if($isNatal)
                    <!-- 🎅 Chapéu de Papai Noel -->
                    <div class="santa-hat">
                        <div class="santa-hat-trim"></div>
                    </div>
                    @endif
                    <img src="{{ asset('logo/logo.png') }}"
                        alt="logo"
                        class="logo-img" />
                </a>
            @endif
        </div>
        <div class="store-info">
            <div class="store-name">{{ $config->config_nome }}</div>
            <div class="store-sub">
                <a href="http://maps.google.com/maps?daddr={{ $config->config_endereco }}&amp;ll=" target="_blank">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> {{ $config->config_endereco }}
                </a>
            </div>
            <div class="status-row">
                <div class="{{ $config->config_aberto == 1 ? 'badge-success' : 'badge-danger' }}" aria-label="">
                    {{ $config->config_aberto == 1 ? 'Aberto' : 'Fechado' }}
                </div>
                <div class="eta" aria-label="Tempo estimado" data-toggle="modal" data-target=".bd-example-modal-sm" title="Nossos horários" alt="Nossos horários">🕒 Nossos Horários <i class="fa fa-chevron-down arrow-down"></i></div>
            </div>
        </div>
    </div>
</header>
@php
// Detectar mobile - mover lógica para controller se necessário
$isMobile = strpos(request()->header('User-Agent'), 'Mobile') !== false;
@endphp
<!-- INICIO DO MODAL QUE APRESENtA OS HORÁRIOS -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-notify modal-info modal-fluid" role="document" style="padding: 15px 15%;">
        <div class="modal-content" style="min-height: 0% !important;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title text-center text-success">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    Horários
                </h3>
            </div>
            <div class="modal-body">
                <table class="table" style="width: 200px; text-align: center; margin: 0 auto;">
                    @php
                    // Domingo
                    $config_domingo = $config->config_domingo;
                    if (!empty($config_domingo)) {
                        $domingo1 = explode(" ", $config_domingo);
                        $domingo2 = explode("-", $domingo1[1]);
                        $domingo  = $domingo2[0] . ' - ' . $domingo2[1];
                    }
                    $domingo = (!empty($config_domingo) && $domingo1[0] == 'on' ? '<tr><td style="border:none !important;"><b>Domingo</b></td><td style="border:none !important;"><span style="color: green;">' . $domingo . '</span></center></td></tr>' : '<tr><td style="border:none !important;"><b>Domingo</b></td><td style="border:none !important;"><span style="color: red;">Fechado</span></center></td></tr>');
                    echo $domingo;

                    // Segunda
                    $config_segunda = $config->config_segunda;
                    if (!empty($config_segunda)) {
                        $segunda1 = explode(" ", $config_segunda);
                        $segunda2 = explode("-", $segunda1[1]);
                        $segunda  = $segunda2[0] . ' - ' . $segunda2[1];
                    }
                    $segunda = (!empty($config_segunda) && $segunda1[0] == 'on' ? '<tr><td style="border:none !important;"><b>Segunda</b></td><td style="border:none !important;"><span style="color: green;">' . $segunda . '</span></center></td></tr>' : '<tr><td style="border:none !important;"><b>Segunda</b></td><td style="border:none !important;"><span style="color: red;"><span style="color: red;">Fechado</span></span></center></td></tr>');
                    echo $segunda;

                    // Terça
                    $config_terca = $config->config_terca;
                    if (!empty($config_terca)) {
                        $terca1 = explode(" ", $config_terca);
                        $terca2 = explode("-", $terca1[1]);
                        $terca  = $terca2[0] . ' - ' . $terca2[1];
                    }
                    $terca = (!empty($config_terca) && $terca1[0] == 'on' ? '<tr><td style="border:none !important;"><b>Terça</b></td><td style="border:none !important;"><span style="color: green;">' . $terca . '</span></center></td></tr>' : '<tr><td style="border:none !important;"><b>Terça</b></td><td style="border:none !important;"><span style="color: red;">Fechado</span></center></td></tr>');
                    echo $terca;

                    // Quarta
                    $config_quarta = $config->config_quarta;
                    if (!empty($config_quarta)) {
                        $quarta1 = explode(" ", $config_quarta);
                        $quarta2 = explode("-", $quarta1[1]);
                        $quarta  = $quarta2[0] . ' - ' . $quarta2[1];
                    }
                    $quarta = (!empty($config_quarta) && $quarta1[0] == 'on' ? '<tr><td style="border:none !important;"><b>Quarta</b></td><td style="border:none !important;"><span style="color: green;">' . $quarta . '</span></center></td></tr>' : '<tr><td style="border:none !important;"><b>Quarta</b></td><td style="border:none !important;"><span style="color: red;">Fechado</span></center></td></tr>');
                    echo $quarta;

                    // Quinta
                    $config_quinta = $config->config_quinta;
                    if (!empty($config_quinta)) {
                        $quinta1 = explode(" ", $config_quinta);
                        $quinta2 = explode("-", $quinta1[1]);
                        $quinta  = $quinta2[0] . ' - ' . $quinta2[1];
                    }
                    $quinta = (!empty($config_quinta) && $quinta1[0] == 'on' ? '<tr><td style="border:none !important;"><b>Quinta</b></td><td style="border:none !important;"><span style="color: green;">' . $quinta . '</span></center></td></tr>' : '<tr><td style="border:none !important;"><b>Quinta</b></td><td style="border:none !important;"><span style="color: red;">Fechado</span></center></td></tr>');
                    echo $quinta;

                    // Sexta
                    $config_sexta = $config->config_sexta;
                    if (!empty($config_sexta)) {
                        $sexta1 = explode(" ", $config_sexta);
                        $sexta2 = explode("-", $sexta1[1]);
                        $sexta  = $sexta2[0] . ' - ' . $sexta2[1];
                    }
                    $sexta = (!empty($config_sexta) && $sexta1[0] == 'on' ? '<tr><td style="border:none !important;"><b>Sexta</b></td><td style="border:none !important;"><span style="color: green;">' . $sexta . '</span></center></td></tr>' : '<tr><td style="border:none !important;"><b>Sexta</b></td><td style="border:none !important;"><span style="color: red;">Fechado</span></center></td></tr>');
                    echo $sexta;

                    // Sábado
                    $config_sabado = $config->config_sabado;
                    if (!empty($config_sabado)) {
                        $sabado1 = explode(" ", $config_sabado);
                        $sabado2 = explode("-", $sabado1[1]);
                        $sabado  = $sabado2[0] . ' - ' . $sabado2[1];
                    }
                    $sabado = (!empty($config_sabado) && $sabado1[0] == 'on' ? '<tr><td style="border:none !important;"><b>Sábado</b></td><td style="border:none !important;"><span style="color: green;">' . $sabado . '</center></td></tr>' : '<tr><td style="border:none !important;"><b>Sábado</b></td><td style="border:none !important;"><span style="color: red;">Fechado</span></center></td></tr>');
                    echo $sabado;
                    @endphp
                </table>
            </div>
            <div class="modal-footer">
                <center><button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button></center>
            </div>
        </div>
    </div>
</div>
<!-- FINAL DO MODAL QUE APRESENHA OS HORÁRIOS -->
