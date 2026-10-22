<?php
require_once __DIR__ . '/../utils/auth.php';
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';

// Esta acción solo recibe la información que manda el formulario.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /courses.php');
    exit;
}

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;
$courseCode = $_POST['course_code'] ?? null;
$careerId = $_POST['career_id'] ?? null;
$credits = $_POST['credits'] ?? null;
$description = $_POST['description'] ?? null;

if (
    !is_string($name)
    || !is_string($courseCode)
    || !is_string($careerId)
    || !is_string($credits)
    || !is_string($description)
    || trim($name) === ''
    || strlen(trim($name)) > 100
    || trim($courseCode) === ''
    || strlen(trim($courseCode)) > 20
    || !ctype_digit($careerId)
    || (int) $careerId < 1
    || !ctype_digit($credits)
    || (int) $credits < 1
    || (isset($_POST['id']) && (!is_string($id) || !ctype_digit($id) || (int) $id < 1))
) {
    header('Location: /courses.php?error=invalid_input');
    exit;
}

$course = [
    'name' => trim($name),
    'course_code' => trim($courseCode),
    'career_id' => (int) $careerId,
    'credits' => (int) $credits,
    'description' => trim($description),
];

try {
    if ($id !== null) {
        // Revisamos que el curso exista antes de intentar editarlo.
        if (getCourse($conn, (int) $id) === false) {
            header('Location: /courses.php?error=course_not_found');
            exit;
        }
        saveCourse($conn, $course, (int) $id);
    } else {
        saveCourse($conn, $course);
    }
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {
        header('Location: /courses.php?error=course_code_taken');
        exit;
    }

    error_log('Error al guardar el curso: ' . $exception->getMessage());
    header('Location: /courses.php?error=server_error');
    exit;
}

header('Location: /courses.php?success=course_saved');
exit;
