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

function versioned_asset(string $path): string
{
    $normalizedPath = ltrim($path, '/');
    $file = public_path('assets/' . $normalizedPath);
    $version = is_file($file) ? '?v=' . filemtime($file) : '';

    return asset($normalizedPath) . $version;
}

function optimized_image_url(?string $path): string
{
    $normalizedPath = ltrim((string) $path, '/');
    if ($normalizedPath === '') {
        return '';
    }

    $extension = strtolower(pathinfo($normalizedPath, PATHINFO_EXTENSION));
    if (in_array($extension, ['png', 'jpg', 'jpeg'], true)) {
        $webpPath = preg_replace('/\.(?:png|jpe?g)$/i', '.webp', $normalizedPath);
        if (is_string($webpPath) && is_file(public_path($webpPath))) {
            return '/' . $webpPath;
        }
    }

    return '/' . $normalizedPath;
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

function vite_tags(string $entry = 'resources/js/storefront.js'): string
{
    $manifestPath = public_path('build/.vite/manifest.json');
    if (!is_file($manifestPath)) {
        return '';
    }

    $manifest = json_decode((string) file_get_contents($manifestPath), true);
    $chunk = is_array($manifest) ? ($manifest[$entry] ?? null) : null;
    if (!is_array($chunk) || empty($chunk['file'])) {
        return '';
    }

    $tags = [];
    foreach (($chunk['css'] ?? []) as $cssFile) {
        $tags[] = '<link rel="stylesheet" href="/build/' . e($cssFile) . '">';
    }
    $tags[] = '<script type="module" src="/build/' . e((string) $chunk['file']) . '"></script>';

    return implode("\n    ", $tags);
}
