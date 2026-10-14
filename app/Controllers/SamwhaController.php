<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\View;
use App\Services\SamwhaService;

final class SamwhaController
{
    public function show(?string $slug = null): void
    {
        $result = (new SamwhaService())->fetch($slug === null ? '/api/products' : '/api/products/' . rawurlencode($slug), $slug === null);
        if ($slug !== null && $result['data'] === null) {
            http_response_code($result['unavailable'] ? 503 : 404);
        }
        $categories = $slug === null ? (new SamwhaService())->fetch('/api/categories', true)['data'] ?? [] : [];
        $all = $slug === null ? $result['data'] ?? [] : [];
        $category = max(0, (int) ($_GET['categoria'] ?? 0));
        $query = trim((string) ($_GET['q'] ?? ''));
        $sort = ($_GET['ordem'] ?? '') === 'nome' ? 'nome' : 'destaques';
        $ids = [$category];
        foreach ($categories as $item) {
            if ((int) $item['id'] === $category) {
                foreach ($item['children'] ?? [] as $child) { $ids[] = (int) $child['id']; }
            }
        }
        $filtered = array_values(array_filter($all, static fn(array $p): bool =>
            (!$category || in_array((int) ($p['category_id'] ?? 0), $ids, true)) &&
            ($query === '' || mb_stripos($p['name'] . ' ' . ($p['product_code'] ?? '') . ' ' . ($p['category'] ?? ''), $query) !== false)
        ));
        $total = count($filtered);
        usort($filtered, static fn(array $a, array $b): int => $sort === 'nome'
            ? strnatcasecmp($a['name'], $b['name'])
            : ((int) ($b['is_featured'] ?? false) <=> (int) ($a['is_featured'] ?? false)));
        $pages = max(1, (int) ceil($total / 12));
        $page = min($pages, max(1, (int) ($_GET['pagina'] ?? 1)));
        View::render('public/samwha', [
            'title' => $slug !== null && $result['data'] ? $result['data']['name'] . ' | MR Drives' : 'Produtos Samwha DSP | MR Drives',
            'result' => $result, 'detail' => $slug !== null, 'categories' => $categories,
            'products' => array_slice($filtered, ($page - 1) * 12, 12),
            'total' => $total, 'pages' => $pages, 'page' => $page, 'category' => $category, 'query' => $query,
            'sort' => $sort, 'catalogCount' => count($all),
        ], 'public/layout');
    }
}
