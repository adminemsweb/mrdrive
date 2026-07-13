<section class="section mrd700-landing-hero">
    <div class="mrd700-hero-copy">
        <a class="product-back-link" href="/catalogo">Voltar ao catalogo</a>
        <p class="eyebrow">Linha MRD700</p>
        <h1>Inversor vetorial modular para alta performance e automacao industrial.</h1>
        <p>O MRD700 foi projetado para aplicacoes que exigem controle robusto, arquitetura modular, protocolos industriais, STO, PLC opcional e operacao em motores sincronos e assincronos.</p>
        <div class="mrd700-hero-actions">
            <a class="btn btn-whatsapp" href="https://wa.me/<?= e($whatsapp) ?>?text=Tenho%20interesse%20no%20MRD700" target="_blank"><span class="wa-icon" aria-hidden="true">W</span>Solicitar orcamento</a>
            <a class="btn btn-secondary" href="<?= asset('img/mrd700/MRD700.pdf') ?>" target="_blank">Baixar catalogo tecnico</a>
            <a class="btn btn-secondary" href="<?= asset('img/mrd700/mrd700guia_rapido.pdf') ?>" target="_blank">Baixar guia rapido</a>
        </div>
    </div>
    <div class="mrd700-hero-media">
        <img class="mrd700-main-product" src="<?= asset('img/mrd700/capa.png') ?>" alt="Inversor MRD700">
        <div class="mrd700-hero-badges">
            <span>0,4 a 1000 kW</span>
            <span>220V / 380V / 480V</span>
            <span>Modbus, Profinet, Profibus, CANopen e EtherCAT</span>
        </div>
    </div>
</section>

<section class="section mrd700-gallery-section">
    <div class="mrd700-gallery">
        <?php foreach (['089A0079.png', '089A0084.png', '089A0087.png', '089A0090.png', '089A0092.png', '089A0095.png', '089A0106.png', '089A9778.png'] as $image): ?>
            <img src="<?= asset('img/mrd700/' . $image) ?>" alt="Detalhe do inversor MRD700">
        <?php endforeach; ?>
    </div>
</section>

