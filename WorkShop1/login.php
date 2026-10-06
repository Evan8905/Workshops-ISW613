<?php

$conn = new mysqli("localhost", "root", "", "workshop1");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    header("Location: usuario_existe.php");
    exit();
} else {
    header("Location: index.php?error=1");
    exit();
}

?>