<?php if (empty($embeddedShopDetail)): ?>
<section class="section mrd600-hero">
    <div class="mrd600-hero-copy">
        <a class="product-back-link" href="/catalogo">Voltar ao catálogo</a>
        <p class="eyebrow">Linha MRD600</p>
        <h1>Inversor compacto para máquinas, bombas, ventiladores e automação industrial.</h1>
        <p>O MRD600 combina instalação compacta, controle V/F e SVC, entradas programáveis, comunicação RS485 Modbus e recursos integrados para operações industriais de rotina.</p>
        <div class="mrd600-hero-actions">
            <a class="btn btn-whatsapp" href="https://wa.me/<?= e($whatsapp) ?>?text=Tenho%20interesse%20no%20MRD600" target="_blank"><span class="wa-icon" aria-hidden="true">W</span>Solicitar orçamento</a>
            <a class="btn btn-secondary" href="<?= asset('img/mrd600/MRD600.pdf') ?>" target="_blank">Baixar catálogo técnico</a>
            <a class="btn btn-secondary" href="<?= asset('img/mrd600/mrd600_guia_rapido.pdf') ?>" target="_blank">Baixar guia rápido</a>
        </div>
    </div>
    <div class="mrd600-hero-media">
        <img class="mrd600-main-product" src="<?= optimized_image_url('assets/img/mrd600/nova-foto-18.jpg') ?>" alt="Inversor MRD600" decoding="async">
        <div class="mrd600-hero-badges">
            <span>0,4 a 7,5 kW</span>
            <span>220V / 380V</span>
            <span>RS485 Modbus</span>
        </div>
    </div>
</section>

<section class="section mrd600-gallery-section">
    <div class="mrd600-gallery">
        <img src="<?= optimized_image_url('assets/img/mrd600/mrd600.png') ?>" alt="MRD600 vista frontal" loading="lazy" decoding="async">
        <img src="<?= optimized_image_url('assets/img/mrd600/mrd600_3.png') ?>" alt="MRD600 detalhe do produto" loading="lazy" decoding="async">
        <img src="<?= optimized_image_url('assets/img/mrd600/mrd600_4.png') ?>" alt="MRD600 em perspectiva" loading="lazy" decoding="async">
        <img src="<?= optimized_image_url('assets/img/mrd600/mrd600_5.png') ?>" alt="MRD600 linha de inversores" loading="lazy" decoding="async">
    </div>
</section>
<?php endif; ?>

<section class="section mrd600-voltage-section" aria-labelledby="mrd600-voltage-title">
    <div class="section-heading"><div><p class="eyebrow">Versões disponíveis</p><h2 id="mrd600-voltage-title">Tensões de entrada e saída.</h2></div></div>
    <div class="mrd600-voltage-wrap" tabindex="0" role="region" aria-label="Tabela de tensões por modelo MRD600">
        <table class="mrd600-voltage-table">
            <thead><tr><th scope="col">Modelo</th><th scope="col">Tensão de entrada</th><th scope="col">Tensão de saída</th></tr></thead>
            <tbody>
                <tr><th scope="row">MRD600M-2S</th><td>Monofásica 220 VCA (180–280 VCA)</td><td>Trifásica 220 VCA</td></tr>
                <tr><th scope="row">MRD600M-2T</th><td>Trifásica 220 VCA (180–280 VCA)</td><td>Trifásica 220 VCA</td></tr>
                <tr><th scope="row">MRD600M-4T</th><td>Trifásica 380 VCA (±20%)</td><td>Trifásica de 0 a 380 VCA</td></tr>
                <tr><th scope="row">MRD600M-2S4T</th><td>Monofásica 220 VCA</td><td>Trifásica de 0 a 380 VCA</td></tr>
            </tbody>
        </table>
    </div>
    <p class="mrd600-voltage-note">As tensões variam conforme a versão do equipamento. Selecione o modelo de acordo com a rede de alimentação e a tensão do motor.</p>
</section>

