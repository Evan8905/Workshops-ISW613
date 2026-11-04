# Workshop 4 — MVC

La funcionalidad del Workshop 3 fue reorganizada con el patrón Modelo–Vista–Controlador.

- `app/Models`: acceso a los datos de usuarios, provincias y cursos.
- `app/Controllers`: recibe cada solicitud, valida datos y coordina modelos/vistas.
- `app/Views`: contiene únicamente la presentación HTML.
- `app/Services`: sesión, renderizado y carga de imágenes.
- `public/index.php`: front controller y definición de rutas.

## Ejecución

1. Cree o conserve la base de datos usada en Workshop 3 y ejecute los esquemas de ese taller.
2. Ajuste las variables de entorno `DB_HOST`, `DB_NAME`, `DB_USER` y `DB_PASSWORD` si son necesarias. Por defecto usa `127.0.0.1`, `workshop3`, `root` y una contraseña vacía.
3. Coloque la carpeta `WorkShop4` en el servidor PHP/XAMPP y abra `http://localhost/WorkShop4/index.php`.

El archivo raíz delega en `public/index.php` para que se pueda abrir el proyecto sin modificar el `DocumentRoot`. En producción, el DocumentRoot debe apuntar a `public/`.
