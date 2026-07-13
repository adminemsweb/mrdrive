<?php

declare(strict_types=1);

namespace App\Models;

final class Product extends Model
{
    public function active(bool $featuredOnly = false): array
    {
        $sql = 'SELECT * FROM products WHERE is_active = 1';
        if ($featuredOnly) {
            $sql .= ' AND is_featured = 1';
        }
        $sql .= ' ORDER BY sort_order ASC, name ASC';

        return $this->db->query($sql)->fetchAll();
    }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM products ORDER BY sort_order ASC, id DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

        return $product ?: null;
    }

    public function findActive(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = :id AND is_active = 1 LIMIT 1');
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

        return $product ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO products
            (name, model_code, category, short_description, full_description, power, voltage, recommended_applications, technical_specs, main_image, manual_pdf, is_active, is_featured, sort_order)
            VALUES
            (:name, :model_code, :category, :short_description, :full_description, :power, :voltage, :recommended_applications, :technical_specs, :main_image, :manual_pdf, :is_active, :is_featured, :sort_order)'
        );
        $stmt->execute($data);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare(
            'UPDATE products SET
            name = :name,
            model_code = :model_code,
            category = :category,
            short_description = :short_description,
            full_description = :full_description,
            power = :power,
            voltage = :voltage,
            recommended_applications = :recommended_applications,
            technical_specs = :technical_specs,
            main_image = :main_image,
            manual_pdf = :manual_pdf,
            is_active = :is_active,
            is_featured = :is_featured,
            sort_order = :sort_order
            WHERE id = :id'
        );
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function stats(): array
    {
        $row = $this->db->query(
            'SELECT COUNT(*) total, SUM(is_active = 1) active, SUM(is_active = 0) inactive FROM products'
        )->fetch();

        return [
            'total' => (int) ($row['total'] ?? 0),
            'active' => (int) ($row['active'] ?? 0),
            'inactive' => (int) ($row['inactive'] ?? 0),
        ];
    }
}
