<?php use App\Core\Csrf; ?>
<section class="customer-auth-page customer-register-page">
    <div class="customer-auth-card customer-register-card">
        <div class="customer-auth-heading">
            <span class="customer-auth-icon"><i data-lucide="user-plus"></i></span>
            <p class="eyebrow">Área do cliente</p>
            <h1>Crie sua conta</h1>
            <p>Preencha seus dados para deixar seu atendimento e suas futuras compras mais rápidos.</p>
        </div>
        <?php if (!empty($error)): ?><div class="customer-auth-error" role="alert"><?= e($error) ?></div><?php endif; ?>
        <form class="customer-auth-form customer-profile-form" action="/criar-conta" method="post" data-cep-lookup>
            <?= Csrf::field() ?>
            <fieldset>
                <legend>Dados pessoais</legend>
                <div class="customer-form-grid customer-form-grid--2">
                    <label>Nome *<input name="first_name" value="<?= e($old['first_name'] ?? '') ?>" autocomplete="given-name" maxlength="80" required></label>
                    <label>Sobrenome *<input name="last_name" value="<?= e($old['last_name'] ?? '') ?>" autocomplete="family-name" maxlength="120" required></label>
                    <label>Data de nascimento *<input type="date" name="birth_date" value="<?= e($old['birth_date'] ?? '') ?>" autocomplete="bday" required></label>
                    <label>Telefone com DDD *<input type="tel" name="phone" value="<?= e($old['phone'] ?? '') ?>" autocomplete="tel" inputmode="tel" maxlength="16" placeholder="(15) 99999-9999" required></label>
                </div>
                <label>E-mail *<input type="email" name="email" value="<?= e($old['email'] ?? '') ?>" autocomplete="email" required></label>
            </fieldset>

            <fieldset>
                <legend>Endereço</legend>
                <div class="customer-cep-row">
                    <label>CEP *<input name="postal_code" value="<?= e($old['postal_code'] ?? '') ?>" autocomplete="postal-code" inputmode="numeric" maxlength="9" data-cep-input required></label>
                    <button type="button" class="customer-cep-button" data-cep-button>Buscar CEP</button>
                </div>
                <p class="customer-cep-status" data-cep-status aria-live="polite">Digite o CEP para preencher o endereço automaticamente.</p>
                <div class="customer-form-grid customer-address-grid">
                    <label class="customer-field-street">Rua/Avenida *<input name="street" value="<?= e($old['street'] ?? '') ?>" autocomplete="address-line1" maxlength="180" data-address-street required></label>
                    <label>Número *<input name="address_number" value="<?= e($old['address_number'] ?? '') ?>" autocomplete="address-line2" maxlength="30" required></label>
                    <label>Complemento<input name="complement" value="<?= e($old['complement'] ?? '') ?>" maxlength="120" placeholder="Apto, bloco, sala..."></label>
                    <label>Bairro *<input name="district" value="<?= e($old['district'] ?? '') ?>" maxlength="120" data-address-district required></label>
                    <label>Cidade *<input name="city" value="<?= e($old['city'] ?? '') ?>" autocomplete="address-level2" maxlength="120" data-address-city required></label>
                    <label>UF *<input name="state" value="<?= e($old['state'] ?? '') ?>" autocomplete="address-level1" maxlength="2" data-address-state required></label>
                </div>
            </fieldset>

            <fieldset>
                <legend>Acesso</legend>
                <div class="customer-form-grid customer-form-grid--2">
                    <label>Senha *<input type="password" name="password" minlength="8" autocomplete="new-password" required><small>Mínimo de 8 caracteres.</small></label>
                    <label>Confirmar senha *<input type="password" name="password_confirmation" minlength="8" autocomplete="new-password" required></label>
                </div>
            </fieldset>
            <button type="submit" class="customer-profile-submit">Criar conta</button>
        </form>
        <p class="customer-auth-privacy">Ao criar sua conta, você concorda com os <a href="/termos-de-uso">Termos de uso</a> e a <a href="/politica-de-privacidade">Política de Privacidade</a>.</p>
        <p class="customer-auth-switch">Já possui uma conta? <a href="/entrar">Entrar</a></p>
    </div>
</section>
