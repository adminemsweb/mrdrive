<?php

declare(strict_types=1);

namespace App\Services;

use RuntimeException;
use Throwable;

final class CustomerVerificationService
{
    public function issue(): array
    {
        $token = bin2hex(random_bytes(32));

        return [
            'token' => $token,
            'hash' => hash('sha256', $token),
            'expires_at' => date('Y-m-d H:i:s', time() + 86400),
        ];
    }

    public function send(string $email, string $firstName, string $token): bool
    {
        $mail = app_config('mail');
        $baseUrl = rtrim((string) (app_config('app')['url'] ?? ''), '/');
        $confirmationUrl = $baseUrl . '/confirmar-email?token=' . rawurlencode($token);
        $subject = 'Confirme seu e-mail na MR Drives';
        $safeName = trim(preg_replace('/[\r\n]+/', ' ', $firstName) ?? '');
        $body = implode("\r\n", [
            'Olá, ' . ($safeName !== '' ? $safeName : 'cliente') . '!',
            '',
            'Confirme seu e-mail para concluir a configuração da sua conta MR Drives:',
            $confirmationUrl,
            '',
            'Este link é válido por 24 horas. Se você não criou esta conta, ignore esta mensagem.',
        ]);

        if (($mail['driver'] ?? 'mail') === 'smtp') {
            return $this->sendSmtp($email, $subject, $body, $mail);
        }

        $from = $this->cleanHeader((string) ($mail['from'] ?? 'site@mrdrives.com.br'));
        $fromName = $this->cleanHeader((string) ($mail['from_name'] ?? 'MR Drives'));
        $headers = [
            'From: ' . $fromName . ' <' . $from . '>',
            'Reply-To: ' . $this->cleanHeader((string) ($mail['reply_to'] ?? $from)),
            'Content-Type: text/plain; charset=UTF-8',
        ];

        return @mail($email, $subject, $body, implode("\r\n", $headers));
    }

    private function sendSmtp(string $recipient, string $subject, string $body, array $mail): bool
    {
        $smtp = $mail['smtp'] ?? [];
        $host = trim((string) ($smtp['host'] ?? ''));
        $port = (int) ($smtp['port'] ?? 587);
        $encryption = strtolower(trim((string) ($smtp['encryption'] ?? 'tls')));
        $username = (string) ($smtp['username'] ?? '');
        $password = (string) ($smtp['password'] ?? '');
        $from = trim((string) ($mail['from'] ?? ''));
        $replyTo = trim((string) ($mail['reply_to'] ?? $from));
        $fromName = $this->cleanHeader((string) ($mail['from_name'] ?? 'MR Drives'));

        if ($host === '' || !filter_var($recipient, FILTER_VALIDATE_EMAIL) || !filter_var($from, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $socket = null;
        try {
            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                    'peer_name' => $host,
                    'allow_self_signed' => false,
                ],
            ]);
            $target = ($encryption === 'ssl' ? 'ssl://' : 'tcp://') . $host . ':' . $port;
            $socket = @stream_socket_client($target, $errorCode, $errorMessage, 10, STREAM_CLIENT_CONNECT, $context);
            if (!is_resource($socket)) {
                throw new RuntimeException($errorMessage ?: 'Falha ao conectar ao SMTP.');
            }
            stream_set_timeout($socket, 10);
            $this->expect($socket, [220]);
            $this->command($socket, 'EHLO mrdrives.com.br', [250]);

            if ($encryption === 'tls') {
                $this->command($socket, 'STARTTLS', [220]);
                if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                    throw new RuntimeException('Falha ao ativar TLS no SMTP.');
                }
                $this->command($socket, 'EHLO mrdrives.com.br', [250]);
            }

            if ($username !== '') {
                $this->command($socket, 'AUTH LOGIN', [334]);
                $this->command($socket, base64_encode($username), [334]);
                $this->command($socket, base64_encode($password), [235]);
            }

            $this->command($socket, 'MAIL FROM:<' . $from . '>', [250]);
            $this->command($socket, 'RCPT TO:<' . $recipient . '>', [250, 251]);
            $this->command($socket, 'DATA', [354]);

            $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $headers = [
                'Date: ' . date(DATE_RFC2822),
                'From: ' . $fromName . ' <' . $from . '>',
                'To: <' . $recipient . '>',
                'Reply-To: ' . $replyTo,
                'Subject: ' . $encodedSubject,
                'MIME-Version: 1.0',
                'Content-Type: text/plain; charset=UTF-8',
                'Content-Transfer-Encoding: 8bit',
            ];
            $safeBody = preg_replace('/(?m)^\./', '..', $body) ?? $body;
            fwrite($socket, implode("\r\n", $headers) . "\r\n\r\n" . $safeBody . "\r\n.\r\n");
            $this->expect($socket, [250]);
            $this->command($socket, 'QUIT', [221]);
            fclose($socket);

            return true;
        } catch (Throwable) {
            if (is_resource($socket)) {
                fclose($socket);
            }
            return false;
        }
    }

    private function command($socket, string $command, array $expectedCodes): void
    {
        fwrite($socket, $command . "\r\n");
        $this->expect($socket, $expectedCodes);
    }

    private function expect($socket, array $expectedCodes): void
    {
        $response = '';
        do {
            $line = fgets($socket, 1024);
            if (!is_string($line)) {
                throw new RuntimeException('Resposta SMTP incompleta.');
            }
            $response .= $line;
        } while (isset($line[3]) && $line[3] === '-');

        $code = (int) substr($response, 0, 3);
        if (!in_array($code, $expectedCodes, true)) {
            throw new RuntimeException('Resposta SMTP inesperada.');
        }
    }

    private function cleanHeader(string $value): string
    {
        return trim(preg_replace('/[\r\n]+/', ' ', $value) ?? '');
    }
}
