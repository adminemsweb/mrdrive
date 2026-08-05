<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\View;
use App\Models\User;

final class UserAdminController
{
    public function index(): void
    {
        Auth::requireOwner();
        View::render('admin/users/index', ['users' => (new User())->all()], 'admin/layout');
    }

    public function store(): void
    {
        Auth::requireOwner();
        Csrf::verify();

        try {
            $name = trim((string) ($_POST['name'] ?? ''));
            $email = strtolower(trim((string) ($_POST['email'] ?? '')));
            $password = (string) ($_POST['password'] ?? '');

            if (mb_strlen($name) < 3) {
                throw new \RuntimeException('Informe o nome completo do administrador.');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('Informe um e-mail válido.');
            }
            if (mb_strlen($password) < 12) {
                throw new \RuntimeException('A senha deve ter pelo menos 12 caracteres.');
            }

            $users = new User();
            if ($users->findByEmail($email)) {
                throw new \RuntimeException('Já existe uma conta com este e-mail.');
            }

            $users->createAdmin($name, $email, $password);
            $_SESSION['admin_success'] = 'Administrador cadastrado. A senha deve ser entregue por um canal seguro.';
        } catch (\Throwable $e) {
            $_SESSION['admin_error'] = $e instanceof \RuntimeException
                ? $e->getMessage()
                : 'Não foi possível cadastrar o administrador.';
        }

        redirect('/admin/index.php?route=users');
    }

    public function toggle(): void
    {
        Auth::requireOwner();
        Csrf::verify();

        $id = (int) ($_POST['id'] ?? 0);
        $users = new User();
        $user = $users->find($id);
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            $_SESSION['admin_error'] = 'Esta conta não pode ser alterada.';
            redirect('/admin/index.php?route=users');
        }

        $users->setActive($id, empty($user['is_active']));
        $_SESSION['admin_success'] = empty($user['is_active'])
            ? 'Acesso do administrador reativado.'
            : 'Acesso do administrador suspenso.';
        redirect('/admin/index.php?route=users');
    }

    public function password(): void
    {
        Auth::requireOwner();
        Csrf::verify();

        $id = (int) ($_POST['id'] ?? 0);
        $password = (string) ($_POST['password'] ?? '');
        $user = (new User())->find($id);
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            $_SESSION['admin_error'] = 'Esta senha não pode ser alterada por esta tela.';
            redirect('/admin/index.php?route=users');
        }
        if (mb_strlen($password) < 12) {
            $_SESSION['admin_error'] = 'A nova senha deve ter pelo menos 12 caracteres.';
            redirect('/admin/index.php?route=users');
        }

        (new User())->updatePassword($id, $password);
        $_SESSION['admin_success'] = 'Senha do administrador atualizada.';
        redirect('/admin/index.php?route=users');
    }
}
