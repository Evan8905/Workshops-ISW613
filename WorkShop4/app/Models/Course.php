<?php

namespace App\Models;

use App\Config\Database;
use PDO;

final class Course
{
    public static function all(): array
    {
        return Database::connection()->query('SELECT id, name, course_code, career_id, credits, description FROM courses ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): array|false
    {
        $statement = Database::connection()->prepare('SELECT id, name, course_code, career_id, credits, description FROM courses WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function save(array $course, ?int $id = null): void
    {
        if ($id === null) {
            $sql = 'INSERT INTO courses (name, course_code, career_id, credits, description) VALUES (:name, :course_code, :career_id, :credits, :description)';
        } else {
            $sql = 'UPDATE courses SET name = :name, course_code = :course_code, career_id = :career_id, credits = :credits, description = :description WHERE id = :id';
            $course['id'] = $id;
        }
        Database::connection()->prepare($sql)->execute($course);
    }

    public static function delete(int $id): bool
    {
        $statement = Database::connection()->prepare('DELETE FROM courses WHERE id = :id');
        $statement->execute(['id' => $id]);
        return $statement->rowCount() > 0;
    }
}
