<section class="catalog-hero">
    <div class="catalog-hero-brand">
        <img src="<?= asset('img/logo.png') ?>" alt="MRDRIVES">
    </div>
    <p class="eyebrow">Catalogo tecnico</p>
    <h1>Produtos MRDRIVES para controle industrial.</h1>
    <p>Conheca os modelos disponiveis, aplicacoes recomendadas e detalhes tecnicos das linhas MRD600 e MRD700.</p>
    <div class="actions">
        <a class="btn btn-whatsapp" href="/#contato"><span class="wa-icon" aria-hidden="true">W</span>Solicitar orcamento</a>
        <?php if ($documents): ?>
            <a class="btn btn-secondary" href="<?= upload_url($documents[0]['file_path']) ?>" target="_blank">Baixar catalogo geral</a>
        <?php endif; ?>
    </div>
</section>

<section class="section catalog-page">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Linha ativa</p>
            <h2>Produtos cadastrados</h2>
        </div>
        <a class="text-link" href="/">Voltar para a landing page</a>
    </div>

    <?php $catalogProducts = [
        [
            'name' => 'MRD600',
            'model_code' => 'MRD600',
            'short_description' => 'Inversor compacto para maquinas, bombas, ventiladores e aplicacoes industriais de rotina.',
            'power' => '0.4 kW a 18 kW',
            'voltage' => '220 V / 380 V',
            'image' => asset('img/mrd600/mrd600_2.png'),
            'href' => '/mrd600',
        ],
        [
            'name' => 'MRD700',
            'model_code' => 'MRD700',
            'short_description' => 'Linha vetorial de alto desempenho com expansao PLC, comunicacao industrial e automacao.',
            'power' => 'Sob consulta',
            'voltage' => '220 V / 380 V / 480 V',
            'image' => asset('img/mrd700/mrd700.jpg'),
            'href' => '/mrd700',
        ],
        [
            'name' => 'MRD700/IP65',
            'model_code' => 'MRD700/IP65',
            'short_description' => 'Versao lavavel para agua, poeira e ambientes severos, com STO, PID, PLC e protocolos industriais.',
            'power' => '0.4 kW a 400 kW',
            'voltage' => '380 V / 480 V',
            'image' => asset('img/mrd700-ip65/mrd700ip65-transparent.png'),
            'href' => '/mrd700-ip65',
        ],
    ]; ?>
    <div class="catalog-grid catalog-grid-page">
        <?php foreach ($catalogProducts as $product): ?>
            <article class="product-card catalog-product-card" id="<?= strtolower(str_replace('/', '-', e($product['model_code']))) ?>">
                <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
                <div>
                    <p class="code"><?= e($product['model_code']) ?></p>
                    <h3><?= e($product['name']) ?></h3>
                    <p><?= e($product['short_description']) ?></p>
                    <dl>
                        <dt>Potencia</dt><dd><?= e($product['power']) ?></dd>
                        <dt>Tensao</dt><dd><?= e($product['voltage']) ?></dd>
                    </dl>
                    <div class="card-actions">
                        <a class="btn btn-small" href="<?= e($product['href']) ?>">Ver detalhes</a>
                        <a class="text-link" href="/#contato" data-product="<?= e($product['name']) ?>">Solicitar orcamento</a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>

        <?php if (false): ?>
            <article class="empty-card">
                <h3>Nenhum produto ativo cadastrado ainda.</h3>
                <p>Adicione produtos no painel administrativo para preencher o catalogo.</p>
                <a class="btn btn-secondary" href="/admin/">Abrir admin</a>
            </article>
        <?php endif; ?>
    </div>
</section>


