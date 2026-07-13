<?php

declare(strict_types=1);

namespace App\Models;

final class QuoteRequest extends Model
{
    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO quote_requests
            (name, company, email, phone, product_interest, application, message, ip_address, user_agent)
            VALUES
            (:name, :company, :email, :phone, :product_interest, :application, :message, :ip_address, :user_agent)'
        );
        $stmt->execute($data);

        return (int) $this->db->lastInsertId();
    }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM quote_requests ORDER BY created_at DESC')->fetchAll();
    }

    public function unreadCount(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM quote_requests WHERE is_read = 0')->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM quote_requests WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $quote = $stmt->fetch();

        return $quote ?: null;
    }

    public function toggleRead(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE quote_requests SET is_read = 1 - is_read WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM quote_requests WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM quote_requests')->fetchColumn();
    }
}
