<?php

declare(strict_types=1);

/*
 * Configure these values for the local MySQL installation if the defaults do
 * not apply. Environment variables make it possible to avoid committing
 * credentials in a real deployment.
 */
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'isw613_workshop2';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPassword = getenv('DB_PASSWORD') ?: '';

$dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";

try {
    $conn = new PDO($dsn, $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $exception) {
    error_log('Database connection error: ' . $exception->getMessage());
    http_response_code(500);
    exit('No fue posible conectar con la base de datos. Revise la configuración en utils/database.php.');
}
