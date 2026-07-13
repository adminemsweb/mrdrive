<section class="admin-section">
    <div class="admin-heading">
        <h1>Solicitação de <?= e($quote['name']) ?></h1>
        <a href="/admin/index.php?route=quotes">Voltar</a>
    </div>
    <div class="detail-panel">
        <p><strong>Empresa:</strong> <?= e($quote['company']) ?></p>
        <p><strong>E-mail:</strong> <a href="mailto:<?= e($quote['email']) ?>"><?= e($quote['email']) ?></a></p>
        <p><strong>Telefone/WhatsApp:</strong> <?= e($quote['phone']) ?></p>
        <p><strong>Produto:</strong> <?= e($quote['product_interest']) ?></p>
        <p><strong>Aplicação:</strong> <?= e($quote['application']) ?></p>
        <p><strong>Mensagem:</strong><br><?= nl2br(e($quote['message'])) ?></p>
        <p><strong>Recebida em:</strong> <?= e(date('d/m/Y H:i', strtotime($quote['created_at']))) ?></p>
    </div>
</section>
