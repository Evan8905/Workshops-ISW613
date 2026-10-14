<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../utils/database.php';
start_app_session();
require_login('../index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf_token($_POST['csrf_token'] ?? null)) {
    header('Location: ../pages/profile.php?error=invalid_input');
    exit;
}

$fullName = trim((string) ($_POST['full_name'] ?? ''));
$username = trim((string) ($_POST['username'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$provinceId = filter_var($_POST['province_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$password = (string) ($_POST['password'] ?? '');
if ($fullName === '' || strlen($fullName) > 100 || $username === '' || strlen($username) > 50 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 120 || !$provinceId || ($password !== '' && strlen($password) < 8)) {
    header('Location: ../pages/profile.php?error=invalid_input');
    exit;
}

$provinceCheck = $conn->prepare('SELECT id FROM provinces WHERE id = :id');
$provinceCheck->execute(['id' => $provinceId]);
if (!$provinceCheck->fetch()) {
    header('Location: ../pages/profile.php?error=invalid_input');
    exit;
}

try {
    $params = ['full_name' => $fullName, 'username' => $username, 'email' => $email, 'province_id' => $provinceId, 'id' => $_SESSION['user_id']];
    $sql = 'UPDATE users SET full_name = :full_name, username = :username, email = :email, province_id = :province_id';
    if ($password !== '') {
        $sql .= ', password_hash = :password_hash';
        $params['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
    }
    $sql .= ' WHERE id = :id';
    $statement = $conn->prepare($sql);
    $statement->execute($params);
    $_SESSION['username'] = $username;
} catch (PDOException $exception) {
    if (($exception->errorInfo[1] ?? null) === 1062) {
        $field = str_contains($exception->getMessage(), 'uq_users_email') ? 'email_exists' : 'username_exists';
        header('Location: ../pages/profile.php?error=' . $field);
        exit;
    }
    error_log('Profile update error: ' . $exception->getMessage());
    header('Location: ../pages/profile.php?error=update_error');
    exit;
}

header('Location: ../pages/profile.php?updated=1');
exit;
