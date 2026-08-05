<?php

declare(strict_types=1);

namespace App\Services;

use RuntimeException;

final class CorreiosService
{
    private array $config;

    public function __construct()
    {
        $this->config = app_config('shipping')['correios'] ?? [];
    }

    public function officialEnabled(): bool
    {
        return !empty($this->config['enabled'])
            && ($this->config['username'] ?? '') !== ''
            && ($this->config['api_code'] ?? '') !== ''
            && ($this->config['contract'] ?? '') !== '';
    }

    public function lookupPostalCode(string $postalCode): ?array
    {
        $postalCode = $this->digits($postalCode);
        if (strlen($postalCode) !== 8) {
            throw new RuntimeException('CEP inválido.');
        }

        if ($this->officialEnabled()) {
            try {
                $data = $this->requestJson(
                    'GET',
                    $this->apiBase('cep') . '/v2/enderecos/' . $postalCode,
                    null,
                    ['Authorization: Bearer ' . $this->token()]
                );

                return $this->normalizeAddress($data, 'Correios');
            } catch (RuntimeException) {
                // Mantém o checkout disponível caso a API contratual esteja temporariamente indisponível.
            }
        }

        $data = $this->requestJson('GET', 'https://viacep.com.br/ws/' . $postalCode . '/json/');
        if (!empty($data['erro'])) {
            return null;
        }

        return $this->normalizeAddress($data, 'ViaCEP');
    }

    public function quote(string $destinationPostalCode): array
    {
        $destinationPostalCode = $this->digits($destinationPostalCode);
        $address = $this->lookupPostalCode($destinationPostalCode);

        if (!$address) {
            throw new RuntimeException('CEP não encontrado.');
        }

        if (!$this->officialEnabled()) {
            return [
                'address' => $address,
                'rates' => [],
                'message' => 'Endereço localizado. O valor e o prazo do frete serão confirmados no atendimento.',
                'correios_configured' => false,
            ];
        }

        $shipping = app_config('shipping');
        $origin = $this->digits((string) ($shipping['origin_postal_code'] ?? ''));
        $package = $shipping['default_package'] ?? [];
        $rates = [];

        foreach (($this->config['services'] ?? []) as $code => $name) {
            try {
                $query = http_build_query([
                    'cepDestino' => $destinationPostalCode,
                    'cepOrigem' => $origin,
                    'psObjeto' => (int) ($package['weight_grams'] ?? 1000),
                    'tpObjeto' => 2,
                    'comprimento' => (int) ($package['length_cm'] ?? 30),
                    'largura' => (int) ($package['width_cm'] ?? 20),
                    'altura' => (int) ($package['height_cm'] ?? 15),
                ]);
                $headers = ['Authorization: Bearer ' . $this->token()];
                $price = $this->requestJson('GET', $this->apiBase('preco') . '/v1/nacional/' . rawurlencode((string) $code) . '?' . $query, null, $headers);
                $deadline = $this->requestJson('GET', $this->apiBase('prazo') . '/v1/nacional/' . rawurlencode((string) $code) . '?' . http_build_query([
                    'cepOrigem' => $origin,
                    'cepDestino' => $destinationPostalCode,
                ]), null, $headers);
                if (!empty($price['pcFinal'])) {
                    $rates[] = [
                        'service' => (string) $name,
                        'code' => (string) $code,
                        'price' => (string) $price['pcFinal'],
                        'days' => isset($deadline['prazoEntrega']) ? (int) $deadline['prazoEntrega'] : null,
                    ];
                }
            } catch (RuntimeException) {
                // Um serviço pode estar indisponível sem invalidar os demais.
            }
        }

        return [
            'address' => $address,
            'rates' => $rates,
            'message' => $rates ? null : 'Endereço localizado. Não foi possível calcular o frete agora; confirme no atendimento.',
            'correios_configured' => true,
        ];
    }

    private function token(): string
    {
        $cached = $_SESSION['correios_token'] ?? null;
        if (is_array($cached) && !empty($cached['token']) && (int) ($cached['expires_at'] ?? 0) > time() + 60) {
            return (string) $cached['token'];
        }

        $data = $this->requestJson(
            'POST',
            (string) ($this->config['token_url'] ?? 'https://api.correios.com.br/token/v1/autentica/contrato'),
            ['numero' => (string) $this->config['contract'], 'dr' => (int) ($this->config['regional'] ?? 0)],
            ['Authorization: Basic ' . base64_encode((string) $this->config['username'] . ':' . (string) $this->config['api_code'])]
        );

        $token = (string) ($data['token'] ?? '');
        if ($token === '') {
            throw new RuntimeException('A API dos Correios não retornou um token válido.');
        }

        $expiresAt = isset($data['expiraEm']) ? strtotime((string) $data['expiraEm']) : time() + 3600;
        $_SESSION['correios_token'] = ['token' => $token, 'expires_at' => $expiresAt ?: time() + 3600];
        return $token;
    }

    private function apiBase(string $api): string
    {
        $homologation = ($this->config['environment'] ?? 'production') === 'homologation';
        $host = $homologation ? 'https://apihom.correios.com.br' : 'https://api.correios.com.br';
        return match ($api) {
            'cep' => $host . '/cep',
            'preco' => $host . '/preco',
            'prazo' => $host . '/prazo',
            default => $host,
        };
    }

    private function requestJson(string $method, string $url, ?array $body = null, array $headers = []): array
    {
        if (!function_exists('curl_init')) {
            throw new RuntimeException('A extensão cURL do PHP é necessária para consultar o CEP.');
        }

        $handle = curl_init($url);
        $requestHeaders = array_merge(['Accept: application/json'], $headers);
        curl_setopt_array($handle, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_TIMEOUT => 8,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_USERAGENT => 'MRDRIVES/1.0',
        ]);
        if (defined('CURLSSLOPT_NATIVE_CA')) {
            curl_setopt($handle, CURLOPT_SSL_OPTIONS, CURLSSLOPT_NATIVE_CA);
        }
        if ($body !== null) {
            $requestHeaders[] = 'Content-Type: application/json';
            curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
        }
        curl_setopt($handle, CURLOPT_HTTPHEADER, $requestHeaders);

        $response = curl_exec($handle);
        $status = (int) curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        $error = curl_error($handle);
        curl_close($handle);

        if (!is_string($response) || $status < 200 || $status >= 300) {
            throw new RuntimeException($error ?: 'Serviço de CEP temporariamente indisponível.');
        }

        $decoded = json_decode($response, true);
        if (!is_array($decoded)) {
            throw new RuntimeException('Resposta inválida do serviço de CEP.');
        }
        return $decoded;
    }

    private function normalizeAddress(array $data, string $provider): array
    {
        return [
            'postal_code' => $this->digits((string) ($data['cep'] ?? '')),
            'street' => (string) ($data['logradouro'] ?? ''),
            'complement' => (string) ($data['complemento'] ?? ''),
            'district' => (string) ($data['bairro'] ?? ''),
            'city' => (string) ($data['localidade'] ?? ''),
            'state' => (string) ($data['uf'] ?? ''),
            'provider' => $provider,
        ];
    }

    private function digits(string $value): string
    {
        return preg_replace('/\D+/', '', $value) ?? '';
    }
}
