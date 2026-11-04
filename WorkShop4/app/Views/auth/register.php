<main class="container py-5"><div class="row justify-content-center"><div class="col-md-6"><div class="card shadow-sm"><div class="card-body p-4">
  <h1 class="h3 text-center mb-4">Crear cuenta</h1>
  <form action="<?= $baseUrl ?>/index.php?route=register" method="post">
    <div class="form-group"><label for="username">Usuario</label><input class="form-control" id="username" name="username" maxlength="50" required></div>
    <div class="form-group"><label for="province_id">Provincia</label><select class="form-control" id="province_id" name="province_id" required><option value="" selected disabled>Seleccione una provincia</option><?php foreach ($provinces as $province): ?><option value="<?= (int) $province['id'] ?>"><?= View::e($province['name']) ?></option><?php endforeach; ?></select></div>
    <div class="form-group"><label for="password">Contraseña</label><input class="form-control" id="password" name="password" type="password" minlength="8" required></div>
    <div class="form-group"><label for="confirm_password">Confirmar contraseña</label><input class="form-control" id="confirm_password" name="confirm_password" type="password" minlength="8" required></div>
    <button class="btn btn-primary btn-block" type="submit">Crear cuenta</button>
  </form>
  <p class="text-center mt-3 mb-0">¿Ya tiene cuenta? <a href="<?= $baseUrl ?>/index.php?route=login">Inicie sesión</a></p>
</div></div></div></div></main>
