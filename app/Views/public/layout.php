<?php
use App\Core\Csrf;
use App\Core\CustomerAuth;

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$customerUser = CustomerAuth::user();
$cartEnabled = (bool) (app_config('store')['cart_enabled'] ?? false);
$seoPages = [
    '/' => [
        'title' => 'MR Drives',
        'description' => 'Inversores de frequência MRD600, MRD700 e MRD700/IP65 para máquinas, bombas e automação industrial, com suporte técnico especializado.',
    ],
    '/catalogo' => [
        'title' => 'Loja de Inversores de Frequência | MRDRIVES',
        'description' => 'Conheça os inversores industriais MRDRIVES e solicite atendimento especializado para redes 220 V, 380 V e 480 V.',
    ],
    '/checkout' => [
        'title' => 'Finalizar pedido | MRDRIVES',
        'description' => 'Revise seu carrinho e envie seu pedido de inversores industriais para validação da equipe MRDRIVES.',
    ],
    '/mrd600' => [
        'title' => 'Inversor de Frequência MRD600 | MRDRIVES',
        'description' => 'MRD600: inversor de frequência compacto para máquinas, bombas, ventiladores e aplicações industriais em redes 220 V e 380 V.',
    ],
    '/mrd700' => [
        'title' => 'Inversor de Frequência Vetorial MRD700 | MRDRIVES',
        'description' => 'MRD700: inversor vetorial industrial de alto desempenho, com expansão PLC e protocolos para automação de máquinas e processos.',
    ],
    '/mrd700-ip65' => [
        'title' => 'Inversor de Frequência IP65 MRD700 | MRDRIVES',
        'description' => 'MRD700/IP65: inversor industrial protegido para ambientes com água, poeira, umidade e rotinas severas de limpeza.',
    ],
    '/downloads' => [
        'title' => 'Manuais e Downloads de Inversores | MRDRIVES',
        'description' => 'Baixe catálogos, manuais e materiais técnicos dos inversores de frequência MRDRIVES.',
    ],
    '/politica-de-privacidade' => [
        'title' => 'Política de Privacidade | MRDRIVES',
        'description' => 'Política de privacidade e tratamento de dados da MRDRIVES.',
    ],
];

$seo = $seoPages[$requestPath] ?? $seoPages['/'];
if (!empty($title)) {
    $seo['title'] = $title;
}
if (!empty($description)) {
    $seo['description'] = $description;
}
if ($requestPath === '/produto' && !empty($product)) {
    $seo['title'] = ($product['name'] ?? 'Inversor de Frequência') . ' | MRDRIVES';
    $seo['description'] = $product['short_description'] ?? $seoPages['/catalogo']['description'];
}

$canonicalPath = $requestPath === '/index.php' ? '/' : $requestPath;
if ($canonicalPath === '/produto' && isset($_GET['id'])) {
    $canonicalPath .= '?id=' . max(0, (int) $_GET['id']);
}
$canonicalUrl = 'https://mrdrives.com.br' . ($canonicalPath === '/' ? '/' : rtrim($canonicalPath, '/'));
$seoImage = 'https://mrdrives.com.br/assets/img/banner.png';
$robotsContent = in_array($requestPath, ['/ticket', '/checkout'], true)
    ? 'noindex, follow'
    : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
