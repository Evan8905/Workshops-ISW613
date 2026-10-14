<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../utils/database.php';
start_app_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf_token($_POST['csrf_token'] ?? null)) {
    header('Location: ../index.php?error=invalid_input');
    exit;
}

$username = trim((string) ($_POST['username'] ?? ''));
$password = (string) ($_POST['password'] ?? '');
if ($username === '' || strlen($username) > 50 || $password === '') {
    header('Location: ../index.php?error=invalid_input');
    exit;
}

$statement = $conn->prepare('SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1');
$statement->execute(['username' => $username]);
$user = $statement->fetch();

if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location: ../index.php?error=invalid_credentials');
    exit;
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['username'] = $user['username'];
header('Location: ../pages/dashboard.php');
exit;
