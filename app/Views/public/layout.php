<?php use App\Core\Csrf; ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MRDRIVES</title>
    <meta name="description" content="Landing page profissional da MRDRIVES para inversores industriais MRD600 e MRD700.">
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
                <a class="nav-parent" href="/">Inicio</a>
                <div class="nav-dropdown">
                    <a href="/#beneficios">Beneficios</a>
                    <a href="/#especificacoes">Especificacoes</a>
                    <a href="/#aplicacoes">Aplicacoes</a>
                    <a href="/#guias">Guias</a>
                </div>
            </div>
            <div class="nav-group">
                <a class="nav-parent" href="/catalogo">Catalogo</a>
                <div class="nav-dropdown">
                    <a href="/mrd600">MRD600</a>
                    <a href="/mrd700">MRD700</a>
                    <a href="/mrd700-ip65">MRD700/IP65</a>
                </div>
            </div>
            <div class="nav-group">
                <a class="nav-parent" href="/#contato">Contato</a>
                <div class="nav-dropdown">
                    <a href="/ticket">Enviar formulario</a>
                    <a href="/#contato">Abrir ticket</a>
                    <a href="https://wa.me/<?= e(app_config('whatsapp')) ?>" target="_blank">WhatsApp direto</a>
                </div>
            </div>
            <div class="nav-group">
                <a class="nav-parent" href="/#faq">FAQ</a>
                <div class="nav-dropdown">
                    <a href="/#faq">Duvidas frequentes</a>
                    <a href="/#feedbacks">Feedbacks</a>
                </div>
            </div>
        </nav>
        <a class="header-cta header-cta-desktop" href="/#contato"><span class="wa-icon" aria-hidden="true">W</span>Solicitar orcamento</a>
        <nav class="mobile-nav" id="mobile-nav" aria-label="Navegacao mobile">
            <a href="/">Inicio</a>
            <a href="/catalogo">Catalogo</a>
            <a href="/#guias">Guias e materiais</a>
            <a href="/#feedbacks">Feedbacks e videos</a>
            <a href="/#faq">FAQ</a>
            <a href="/#contato">Contato</a>
            <a class="mobile-nav-cta" href="/#contato">Solicitar orcamento</a>
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
            <p>Inversores industriais MRDRIVES para controle de motores, eficiencia operacional e protecao de equipamentos criticos.</p>
            <ul class="footer-contact">
                <li><span>Tel</span><a href="https://wa.me/<?= e(app_config('whatsapp')) ?>">+55 11 92104-7460</a></li>
                <li><span>@</span><a href="mailto:<?= e(app_config('mail')['to']) ?>"><?= e(app_config('mail')['to']) ?></a></li>
                <li><span>BR</span>Atendimento Brasil</li>
            </ul>
        </div>
        <div class="footer-column">
            <h3><span class="footer-title-icon" aria-hidden="true">M</span>Mapa do site</h3>
            <a href="/"><span class="footer-link-icon">01</span>Inicio</a>
            <a href="/catalogo"><span class="footer-link-icon">02</span>Catalogo</a>
            <a href="/#contato"><span class="footer-link-icon">03</span>Contato</a>
            <a href="/#faq"><span class="footer-link-icon">04</span>FAQ</a>
            <a href="/#feedbacks"><span class="footer-link-icon">05</span>Feedbacks</a>
        </div>
        <div class="footer-column">
            <h3><span class="footer-title-icon" aria-hidden="true">S</span>Solucoes</h3>
            <a href="/mrd600"><span class="footer-link-icon">A</span>MRD600</a>
            <a href="/mrd700"><span class="footer-link-icon">B</span>MRD700</a>
            <a href="/mrd700-ip65"><span class="footer-link-icon">C</span>MRD700/IP65</a>
            <a href="/#contato"><span class="footer-link-icon">D</span>Dimensionamento tecnico</a>
        </div>
        <div class="footer-column">
            <h3><span class="footer-title-icon" aria-hidden="true">L</span>Suporte e legal</h3>
            <a href="/politica-de-privacidade"><span class="footer-link-icon">LG</span>Politica de privacidade</a>
            <a href="/#contato"><span class="footer-link-icon">ST</span>Suporte tecnico</a>
            <a href="/#contato"><span class="footer-link-icon">OR</span>Solicitar orcamento</a>
            <a href="/admin/"><span class="footer-link-icon">AD</span>Area administrativa</a>
        </div>
        <div class="footer-partners footer-partners-wide" aria-label="Parcerias MRDRIVES">
            <img src="<?= asset('img/parceiras.png') ?>" alt="Parcerias atendidas pela MRDRIVES">
        </div>
        <div class="copyright">
            <span>&copy; <?= date('Y') ?> MRDRIVES - Todos os direitos reservados.</span>
            <span>Eficiencia, controle e continuidade para a sua operacao.</span>
        </div>
    </footer>
    <script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
