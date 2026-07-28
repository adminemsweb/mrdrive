<?php
use App\Core\Csrf;

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$seoPages = [
    '/' => [
        'title' => 'MR Drives',
        'description' => 'Inversores de frequência MRD600, MRD700 e MRD700/IP65 para máquinas, bombas e automação industrial, com suporte técnico especializado.',
    ],
    '/catalogo' => [
        'title' => 'Catálogo de Inversores de Frequência | MRDRIVES',
        'description' => 'Conheça os inversores industriais MRDRIVES: modelos MRD600, MRD700 e MRD700/IP65 para redes 220 V, 380 V e 480 V.',
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
$robotsContent = $requestPath === '/ticket'
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
</head>
<body>
    <canvas class="ambient-canvas" id="ambient-canvas" aria-hidden="true"></canvas>
    <header class="site-header">
        <div class="brand brand-logo" aria-label="MRDRIVES">
            <img src="<?= asset('img/logo.png') ?>" alt="MRDRIVES">
        </div>
        <button class="menu-toggle mobile-menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="mobile-nav">Menu</button>
        <nav class="site-nav site-nav-desktop" aria-label="Navegacao principal">
            <div class="nav-group">
                <a class="nav-parent" href="/">In&iacute;cio</a>
                <div class="nav-dropdown">
                    <a href="/#beneficios">Benef&iacute;cios</a>
                    <a href="/#especificacoes">Especifica&ccedil;&otilde;es</a>
                    <a href="/#aplicacoes">Aplica&ccedil;&otilde;es</a>
                    <a href="/downloads">Downloads</a>
                </div>
            </div>
            <div class="nav-group">
                <a class="nav-parent" href="/catalogo">Cat&aacute;logo</a>
                <div class="nav-dropdown">
                    <a href="/downloads">Downloads</a>
                    <a href="/mrd600">MRD600</a>
                    <a href="/mrd700">MRD700</a>
                    <a href="/mrd700-ip65">MRD700/IP65</a>
                </div>
            </div>
            <div class="nav-group">
                <a class="nav-parent" href="/#faq">FAQ</a>
                <div class="nav-dropdown">
                    <a href="/#faq">D&uacute;vidas frequentes</a>
                    <a href="/#feedbacks">Feedbacks</a>
                </div>
            </div>
            <a class="nav-parent nav-plain" href="/downloads">Downloads</a>
            <div class="nav-group">
                <a class="nav-parent" href="/#contato">Contato</a>
                <div class="nav-dropdown">
                    <a href="/ticket">Enviar formul&aacute;rio</a>
                    <a href="/#contato">Abrir ticket</a>
                    <a href="https://wa.me/<?= e(app_config('whatsapp')) ?>" target="_blank">WhatsApp direto</a>
                </div>
            </div>
        </nav>
        <a class="header-cta header-cta-desktop" href="/#contato"><span class="wa-icon" aria-hidden="true">W</span>Solicitar orçamento</a>
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
                    <a href="/catalogo">Cat&aacute;logo</a>
                    <button type="button" class="mobile-submenu-toggle" aria-expanded="false" aria-label="Abrir produtos do catalogo"></button>
                </div>
                <div class="mobile-submenu">
                    <a href="/downloads">Downloads</a>
                    <a href="/mrd600">MRD600</a>
                    <a href="/mrd700">MRD700</a>
                    <a href="/mrd700-ip65">MRD700/IP65</a>
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
            <a class="mobile-nav-cta" href="/#contato">Solicitar or&ccedil;amento</a>
        </nav>
    </header>
    <main>
        <?= $content ?>
    </main>
    <footer class="footer footer-mr">
        <div class="footer-brand">
            <div class="brand brand-footer brand-logo" aria-label="MRDRIVES">
                <img src="<?= asset('img/logo.png') ?>" alt="MRDRIVES">
            </div>
            <p>Inversores industriais MRDRIVES para controle de motores, eficiência operacional e proteção de equipamentos críticos.</p>
            <ul class="footer-contact">
                <li><span>Tel</span><a href="https://wa.me/<?= e(app_config('whatsapp')) ?>">+55 11 92104-7460</a></li>
                <li><span>@</span><a href="mailto:<?= e(app_config('mail')['to']) ?>"><?= e(app_config('mail')['to']) ?></a></li>
                <li><span>BR</span>Atendimento Brasil</li>
            </ul>
        </div>
        <div class="footer-column">
            <h3><span class="footer-title-icon" aria-hidden="true">M</span>Mapa do site</h3>
            <a href="/"><span class="footer-link-icon">01</span>In&iacute;cio</a>
            <a href="/catalogo"><span class="footer-link-icon">02</span>Cat&aacute;logo</a>
            <a href="/#faq"><span class="footer-link-icon">03</span>FAQ</a>
            <a href="/downloads"><span class="footer-link-icon">04</span>Downloads</a>
            <a href="/#contato"><span class="footer-link-icon">05</span>Contato</a>
            <a href="/#feedbacks"><span class="footer-link-icon">06</span>Feedbacks</a>
        </div>
        <div class="footer-column">
            <h3><span class="footer-title-icon" aria-hidden="true">S</span>Soluções</h3>
            <a href="/mrd600"><span class="footer-link-icon">A</span>MRD600</a>
            <a href="/mrd700"><span class="footer-link-icon">B</span>MRD700</a>
            <a href="/mrd700-ip65"><span class="footer-link-icon">C</span>MRD700/IP65</a>
            <a href="/#contato"><span class="footer-link-icon">D</span>Dimensionamento técnico</a>
        </div>
        <div class="footer-column">
            <h3><span class="footer-title-icon" aria-hidden="true">L</span>Suporte e legal</h3>
            <a href="/politica-de-privacidade"><span class="footer-link-icon">LG</span>Política de privacidade</a>
            <a href="/#contato"><span class="footer-link-icon">ST</span>Suporte técnico</a>
            <a href="/#contato"><span class="footer-link-icon">OR</span>Solicitar orçamento</a>
            <a href="/admin/"><span class="footer-link-icon">AD</span>Área administrativa</a>
        </div>
        <div class="footer-partners footer-partners-wide" aria-label="Parcerias MRDRIVES">
            <img src="<?= asset('img/parceiras.png') ?>" alt="Parcerias atendidas pela MRDRIVES">
        </div>
        <div class="copyright">
            <span>&copy; <?= date('Y') ?> MRDRIVES - Todos os direitos reservados.</span>
            <span>Eficiência, controle e continuidade para a sua operação.</span>
        </div>
    </footer>
    <button class="scroll-top-button" type="button" aria-label="Voltar ao topo"></button>
    <script src="<?= asset('js/main.js') ?>"></script>
    <script type="module" src="<?= asset('js/product-3d.js') ?>?v=<?= filemtime(public_path('assets/js/product-3d.js')) ?>"></script>
</body>
</html>
