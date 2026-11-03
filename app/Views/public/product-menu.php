<div class="product-menu-categories">
    <?php foreach ($productMenuGroups as $group): ?>
        <section class="product-menu-category" aria-label="<?= e($group['title']) ?>">
            <h3><?= e($group['title']) ?></h3>
            <p>Modelos</p>
            <?php foreach ($group['models'] as [$label, $href]): ?>
                <a href="<?= e($href) ?>"><?= e($label) ?></a>
            <?php endforeach; ?>
        </section>
    <?php endforeach; ?>
</div>
