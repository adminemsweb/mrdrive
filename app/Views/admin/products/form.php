<?php use App\Core\Csrf; ?>
<?php $editing = !empty($product); ?>
<section class="admin-section">
    <div class="admin-heading">
        <h1><?= $editing ? 'Editar produto' : 'Novo produto' ?></h1>
        <a href="/admin/index.php?route=products">Voltar</a>
    </div>
    <form class="admin-form" action="/admin/index.php?route=<?= $editing ? 'products.update' : 'products.store' ?>" method="post" enctype="multipart/form-data">
        <?= Csrf::field() ?>
        <?php if ($editing): ?><input type="hidden" name="id" value="<?= (int) $product['id'] ?>"><?php endif; ?>
        <div class="form-grid">
            <label>Nome<input name="name" value="<?= e($product['name'] ?? '') ?>" required></label>
            <label>Código/modelo<input name="model_code" value="<?= e($product['model_code'] ?? '') ?>" required></label>
            <label>Categoria<input name="category" value="<?= e($product['category'] ?? '') ?>"></label>
            <label>Ordem<input type="number" name="sort_order" value="<?= e((string) ($product['sort_order'] ?? 0)) ?>"></label>
            <label>Potência<input name="power" value="<?= e($product['power'] ?? '') ?>"></label>
            <label>Tensão<input name="voltage" value="<?= e($product['voltage'] ?? '') ?>"></label>
        </div>
        <label>Descrição curta<textarea name="short_description" rows="3"><?= e($product['short_description'] ?? '') ?></textarea></label>
        <label>Descrição completa<textarea name="full_description" rows="6"><?= e($product['full_description'] ?? '') ?></textarea></label>
        <label>Aplicações recomendadas<textarea name="recommended_applications" rows="4"><?= e($product['recommended_applications'] ?? '') ?></textarea></label>
        <label>Especificações técnicas<textarea name="technical_specs" rows="6"><?= e($product['technical_specs'] ?? '') ?></textarea></label>
        <div class="form-grid">
            <label>Imagem principal<input type="file" name="main_image" accept=".jpg,.jpeg,.png,.webp"></label>
            <label>Manual PDF<input type="file" name="manual_pdf" accept=".pdf"></label>
            <label>Galeria de imagens<input type="file" name="gallery[]" accept=".jpg,.jpeg,.png,.webp" multiple></label>
        </div>
        <div class="checks">
            <label><input type="checkbox" name="is_active" <?= (!$editing || $product['is_active']) ? 'checked' : '' ?>> Ativo</label>
            <label><input type="checkbox" name="is_featured" <?= (!empty($product['is_featured'])) ? 'checked' : '' ?>> Destaque</label>
        </div>
        <?php if ($editing && $images): ?>
            <h2>Galeria cadastrada</h2>
            <div class="admin-gallery">
                <?php foreach ($images as $image): ?>
                    <div>
                        <img src="<?= upload_url($image['image_path']) ?>" alt="">
                        <form action="/admin/index.php?route=products.image.delete" method="post">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="id" value="<?= (int) $image['id'] ?>">
                            <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                            <button type="submit">Remover</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <button class="admin-btn" type="submit">Salvar produto</button>
    </form>
</section>
