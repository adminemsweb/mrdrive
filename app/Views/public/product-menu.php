<div class="product-menu-categories">
    <?php foreach ($productMenuGroups as $group): ?>
        <section class="product-menu-category" aria-label="<?= e($group['title']) ?>">
            <h3><?= e($group['title']) ?></h3>
            <div class="product-menu-columns" aria-hidden="true"><span>Modelo</span><span>Marca</span></div>
            <?php foreach ($group['models'] as [$label, $href]): ?>
                <?php [$model, $brand] = array_pad(explode(' · ', $label, 2), 2, 'MR Drives'); ?>
                <a class="product-menu-model" href="<?= e($href) ?>" aria-label="<?= e($model . ', marca ' . $brand) ?>">
                    <span><?= e($model) ?></span><small><?= e($brand) ?></small>
                </a>
            <?php endforeach; ?>
        </section>
    <?php endforeach; ?>
</div>
