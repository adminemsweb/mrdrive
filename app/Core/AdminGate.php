<?php

declare(strict_types=1);

namespace App\Core;

final class AdminGate
{
    private const SESSION_KEY = 'admin_entry_authorized';

    public static function enforce(): void
    {
        $entryKey = (string) (app_config('admin')['entry_key'] ?? '');
        $providedKey = $_GET['access'] ?? null;

        if ($entryKey !== '' && is_string($providedKey) && hash_equals($entryKey, $providedKey)) {
            session_regenerate_id(true);
            $_SESSION[self::SESSION_KEY] = hash('sha256', $entryKey);
            header('Referrer-Policy: no-referrer');
            header('Cache-Control: no-store, private');
            redirect('/admin/index.php?route=login');
        }

        $sessionProof = $_SESSION[self::SESSION_KEY] ?? '';
        $expectedProof = $entryKey !== '' ? hash('sha256', $entryKey) : '';
        if ($expectedProof === '' || !is_string($sessionProof) || !hash_equals($expectedProof, $sessionProof)) {
            http_response_code(404);
            header('Cache-Control: no-store, private');
            header('X-Robots-Tag: noindex, nofollow, noarchive');
            exit('Página não encontrada.');
        }
    }

    public static function clear(): void
    {
        unset($_SESSION[self::SESSION_KEY]);
    }
}
