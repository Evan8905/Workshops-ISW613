<?php

$dsn = 'mysql:host=localhost;dbname=isw613_workshop2;charset=utf8mb4';
$dbUser = 'root';
$dbPassword = '';

$conn = new PDO($dsn, $dbUser, $dbPassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
