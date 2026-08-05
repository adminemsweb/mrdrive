<?php

declare(strict_types=1);

namespace App\Core;

final class CustomerAuth
{
    public static function login(array $customer): void
    {
        session_regenerate_id(true);
        $_SESSION['customer_user'] = [
            'id' => (int) $customer['id'],
            'name' => (string) $customer['name'],
            'first_name' => (string) ($customer['first_name'] ?? explode(' ', trim((string) $customer['name']))[0]),
            'last_name' => (string) ($customer['last_name'] ?? ''),
            'email' => (string) $customer['email'],
        ];
    }

    public static function check(): bool
    {
        return isset($_SESSION['customer_user']['id']);
    }

    public static function user(): ?array
    {
        return $_SESSION['customer_user'] ?? null;
    }

    public static function logout(): void
    {
        unset($_SESSION['customer_user']);
        session_regenerate_id(true);
    }
}
