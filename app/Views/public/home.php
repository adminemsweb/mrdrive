<?php
use App\Core\Csrf;

$heroProducts = array_values($products);
$heroMessages = [
    ['Linha compacta e versátil', 'Inversores de frequência para máquinas e automação industrial', 'purple', 'Explore a linha MRD600'],
    ['Linha de alto desempenho', 'Mais desempenho para a sua automação industrial', 'orange', 'Conheça o MRD700'],
    ['Linha protegida IP65', 'Proteção preparada para ambientes severos', 'blue', 'Conheça o MRD700/IP65'],
];
?>
<section class="storefront-hero" aria-label="Loja de automação industrial MR Drives">
    <div class="storefront-hero-carousel swiper" data-hero-carousel>
        <div class="swiper-wrapper">
            <?php foreach ($heroProducts as $index => $item):
                $heroImage = !empty($item['main_image']) ? optimized_image_url($item['main_image']) : optimized_image_url('assets/img/mrd600/mrd600_2.png');
                $heroUrl = $item['url'] ?? ('/produto?id=' . (int) $item['id']);
                $message = $heroMessages[$index] ?? ['Linha MR Drives', 'Controle industrial para a sua operação', 'blue', 'Conheça nossos produtos'];
            ?>
                <article class="storefront-promotion storefront-promotion--<?= e($message[2]) ?> swiper-slide">
                    <div class="storefront-promotion-copy">
                        <span class="storefront-promotion-label"><?= e($message[0]) ?> <b>•</b> Entrega nacional</span>
                        <?php if ($index === 0): ?>
                            <h1><?= e($message[1]) ?></h1>
                        <?php else: ?>
                            <h2><?= e($message[1]) ?></h2>
                        <?php endif; ?>
                        <p><?= e($item['short_description']) ?></p>
                        <div class="storefront-promotion-tags"><span><?= e($item['power']) ?></span><span><?= e($item['voltage']) ?></span></div>
                        <div class="storefront-promotion-actions"><a href="<?= e($heroUrl) ?>"><?= e($message[3]) ?> <i data-lucide="arrow-right"></i></a><a href="/ticket">Falar com um especialista</a></div>
                    </div>
                    <div class="storefront-promotion-product">
                        <span class="storefront-promotion-model"><?= e($item['name']) ?></span>
                        <img src="<?= e($heroImage) ?>" alt="<?= e($item['name']) ?>" decoding="async" <?= $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="storefront-hero-pagination" aria-label="Selecionar produto em destaque"></div>
    </div>
    <div class="storefront-hero-assurances">
        <span><i data-lucide="truck"></i><strong>Entrega nacional</strong><small>Atendimento em todo o Brasil</small></span>
        <span><i data-lucide="headphones"></i><strong>Compra assistida</strong><small>Ajuda para escolher o modelo</small></span>
        <span><i data-lucide="badge-check"></i><strong>Garantia e nota fiscal</strong><small>Consulte as condições da linha</small></span>
        <span><i data-lucide="shield-check"></i><strong>Compra protegida</strong><small>Políticas claras e suporte</small></span>
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
        <video src="<?= asset('img/videos/mrd700ip65.mp4') ?>" controls playsinline preload="none" poster="<?= optimized_image_url('assets/img/mrd700-ip65/mrip65banner.png') ?>"></video>
    </div>
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
        <img class="photo-large" src="<?= optimized_image_url('assets/img/mrd600/mrd600.png') ?>" alt="Linha de inversores MRDRIVES" loading="lazy" decoding="async">
        <img class="photo-small" src="<?= optimized_image_url('assets/img/mrd700-ip65/mrd700ip65-transparent.png') ?>" alt="Inversor MRD700/IP65 lavável" loading="lazy" decoding="async">
        <img class="photo-small" src="<?= optimized_image_url('assets/img/mrd700/mr.jpg') ?>" alt="Módulos de comunicação MR700" loading="lazy" decoding="async">
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
    </div>
    <?php $featuredProducts = [
        [
            'id' => 'mrd600-family',
            'name' => 'MRD600',
            'model_code' => 'MRD600',
            'short_description' => 'Inversor compacto para máquinas, bombas, ventiladores e aplicações industriais de rotina.',
            'power' => '0.4 kW a 18 kW',
            'voltage' => '220 V / 380 V',
            'image' => optimized_image_url('assets/img/mrd600/mrd600_2.png'),
            'href' => '/mrd600',
        ],
        [
            'id' => 'mrd700-family',
            'name' => 'MRD700',
            'model_code' => 'MRD700',
            'short_description' => 'Linha vetorial de alto desempenho com expansão PLC e protocolos industriais.',
            'power' => 'Sob consulta',
            'voltage' => '220 V / 380 V / 480 V',
            'image' => optimized_image_url('assets/img/mrd700/mrd700.jpg'),
            'href' => '/mrd700',
        ],
        [
            'id' => 'mrd700-ip65-family',
            'name' => 'MRD700/IP65',
            'model_code' => 'MRD700/IP65',
            'short_description' => 'Inversor lavável para ambientes com água, poeira e rotinas severas de limpeza.',
            'power' => '0.4 kW a 400 kW',
            'voltage' => '380 V / 480 V',
            'image' => optimized_image_url('assets/img/mrd700-ip65/mrd700ip65-transparent.png'),
            'href' => '/mrd700-ip65',
        ],
    ]; ?>
    <div class="catalog-grid">
        <?php foreach ($featuredProducts as $product): ?>
            <article class="product-card">
                <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>" loading="lazy" decoding="async">
                <div>
                    <p class="code"><?= e($product['model_code']) ?></p>
                    <h3><?= e($product['name']) ?></h3>
                    <div class="product-rating" aria-label="Avaliação 4,8 de 5 estrelas">
                        <strong>4,8</strong><span aria-hidden="true">★★★★★</span><small>Avaliações</small>
                    </div>
                    <p><?= e($product['short_description']) ?></p>
                    <dl>
                        <dt>Potência</dt><dd><?= e($product['power']) ?></dd>
                        <dt>Tensão</dt><dd><?= e($product['voltage']) ?></dd>
                    </dl>
                    <div class="card-actions">
                        <a class="btn btn-small product-details-button" href="<?= e($product['href']) ?>" aria-label="Ver detalhes de <?= e($product['name']) ?>" title="Ver detalhes"><i data-lucide="file-text"></i></a>
                        <a class="home-shop-whatsapp" href="https://wa.me/<?= e(app_config('whatsapp')) ?>?text=Tenho%20interesse%20no%20<?= rawurlencode($product['name']) ?>" target="_blank" rel="noopener"><i data-lucide="message-circle" aria-hidden="true"></i><span>Comprar via WhatsApp</span></a>
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
    <div class="feedback-summary-inline"><strong>4,8</strong><span aria-label="5 de 5 estrelas">&#9733;&#9733;&#9733;&#9733;&#9733;</span><small>Avaliações de clientes</small></div>
    <div class="feedback-swiper swiper" data-feedback-swiper aria-label="Vídeos e comentários de clientes">
        <div class="swiper-wrapper">
            <article class="feedback-carousel-card feedback-video-feature swiper-slide">
                <div class="feedback-carousel-media"><video src="<?= versioned_asset('img/videos/provas.mp4') ?>" muted playsinline controls controlslist="nodownload noplaybackrate noremoteplayback" disablepictureinpicture preload="none"></video></div>
                <div class="feedback-carousel-copy"><span class="feedback-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span><div class="feedback-person"><img src="<?= asset('img/testimonials/customer-avatar-ai.webp') ?>" alt="Avatar ilustrativo da equipe MR Drives" loading="lazy" decoding="async"><span><h3>Equipe MR Drives</h3><small>Demonstração técnica</small></span></div><p>Registro em campo do equipamento durante uma aplicação acompanhada.</p></div>
            </article>
            <article class="feedback-carousel-card feedback-video-feature swiper-slide">
                <div class="feedback-carousel-media"><video src="<?= versioned_asset('img/videos/provas2.mp4') ?>" muted playsinline controls controlslist="nodownload noplaybackrate noremoteplayback" disablepictureinpicture preload="none"></video></div>
                <div class="feedback-carousel-copy"><span class="feedback-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span><div class="feedback-person"><img src="<?= asset('img/testimonials/customer-avatar-ai.webp') ?>" alt="Avatar ilustrativo da demonstração em campo" loading="lazy" decoding="async"><span><h3>Demonstração em campo</h3><small>Aplicação real</small></span></div><p>Continuidade do teste com suporte durante toda a demonstração.</p></div>
            </article>
        <?php foreach ([
            ['Excelente produto, chegou bem orientado e com suporte para parametrização.', 'Carlos M.', 'Manutenção industrial'],
            ['O atendimento ajudou a escolher a potência correta sem comprar acima do necessário.', 'Renata S.', 'Compras técnicas'],
            ['Instalamos em bomba e o controle ficou muito mais estável.', 'Marcos P.', 'Saneamento'],
            ['Boa resposta no orçamento e explicação clara sobre tensão e aplicação.', 'Juliana R.', 'Automação'],
            ['Produto robusto, visual profissional e entrega alinhada com o combinado.', 'Eduardo L.', 'Integrador'],
            ['A equipe entendeu a carga da máquina e indicou a linha certa.', 'Paulo A.', 'Máquinas industriais'],
        ] as $review): ?>
            <article class="feedback-carousel-card feedback-carousel-review swiper-slide">
                <div class="feedback-carousel-copy"><span class="feedback-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span><div class="feedback-person feedback-person-placeholder"><span class="feedback-placeholder-avatar" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 22c.4-5.2 3.1-8 8-8s7.6 2.8 8 8Z"/></svg></span><span><h3><?= e($review[1]) ?></h3><small><?= e($review[2]) ?></small></span></div><p>“<?= e($review[0]) ?>”</p></div>
            </article>
        <?php endforeach; ?>
        </div>
        <div class="feedback-swiper-pagination" aria-hidden="true"></div>
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
        <?php $companyData = app_config('company'); ?>
        <address class="contact-company-location">
            <i data-lucide="map-pin"></i>
            <span><small>Localização da empresa</small><strong>MR Drives • Sorocaba, SP</strong><span><?= e($companyData['address']) ?></span><a href="https://www.google.com/maps/search/?api=1&amp;query=<?= rawurlencode($companyData['address']) ?>" target="_blank" rel="noopener">Ver no Google Maps →</a></span>
        </address>
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
