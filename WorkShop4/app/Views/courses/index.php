<main class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="h2 mb-1">Cursos</h1><p class="text-muted mb-0">Cursos registrados en el sistema.</p></div><a class="btn btn-primary" href="<?= $baseUrl ?>/index.php?route=course-create">Crear curso</a></div>
  <div class="table-responsive"><table class="table table-bordered table-striped"><thead class="thead-light"><tr><th>Nombre</th><th>Código</th><th>ID carrera</th><th>Créditos</th><th>Descripción</th><th>Acciones</th></tr></thead><tbody>
  <?php if ($courses === []): ?><tr><td class="text-center" colspan="6">Todavía no hay cursos registrados.</td></tr><?php endif; ?>
  <?php foreach ($courses as $course): ?><tr><td><?= View::e($course['name']) ?></td><td><?= View::e($course['course_code']) ?></td><td><?= (int) $course['career_id'] ?></td><td><?= (int) $course['credits'] ?></td><td><?= View::e($course['description']) ?></td><td class="text-nowrap"><a class="btn btn-sm btn-secondary" href="<?= $baseUrl ?>/index.php?route=course-edit&amp;id=<?= (int) $course['id'] ?>">Editar</a> <form class="d-inline" action="<?= $baseUrl ?>/index.php?route=course-delete" method="post"><input type="hidden" name="id" value="<?= (int) $course['id'] ?>"><button class="btn btn-sm btn-danger" type="submit">Eliminar</button></form></td></tr><?php endforeach; ?>
  </tbody></table></div>
</main>
