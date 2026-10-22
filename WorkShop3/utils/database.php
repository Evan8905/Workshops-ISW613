<?php

$dsn = 'mysql:host=127.0.0.1;dbname=workshop3;charset=utf8mb4';
$dbUser = 'root';
// En esta instalación de XAMPP el usuario root no tiene contraseña.
$dbPassword = '';

try {
    $conn = new PDO($dsn, $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $exception) {
    // Log the details instead of showing them: an uncaught error would print the credentials in the stack trace
    error_log('Database connection error: ' . $exception->getMessage());
    http_response_code(500);
    exit('The service is temporarily unavailable. Please try again later.');
}
