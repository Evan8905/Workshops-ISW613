<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/auth.php';
start_app_session();
require_login('../index.php');
$pageTitle = 'Inicio | Workshop 2';
require_once __DIR__ . '/common/header.php';
?>
<main class="container py-5">
  <div class="row justify-content-center"><div class="col-md-7">
    <div class="card shadow-sm"><div class="card-body p-4 text-center">
      <h1 class="h3">Bienvenido, <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></h1>
      <p class="text-muted">Su sesión está activa.</p>
      <a class="btn btn-primary mr-2" href="profile.php">Ver y actualizar mi perfil</a>
      <form action="../actions/logout.php" method="POST" class="d-inline">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit" class="btn btn-outline-danger">Cerrar sesión</button>
      </form>
    </div></div>
  </div></div>
</main>
<?php require_once __DIR__ . '/common/footer.php'; ?>
