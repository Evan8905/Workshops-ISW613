USE matricula_quiz3;

INSERT INTO carreras (nombre) VALUES
    ('Ingeniería del Software'),
    ('Administración de Empresas'),
    ('Contabilidad y Finanzas')
ON DUPLICATE KEY UPDATE id = carreras.id;

INSERT INTO cursos (nombre, codigo, creditos, carrera_id) VALUES
    ('Programación Web', 'ISW-101', 4,
        (SELECT id FROM carreras WHERE nombre = 'Ingeniería del Software')),
    ('Bases de Datos', 'ISW-102', 4,
        (SELECT id FROM carreras WHERE nombre = 'Ingeniería del Software')),
    ('Fundamentos de Administración', 'ADM-101', 3,
        (SELECT id FROM carreras WHERE nombre = 'Administración de Empresas')),
    ('Contabilidad General', 'CON-101', 3,
        (SELECT id FROM carreras WHERE nombre = 'Contabilidad y Finanzas'))
ON DUPLICATE KEY UPDATE id = cursos.id;