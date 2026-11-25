<?= $this->extend('base') ?>
<?= $this->section('contenido') ?>
<?php
$editando = isset($curso['id']);
$accion = $editando ? 'cursos/' . $curso['id'] : 'cursos';
?>
<h1><?= $editando ? 'Editar curso' : 'Crear curso' ?></h1>

<?php if ($errores !== []): ?>
    <ul role="alert">
    <?php foreach ($errores as $error): ?>
        <li><?= esc($error) ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="<?= esc(site_url($accion), 'attr') ?>">
    <?= csrf_field() ?>

    <label for="nombre">Nombre del curso</label>
    <input id="nombre" name="nombre" required maxlength="100" value="<?= esc($curso['nombre'] ?? '', 'attr') ?>">

    <label for="codigo">Código del curso</label>
    <input id="codigo" name="codigo" required maxlength="20" value="<?= esc($curso['codigo'] ?? '', 'attr') ?>">

    <label for="creditos">Cantidad de créditos</label>
    <input id="creditos" type="number" name="creditos" required min="0" max="4294967295"
           value="<?= esc((string) ($curso['creditos'] ?? ''), 'attr') ?>">

    <label for="carrera_id">Carrera</label>
    <select id="carrera_id" name="carrera_id" required>
        <option value="">Selecciona una carrera</option>
        <?php foreach ($carreras as $carrera): ?>
            <option value="<?= esc($carrera['id']) ?>" <?= (string) ($curso['carrera_id'] ?? '') === (string) $carrera['id'] ? 'selected' : '' ?>>
                <?= esc($carrera['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <p><button type="submit">Guardar</button> <a href="<?= esc(site_url('cursos'), 'attr') ?>">Cancelar</a></p>
</form>
<?= $this->endSection() ?>
