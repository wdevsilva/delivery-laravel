@php
$current = request()->path();
$baseUri = url("/");
@endphp
<?php $current = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
<div data-v-42af03df="" data-v-6cfbbd67="" class="menu-container w-100 px-3 bg-white mobile category-cards" id="myNav">
    <div data-v-42af03df="" class="grey-border"></div>
    <div data-v-42af03df="" class="menu-container__wrapper category-cards">
        <!-- INÍCIO -->
        <div data-v-0c8898ec="" data-v-42af03df="">
            <div data-v-0c8898ec="" class="mi-container flex justify-around router-link-active pt-1 voltarFooter" data-testid="router-link-menu">
                <a href="{{ $baseUri }}/" data-v-1267300e="" data-v-0c8898ec="" data-testid="span-menu"
                    class="mi-container radius-2 flex justify-around">
                    <div data-v-1267300e="" class="mi-icon voltarFooter">
                        <div data-v-d15b4698="" data-v-1267300e="" class="icon-container voltarFooter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 19.195 18" class="voltarFooter">
                                <g id="Home" transform="translate(-8.999 -10)">
                                    <path id="Icon"
                                        d="M16.622,18H2.57a1.319,1.319,0,0,1-1.317-1.318V9.657a1.317,1.317,0,0,1-.79-2.318L8.744.312a1.318,1.318,0,0,1,1.7,0L18.73,7.339a1.32,1.32,0,0,1-.79,2.323v7.021A1.319,1.319,0,0,1,16.622,18ZM8.279,11.417h2.635a1.319,1.319,0,0,1,1.317,1.318v3.952h4.391V8.344h1.256L9.6,1.319,1.315,8.344H2.57v8.343H6.962V12.735A1.319,1.319,0,0,1,8.279,11.417Zm0,1.318v3.952h2.635V12.735Z"
                                        transform="translate(9 10)" fill="<?= ($current == '' || $current == 'index' ? '#1A95F3' : '#ffffffff') ?>"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div data-v-1267300e="" class="mi-title font-0 text-primary voltarFooter"
                        style="color: rgba(255, 255, 255, 1); padding: 4px 4px;">
                        Início
                    </div>
                </a>
            </div>
            <div data-v-66839ce5="" data-v-0c8898ec="" role="dialog" class="modal-backdrop flex voltarFooter" style="display: none;"></div>
        </div>

        <!-- só vai mostrar se não tiver na tela de checkout -->
        @if ($current != 'pedido/')
            <!-- carrinho -->
            <div data-v-0c8898ec="" data-v-42af03df="">
                <div data-v-0c8898ec="" class="mi-container flex justify-around router-link-active pt-1" data-testid="router-link-menu"><span data-v-1267300e="" data-v-0c8898ec="" data-testid="span-menu" class="mi-container radius-2 flex justify-around">
                        <div data-v-1267300e="" class="mi-icon" onclick="$('#modal-carrinho').modal('show');" style="cursor: pointer;">
                            <div data-v-d15b4698="" data-v-1267300e="" class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 23.326 20">
                                    <path id="Shape" d="M8.454,20h0a2.563,2.563,0,0,1-2.563-2.567,6.2,6.2,0,0,0,.584-5.2L1.795,1.538H.77A.769.769,0,1,1,.77,0H2.308a.768.768,0,0,1,.7.462L4.036,2.82a1.535,1.535,0,0,1,.831-.256h16.92A1.538,1.538,0,0,1,23.2,4.707l-3.076,7.178a1.537,1.537,0,0,1-1.415.933H8.475a1.026,1.026,0,0,0,0,2.051H18.746a2.563,2.563,0,1,1-2.38,1.538H10.8A2.564,2.564,0,0,1,8.454,20ZM18.71,16.408a1.026,1.026,0,1,0,1.025,1.025A1.027,1.027,0,0,0,18.71,16.408Zm-10.255,0a1.026,1.026,0,1,0,1.025,1.025A1.027,1.027,0,0,0,8.455,16.408ZM4.866,4.1l3.076,7.178H18.71L21.786,4.1H4.866Z" fill="#ffffffff"></path>
                                </svg>
                                <span id="cart-count"></span>
                            </div>
                        </div>
                        <div data-v-1267300e="" class="mi-title font-0" onclick="$('#modal-carrinho').modal('show');" style="color: rgba(255, 255, 255, 1); padding: 4px 4px; cursor: pointer;">Carrinho</div>
                    </span></div>
                <div data-v-66839ce5="" data-v-0c8898ec="" role="dialog" class="modal-backdrop flex" style="display: none;"></div>
            </div>
        @endif
        @if (isset($_SESSION["__CLIENTE__ID__"]) && $_SESSION["__CLIENTE__ID__"] > 0)

            <!-- PEDIDOS -->
            <div data-v-0c8898ec="" data-v-42af03df="">
                <div data-v-0c8898ec="" class="mi-container flex justify-around router-link-active pt-1" data-testid="router-link-menu">
                    <a href="{{ $baseUri }}/meus-pedidos/" data-v-1267300e="" data-v-0c8898ec="" data-testid="span-menu"
                        class="mi-container radius-2 flex justify-around">
                        <div data-v-1267300e="" class="mi-icon">
                            <div data-v-d15b4698="" data-v-1267300e="" class="icon-container">
                                <!-- Ícone de Pedidos (lista) -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="<?= ($current == 'meus-pedidos/' ? '#1A95F3' : '#ffffffff') ?>"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                            </div>
                        </div>
                        <div data-v-1267300e="" class="mi-title font-0"
                            style="color: rgba(255, 255, 255, 1); padding: 4px 4px;">
                            Pedidos
                        </div>
                    </a>
                </div>
            </div>

            <!-- CUPONS -->
            <div data-v-0c8898ec="" data-v-42af03df="">
                <div data-v-0c8898ec="" class="mi-container flex justify-around router-link-active pt-1" data-testid="router-link-menu">
                    <a href="{{ $baseUri }}/meus_cupons/" data-v-1267300e="" data-v-0c8898ec="" data-testid="span-menu"
                        class="mi-container radius-2 flex justify-around">
                        <div data-v-1267300e="" class="mi-icon">
                            <div data-v-d15b4698="" data-v-1267300e="" class="icon-container">
                                <!-- Ícone de Cupom (ticket) -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="<?= ($current == 'meus_cupons/' ? '#1A95F3' : '#ffffffff') ?>"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4
                                 a2 2 0 0 0 0 6v4a2 2 0 0 1-2 2H5
                                 a2 2 0 0 1-2-2v-4a2 2 0 0 0 0-6z"></path>
                                    <line x1="12" y1="3" x2="12" y2="21"></line>
                                </svg>
                            </div>
                        </div>
                        <div data-v-1267300e="" class="mi-title font-0"
                            style="color: rgba(255, 255, 255, 1); padding: 4px 4px;">
                            Cupons
                        </div>
                    </a>
                </div>
            </div>

            <!-- PONTOS -->
            <?php if ($config->config_fidelidade_ativo ?? 0 == 1): ?>
            <div data-v-0c8898ec="" data-v-42af03df="">
                <div data-v-0c8898ec="" class="mi-container flex justify-around router-link-active pt-1" data-testid="router-link-menu">
                    <a href="{{ $baseUri }}/fidelidadeCliente/" data-v-1267300e="" data-v-0c8898ec="" data-testid="span-menu"
                        class="mi-container radius-2 flex justify-around">
                        <div data-v-1267300e="" class="mi-icon">
                            <div data-v-d15b4698="" data-v-1267300e="" class="icon-container">
                                <!-- Ícone de Pontos (estrela/gift) -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="<?= ($current == 'fidelidadeCliente/' ? '#1A95F3' : '#ffffffff') ?>"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </div>
                        </div>
                        <div data-v-1267300e="" class="mi-title font-0"
                            style="color: rgba(255, 255, 255, 1); padding: 4px 4px;">
                            Fidelidade
                        </div>
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <!-- PERFIL -->
            <div data-v-0c8898ec="" data-v-42af03df="">
                <div data-v-0c8898ec="" class="mi-container flex justify-around router-link-active pt-1" data-testid="router-link-menu">
                    <a href="{{ $baseUri }}/meus-dados/" data-v-1267300e="" data-v-0c8898ec="" data-testid="span-menu"
                        class="mi-container radius-2 flex justify-around">
                        <div data-v-1267300e="" class="mi-icon">
                            <div data-v-d15b4698="" data-v-1267300e="" class="icon-container">
                                <?php
                                $pattern = '#^(meus-dados|meus-enderecos|novo-endereco|editar-endereco/\d+)/?$#';
                                ?>
                                <!-- Ícone de Perfil (usuário) -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="<?= preg_match($pattern, $current) ? '#1A95F3' : '#ffffffff' ?>"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                        </div>
                        <div data-v-1267300e="" class="mi-title font-0"
                            style="color: rgba(255, 255, 255, 1); padding: 4px 4px;">
                            Perfil
                        </div>
                    </a>
                </div>
            </div>

            <!-- SAIR -->
            <div data-v-0c8898ec="" data-v-42af03df="">
                <div data-v-0c8898ec="" class="mi-container flex justify-around router-link-active pt-1" data-testid="router-link-menu">
                    <a href="{{ $baseUri }}/sair/" data-v-1267300e="" data-v-0c8898ec="" data-testid="span-menu"
                        class="mi-container radius-2 flex justify-around">
                        <div data-v-1267300e="" class="mi-icon">
                            <div data-v-d15b4698="" data-v-1267300e="" class="icon-container">
                                <!-- Ícone de Logout -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="#ffffffff"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                            </div>
                        </div>
                        <div data-v-1267300e="" class="mi-title font-0"
                            style="color: rgba(255, 255, 255, 1); padding: 4px 4px;">
                            Sair
                        </div>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
