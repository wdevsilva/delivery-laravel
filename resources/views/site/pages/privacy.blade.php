<!DOCTYPE html>
<html lang="en">

<body>
    <?php
    //POLITICA DE PRIVACIDADE
    if (ClienteSessao::get_id() > 0) {
        if ($data['cliente'][0]->cliente_politica_privacidade == 0) { ?>
            <script type="text/javascript">
                $(document).ready(function() {

                    function abreTermoPrivacidade() {
                        // mostra máscara cobrindo a tela inteira
                        $('#mascara').fadeIn(200);

                        // mostra o modal centralizado (CSS já cuida do posicionamento)
                        $('#politicaPrivacidade').fadeIn(200);

                        // trava scroll do body enquanto modal estiver aberto
                        $('body').css('overflow', 'hidden');
                    }

                    $('.fechar').click(function(ev) {
                        ev.preventDefault();
                        $("#mascara, #cobranca, #politicaPrivacidade").hide();
                        $('body').css('overflow', ''); // libera scroll do body
                    });

                    //Abro o Aviso de Pagamento caso vencido e Bloqueio o Sistema se vencido
                    <?php
                    echo 'abreTermoPrivacidade();';
                    ?>
                });
            </script>
    <?php }
    } ?>
    <p>POLÍTICA DE PRIVACIDADE</p>
    <p>Este site é mantido e operado por Sysvon.</p>
    <p>Nós coletamos e utilizamos alguns dados pessoais que pertencem àqueles que
        utilizam nosso site. Ao fazê-lo, agimos na qualidade de controlador desses dados e
        estamos sujeitos às disposições da Lei Federal n. 13.709/2018 (Lei Geral de
        Proteção de Dados Pessoais - LGPD).</p>
    <p>Nós cuidamos da proteção de seus dados pessoais e, por isso, disponibilizamos
        esta política de privacidade, que contém informações importantes sobre:</p>
    - Quem deve utilizar nosso site<br>
    - Quais dados coletamos e o que fazemos com eles;<br>
    - Seus direitos em relação aos seus dados pessoais; e<br>
    - Como entrar em contato conosco.<br><br>
    <p>1. Dados que coletamos e motivos da coleta</p>
    <p>Nosso site coleta e utiliza alguns dados pessoais de nossos usuários, de acordo com
        o disposto nesta seção.</p>
    <p>1. Dados pessoais fornecidos expressamente pelo usuário
        Nós coletamos os seguintes dados pessoais que nossos usuários nos fornecem
        expressamente ao utilizar nosso site:</p>
    -Nome completo;<br>
    -Endereço completo;<br>
    -Número de celular;<br>
    -Endereço de e-mail<br><br>
    <p>A coleta destes dados ocorre nos seguintes momentos:</p>
    <p>Quando o usuário faz o seu cadastro no site.</p>
    <p>Os dados fornecidos por nossos usuários são coletados com as seguintes
        finalidades:</p>
    Para que possam adquirir nossos produtos.<br><br>
    <p>2. Dados sensíveis</p>
    <p>Não serão coletados dados sensíveis de nossos usuários, assim entendidos aqueles2/6
        definidos nos arts. 11 e seguintes da Lei de Proteção de Dados Pessoais. Assim,
        não haverá coleta de dados sobre origem racial ou étnica, convicção religiosa,
        opinião política, filiação a sindicato ou a organização de caráter religioso, filosófico
        ou político, dado referente à saúde ou à vida sexual, dado genético ou biométrico,
        quando vinculado a uma pessoa natural.</p>
    <p>3. Cookies</p>
    <p>Cookies são pequenos arquivos de texto baixados automaticamente em seu
        dispositivo quando você acessa e navega por um site. Eles servem, basicamente,
        para seja possível identificar dispositivos, atividades e preferências de usuários.</p>
    <p>Os cookies não permitem que qualquer arquivo ou informação sejam extraídos do
        disco rígido do usuário, não sendo possível, ainda, que, por meio deles, se tenha
        acesso a informações pessoais que não tenham partido do usuário ou da forma
        como utiliza os recursos do site.</p>
    <p>a. Cookies do site</p>
    <p>Os cookies do site são aqueles enviados ao computador ou dispositivo do usuário e
        administrador exclusivamente pelo site.</p>
    <p>As informações coletadas por meio destes cookies são utilizadas para melhorar e
        personalizar a experiência do usuário, sendo que alguns cookies podem, por
        exemplo, ser utilizados para lembrar as preferências e escolhas do usuário, bem
        como para o oferecimento de conteúdo personalizado.</p>
    <p>b. Gestão de cookies</p>
    <p>O usuário poderá se opor ao registro de cookies pelo site, bastando que desative
        esta opção no seu próprio navegador. Mais informações sobre como fazer isso em
        alguns dos principais navegadores utilizados hoje podem ser acessadas a partir dos
        seguintes links:</p>
    <p>Internet Explorer:<br>
        https://support.microsoft.com/pt-br/help/17442/windows-internet-explorer-deletemanage-cookies</p>
    <p>Safari:<br>
        https://support.apple.com/pt-br/guide/safari/sfri11471/mac</p>
    <p>Google Chrome:<br>
        https://support.google.com/chrome/answer/95647?hl=pt-BR&hlrm=pt</p>
    <p>Mozila Firefox:<br>
        https://support.mozilla.org/pt-BR/kb/ative-e-desative-os-cookies-que-os-sites-usa3/6</p>
    <p>Opera:<br>
        https://www.opera.com/help/tutorials/security/privacy/</p>
    <p>A desativação dos cookies, no entanto, pode afetar a disponibilidade de algumas
        ferramentas e funcionalidades do site, comprometendo seu correto e esperado
        funcionamento. Outra consequência possível é remoção das preferências do usuário
        que eventualmente tiverem sido salvas, prejudicando sua experiência.</p>
    <p>4. Coleta de dados não previstos expressamente</p>
    <p>Eventualmente, outros tipos de dados não previstos expressamente nesta Política
        de Privacidade poderão ser coletados, desde que sejam fornecidos com o
        consentimento do usuário, ou, ainda, que a coleta seja permitida com fundamento
        em outra base legal prevista em lei.</p>
    <p>Em qualquer caso, a coleta de dados e as atividades de tratamento dela decorrentes
        serão informadas aos usuários do site.</p>
    <p>2. Compartilhamento de dados pessoais com terceiros</p>
    <p>Nós não compartilhamos seus dados pessoais com terceiros. Apesar disso, é
        possível que o façamos para cumprir alguma determinação legal ou regulatória, ou,
        ainda, para cumprir alguma ordem expedida por autoridade pública.</p>
    <p>3. Por quanto tempo seus dados pessoais serão armazenados</p>
    <p>Os dados pessoais coletados pelo site são armazenados e utilizados por período de
        tempo que corresponda ao necessário para atingir as finalidades elencadas neste
        documento e que considere os direitos de seus titulares, os direitos do controlador
        do site e as disposições legais ou regulatórias aplicáveis.</p>
    <p>Uma vez expirados os períodos de armazenamento dos dados pessoais, eles são
        removidos de nossas bases de dados ou anonimizados, salvo nos casos em que
        houver a possibilidade ou a necessidade de armazenamento em virtude de
        disposição legal ou regulatória.</p>
    <p>4. Bases legais para o tratamento de dados pessoais</p>
    <p>Cada operação de tratamento de dados pessoais precisa ter um fundamento
        jurídico, ou seja, uma base legal, que nada mais é que uma justificativa que a4/6
        autorize, prevista na Lei Geral de Proteção de Dados Pessoais.</p>
    <p>Todas as Nossas atividades de tratamento de dados pessoais possuem uma base
        legal que as fundamenta, dentre as permitidas pela legislação. Mais informações
        sobre as bases legais que utilizamos para operações de tratamento de dados
        pessoais específicas podem ser obtidas a partir de nossos canais de contato,
        informados ao final desta Política.</p>
    <p>5. Direitos do usuário</p>
    <p>O usuário do site possui os seguintes direitos, conferidos pela Lei de Proteção de
        Dados Pessoais:
    <p>
        - confirmação da existência de tratamento;<br>
        - acesso aos dados;<br>
        - correção de dados incompletos, inexatos ou desatualizados;<br>
        - anonimização, bloqueio ou eliminação de dados desnecessários, excessivos
        ou tratados em desconformidade com o disposto na lei;<br>
        - portabilidade dos dados a outro fornecedor de serviço ou produto, mediante
        requisição expressa, de acordo com a regulamentação da autoridade nacional,
        observados os segredos comercial e industrial;<br>
        - eliminação dos dados pessoais tratados com o consentimento do titular, exceto
        nos casos previstos em lei;<br>
        - informação das entidades públicas e privadas com as quais o controlador
        realizou uso compartilhado de dados;<br>
        - informação sobre a possibilidade de não fornecer consentimento e sobre as
        consequências da negativa;<br>
        - revogação do consentimento.<br><br>
    <p>É importante destacar que, nos termos da LGPD, não existe um direito de
        eliminação de dados tratados com fundamento em bases legais distintas do
        consentimento, a menos que os dados seja desnecessários, excessivos ou tratados
        em desconformidade com o previsto na lei.</p>
    <p>1. Como o titular pode exercer seus direitos</p>
    <p>Para garantir que o usuário que pretende exercer seus direitos é, de fato, o titular
        dos dados pessoais objeto da requisição, poderemos solicitar documentos ou outras
        informações que possam auxiliar em sua correta identificação, a fim de resguardar
        nossos direitos e os direitos de terceiros. Isto somente será feito, porém, se for
        absolutamente necessário, e o requerente receberá todas as informações
        relacionadas.</p>
    <p>6. Medidas de segurança no tratamento de dados pessoais</p>
    <p>Empregamos medidas técnicas e organizativas aptas a proteger os dados pessoais
        de acessos não autorizados e de situações de destruição, perda, extravio ou
        alteração desses dados.</p>
    <p>As medidas que utilizamos levam em consideração a natureza dos dados, o contexto
        e a finalidade do tratamento, os riscos que uma eventual violação geraria para os
        direitos e liberdades do usuário, e os padrões atualmente empregados no mercado
        por empresas semelhantes à nossa.</p>
    <p>Entre as medidas de segurança adotadas por nós, destacamos as seguintes:</p>
    Armazenamentos de senhas utilizando hashes critográficos.<br>
    <p>Ainda que adote tudo o que está ao seu alcance para evitar incidentes de
        segurança, é possível que ocorra algum problema motivado exclusivamente por um
        terceiro - como em caso de ataques de hackers ou crackers ou, ainda, em caso de
        culpa exclusiva do usuário, que ocorre, por exemplo, quando ele mesmo transfere
        seus dados a terceiro. Assim, embora sejamos, em geral, responsáveis pelos dados
        pessoais que tratamos, nos eximimos de responsabilidade caso ocorra uma situação
        excepcional como essas, sobre as quais não temos nenhum tipo de controle.</p>
    <p>De qualquer forma, caso ocorra qualquer tipo de incidente de segurança que possa
        gerar risco ou dano relevante para qualquer de nossos usuários, comunicaremos os
        afetados e a Autoridade Nacional de Proteção de Dados acerca do ocorrido, em
        conformidade com o disposto na Lei Geral de Proteção de Dados.</p>
    <p>7. Reclamação a uma autoridade de controle</p>
    <p>Sem prejuízo de qualquer outra via de recurso administrativo ou judicial, os titulares
        de dados pessoais que se sentirem, de qualquer forma, lesados, podem apresentar
        reclamação à Autoridade Nacional de Proteção de Dados.</p>
    <p>8. Alterações nesta política</p>
    A presente versão desta Política de Privacidade foi atualizada pela última vez em:
    20/02/2022.
    <p>Reservamo-nos o direito de modificar, a qualquer momento, as presentes normas,
        especialmente para adaptá-las às eventuais alterações feitas em nosso site, seja
        pela disponibilização de novas funcionalidades, seja pela supressão ou modificação
        daquelas já existentes.</p>
    <p>Sempre que houver uma modificação, nossos usuários serão notificados acerca da
        mudança.</p>
    <!-- <p>9. Como entrar em contato conosco</p>
    <p>Para esclarecer quaisquer dúvidas sobre esta Política de Privacidade ou sobre os
        dados pessoais que tratamos, entre em contato com nosso Encarregado de
        Proteção de Dados Pessoais, por algum dos canais mencionados abaixo:</p>
    E-mail: wmendesprog@gmail.com<br>
    Telefone: +55(85)99141-5641<br>
    Endereço postal: Rua Cicero Nogueira, 260, Cruz das Almas, Pacajus-CE, CEP
    62870-000 -->
    <br>
    <form action="<?= $baseUri ?>/termo-privacidade" method="post" class="form-control" name="form_privacidade" style="height: 160px;">
        <input type="hidden" name="cliente_id" value="<?= $_SESSION['__CLIENTE__ID__'] ?>">
        <input type="hidden" name="cliente_politica_privacidade_data" value="<?= date('Y-m-d H:i:s') ?>">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="cliente_marketing_whatssapp" value="1" style="position: static !important;"> Aceito receber mensagens de marketing via whatsapp.
            </label>
            <label>
                <input type="checkbox" name="cliente_politica_privacidade" value="1" required style="position: static !important;"> Eu li e concordo com os termos de uso.
            </label>
        </div>
        <center><button type="submit" class="btn btn-success">Continuar</button></center>
    </form>    
</body>

</html>