<?php use App\Core\Csrf; ?>
<section class="customer-account-page customer-settings-page">
    <div class="customer-settings-shell">
        <header class="customer-settings-header">
            <a href="/minha-conta">← Minha conta</a>
            <p class="eyebrow">Configurações</p>
            <h1>Seus dados e segurança</h1>
            <p>Mantenha seus dados pessoais e endereço atualizados.</p>
        </header>
        <?php if (!empty($message)): ?>
            <div class="customer-account-message customer-account-message--<?= e($message['type'] ?? 'success') ?>" role="status"><?= e($message['text'] ?? '') ?></div>
        <?php endif; ?>
        <div class="customer-settings-grid">
            <form class="customer-settings-card customer-auth-form customer-profile-form" action="/minha-conta/configuracoes" method="post" data-cep-lookup>
                <?= Csrf::field() ?>
                <div class="customer-settings-title"><i data-lucide="user-round"></i><div><strong>Perfil e endereço</strong><small>Campos com * são obrigatórios.</small></div></div>
                <fieldset>
                    <legend>Dados pessoais</legend>
                    <div class="customer-form-grid customer-form-grid--2">
                        <label>Nome *<input name="first_name" value="<?= e($customer['first_name'] ?? '') ?>" autocomplete="given-name" maxlength="80" required></label>
                        <label>Sobrenome *<input name="last_name" value="<?= e($customer['last_name'] ?? '') ?>" autocomplete="family-name" maxlength="120" required></label>
                        <label>Data de nascimento *<input type="date" name="birth_date" value="<?= e($customer['birth_date'] ?? '') ?>" autocomplete="bday" required></label>
                        <label>Telefone com DDD *<input type="tel" name="phone" value="<?= e($customer['phone'] ?? '') ?>" autocomplete="tel" inputmode="tel" maxlength="16" required></label>
                    </div>
                    <label>E-mail *<input type="email" name="email" value="<?= e($customer['email'] ?? '') ?>" autocomplete="email" required><small>Ao trocar o e-mail, será necessário confirmá-lo novamente.</small></label>
                </fieldset>
                <fieldset>
                    <legend>Endereço</legend>
                    <div class="customer-cep-row">
                        <label>CEP *<input name="postal_code" value="<?= e($customer['postal_code'] ?? '') ?>" autocomplete="postal-code" inputmode="numeric" maxlength="9" data-cep-input required></label>
                        <button type="button" class="customer-cep-button" data-cep-button>Buscar CEP</button>
                    </div>
                    <p class="customer-cep-status" data-cep-status aria-live="polite">O CEP preenche rua, bairro, cidade e UF.</p>
                    <div class="customer-form-grid customer-address-grid">
                        <label class="customer-field-street">Rua/Avenida *<input name="street" value="<?= e($customer['street'] ?? '') ?>" autocomplete="address-line1" maxlength="180" data-address-street required></label>
                        <label>Número *<input name="address_number" value="<?= e($customer['address_number'] ?? '') ?>" maxlength="30" required></label>
                        <label>Complemento<input name="complement" value="<?= e($customer['complement'] ?? '') ?>" maxlength="120"></label>
                        <label>Bairro *<input name="district" value="<?= e($customer['district'] ?? '') ?>" maxlength="120" data-address-district required></label>
                        <label>Cidade *<input name="city" value="<?= e($customer['city'] ?? '') ?>" maxlength="120" data-address-city required></label>
                        <label>UF *<input name="state" value="<?= e($customer['state'] ?? '') ?>" maxlength="2" data-address-state required></label>
                    </div>
                </fieldset>
                <label>Senha atual<input type="password" name="current_password" autocomplete="current-password"><small>Obrigatória somente para alterar o e-mail.</small></label>
                <button type="submit">Salvar perfil</button>
            </form>
            <aside class="customer-settings-side">
                <form class="customer-settings-card customer-auth-form" action="/minha-conta/senha" method="post">
                    <?= Csrf::field() ?>
                    <div class="customer-settings-title"><i data-lucide="lock-keyhole"></i><div><strong>Alterar senha</strong><small>Use uma senha exclusiva para a MR Drives.</small></div></div>
                    <label>Senha atual<input type="password" name="current_password" autocomplete="current-password" required></label>
                    <label>Nova senha<input type="password" name="password" minlength="8" autocomplete="new-password" required><small>Mínimo de 8 caracteres.</small></label>
                    <label>Confirmar nova senha<input type="password" name="password_confirmation" minlength="8" autocomplete="new-password" required></label>
                    <button type="submit">Alterar senha</button>
                </form>
                <div class="customer-settings-tip"><i data-lucide="shield-check"></i><div><strong>Seus dados ficam protegidos</strong><p>Usamos essas informações apenas para identificação, atendimento e futuras entregas.</p></div></div>
            </aside>
        </div>
    </div>
</section>