$structuredData = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Organization',
            '@id' => 'https://mrdrives.com.br/#organization',
            'name' => 'MRDRIVES',
            'alternateName' => 'MR Drives',
            'url' => 'https://mrdrives.com.br/',
            'logo' => 'https://mrdrives.com.br/assets/img/logo-site.png',
            'image' => $seoImage,
            'description' => 'Inversores de frequência e soluções para automação industrial.',
            'contactPoint' => [[
                '@type' => 'ContactPoint',
                'telephone' => '+55-11-92104-7460',
                'contactType' => 'sales',
                'areaServed' => 'BR',
                'availableLanguage' => 'Portuguese',
            ]],
        ],
        [
            '@type' => 'WebSite',
            '@id' => 'https://mrdrives.com.br/#website',
            'url' => 'https://mrdrives.com.br/',
            'name' => 'MRDRIVES',
            'alternateName' => 'MR Drives Inversores Industriais',
            'inLanguage' => 'pt-BR',
            'publisher' => ['@id' => 'https://mrdrives.com.br/#organization'],
        ],
    ],
];
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($seo['title']) ?></title>
    <meta name="description" content="<?= e($seo['description']) ?>">
    <meta name="robots" content="<?= e($robotsContent) ?>">
    <meta name="googlebot" content="<?= e($robotsContent) ?>">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="MRDRIVES">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:title" content="<?= e($seo['title']) ?>">
    <meta property="og:description" content="<?= e($seo['description']) ?>">
    <meta property="og:image" content="<?= e($seoImage) ?>">
    <meta property="og:image:secure_url" content="<?= e($seoImage) ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1920">
    <meta property="og:image:height" content="1080">
    <meta property="og:image:alt" content="Inversores industriais MRDRIVES">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($seo['title']) ?>">
    <meta name="twitter:description" content="<?= e($seo['description']) ?>">
    <meta name="twitter:image" content="<?= e($seoImage) ?>">
    <script type="application/ld+json"><?= json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <link rel="icon" type="image/png" sizes="64x64" href="<?= asset('img/favicon-64.png') ?>">
    <link rel="shortcut icon" type="image/png" href="<?= asset('img/favicon-64.png') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>?v=<?= filemtime(public_path('assets/css/style.css')) ?>">
    <link rel="stylesheet" href="<?= asset('css/ecommerce.css') ?>?v=<?= filemtime(public_path('assets/css/ecommerce.css')) ?>">
    <?= vite_tags() ?>
