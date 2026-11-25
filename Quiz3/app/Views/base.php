<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Matrícula de cursos</title>
    <style>
        body { font: 1rem/1.5 system-ui, sans-serif; max-width: 56rem; margin: 2rem auto; padding: 0 1rem; }
        label { display: block; margin-top: 1rem; }
        button, input, select { font: inherit; }
        input, select { max-width: 100%; box-sizing: border-box; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: .5rem; border-bottom: 1px solid #ccc; text-align: left; }
        .tabla { overflow-x: auto; }
        .acciones form { display: inline-block; margin-left: .5rem; }
        nav a { margin-right: 1rem; }
        dt { font-weight: bold; }
    </style>
</head>
<body>
<nav aria-label="Navegación principal">
    <a href="<?= esc(site_url('/'), 'attr') ?>">Matrícula</a>
    <a href="<?= esc(site_url('cursos'), 'attr') ?>">Cursos</a>
</nav>
<main>
    <?= $this->renderSection('contenido') ?>
</main>
</body>
</html>
