<?= $this->extend('base') ?>
<?= $this->section('contenido') ?>
<h1>Matrícula de estudiantes</h1>

<?php if ($errores !== []): ?>
    <ul role="alert">
    <?php foreach ($errores as $error): ?>
        <li><?= esc($error) ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($cursos === []): ?>
    <p>No hay cursos disponibles para matricular.</p>
<?php else: ?>
    <form method="post" action="<?= esc(site_url('matriculas'), 'attr') ?>">
        <?= csrf_field() ?>

        <label for="carne">Carné del estudiante</label>
        <input id="carne" name="carne" maxlength="30" required
               value="<?= esc($datos['carne'] ?? '', 'attr') ?>">

        <label for="curso_id">Curso</label>
        <select id="curso_id" name="curso_id" required>
            <option value="">Selecciona un curso</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= esc($curso['id']) ?>" <?= (string) ($datos['curso_id'] ?? '') === (string) $curso['id'] ? 'selected' : '' ?>>
                    <?= esc($curso['codigo'] . ' — ' . $curso['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <p><button type="submit">Matricular</button></p>
    </form>
<?php endif; ?>
<?= $this->endSection() ?>
