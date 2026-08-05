<?php
use App\Core\Csrf;

$editing = !empty($product);
$saleChannel = $product['sale_channel'] ?? 'whatsapp';
$cartEnabled = (bool) (app_config('store')['cart_enabled'] ?? false);
?>
<section class="admin-section admin-product-editor">
    <div class="admin-page-intro">
        <div><a class="admin-back" href="/admin/index.php?route=products">← Voltar aos produtos</a><span class="admin-eyebrow"><?= $editing ? 'Edição de produto' : 'Novo cadastro' ?></span><h1><?= $editing ? e($product['name']) : 'Cadastrar produto' ?></h1><p>Preencha as informações que serão usadas no catálogo e na página do produto.</p></div>
        <?php if ($editing && !empty($product['is_active'])): ?><a class="admin-secondary-btn" href="/produto?id=<?= (int) $product['id'] ?>" target="_blank" rel="noopener">Visualizar na loja ↗</a><?php endif; ?>
    </div>

    <form class="admin-form admin-product-form" action="/admin/index.php?route=<?= $editing ? 'products.update' : 'products.store' ?>" method="post" enctype="multipart/form-data" data-product-form>
        <?= Csrf::field() ?>
        <?php if ($editing): ?><input type="hidden" name="id" value="<?= (int) $product['id'] ?>"><?php endif; ?>

        <div class="admin-editor-layout">
            <div class="admin-editor-main">
                <fieldset class="admin-form-card">
                    <legend><span>1</span><strong>Identificação</strong><small>Dados principais para reconhecer o produto.</small></legend>
                    <div class="form-grid">
                        <label>Nome do produto<input name="name" value="<?= e($product['name'] ?? '') ?>" placeholder="Ex.: MRD700" required></label>
                        <label>Código ou modelo<input name="model_code" value="<?= e($product['model_code'] ?? '') ?>" placeholder="Ex.: MRD700" required></label>
                        <label>Categoria<input name="category" value="<?= e($product['category'] ?? '') ?>" placeholder="Ex.: Alto desempenho"></label>
                        <label>SKU<input name="sku" value="<?= e($product['sku'] ?? '') ?>" placeholder="Ex.: MRD700-4T-5K5"></label>
                        <label>Faixa de potência<input name="power" value="<?= e($product['power'] ?? '') ?>" placeholder="Ex.: 0,4 kW a 400 kW"></label>
                        <label>Tensão<input name="voltage" value="<?= e($product['voltage'] ?? '') ?>" placeholder="Ex.: 220 V / 380 V / 480 V"></label>
                    </div>
                </fieldset>

                <fieldset class="admin-form-card">
                    <legend><span>2</span><strong>Venda e estoque</strong><small>Defina como o cliente poderá comprar.</small></legend>
                    <label>Canal de venda
                        <select name="sale_channel" data-sale-channel>
                            <option value="whatsapp" <?= $saleChannel !== 'cart' ? 'selected' : '' ?>>Sob consulta · comprar via WhatsApp</option>
                            <option value="cart" <?= $saleChannel === 'cart' ? 'selected' : '' ?> <?= !$cartEnabled ? 'disabled' : '' ?>>Venda direta · comprar pela loja<?= !$cartEnabled ? ' (aguardando pagamentos)' : '' ?></option>
                        </select>
                    </label>
                    <div class="admin-sale-hint" data-sale-hint></div>
                    <div class="form-grid" data-direct-sale-fields>
                        <label>Preço de venda (R$)<input type="number" name="price" min="0" step="0.01" value="<?= e((string) ($product['price'] ?? '')) ?>" placeholder="0,00"></label>
                        <label>Preço anterior (R$)<input type="number" name="compare_at_price" min="0" step="0.01" value="<?= e((string) ($product['compare_at_price'] ?? '')) ?>" placeholder="Opcional"></label>
                        <label>Estoque disponível<input type="number" name="stock_quantity" min="0" value="<?= e((string) ($product['stock_quantity'] ?? 0)) ?>"></label>
                        <label>Prazo de envio<input name="shipping_days" value="<?= e($product['shipping_days'] ?? '') ?>" placeholder="Ex.: até 2 dias úteis"></label>
                    </div>
                    <label class="admin-switch"><input type="checkbox" name="track_stock" <?= !empty($product['track_stock']) ? 'checked' : '' ?>><span></span><p><strong>Controlar estoque</strong><small>Impedir pedidos quando a quantidade chegar a zero.</small></p></label>
                </fieldset>

                <fieldset class="admin-form-card">
                    <legend><span>3</span><strong>Conteúdo do produto</strong><small>Textos apresentados ao cliente durante a escolha.</small></legend>
                    <label>Descrição curta<textarea name="short_description" rows="3" placeholder="Resumo usado nos cards e no início da página."><?= e($product['short_description'] ?? '') ?></textarea></label>
                    <label>Descrição completa<textarea name="full_description" rows="6" placeholder="Apresente os benefícios, diferenciais e contexto de uso."><?= e($product['full_description'] ?? '') ?></textarea></label>
                    <div class="form-grid">
                        <label>Aplicações recomendadas<textarea name="recommended_applications" rows="6" placeholder="Uma aplicação por linha facilita a leitura."><?= e($product['recommended_applications'] ?? '') ?></textarea></label>
                        <label>Especificações técnicas<textarea name="technical_specs" rows="6" placeholder="Uma especificação por linha."><?= e($product['technical_specs'] ?? '') ?></textarea></label>
                    </div>
                </fieldset>

                <fieldset class="admin-form-card">
                    <legend><span>4</span><strong>Imagens e documentos</strong><small>Use arquivos nítidos e bem centralizados.</small></legend>
                    <div class="admin-media-grid">
                        <label class="admin-upload-card">Imagem principal<small>PNG, JPG ou WEBP · até 8 MB</small><input type="file" name="main_image" accept=".jpg,.jpeg,.png,.webp" data-image-input><span>Selecionar imagem</span></label>
                        <div class="admin-main-preview" data-image-preview><?php if ($editing && !empty($product['main_image'])): ?><img src="<?= e(upload_url($product['main_image'])) ?>" alt="Imagem atual de <?= e($product['name']) ?>"><?php else: ?><p>A prévia da imagem aparecerá aqui.</p><?php endif; ?></div>
                        <label class="admin-upload-card">Manual ou ficha técnica<small>Arquivo PDF · até 8 MB</small><input type="file" name="manual_pdf" accept=".pdf" data-file-input><span>Selecionar PDF</span><b data-file-name><?= !empty($product['manual_pdf']) ? 'PDF já cadastrado' : 'Nenhum arquivo selecionado' ?></b></label>
                        <label class="admin-upload-card">Galeria de imagens<small>Você pode selecionar vários arquivos.</small><input type="file" name="gallery[]" accept=".jpg,.jpeg,.png,.webp" multiple data-gallery-input><span>Adicionar à galeria</span><b data-gallery-count>Nenhuma nova imagem</b></label>
                    </div>
                    <?php if ($editing && $images): ?>
                        <h2 class="admin-gallery-title">Galeria cadastrada <small><?= count($images) ?> imagens</small></h2>
                        <div class="admin-gallery">
                            <?php foreach ($images as $image): ?>
                                <div><img src="<?= e(upload_url($image['image_path'])) ?>" alt=""><button type="submit" form="remove-image-<?= (int) $image['id'] ?>">Remover</button></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </fieldset>
            </div>

            <aside class="admin-editor-sidebar">
                <fieldset class="admin-form-card admin-publish-card">
                    <legend><strong>Publicação</strong><small>Controle a exibição na loja.</small></legend>
                    <label class="admin-switch"><input type="checkbox" name="is_active" <?= (!$editing || !empty($product['is_active'])) ? 'checked' : '' ?>><span></span><p><strong>Produto ativo</strong><small>Visível no catálogo público.</small></p></label>
                    <label class="admin-switch"><input type="checkbox" name="is_featured" <?= !empty($product['is_featured']) ? 'checked' : '' ?>><span></span><p><strong>Destaque</strong><small>Prioridade nas vitrines.</small></p></label>
                    <label class="admin-switch"><input type="checkbox" name="is_offer" <?= !empty($product['is_offer']) ? 'checked' : '' ?>><span></span><p><strong>Oferta</strong><small>Exibe selo promocional.</small></p></label>
                    <label class="admin-switch"><input type="checkbox" name="is_best_seller" <?= !empty($product['is_best_seller']) ? 'checked' : '' ?>><span></span><p><strong>Mais vendido</strong><small>Destaca a procura do item.</small></p></label>
                    <label class="admin-switch"><input type="checkbox" name="is_new" <?= !empty($product['is_new']) ? 'checked' : '' ?>><span></span><p><strong>Lançamento</strong><small>Marca o produto como novidade.</small></p></label>
                    <label>Ordem no catálogo<input type="number" name="sort_order" value="<?= e((string) ($product['sort_order'] ?? 0)) ?>"><small>Menores números aparecem primeiro.</small></label>
                </fieldset>
                <div class="admin-save-panel">
                    <p><strong><?= $editing ? 'Salvar alterações' : 'Publicar produto' ?></strong><span>Revise os campos antes de concluir.</span></p>
                    <button class="admin-btn" type="submit"><?= $editing ? 'Salvar produto' : 'Cadastrar produto' ?></button>
                    <a href="/admin/index.php?route=products">Cancelar</a>
                </div>
            </aside>
        </div>
    </form>

    <?php if ($editing && $images): ?>
        <?php foreach ($images as $image): ?>
            <form id="remove-image-<?= (int) $image['id'] ?>" action="/admin/index.php?route=products.image.delete" method="post" onsubmit="return confirm('Remover esta imagem da galeria?')">
                <?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int) $image['id'] ?>"><input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
            </form>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
