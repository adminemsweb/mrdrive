<?php use App\Core\Csrf; ?>
<section class="hero hero-premium">
    <div class="hero-bg-banner" aria-hidden="true"></div>
    <div class="hero-orbit orbit-one"></div>
    <div class="hero-orbit orbit-two"></div>
    <div class="hero-copy">
        <p class="eyebrow">MRDRIVES automação industrial</p>
        <h1><span>Inversores <br class="hero-mobile-break">industriais</span> com presença, <br class="hero-mobile-break">proteção <br class="hero-mobile-break">e controle.</h1>
        <p class="lead">Linha MRDRIVES para controle de motores.<br>MRD600 e MRD700 para automação industrial.<br>Atendimento técnico para escolher o equipamento certo.</p>
        <div class="actions hero-actions">
            <a class="btn btn-whatsapp" href="#contato">Solicitar cotação rápida</a>
            <a class="btn btn-ghost" href="/catalogo">Conhecer produtos</a>
        </div>
    </div>
    <div class="hero-visual" aria-label="Imagem real dos inversores MRDRIVES">
        <div class="hero-device-stage">
            <div class="device-glow"></div>
            <img class="hero-product-photo hero-product-original hero-product-line hero-product-banner" src="<?= asset('img/mrd600/mrd600.png') ?>" alt="Linha de inversores industriais MRDRIVES">
            <div class="floating-panel panel-a"><strong>MRD600</strong><span>linha compacta</span></div>
            <div class="floating-panel panel-b"><strong>MRD700</strong><span>automação e expansão</span></div>
        </div>
    </div>
    <div class="hero-metrics">
        <div><strong>Rede 220V</strong><span>0.4 kW até 5.5 kW</span></div>
        <div><strong>Rede 380V</strong><span>0.4 kW até 7.5 kW</span></div>
        <div><strong>MRD700</strong><span>expansão e protocolos</span></div>
    </div>
</section>

<section class="section visual-proof">
    <div class="visual-carousel visual-banner-only" aria-label="Banner institucional MRDRIVES">
        <img src="<?= asset('img/banner.png') ?>?v=<?= filemtime(public_path('assets/img/banner.png')) ?>" alt="Linha MRDRIVES para automação industrial">
    </div>
</section>

<section class="section mrd-home-video" id="mrd700-lavavel">
    <div class="mrd-home-video-copy">
        <p class="eyebrow">MRD700/IP65 lavável</p>
        <h2>Controle industrial protegido para ambientes com poeira, umidade e lavagem.</h2>
        <p>Conheça o modelo lavável da MRDRIVES: gabinete IP65, operação robusta e recursos completos para aplicações severas que precisam de proteção sem abrir mão de automação.</p>
        <div class="actions">
            <a class="btn btn-whatsapp" href="#contato">Solicitar orçamento</a>
            <a class="btn btn-secondary" href="/mrd700-ip65">Ver página do MRD700/IP65</a>
        </div>
    </div>
    <div class="mrd-home-video-frame">
        <video src="<?= asset('img/videos/mrd700ip65.mp4') ?>" controls playsinline preload="metadata" poster="<?= asset('img/mrd700-ip65/mrip65banner.png') ?>"></video>
    </div>
</section>

<section class="trust-band">
    <div><span class="mini-emoji">01</span><strong>Dimensionamento técnico</strong><span>Indicação do modelo correto para motor, tensão e carga.</span></div>
    <div><span class="mini-emoji">02</span><strong>Controle de consumo</strong><span>Ajuste de velocidade em cargas variáveis.</span></div>
    <div><span class="mini-emoji">03</span><strong>Operação protegida</strong><span>Partida suave, proteção e previsibilidade.</span></div>
    <div><span class="mini-emoji">04</span><strong>Suporte comercial</strong><span>Atendimento para orçamento e aplicação.</span></div>
</section>

