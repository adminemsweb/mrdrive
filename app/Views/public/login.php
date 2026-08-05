<?php use App\Core\Csrf; ?>
<section class="customer-auth-page">
    <div class="customer-auth-card">
        <div class="customer-auth-heading">
            <span class="customer-auth-icon"><i data-lucide="user-round"></i></span>
            <p class="eyebrow">Área do cliente</p>
            <h1>Entre na sua conta</h1>
            <p>Acesse seus dados e acompanhe suas solicitações.</p>
        </div>
        <?php if (!empty($error)): ?><div class="customer-auth-error" role="alert"><?= e($error) ?></div><?php endif; ?>
        <form class="customer-auth-form" action="/entrar" method="post">
            <?= Csrf::field() ?>
            <label>E-mail<input type="email" name="email" value="<?= e($old['email'] ?? '') ?>" autocomplete="email" required></label>
            <label>Senha<input type="password" name="password" autocomplete="current-password" required></label>
            <button type="submit">Entrar</button>
        </form>
        <p class="customer-auth-switch">Ainda não tem conta? <a href="/criar-conta">Criar conta</a></p>
    </div>
</section>
