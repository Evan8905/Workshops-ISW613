<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

    <h2>Iniciar sesión</h2>

    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>Credenciales inválidas</p>";
    }
    ?>

    <form action="login.php" method="POST">
        <label>Usuario:</label>
        <input type="text" name="username" required>

        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <br><br>

        <button type="submit">Ingresar</button>
    </form>

</body>
</html>