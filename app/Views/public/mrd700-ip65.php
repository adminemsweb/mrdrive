<section class="section mrd700ip65-hero">
    <div class="mrd700ip65-hero-copy">
        <a class="product-back-link" href="/catalogo">Voltar ao catalogo</a>
        <p class="eyebrow">Linha MRD700/IP65</p>
        <h1>Inversor industrial lavavel para agua, poeira e ambientes severos.</h1>
        <p>O MRD700/IP65 combina gabinete protegido, controle vetorial, STO, PID, PLC e comunicacao industrial para aplicacoes que exigem resistencia, limpeza e confiabilidade em campo.</p>
        <div class="mrd700ip65-hero-actions">
            <a class="btn btn-whatsapp" href="https://wa.me/<?= e($whatsapp) ?>?text=Tenho%20interesse%20no%20MRD700%2FIP65" target="_blank"><span class="wa-icon" aria-hidden="true">W</span>Solicitar orcamento</a>
            <a class="btn btn-secondary" href="<?= asset('img/mrd700/MRD700.pdf') ?>" target="_blank">Baixar catalogo tecnico</a>
            <a class="btn btn-secondary" href="<?= asset('img/mrd700/mrd700guia_rapido.pdf') ?>" target="_blank">Baixar guia rapido</a>
        </div>
    </div>
    <div class="mrd700ip65-hero-media">
        <img class="mrd700ip65-main-product" src="<?= asset('img/mrd700-ip65/mrd700ip65-transparent.png') ?>" alt="Inversor MRD700/IP65">
        <div class="mrd700ip65-hero-badges">
            <span>IP65 lavavel</span>
            <span>0,4 a 400 kW</span>
            <span>RS485, Profinet, Profibus, CANopen, EtherCAT e PG</span>
        </div>
    </div>
</section>

<section class="section mrd700ip65-gallery-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Imagens do produto</p>
            <h2>Detalhes do MRD700/IP65.</h2>
        </div>
    </div>
    <div class="mrd700ip65-gallery">
        <?php foreach (['um.jpeg', 'dois.jpeg', 'tres.jpeg', 'quatro.jpeg', 'cinco.jpeg', 'seis.jpeg', 'sete.jpeg', 'oito.jpeg'] as $image): ?>
            <img src="<?= asset('img/mrd700-ip65/' . $image) ?>" alt="Detalhe MRD700/IP65">
        <?php endforeach; ?>
    </div>
</section>

<section class="section mrd700ip65-diagram-section">
    <div class="mrd700ip65-diagram-grid">
        <article>
            <p class="eyebrow">Modelo e tamanho</p>
            <h2>Dimensoes para instalacao.</h2>
            <img src="<?= asset('img/mrd700-ip65/modelomrd700ip65.png') ?>" alt="Modelo e tamanho MRD700/IP65">
        </article>
        <article>
            <p class="eyebrow">Diagrama eletrico</p>
            <h2>Ligacao e expansao do inversor.</h2>
            <img src="<?= asset('img/mrd700-ip65/image.png') ?>" alt="Diagrama eletrico MRD700/IP65">
        </article>
    </div>
</section>

<section class="section mrd700ip65-video-section" id="mrd700-video">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Video do produto</p>
            <h2>Veja o MRD700/IP65 operando em contato com agua.</h2>
        </div>
        <p>Esse video mostra a proposta do modelo IP65: protecao para instalacoes sujeitas a poeira, umidade e rotinas de limpeza.</p>
    </div>
    <div class="mrd700ip65-video-card">
        <video src="<?= asset('img/videos/mrd700ip65.mp4') ?>" controls playsinline preload="metadata" poster="<?= asset('img/mrd700-ip65/mrip65banner.png') ?>"></video>
    </div>
</section>

