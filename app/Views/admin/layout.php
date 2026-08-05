<?php
use App\Core\Auth;

$route = (string) ($_GET['route'] ?? 'dashboard');
$currentSection = str_contains($route, '.') ? strstr($route, '.', true) : $route;
$adminUser = Auth::user();
$initials = strtoupper(substr((string) ($adminUser['name'] ?? 'Admin'), 0, 1));
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin MRDRIVES</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script src="/assets/js/admin.js" defer></script>
</head>
<body>
    <aside class="admin-sidebar">
        <a class="admin-brand" href="/admin/"><span>MR</span><strong>DRIVES</strong><small>Gestão da loja</small></a>
        <nav>
            <span class="admin-nav-label">Operação</span>
            <a class="<?= $currentSection === 'dashboard' ? 'is-active' : '' ?>" href="/admin/index.php" data-admin-icon="dashboard">Visão geral</a>
            <a class="<?= $currentSection === 'products' ? 'is-active' : '' ?>" href="/admin/index.php?route=products" data-admin-icon="products">Produtos</a>
            <a class="<?= $currentSection === 'quotes' ? 'is-active' : '' ?>" href="/admin/index.php?route=quotes" data-admin-icon="quotes">Solicitações</a>
            <a class="<?= $currentSection === 'documents' ? 'is-active' : '' ?>" href="/admin/index.php?route=documents" data-admin-icon="documents">Documentos</a>
            <?php if (Auth::isOwner()): ?><a class="<?= $currentSection === 'users' ? 'is-active' : '' ?>" href="/admin/index.php?route=users" data-admin-icon="users">Equipe</a><?php endif; ?>
            <span class="admin-nav-label">Atalhos</span>
            <a href="/" target="_blank" rel="noopener" data-admin-icon="site">Abrir loja</a>
        </nav>
        <a class="admin-logout" href="/admin/index.php?route=logout">Sair do painel</a>
    </aside>
    <main class="admin-main">
        <header class="admin-topbar">
            <button class="admin-menu-toggle" type="button" data-admin-menu aria-label="Abrir menu">☰</button>
            <div><strong>Painel administrativo</strong><small>Controle da operação MR Drives</small></div>
            <div class="admin-user"><span><?= e($initials) ?></span><p><strong><?= e($adminUser['name'] ?? 'Admin') ?></strong><small><?= Auth::isOwner() ? 'Proprietário' : 'Administrador' ?></small></p></div>
        </header>
        <?php if (!empty($_SESSION['admin_error'])): ?>
            <div class="admin-flash alert"><strong>Não foi possível concluir.</strong><?= e($_SESSION['admin_error']) ?></div>
            <?php unset($_SESSION['admin_error']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['admin_success'])): ?>
            <div class="admin-flash alert-success"><strong>Tudo certo.</strong><?= e($_SESSION['admin_success']) ?></div>
            <?php unset($_SESSION['admin_success']); ?>
        <?php endif; ?>
        <?= $content ?>
    </main>
</body>
</html>
