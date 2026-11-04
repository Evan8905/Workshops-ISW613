<main class="container py-5">
  <div class="row justify-content-center"><div class="col-md-6">
    <div class="card shadow-sm"><div class="card-body p-4">
      <h1 class="h3 text-center mb-4">Iniciar sesión</h1>
      <form action="<?= $baseUrl ?>/index.php?route=login" method="post">
        <div class="form-group"><label for="username">Usuario</label><input class="form-control" id="username" name="username" maxlength="50" value="<?= View::e($rememberedUsername) ?>" required></div>
        <div class="form-group"><label for="password">Contraseña</label><input class="form-control" id="password" name="password" type="password" required></div>
        <div class="form-group form-check"><input class="form-check-input" id="remember_me" name="remember_me" type="checkbox" <?= $rememberedUsername !== '' ? 'checked' : '' ?>><label class="form-check-label" for="remember_me">Recordarme</label></div>
        <button class="btn btn-primary btn-block" type="submit">Ingresar</button>
      </form>
      <p class="text-center mt-3 mb-0">¿No tiene cuenta? <a href="<?= $baseUrl ?>/index.php?route=register">Regístrese</a></p>
    </div></div>
  </div></div>
</main>
