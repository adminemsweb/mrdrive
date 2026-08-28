<?php
$price = isset($product['price']) && $product['price'] !== '' ? (float) $product['price'] : null;
$comparePrice = isset($product['compare_at_price']) && $product['compare_at_price'] !== '' ? (float) $product['compare_at_price'] : null;
$mainImage = !empty($product['main_image']) ? optimized_image_url($product['main_image']) : optimized_image_url('assets/img/mrd600/mrd600_2.png');
$outOfStock = !empty($product['track_stock']) && (int) ($product['stock_quantity'] ?? 0) < 1;
$saleChannel = (string) ($product['sale_channel'] ?? 'whatsapp');
$cartEnabled = (bool) (app_config('store')['cart_enabled'] ?? false);
$canUseCart = $cartEnabled && $saleChannel === 'cart' && $price !== null;
$canUseWhatsApp = !$canUseCart;
$reviewCount = 6;
?>
<nav class="shop-breadcrumb" aria-label="Navegação estrutural"><a href="/">Início</a><span>/</span><a href="/catalogo">Loja</a><span>/</span><strong><?= e($product['name']) ?></strong></nav>

<section class="shop-product-detail">
    <div class="shop-detail-gallery" data-product-gallery>
        <div class="shop-detail-main-image"><img src="<?= e($mainImage) ?>" alt="<?= e($product['name']) ?>" fetchpriority="high" decoding="async" data-gallery-main></div>
        <div class="shop-detail-thumbs">
            <button class="is-active" type="button" data-gallery-thumb="<?= e($mainImage) ?>"><img src="<?= e($mainImage) ?>" alt="Vista principal"></button>
            <?php foreach (($images ?? []) as $index => $image): ?>
                <?php $galleryImage = optimized_image_url($image['image_path']); ?>
                <button type="button" data-gallery-thumb="<?= e($galleryImage) ?>"><img src="<?= e($galleryImage) ?>" alt="Vista <?= $index + 2 ?> de <?= e($product['name']) ?>" loading="lazy" decoding="async"></button>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="shop-detail-content">
        <?php if (!empty($product['is_featured'])): ?><span class="shop-detail-featured">Destaque</span><?php endif; ?>
        <div class="shop-detail-code"><span><?= e($product['category'] ?? 'Produto MR Drives') ?></span><small>SKU <?= e($product['sku'] ?? $product['model_code']) ?></small></div>
        <h1><?= e($product['name']) ?></h1>
        <p class="shop-detail-lead"><?= e($product['short_description']) ?></p>
        <a class="shop-detail-rating" href="#avaliacoes"><span>★★★★★</span><strong>4,8</strong><small><?= $reviewCount ?> opiniões</small></a>
        <div class="shop-stock-status <?= $outOfStock ? 'is-unavailable' : 'is-available' ?>">
            <span aria-hidden="true"></span><strong><?= $outOfStock ? 'Indisponível' : 'Em estoque' ?></strong>
        </div>
        <div class="shop-detail-price">
            <?php if ($price !== null): ?>
                <?php if ($comparePrice !== null && $comparePrice > $price): ?><del><?= money_br($comparePrice) ?></del><?php endif; ?>
                <strong><?= money_br($price) ?></strong><span>à vista</span>
            <?php else: ?>
                <strong>Preço sob consulta</strong><span>Condição definida conforme potência e configuração.</span>
            <?php endif; ?>
        </div>
        <?php if ($canUseCart): ?>
            <div class="shop-purchase-row">
                <label>Quantidade
                    <span class="shop-quantity"><button type="button" data-qty-minus aria-label="Diminuir quantidade">−</button><input type="number" value="1" min="1" max="99" data-product-quantity><button type="button" data-qty-plus aria-label="Aumentar quantidade">+</button></span>
                </label>
                <button class="shop-buy-button" type="button" data-add-to-cart
                    data-id="<?= (int) $product['id'] ?>" data-name="<?= e($product['name']) ?>"
                    data-sku="<?= e($product['sku'] ?? $product['model_code']) ?>" data-image="<?= e($mainImage) ?>"
                    data-price="<?= $price ?>" data-quantity-source="[data-product-quantity]" <?= $outOfStock ? 'disabled' : '' ?>>
                    <?php if ($outOfStock): ?>Produto indisponível<?php else: ?><i data-lucide="shopping-cart" aria-hidden="true"></i><span>Adicionar ao carrinho</span><?php endif; ?>
                </button>
            </div>
        <?php endif; ?>
        <?php if ($canUseWhatsApp): ?>
            <a class="shop-detail-whatsapp <?= !$canUseCart ? 'is-primary' : '' ?>" href="https://wa.me/<?= e($whatsapp) ?>?text=Olá!%20Quero%20comprar%20o%20<?= rawurlencode($product['name']) ?>.%20Gostaria%20de%20consultar%20preço%20e%20configuração." target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>Comprar via WhatsApp</a>
        <?php endif; ?>
        <form class="shop-shipping-calculator" data-shipping-calculator data-product-id="<?= (int) $product['id'] ?>" novalidate>
            <label for="shipping-cep"><i data-lucide="truck" aria-hidden="true"></i><span>Informe seu CEP</span></label>
            <input id="shipping-cep" type="text" inputmode="numeric" maxlength="9" placeholder="00000-000" aria-describedby="shipping-result" data-shipping-cep>
            <button type="submit">Calcular</button>
            <p id="shipping-result" data-shipping-result aria-live="polite"></p>
        </form>
        <ul class="shop-detail-assurances">
            <li><span>✓</span><div><strong>Dimensionamento antes da compra</strong><small>Validamos motor, tensão e aplicação.</small></div></li>
            <li><span>↗</span><div><strong><?= e($product['shipping_days'] ?: 'Envio para todo o Brasil') ?></strong><small>Prazo e transportadora confirmados no pedido.</small></div></li>
            <li><span>⚙</span><div><strong>Suporte técnico especializado</strong><small>Apoio para parametrização e instalação.</small></div></li>
        </ul>
    </div>
