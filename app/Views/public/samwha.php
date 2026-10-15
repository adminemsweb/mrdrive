<?php
use App\Services\SamwhaService;
$catalogUrl = static fn(int $id = 0, int $number = 1): string => '/samwha-dsp?' . http_build_query(array_filter(['categoria' => $id, 'q' => $query, 'pagina' => $number > 1 ? $number : null]));
?>
<div class="samwha-page">
<?php if ($result['unavailable']): ?><p class="samwha-notice" role="status"><?= $result['stale'] ? 'Exibindo a última consulta disponível. Confirme a disponibilidade com nossa equipe.' : 'Catálogo temporariamente indisponível. Consulte nossa equipe.' ?></p><?php endif; ?>
<?php if (!$detail): ?>
<?php require app_path('Views/public/samwha-catalog.php'); ?>
<?php elseif ($result['data']): $product = $result['data']; $image = SamwhaService::asset($product['main_image_url'] ?? null); $manual = SamwhaService::asset($product['manual_path'] ?? null); $technicalImages = array_filter(array_unique(array_merge($product['specifications_image_urls'] ?? [], [$product['specifications_image_url'] ?? '']))); ?>
<?php require app_path('Views/public/samwha-product.php'); ?>
<?php if ($technicalImages || !empty($product['specifications'])): ?><section class="samwha-specs"><header><span>DADOS DO PRODUTO</span><h2>Especificações técnicas</h2><div class="samwha-accent"></div></header><div class="samwha-specs-panel"><?php foreach ($technicalImages as $path): $technicalImage = SamwhaService::asset($path); if (!$technicalImage) { continue; } ?><img src="<?= e($technicalImage) ?>" alt="Especificações técnicas de <?= e($product['name']) ?>" loading="lazy"><?php endforeach; ?><?php if (!empty($product['specifications'])): ?><dl><?php foreach ($product['specifications'] as $key => $value): ?><div><dt><?= e(is_string($key) ? $key : (is_array($value) ? (string) ($value['name'] ?? $value['label'] ?? 'Especificação') : 'Especificação')) ?></dt><dd><?= e(is_array($value) ? (string) ($value['value'] ?? implode(' · ', array_map(static fn($v) => is_scalar($v) ? (string) $v : '', $value))) : (string) $value) ?></dd></div><?php endforeach; ?></dl><?php endif; ?></div></section><?php endif; ?>
<?php else: ?><section class="samwha-detail"><a class="samwha-back" href="/samwha-dsp">← Voltar aos produtos</a><h1><?= $result['unavailable'] ? 'Produto temporariamente indisponível' : 'Produto não encontrado' ?></h1></section><?php endif; ?>
</div>
