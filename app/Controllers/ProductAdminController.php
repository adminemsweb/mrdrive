<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Upload;
use App\Core\View;
use App\Models\Product;
use App\Models\ProductImage;

final class ProductAdminController
{
    public function index(): void
    {
        Auth::requireAdmin();
        View::render('admin/products/index', ['products' => (new Product())->all()], 'admin/layout');
    }

    public function create(): void
    {
        Auth::requireAdmin();
        View::render('admin/products/form', ['product' => null, 'images' => []], 'admin/layout');
    }

    public function store(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        try {
            $data = $this->payload();
            $data['main_image'] = Upload::file($_FILES['main_image'] ?? [], 'image', 'products');
            $data['manual_pdf'] = Upload::file($_FILES['manual_pdf'] ?? [], 'pdf', 'products');
            $id = (new Product())->create($data);
            $this->storeGallery($id);
            $_SESSION['admin_success'] = 'Produto cadastrado com sucesso.';
            redirect('/admin/index.php?route=products');
        } catch (\Throwable $e) {
            $_SESSION['admin_error'] = $e->getMessage();
            redirect('/admin/index.php?route=products.create');
        }
    }

    public function edit(): void
    {
        Auth::requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $product = (new Product())->find($id);
        if (!$product) {
            redirect('/admin/index.php?route=products');
        }

        View::render('admin/products/form', [
            'product' => $product,
            'images' => (new ProductImage())->forProduct($id),
        ], 'admin/layout');
    }

    public function update(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        $id = (int) ($_POST['id'] ?? 0);
        $product = (new Product())->find($id);
        if (!$product) {
            redirect('/admin/index.php?route=products');
        }

        try {
            $data = $this->payload();
            $data['main_image'] = Upload::file($_FILES['main_image'] ?? [], 'image', 'products') ?: $product['main_image'];
            $data['manual_pdf'] = Upload::file($_FILES['manual_pdf'] ?? [], 'pdf', 'products') ?: $product['manual_pdf'];
            (new Product())->update($id, $data);
            $this->storeGallery($id);
            $_SESSION['admin_success'] = 'Produto atualizado com sucesso.';
            redirect('/admin/index.php?route=products');
        } catch (\Throwable $e) {
            $_SESSION['admin_error'] = $e->getMessage();
            redirect('/admin/index.php?route=products.edit&id=' . $id);
        }
    }

    public function delete(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        (new Product())->delete((int) ($_POST['id'] ?? 0));
        $_SESSION['admin_success'] = 'Produto excluído com sucesso.';
        redirect('/admin/index.php?route=products');
    }

    public function deleteImage(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        (new ProductImage())->delete((int) ($_POST['id'] ?? 0));
        $_SESSION['admin_success'] = 'Imagem removida da galeria.';
        redirect('/admin/index.php?route=products.edit&id=' . (int) ($_POST['product_id'] ?? 0));
    }

    private function payload(): array
    {
        $saleChannel = (string) ($_POST['sale_channel'] ?? 'whatsapp');
        if (!in_array($saleChannel, ['whatsapp', 'cart'], true)) {
            $saleChannel = 'whatsapp';
        }
        if (!(bool) (app_config('store')['cart_enabled'] ?? false)) {
            $saleChannel = 'whatsapp';
        }
        $price = $this->decimalOrNull($_POST['price'] ?? null);
        $compareAtPrice = $this->decimalOrNull($_POST['compare_at_price'] ?? null);

        if ($saleChannel === 'cart' && ($price === null || (float) $price <= 0)) {
            throw new \RuntimeException('Informe um preço maior que zero para produtos com compra direta na loja.');
        }
        if ($saleChannel === 'whatsapp') {
            $price = null;
            $compareAtPrice = null;
        }

        return [
            'name' => trim((string) ($_POST['name'] ?? '')),
            'model_code' => trim((string) ($_POST['model_code'] ?? '')),
            'category' => trim((string) ($_POST['category'] ?? '')),
            'short_description' => trim((string) ($_POST['short_description'] ?? '')),
            'full_description' => trim((string) ($_POST['full_description'] ?? '')),
            'power' => trim((string) ($_POST['power'] ?? '')),
            'voltage' => trim((string) ($_POST['voltage'] ?? '')),
            'recommended_applications' => trim((string) ($_POST['recommended_applications'] ?? '')),
            'technical_specs' => trim((string) ($_POST['technical_specs'] ?? '')),
            'sku' => trim((string) ($_POST['sku'] ?? '')) ?: null,
            'price' => $price,
            'compare_at_price' => $compareAtPrice,
            'sale_channel' => $saleChannel,
            'stock_quantity' => max(0, (int) ($_POST['stock_quantity'] ?? 0)),
            'track_stock' => isset($_POST['track_stock']) ? 1 : 0,
            'shipping_days' => trim((string) ($_POST['shipping_days'] ?? '')),
            'main_image' => null,
            'manual_pdf' => null,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_offer' => isset($_POST['is_offer']) ? 1 : 0,
            'is_best_seller' => isset($_POST['is_best_seller']) ? 1 : 0,
            'is_new' => isset($_POST['is_new']) ? 1 : 0,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ];
    }

    private function decimalOrNull(mixed $value): ?string
    {
        $normalized = str_replace(',', '.', trim((string) $value));
        if ($normalized === '' || !is_numeric($normalized)) {
            return null;
        }

        return number_format(max(0, (float) $normalized), 2, '.', '');
    }

    private function storeGallery(int $productId): void
    {
        if (empty($_FILES['gallery']['name']) || !is_array($_FILES['gallery']['name'])) {
            return;
        }

        foreach ($_FILES['gallery']['name'] as $index => $name) {
            $file = [
                'name' => $name,
                'type' => $_FILES['gallery']['type'][$index],
                'tmp_name' => $_FILES['gallery']['tmp_name'][$index],
                'error' => $_FILES['gallery']['error'][$index],
                'size' => $_FILES['gallery']['size'][$index],
            ];
            $path = Upload::file($file, 'image', 'products');
            if ($path) {
                (new ProductImage())->add($productId, $path, $index);
            }
        }
    }
}
