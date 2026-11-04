<main class="container py-5"><div class="row justify-content-center"><div class="col-md-8 col-lg-7"><div class="card shadow-sm"><div class="card-body p-4">
  <h1 class="h3 mb-4"><?= $isEditing ? 'Editar curso' : 'Crear curso' ?></h1>
  <form action="<?= $baseUrl ?>/index.php?route=course-save" method="post">
    <?php if ($isEditing): ?><input type="hidden" name="id" value="<?= (int) $course['id'] ?>"><?php endif; ?>
    <div class="form-group"><label for="name">Nombre</label><input class="form-control" id="name" name="name" maxlength="100" value="<?= View::e($course['name']) ?>" required></div>
    <div class="form-group"><label for="course_code">Código de curso</label><input class="form-control" id="course_code" name="course_code" maxlength="20" value="<?= View::e($course['course_code']) ?>" required></div>
    <div class="form-group"><label for="career_id">ID de la carrera</label><input class="form-control" id="career_id" name="career_id" type="number" min="1" value="<?= View::e($course['career_id']) ?>" required></div>
    <div class="form-group"><label for="credits">Créditos</label><input class="form-control" id="credits" name="credits" type="number" min="1" value="<?= View::e($course['credits']) ?>" required></div>
    <div class="form-group"><label for="description">Descripción</label><textarea class="form-control" id="description" name="description" rows="4" required><?= View::e($course['description']) ?></textarea></div>
    <button class="btn btn-primary" type="submit"><?= $isEditing ? 'Guardar cambios' : 'Crear curso' ?></button><a class="btn btn-secondary" href="<?= $baseUrl ?>/index.php?route=courses">Cancelar</a>
  </form>
</div></div></div></div></main>
