<?php use App\Core\Csrf; ?>
<section class="admin-section">
    <div class="admin-page-intro">
        <div><span class="admin-eyebrow">Controle de acesso</span><h1>Equipe administrativa</h1><p>Crie uma conta individual para cada pessoa que trabalhará no painel.</p></div>
    </div>

    <div class="admin-users-layout">
        <form class="admin-form-card admin-user-create" action="/admin/index.php?route=users.store" method="post">
            <?= Csrf::field() ?>
            <header><span class="admin-eyebrow">Novo acesso</span><h2>Cadastrar administrador</h2><p>Não compartilhe a conta proprietária. Cada pessoa deve usar sua própria senha.</p></header>
            <label>Nome completo<input name="name" autocomplete="name" required placeholder="Nome da pessoa"></label>
            <label>E-mail profissional<input type="email" name="email" autocomplete="email" required placeholder="nome@empresa.com.br"></label>
            <label>Senha temporária<input type="password" name="password" minlength="12" autocomplete="new-password" required placeholder="Mínimo de 12 caracteres"><small>Envie essa senha por um canal privado e peça a troca no primeiro acesso.</small></label>
            <button class="admin-btn" type="submit">Criar acesso</button>
        </form>

        <div class="admin-team-list">
            <div class="admin-team-summary"><strong><?= count($users) ?></strong><span><?= count($users) === 1 ? 'pessoa cadastrada' : 'pessoas cadastradas' ?></span></div>
            <?php foreach ($users as $user): ?>
                <?php $owner = ($user['role'] ?? '') === 'owner'; ?>
                <article class="admin-team-member <?= empty($user['is_active']) ? 'is-inactive' : '' ?>">
                    <span class="admin-team-avatar"><?= e(strtoupper(substr($user['name'], 0, 1))) ?></span>
                    <div class="admin-team-identity"><strong><?= e($user['name']) ?></strong><span><?= e($user['email']) ?></span><small>Último acesso: <?= !empty($user['last_login_at']) ? e(date('d/m/Y H:i', strtotime($user['last_login_at']))) : 'ainda não acessou' ?></small></div>
                    <span class="admin-badge <?= $owner ? 'badge-owner' : (!empty($user['is_active']) ? 'badge-active' : 'badge-inactive') ?>"><?= $owner ? 'Proprietário' : (!empty($user['is_active']) ? 'Ativo' : 'Suspenso') ?></span>
                    <?php if (!$owner): ?>
                        <div class="admin-team-actions">
                            <form action="/admin/index.php?route=users.toggle" method="post" onsubmit="return confirm('<?= !empty($user['is_active']) ? 'Suspender o acesso desta pessoa?' : 'Reativar o acesso desta pessoa?' ?>')">
                                <?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int) $user['id'] ?>"><button type="submit"><?= !empty($user['is_active']) ? 'Suspender' : 'Reativar' ?></button>
                            </form>
                            <details><summary>Trocar senha</summary><form action="/admin/index.php?route=users.password" method="post"><?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int) $user['id'] ?>"><input type="password" name="password" minlength="12" required placeholder="Nova senha"><button type="submit">Atualizar</button></form></details>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
