<?php

declare(strict_types=1);

$envPath = dirname(__DIR__) . '/.env';
if (is_file($envPath)) {
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $_ENV[$key] = trim($value, "\"'");
    }
}

return [
    'app' => [
        'name' => 'MRDRIVES',
        'url' => $_ENV['APP_URL'] ?? 'http://localhost:8000',
        'env' => $_ENV['APP_ENV'] ?? 'production',
        'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
    ],
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
        'port' => $_ENV['DB_PORT'] ?? '3306',
        'database' => $_ENV['DB_DATABASE'] ?? 'mrdrives',
        'username' => $_ENV['DB_USERNAME'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'charset' => 'utf8mb4',
    ],
    'mail' => [
        'to' => $_ENV['MAIL_TO'] ?? 'comercial@mrdrives.com.br',
        'from' => $_ENV['MAIL_FROM'] ?? 'site@mrdrives.com.br',
    ],
    'whatsapp' => $_ENV['WHATSAPP_NUMBER'] ?? '5511921047460',
    'social' => [
        'instagram' => $_ENV['SOCIAL_INSTAGRAM'] ?? '#',
        'linkedin' => $_ENV['SOCIAL_LINKEDIN'] ?? '#',
        'facebook' => $_ENV['SOCIAL_FACEBOOK'] ?? '#',
    ],
];
