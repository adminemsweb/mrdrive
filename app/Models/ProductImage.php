<?php

declare(strict_types=1);

namespace App\Models;

final class ProductImage extends Model
{
    public function forProduct(int $productId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM product_images WHERE product_id = :product_id ORDER BY sort_order ASC, id ASC');
        $stmt->execute(['product_id' => $productId]);

        return $stmt->fetchAll();
    }

    public function add(int $productId, string $path, int $sortOrder = 0): void
    {
        $stmt = $this->db->prepare('INSERT INTO product_images (product_id, image_path, sort_order) VALUES (:product_id, :image_path, :sort_order)');
        $stmt->execute([
            'product_id' => $productId,
            'image_path' => $path,
            'sort_order' => $sortOrder,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM product_images WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