</head>
<body>
    <canvas class="ambient-canvas" id="ambient-canvas" aria-hidden="true"></canvas>
    <div class="marketplace-topbar">
        <div><span>🇧🇷</span><strong>Entrega em todo o Brasil</strong><span>Compra nacional, suporte em português</span></div>
        <nav aria-label="Links comerciais"><a href="/politica-de-entrega">Entrega e frete</a><a href="/trocas-e-devolucoes">Trocas e devoluções</a><a href="/garantia">Garantia</a><a href="/ticket">Central de ajuda</a></nav>
    </div>
    <header class="site-header marketplace-main-header" x-data="marketplaceSearch">
        <a class="brand brand-logo marketplace-logo" href="/" aria-label="MRDRIVES - Página inicial">
            <img src="<?= asset('img/logo-site.png') ?>" alt="MRDRIVES">
        </a>
        <form class="header-postal-code" data-header-cep novalidate>
            <label for="header-postal-code"><i data-lucide="map-pin" aria-hidden="true"></i><span><small>Entregar em</small><strong data-header-cep-label>Informe seu CEP</strong></span></label>
            <span class="header-postal-entry">
                <input id="header-postal-code" type="text" inputmode="numeric" maxlength="9" autocomplete="postal-code" placeholder="00000-000" aria-label="CEP" data-header-cep-input>
                <button type="submit" aria-label="Buscar CEP"><i data-lucide="search" aria-hidden="true"></i></button>
            </span>
            <small class="header-postal-status" data-header-cep-status aria-live="polite"></small>
        </form>
        <button class="menu-toggle mobile-menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="mobile-nav">Menu</button>
        <form class="marketplace-search" action="/catalogo" method="get" role="search" @focusin="open()" @keydown.escape="close()" @click.outside="close()">
            <label class="sr-only" for="marketplace-search-input">Buscar produtos</label>
            <input id="marketplace-search-input" name="q" value="<?= e($_GET['q'] ?? '') ?>" placeholder="O que você procura?" autocomplete="off">
            <button type="submit" aria-label="Buscar"><i data-lucide="search"></i><span>Buscar</span></button>
            <div class="marketplace-search-help" x-show="focused" x-transition.opacity.duration.180ms x-cloak>
                <strong>Buscas rápidas</strong>
                <a href="/catalogo?q=220V"><i data-lucide="search"></i> Inversores 220 V</a>
                <a href="/catalogo?q=380V"><i data-lucide="search"></i> Inversores 380 V</a>
                <a href="/catalogo?q=IP65"><i data-lucide="shield-check"></i> Proteção IP65</a>
            </div>
        </form>
        <div class="header-commerce-actions">
            <a class="marketplace-location header-cta-desktop" href="/politica-de-entrega"><i data-lucide="truck"></i><span><small>Entregamos</small><strong>Todo o Brasil</strong></span></a>
            <a class="marketplace-help header-cta-desktop" href="/ticket"><i data-lucide="headphones"></i><span><small>Precisa de ajuda?</small><strong>Atendimento técnico</strong></span></a>
            <a class="marketplace-account" href="<?= $customerUser ? '/minha-conta' : '/entrar' ?>"><i data-lucide="user-round"></i><span><small><?= $customerUser ? 'Olá, ' . e($customerUser['first_name'] ?? explode(' ', trim((string) $customerUser['name']))[0]) : 'Bem-vindo' ?></small><strong><?= $customerUser ? 'Minha conta' : 'Entrar / Criar conta' ?></strong></span></a>
            <?php if ($cartEnabled): ?><button class="header-cart-button" type="button" data-cart-open aria-label="Abrir carrinho de compras"><i data-lucide="shopping-cart"></i><span class="header-cart-label">Carrinho</span><strong data-cart-count>0</strong></button><?php endif; ?>
        </div>
        <nav class="mobile-nav" id="mobile-nav" aria-label="Navegacao mobile">
            <div class="mobile-nav-group">
                <div class="mobile-nav-row">
                    <a href="/">In&iacute;cio</a>
                    <button type="button" class="mobile-submenu-toggle" aria-expanded="false" aria-label="Abrir opcoes de inicio"></button>
                </div>
                <div class="mobile-submenu">
                    <a href="/#beneficios">Benef&iacute;cios</a>
                    <a href="/#especificacoes">Especifica&ccedil;&otilde;es</a>
                    <a href="/#aplicacoes">Aplica&ccedil;&otilde;es</a>
                    <a href="/downloads">Downloads</a>
                </div>
            </div>
            <div class="mobile-nav-group">
                <div class="mobile-nav-row">
                    <a href="/catalogo">Produtos MR Drives</a>
                    <button type="button" class="mobile-submenu-toggle" aria-expanded="false" aria-label="Abrir produtos do catalogo"></button>
                </div>
                <div class="mobile-submenu">
                    <a href="/catalogo#produtos"><strong>Todos os produtos</strong></a>
                    <a href="/mrd600">MRD600 · Compacto</a>
                    <a href="/mrd700">MRD700 · Alto desempenho</a>
                    <a href="/mrd700-ip65">MRD700/IP65 · Proteção IP65</a>
                </div>
            </div>
            <div class="mobile-nav-group">
                <div class="mobile-nav-row">
                    <a href="/#faq">FAQ</a>
                    <button type="button" class="mobile-submenu-toggle" aria-expanded="false" aria-label="Abrir perguntas frequentes"></button>
                </div>
                <div class="mobile-submenu">
                    <a href="/#faq">D&uacute;vidas frequentes</a>
                    <a href="/#feedbacks">Feedbacks</a>
                </div>
            </div>
            <div class="mobile-nav-group">
                <div class="mobile-nav-row mobile-nav-row-single">
                    <a href="/downloads">Downloads</a>
                </div>
            </div>
            <div class="mobile-nav-group">
                <div class="mobile-nav-row">
                    <a href="/#contato">Contato</a>
                    <button type="button" class="mobile-submenu-toggle" aria-expanded="false" aria-label="Abrir opcoes de contato"></button>
                </div>
                <div class="mobile-submenu">
                    <a href="/ticket">Enviar formul&aacute;rio</a>
                    <a href="/#contato">Abrir contato</a>
                    <a href="https://wa.me/<?= e(app_config('whatsapp')) ?>" target="_blank">WhatsApp direto</a>
                </div>
            </div>
            <?php if ($cartEnabled): ?><button class="mobile-nav-cart" type="button" data-cart-open>Ver carrinho <strong data-cart-count>0</strong></button><?php endif; ?>
            <a class="mobile-nav-account" href="<?= $customerUser ? '/minha-conta' : '/entrar' ?>"><i data-lucide="user-round"></i><?= $customerUser ? 'Minha conta' : 'Entrar ou criar conta' ?></a>
            <a class="mobile-nav-cta" href="https://wa.me/<?= e(app_config('whatsapp')) ?>" target="_blank" rel="noopener">Atendimento no WhatsApp</a>
        </nav>
    </header>
    <nav class="marketplace-category-nav site-nav-desktop" aria-label="Departamentos da loja">
        <a href="/">Início</a>
        <div class="marketplace-departments nav-group"><button type="button" aria-haspopup="true"><i class="marketplace-departments-menu" data-lucide="menu"></i><span class="marketplace-departments-label">Produtos MR Drives</span><i class="marketplace-departments-chevron" data-lucide="chevron-down"></i></button><div class="nav-dropdown"><a href="/catalogo#produtos">Todos os produtos</a><a href="/mrd600">MRD600 · Compacto</a><a href="/mrd700">MRD700 · Alto desempenho</a><a href="/mrd700-ip65">MRD700/IP65 · Proteção IP65</a></div></div>
        <a href="/#aplicacoes">Aplicações</a>
        <a href="/downloads">Downloads</a>
        <a href="/#feedbacks">Avaliações</a>
        <a href="/#contato">Contato</a>
    </nav>
    <main>
        <?= $content ?>
    </main>
    <?php if ($cartEnabled): ?>
    <div class="cart-overlay" data-cart-overlay hidden></div>
    <aside class="cart-drawer" data-cart-drawer aria-hidden="true" aria-label="Carrinho de compras">
        <header class="cart-drawer-header"><div><span>Seu carrinho</span><strong><span data-cart-count>0</span> item(ns)</strong></div><button type="button" data-cart-close aria-label="Fechar carrinho">×</button></header>
        <div class="cart-drawer-body" data-cart-items></div>
        <div class="cart-empty" data-cart-empty><span class="cart-empty-icon" aria-hidden="true"></span><strong>Seu carrinho está vazio</strong><p>Explore nossos produtos e monte sua solicitação.</p><a href="/catalogo">Ir para a loja</a></div>
        <footer class="cart-drawer-footer" data-cart-footer>
            <div class="cart-subtotal"><span>Subtotal</span><strong data-cart-subtotal>R$ 0,00</strong></div>
            <p data-cart-price-note>Valores sob consulta serão confirmados no atendimento.</p>
            <a class="cart-checkout-button" href="/checkout">Continuar para finalizar</a>
            <button class="cart-continue-button" type="button" data-cart-close>Continuar comprando</button>
        </footer>
    </aside>
    <?php endif; ?>
    <a class="floating-whatsapp" href="https://wa.me/<?= e(app_config('whatsapp')) ?>?text=Olá!%20Preciso%20de%20ajuda%20com%20um%20produto." target="_blank" rel="noopener" aria-label="Falar com a MR Drives pelo WhatsApp"><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg></span><strong>Fale já</strong></a>
    <?php $company = app_config('company'); $social = app_config('social'); ?>
    <footer class="commerce-footer">
        <section class="commerce-footer-about" aria-labelledby="footer-about-title">
            <h2 id="footer-about-title">MR Drives: soluções industriais para comprar com segurança</h2>
            <h3>Inversores de frequência, automação e suporte técnico em um só lugar</h3>
            <p>A MR Drives atende empresas e profissionais em todo o Brasil com inversores industriais, linhas para redes 220 V, 380 V e 480 V, proteção IP65 e soluções de controle. Compare modelos, consulte especificações e receba apoio especializado antes de concluir o pedido.</p>
            <nav aria-label="Atalhos comerciais do rodapé"><a href="/catalogo#produtos">Todos os produtos</a><a href="/mrd600">Inversores compactos</a><a href="/mrd700">Alto desempenho</a><a href="/mrd700-ip65">Proteção IP65</a><a href="/downloads">Catálogos e manuais</a><a href="/ticket">Ajuda técnica</a></nav>
        </section>
        <div class="commerce-footer-grid">
            <section class="commerce-footer-column commerce-footer-institutional">
                <img class="commerce-footer-logo" src="<?= asset('img/logo-site.png') ?>" alt="MRDRIVES">
                <p>Automação industrial, compra assistida e suporte especializado para todo o Brasil.</p>
            </section>
            <div class="commerce-footer-links-grid">
                <section class="commerce-footer-column">
                    <h2>Atendimento</h2>
                    <div class="commerce-footer-contact"><a href="https://wa.me/<?= e(app_config('whatsapp')) ?>" target="_blank" rel="noopener"><i data-lucide="message-circle"></i><span><small>WhatsApp comercial</small><strong>+55 11 92104-7460</strong></span></a><a href="mailto:<?= e(app_config('mail')['to']) ?>"><i data-lucide="mail"></i><span><small>E-mail</small><strong><?= e(app_config('mail')['to']) ?></strong></span></a><a href="/ticket"><i data-lucide="headphones"></i><span><small>Suporte técnico</small><strong>Abrir atendimento</strong></span></a></div>
                </section>
                <section class="commerce-footer-column">
                    <h2>Produtos e suporte</h2>
                    <nav><a href="/catalogo#produtos">Todos os produtos</a><a href="/mrd600">Linha MRD600</a><a href="/mrd700">Linha MRD700</a><a href="/mrd700-ip65">Linha MRD700/IP65</a><a href="/catalogo#avaliacoes">Avaliações de clientes</a><a href="/downloads">Manuais e downloads</a><a href="/#faq">Perguntas frequentes</a></nav>
                </section>
                <section class="commerce-footer-column">
                    <h2>Para compradores</h2>
                    <nav><?php if ($cartEnabled): ?><a href="/checkout">Finalizar pedido</a><?php endif; ?><a href="/trocas-e-devolucoes">Trocas e devoluções</a><a href="/garantia">Garantia</a><a href="/politica-de-privacidade">Privacidade</a><a href="/ticket">Central de ajuda</a></nav>
                </section>
                <section class="commerce-footer-column">
                    <h2>Institucional</h2>
                    <nav><a href="/">Sobre a MR Drives</a><a href="/termos-de-uso">Como comprar</a><a href="/politica-de-entrega">Entrega e frete</a><a href="/trocas-e-devolucoes">Trocas e devoluções</a><a href="/garantia">Garantia</a></nav>
                </section>
                <section class="commerce-footer-column">
                    <h2>Guia de compras</h2>
                    <nav><a href="/termos-de-uso">Como comprar</a><a href="/formas-de-pagamento">Formas de pagamento</a><a href="/politica-de-entrega">Opções de entrega</a></nav>
                </section>
                <section class="commerce-footer-column">
                    <h2>Compra e segurança</h2>
                    <div class="commerce-footer-trust"><a href="/politica-de-privacidade"><i data-lucide="lock-keyhole"></i><span><strong>Privacidade protegida</strong><small>Tratamento de dados conforme a LGPD</small></span></a><a href="/trocas-e-devolucoes"><i data-lucide="shield-check"></i><span><strong>Compra protegida</strong><small>Direitos previstos no Código de Defesa do Consumidor</small></span></a><a href="/garantia"><i data-lucide="badge-check"></i><span><strong>Garantia nacional</strong><small>Consulte as condições de cada produto</small></span></a></div>
                </section>
            </div>
        </div>
        <section class="commerce-footer-tools" aria-label="Pagamentos e redes sociais">
            <div class="commerce-footer-tools-payment">
                <h2>Pague com</h2>
                <div class="commerce-footer-payment-brands" aria-label="Formas de pagamento sujeitas à confirmação">
                    <span class="payment-brand is-mastercard" aria-label="Mastercard" title="Mastercard"><svg viewBox="0 0 48 24" aria-hidden="true"><circle cx="18" cy="12" r="10" fill="#eb001b"/><circle cx="30" cy="12" r="10" fill="#f79e1b"/><path d="M24 4.5a10 10 0 0 1 0 15 10 10 0 0 1 0-15Z" fill="#ff5f00"/></svg></span>
                    <span class="payment-brand is-visa" aria-label="Visa" title="Visa"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9.112 8.262 5.97 15.758H3.92L2.374 9.775c-.094-.368-.175-.503-.461-.658C1.447 8.864.677 8.627 0 8.479l.046-.217h3.3a.904.904 0 0 1 .894.764l.817 4.338 2.018-5.102Zm8.033 5.049c.008-1.979-2.736-2.088-2.717-2.972.006-.269.262-.555.822-.628a3.66 3.66 0 0 1 1.913.336l.34-1.59a5.207 5.207 0 0 0-1.814-.333c-1.917 0-3.266 1.02-3.278 2.479-.012 1.079.963 1.68 1.698 2.04.756.367 1.01.603 1.006.931-.005.504-.602.725-1.16.734-.975.015-1.54-.263-1.992-.473l-.351 1.642c.453.208 1.289.39 2.156.398 2.037 0 3.37-1.006 3.377-2.564Zm5.061 2.447H24l-1.565-7.496h-1.656a.883.883 0 0 0-.826.55l-2.909 6.946h2.036l.405-1.12h2.488Zm-2.163-2.656 1.02-2.815.588 2.815Zm-8.16-4.84-1.603 7.496H8.34l1.605-7.496Z"/></svg></span>
                    <span class="payment-brand is-hipercard" aria-label="Hipercard" title="Hipercard"><svg viewBox="0 0 66 26" aria-hidden="true"><rect x="2" y="3" width="62" height="20" rx="3"/><text x="33" y="17.2" text-anchor="middle">hipercard</text></svg></span>
                    <span class="payment-brand is-elo" aria-label="Elo" title="Elo"><svg viewBox="0 0 58 28" aria-hidden="true"><circle cx="16" cy="14" r="10" fill="#111"/><path d="M10 9.5a7 7 0 0 1 5-2.3" fill="none" stroke="#ffd100" stroke-width="3"/><path d="M10 18.5a7 7 0 0 0 5 2.3" fill="none" stroke="#00a4e4" stroke-width="3"/><path d="M19 8.5a7 7 0 0 1 3 4" fill="none" stroke="#ef4123" stroke-width="3"/><text x="39" y="19" text-anchor="middle">elo</text></svg></span>
                    <span class="payment-brand is-installments" aria-label="Pagamento parcelado" title="Pagamento parcelado"><svg viewBox="0 0 146 28" aria-hidden="true"><rect x="3" y="5" width="26" height="18" rx="2" fill="none" stroke="#f05b72" stroke-width="1.8"/><path d="M7 10h18M8 15h7" stroke="#f05b72" stroke-width="1.8"/><text x="87" y="18">Pagamento Parcelado</text></svg></span>
                    <span class="payment-brand is-pix" aria-label="Pix" title="Pix"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5.283 18.36a3.505 3.505 0 0 0 2.493-1.032l3.6-3.6a.684.684 0 0 1 .946 0l3.613 3.613a3.504 3.504 0 0 0 2.493 1.032h.71l-4.56 4.56a3.647 3.647 0 0 1-5.156 0L4.85 18.36ZM18.428 5.627a3.505 3.505 0 0 0-2.493 1.032l-3.613 3.614a.67.67 0 0 1-.946 0l-3.6-3.6A3.505 3.505 0 0 0 5.283 5.64h-.434l4.573-4.572a3.646 3.646 0 0 1 5.156 0l4.559 4.559ZM1.068 9.422 3.79 6.699h1.492a2.483 2.483 0 0 1 1.744.722l3.6 3.6a1.73 1.73 0 0 0 2.443 0l3.614-3.613a2.482 2.482 0 0 1 1.744-.723h1.767l2.737 2.737a3.646 3.646 0 0 1 0 5.156l-2.736 2.736h-1.768a2.482 2.482 0 0 1-1.744-.722l-3.613-3.613a1.77 1.77 0 0 0-2.444 0l-3.6 3.6a2.483 2.483 0 0 1-1.744.722H3.791l-2.723-2.723a3.646 3.646 0 0 1 0-5.156Z"/></svg></span>
                    <span class="payment-brand is-paypal" aria-label="PayPal" title="PayPal"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15.607 4.653H8.941L6.645 19.251H1.82L4.862 0h7.995c3.754 0 6.375 2.294 6.473 5.513-.648-.478-2.105-.86-3.722-.86m6.57 5.546c0 3.41-3.01 6.853-6.958 6.853h-2.493L11.595 24H6.74l1.845-11.538h3.592c4.208 0 7.346-3.634 7.153-6.949a5.24 5.24 0 0 1 2.848 4.686M9.653 5.546h6.408c.907 0 1.942.222 2.363.541-.195 2.741-2.655 5.483-6.441 5.483H8.714Z"/></svg></span>
                    <span class="payment-brand is-google-pay" aria-label="Google Pay" title="Google Pay"><svg viewBox="0 0 48 24" aria-hidden="true"><text x="2" y="17" class="google-g">G</text><text x="18" y="17">Pay</text></svg></span>
                    <span class="payment-brand is-boleto" aria-label="Boleto bancário" title="Boleto bancário"><svg viewBox="0 0 52 28" aria-hidden="true"><path d="M7 4v14M10 4v14M14 4v14M19 4v14M22 4v14M27 4v14M31 4v14M37 4v14M40 4v14M45 4v14" stroke="#252d34" stroke-width="1.7"/><text x="26" y="26" text-anchor="middle">Boleto</text></svg></span>
                    <span class="payment-brand is-picpay" aria-label="PicPay" title="PicPay"><svg viewBox="0 0 72 24" aria-hidden="true"><g transform="scale(.92)"><path d="M16.463 1.587v7.537H24V1.587Zm1.256 1.256h5.025v5.025h-5.025Zm1.256 1.256v2.513h2.513V4.099ZM3.77 5.355V8.53h3.376c2.142 0 3.358 1.04 3.358 2.939 0 1.947-1.216 3.011-3.358 3.011H3.769V8.53H0v13.884h3.769v-4.76h3.57c4.333 0 6.815-2.352 6.815-6.32 0-3.771-2.482-5.978-6.814-5.978Z"/></g><text x="26" y="16.5">PicPay</text></svg></span>
                </div>
                <p>Condições confirmadas no fechamento do pedido.</p>
            </div>
            <div class="commerce-footer-tools-social">
                <h2>Siga a gente</h2>
                <div class="commerce-footer-socials">
                    <?php $instagramUrl = $social['instagram'] ?? '#'; ?>
                    <?php if ($instagramUrl !== '#'): ?><a href="<?= e($instagramUrl) ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php else: ?><span class="footer-social-mark" aria-label="Instagram"><?php endif; ?><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7Zm5 3a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm5.25-3.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Z"/></svg><?php if ($instagramUrl !== '#'): ?></a><?php else: ?></span><?php endif; ?>
                    <?php $facebookUrl = $social['facebook'] ?? '#'; ?>
                    <?php if ($facebookUrl !== '#'): ?><a href="<?= e($facebookUrl) ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php else: ?><span class="footer-social-mark" aria-label="Facebook"><?php endif; ?><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9.1 23.69v-7.98H6.63v-3.67H9.1v-1.58c0-4.08 1.85-5.97 5.86-5.97.92 0 1.95.15 2.61.3v3.32c-.44-.04-.92-.05-1.39-.05-1.93 0-2.73.69-2.73 2.68v1.3h3.92l-.67 3.67h-3.25v8.25A12 12 0 1 0 9.1 23.69Z"/></svg><?php if ($facebookUrl !== '#'): ?></a><?php else: ?></span><?php endif; ?>
                    <?php $tiktokUrl = $social['tiktok'] ?? '#'; ?>
                    <?php if ($tiktokUrl !== '#'): ?><a href="<?= e($tiktokUrl) ?>" target="_blank" rel="noopener" aria-label="TikTok"><?php else: ?><span class="footer-social-mark" aria-label="TikTok"><?php endif; ?><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-2.1-.07-4.14-.65-5.82-1.9-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94a7.34 7.34 0 0 1-5.91 3.21 7.2 7.2 0 0 1-4.08-1.03 7.39 7.39 0 0 1-3.65-5.71c-.14-2.42.82-4.81 2.58-6.45a7.36 7.36 0 0 1 6.15-1.72c.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37a3.43 3.43 0 0 0-1.5 3.36c.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.59-1 .45-2.11.47-3.17.01-4.03-.01-8.05.02-12.07Z"/></svg><?php if ($tiktokUrl !== '#'): ?></a><?php else: ?></span><?php endif; ?>
                </div>
            </div>
        </section>
        <div class="commerce-footer-legal">
            <div><?php if (!empty($company['legal_name']) || !empty($company['cnpj'])): ?><strong><?= e($company['legal_name'] ?: $company['trade_name']) ?></strong><?php if ($company['cnpj']): ?><span>CNPJ <?= e($company['cnpj']) ?></span><?php endif; ?><?php else: ?><strong>MRDRIVES</strong><?php endif; ?><?php if (!empty($company['address'])): ?><span><?= e($company['address']) ?></span><?php endif; ?><span>Entregas exclusivamente em território brasileiro.</span></div>
            <nav><a href="/politica-de-privacidade">Privacidade</a><a href="/politica-de-cookies">Cookies</a><a href="/termos-de-uso">Termos de uso</a></nav>
            <span>&copy; <?= date('Y') ?> MRDRIVES. Todos os direitos reservados.</span>
        </div>
    </footer>
    <aside class="cookie-banner" data-cookie-banner hidden aria-label="Preferências de privacidade"><div><strong>Sua privacidade importa</strong><p>Usamos armazenamento essencial para manter suas preferências. Tecnologias opcionais só serão usadas com sua escolha.</p><a href="/politica-de-cookies">Entenda nossa política</a></div><div><button type="button" data-cookie-reject>Somente essenciais</button><button type="button" data-cookie-accept>Aceitar opcionais</button></div></aside>
    <button class="scroll-top-button" type="button" aria-label="Voltar ao topo"><i data-lucide="chevron-up"></i></button>
    <script src="<?= asset('js/main.js') ?>"></script>
    <script>window.MRShop = <?= json_encode(['whatsapp' => app_config('whatsapp'), 'cartEnabled' => $cartEnabled], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;</script>
    <script src="<?= asset('js/ecommerce.js') ?>?v=<?= filemtime(public_path('assets/js/ecommerce.js')) ?>"></script>
    <script type="module" src="<?= asset('js/product-3d.js') ?>?v=<?= filemtime(public_path('assets/js/product-3d.js')) ?>"></script>
</body>
</html>
