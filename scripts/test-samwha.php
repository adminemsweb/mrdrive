<?php
declare(strict_types=1);

namespace App\Services {
    function curl_init($url) { return $url; }
    function curl_setopt_array($handle, $options) { return true; }
    function curl_exec($handle) { return $GLOBALS['test_body']; }
    function curl_getinfo($handle, $option) { return $GLOBALS['test_status']; }
    function curl_close($handle) {}
}

namespace {
    $root = sys_get_temp_dir() . '/mrdrives-samwha-test-' . bin2hex(random_bytes(6));
    function base_path(string $path = ''): string { return $GLOBALS['root'] . '/' . $path; }
    function app_config(?string $key = null): array { return ['api_base' => 'https://samwha.com.br']; }
    require dirname(__DIR__) . '/app/Services/SamwhaService.php';
    function check(bool $ok, string $message): void {
        if (!$ok) { throw new \RuntimeException($message); }
    }
    function expire(string $path): void {
        $file = base_path('storage/samwha/') . hash('sha256', 'https://samwha.com.br' . $path) . '.cache';
        $cache = json_decode(file_get_contents($file), true);
        $cache['checked_at'] = 0;
        file_put_contents($file, json_encode($cache));
    }
    try {
        $service = new \App\Services\SamwhaService();
        $test_status = 200;
        $product = ['id' => 50, 'slug' => 'akr-01d', 'name' => 'AKR-01D', 'stock_status' => 'on_request', 'stock_quantity' => 2];
        $test_body = json_encode([$product]);
        $result = $service->fetch('/api/products', true);
        check($result['data'][0]['id'] === 50 && !$result['stale'], 'Valid list');
        expire('/api/products');
        $test_status = 503;
        $test_body = 'Unavailable';
        $result = $service->fetch('/api/products', true);
        check($result['stale'] && $result['data'][0]['id'] === 50, '503 must preserve list');
        expire('/api/products');
        $test_status = 200;
        $test_body = '[{"error":"invalid"}]';
        check($service->fetch('/api/products', true)['stale'], 'Malformed response must preserve list');
        expire('/api/products');
        $test_body = '[]';
        check($service->fetch('/api/products', true)['data'] === [], 'Successful empty list');
        $test_body = json_encode($product);
        check($service->fetch('/api/products/akr-01d')['data']['id'] === 50, 'Product detail');
        expire('/api/products/akr-01d');
        $test_status = 404;
        $test_body = '{}';
        $result = $service->fetch('/api/products/akr-01d');
        check($result['data'] === null && !$result['unavailable'], '404 must not serve stale product');
        $test_status = 503;
        check($service->fetch('/api/products/missing')['unavailable'], 'Initial outage');
        check(\App\Services\SamwhaService::availability($product) === 'Sob consulta', 'Status precedes quantity');
        check(\App\Services\SamwhaService::asset('/uploads/test.webp') === 'https://samwha.com.br/uploads/test.webp', 'Relative image');
        check(\App\Services\SamwhaService::asset('javascript:alert(1)') === '', 'Unsafe asset scheme');
        echo "Samwha integration checks passed.\n";
    } finally {
        foreach (glob($root . '/storage/samwha/*') ?: [] as $file) { unlink($file); }
        if (is_dir($root . '/storage/samwha')) { rmdir($root . '/storage/samwha'); rmdir($root . '/storage'); rmdir($root); }
    }
}
