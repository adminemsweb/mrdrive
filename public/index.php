<?php

declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Controllers\PublicController;
use App\Controllers\CustomerAuthController;
use App\Controllers\ShippingController;

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$controller = new PublicController();
$customerAuth = new CustomerAuthController();

if ($path === '/api/cep') {
    (new ShippingController())->postalCode();
    return;
}

if ($path === '/api/frete') {
    (new ShippingController())->quote();
    return;
}

if ($path === '/entrar') {
    is_post() ? $customerAuth->login() : $customerAuth->loginForm();
    return;
}

if ($path === '/criar-conta') {
    is_post() ? $customerAuth->register() : $customerAuth->registerForm();
    return;
}

if ($path === '/minha-conta') {
    $customerAuth->account();
    return;
}

if ($path === '/sair' && is_post()) {
    $customerAuth->logout();
    return;
}

if ($path === '/' || $path === '/index.php') {
    $controller->home();
    return;
}

if ($path === '/produto') {
    $controller->product();
    return;
}

if ($path === '/catalogo') {
    $controller->catalog();
    return;
}

if ($path === '/checkout') {
    $controller->checkout();
    return;
}

if ($path === '/downloads') {
    $controller->downloads();
    return;
}

if ($path === '/politica-de-privacidade') {
    $controller->privacy();
    return;
}

$legalRoutes = [
    '/termos-de-uso' => 'termos-de-uso',
    '/politica-de-entrega' => 'politica-de-entrega',
    '/trocas-e-devolucoes' => 'trocas-e-devolucoes',
    '/garantia' => 'garantia',
    '/formas-de-pagamento' => 'formas-de-pagamento',
    '/politica-de-cookies' => 'politica-de-cookies',
];
if (isset($legalRoutes[$path])) {
    $controller->legal($legalRoutes[$path]);
    return;
}

if ($path === '/mrd700-ip65') {
    $controller->mrd700Ip65();
    return;
}

if ($path === '/mrd600') {
    $controller->mrd600();
    return;
}

if ($path === '/mrd700') {
    $controller->mrd700();
    return;
}

if ($path === '/ticket' && is_post()) {
    $controller->ticketSubmit();
    return;
}

if ($path === '/ticket') {
    $controller->ticket();
    return;
}

if ($path === '/quote' && is_post()) {
    $controller->quote();
    return;
}

http_response_code(404);
$controller->home();
