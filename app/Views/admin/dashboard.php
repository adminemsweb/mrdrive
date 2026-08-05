<section class="admin-section">
    <div class="admin-page-intro">
        <div><span class="admin-eyebrow">Visão geral</span><h1>Bom trabalho hoje.</h1><p>Acompanhe os produtos e as solicitações recebidas pela loja.</p></div>
        <a class="admin-btn" href="/admin/index.php?route=products.create">+ Cadastrar produto</a>
    </div>
    <div class="metric-grid">
        <article class="metric-products"><span>Produtos cadastrados</span><strong><?= (int) $stats['total'] ?></strong><small>Itens gerenciados no catálogo</small></article>
        <article class="metric-active"><span>Produtos publicados</span><strong><?= (int) $stats['active'] ?></strong><small>Visíveis para os clientes</small></article>
        <article class="metric-inactive"><span>Rascunhos e inativos</span><strong><?= (int) $stats['inactive'] ?></strong><small>Fora da loja no momento</small></article>
        <article class="metric-quotes"><span>Solicitações comerciais</span><strong><?= (int) $quotes['total'] ?></strong><small><?= (int) $quotes['unread'] ?> aguardando leitura</small></article>
    </div>
    <div class="admin-dashboard-grid">
        <article class="admin-panel-card">
            <header><div><span class="admin-eyebrow">Ações rápidas</span><h2>O que você deseja fazer?</h2></div></header>
            <div class="admin-quick-actions">
                <a href="/admin/index.php?route=products.create"><strong>Novo produto</strong><span>Cadastre informações, preço e imagens.</span></a>
                <a href="/admin/index.php?route=products"><strong>Gerenciar catálogo</strong><span>Edite status, estoque e conteúdo.</span></a>
                <a href="/admin/index.php?route=quotes"><strong>Ver solicitações</strong><span>Responda contatos comerciais recebidos.</span></a>
            </div>
        </article>
        <article class="admin-panel-card admin-operation-card">
            <span class="admin-eyebrow">Regra de venda</span>
            <h2>Loja ou WhatsApp?</h2>
            <p>Ao cadastrar um produto, escolha como o cliente poderá comprar.</p>
            <ul><li><strong>Venda pela loja:</strong> exige preço e pode usar estoque.</li><li><strong>Sob consulta:</strong> direciona a negociação ao WhatsApp.</li></ul>
            <a href="/admin/index.php?route=products.create">Começar um cadastro →</a>
        </article>
    </div>
</section>
