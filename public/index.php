<?php

declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Controllers\PublicController;

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$controller = new PublicController();

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

if ($path === '/downloads') {
    $controller->downloads();
    return;
}

if ($path === '/politica-de-privacidade') {
    $controller->privacy();
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
