<?php
use App\Core\Csrf;

$phoneDigits = preg_replace('/\D+/', '', (string) ($customer['phone'] ?? '')) ?? '';
$phone = strlen($phoneDigits) === 11
    ? sprintf('(%s) %s-%s', substr($phoneDigits, 0, 2), substr($phoneDigits, 2, 5), substr($phoneDigits, 7))
    : ($phoneDigits ?: 'Não informado');
$postalDigits = preg_replace('/\D+/', '', (string) ($customer['postal_code'] ?? '')) ?? '';
$postalCode = strlen($postalDigits) === 8 ? substr($postalDigits, 0, 5) . '-' . substr($postalDigits, 5) : 'Não informado';
$birthDate = !empty($customer['birth_date']) ? date('d/m/Y', strtotime((string) $customer['birth_date'])) : 'Não informada';
$address = $profileComplete
    ? trim(sprintf('%s, %s%s — %s, %s/%s', $customer['street'], $customer['address_number'], !empty($customer['complement']) ? ' — ' . $customer['complement'] : '', $customer['district'], $customer['city'], $customer['state']))
    : 'Complete seu endereço para agilizar futuros pedidos.';
?>
<section class="customer-account-page">
    <div class="customer-account-shell customer-dashboard">
        <?php if (!empty($message)): ?>
            <div class="customer-account-message customer-account-message--<?= e($message['type'] ?? 'success') ?>" role="status"><?= e($message['text'] ?? '') ?></div>
        <?php endif; ?>

        <header class="customer-dashboard-hero">
            <span class="customer-auth-icon"><i data-lucide="user-round"></i></span>
            <div>
                <p class="eyebrow">Minha conta</p>
                <h1>Olá, <?= e($customer['first_name'] ?? 'Cliente') ?>!</h1>
                <p>Gerencie seus dados e o status da sua conta MR Drives.</p>
            </div>
            <a href="/minha-conta/configuracoes"><i data-lucide="settings"></i> Editar perfil</a>
        </header>

        <?php if (!$profileComplete): ?>
            <div class="customer-profile-progress">
                <i data-lucide="circle-alert"></i>
                <div><strong>Seu perfil ainda está incompleto</strong><p>Adicione telefone, nascimento e endereço para deixar seus próximos atendimentos mais rápidos.</p></div>
                <a href="/minha-conta/configuracoes">Completar agora</a>
            </div>
        <?php endif; ?>

        <div class="customer-dashboard-grid">
            <article class="customer-dashboard-card">
                <div class="customer-dashboard-card-title"><i data-lucide="contact-round"></i><h2>Dados pessoais</h2></div>
                <dl class="customer-dashboard-list">
                    <div><dt>Nome completo</dt><dd><?= e(trim(($customer['first_name'] ?? '') . ' ' . ($customer['last_name'] ?? ''))) ?></dd></div>
                    <div><dt>E-mail</dt><dd><?= e($customer['email'] ?? '') ?></dd></div>
                    <div><dt>Telefone</dt><dd><?= e($phone) ?></dd></div>
                    <div><dt>Data de nascimento</dt><dd><?= e($birthDate) ?></dd></div>
                </dl>
            </article>

            <article class="customer-dashboard-card">
                <div class="customer-dashboard-card-title"><i data-lucide="map-pin-house"></i><h2>Endereço</h2></div>
                <dl class="customer-dashboard-list">
                    <div><dt>CEP</dt><dd><?= e($postalCode) ?></dd></div>
                    <div class="is-wide"><dt>Endereço principal</dt><dd><?= e($address) ?></dd></div>
                </dl>
            </article>
        </div>

        <div class="customer-verification-status <?= !empty($customer['email_verified_at']) ? 'is-verified' : 'is-pending' ?>">
            <i data-lucide="<?= !empty($customer['email_verified_at']) ? 'badge-check' : 'mail' ?>"></i>
            <div>
                <strong><?= !empty($customer['email_verified_at']) ? 'E-mail confirmado' : 'Confirme seu e-mail' ?></strong>
                <small><?= !empty($customer['email_verified_at']) ? 'Sua conta está verificada.' : 'Use o link enviado para ' . e($customer['email']) . '.' ?></small>
            </div>
            <?php if (empty($customer['email_verified_at'])): ?>
                <form action="/reenviar-confirmacao" method="post"><?= Csrf::field() ?><button type="submit">Reenviar link</button></form>
            <?php endif; ?>
        </div>

        <footer class="customer-account-actions customer-dashboard-actions">
            <a href="/catalogo">Ver produtos</a>
            <form action="/sair" method="post"><?= Csrf::field() ?><button type="submit">Sair da conta</button></form>
        </footer>
    </div>
</section>