<section class="section mrd700ip65-overview-section">
    <div class="mrd700ip65-overview">
        <article>
            <p>O inversor MRD700/IP65 e uma solucao inovadora, fruto de mais de dez anos de experiencia em pesquisa e desenvolvimento. Sua configuracao padrao inclui painel LED com dupla exibicao de parametros e painel LCD com suporte a varios idiomas.</p>
            <p>O design permite troca rapida de parametros entre softwares dedicados para bombas d'agua fotovoltaicas, motores sincronos, motores assincronos, elevadores e guindastes.</p>
        </article>
        <article>
            <p>Em hardware, o MRD700/IP65 foi projetado com 7 terminais multifuncionais, 2 conjuntos de entrada AI, 2 saidas de rele e saida AO, alem da funcao de seguranca STO.</p>
            <p>A estrutura modulariza placa de controle e placa de alimentacao, facilitando manutencao e substituicao de acessorios.</p>
        </article>
        <article>
            <p>Em comunicacao e expansao, suporta placas convencionais como PROFIBUS, PROFINET, CANopen, EtherCAT, MODBUS TCP e placas PG, permitindo integracao com sistemas de automacao industrial.</p>
        </article>
    </div>
</section>

<section class="section mrd700ip65-feature-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Caracteristicas do produto</p>
            <h2>Protecao IP65, controle forte e manutencao mais simples.</h2>
        </div>
    </div>
    <div class="mrd700ip65-feature-grid">
        <?php foreach ([
            ['01', 'Agua e poeira', 'Alto desempenho a prova d\'agua e poeira para ambientes adversos.'],
            ['02', 'Material resistente', 'ABS retardante de chamas e pintura metalica resistente a corrosao.'],
            ['03', 'PT100/PT1000', 'Entrada analogica para sensor de temperatura PT100 e PT1000.'],
            ['04', 'Capacitor robusto', 'Capacitor embutido de alta qualidade de 105C a 10000H para maior vida util.'],
            ['05', 'Dissipacao independente', 'Resfriamento a ar mais eficiente e conveniente para limpeza e manutencao.'],
            ['06', 'Alto torque', 'Saida de 0,1s com protecao de curva de corrente de 200%.'],
            ['07', 'PID e PLC', 'Funcoes PID e PLC para sistemas de controle inteligentes.'],
            ['08', 'Protecoes completas', 'Protecao contra perda de fase, tensao, corrente, motor e acionamento.'],
            ['09', 'SVC e V/F', 'Controle de motor potente compativel com SVC e controle V/F.'],
            ['10', 'Parametros poderosos', 'Milhares de grupos de configuracoes de parametros.'],
            ['11', 'Ampla faixa de tensao', 'Faixa de -15% a +20%, adequada para diversas ocasioes.'],
        ] as $feature): ?>
            <article>
                <span><?= e($feature[0]) ?></span>
                <h3><?= e($feature[1]) ?></h3>
                <p><?= e($feature[2]) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section mrd700ip65-spec-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Detalhes tecnicos</p>
            <h2>Base eletrica e comunicacao do MRD700/IP65.</h2>
        </div>
        <a class="btn btn-secondary" href="<?= asset('img/mrd700/MRD700.pdf') ?>" target="_blank">Abrir PDF completo</a>
    </div>
    <div class="mrd700ip65-spec-table-wrap">
        <table class="mrd700ip65-spec-table">
            <tbody>
                <tr><th>Tensao de entrada</th><td><strong>380V-480V trifasico</strong></td></tr>
                <tr><th>Tensao de saida</th><td>0~480V trifasico</td></tr>
                <tr><th>Frequencia de saida</th><td>0~1200Hz V/F<br>0~600Hz FVC</td></tr>
                <tr><th>Tecnologia de controle</th><td>V/F, FVC, SVC, Controle de Torque</td></tr>
                <tr><th>Capacidade de sobrecarga</th><td>150% da corrente nominal por 60s<br>180% da corrente nominal por 10s<br>250% da corrente nominal por 1s</td></tr>
                <tr><th>PLC simples</th><td>Controle de velocidade de ate 16 niveis.</td></tr>
                <tr><th>Entradas digitais</th><td>5 entradas digitais compativeis com NPN e PNP.</td></tr>
                <tr><th>Entradas analogicas</th><td>2 entradas analogicas: AI1 -10V~10V; AI2 -10V~10V, 0~20mA e sensor PT100/PT1000.</td></tr>
                <tr><th>Saidas</th><td>1 saida analogica 0~20mA ou 0~10V, 1 FM, 1 rele e 1 DO.</td></tr>
                <tr><th>Comunicacao</th><td>MODBUS RS485, Profinet, Profibus, CANopen, EtherCAT, PG</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="section mrd700ip65-models-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Tabela de modelos</p>
            <h2>Familia IP65 por alimentacao, potencia e dimensoes.</h2>
        </div>
        <a class="text-link" href="/#contato" data-product="MRD700/IP65">Solicitar dimensionamento</a>
    </div>
    <div class="mrd700ip65-model-table-wrap">
        <table class="mrd700ip65-model-table">
            <thead>
                <tr><th>Modelo</th><th>kW</th><th>W1</th><th>H1</th><th>W</th><th>H</th><th>D</th><th>d</th></tr>
            </thead>
            <tbody>
                <tr class="group"><td colspan="8">2S - Entrada monofasica 220V. Faixa: -15%~20%.</td></tr>
                <tr><td>MRD700/IP65-2S-0.4GB</td><td>0.4</td><td>93</td><td>263</td><td>110</td><td>272</td><td>150</td><td>5</td></tr>
                <tr><td>MRD700/IP65-2S-0.75GB</td><td>0.75</td><td>93</td><td>263</td><td>110</td><td>272</td><td>150</td><td>5</td></tr>
                <tr><td>MRD700/IP65-2S-1.5GB</td><td>1.5</td><td>93</td><td>263</td><td>110</td><td>272</td><td>150</td><td>5</td></tr>
                <tr><td>MRD700/IP65-2S-2.2GB</td><td>2.2</td><td>93</td><td>263</td><td>110</td><td>272</td><td>150</td><td>5</td></tr>
                <tr><td>MRD700/IP65-2S-4.0GB</td><td>4.0</td><td>128</td><td>289</td><td>146</td><td>300</td><td>166</td><td>6</td></tr>
                <tr><td>MRD700/IP65-2S-5.5GB</td><td>5.5</td><td>149</td><td>330</td><td>170</td><td>345</td><td>215</td><td>6</td></tr>
                <tr><td>MRD700/IP65-2S-7.5GB</td><td>7.5</td><td>149</td><td>330</td><td>170</td><td>345</td><td>215</td><td>6</td></tr>
                <tr class="group"><td colspan="8">2T - Entrada trifasica 220V. Faixa: -15%~20%.</td></tr>
                <tr><td>MRD700/IP65-2T-0.4GB</td><td>0.4</td><td>93</td><td>263</td><td>110</td><td>272</td><td>150</td><td>5</td></tr>
                <tr><td>MRD700/IP65-2T-7.5GB</td><td>7.5</td><td>149</td><td>330</td><td>170</td><td>345</td><td>215</td><td>6</td></tr>
                <tr><td>MRD700/IP65-2T-22G(B)</td><td>22</td><td>210</td><td>587</td><td>280</td><td>600</td><td>320</td><td>7</td></tr>
                <tr><td>MRD700/IP65-2T-75G</td><td>75</td><td>250</td><td>1085</td><td>390</td><td>1105</td><td>375</td><td>12</td></tr>
                <tr class="group"><td colspan="8">4T - Entrada trifasica 380V. Faixa: -15%~20%.</td></tr>
                <tr><td>MRD700/IP65-4T-0.7GB</td><td>0.7</td><td>93</td><td>263</td><td>110</td><td>272</td><td>150</td><td>5</td></tr>
                <tr><td>MRD700/IP65-4T-7.5GB</td><td>7.5</td><td>149</td><td>330</td><td>170</td><td>345</td><td>215</td><td>6</td></tr>
                <tr><td>MRD700/IP65-4T-75G(B)</td><td>75</td><td>250</td><td>1085</td><td>390</td><td>1105</td><td>375</td><td>12</td></tr>
                <tr><td>MRD700/IP65-4T-400G</td><td>400</td><td>590</td><td>1380</td><td>685</td><td>1400</td><td>430</td><td>12</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="section mrd700ip65-cta-section">
    <div>
        <p class="eyebrow">Aplicacao assistida</p>
        <h2>Vai instalar em ambiente com lavagem, poeira ou umidade?</h2>
        <p>Envie potencia, tensao, tipo de carga e condicoes do ambiente para validar o MRD700/IP65 correto.</p>
    </div>
    <div class="mrd700ip65-cta-actions">
        <a class="btn btn-whatsapp" href="https://wa.me/<?= e($whatsapp) ?>?text=Quero%20dimensionar%20um%20MRD700%2FIP65" target="_blank"><span class="wa-icon" aria-hidden="true">W</span>Chamar no WhatsApp</a>
        <a class="btn btn-secondary" href="/ticket">Enviar dados tecnicos</a>
    </div>
</section>
