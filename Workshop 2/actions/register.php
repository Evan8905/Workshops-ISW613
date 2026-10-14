<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../utils/database.php';
start_app_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf_token($_POST['csrf_token'] ?? null)) {
    header('Location: ../pages/register.php?error=invalid_input');
    exit;
}

$fullName = trim((string) ($_POST['full_name'] ?? ''));
$username = trim((string) ($_POST['username'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$provinceId = filter_var($_POST['province_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$password = (string) ($_POST['password'] ?? '');

if ($fullName === '' || strlen($fullName) > 100 || $username === '' || strlen($username) > 50 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 120 || !$provinceId || strlen($password) < 8) {
    header('Location: ../pages/register.php?error=invalid_input');
    exit;
}

$provinceCheck = $conn->prepare('SELECT id FROM provinces WHERE id = :id');
$provinceCheck->execute(['id' => $provinceId]);
if (!$provinceCheck->fetch()) {
    header('Location: ../pages/register.php?error=invalid_input');
    exit;
}

try {
    $statement = $conn->prepare('INSERT INTO users (full_name, username, email, password_hash, province_id) VALUES (:full_name, :username, :email, :password_hash, :province_id)');
    $statement->execute([
        'full_name' => $fullName,
        'username' => $username,
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'province_id' => $provinceId,
    ]);
} catch (PDOException $exception) {
    $duplicate = $exception->errorInfo[1] ?? null;
    if ($duplicate === 1062) {
        $field = str_contains($exception->getMessage(), 'uq_users_email') ? 'email_exists' : 'username_exists';
        header('Location: ../pages/register.php?error=' . $field);
        exit;
    }
    error_log('Registration error: ' . $exception->getMessage());
    header('Location: ../pages/register.php?error=registration_error');
    exit;
}

header('Location: ../index.php?registered=1');
exit;
