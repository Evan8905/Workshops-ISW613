<main class="container py-5"><div class="row justify-content-center"><div class="col-md-7"><div class="card shadow-sm"><div class="card-body p-4">
  <h1 class="h3 text-center mb-3">Mi perfil</h1>
  <div class="text-center mb-3"><?php if (!empty($user['profile_picture'])): ?><img class="rounded-circle img-thumbnail" style="width:128px;height:128px;object-fit:cover" src="<?= $baseUrl ?>/uploads/profile_pictures/<?= rawurlencode(basename($user['profile_picture'])) ?>" alt="Foto de perfil"><?php else: ?><div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:128px;height:128px;font-size:48px"><?= View::e(mb_strtoupper(mb_substr($user['username'], 0, 1))) ?></div><?php endif; ?></div>
  <dl class="row"><dt class="col-sm-4">Usuario</dt><dd class="col-sm-8"><?= View::e($user['username']) ?></dd><dt class="col-sm-4">Provincia</dt><dd class="col-sm-8"><?= View::e($user['province_name'] ?? 'Sin asignar') ?></dd></dl><hr>
  <h2 class="h5">Actualizar datos</h2>
  <form action="<?= $baseUrl ?>/index.php?route=profile" method="post" enctype="multipart/form-data">
    <div class="form-group"><label for="username">Usuario</label><input class="form-control" id="username" name="username" maxlength="50" value="<?= View::e($user['username']) ?>" required></div>
    <div class="form-group"><label for="province_id">Provincia</label><select class="form-control" id="province_id" name="province_id" required><?php foreach ($provinces as $province): ?><option value="<?= (int) $province['id'] ?>" <?= (int) $province['id'] === $user['province_id'] ? 'selected' : '' ?>><?= View::e($province['name']) ?></option><?php endforeach; ?></select></div>
    <div class="form-group"><label for="profile_picture">Foto de perfil</label><input class="form-control-file" id="profile_picture" name="profile_picture" type="file" accept="image/jpeg,image/png,image/gif,image/webp"><small class="form-text text-muted">Opcional; JPG, PNG, GIF o WEBP de hasta 2 MB.</small></div>
    <p class="text-muted small">Deje las contraseñas vacías si no desea cambiarla.</p>
    <div class="form-group"><label for="current_password">Contraseña actual</label><input class="form-control" id="current_password" name="current_password" type="password"></div><div class="form-group"><label for="new_password">Nueva contraseña</label><input class="form-control" id="new_password" name="new_password" type="password" minlength="8"></div><div class="form-group"><label for="confirm_password">Confirmar nueva contraseña</label><input class="form-control" id="confirm_password" name="confirm_password" type="password" minlength="8"></div>
    <button class="btn btn-primary btn-block" type="submit">Guardar cambios</button>
  </form>
</div></div></div></div></main>
