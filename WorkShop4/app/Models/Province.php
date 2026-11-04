<?php

namespace App\Models;

use App\Config\Database;
use PDO;

final class Province
{
    public static function all(): array
    {
        return Database::connection()->query('SELECT id, name FROM provinces ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): array|false
    {
        $statement = Database::connection()->prepare('SELECT id, name FROM provinces WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
