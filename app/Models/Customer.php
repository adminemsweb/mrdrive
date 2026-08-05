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

    public function create(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        array $profile,
        string $verificationTokenHash,
        string $verificationExpiresAt
    ): array
    {
        $firstName = trim($firstName);
        $lastName = trim($lastName);
        $fullName = trim($firstName . ' ' . $lastName);
        $stmt = $this->db->prepare(
            'INSERT INTO customers (
                first_name, last_name, name, email, password,
                email_verification_token, email_verification_expires_at,
                birth_date, phone, postal_code, street, address_number,
                complement, district, city, state
             ) VALUES (
                :first_name, :last_name, :name, :email, :password,
                :email_verification_token, :email_verification_expires_at,
                :birth_date, :phone, :postal_code, :street, :address_number,
                :complement, :district, :city, :state
             )'
        );
        $stmt->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => $fullName,
            'email' => mb_strtolower(trim($email)),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email_verification_token' => $verificationTokenHash,
            'email_verification_expires_at' => $verificationExpiresAt,
            ...$profile,
        ]);

        return [
            'id' => (int) $this->db->lastInsertId(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => $fullName,
            'email' => mb_strtolower(trim($email)),
            'email_verified_at' => null,
            ...$profile,
        ];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM customers WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $customer = $stmt->fetch();

        return $customer ?: null;
    }

    public function verifyEmailToken(string $tokenHash): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM customers
             WHERE email_verification_token = :token
               AND email_verification_expires_at >= NOW()
             LIMIT 1'
        );
        $stmt->execute(['token' => $tokenHash]);
        $customer = $stmt->fetch();
        if (!$customer) {
            return null;
        }

        $update = $this->db->prepare(
            'UPDATE customers
             SET email_verified_at = NOW(),
                 email_verification_token = NULL,
                 email_verification_expires_at = NULL
             WHERE id = :id'
        );
        $update->execute(['id' => (int) $customer['id']]);

        return $this->find((int) $customer['id']);
    }

    public function setVerificationToken(int $id, string $tokenHash, string $expiresAt): void
    {
        $stmt = $this->db->prepare(
            'UPDATE customers
             SET email_verified_at = NULL,
                 email_verification_token = :token,
                 email_verification_expires_at = :expires_at
             WHERE id = :id'
        );
        $stmt->execute(['id' => $id, 'token' => $tokenHash, 'expires_at' => $expiresAt]);
    }

    public function updateProfile(int $id, string $firstName, string $lastName, string $email, array $profile): array
    {
        $fullName = trim($firstName . ' ' . $lastName);
        $stmt = $this->db->prepare(
            'UPDATE customers
             SET first_name = :first_name,
                 last_name = :last_name,
                 name = :name,
                 email = :email,
                 birth_date = :birth_date,
                 phone = :phone,
                 postal_code = :postal_code,
                 street = :street,
                 address_number = :address_number,
                 complement = :complement,
                 district = :district,
                 city = :city,
                 state = :state
             WHERE id = :id'
        );
        $stmt->execute([
            'id' => $id,
            'first_name' => trim($firstName),
            'last_name' => trim($lastName),
            'name' => $fullName,
            'email' => mb_strtolower(trim($email)),
            ...$profile,
        ]);

        return $this->find($id) ?? throw new \RuntimeException('Conta não encontrada.');
    }

    public function updatePassword(int $id, string $password): void
    {
        $stmt = $this->db->prepare('UPDATE customers SET password = :password WHERE id = :id');
        $stmt->execute(['id' => $id, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
    }
}
