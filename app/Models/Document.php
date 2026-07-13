<?php

declare(strict_types=1);

namespace App\Models;

final class Document extends Model
{
    public function active(): array
    {
        return $this->db->query('SELECT * FROM documents WHERE is_active = 1 ORDER BY created_at DESC')->fetchAll();
    }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM documents ORDER BY created_at DESC')->fetchAll();
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO documents (name, type, file_path, is_active) VALUES (:name, :type, :file_path, :is_active)'
        );
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM documents WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function toggle(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE documents SET is_active = 1 - is_active WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
