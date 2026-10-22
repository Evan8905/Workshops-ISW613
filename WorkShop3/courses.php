<?php
require_once __DIR__ . '/utils/auth.php';
requireLogin();

require_once __DIR__ . '/utils/database.php';
require_once __DIR__ . '/utils/courses.php';
require_once __DIR__ . '/utils/messages.php';

$courses = getCourses($conn);
?>
<?php require_once __DIR__ . '/pages/common/header.php'; ?>
<main class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h2 mb-1">Cursos</h1>
      <p class="text-muted mb-0">Cursos registrados en el sistema.</p>
    </div>
    <a href="/workshop3/pages/course_form.php" class="btn btn-primary">Crear curso</a>
  </div>
  <?php renderAlert(); ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="thead-light">
        <tr>
          <th>Nombre</th>
          <th>Código de curso</th>
          <th>Id de la carrera</th>
          <th>Créditos</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($courses) === 0): ?>
          <tr><td colspan="6" class="text-center">Todavía no hay cursos registrados.</td></tr>
        <?php endif; ?>
        <?php foreach ($courses as $course): ?>
          <tr>
            <td><?php echo htmlspecialchars($course['name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($course['course_code'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo (int) $course['career_id']; ?></td>
            <td><?php echo (int) $course['credits']; ?></td>
            <td><?php echo htmlspecialchars($course['description'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="text-nowrap">
              <a href="/workshop3/pages/course_form.php?id=<?php echo (int) $course['id']; ?>" class="btn btn-sm btn-secondary">Editar</a>
              <form action="/workshop3/actions/delete_course.php" method="POST" class="d-inline">
                <input type="hidden" name="id" value="<?php echo (int) $course['id']; ?>">
                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php require_once __DIR__ . '/pages/common/footer.php'; ?>
