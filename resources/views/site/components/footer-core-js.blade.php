<script>
    var baseUri = '{{ url('/') }}';
</script>
<script type="text/javascript">
    var isMobile = {{ ($isMobile) ? 'true' : 'false' }};
</script>
<script type="text/javascript" src="{{ asset('assets/vendor/jquery/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/jquery.select2/dist/js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/jquery.select2/dist/js/i18n/pt-BR.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" src="{{ asset('view/site/app-js/main.js') }}"></script>
@if (session('cliente_id', 0) > 0)
    <script>
        function verificarAtualizacao(url, tituloAlerta) {
            $.getJSON(url).done(function(rs) {
                if (rs != 0) {
                    __alert__(tituloAlerta, 'Pedido ' + rs.text, rs.color);
                    var pedido = baseUri + '/detalhes-do-pedido/' + rs.id + '/';
                    if (currentUri !== undefined && currentUri == 'pedido') {
                        window.location.href = pedido;
                    }
                }
            });
        }

        // Verifica pedido a cada 5 segundos
        setInterval(function() {
            verificarAtualizacao(baseUri + "/pedido/checkPedido/", 'Atualização de pedido');
        }, 5000);
    </script>
@endif
