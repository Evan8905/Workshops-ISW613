<?php
require_once __DIR__ . '/../utils/auth.php';
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';
require_once __DIR__ . '/../utils/messages.php';

$course = [
    'name' => '',
    'course_code' => '',
    'career_id' => '',
    'credits' => '',
    'description' => '',
];
$isEditing = isset($_GET['id']);

if ($isEditing) {
    $id = $_GET['id'];
    if (!is_string($id) || !ctype_digit($id) || (int) $id < 1) {
        header('Location: /courses.php?error=course_not_found');
        exit;
    }

    $course = getCourse($conn, (int) $id);
    if ($course === false) {
        header('Location: /courses.php?error=course_not_found');
        exit;
    }
}
?>
<?php require_once __DIR__ . '/common/header.php'; ?>
<main class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h1 class="h3 mb-4"><?php echo $isEditing ? 'Editar curso' : 'Crear curso'; ?></h1>
          <?php renderAlert(); ?>
          <form action="/actions/save_course.php" method="POST">
            <?php if ($isEditing): ?>
              <input type="hidden" name="id" value="<?php echo (int) $course['id']; ?>">
            <?php endif; ?>
            <div class="form-group">
              <label for="name">Nombre</label>
              <input type="text" class="form-control" id="name" name="name" maxlength="100" value="<?php echo htmlspecialchars($course['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
              <label for="course_code">Código de curso</label>
              <input type="text" class="form-control" id="course_code" name="course_code" maxlength="20" value="<?php echo htmlspecialchars($course['course_code'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
              <label for="career_id">Id de la carrera</label>
              <input type="number" class="form-control" id="career_id" name="career_id" min="1" value="<?php echo htmlspecialchars((string) $course['career_id'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
              <label for="credits">Créditos</label>
              <input type="number" class="form-control" id="credits" name="credits" min="1" value="<?php echo htmlspecialchars((string) $course['credits'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
              <label for="description">Descripción</label>
              <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($course['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $isEditing ? 'Guardar cambios' : 'Crear curso'; ?></button>
            <a href="/courses.php" class="btn btn-secondary">Cancelar</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/common/footer.php'; ?>
