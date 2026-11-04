<main class="container py-5">
  <h1 class="h2">Usuarios</h1><p class="text-muted">Usuarios registrados en el sistema.</p>
  <div class="table-responsive"><table class="table table-striped table-bordered"><thead class="thead-light"><tr><th>ID</th><th>Usuario</th><th>Provincia</th><th>Creado</th></tr></thead><tbody>
  <?php foreach ($users as $registeredUser): ?><tr><td><?= (int) $registeredUser['id'] ?></td><td><?= View::e($registeredUser['username']) ?></td><td><?= View::e($registeredUser['province_name'] ?? 'Sin asignar') ?></td><td><?= View::e($registeredUser['created_at']) ?></td></tr><?php endforeach; ?>
  </tbody></table></div>
</main>
