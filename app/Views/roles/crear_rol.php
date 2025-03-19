<!-- Formulario para crear rol -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Crear Nuevo Rol</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <form action="<?= base_url('rol/crear') ?>" method="post">
      <?= csrf_field() ?>
      
      <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
      <?php endif; ?>
      
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="rol_nombre">Nombre del Rol</label>
            <input type="text" class="form-control" id="rol_nombre" name="rol_nombre" 
                  value="<?= old('rol_nombre') ?>" required>
            <small class="text-muted">Nombre que identificará al rol (ej. Administrador, Editor, etc.)</small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="rol_descripcion">Descripción</label>
            <textarea class="form-control" id="rol_descripcion" name="rol_descripcion" rows="3"><?= old('rol_descripcion') ?></textarea>
            <small class="text-muted">Breve descripción de las funciones o propósito del rol</small>
          </div>
        </div>
      </div>

      <!-- Selección de permisos -->
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Permisos</label>
            <div class="select2-purple">
              <select class="select2" multiple="multiple" name="permisos[]" style="width: 100%;">
                <?php foreach ($permisos as $permiso): ?>
                  <option value="<?= $permiso['permiso_id'] ?>" 
                          title="<?= $permiso['permiso_descripcion'] ?>">
                    <?= $permiso['permiso_nombre'] ?> (<?= $permiso['permiso_clave'] ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <small class="text-muted">Seleccione uno o más permisos para asignar a este rol</small>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-12 text-right">
          <a href="<?= base_url('roles') ?>" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save mr-1"></i> Guardar Rol
          </button>
        </div>
      </div>
    </form>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->