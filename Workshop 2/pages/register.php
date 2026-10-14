<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../utils/database.php';
start_app_session();

if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$statement = $conn->query('SELECT id, name FROM provinces ORDER BY name');
$provinces = $statement->fetchAll();
$errors = [
    'invalid_input' => 'Revise los datos ingresados.',
    'username_exists' => 'El nombre de usuario ya está en uso.',
    'email_exists' => 'El correo electrónico ya está registrado.',
    'registration_error' => 'No fue posible registrar el usuario. Intente de nuevo.',
];
$message = $errors[$_GET['error'] ?? ''] ?? null;
$pageTitle = 'Registro de usuario | Workshop 2';
require_once __DIR__ . '/common/header.php';
?>
<main class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h1 class="h3 text-center mb-4">Registro de usuario</h1>
          <?php if ($message): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
          <?php endif; ?>
          <form action="../actions/register.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
            <div class="form-row">
              <div class="form-group col-md-6"><label for="full_name">Nombre completo</label><input type="text" class="form-control" id="full_name" name="full_name" maxlength="100" required></div>
              <div class="form-group col-md-6"><label for="username">Usuario</label><input type="text" class="form-control" id="username" name="username" maxlength="50" required></div>
            </div>
            <div class="form-group"><label for="email">Correo electrónico</label><input type="email" class="form-control" id="email" name="email" maxlength="120" required></div>
            <div class="form-group">
              <label for="province_id">Provincia</label>
              <select class="form-control" id="province_id" name="province_id" required>
                <option value="">Seleccione una provincia</option>
                <?php foreach ($provinces as $province): ?>
                  <option value="<?= (int) $province['id'] ?>"><?= htmlspecialchars($province['name'], ENT_QUOTES, 'UTF-8') ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group"><label for="password">Contraseña</label><input type="password" class="form-control" id="password" name="password" minlength="8" required><small class="form-text text-muted">Mínimo 8 caracteres.</small></div>
            <button type="submit" class="btn btn-success btn-block">Crear cuenta</button>
          </form>
          <p class="text-center mt-3 mb-0"><a href="../index.php">Volver al inicio de sesión</a></p>
        </div>
      </div>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/common/footer.php'; ?>
