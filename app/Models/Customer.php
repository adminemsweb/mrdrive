<?php

declare(strict_types=1);

namespace App\Models;

final class Customer extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM customers WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => mb_strtolower(trim($email))]);
        $customer = $stmt->fetch();

        return $customer ?: null;
    }

    public function create(string $firstName, string $lastName, string $email, string $password): array
    {
        $firstName = trim($firstName);
        $lastName = trim($lastName);
        $fullName = trim($firstName . ' ' . $lastName);
        $stmt = $this->db->prepare(
            'INSERT INTO customers (first_name, last_name, name, email, password)
             VALUES (:first_name, :last_name, :name, :email, :password)'
        );
        $stmt->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => $fullName,
            'email' => mb_strtolower(trim($email)),
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return [
            'id' => (int) $this->db->lastInsertId(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => $fullName,
            'email' => mb_strtolower(trim($email)),
        ];
    }
}
