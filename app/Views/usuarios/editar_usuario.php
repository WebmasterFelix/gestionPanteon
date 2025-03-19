<!-- Formulario para editar usuario -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Editar Usuario</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <form action="<?= base_url('usuario/actualizar') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="usuario_id" value="<?= $usuario['usuario_id'] ?>">

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="usuario_nombre">Nombre</label>
            <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre" 
                  value="<?= old('usuario_nombre', $usuario['usuario_nombre']) ?>" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="usuario_apellido">Apellido</label>
            <input type="text" class="form-control" id="usuario_apellido" name="usuario_apellido" 
                  value="<?= old('usuario_apellido', $usuario['usuario_apellido']) ?>" required>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="usuario_usuario">Nombre de Usuario</label>
            <input type="text" class="form-control" id="usuario_usuario" name="usuario_usuario" 
                  value="<?= old('usuario_usuario', $usuario['usuario_usuario']) ?>" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="usuario_password">Contraseña (Dejar en blanco para mantener la actual)</label>
            <input type="password" class="form-control" id="usuario_password" name="usuario_password">
            <small class="text-muted">Si se completa, la contraseña debe tener al menos 8 caracteres</small>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="usuario_estado">Estado</label>
            <select class="form-control" id="usuario_estado" name="usuario_estado" required>
              <option value="activo" <?= old('usuario_estado', $usuario['usuario_estado']) == 'activo' ? 'selected' : '' ?>>Activo</option>
              <option value="inactivo" <?= old('usuario_estado', $usuario['usuario_estado']) == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
              <option value="pendiente" <?= old('usuario_estado', $usuario['usuario_estado']) == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="usuario_foto">Foto de Perfil</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="usuario_foto" name="usuario_foto" accept="image/*">
                <label class="custom-file-label" for="usuario_foto">Seleccionar archivo</label>
              </div>
            </div>
            <small class="text-muted">Dejar en blanco para mantener la foto actual</small>
          </div>
        </div>
      </div>

      <!-- Selección de roles -->
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Roles</label>
            <div class="select2-purple">
              <select class="select2" multiple="multiple" name="roles[]" style="width: 100%;">
                <?php foreach ($roles as $rol): ?>
                  <option value="<?= $rol['rol_id'] ?>" <?= in_array($rol['rol_id'], $rolesAsignados) ? 'selected' : '' ?>>
                    <?= $rol['rol_nombre'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <small class="text-muted">Seleccione uno o más roles para el usuario</small>
          </div>
        </div>
      </div>

      <!-- Foto actual -->
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Foto actual</label>
            <div>
              <img src="<?= base_url($usuario['usuario_foto']) ?>" alt="Foto de perfil" class="img-thumbnail" style="max-width: 150px;">
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-12 text-right">
          <a href="<?= base_url('usuarios') ?>" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-edit mr-1"></i> Actualizar Usuario
          </button>
        </div>
      </div>
    </form>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
  $(function() {
    // Mostrar el nombre del archivo seleccionado en el input file
    $('input[type="file"]').change(function(e) {
      var fileName = e.target.files[0].name;
      $(this).next('.custom-file-label').html(fileName);
    });
    
    // Inicializar Select2 para selección múltiple
    $('.select2').select2({
      theme: 'bootstrap4',
      placeholder: "Seleccione los roles",
      allowClear: true
    });
  });
</script>