<?php
declare(strict_types=1);

namespace App\Services;

final class SamwhaService
{
    private static function base(): string
    {
        return rtrim((string) (app_config('samwha')['api_base'] ?? 'https://samwha.com.br'), '/');
    }

    public function fetch(string $path, bool $list = false): array
    {
        $directory = base_path('storage/samwha');
        $file = $directory . '/' . hash('sha256', self::base() . $path) . '.cache';
        $cached = is_file($file) ? json_decode((string) file_get_contents($file), true) : null;
        if (is_array($cached) && time() - (int) ($cached['checked_at'] ?? 0) < 300) {
            return $cached;
        }
        $curl = curl_init(self::base() . $path);
        curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => ['Accept: application/json'], CURLOPT_CONNECTTIMEOUT => 3, CURLOPT_TIMEOUT => 8]);
        $body = curl_exec($curl);
        $status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $data = is_string($body) ? json_decode($body, true) : null;
        $valid = $status === 200 && is_array($data) && ($list
            ? array_is_list($data) && count(array_filter($data, static fn($p) => is_array($p) && isset($p['id'], $p['slug'], $p['name']))) === count($data)
            : isset($data['id'], $data['slug'], $data['name']));
        $result = $valid
            ? ['data' => $data, 'stale' => false, 'unavailable' => false, 'checked_at' => time(), 'fetched_at' => time()]
            : ['data' => $status === 404 ? null : ($cached['data'] ?? null), 'stale' => $status !== 404 && isset($cached['data']), 'unavailable' => $status !== 404, 'checked_at' => time(), 'fetched_at' => $cached['fetched_at'] ?? null];
        if (!is_dir($directory)) { @mkdir($directory, 0775, true); }
        $temporary = @tempnam($directory, 'samwha-');
        if ($temporary !== false) {
            if (@file_put_contents($temporary, json_encode($result), LOCK_EX) !== false) { @rename($temporary, $file); }
            if (is_file($temporary)) { @unlink($temporary); }
        }
        return $result;
    }

    public static function asset(?string $path): string
    {
        $path = trim($path ?? '');
        if ($path === '') { return ''; }
        if (preg_match('~^https?://~i', $path)) { return $path; }
        if (str_starts_with($path, '//') || preg_match('~^[a-z][a-z0-9+.-]*:~i', $path)) { return ''; }
        return self::base() . '/' . ltrim($path, '/');
    }

    public static function availability(array $product): string
    {
        return match ($product['stock_status'] ?? '') {
            'available' => 'Disponível',
            'out_of_stock' => 'Esgotado',
            default => 'Sob consulta',
        };
    }
}
