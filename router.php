<?php

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$root = __DIR__;

$publicFile = realpath($root . '/public' . $path);
if ($publicFile && str_starts_with($publicFile, realpath($root . '/public')) && is_file($publicFile)) {
    $extension = strtolower(pathinfo($publicFile, PATHINFO_EXTENSION));
    $types = [
        'css' => 'text/css; charset=utf-8',
        'js' => 'application/javascript; charset=utf-8',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'pdf' => 'application/pdf',
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
    ];
    $fileSize = filesize($publicFile);
    header('Content-Type: ' . ($types[$extension] ?? 'application/octet-stream'));

    if (in_array($extension, ['mp4', 'webm'], true)) {
        header('Accept-Ranges: bytes');
        $range = $_SERVER['HTTP_RANGE'] ?? '';
        if (preg_match('/bytes=(\d*)-(\d*)/', $range, $matches)) {
            $start = $matches[1] === '' ? 0 : (int) $matches[1];
            $end = $matches[2] === '' ? $fileSize - 1 : (int) $matches[2];
            $end = min($end, $fileSize - 1);
            if ($start <= $end) {
                http_response_code(206);
                header("Content-Range: bytes {$start}-{$end}/{$fileSize}");
                header('Content-Length: ' . ($end - $start + 1));
                if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'HEAD') {
                    return;
                }
                $handle = fopen($publicFile, 'rb');
                fseek($handle, $start);
                $remaining = $end - $start + 1;
                while ($remaining > 0 && !feof($handle)) {
                    $chunk = fread($handle, min(8192, $remaining));
                    echo $chunk;
                    $remaining -= strlen($chunk);
                }
                fclose($handle);
                return;
            }
        }
    }

    header('Content-Length: ' . $fileSize);
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'HEAD') {
        return;
    }
    readfile($publicFile);
    return;
}

$directFile = realpath($root . $path);
if ($directFile && str_starts_with($directFile, realpath($root)) && is_file($directFile)) {
    return false;
}

if (str_starts_with($path, '/admin')) {
    require $root . '/admin/index.php';
    return;
}

require $root . '/public/index.php';
