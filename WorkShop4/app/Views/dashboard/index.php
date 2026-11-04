<main class="container py-5"><div class="row justify-content-center"><div class="col-md-7"><div class="card shadow-sm"><div class="card-body p-4 text-center">
  <h1 class="h3">Panel principal</h1>
  <p class="lead">Bienvenido, <strong><?= View::e($user['username']) ?></strong>.</p>
  <a class="btn btn-primary mr-2" href="<?= $baseUrl ?>/index.php?route=profile">Mi perfil</a>
  <a class="btn btn-outline-secondary" href="<?= $baseUrl ?>/index.php?route=courses">Administrar cursos</a>
</div></div></div></div></main>
