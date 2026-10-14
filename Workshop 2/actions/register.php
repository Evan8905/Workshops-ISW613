<?php
require_once __DIR__ . '/../utils/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/register.php?error=invalid_input');
    exit;
}

$fullName = trim($_POST['full_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$provinceId = $_POST['province_id'] ?? '';
$password = $_POST['password'] ?? '';

if ($fullName === '' || $username === '' || $email === '' || $provinceId === '' || strlen($password) < 8) {
    header('Location: ../pages/register.php?error=invalid_input');
    exit;
}

$userCheck = $conn->prepare('SELECT id FROM users WHERE username = :username OR email = :email');
$userCheck->execute(['username' => $username, 'email' => $email]);

if ($userCheck->fetch()) {
    header('Location: ../pages/register.php?error=user_exists');
    exit;
}

$statement = $conn->prepare('INSERT INTO users (full_name, username, email, password_hash, province_id) VALUES (:full_name, :username, :email, :password_hash, :province_id)');
$statement->execute([
    'full_name' => $fullName,
    'username' => $username,
    'email' => $email,
    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    'province_id' => $provinceId,
]);

header('Location: ../index.php?registered=1');
exit;
