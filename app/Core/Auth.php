<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

final class Auth
{
    public static function attempt(string $email, string $password): bool
    {
        $user = (new User())->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        session_regenerate_id(true);
        $_SESSION['admin_user'] = [
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ];

        return true;
    }

    public static function check(): bool
    {
        return isset($_SESSION['admin_user']);
    }

    public static function user(): ?array
    {
        return $_SESSION['admin_user'] ?? null;
    }

    public static function requireAdmin(): void
    {
        if (!self::check()) {
            redirect('/admin/index.php?route=login');
        }
    }

    public static function logout(): void
    {
        unset($_SESSION['admin_user']);
        session_regenerate_id(true);
    }
}
