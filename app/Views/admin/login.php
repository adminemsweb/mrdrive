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
        <h1>MRDRIVES</h1>
        <p>Acesse o painel administrativo.</p>
        <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
        <label>E-mail<input type="email" name="email" required autofocus></label>
        <label>Senha<input type="password" name="password" required></label>
        <button class="admin-btn" type="submit">Entrar</button>
    </form>
</body>
</html>
