<?php
$cartEnabled = (bool) (app_config('store')['cart_enabled'] ?? false);
$categories = array_values(array_unique(array_filter(array_map(
    static fn(array $item): string => trim((string) ($item['category'] ?? '')),
    $products
))));
sort($categories);
?>
<section class="shop-section" id="produtos">
    <div class="legacy-catalog-layout">
        <aside class="legacy-catalog-sidebar" aria-label="Filtros do catálogo">
            <div class="legacy-filter-group">
                <h2><span>Categorias</span><i data-lucide="chevron-left" aria-hidden="true"></i></h2>
                <div class="legacy-category-list" data-category-filters>
                    <button class="is-active" type="button" data-category="all"><span></span>Todos os produtos <small>(<?= count($products) ?>)</small></button>
                    <?php foreach ($categories as $category):
                        $categoryCount = count(array_filter($products, static fn(array $product): bool => strtolower(trim((string) ($product['category'] ?? ''))) === strtolower($category)));
                    ?>
                        <button type="button" data-category="<?= e(strtolower($category)) ?>"><span></span><?= e($category) ?> <small>(<?= $categoryCount ?>)</small></button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="legacy-filter-group">
                <h2><span>Preço</span><i data-lucide="chevron-left" aria-hidden="true"></i></h2>
                <div class="legacy-price-range">
                    <label><span>Valor mínimo</span><span class="legacy-price-input"><small>R$</small><input type="number" min="0" step="0.01" placeholder="0,00" inputmode="decimal" data-price-min></span></label>
                    <label><span>Valor máximo</span><span class="legacy-price-input"><small>R$</small><input type="number" min="0" step="0.01" placeholder="10.000" inputmode="decimal" data-price-max></span></label>
                </div>
            </div>

            <div class="legacy-filter-group">
                <h2><span>Disponibilidade</span><i data-lucide="chevron-left" aria-hidden="true"></i></h2>
                <label class="legacy-check-filter"><input type="checkbox" checked><span>Disponível para consulta</span><small>(<?= count($products) ?>)</small></label>
            </div>

            <div class="legacy-filter-group">
                <h2><span>Marcas</span><i data-lucide="chevron-left" aria-hidden="true"></i></h2>
                <label class="legacy-check-filter"><input type="checkbox" checked><span>MR Drives</span><small>(<?= count($products) ?>)</small></label>
            </div>

            <button class="legacy-filter-apply" type="button" data-sidebar-apply>Filtrar</button>
        </aside>

        <div class="legacy-catalog-main">
            <nav class="legacy-catalog-breadcrumb" aria-label="Navegação estrutural">
                <a href="/">Início</a><span>›</span><strong>Produtos MR Drives</strong>
            </nav>

            <header class="legacy-catalog-heading">
                <div>
                    <span class="shop-kicker">Catálogo profissional</span>
                    <h1>Produtos MR Drives</h1>
                </div>
                <label class="shop-sort">Ordenar por:
                    <select data-catalog-sort>
                        <option value="featured">Destaques</option>
                        <option value="name">Nome A–Z</option>
                        <option value="price-asc">Menor preço</option>
                        <option value="price-desc">Maior preço</option>
                    </select>
                </label>
            </header>

            <p class="legacy-catalog-description">Compare nossas linhas de inversores de frequência para máquinas, bombas, ventiladores e aplicações industriais. Consulte potência, tensão e recursos para escolher a solução correta para sua operação.</p>

            <div class="legacy-catalog-toolbar">
                <label class="shop-search">
                    <i data-lucide="search" aria-hidden="true"></i>
                    <input type="search" placeholder="Buscar por produto, modelo ou aplicação" data-catalog-search autocomplete="off">
                </label>
                <p><strong data-product-result-count><?= count($products) ?></strong> produtos encontrados</p>
            </div>

    <div class="shop-product-grid" data-product-grid>
        <?php foreach ($products as $product):
            $price = isset($product['price']) && $product['price'] !== '' ? (float) $product['price'] : null;
            $comparePrice = isset($product['compare_at_price']) && $product['compare_at_price'] !== '' ? (float) $product['compare_at_price'] : null;
            $image = !empty($product['main_image']) ? optimized_image_url($product['main_image']) : optimized_image_url('assets/img/mrd600/mrd600_2.png');
            $category = trim((string) ($product['category'] ?? 'Soluções industriais'));
            $outOfStock = !empty($product['track_stock']) && (int) ($product['stock_quantity'] ?? 0) < 1;
            $saleChannel = (string) ($product['sale_channel'] ?? 'whatsapp');
            $canUseCart = $cartEnabled && $saleChannel === 'cart' && $price !== null;
            $canUseWhatsApp = !$canUseCart;
            $productUrl = !empty($product['url']) ? (string) $product['url'] : '/produto?id=' . (int) $product['id'];
        ?>
            <article class="shop-product-card" data-product-card data-name="<?= e(strtolower(($product['name'] ?? '') . ' ' . ($product['model_code'] ?? '') . ' ' . $category . ' ' . ($product['recommended_applications'] ?? ''))) ?>" data-category="<?= e(strtolower($category)) ?>" data-price="<?= $price ?? '' ?>" data-featured="<?= !empty($product['is_featured']) ? '1' : '0' ?>">
                <a class="shop-product-image" href="<?= e($productUrl) ?>">
                    <?php if (!empty($product['is_featured'])): ?><span class="shop-product-badge">Destaque</span><?php endif; ?>
                    <img src="<?= e($image) ?>" alt="<?= e($product['name']) ?>" loading="lazy" decoding="async">
                </a>
                <div class="shop-product-content">
                    <div class="shop-product-meta"><span><?= e($category) ?></span><small>SKU <?= e($product['sku'] ?? $product['model_code']) ?></small></div>
                    <a class="shop-product-title" href="<?= e($productUrl) ?>"><h3><?= e($product['name']) ?></h3></a>
                    <a class="shop-card-rating" href="<?= e($productUrl) ?>#avaliacoes" aria-label="Ver avaliações de <?= e($product['name']) ?>"><span>★★★★★</span><strong>4,8</strong><small>Avaliações de clientes</small></a>
                    <p><?= e($product['short_description']) ?></p>
                    <ul class="shop-mini-specs">
                        <li><span>Potência</span><strong><?= e($product['power']) ?></strong></li>
                        <li><span>Tensão</span><strong><?= e($product['voltage']) ?></strong></li>
                    </ul>
                    <div class="shop-price-block">
                        <?php if ($price !== null): ?>
                            <?php if ($comparePrice !== null && $comparePrice > $price): ?><del><?= money_br($comparePrice) ?></del><?php endif; ?>
                            <strong><?= money_br($price) ?></strong>
                            <span><?= $cartEnabled ? 'Preço à vista. Condições no checkout.' : 'Consulte condições e disponibilidade pelo WhatsApp.' ?></span>
                        <?php else: ?>
                            <strong class="shop-consult-price">Preço sob consulta</strong>
                            <span>Receba uma condição personalizada.</span>
                        <?php endif; ?>
                    </div>
                    <div class="shop-card-actions">
                        <?php if ($canUseCart): ?>
                            <button class="shop-add-button" type="button" data-add-to-cart
                                data-id="<?= (int) $product['id'] ?>" data-name="<?= e($product['name']) ?>"
                                data-sku="<?= e($product['sku'] ?? $product['model_code']) ?>" data-image="<?= e($image) ?>"
                                data-price="<?= $price ?>" <?= $outOfStock ? 'disabled' : '' ?>>
                                <?php if ($outOfStock): ?>Indisponível<?php else: ?><i data-lucide="shopping-cart" aria-hidden="true"></i><span>Adicionar ao carrinho</span><?php endif; ?>
                            </button>
                        <?php endif; ?>
                        <?php if ($canUseWhatsApp): ?>
                            <a class="shop-whatsapp-buy <?= !$canUseCart ? 'is-only-action' : '' ?>" href="https://wa.me/<?= e($whatsapp) ?>?text=Quero%20comprar%20o%20<?= rawurlencode($product['name']) ?>.%20Gostaria%20de%20consultar%20preço%20e%20configuração." target="_blank" rel="noopener"><svg class="shop-whatsapp-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg><span>Comprar via WhatsApp</span></a>
                        <?php endif; ?>
                    </div>
                    <a class="shop-details-link" href="<?= e($productUrl) ?>">Ver detalhes e especificações →</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <div class="shop-empty-results" data-empty-results hidden>
        <strong>Nenhum produto encontrado.</strong>
        <p>Tente outro termo ou fale com nossa equipe para encontrar uma solução equivalente.</p>
    </div>
    <div class="shop-all-products-action"><p>Você está vendo o catálogo completo da MR Drives.</p><a href="#produtos">Todos os produtos <strong>(<?= count($products) ?>)</strong></a></div>
        </div>
    </div>
</section>
