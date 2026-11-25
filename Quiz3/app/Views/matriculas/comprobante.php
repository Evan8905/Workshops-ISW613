<?= $this->extend('base') ?>
<?= $this->section('contenido') ?>
<h1>Matrícula registrada</h1>
<dl>
    <dt>Número de matrícula</dt>
    <dd><?= esc($matricula['id']) ?></dd>
    <dt>Carné</dt>
    <dd><?= esc($matricula['carne']) ?></dd>
    <dt>Curso</dt>
    <dd><?= esc($matricula['codigo'] . ' — ' . $matricula['curso']) ?></dd>
    <dt>Carrera</dt>
    <dd><?= esc($matricula['carrera']) ?></dd>
    <dt>Fecha</dt>
    <dd><?= esc($matricula['fecha']) ?></dd>
</dl>
<p><a href="<?= esc(site_url('/'), 'attr') ?>">Volver al formulario</a></p>
<?= $this->endSection() ?>