<section class="section engineered" id="beneficios">
    <div>
        <p class="eyebrow">Por que aplicar</p>
        <h2>Energia controlada, equipamento protegido e produção mais estável.</h2>
        <p>Os inversores MRDRIVES ajustam velocidade e torque conforme a demanda real. Isso evita partidas agressivas, reduz consumo em cargas variáveis e ajuda a manter a linha operando com previsibilidade.</p>
    </div>
    <div class="benefit-stack">
        <?php foreach ([
            ['Controle de consumo', 'Motor opera conforme a demanda, sem potência desperdicada.'],
            ['Partida suave', 'Rampas configuráveis reduzem impacto mecânico e elétrico.'],
            ['Proteções integradas', 'Monitoramento contra sobrecarga, falhas e operação severa.'],
            ['Aplicação assistida', 'Suporte para escolher o modelo e parametrizar corretamente.'],
        ] as $benefit): ?>
            <article>
                <span></span>
                <strong><?= e($benefit[0]) ?></strong>
                <p><?= e($benefit[1]) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section technical-band" id="especificacoes">
    <div class="technical-card">
        <p class="eyebrow">Ficha técnica</p>
        <h2>Modelos para diferentes cenários industriais.</h2>
        <dl>
            <dt>MRD600</dt><dd>220V / 380V para máquinas, bombas e ventiladores</dd>
            <dt>MRD700</dt><dd>Expansão PLC, comunicação industrial e automação</dd>
            <dt>Controle</dt><dd>Vetorial, V/F, SVC e recursos conforme modelo</dd>
            <dt>Atendimento</dt><dd>Orçamento sob consulta e dimensionamento técnico</dd>
        </dl>
    </div>
    <div class="technical-list">
        <?php foreach (['Controle vetorial', 'Expansão PLC', 'Comunicação industrial', 'Proteções integradas', 'Suporte técnico especializado', 'Dimensionamento por aplicação'] as $item): ?>
            <article><span></span><?= e($item) ?></article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section application-showcase" id="aplicacoes">
    <p class="eyebrow">Aplicações industriais</p>
    <h2>Construído para ambientes industriais reais.</h2>
    <div class="photo-grid">
        <img class="photo-large" src="<?= asset('img/mrd600/mrd600.png') ?>" alt="Linha de inversores MRDRIVES">
        <img class="photo-small" src="<?= asset('img/mrd700-ip65/mrd700ip65-transparent.png') ?>" alt="Inversor MRD700/IP65 lavável">
        <img class="photo-small" src="<?= asset('img/mrd700/mr.jpg') ?>" alt="Módulos de comunicação MR700">
    </div>
    <div class="application-detail-grid">
        <?php foreach ([
            ['Esteiras transportadoras', 'Controle de velocidade, partida suave e redução de trancos mecânicos.'],
            ['Ventiladores e exaustores', 'Ajuste fino de vazão para reduzir consumo em cargas variáveis.'],
            ['Bombas de recalque', 'PID, proteção do motor e operação mais estável em pressão e vazão.'],
            ['Máquinas industriais', 'Torque controlado, rampas configuráveis e integração com automação.'],
            ['Linha MRD700', 'Expansão PLC, protocolos industriais e integração com automação.'],
            ['Comunicação industrial', 'Modbus, EtherCAT, Profinet, Profibus e CANopen conforme projeto.'],
        ] as $app): ?>
            <article class="application-detail-card"><span></span><strong><?= e($app[0]) ?></strong><p><?= e($app[1]) ?></p></article>
        <?php endforeach; ?>
    </div>
    <div class="application-grid">
        <?php foreach (['Esteiras transportadoras', 'Ventiladores e exaustores', 'Máquinas industriais', 'Máquinas têxteis', 'Bombas de recalque', 'Máquinas de marcenaria', 'Sistemas de embalagem'] as $app): ?>
            <article class="application-card"><span></span><?= e($app) ?></article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section download-section" id="guias">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Guias e materiais</p>
            <h2>Baixe ou solicite materiais técnicos por linha.</h2>
        </div>
        <a class="btn btn-secondary" href="#contato">Pedir catálogo completo</a>
    </div>
    <div class="guide-card-grid">
        <?php foreach ([
            [
                'line' => 'MRD600',
                'image' => asset('img/mrd600/capatecnico600.png'),
                'alt' => 'Capa do guia técnico MRD600',
                'description' => 'Materiais para consulta técnica, instalação, parametrização e uso inicial da linha MRD600.',
                'links' => [
                    ['Guia técnico MRD600', 'PDF completo do produto com capa, linha e principais informações comerciais.', 'Baixar PDF', asset('img/mrd600/MRD600.pdf')],
                    ['Guia rápido MRD600', 'Consulta rápida de instalação, parametrização e uso inicial.', 'Baixar guia rápido', asset('img/mrd600/mrd600_guia_rapido.pdf')],
                ],
            ],
            [
                'line' => 'MRD700',
                'image' => asset('img/mrd700/capatecnicamrd700.png'),
                'alt' => 'Capa do guia técnico MRD700',
                'description' => 'Materiais para aplicações da linha MRD700, expansão de automação e configuração inicial.',
                'links' => [
                    ['Guia técnico MRD700', 'PDF completo do produto com capa e informações da linha MRD700.', 'Baixar PDF', asset('img/mrd700/MRD700.pdf')],
                    ['Guia rápido MRD700', 'Guia rápido para consulta de instalação, parametrização e uso inicial.', 'Baixar guia rápido', asset('img/mrd700/mrd700guia_rapido.pdf')],
                ],
            ],
        ] as $guideCard): ?>
            <article class="guide-line-card">
                <div class="guide-line-cover">
                    <img src="<?= e($guideCard['image']) ?>" alt="<?= e($guideCard['alt']) ?>">
                </div>
                <div class="guide-line-content">
                    <span><?= e($guideCard['line']) ?></span>
                    <h3>Guias da linha <?= e($guideCard['line']) ?></h3>
                    <p><?= e($guideCard['description']) ?></p>
                    <div class="guide-line-links">
                        <?php foreach ($guideCard['links'] as $guide): ?>
                            <div class="guide-item">
                                <span><?= e($guide[0]) ?></span>
                                <p><?= e($guide[1]) ?></p>
                                <a class="text-link" href="<?= e($guide[3]) ?>" target="_blank" data-product="<?= e($guide[0]) ?>"><?= e($guide[2]) ?></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
        <article class="guide-line-card guide-analysis-card">
            <div class="guide-line-content">
                <span>Dimensionamento</span>
                <h3>Precisa escolher a linha certa?</h3>
                <p>Envie dados do motor, carga e tensão para receber indicação entre MRD600, MRD700 ou MRD700/IP65.</p>
                <a class="btn btn-secondary" href="/ticket">Solicitar análise</a>
            </div>
        </article>
    </div>