<section class="section mrd700-feature-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Caracteristicas do produto</p>
            <h2>Arquitetura modular, comunicacao completa e controle para processos exigentes.</h2>
        </div>
    </div>
    <div class="mrd700-feature-grid">
        <?php foreach ([
            ['01', 'Design tipo livro', 'Economiza espaco e facilita a instalacao em armarios e paineis industriais.'],
            ['02', 'Motores sincronos e assincronos', 'Suporte para combinacao sincrona e assincrona, incluindo motores sincronos de ima permanente.'],
            ['03', 'Design modular', 'Dispensa fiacao e fios de conexao tradicionais, reduzindo dificuldade de manutencao e desmontagem.'],
            ['04', 'Modulos independentes', 'Modulo de alimentacao e modulo de controle podem funcionar independentemente, reduzindo custos de estoque.'],
            ['05', 'Teclado atualizado', 'Display duplo de LED, conexao remota de ate 300 metros e suporte a LCD grande com troca de idioma.'],
            ['06', 'Reator CC', 'Reator CC integrado opcional de 37 kW a 132 kW e padrao para potencias maiores ou iguais a 160 kW.'],
            ['07', 'Frenagem integrada', 'Unidade de frenagem padrao ate 37 kW e modulo opcional de 45 kW a 160 kW.'],
            ['08', 'Entradas e saidas completas', '7 entradas digitais, 2 entradas analogicas, 2 saidas analogicas, 2 reles e terminais STO.'],
            ['09', 'Protocolos industriais', 'Modbus RS485, Profinet, Profibus-DP, CANopen, EtherCAT e placas PG.'],
            ['10', 'PLC opcional', 'Modulo PLC integrado opcional para reduzir custos de implementacao e treinamento.'],
            ['11', 'Programas especiais', 'Recursos para bomba solar, elevador, elevacao, controle de tensao e PID para agua com pressao constante.'],
        ] as $feature): ?>
            <article>
                <span><?= e($feature[0]) ?></span>
                <h3><?= e($feature[1]) ?></h3>
                <p><?= e($feature[2]) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section mrd700-spec-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Detalhes tecnicos</p>
            <h2>Especificacoes principais do MRD700.</h2>
        </div>
        <a class="btn btn-secondary" href="<?= asset('img/mrd700/MRD700.pdf') ?>" target="_blank">Abrir PDF completo</a>
    </div>
    <div class="mrd700-spec-table-wrap">
        <table class="mrd700-spec-table">
            <tbody>
                <tr><th>Tensao de entrada</th><td><strong>220~240V monofasico e trifasico</strong><br>380~480V trifasico</td></tr>
                <tr><th>Frequencia de saida</th><td>0~1200Hz V/F<br>0~600Hz FVC</td></tr>
                <tr><th>Tecnologia de controle</th><td>V/Hz, SVC1, SVC2, VC</td></tr>
                <tr><th>Capacidade de sobrecarga</th><td>150% da corrente nominal por 60s<br>180% da corrente nominal por 10s<br>200% da corrente nominal por 1s</td></tr>
                <tr><th>CLP simples</th><td>Controle de velocidade de ate 16 niveis, 7 entradas digitais compativeis com NPN/PNP, 2 entradas analogicas e 2 saidas analogicas.</td></tr>
                <tr><th>Comunicacao</th><td>MODBUS RS485, Profinet, Profibus, CANopen, EtherCAT, PG</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="section mrd700-diagram-section">
    <div class="mrd700-diagram-grid">
        <article>
            <p class="eyebrow">Ligacao e terminais</p>
            <h2>Diagrama de alimentacao, I/O, comunicacao e STO.</h2>
            <img src="<?= asset('img/mrd700/modelomrd700_2.png') ?>" alt="Diagrama eletrico MRD700">
        </article>
        <article>
            <p class="eyebrow">Modelo e tamanho</p>
            <h2>Referencias mecanicas para integracao.</h2>
            <img src="<?= asset('img/mrd700/modelomrd700.png') ?>" alt="Modelo e tamanho MRD700">
        </article>
    </div>
</section>

