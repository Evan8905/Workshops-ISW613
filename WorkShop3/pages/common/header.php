<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<?php if (isset($_SESSION['user_id'])): ?>
  <nav class="navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="/workshop3/pages/dashboard.php">Workshop 3</a>
    <div class="navbar-nav mr-auto">
      <a class="nav-item nav-link" href="/workshop3/pages/dashboard.php">Inicio</a>
      <a class="nav-item nav-link" href="/workshop3/courses.php">Cursos</a>
      <a class="nav-item nav-link" href="/workshop3/pages/profile.php">Perfil</a>
    </div>
    <form action="/workshop3/actions/logout.php" method="POST" class="form-inline">
      <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
    </form>
  </nav>
<?php endif; ?>
