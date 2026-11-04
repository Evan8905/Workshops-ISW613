<?php

use App\Services\Session;
use App\Services\View;

$currentUser = Session::user();
$baseUrl = Session::baseUrl();
$messages = [
    'error' => [
        'invalid_input' => 'Complete correctamente todos los campos requeridos.',
        'invalid_credentials' => 'El usuario o la contraseña son incorrectos.',
        'login_required' => 'Debe iniciar sesión para acceder a esa página.',
        'session_expired' => 'Su sesión expiró. Inicie sesión nuevamente.',
        'password_too_short' => 'La contraseña debe tener al menos 8 caracteres.',
        'password_mismatch' => 'Las contraseñas no coinciden.',
        'invalid_province' => 'Seleccione una provincia válida.',
        'username_taken' => 'Ese nombre de usuario ya está en uso.',
        'wrong_password' => 'La contraseña actual es incorrecta.',
        'invalid_picture' => 'La imagen debe ser JPG, PNG, GIF o WEBP.',
        'picture_too_large' => 'La imagen no puede superar 2 MB.',
        'upload_failed' => 'No fue posible subir la imagen.',
        'course_not_found' => 'No se encontró el curso solicitado.',
        'course_code_taken' => 'Ese código de curso ya está registrado.',
        'server_error' => 'Ocurrió un error. Intente nuevamente más tarde.',
    ],
    'success' => [
        'registered' => 'Su cuenta fue creada. Ya puede iniciar sesión.',
        'logged_out' => 'La sesión se cerró correctamente.',
        'updated' => 'Su perfil fue actualizado.',
        'course_saved' => 'El curso se guardó correctamente.',
        'course_deleted' => 'El curso se eliminó correctamente.',
    ],
];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Workshop 4 · MVC</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<?php if ($currentUser !== null): ?>
  <nav class="navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="<?= $baseUrl ?>/index.php?route=dashboard">Workshop 4</a>
    <div class="navbar-nav mr-auto">
      <a class="nav-item nav-link" href="<?= $baseUrl ?>/index.php?route=dashboard">Inicio</a>
      <a class="nav-item nav-link" href="<?= $baseUrl ?>/index.php?route=courses">Cursos</a>
      <a class="nav-item nav-link" href="<?= $baseUrl ?>/index.php?route=users">Usuarios</a>
      <a class="nav-item nav-link" href="<?= $baseUrl ?>/index.php?route=profile">Perfil</a>
    </div>
    <form action="<?= $baseUrl ?>/index.php?route=logout" method="post" class="form-inline">
      <button class="btn btn-outline-light btn-sm" type="submit">Cerrar sesión</button>
    </form>
  </nav>
<?php endif; ?>
<?php foreach (['error' => 'danger', 'success' => 'success'] as $type => $style): ?>
  <?php $code = $_GET[$type] ?? null; ?>
  <?php if (is_string($code) && isset($messages[$type][$code])): ?>
    <div class="container mt-3"><div class="alert alert-<?= $style ?>" role="alert"><?= View::e($messages[$type][$code]) ?></div></div>
  <?php endif; ?>
<?php endforeach; ?>