<section class="section mrd600-feature-section">
    <div class="section-heading"><div><p class="eyebrow">Características do produto</p><h2>Pequeno em tamanho, poderoso em desempenho.</h2></div></div>
    <figure class="mrd600-resource-image"><img src="<?= optimized_image_url('assets/img/mrd600/mrd600-recursos.jpeg') ?>" alt="Recursos do MRD600: montagem em paralelo, aterramento EMC, dissipação de calor e proteção dos componentes" loading="lazy" decoding="async"></figure>
</section>

<section class="section mrd600-spec-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Detalhes técnicos</p>
            <h2>Base técnica do MRD600.</h2>
        </div>
        <a class="btn btn-secondary" href="<?= asset('img/mrd600/MRD600.pdf') ?>" target="_blank">Abrir PDF completo</a>
    </div>
    <div class="mrd600-spec-table-wrap">
        <table class="mrd600-spec-table">
            <tbody>
                <tr><th>Tensão de entrada</th><td><strong>208~240V monofásico e trifásico</strong><br>380~440V trifásico</td></tr>
                <tr><th>Frequência de saída</th><td>0~600Hz</td></tr>
                <tr><th>Tecnologia de controle</th><td>V/F, SVC, Controle de Torque</td></tr>
                <tr><th>Torque inicial</th><td>0,5Hz 150% (V/F), 0,25Hz 180% (SVC)</td></tr>
                <tr><th>Velocidade / precisao</th><td>± 0,5% (V/F), ± 0,2% (SVC)</td></tr>
                <tr><th>Resposta de torque</th><td>&lt; 10ms (SVC)</td></tr>
                <tr><th>Capacidade de sobrecarga</th><td>150% da corrente nominal por 60s<br>180% da corrente nominal por 10s<br>200% da corrente nominal por 1s</td></tr>
                <tr><th>CLP simples</th><td>Controle de velocidade de até 16 niveis, 5 entradas digitais compatíveis com NPN/PNP, 2 entradas analógicas e 2 saídas analógicas.</td></tr>
                <tr><th>Comunicação</th><td>MODBUS RS485</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="section mrd600-diagram-section">
    <div class="mrd600-diagram-grid">
        <article>
            <p class="eyebrow">Ligação e terminais</p>
            <h2>Diagrama elétrico de referência.</h2>
            <img src="<?= optimized_image_url('assets/img/mrd600/modelomrd600_2.png') ?>" alt="Diagrama elétrico MRD600" loading="lazy" decoding="async">
        </article>
    </div>
</section>

<section class="section mrd600-models-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Tabela de modelos</p>
            <h2>Modelos e dimensões do MRD600.</h2>
        </div>
        <a class="text-link" href="/#contato" data-product="MRD600">Solicitar dimensionamento</a>
    </div>
    <div class="mrd600-model-table-wrap">
        <table class="mrd600-model-table">
            <thead><tr><th scope="col">Modelo</th><th scope="col">Altura (mm)</th><th scope="col">Largura (mm)</th><th scope="col">Profundidade (mm)</th></tr></thead>
            <tbody>
                <?php foreach (json_decode((string) file_get_contents(base_path('config/mrd600-dimensions.json')), true) as [$model, $height, $width, $depth]): ?>
                <tr><th scope="row"><?= e($model) ?></th><td><?= (int) $height ?></td><td><?= (int) $width ?></td><td><?= (int) $depth ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<p><a class="text-link" href="/assets/documents/MRD600M-modelos-e-dimensoes.xlsx" download>Baixar tabela de modelos e dimensões (Excel)</a></p>
</section>

<?php if (empty($embeddedShopDetail)): ?>
<section class="section mrd600-cta-section">
    <div>
        <p class="eyebrow">Aplicação assistida</p>
        <h2>Quer confirmar o modelo antes de comprar?</h2>
        <p>Envie potência do motor, tensão, aplicação e regime de trabalho. A equipe MRDRIVES indica o MRD600 adequado para sua instalação.</p>
    </div>
    <div class="mrd600-cta-actions">
        <a class="btn btn-whatsapp" href="https://wa.me/<?= e($whatsapp) ?>?text=Quero%20dimensionar%20um%20MRD600" target="_blank"><span class="wa-icon" aria-hidden="true">W</span>Chamar no WhatsApp</a>
        <a class="btn btn-secondary" href="/ticket">Enviar dados técnicos</a>
    </div>
</section>
<?php endif; ?>
