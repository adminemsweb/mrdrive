<section class="section product-detail">
    <div class="product-media">
        <?php if ($product['main_image']): ?>
            <img src="<?= upload_url($product['main_image']) ?>" alt="<?= e($product['name']) ?>">
        <?php else: ?>
            <div class="placeholder detail-placeholder">Imagem principal do produto</div>
        <?php endif; ?>
        <div class="gallery">
            <?php foreach ($images as $image): ?>
                <img src="<?= upload_url($image['image_path']) ?>" alt="<?= e($product['name']) ?>">
            <?php endforeach; ?>
        </div>
    </div>
    <div>
        <p class="eyebrow"><?= e($product['model_code']) ?></p>
        <h1><?= e($product['name']) ?></h1>
        <p class="lead"><?= e($product['short_description']) ?></p>
        <p><?= nl2br(e($product['full_description'])) ?></p>
        <dl class="spec-list">
            <dt>Potência</dt><dd><?= e($product['power']) ?></dd>
            <dt>Tensão</dt><dd><?= e($product['voltage']) ?></dd>
            <dt>Aplicações</dt><dd><?= nl2br(e($product['recommended_applications'])) ?></dd>
        </dl>
        <h2>Especificações técnicas</h2>
        <pre class="spec-box"><?= e($product['technical_specs']) ?></pre>
        <div class="actions">
            <?php if ($product['manual_pdf']): ?>
                <a class="btn btn-secondary" href="<?= upload_url($product['manual_pdf']) ?>" target="_blank">Baixar manual PDF</a>
            <?php endif; ?>
            <a class="btn" href="/#contato">Solicitar orçamento</a>
            <a class="text-link" href="https://wa.me/<?= e($whatsapp) ?>?text=Tenho%20interesse%20no%20<?= urlencode($product['name']) ?>" target="_blank">WhatsApp</a>
        </div>
    </div>
</section>
