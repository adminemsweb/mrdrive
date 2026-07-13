<?php use App\Core\Csrf; ?>
<section class="admin-section">
    <h1>Documentos e catálogos</h1>
    <form class="admin-form compact" action="/admin/index.php?route=documents.store" method="post" enctype="multipart/form-data">
        <?= Csrf::field() ?>
        <label>Nome<input name="name" required></label>
        <label>Tipo
            <select name="type">
                <option value="catalogo">Catálogo</option>
                <option value="manual">Manual</option>
                <option value="ficha tecnica">Ficha técnica</option>
            </select>
        </label>
        <label>PDF<input type="file" name="file_path" accept=".pdf" required></label>
        <label><input type="checkbox" name="is_active" checked> Ativo</label>
        <button class="admin-btn" type="submit">Cadastrar documento</button>
    </form>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Nome</th><th>Tipo</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody>
                <?php foreach ($documents as $document): ?>
                    <tr>
                        <td><a href="<?= upload_url($document['file_path']) ?>" target="_blank"><?= e($document['name']) ?></a></td>
                        <td><?= e($document['type']) ?></td>
                        <td><?= $document['is_active'] ? 'Ativo' : 'Inativo' ?></td>
                        <td class="row-actions">
                            <form action="/admin/index.php?route=documents.toggle" method="post"><?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int) $document['id'] ?>"><button type="submit">Alternar</button></form>
                            <form action="/admin/index.php?route=documents.delete" method="post" onsubmit="return confirm('Excluir documento?')"><?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int) $document['id'] ?>"><button type="submit">Excluir</button></form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
