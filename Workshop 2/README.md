# Workshop 2 — ISW-613

Aplicación PHP para registrar usuarios, asociarlos a una provincia, iniciar sesión y administrar el perfil autenticado.

## Estructura

```
actions/  Procesamiento de inicio de sesión, registro, actualización y cierre de sesión
pages/    Pantallas de registro, inicio, perfil y componentes compartidos
utils/    Conexión a MySQL
```

## Instalación

1. Cree la base de datos ejecutando `auth_schema.sql` en MySQL.
2. Ajuste los valores de `utils/database.php` o defina `DB_HOST`, `DB_NAME`, `DB_USER` y `DB_PASSWORD`.
3. Publique la carpeta en el servidor PHP (por ejemplo, en `htdocs`) y abra `index.php`.
4. Registre un usuario desde la aplicación.

El acceso a `pages/profile.php` y `pages/dashboard.php` exige una sesión válida. El cierre de sesión finaliza la sesión actual.
