<?php

declare(strict_types=1);

namespace App\Core;

final class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_csrf'];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_csrf" value="' . e(self::token()) . '">';
    }

    public static function verify(): void
    {
        $posted = $_POST['_csrf'] ?? '';
        if (!is_string($posted) || !hash_equals(self::token(), $posted)) {
            http_response_code(419);
            exit('Token CSRF invalido.');
        }
    }
}
