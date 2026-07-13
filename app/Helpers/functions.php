<?php

declare(strict_types=1);

function base_path(string $path = ''): string
{
    return dirname(__DIR__, 2) . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : '');
}

function app_path(string $path = ''): string
{
    return base_path('app' . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : ''));
}

function public_path(string $path = ''): string
{
    return base_path('public' . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : ''));
}

function app_config(?string $key = null): mixed
{
    static $config = null;
    if ($config === null) {
        $config = require base_path('config/config.php');
    }

    return $key ? ($config[$key] ?? null) : $config;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function asset(string $path): string
{
    return '/assets/' . ltrim($path, '/');
}

function upload_url(?string $path): string
{
    return $path ? '/' . ltrim($path, '/') : '';
}

function redirect(string $to): never
{
    header('Location: ' . $to);
    exit;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function money_br(float $value): string
{
    return 'R$ ' . number_format($value, 2, ',', '.');
}
