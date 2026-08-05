<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\CustomerAuth;
use App\Core\View;
use App\Models\Customer;
use App\Services\CustomerVerificationService;
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
        $profile = $this->profileFromRequest();
        $old = ['first_name' => $firstName, 'last_name' => $lastName, 'email' => $email, ...$profile];

        if (mb_strlen($firstName) < 2 || mb_strlen($firstName) > 80) {
            $this->fail('Informe seu nome.', $old, '/criar-conta');
        }
        if (mb_strlen($lastName) < 2 || mb_strlen($lastName) > 120) {
            $this->fail('Informe seu sobrenome.', $old, '/criar-conta');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->fail('Informe um e-mail válido.', $old, '/criar-conta');
        }
        if ($profileError = $this->validateProfile($profile)) {
            $this->fail($profileError, $old, '/criar-conta');
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
            $verification = (new CustomerVerificationService())->issue();
            $customer = $model->create(
                $firstName,
                $lastName,
                $email,
                $password,
                $profile,
                $verification['hash'],
                $verification['expires_at']
            );
        } catch (Throwable) {
            $this->fail('Não foi possível criar sua conta agora. Tente novamente em instantes.', $old, '/criar-conta');
        }

        CustomerAuth::login($customer);
        $sent = (new CustomerVerificationService())->send($email, $firstName, $verification['token']);
        $this->message(
            $sent
                ? 'Conta criada. Enviamos um link de confirmação para o seu e-mail.'
                : 'Conta criada. O envio automático não está disponível agora; você pode reenviar a confirmação em Minha conta.',
            $sent ? 'success' : 'warning'
        );
        redirect('/minha-conta');
    }

    public function account(): void
    {
        $customer = $this->currentCustomer();
        CustomerAuth::login($customer);
        View::render('public/account', [
            'title' => 'Minha conta | MRDRIVES',
            'customer' => $customer,
            'profileComplete' => $this->profileIsComplete($customer),
            'message' => $this->pullMessage(),
        ], 'public/layout');
    }

    public function confirmEmail(): void
    {
        $token = strtolower(trim((string) ($_GET['token'] ?? '')));
        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            $this->message('O link de confirmação é inválido ou já foi utilizado.', 'error');
            redirect('/minha-conta');
        }

        $customer = (new Customer())->verifyEmailToken(hash('sha256', $token));
        if (!$customer) {
            $this->message('O link de confirmação expirou ou já foi utilizado. Solicite um novo link.', 'error');
            redirect('/minha-conta');
        }

        CustomerAuth::login($customer);
        $this->message('E-mail confirmado com sucesso. Sua conta está verificada.', 'success');
        redirect('/minha-conta');
    }

    public function resendConfirmation(): void
    {
        Csrf::verify();
        $customer = $this->currentCustomer();
        if (!empty($customer['email_verified_at'])) {
            $this->message('Seu e-mail já está confirmado.', 'success');
            redirect('/minha-conta');
        }

        $lastSent = (int) ($_SESSION['verification_last_sent_at'] ?? 0);
        if ($lastSent > time() - 60) {
            $this->message('Aguarde um minuto antes de solicitar outro e-mail.', 'warning');
            redirect('/minha-conta');
        }

        $verification = (new CustomerVerificationService())->issue();
        (new Customer())->setVerificationToken((int) $customer['id'], $verification['hash'], $verification['expires_at']);
        $_SESSION['verification_last_sent_at'] = time();
        $sent = (new CustomerVerificationService())->send(
            (string) $customer['email'],
            (string) $customer['first_name'],
            $verification['token']
        );
        $this->message(
            $sent
                ? 'Enviamos um novo link de confirmação para o seu e-mail.'
                : 'Não foi possível enviar agora. Confira a configuração de e-mail do site e tente novamente.',
            $sent ? 'success' : 'error'
        );
        redirect('/minha-conta');
    }

    public function settings(): void
    {
        View::render('public/account-settings', [
            'title' => 'Configurações da conta | MRDRIVES',
            'customer' => $this->currentCustomer(),
            'message' => $this->pullMessage(),
        ], 'public/layout');
    }

    public function updateSettings(): void
    {
        Csrf::verify();
        $customer = $this->currentCustomer();
        $firstName = trim((string) ($_POST['first_name'] ?? ''));
        $lastName = trim((string) ($_POST['last_name'] ?? ''));
        $email = mb_strtolower(trim((string) ($_POST['email'] ?? '')));
        $currentPassword = (string) ($_POST['current_password'] ?? '');
        $profile = $this->profileFromRequest();

        if (mb_strlen($firstName) < 2 || mb_strlen($firstName) > 80 || mb_strlen($lastName) < 2 || mb_strlen($lastName) > 120) {
            $this->message('Revise seu nome e sobrenome.', 'error');
            redirect('/minha-conta/configuracoes');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->message('Informe um e-mail válido.', 'error');
            redirect('/minha-conta/configuracoes');
        }

        if ($profileError = $this->validateProfile($profile)) {
            $this->message($profileError, 'error');
            redirect('/minha-conta/configuracoes');
        }

        $emailChanged = !hash_equals((string) $customer['email'], $email);
        if ($emailChanged) {
            if (!password_verify($currentPassword, (string) $customer['password'])) {
                $this->message('Confirme sua senha atual para alterar o e-mail.', 'error');
                redirect('/minha-conta/configuracoes');
            }
            $existing = (new Customer())->findByEmail($email);
            if ($existing && (int) $existing['id'] !== (int) $customer['id']) {
                $this->message('Este e-mail já está vinculado a outra conta.', 'error');
                redirect('/minha-conta/configuracoes');
            }
        }

        $model = new Customer();
        $updated = $model->updateProfile((int) $customer['id'], $firstName, $lastName, $email, $profile);
        if ($emailChanged) {
            $verification = (new CustomerVerificationService())->issue();
            $model->setVerificationToken((int) $customer['id'], $verification['hash'], $verification['expires_at']);
            $updated = $model->find((int) $customer['id']) ?? $updated;
            $sent = (new CustomerVerificationService())->send($email, $firstName, $verification['token']);
            $this->message(
                $sent
                    ? 'Dados atualizados. Confirme o novo e-mail pelo link enviado.'
                    : 'Dados atualizados, mas não foi possível enviar a confirmação do novo e-mail agora.',
                $sent ? 'success' : 'warning'
            );
        } else {
            $this->message('Seus dados foram atualizados.', 'success');
        }

        CustomerAuth::login($updated);
        redirect('/minha-conta/configuracoes');
    }

    public function updatePassword(): void
    {
        Csrf::verify();
        $customer = $this->currentCustomer();
        $current = (string) ($_POST['current_password'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $confirmation = (string) ($_POST['password_confirmation'] ?? '');

        if (!password_verify($current, (string) $customer['password'])) {
            $this->message('A senha atual está incorreta.', 'error');
        } elseif (strlen($password) < 8) {
            $this->message('A nova senha precisa ter pelo menos 8 caracteres.', 'error');
        } elseif (!hash_equals($password, $confirmation)) {
            $this->message('A confirmação da nova senha não coincide.', 'error');
        } else {
            (new Customer())->updatePassword((int) $customer['id'], $password);
            session_regenerate_id(true);
            $this->message('Senha alterada com segurança.', 'success');
        }
        redirect('/minha-conta/configuracoes');
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

    private function currentCustomer(): array
    {
        if (!CustomerAuth::check()) {
            redirect('/entrar');
        }
        $customer = (new Customer())->find((int) (CustomerAuth::user()['id'] ?? 0));
        if (!$customer) {
            CustomerAuth::logout();
            redirect('/entrar');
        }

        return $customer;
    }

    private function message(string $text, string $type): void
    {
        $_SESSION['customer_message'] = ['text' => $text, 'type' => $type];
    }

    private function pullMessage(): ?array
    {
        $message = $_SESSION['customer_message'] ?? null;
        unset($_SESSION['customer_message']);

        return is_array($message) ? $message : null;
    }

    private function profileFromRequest(): array
    {
        return [
            'birth_date' => trim((string) ($_POST['birth_date'] ?? '')),
            'phone' => preg_replace('/\D+/', '', (string) ($_POST['phone'] ?? '')) ?? '',
            'postal_code' => preg_replace('/\D+/', '', (string) ($_POST['postal_code'] ?? '')) ?? '',
            'street' => trim((string) ($_POST['street'] ?? '')),
            'address_number' => trim((string) ($_POST['address_number'] ?? '')),
            'complement' => trim((string) ($_POST['complement'] ?? '')),
            'district' => trim((string) ($_POST['district'] ?? '')),
            'city' => trim((string) ($_POST['city'] ?? '')),
            'state' => mb_strtoupper(trim((string) ($_POST['state'] ?? ''))),
        ];
    }

    private function validateProfile(array $profile): ?string
    {
        $birthDate = \DateTimeImmutable::createFromFormat('!Y-m-d', (string) $profile['birth_date']);
        $today = new \DateTimeImmutable('today');
        if (!$birthDate || $birthDate->format('Y-m-d') !== $profile['birth_date'] || $birthDate >= $today || $birthDate < $today->modify('-120 years')) {
            return 'Informe uma data de nascimento válida.';
        }
        if (!preg_match('/^\d{10,11}$/', (string) $profile['phone'])) {
            return 'Informe um telefone com DDD.';
        }
        if (!preg_match('/^\d{8}$/', (string) $profile['postal_code'])) {
            return 'Informe um CEP válido com 8 números.';
        }
        foreach (['street' => 180, 'address_number' => 30, 'district' => 120, 'city' => 120] as $field => $maxLength) {
            $length = mb_strlen((string) $profile[$field]);
            if ($length < 1 || $length > $maxLength) {
                return 'Preencha o endereço completo e confira os dados.';
            }
        }
        if (!preg_match('/^[A-Z]{2}$/', (string) $profile['state'])) {
            return 'Informe a UF com duas letras.';
        }
        if (mb_strlen((string) $profile['complement']) > 120) {
            return 'O complemento deve ter no máximo 120 caracteres.';
        }

        return null;
    }

    private function profileIsComplete(array $customer): bool
    {
        foreach (['birth_date', 'phone', 'postal_code', 'street', 'address_number', 'district', 'city', 'state'] as $field) {
            if (trim((string) ($customer[$field] ?? '')) === '') {
                return false;
            }
        }

        return true;
    }
}
