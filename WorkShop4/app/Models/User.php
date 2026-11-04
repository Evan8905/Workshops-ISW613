<?php

namespace App\Models;

use App\Config\Database;
use PDO;

final class User
{
    public static function authenticate(string $username): array|false
    {
        $statement = Database::connection()->prepare(
            'SELECT u.id, u.username, u.password_hash, u.province_id, u.profile_picture, p.name AS province_name
             FROM users u LEFT JOIN provinces p ON p.id = u.province_id WHERE u.username = :username LIMIT 1'
        );
        $statement->execute(['username' => $username]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function create(string $username, string $password, int $provinceId): void
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO users (username, password_hash, province_id) VALUES (:username, :password_hash, :province_id)'
        );
        $statement->execute(['username' => $username, 'password_hash' => password_hash($password, PASSWORD_DEFAULT), 'province_id' => $provinceId]);
    }

    public static function all(): array
    {
        return Database::connection()->query(
            'SELECT u.id, u.username, p.name AS province_name, u.created_at FROM users u LEFT JOIN provinces p ON p.id = u.province_id ORDER BY u.id'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function passwordHash(int $id): string|false
    {
        $statement = Database::connection()->prepare('SELECT password_hash FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        return $statement->fetchColumn();
    }

    public static function profilePicture(int $id): string|false
    {
        $statement = Database::connection()->prepare('SELECT profile_picture FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        return $statement->fetchColumn();
    }

    public static function update(int $id, string $username, int $provinceId, ?string $passwordHash, ?string $picture): void
    {
        $fields = ['username' => $username, 'province_id' => $provinceId, 'id' => $id];
        $sql = 'UPDATE users SET username = :username, province_id = :province_id';
        if ($passwordHash !== null) {
            $sql .= ', password_hash = :password_hash';
            $fields['password_hash'] = $passwordHash;
        }
        if ($picture !== null) {
            $sql .= ', profile_picture = :profile_picture';
            $fields['profile_picture'] = $picture;
        }
        Database::connection()->prepare($sql . ' WHERE id = :id')->execute($fields);
    }
}
