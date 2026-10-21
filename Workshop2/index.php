<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: pages/dashboard.php');
    exit;
}

$errors = [
    'invalid_credentials' => 'Usuario o contraseña incorrectos.',
    'invalid_input' => 'Complete los datos solicitados correctamente.',
    'session_required' => 'Debe iniciar sesión para acceder a esa página.',
];
$message = $errors[$_GET['error'] ?? ''] ?? null;
$registered = isset($_GET['registered']);
$pageTitle = 'Iniciar sesión | Workshop 2';
require_once __DIR__ . '/pages/common/header.php';
?>
<main class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h1 class="h3 text-center mb-4">Iniciar sesión</h1>
          <?php if ($message): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
          <?php endif; ?>
          <?php if ($registered): ?>
            <div class="alert alert-success">Cuenta creada correctamente. Ya puede iniciar sesión.</div>
          <?php endif; ?>
          <form action="actions/login.php" method="POST">
            <div class="form-group">
              <label for="username">Usuario</label>
              <input type="text" class="form-control" id="username" name="username" maxlength="50" required autofocus>
            </div>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
          </form>
          <p class="text-center mt-3 mb-0">¿No tiene una cuenta? <a href="pages/register.php">Regístrese aquí</a>.</p>
        </div>
      </div>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/pages/common/footer.php'; ?>
