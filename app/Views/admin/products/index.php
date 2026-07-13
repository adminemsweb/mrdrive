<?php use App\Core\Csrf; ?>
<section class="admin-section">
    <div class="admin-heading">
        <h1>Produtos</h1>
        <a class="admin-btn" href="/admin/index.php?route=products.create">Novo produto</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Ordem</th><th>Nome</th><th>Modelo</th><th>Potência</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= (int) $product['sort_order'] ?></td>
                        <td><?= e($product['name']) ?></td>
                        <td><?= e($product['model_code']) ?></td>
                        <td><?= e($product['power']) ?></td>
                        <td><?= $product['is_active'] ? 'Ativo' : 'Inativo' ?></td>
                        <td class="row-actions">
                            <a href="/admin/index.php?route=products.edit&id=<?= (int) $product['id'] ?>">Editar</a>
                            <form action="/admin/index.php?route=products.delete" method="post" onsubmit="return confirm('Excluir este produto?')">
                                <?= Csrf::field() ?>
                                <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
