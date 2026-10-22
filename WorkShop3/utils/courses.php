<?php

function getCourses(PDO $conn)
{
    // Traemos los cursos ordenados por nombre para mostrarlos en la tabla.
    return $conn->query(
        'SELECT id, name, course_code, career_id, credits, description
         FROM courses
         ORDER BY name'
    )->fetchAll(PDO::FETCH_ASSOC);
}

function getCourse(PDO $conn, int $id)
{
    $statement = $conn->prepare(
        'SELECT id, name, course_code, career_id, credits, description
         FROM courses
         WHERE id = :id
         LIMIT 1'
    );
    $statement->execute(['id' => $id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function saveCourse(PDO $conn, array $course, $id = null)
{
    if ($id === null) {
        // Si no llega un id, el curso es nuevo.
        $statement = $conn->prepare(
            'INSERT INTO courses (name, course_code, career_id, credits, description)
             VALUES (:name, :course_code, :career_id, :credits, :description)'
        );
    } else {
        // Si llega un id, usamos los mismos datos para actualizar ese curso.
        $statement = $conn->prepare(
            'UPDATE courses
             SET name = :name, course_code = :course_code, career_id = :career_id,
                 credits = :credits, description = :description
             WHERE id = :id'
        );
        $course['id'] = $id;
    }

    $statement->execute($course);
}

function deleteCourse(PDO $conn, int $id)
{
    $statement = $conn->prepare('DELETE FROM courses WHERE id = :id');
    $statement->execute(['id' => $id]);
    return $statement->rowCount() > 0;
}
