<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\View;

final class AuthController
{
    public function login(): void
    {
        View::render('admin/login', [
            'error' => $_SESSION['login_error'] ?? null,
        ]);
        unset($_SESSION['login_error']);
    }

    public function authenticate(): void
    {
        Csrf::verify();
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if (Auth::attempt($email, $password)) {
            redirect('/admin/index.php');
        }

        $_SESSION['login_error'] = 'E-mail ou senha inválidos.';
        redirect('/admin/index.php?route=login');
    }

    public function logout(): void
    {
        Auth::logout();
        redirect('/admin/index.php?route=login');
    }
}
