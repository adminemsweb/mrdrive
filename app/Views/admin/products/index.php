<?php use App\Core\Csrf; ?>
<section class="admin-section">
    <div class="admin-page-intro">
        <div><span class="admin-eyebrow">Catálogo</span><h1>Produtos</h1><p>Cadastre, publique e atualize as condições comerciais da loja.</p></div>
        <a class="admin-btn" href="/admin/index.php?route=products.create">+ Novo produto</a>
    </div>
    <div class="admin-catalog-tools">
        <label class="admin-search"><span>Buscar</span><input type="search" placeholder="Nome, modelo ou SKU" data-product-search></label>
        <label><span>Status</span><select data-product-status><option value="all">Todos</option><option value="active">Ativos</option><option value="inactive">Inativos</option></select></label>
        <label><span>Canal de venda</span><select data-product-channel><option value="all">Todos</option><option value="cart">Loja</option><option value="whatsapp">WhatsApp</option></select></label>
        <strong class="admin-product-count" data-product-count><?= count($products) ?> produtos</strong>
    </div>
    <div class="table-wrap admin-product-table">
        <table>
            <thead><tr><th>Produto</th><th>SKU</th><th>Preço</th><th>Venda</th><th>Estoque</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <?php
                    $channel = ($product['sale_channel'] ?? 'whatsapp') === 'cart' ? 'cart' : 'whatsapp';
                    $status = !empty($product['is_active']) ? 'active' : 'inactive';
                    $search = strtolower(trim(($product['name'] ?? '') . ' ' . ($product['model_code'] ?? '') . ' ' . ($product['sku'] ?? '')));
                    ?>
                    <tr data-product-row data-status="<?= $status ?>" data-channel="<?= $channel ?>" data-search="<?= e($search) ?>">
                        <td><div class="admin-product-cell">
                            <span class="admin-product-thumb"><?php if (!empty($product['main_image'])): ?><img src="<?= e(upload_url($product['main_image'])) ?>" alt=""><?php else: ?><b>MR</b><?php endif; ?></span>
                            <span><strong><?= e($product['name']) ?></strong><small><?= e($product['model_code']) ?> · ordem <?= (int) $product['sort_order'] ?></small></span>
                        </div></td>
                        <td><?= e($product['sku'] ?: $product['model_code']) ?></td>
                        <td><strong><?= $product['price'] !== null ? money_br((float) $product['price']) : 'Sob consulta' ?></strong></td>
                        <td><span class="admin-badge <?= $channel === 'cart' ? 'badge-store' : 'badge-whatsapp' ?>"><?= $channel === 'cart' ? 'Loja' : 'WhatsApp' ?></span></td>
                        <td><?= !empty($product['track_stock']) ? (int) $product['stock_quantity'] . ' un.' : 'Não controlado' ?></td>
                        <td><span class="admin-badge <?= $status === 'active' ? 'badge-active' : 'badge-inactive' ?>"><?= $status === 'active' ? 'Ativo' : 'Inativo' ?></span></td>
                        <td class="row-actions">
                            <a href="/admin/index.php?route=products.edit&id=<?= (int) $product['id'] ?>">Editar</a>
                            <form action="/admin/index.php?route=products.delete" method="post" onsubmit="return confirm('Excluir este produto? Esta ação não pode ser desfeita.')">
                                <?= Csrf::field() ?>
                                <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="admin-empty-filter" data-product-empty hidden><td colspan="7">Nenhum produto encontrado com esses filtros.</td></tr>
            </tbody>
        </table>
    </div>
</section>
