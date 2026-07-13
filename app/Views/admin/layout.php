<?php use App\Core\Auth; use App\Core\Csrf; ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin MRDRIVES</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <aside class="admin-sidebar">
        <a class="admin-brand" href="/admin/">MRDRIVES</a>
        <nav>
            <a href="/admin/index.php">Dashboard</a>
            <a href="/admin/index.php?route=products">Produtos</a>
            <a href="/admin/index.php?route=documents">Documentos</a>
            <a href="/admin/index.php?route=quotes">Solicitações</a>
            <a href="/" target="_blank">Ver site</a>
            <a href="/admin/index.php?route=logout">Sair</a>
        </nav>
    </aside>
    <main class="admin-main">
        <header class="admin-topbar">
            <span><?= e(Auth::user()['name'] ?? 'Admin') ?></span>
        </header>
        <?php if (!empty($_SESSION['admin_error'])): ?>
            <div class="alert"><?= e($_SESSION['admin_error']) ?></div>
            <?php unset($_SESSION['admin_error']); ?>
        <?php endif; ?>
        <?= $content ?>
    </main>
</body>
</html>
