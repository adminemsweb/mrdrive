<section class="admin-section">
    <h1>Dashboard</h1>
    <div class="metric-grid">
        <article><span>Total de produtos</span><strong><?= (int) $stats['total'] ?></strong></article>
        <article><span>Produtos ativos</span><strong><?= (int) $stats['active'] ?></strong></article>
        <article><span>Produtos inativos</span><strong><?= (int) $stats['inactive'] ?></strong></article>
        <article><span>Solicitações</span><strong><?= (int) $quotes['total'] ?></strong><small><?= (int) $quotes['unread'] ?> não lidas</small></article>
    </div>
</section>
