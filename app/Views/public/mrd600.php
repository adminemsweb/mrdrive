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
        <img class="mrd600-main-product" src="<?= asset('img/mrd600/mrd600_2.png') ?>" alt="Inversor MRD600">
        <div class="mrd600-hero-badges">
            <span>0,4 a 15 kW</span>
            <span>220V / 380V</span>
            <span>RS485 Modbus</span>
        </div>
    </div>
</section>

<section class="section mrd600-gallery-section">
    <div class="mrd600-gallery">
        <img src="<?= asset('img/mrd600/mrd600.png') ?>" alt="MRD600 vista frontal">
        <img src="<?= asset('img/mrd600/mrd600_3.png') ?>" alt="MRD600 detalhe do produto">
        <img src="<?= asset('img/mrd600/mrd600_4.png') ?>" alt="MRD600 em perspectiva">
        <img src="<?= asset('img/mrd600/mrd600_5.png') ?>" alt="MRD600 linha de inversores">
    </div>
</section>

<section class="section mrd600-feature-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Características do produto</p>
            <h2>Compacto, comunicável e pronto para aplicações industriais.</h2>
        </div>
    </div>
    <div class="mrd600-feature-grid">
        <?php foreach ([
            ['01', 'Design compacto', 'Adequado para espacos de instalação limitados, como embalagens, máquinas de rotulagem e esteiras transportadoras.'],
            ['02', 'Teclado emborrachado', 'Interface projetada para facilitar a operação diária e o acesso rápido aos comandos.'],
            ['03', 'Teclado externo', 'Flexível para montagem em painel e operação remota conforme a necessidade da máquina.'],
            ['04', 'Software para PC', 'Configuração com um único clique, economizando tempo de depuração e parametrização.'],
            ['05', 'Filtro EMC C3', 'Maior capacidade anti-interferência eletromagnética para ambientes industriais.'],
            ['06', 'Dutos independentes', 'Melhor dissipação de calor e manutenção mais fácil.'],
            ['07', 'DI/DO/AI programáveis', 'Entradas e saídas programáveis com RS485 Modbus RTU e ASCII para comunicação com dispositivos.'],
            ['08', 'PID integrado', 'Controle de processo direto no inversor para bombas, ventilação e controle de vazão/pressão.'],
            ['09', 'Múltiplas velocidades', 'Função integrada para operação em diferentes velocidades conforme o processo.'],
            ['10', 'Modo de sobreposição', 'Suporte ao modo de sobreposição de disparo para estratégias específicas de acionamento.'],
        ] as $feature): ?>
            <article>
                <span><?= e($feature[0]) ?></span>
                <h3><?= e($feature[1]) ?></h3>
                <p><?= e($feature[2]) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
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
                <tr><th>Tensão de entrada</th><td><strong>208~240V monofásico e trifásico</strong><br>380~480V trifásico</td></tr>
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
            <img src="<?= asset('img/mrd600/modelomrd600.png') ?>" alt="Diagrama elétrico MRD600">
        </article>
        <article>
            <p class="eyebrow">Dimensão do modelo</p>
            <h2>Medidas para painel e montagem.</h2>
            <img src="<?= asset('img/mrd600/modelomrd600_2.png') ?>" alt="Dimensões mecanicas MRD600">
        </article>
    </div>
</section>

<section class="section mrd600-models-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Tabela de modelos</p>
            <h2>Seleção por tensão, potência e dimensões.</h2>
        </div>
        <a class="text-link" href="/#contato" data-product="MRD600">Solicitar dimensionamento</a>
    </div>
    <div class="mrd600-model-table-wrap">
        <table class="mrd600-model-table">
            <thead>
                <tr>
                    <th>Modelo de acionamento CA</th>
                    <th>Motor (kW)</th>
                    <th>Corrente entrada (A)</th>
                    <th>Saída nominal (A)</th>
                    <th>D</th>
                    <th>C</th>
                    <th>H</th>
                </tr>
            </thead>
            <tbody>
                <tr class="group"><td colspan="7">Tensão de entrada: monofásica 220V. Faixa de tensão: -15% a 20%.</td></tr>
                <tr><td>MRD600-2S-0.4G</td><td>0,4</td><td>5.4</td><td>2.3</td><td>107</td><td>83</td><td>149</td></tr>
                <tr><td>MRD600-2S-0,7G</td><td>0,7</td><td>8.2</td><td>4</td><td>107</td><td>83</td><td>149</td></tr>
                <tr><td>MRD600-2S-1.5G</td><td>1,5</td><td>14.0</td><td>7</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD600-2S-2.2G</td><td>2.2</td><td>23.0</td><td>9,6</td><td>120</td><td>98</td><td>170</td></tr>
                <tr class="group"><td colspan="7">Tensão de entrada: trifásica 220V. Faixa: -15%~20%.</td></tr>
                <tr><td>MRD600-2T-0.4G</td><td>0,4</td><td>2.7</td><td>2.3</td><td>107</td><td>83</td><td>149</td></tr>
                <tr><td>MRD600-2T-0,7G</td><td>0,7</td><td>4.2</td><td>4</td><td>107</td><td>83</td><td>149</td></tr>
                <tr><td>MRD600-2T-1.5G</td><td>1,5</td><td>7,7</td><td>7</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD600-2T-2.2G</td><td>2.2</td><td>12</td><td>9,6</td><td>120</td><td>98</td><td>170</td></tr>
                <tr class="group"><td colspan="7">Tensão de entrada: trifásica 380V. Faixa: -15%~20%.</td></tr>
                <tr><td>MRD600-4T-0,7G</td><td>0,7</td><td>3,4/5,0</td><td>2.1/3.8</td><td>107</td><td>83</td><td>149</td></tr>
                <tr><td>MRD600-4T-1.5G</td><td>1,5</td><td>5,0/5,8</td><td>3.8/5.1</td><td>107</td><td>83</td><td>149</td></tr>
                <tr><td>MRD600-4T-2.2G</td><td>2.2</td><td>5,8/10,5</td><td>5.1/9.0</td><td>107</td><td>83</td><td>149</td></tr>
                <tr><td>MRD600-4T-4.0G</td><td>4.0</td><td>10,5/14,6</td><td>9,0/13,0</td><td>124</td><td>98</td><td>170</td></tr>
                <tr><td>MRD600-4T-5.5G</td><td>5,5</td><td>14,6/20,5</td><td>13,0/17,0</td><td>124</td><td>98</td><td>170</td></tr>
                <tr><td>MRD600-4T-7.5G</td><td>7,5</td><td>20,5/22,0</td><td>17,0/20,0</td><td>124</td><td>98</td><td>170</td></tr>
                <tr><td>MRD600-4T-11.0G</td><td>11.0</td><td>26,0/35,0</td><td>25,0/32,0</td><td>160</td><td>135</td><td>228</td></tr>
                <tr><td>MRD600-4T-15.0G</td><td>15.0</td><td>35,0/38,5</td><td>32,0/37,0</td><td>160</td><td>135</td><td>228</td></tr>
            </tbody>
        </table>
    </div>
</section>

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
