<?php
require_once __DIR__ . '/../utils/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?error=invalid_input');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
if ($username === '' || $password === '') {
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

$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['username'] = $user['username'];
header('Location: ../pages/dashboard.php');
exit;
