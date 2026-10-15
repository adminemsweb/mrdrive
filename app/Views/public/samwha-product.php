<?php
use App\Services\SamwhaService;
$gallery = array_values(array_unique(array_filter(array_map([SamwhaService::class, 'asset'], array_merge([$product['main_image_url'] ?? ''], $product['images'] ?? [])))));
$status = SamwhaService::availability($product);
?>
<div class="samwha-store-product">
<nav class="shop-breadcrumb" aria-label="Navegação estrutural"><a href="/">Início</a><span>/</span><a href="/samwha-dsp">Loja Samwha DSP</a><span>/</span><strong><?= e($product['product_code'] ?: $product['name']) ?></strong></nav>
<section class="shop-product-detail">
    <div class="shop-detail-gallery" data-product-gallery>
        <div class="shop-detail-main-image"><?php if ($image): ?><img src="<?= e($image) ?>" alt="<?= e($product['name']) ?>" fetchpriority="high" decoding="async" data-gallery-main><?php endif; ?></div>
        <div class="shop-detail-thumbs"><?php foreach ($gallery as $index => $galleryImage): ?><button class="<?= $index === 0 ? 'is-active' : '' ?>" type="button" data-gallery-thumb="<?= e($galleryImage) ?>" aria-label="Ver imagem <?= $index + 1 ?> de <?= e($product['name']) ?>"><img src="<?= e($galleryImage) ?>" alt="Vista <?= $index + 1 ?>" loading="lazy"></button><?php endforeach; ?></div>
    </div>
    <div class="shop-detail-content">
        <?php if (!empty($product['is_featured'])): ?><span class="shop-detail-featured">Destaque</span><?php endif; ?>
        <div class="shop-detail-code"><span><?= e($product['category'] ?? 'Samwha DSP') ?></span><small>SKU <?= e($product['product_code'] ?? '') ?></small></div>
        <h1><?= e($product['name']) ?></h1>
        <p class="shop-detail-lead"><?= e($product['short_description'] ?? '') ?></p>
        <div class="shop-stock-status <?= ($product['stock_status'] ?? '') === 'out_of_stock' ? 'is-unavailable' : 'is-available' ?>"><span aria-hidden="true"></span><strong><?= e($status) ?></strong></div>
        <div class="shop-detail-price"><strong>Preço sob consulta</strong><span>Consulte condições e disponibilidade com nossa equipe.</span></div>
        <a class="shop-detail-whatsapp is-primary" href="https://wa.me/<?= e(app_config('whatsapp')) ?>?text=<?= rawurlencode('Olá! Quero consultar o produto Samwha DSP ' . $product['name'] . ' (' . ($product['product_code'] ?? '') . ').') ?>" target="_blank" rel="noopener"><svg aria-hidden="true" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>Comprar via WhatsApp</a>
        <?php if ($manual): ?><a class="shop-manual-link samwha-store-manual" href="<?= e($manual) ?>" target="_blank" rel="noopener"><i data-lucide="download"></i>Baixar manual técnico em PDF</a><?php else: ?><p class="samwha-store-manual-missing">Manual técnico não disponível para este produto.</p><?php endif; ?>
        <form class="shop-shipping-calculator" data-shipping-calculator novalidate><label for="shipping-cep"><i data-lucide="truck"></i><span>Informe seu CEP</span></label><input id="shipping-cep" type="text" inputmode="numeric" maxlength="9" placeholder="00000-000" aria-describedby="shipping-result" data-shipping-cep><button type="submit">Calcular</button><p id="shipping-result" data-shipping-result aria-live="polite"></p></form>
        <ul class="shop-detail-assurances">
            <li><span>✓</span><div><strong>Orientação antes da compra</strong><small>Validamos modelo, especificações e aplicação.</small></div></li>
            <li><span>↗</span><div><strong>Prazo confirmado no atendimento</strong><small>Prazo e transportadora confirmados no pedido.</small></div></li>
            <li><span>⚙</span><div><strong>Suporte técnico especializado</strong><small>Apoio na escolha do produto e na instalação.</small></div></li>
        </ul>
    </div>
</section>
<?php if (!empty($product['description'])): ?><section class="samwha-store-description"><span class="shop-kicker">Visão geral do produto</span><h2>Informações do produto</h2><p><?= nl2br(e(html_entity_decode(strip_tags(str_ireplace(['</p>', '<br>', '<br/>', '<br />'], "\n", $product['description'])), ENT_QUOTES | ENT_HTML5, 'UTF-8'))) ?></p></section><?php endif; ?>
</div>