</section>

<section class="shop-detail-information">
    <article><span class="shop-kicker">Visão geral do produto</span><h2><?= e($product['name']) ?> para sua aplicação industrial.</h2><p><?= nl2br(e($product['full_description'] ?: $product['short_description'])) ?></p></article>
    <article class="shop-spec-card"><h2>Informações técnicas</h2><dl><div><dt>Modelo</dt><dd><?= e($product['model_code']) ?></dd></div><div><dt>Potência</dt><dd><?= e($product['power']) ?></dd></div><div><dt>Tensão</dt><dd><?= e($product['voltage']) ?></dd></div><div><dt>Aplicações</dt><dd><?= nl2br(e($product['recommended_applications'])) ?></dd></div></dl></article>
</section>

<?php if (!empty($product['technical_specs'])): ?>
<section class="shop-tech-section"><span class="shop-kicker">Ficha técnica</span><h2>Recursos e especificações</h2><div class="shop-tech-list"><?php foreach (preg_split('/\R/', trim($product['technical_specs'])) as $spec): if (trim($spec) !== ''): ?><div><span>✓</span><?= e(trim($spec)) ?></div><?php endif; endforeach; ?></div><?php if (!empty($product['manual_pdf'])): ?><a class="shop-manual-link" href="<?= upload_url($product['manual_pdf']) ?>" target="_blank">Baixar manual técnico em PDF →</a><?php endif; ?></section>
<?php endif; ?>

<?php if (!empty($technicalView)):
    $embeddedShopDetail = true;
    require app_path('Views/public/' . basename((string) $technicalView) . '.php');
endif; ?>

<?php require app_path('Views/public/reviews.php'); ?>

<?php if (!empty($relatedProducts)): ?>
<section class="product-related-section" aria-labelledby="related-products-title">
    <h2 id="related-products-title">Produtos relacionados</h2>
    <div class="product-related-grid">
        <?php foreach ($relatedProducts as $related):
            $relatedImage = !empty($related['main_image']) ? optimized_image_url($related['main_image']) : optimized_image_url('assets/img/mrd600/mrd600_2.png');
            $relatedPrice = isset($related['price']) && $related['price'] !== '' ? (float) $related['price'] : null;
            $relatedUrl = !empty($related['url']) ? (string) $related['url'] : '/produto?id=' . (int) $related['id'];
        ?>
            <article class="product-related-card">
                <?php if (!empty($related['is_featured'])): ?><span>Destaque</span><?php endif; ?>
                <a href="<?= e($relatedUrl) ?>"><img src="<?= e($relatedImage) ?>" alt="<?= e($related['name']) ?>" loading="lazy"></a>
                <h3><a href="<?= e($relatedUrl) ?>"><?= e($related['name']) ?></a></h3>
                <div class="product-related-rating" aria-label="Avaliação 4,8 de 5 estrelas">★★★★★ <small>4,8</small></div>
                <strong><?= $relatedPrice !== null ? money_br($relatedPrice) : 'Preço sob consulta' ?></strong>
                <a class="product-related-action" href="<?= e($relatedUrl) ?>">Ver produto</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<section class="product-newsletter-section" aria-labelledby="product-newsletter-title">
    <div><i data-lucide="mail" aria-hidden="true"></i><span><strong id="product-newsletter-title">Receba promoções exclusivas</strong><small>Cadastre-se e receba novidades, dicas e condições especiais.</small></span></div>
    <form data-product-newsletter novalidate>
        <input type="email" placeholder="Digite seu melhor e-mail" aria-label="Seu melhor e-mail" required>
        <button type="submit">Enviar</button>
        <p aria-live="polite"></p>
    </form>
</section>
