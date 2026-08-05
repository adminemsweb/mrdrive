<?php

declare(strict_types=1);

namespace App\Models;

final class User extends Model
{
    public function all(): array
    {
        return $this->db->query(
            "SELECT id, name, email, role, is_active, last_login_at, created_at
             FROM users
             ORDER BY role = 'owner' DESC, name ASC"
        )->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function createAdmin(string $name, string $email, string $password): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, password, role, is_active)
             VALUES (:name, :email, :password, 'admin', 1)"
        );
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function setActive(int $id, bool $active): void
    {
        $stmt = $this->db->prepare("UPDATE users SET is_active = :active WHERE id = :id AND role = 'admin'");
        $stmt->execute(['id' => $id, 'active' => $active ? 1 : 0]);
    }

    public function updatePassword(int $id, string $password): void
    {
        $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id AND role = 'admin'");
        $stmt->execute(['id' => $id, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
    }

    public function touchLastLogin(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE users SET last_login_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
