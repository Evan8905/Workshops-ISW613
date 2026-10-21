<?php
require_once __DIR__ . '/../utils/database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/profile.php?error=invalid_input');
    exit;
}

$fullName = trim($_POST['full_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$provinceId = $_POST['province_id'] ?? '';
$password = $_POST['password'] ?? '';
if ($fullName === '' || $username === '' || $email === '' || $provinceId === '' || ($password !== '' && strlen($password) < 8)) {
    header('Location: ../pages/profile.php?error=invalid_input');
    exit;
}

$userCheck = $conn->prepare('SELECT id FROM users WHERE (username = :username OR email = :email) AND id != :id');
$userCheck->execute(['username' => $username, 'email' => $email, 'id' => $_SESSION['user_id']]);

if ($userCheck->fetch()) {
    header('Location: ../pages/profile.php?error=user_exists');
    exit;
}

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

header('Location: ../pages/profile.php?updated=1');
exit;
