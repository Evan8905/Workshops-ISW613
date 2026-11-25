<?= $this->extend('cursos/base') ?>
<?= $this->section('contenido') ?>
<h1>Cursos</h1>
<p><a href="<?= esc(site_url('cursos/nuevo'), 'attr') ?>">Crear curso</a></p>

<?php if ($mensaje = session()->getFlashdata('mensaje')): ?>
    <p role="status"><?= esc($mensaje) ?></p>
<?php endif; ?>

<?php if ($cursos === []): ?>
    <p>No hay cursos registrados.</p>
<?php else: ?>
    <div class="tabla">
        <table>
            <thead>
                <tr><th>Código</th><th>Nombre</th><th>Créditos</th><th>Carrera</th><th>Acciones</th></tr>
            </thead>
            <tbody>
            <?php foreach ($cursos as $curso): ?>
                <tr>
                    <td><?= esc($curso['codigo']) ?></td>
                    <td><?= esc($curso['nombre']) ?></td>
                    <td><?= esc($curso['creditos']) ?></td>
                    <td><?= esc($curso['carrera']) ?></td>
                    <td class="acciones">
                        <a href="<?= esc(site_url('cursos/' . $curso['id'] . '/editar'), 'attr') ?>">Editar</a>
                        <form method="post" action="<?= esc(site_url('cursos/' . $curso['id'] . '/eliminar'), 'attr') ?>"
                              onsubmit="return confirm('¿Eliminar este curso?')">
                            <?= csrf_field() ?>
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
