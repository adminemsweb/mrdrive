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
        $displayName = $safeName !== '' ? $safeName : 'cliente';
        $textBody = implode("\r\n", [
            'Olá, ' . $displayName . '!',
            '',
            'Confirme seu e-mail para concluir a configuração da sua conta MR Drives:',
            $confirmationUrl,
            '',
            'Este link é válido por 24 horas. Se você não criou esta conta, ignore esta mensagem.',
        ]);
        $htmlBody = $this->verificationHtml($displayName, $confirmationUrl, $baseUrl);

        if (($mail['driver'] ?? 'mail') === 'smtp') {
            return $this->sendSmtp($email, $subject, $textBody, $htmlBody, $mail);
        }

        $from = $this->cleanHeader((string) ($mail['from'] ?? 'site@mrdrives.com.br'));
        $fromName = $this->cleanHeader((string) ($mail['from_name'] ?? 'MR Drives'));
        [$mimeBody, $boundary] = $this->multipartBody($textBody, $htmlBody);
        $headers = [
            'From: ' . $fromName . ' <' . $from . '>',
            'Reply-To: ' . $this->cleanHeader((string) ($mail['reply_to'] ?? $from)),
            'MIME-Version: 1.0',
            'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
        ];

        return @mail($email, $subject, $mimeBody, implode("\r\n", $headers));
    }

    private function sendSmtp(string $recipient, string $subject, string $textBody, string $htmlBody, array $mail): bool
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
            [$mimeBody, $boundary] = $this->multipartBody($textBody, $htmlBody);
            $headers = [
                'Date: ' . date(DATE_RFC2822),
                'From: ' . $fromName . ' <' . $from . '>',
                'To: <' . $recipient . '>',
                'Reply-To: ' . $replyTo,
                'Subject: ' . $encodedSubject,
                'MIME-Version: 1.0',
                'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
            ];
            $safeBody = preg_replace('/(?m)^\./', '..', $mimeBody) ?? $mimeBody;
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

    private function multipartBody(string $textBody, string $htmlBody): array
    {
        $boundary = 'mrdrives_' . bin2hex(random_bytes(12));
        $body = implode("\r\n", [
            '--' . $boundary,
            'Content-Type: text/plain; charset=UTF-8',
            'Content-Transfer-Encoding: base64',
            '',
            rtrim(chunk_split(base64_encode($textBody), 76, "\r\n")),
            '--' . $boundary,
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: base64',
            '',
            rtrim(chunk_split(base64_encode($htmlBody), 76, "\r\n")),
            '--' . $boundary . '--',
        ]);

        return [$body, $boundary];
    }

    private function verificationHtml(string $displayName, string $confirmationUrl, string $baseUrl): string
    {
        $name = htmlspecialchars($displayName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $url = htmlspecialchars($confirmationUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $siteUrl = htmlspecialchars($baseUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $logo = htmlspecialchars($baseUrl . '/assets/img/logo-site.png', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        return '<!doctype html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>'
            . '<body style="margin:0;padding:0;background:#f2f5f8;font-family:Arial,Helvetica,sans-serif;color:#102b43">'
            . '<div style="display:none;max-height:0;overflow:hidden;opacity:0">Confirme seu e-mail para ativar sua conta MR Drives.</div>'
            . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f2f5f8"><tr><td align="center" style="padding:32px 16px">'
            . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:600px;background:#ffffff;border:1px solid #dce4eb;border-radius:14px;overflow:hidden">'
            . '<tr><td style="height:7px;background:#f45b18;font-size:0">&nbsp;</td></tr>'
            . '<tr><td align="center" style="padding:34px 36px 20px"><img src="' . $logo . '" width="150" alt="MR Drives" style="display:block;width:150px;max-width:100%;height:auto;border:0"></td></tr>'
            . '<tr><td style="padding:6px 42px 38px;text-align:center">'
            . '<p style="margin:0 0 10px;color:#f45b18;font-size:13px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase">Confirmação de cadastro</p>'
            . '<h1 style="margin:0 0 18px;font-size:30px;line-height:1.2;color:#0b2d47">Olá, ' . $name . '!</h1>'
            . '<p style="margin:0 auto 26px;max-width:470px;color:#5d7082;font-size:16px;line-height:1.65">Seu cadastro foi realizado. Confirme seu e-mail para ativar sua conta e acessar seus dados com segurança.</p>'
            . '<a href="' . $url . '" style="display:inline-block;background:#f45b18;color:#ffffff;text-decoration:none;font-size:16px;font-weight:700;padding:16px 30px;border-radius:7px">Confirmar meu e-mail</a>'
            . '<p style="margin:26px 0 0;color:#7a8997;font-size:13px;line-height:1.55">Este link é válido por 24 horas.<br>Se você não criou esta conta, ignore esta mensagem.</p>'
            . '</td></tr><tr><td style="padding:22px 36px;background:#0b2d47;text-align:center;color:#cbd6df;font-size:12px;line-height:1.6">MR Drives · Automação e controle industrial<br><a href="' . $siteUrl . '" style="color:#ffffff;text-decoration:none">mrdrives.com.br</a></td></tr>'
            . '</table></td></tr></table></body></html>';
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
