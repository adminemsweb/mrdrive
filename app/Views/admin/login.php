<?php use App\Core\Csrf; ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | MRDRIVES</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="login-body">
    <form class="login-card" action="/admin/index.php?route=authenticate" method="post">
        <?= Csrf::field() ?>
        <div class="login-brand"><span>MR</span><p><strong>DRIVES</strong><small>Painel administrativo</small></p></div>
        <h1>Bem-vindo de volta</h1>
        <p>Acesse sua conta para gerenciar a loja.</p>
        <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
        <label>E-mail<input type="email" name="email" required autofocus></label>
        <label>Senha<input type="password" name="password" required></label>
        <button class="admin-btn" type="submit">Entrar</button>
        <a class="login-store-link" href="/">← Voltar para a loja</a>
    </form>
</body>
</html>
