<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../utils/database.php';
start_app_session();
require_login('../index.php');

$userStatement = $conn->prepare('SELECT id, full_name, username, email, province_id FROM users WHERE id = :id LIMIT 1');
$userStatement->execute(['id' => $_SESSION['user_id']]);
$user = $userStatement->fetch();
if (!$user) {
    $_SESSION = [];
    session_destroy();
    header('Location: ../index.php?error=session_required');
    exit;
}
$provinces = $conn->query('SELECT id, name FROM provinces ORDER BY name')->fetchAll();
$errors = ['invalid_input' => 'Revise los datos ingresados.', 'username_exists' => 'El nombre de usuario ya está en uso.', 'email_exists' => 'El correo electrónico ya está registrado.', 'update_error' => 'No fue posible actualizar sus datos.'];
$message = $errors[$_GET['error'] ?? ''] ?? null;
$updated = isset($_GET['updated']);
$pageTitle = 'Mi perfil | Workshop 2';
require_once __DIR__ . '/common/header.php';
?>
<main class="container py-5"><div class="row justify-content-center"><div class="col-md-8 col-lg-7">
  <div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3 mb-0">Mi perfil</h1><a href="dashboard.php">Volver al inicio</a></div>
  <div class="card shadow-sm"><div class="card-body p-4">
    <?php if ($message): ?><div class="alert alert-danger"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <?php if ($updated): ?><div class="alert alert-success">Sus datos fueron actualizados correctamente.</div><?php endif; ?>
    <form action="../actions/update_profile.php" method="POST">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
      <div class="form-row">
        <div class="form-group col-md-6"><label for="full_name">Nombre completo</label><input type="text" class="form-control" id="full_name" name="full_name" maxlength="100" value="<?= htmlspecialchars($user['full_name'], ENT_QUOTES, 'UTF-8') ?>" required></div>
        <div class="form-group col-md-6"><label for="username">Usuario</label><input type="text" class="form-control" id="username" name="username" maxlength="50" value="<?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>" required></div>
      </div>
      <div class="form-group"><label for="email">Correo electrónico</label><input type="email" class="form-control" id="email" name="email" maxlength="120" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>" required></div>
      <div class="form-group"><label for="province_id">Provincia</label><select class="form-control" id="province_id" name="province_id" required><?php foreach ($provinces as $province): ?><option value="<?= (int) $province['id'] ?>" <?= (int) $province['id'] === (int) $user['province_id'] ? 'selected' : '' ?>><?= htmlspecialchars($province['name'], ENT_QUOTES, 'UTF-8') ?></option><?php endforeach; ?></select></div>
      <div class="form-group"><label for="password">Nueva contraseña <small class="text-muted">(opcional)</small></label><input type="password" class="form-control" id="password" name="password" minlength="8"><small class="form-text text-muted">Déjelo vacío para conservar su contraseña actual.</small></div>
      <button type="submit" class="btn btn-primary btn-block">Guardar cambios</button>
    </form>
  </div></div>
</div></div></main>
<?php require_once __DIR__ . '/common/footer.php'; ?>
