<?php
require_once __DIR__ . '/../utils/auth.php';
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';

// Eliminar siempre se hace por POST desde el botón de la tabla.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /courses.php');
    exit;
}

$id = $_POST['id'] ?? null;
if (!is_string($id) || !ctype_digit($id) || (int) $id < 1) {
    header('Location: /courses.php?error=invalid_input');
    exit;
}

try {
    if (!deleteCourse($conn, (int) $id)) {
        header('Location: /courses.php?error=course_not_found');
        exit;
    }
} catch (PDOException $exception) {
    error_log('Error al eliminar el curso: ' . $exception->getMessage());
    header('Location: /courses.php?error=server_error');
    exit;
}

header('Location: /courses.php?success=course_deleted');
exit;
