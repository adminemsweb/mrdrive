<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\CustomerAuth;
use App\Core\View;
use App\Models\Customer;
use Throwable;

final class CustomerAuthController
{
    public function loginForm(): void
    {
        if (CustomerAuth::check()) {
            redirect('/minha-conta');
        }

        $this->renderAuth('public/login', 'Entrar na sua conta');
    }

    public function login(): void
    {
        Csrf::verify();
        $email = mb_strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        try {
            $customer = (new Customer())->findByEmail($email);
        } catch (Throwable) {
            $this->fail('Não foi possível acessar as contas agora. Tente novamente em instantes.', ['email' => $email], '/entrar');
        }

        if (!$customer || !password_verify($password, (string) $customer['password'])) {
            $this->fail('E-mail ou senha incorretos.', ['email' => $email], '/entrar');
        }

        CustomerAuth::login($customer);
        redirect('/minha-conta');
    }

    public function registerForm(): void
    {
        if (CustomerAuth::check()) {
            redirect('/minha-conta');
        }

        $this->renderAuth('public/register', 'Criar sua conta');
    }

    public function register(): void
    {
        Csrf::verify();
        $firstName = trim((string) ($_POST['first_name'] ?? ''));
        $lastName = trim((string) ($_POST['last_name'] ?? ''));
        $email = mb_strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');
        $confirmation = (string) ($_POST['password_confirmation'] ?? '');
        $old = ['first_name' => $firstName, 'last_name' => $lastName, 'email' => $email];

        if (mb_strlen($firstName) < 2 || mb_strlen($firstName) > 80) {
            $this->fail('Informe seu nome.', $old, '/criar-conta');
        }
        if (mb_strlen($lastName) < 2 || mb_strlen($lastName) > 120) {
            $this->fail('Informe seu sobrenome.', $old, '/criar-conta');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->fail('Informe um e-mail válido.', $old, '/criar-conta');
        }
        if (strlen($password) < 8) {
            $this->fail('A senha precisa ter pelo menos 8 caracteres.', $old, '/criar-conta');
        }
        if (!hash_equals($password, $confirmation)) {
            $this->fail('As senhas não coincidem.', $old, '/criar-conta');
        }

        try {
            $model = new Customer();
            if ($model->findByEmail($email)) {
                $this->fail('Já existe uma conta com esse e-mail.', $old, '/criar-conta');
            }
            $customer = $model->create($firstName, $lastName, $email, $password);
        } catch (Throwable) {
            $this->fail('Não foi possível criar sua conta agora. Tente novamente em instantes.', $old, '/criar-conta');
        }

        CustomerAuth::login($customer);
        redirect('/minha-conta');
    }

    public function account(): void
    {
        if (!CustomerAuth::check()) {
            redirect('/entrar');
        }

        View::render('public/account', [
            'title' => 'Minha conta | MRDRIVES',
            'customer' => CustomerAuth::user(),
        ], 'public/layout');
    }

    public function logout(): void
    {
        Csrf::verify();
        CustomerAuth::logout();
        redirect('/');
    }

    private function renderAuth(string $view, string $title): void
    {
        View::render($view, [
            'title' => $title . ' | MRDRIVES',
            'error' => $_SESSION['customer_auth_error'] ?? null,
            'old' => $_SESSION['customer_auth_old'] ?? [],
        ], 'public/layout');
        unset($_SESSION['customer_auth_error'], $_SESSION['customer_auth_old']);
    }

    private function fail(string $message, array $old, string $route): never
    {
        $_SESSION['customer_auth_error'] = $message;
        $_SESSION['customer_auth_old'] = $old;
        redirect($route);
    }
}
