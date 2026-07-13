<?php use App\Core\Csrf; ?>
<section class="admin-section">
    <h1>Solicitações de orçamento</h1>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Data</th><th>Nome</th><th>Empresa</th><th>Produto</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody>
                <?php foreach ($quotes as $quote): ?>
                    <tr>
                        <td><?= e(date('d/m/Y H:i', strtotime($quote['created_at']))) ?></td>
                        <td><?= e($quote['name']) ?></td>
                        <td><?= e($quote['company']) ?></td>
                        <td><?= e($quote['product_interest']) ?></td>
                        <td><?= $quote['is_read'] ? 'Lida' : 'Não lida' ?></td>
                        <td class="row-actions">
                            <a href="/admin/index.php?route=quotes.show&id=<?= (int) $quote['id'] ?>">Ver</a>
                            <form action="/admin/index.php?route=quotes.toggle" method="post"><?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int) $quote['id'] ?>"><button type="submit">Alternar</button></form>
                            <form action="/admin/index.php?route=quotes.delete" method="post" onsubmit="return confirm('Excluir solicitação?')"><?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int) $quote['id'] ?>"><button type="submit">Excluir</button></form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
