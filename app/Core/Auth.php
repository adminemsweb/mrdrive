<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

final class Auth
{
    public static function attempt(string $email, string $password): bool
    {
        $user = (new User())->findByEmail($email);
        if (!$user || empty($user['is_active']) || !password_verify($password, $user['password'])) {
            return false;
        }

        session_regenerate_id(true);
        $_SESSION['admin_user'] = [
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'] ?? 'admin',
        ];
        (new User())->touchLastLogin((int) $user['id']);

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

        $sessionUser = self::user();
        $currentUser = (new User())->find((int) ($sessionUser['id'] ?? 0));
        if (!$currentUser || empty($currentUser['is_active'])) {
            self::logout();
            $_SESSION['login_error'] = 'Seu acesso administrativo está suspenso.';
            redirect('/admin/index.php?route=login');
        }

        $_SESSION['admin_user']['name'] = $currentUser['name'];
        $_SESSION['admin_user']['email'] = $currentUser['email'];
        $_SESSION['admin_user']['role'] = $currentUser['role'] ?? 'admin';
    }

    public static function isOwner(): bool
    {
        return (self::user()['role'] ?? null) === 'owner';
    }

    public static function requireOwner(): void
    {
        self::requireAdmin();
        if (!self::isOwner()) {
            http_response_code(403);
            exit('Acesso não autorizado.');
        }
    }

    public static function logout(): void
    {
        unset($_SESSION['admin_user']);
        session_regenerate_id(true);
    }
}
