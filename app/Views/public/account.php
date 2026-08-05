<?php use App\Core\Csrf; ?>
<section class="customer-account-page">
    <div class="customer-account-card">
        <span class="customer-auth-icon"><i data-lucide="user-round"></i></span>
        <div>
            <p class="eyebrow">Minha conta</p>
            <h1>Olá, <?= e($customer['first_name'] ?? explode(' ', trim((string) ($customer['name'] ?? 'Cliente')))[0]) ?>!</h1>
            <p>Sua conta MR Drives está ativa.</p>
        </div>
        <dl class="customer-account-details">
            <div><dt>Nome</dt><dd><?= e($customer['first_name'] ?? '') ?></dd></div>
            <div><dt>Sobrenome</dt><dd><?= e($customer['last_name'] ?? '') ?></dd></div>
            <div><dt>E-mail</dt><dd><?= e($customer['email'] ?? '') ?></dd></div>
        </dl>
        <div class="customer-account-actions">
            <a href="/catalogo">Ver produtos</a>
            <form action="/sair" method="post"><?= Csrf::field() ?><button type="submit">Sair da conta</button></form>
        </div>
    </div>
</section>
