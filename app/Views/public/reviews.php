<?php
$shopReviews = [
    ['Excelente produto, chegou bem orientado e com suporte para parametrização.', 'Carlos M.', 'Manutenção industrial', 5],
    ['O atendimento ajudou a escolher a potência correta sem comprar acima do necessário.', 'Renata S.', 'Compras técnicas', 5],
    ['Instalamos em bomba e o controle ficou muito mais estável.', 'Marcos P.', 'Saneamento', 5],
    ['Boa resposta no orçamento e explicação clara sobre tensão e aplicação.', 'Juliana R.', 'Automação', 5],
    ['Produto robusto, visual profissional e entrega alinhada com o combinado.', 'Eduardo L.', 'Integrador', 5],
    ['A equipe entendeu a carga da máquina e indicou a linha certa.', 'Paulo A.', 'Máquinas industriais', 4],
];
$ratingCounts = array_fill(1, 5, 0);
foreach ($shopReviews as $review) {
    $ratingCounts[$review[3]]++;
}
$reviewTotal = count($shopReviews);
?>
<section class="shop-reviews" id="avaliacoes">
    <header class="shop-reviews-heading">
        <div class="shop-rating-overview">
            <div class="shop-rating-summary"><strong>4,8</strong><div><span>★★★★★</span><small><?= $reviewTotal ?> avaliações de clientes</small></div></div>
            <div class="shop-rating-distribution" aria-label="Distribuição das avaliações por estrelas">
                <?php for ($stars = 5; $stars >= 1; $stars--):
                    $percentage = $reviewTotal > 0 ? (int) round(($ratingCounts[$stars] / $reviewTotal) * 100) : 0;
                ?>
                    <div><span><?= $stars ?> ★</span><i><b style="width: <?= $percentage ?>%"></b></i><small><?= $ratingCounts[$stars] ?></small></div>
                <?php endfor; ?>
            </div>
        </div>
    </header>
    <div class="shop-review-swiper swiper" data-shop-review-swiper>
        <div class="swiper-wrapper">
            <?php foreach ($shopReviews as $review): ?>
                <article class="shop-review-card swiper-slide">
                    <div class="shop-review-stars" aria-label="<?= $review[3] ?> de 5 estrelas"><?= str_repeat('★', $review[3]) ?><?= str_repeat('☆', 5 - $review[3]) ?></div>
                    <p>“<?= e($review[0]) ?>”</p>
                    <footer><span><?= e(strtoupper(substr($review[1], 0, 1))) ?></span><div><strong><?= e($review[1]) ?></strong><small><?= e($review[2]) ?></small></div></footer>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="shop-review-pagination swiper-pagination" aria-label="Navegação das avaliações"></div>
    </div>
</section>