<section class="section mrd700-models-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Tabela de modelos</p>
            <h2>Selecao por tensao, potencia e dimensoes.</h2>
        </div>
        <a class="text-link" href="/#contato" data-product="MRD700">Solicitar dimensionamento</a>
    </div>
    <div class="mrd700-model-table-wrap">
        <table class="mrd700-model-table">
            <thead>
                <tr>
                    <th>Modelo de acionamento CA</th>
                    <th>Motor (kW)</th>
                    <th>Corrente entrada (A)</th>
                    <th>Saida nominal (A)</th>
                    <th>D</th>
                    <th>C</th>
                    <th>H</th>
                </tr>
            </thead>
            <tbody>
                <tr class="group"><td colspan="7">Tensao de entrada: monofasica 220V. Faixa de tensao: -15% a 20%.</td></tr>
                <tr><td>MRD700-2S-0.4G</td><td>0,4</td><td>5.4</td><td>2.3</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-2S-0,7G</td><td>0,7</td><td>8.2</td><td>4</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-2S-1.5G</td><td>1,5</td><td>14.0</td><td>7</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-2S-2.2G</td><td>2.2</td><td>23.0</td><td>9,6</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-2S-4.0G</td><td>4.0</td><td>40.0</td><td>17</td><td>170</td><td>98</td><td>260</td></tr>
                <tr><td>MRD700-2S-5.5G</td><td>5,5</td><td>60,0</td><td>25</td><td>187</td><td>115</td><td>310</td></tr>
                <tr><td>MRD700-2S-7.5G</td><td>7,5</td><td>75,0</td><td>32</td><td>187</td><td>115</td><td>310</td></tr>
                <tr class="group"><td colspan="7">Tensao de entrada: trifasica 220V. Faixa: -15%~20%.</td></tr>
                <tr><td>MRD700-2T-0.4G</td><td>0,4</td><td>2.7</td><td>2.3</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-2T-0,7G</td><td>0,7</td><td>4.2</td><td>3,8</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-2T-1.5G</td><td>1,5</td><td>7,7</td><td>7</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-2T-2.2G</td><td>2.2</td><td>12</td><td>9,6</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-2T-4.0G</td><td>4.0</td><td>19</td><td>17</td><td>170</td><td>98</td><td>260</td></tr>
                <tr><td>MRD700-2T-5.5G</td><td>5,5</td><td>28</td><td>25</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-7.5G</td><td>7,5</td><td>35</td><td>32</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-11G</td><td>11</td><td>47</td><td>45</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-15G</td><td>15</td><td>65</td><td>60</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-18G</td><td>18</td><td>80</td><td>75</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-22G</td><td>22</td><td>97</td><td>90</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-30G</td><td>30</td><td>115</td><td>110</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-37G</td><td>37</td><td>166</td><td>152</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-45G</td><td>45</td><td>190</td><td>176</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-55G</td><td>55</td><td>214</td><td>210</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-75G</td><td>75</td><td>307</td><td>304</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-93G</td><td>93</td><td>389</td><td>377</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-110G</td><td>110</td><td>435</td><td>426</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-132G</td><td>132</td><td>468</td><td>465</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-160G</td><td>160</td><td>590</td><td>585</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-200G</td><td>200</td><td>785</td><td>725</td><td>120</td><td>98</td><td>170</td></tr>
                <tr><td>MRD700-2T-220G</td><td>220</td><td>883</td><td>820</td><td>120</td><td>98</td><td>170</td></tr>
                <tr class="group"><td colspan="7">Tensao de entrada: trifasica 380V. Faixa: -15%~20%.</td></tr>
                <tr><td>MRD700-4T-0.7G</td><td>0,7</td><td>3,4/5,0</td><td>2.1/3.8</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-4T-1.5G</td><td>1,5</td><td>5,0/5,8</td><td>3,8/5,1</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-4T-2.2G</td><td>2.2</td><td>5,8/10,5</td><td>5.1/9.0</td><td>138</td><td>80</td><td>200</td></tr>
                <tr><td>MRD700-4T-4.0G</td><td>4.0</td><td>10,5/14,6</td><td>9,0/13,0</td><td>170</td><td>98</td><td>260</td></tr>
                <tr><td>MRD700-4T-5.5G</td><td>5,5</td><td>14,6/20,5</td><td>13,0/17,0</td><td>170</td><td>98</td><td>260</td></tr>
                <tr><td>MRD700-4T-7.5G</td><td>7,5</td><td>20,5/26,0</td><td>17,0/25,0</td><td>187</td><td>115</td><td>310</td></tr>
                <tr><td>MRD700-4T-11.0G</td><td>11.0</td><td>26,0/35,0</td><td>25,0/32,0</td><td>187</td><td>115</td><td>310</td></tr>
                <tr><td>MRD700-4T-15.0G</td><td>15.0</td><td>35,0/38,5</td><td>32,0/37,0</td><td>187</td><td>115</td><td>310</td></tr>
                <tr><td>MRD700-4T-18.5G</td><td>18.0</td><td>38,5/46,5</td><td>37,0/45,0</td><td>210</td><td>165</td><td>395</td></tr>
                <tr><td>MRD700-4T-22G</td><td>22.0</td><td>46,5/62</td><td>45,0/60</td><td>210</td><td>165</td><td>395</td></tr>
                <tr><td>MRD700-4T-30G</td><td>30.0</td><td>62/76</td><td>60/75</td><td>220</td><td>220</td><td>440</td></tr>
                <tr><td>MRD700-4T-37G</td><td>37.0</td><td>76/92</td><td>75/90</td><td>220</td><td>220</td><td>440</td></tr>
                <tr><td>MRD700-4T-45G</td><td>45.0</td><td>92/113</td><td>90/110</td><td>255</td><td>145</td><td>550</td></tr>
                <tr><td>MRD700-4T-55G</td><td>55.0</td><td>113/157</td><td>110/152</td><td>305</td><td>265</td><td>660</td></tr>
                <tr><td>MRD700-4T-75G</td><td>75.0</td><td>157/180</td><td>152/176</td><td>305</td><td>265</td><td>660</td></tr>
                <tr><td>MRD700-4T-93G</td><td>90</td><td>180/214</td><td>176/210</td><td>305</td><td>300</td><td>785</td></tr>
                <tr><td>MRD700-4T-110G</td><td>110</td><td>214/256</td><td>210/253</td><td>305</td><td>300</td><td>785</td></tr>
                <tr><td>MRD700-4T-132G</td><td>132</td><td>256/307</td><td>253/304</td><td>325</td><td>340</td><td>835</td></tr>
                <tr><td>MRD700-4T-160G</td><td>160</td><td>307/345</td><td>304/340</td><td>325</td><td>340</td><td>835</td></tr>
                <tr><td>MRD700-4T-185G</td><td>185</td><td>345/385</td><td>340/380</td><td>370</td><td>410</td><td>915</td></tr>
                <tr><td>MRD700-4T-200G</td><td>200</td><td>385/430</td><td>380/426</td><td>370</td><td>410</td><td>915</td></tr>
                <tr><td>MRD700-4T-220G</td><td>220</td><td>430/468</td><td>426/465</td><td>370</td><td>410</td><td>915</td></tr>
                <tr><td>MRD700-4T-250G</td><td>250</td><td>468/425</td><td>465/520</td><td>385</td><td>470</td><td>1015</td></tr>
                <tr><td>MRD700-4T-280G</td><td>280</td><td>525/590</td><td>520/585</td><td>385</td><td>470</td><td>1015</td></tr>
                <tr><td>MRD700-4T-315G</td><td>315</td><td>590/685</td><td>580/650</td><td>395</td><td>640</td><td>1135</td></tr>
                <tr><td>MRD700-4T-355G</td><td>355</td><td>685/785</td><td>650/725</td><td>395</td><td>640</td><td>1135</td></tr>
                <tr><td>MRD700-4T-400G</td><td>400</td><td>785/883</td><td>725/820</td><td>395</td><td>640</td><td>1135</td></tr>
                <tr><td>MRD700-4T-450G</td><td>450</td><td>883/920</td><td>820/900</td><td>395</td><td>640</td><td>1135</td></tr>
                <tr><td>MRD700-4T-500G</td><td>500</td><td>920/1020</td><td>900/1000</td><td>500</td><td>800</td><td>1800</td></tr>
                <tr><td>MRD700-4T-550G</td><td>550</td><td>1020/1120</td><td>1000/1100</td><td>500</td><td>800</td><td>1800</td></tr>
                <tr><td>MRD700-4T-630G</td><td>630</td><td>1200</td><td>1100</td><td>500</td><td>800</td><td>1800</td></tr>
                <tr><td>MRD700-4T-710G</td><td>710</td><td>1315</td><td>1250</td><td>600</td><td>1100</td><td>2200</td></tr>
                <tr><td>MRD700-4T-800G</td><td>800</td><td>1560</td><td>1450</td><td>600</td><td>1100</td><td>2200</td></tr>
                <tr><td>MRD700-4T-900G</td><td>900</td><td>1760</td><td>1710</td><td>600</td><td>1300</td><td>2300</td></tr>
                <tr><td>MRD700-4T-1000G</td><td>1000</td><td>1960</td><td>1900</td><td>600</td><td>1300</td><td>2300</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="section mrd700-cta-section">
    <div>
        <p class="eyebrow">Aplicacao assistida</p>
        <h2>Precisa de automacao, comunicacao industrial ou alta potencia?</h2>
        <p>Envie tensao, potencia do motor, protocolo de comunicacao e aplicacao. A equipe MRDRIVES valida o MRD700 correto para seu projeto.</p>
    </div>
    <div class="mrd700-cta-actions">
        <a class="btn btn-whatsapp" href="https://wa.me/<?= e($whatsapp) ?>?text=Quero%20dimensionar%20um%20MRD700" target="_blank"><span class="wa-icon" aria-hidden="true">W</span>Chamar no WhatsApp</a>
        <a class="btn btn-secondary" href="/ticket">Enviar dados tecnicos</a>
    </div>
</section>