</section>

<section class="section process-section">
    <p class="eyebrow">Como funciona</p>
    <h2>Do diagnóstico ao equipamento certo.</h2>
    <div class="process-grid">
        <?php foreach ([
            ['01', 'Levantamento', 'Entendemos motor, carga, tensão, regime de operação e objetivo.'],
            ['02', 'Dimensionamento', 'Indicamos potência, modelo e cuidados de instalação.'],
            ['03', 'Proposta técnica', 'Você recebe uma recomendação objetiva para orçamento.'],
            ['04', 'Aplicação', 'Apoio com boas práticas para operação e parametrização.'],
        ] as $step): ?>
            <article>
                <span><?= e($step[0]) ?></span>
                <h3><?= e($step[1]) ?></h3>
                <p><?= e($step[2]) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section" id="catalogo">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Catálogo</p>
            <h2>Produtos MRDRIVES</h2>
        </div>
        <a class="btn btn-secondary" href="/catalogo">Abrir catálogo completo</a>
    </div>
    <?php $featuredProducts = [
        [
            'name' => 'MRD600',
            'model_code' => 'MRD600',
            'short_description' => 'Inversor compacto para máquinas, bombas, ventiladores e aplicações industriais de rotina.',
            'power' => '0.4 kW a 18 kW',
            'voltage' => '220 V / 380 V',
            'image' => asset('img/mrd600/mrd600_2.png'),
            'href' => '/mrd600',
        ],
        [
            'name' => 'MRD700',
            'model_code' => 'MRD700',
            'short_description' => 'Linha vetorial de alto desempenho com expansão PLC e protocolos industriais.',
            'power' => 'Sob consulta',
            'voltage' => '220 V / 380 V / 480 V',
            'image' => asset('img/mrd700/mrd700.jpg'),
            'href' => '/mrd700',
        ],
        [
            'name' => 'MRD700/IP65',
            'model_code' => 'MRD700/IP65',
            'short_description' => 'Inversor lavável para ambientes com água, poeira e rotinas severas de limpeza.',
            'power' => '0.4 kW a 400 kW',
            'voltage' => '380 V / 480 V',
            'image' => asset('img/mrd700-ip65/mrd700ip65-transparent.png'),
            'href' => '/mrd700-ip65',
        ],
    ]; ?>
    <div class="catalog-grid">
        <?php foreach ($featuredProducts as $product): ?>
            <article class="product-card">
                <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
                <div>
                    <p class="code"><?= e($product['model_code']) ?></p>
                    <h3><?= e($product['name']) ?></h3>
                    <p><?= e($product['short_description']) ?></p>
                    <dl>
                        <dt>Potência</dt><dd><?= e($product['power']) ?></dd>
                        <dt>Tensão</dt><dd><?= e($product['voltage']) ?></dd>
                    </dl>
                    <div class="card-actions">
                        <a class="btn btn-small" href="<?= e($product['href']) ?>">Ver detalhes</a>
                        <a class="text-link" href="#contato" data-product="<?= e($product['name']) ?>">Solicitar orçamento</a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section feedback-section" id="feedbacks">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Feedbacks e vídeos</p>
            <h2>Provas reais, vídeos e comentários de clientes.</h2>
        </div>
    </div>
    <div class="feedback-grid">
        <article class="video-proof-card video-proof-portrait"><video src="<?= asset('img/videos/provas.mp4') ?>?v=<?= filemtime(public_path('assets/img/videos/provas.mp4')) ?>" muted loop playsinline controls preload="metadata"></video></article>
        <article class="video-proof-card video-proof-portrait"><video src="<?= asset('img/videos/provas2.mp4') ?>?v=<?= filemtime(public_path('assets/img/videos/provas2.mp4')) ?>" muted loop playsinline controls preload="metadata"></video></article>
    </div>
    <div class="rating-summary"><strong>4,8</strong><span>&#9733;&#9733;&#9733;&#9733;&#9733;</span><p>Média de avaliação em atendimentos técnicos e aplicações industriais.</p></div>
    <div class="feedback-carousel-tools" aria-label="Navegação dos comentários">
        <button class="carousel-arrow carousel-arrow-prev" type="button" aria-label="Comentários anteriores" data-scroll-target=".testimonial-carousel" data-scroll-direction="-1"></button>
        <button class="carousel-arrow carousel-arrow-next" type="button" aria-label="Próximos comentários" data-scroll-target=".testimonial-carousel" data-scroll-direction="1"></button>
    </div>
    <div class="testimonial-carousel drag-scroll" data-drag-scroll aria-label="Comentários de clientes">
        <div class="testimonial-track">
        <?php foreach ([
            ['Excelente produto, chegou bem orientado e com suporte para parametrização.', 'Carlos M.', 'Manutenção industrial'],
            ['O atendimento ajudou a escolher a potência correta sem comprar acima do necessário.', 'Renata S.', 'Compras técnicas'],
            ['Instalamos em bomba e o controle ficou muito mais estável.', 'Marcos P.', 'Saneamento'],
            ['Boa resposta no orçamento e explicação clara sobre tensão e aplicação.', 'Juliana R.', 'Automação'],
            ['Produto robusto, visual profissional e entrega alinhada com o combinado.', 'Eduardo L.', 'Integrador'],
            ['A equipe entendeu a carga da máquina e indicou a linha certa.', 'Paulo A.', 'Máquinas industriais'],
        ] as $review): ?>
            <article class="testimonial-card"><span>&#9733;&#9733;&#9733;&#9733;&#9733;</span><p>"<?= e($review[0]) ?>"</p><strong><?= e($review[1]) ?></strong><small><?= e($review[2]) ?></small></article>
        <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section contrast faq-section" id="faq">
    <div class="faq-heading">
        <p class="eyebrow">FAQ</p>
        <h2>Perguntas frequentes</h2>
        <p>Tudo o que você precisa saber antes de definir o inversor ideal para sua aplicação.</p>
    </div>
    <?php foreach ([
        'Qual o prazo de entrega?' => 'O prazo é definido conforme disponibilidade de estoque, modelo escolhido e forma de envio. Para demandas urgentes, nossa equipe confirma a melhor opção antes do fechamento do pedido.',
        'O MRD700/IP65 é lavável?' => 'Sim. Ele é indicado para ambientes severos e rotinas com poeira, umidade e lavagem, respeitando as orientações técnicas de instalação do modelo IP65.',
        'Preciso trocar meu motor atual?' => 'Na maioria dos casos, não. Avaliamos potência, tensão e regime de trabalho para indicar o inversor compatível com seu motor.',
        'Quais aplicações são recomendadas?' => 'Bombas, ventiladores, exaustores, esteiras transportadoras, compressores, máquinas industriais e aplicações que exigem controle de velocidade e torque.',
        'Vocês fazem o dimensionamento técnico?' => 'Sim. Nossa equipe analisa motor, carga, tensão, ambiente de instalação e objetivo da aplicação para indicar o modelo adequado.',
    ] as $question => $answer): ?>
        <details class="faq-item">
            <summary><?= e($question) ?></summary>
            <p><?= e($answer) ?></p>
        </details>
    <?php endforeach; ?>
