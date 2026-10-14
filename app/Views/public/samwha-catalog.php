<?php
use App\Services\SamwhaService;
$catalogUrl = static fn(int $id = 0, int $number = 1): string => '/samwha-dsp?' . http_build_query(array_filter(['categoria' => $id, 'q' => $query, 'ordem' => $sort, 'pagina' => $number > 1 ? $number : null]));
?>
<section class="shop-section samwha-mr-catalog" id="produtos"><div class="legacy-catalog-layout">
<aside class="legacy-catalog-sidebar" aria-label="Filtros Samwha DSP">
<div class="legacy-filter-group"><h2><span>Categorias</span><i data-lucide="chevron-left"></i></h2><div class="samwha-mr-categories">
<a class="<?= !$category ? 'is-active' : '' ?>" href="<?= e($catalogUrl()) ?>"><span></span>Todos os produtos<small>(<?= $catalogCount ?>)</small></a>
<?php foreach ($categories as $item): $children = $item['children'] ?? []; $active = $category === (int) $item['id'] || in_array($category, array_map(static fn($c) => (int) $c['id'], $children), true); ?>
<?php if ($children): ?><details <?= $active ? 'open' : '' ?>><summary><?= e($item['name']) ?></summary><a class="<?= $category === (int) $item['id'] ? 'is-active' : '' ?>" href="<?= e($catalogUrl((int) $item['id'])) ?>"><span></span>Todos desta categoria</a><?php foreach ($children as $child): ?><a class="<?= $category === (int) $child['id'] ? 'is-active' : '' ?>" href="<?= e($catalogUrl((int) $child['id'])) ?>"><span></span><?= e($child['name']) ?></a><?php endforeach; ?></details>
<?php else: ?><a class="<?= $active ? 'is-active' : '' ?>" href="<?= e($catalogUrl((int) $item['id'])) ?>"><span></span><?= e($item['name']) ?></a><?php endif; ?>
<?php endforeach; ?></div></div>
<div class="legacy-filter-group"><h2><span>Preço</span><i data-lucide="chevron-left"></i></h2><p class="samwha-filter-note">Preços sob consulta</p></div>
<div class="legacy-filter-group"><h2><span>Disponibilidade</span><i data-lucide="chevron-left"></i></h2><p class="samwha-filter-note">Consulte a disponibilidade em cada produto.</p></div>
<div class="legacy-filter-group"><h2><span>Marca</span><i data-lucide="chevron-left"></i></h2><p class="samwha-brand">✓ &nbsp; Samwha DSP <small>(<?= $catalogCount ?>)</small></p></div>
<a class="samwha-mr-manual" href="/downloads#manuais-samwha"><i data-lucide="download"></i> Manuais Samwha DSP</a>
</aside>
<div class="legacy-catalog-main"><nav class="legacy-catalog-breadcrumb" aria-label="Navegação estrutural"><a href="/">Início</a><span>›</span><strong>Produtos Samwha DSP</strong></nav>
<header class="legacy-catalog-heading"><div><span class="shop-kicker">Catálogo profissional</span><h1>Produtos Samwha DSP</h1></div><form action="/samwha-dsp" class="samwha-sort-form"><input type="hidden" name="categoria" value="<?= $category ?>"><input type="hidden" name="q" value="<?= e($query) ?>"><label class="shop-sort">Ordenar por: <select name="ordem"><option value="destaques" <?= $sort === 'destaques' ? 'selected' : '' ?>>Destaques</option><option value="nome" <?= $sort === 'nome' ? 'selected' : '' ?>>Nome A–Z</option></select></label><button type="submit">Aplicar</button></form></header>
<p class="legacy-catalog-description">Explore as soluções Samwha DSP para proteção, controle e medição industrial. Compare modelos, consulte especificações e baixe os manuais técnicos.</p>
<div class="legacy-catalog-toolbar"><form class="samwha-mr-search" action="/samwha-dsp"><label class="shop-search"><i data-lucide="search"></i><input name="q" type="search" value="<?= e($query) ?>" placeholder="Buscar por produto, modelo ou aplicação" aria-label="Buscar produto Samwha"></label><input type="hidden" name="categoria" value="<?= $category ?>"><input type="hidden" name="ordem" value="<?= e($sort) ?>"><button type="submit">Buscar</button></form><p><strong><?= $total ?></strong> produtos encontrados</p></div>
<div class="shop-product-grid">
<?php foreach ($products as $product): $url = '/samwha-dsp/produto/' . rawurlencode($product['slug']); $image = SamwhaService::asset($product['main_image_url'] ?? null); $manual = SamwhaService::asset($product['manual_path'] ?? null); ?>
<article class="shop-product-card"><a class="shop-product-image" href="<?= e($url) ?>"><?php if (!empty($product['is_featured'])): ?><span class="shop-product-badge">Destaque</span><?php endif; ?><?php if ($image): ?><img src="<?= e($image) ?>" alt="<?= e($product['name']) ?>" loading="lazy" decoding="async"><?php endif; ?></a><div class="shop-product-content"><div class="shop-product-meta"><span><?= e($product['category'] ?? '') ?></span><small><?= e($product['product_code'] ?? '') ?></small></div><a class="shop-product-title" href="<?= e($url) ?>"><h3><?= e($product['name']) ?></h3></a><p><?= e(SamwhaService::availability($product)) ?></p><div class="samwha-mr-card-actions"><a href="<?= e($url) ?>">Ver produto</a><?php if ($manual): ?><a href="<?= e($manual) ?>" target="_blank" rel="noopener"><i data-lucide="download"></i> Manual técnico</a><?php endif; ?></div></div></article>
<?php endforeach; ?></div>
<?php if (!$products): ?><p>Nenhum produto disponível para esta busca.</p><?php endif; ?>
<p class="samwha-page-range">Exibindo <?= $total ? ($page - 1) * 12 + 1 : 0 ?>–<?= min($page * 12, $total) ?> de <?= $total ?></p>
<?php if ($pages > 1): ?><nav class="samwha-pagination" aria-label="Paginação"><?php if ($page > 1): ?><a href="<?= e($catalogUrl($category, $page - 1)) ?>">←</a><?php endif; ?><?php for ($n = 1; $n <= $pages; $n++): if ($n !== 1 && $n !== $pages && abs($page - $n) > 2) { if (abs($page - $n) === 3) { echo '<span>…</span>'; } continue; } ?><a <?= $n === $page ? 'aria-current="page"' : '' ?> href="<?= e($catalogUrl($category, $n)) ?>"><?= $n ?></a><?php endfor; ?><?php if ($page < $pages): ?><a href="<?= e($catalogUrl($category, $page + 1)) ?>">→</a><?php endif; ?></nav><?php endif; ?>
</div></div></section>
