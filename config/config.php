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
    'admin' => [
        'entry_key' => trim((string) ($_ENV['ADMIN_ENTRY_KEY'] ?? '')),
    ],
    'store' => [
        'cart_enabled' => filter_var($_ENV['STORE_CART_ENABLED'] ?? false, FILTER_VALIDATE_BOOLEAN),
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
    'company' => [
        'legal_name' => $_ENV['COMPANY_LEGAL_NAME'] ?? 'SMARTFLOW TECNOLOGIA EIRELI',
        'trade_name' => $_ENV['COMPANY_TRADE_NAME'] ?? 'MRDRIVES',
        'cnpj' => $_ENV['COMPANY_CNPJ'] ?? '19.252.656/0001-20',
        'address' => $_ENV['COMPANY_ADDRESS'] ?? 'Rua Cabreúva, Sorocaba - SP, CEP 18085-340',
        'support_email' => $_ENV['COMPANY_SUPPORT_EMAIL'] ?? ($_ENV['MAIL_TO'] ?? 'comercial@mrdrives.com.br'),
    ],
    'social' => [
        'instagram' => $_ENV['SOCIAL_INSTAGRAM'] ?? '#',
        'linkedin' => $_ENV['SOCIAL_LINKEDIN'] ?? '#',
        'facebook' => $_ENV['SOCIAL_FACEBOOK'] ?? '#',
        'tiktok' => $_ENV['SOCIAL_TIKTOK'] ?? '#',
    ],
    'payments' => [
        'santander' => [
            'enabled' => filter_var($_ENV['SANTANDER_ENABLED'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'environment' => $_ENV['SANTANDER_ENVIRONMENT'] ?? 'sandbox',
            'client_id' => $_ENV['SANTANDER_CLIENT_ID'] ?? '',
            'client_secret' => $_ENV['SANTANDER_CLIENT_SECRET'] ?? '',
            'certificate_path' => $_ENV['SANTANDER_CERTIFICATE_PATH'] ?? '',
            'private_key_path' => $_ENV['SANTANDER_PRIVATE_KEY_PATH'] ?? '',
            'webhook_secret' => $_ENV['SANTANDER_WEBHOOK_SECRET'] ?? '',
        ],
    ],
    'shipping' => [
        'origin_postal_code' => $_ENV['CORREIOS_ORIGIN_POSTAL_CODE'] ?? '18085340',
        'default_package' => [
            'weight_grams' => (int) ($_ENV['CORREIOS_DEFAULT_WEIGHT_GRAMS'] ?? 1000),
            'length_cm' => (int) ($_ENV['CORREIOS_DEFAULT_LENGTH_CM'] ?? 30),
            'width_cm' => (int) ($_ENV['CORREIOS_DEFAULT_WIDTH_CM'] ?? 20),
            'height_cm' => (int) ($_ENV['CORREIOS_DEFAULT_HEIGHT_CM'] ?? 15),
        ],
        'correios' => [
            'enabled' => filter_var($_ENV['CORREIOS_ENABLED'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'environment' => $_ENV['CORREIOS_ENVIRONMENT'] ?? 'production',
            'username' => $_ENV['CORREIOS_USERNAME'] ?? '',
            'api_code' => $_ENV['CORREIOS_API_CODE'] ?? '',
            'contract' => $_ENV['CORREIOS_CONTRACT'] ?? '',
            'regional' => (int) ($_ENV['CORREIOS_REGIONAL'] ?? 0),
            'token_url' => $_ENV['CORREIOS_TOKEN_URL'] ?? 'https://api.correios.com.br/token/v1/autentica/contrato',
            'services' => [
                ($_ENV['CORREIOS_SEDEX_CODE'] ?? '03220') => 'SEDEX',
                ($_ENV['CORREIOS_PAC_CODE'] ?? '03298') => 'PAC',
            ],
        ],
    ],
];