</section>

<section class="section contact contact-compact" id="contato">
    <div class="contact-copy">
        <p class="eyebrow">Contato</p>
        <h2>Orçamento rápido, sem formulário gigante.</h2>
        <p>Escolha a linha, deixe seu WhatsApp e envie um ticket direto para nossa equipe técnica.</p>
        <?php if (!empty($flash)): ?>
            <div class="flash <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
        <?php endif; ?>
    </div>
    <form class="quote-form quote-form-compact" action="/ticket" method="post">
        <?= Csrf::field() ?>
        <input type="hidden" name="name" value="Lead site MRDRIVES">
        <input type="hidden" name="company" value="Contato rápido">
        <input type="hidden" name="email" value="lead@mrdrives.local">
        <label>Produto
            <select name="product_interest" id="product_interest">
                <option>MRD600</option>
                <option>MRD700</option>
                <option>MRD700/IP65</option>
                <option>Dimensionamento técnico</option>
            </select>
        </label>
        <label>WhatsApp<input name="phone" required placeholder="+55 11 99999-9999"></label>
        <input type="hidden" name="application" value="Ticket enviado pelo site">
        <label>Resumo do pedido<textarea name="message" rows="3" placeholder="Ex.: motor 3 cv, rede 220 V, bomba de recalque"></textarea></label>
        <div class="contact-actions">
            <button class="btn" type="submit">Enviar ticket</button>
            <a class="btn btn-secondary" href="/ticket">Formulário completo</a>
        </div>
    </form>
</section>



