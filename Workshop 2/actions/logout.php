<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/auth.php';
start_app_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf_token($_POST['csrf_token'] ?? null)) {
    $_SESSION = [];
    session_destroy();
}

header('Location: ../index.php');
exit;
