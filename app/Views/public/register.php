<?php use App\Core\Csrf; ?>
<section class="customer-auth-page">
    <div class="customer-auth-card">
        <div class="customer-auth-heading">
            <span class="customer-auth-icon"><i data-lucide="user-plus"></i></span>
            <p class="eyebrow">Área do cliente</p>
            <h1>Crie sua conta</h1>
            <p>Cadastre-se para acessar sua área de cliente e manter seus dados organizados.</p>
        </div>
        <?php if (!empty($error)): ?><div class="customer-auth-error" role="alert"><?= e($error) ?></div><?php endif; ?>
        <form class="customer-auth-form" action="/criar-conta" method="post">
            <?= Csrf::field() ?>
            <div class="customer-auth-name-grid">
                <label>Nome<input name="first_name" value="<?= e($old['first_name'] ?? '') ?>" autocomplete="given-name" maxlength="80" required></label>
                <label>Sobrenome<input name="last_name" value="<?= e($old['last_name'] ?? '') ?>" autocomplete="family-name" maxlength="120" required></label>
            </div>
            <label>E-mail<input type="email" name="email" value="<?= e($old['email'] ?? '') ?>" autocomplete="email" required></label>
            <label>Senha<input type="password" name="password" minlength="8" autocomplete="new-password" required><small>Mínimo de 8 caracteres.</small></label>
            <label>Confirmar senha<input type="password" name="password_confirmation" minlength="8" autocomplete="new-password" required></label>
            <button type="submit">Criar conta</button>
        </form>
        <p class="customer-auth-privacy">Ao criar sua conta, você concorda com os <a href="/termos-de-uso">Termos de uso</a> e a <a href="/politica-de-privacidade">Política de Privacidade</a>.</p>
        <p class="customer-auth-switch">Já possui uma conta? <a href="/entrar">Entrar</a></p>
    </div>
</section>
