<!-- Formulario para crear permiso -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Crear Nuevo Permiso</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <form action="<?= base_url('permiso/crear') ?>" method="post">
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
        <div class="col-md-4">
          <div class="form-group">
            <label for="permiso_nombre">Nombre del Permiso</label>
            <input type="text" class="form-control" id="permiso_nombre" name="permiso_nombre" 
                  value="<?= old('permiso_nombre') ?>" required>
            <small class="text-muted">Nombre descriptivo del permiso</small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="permiso_clave">Clave del Permiso</label>
            <input type="text" class="form-control" id="permiso_clave" name="permiso_clave" 
                   value="<?= old('permiso_clave') ?>" required>
            <small class="text-muted">Clave única para identificar el permiso (ej. usuarios_crear)</small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="permiso_descripcion">Descripción</label>
            <textarea class="form-control" id="permiso_descripcion" name="permiso_descripcion" rows="2"><?= old('permiso_descripcion') ?></textarea>
            <small class="text-muted">Breve descripción del propósito del permiso</small>
          </div>
        </div>
      </div>

      <!-- Selección de acciones de módulos -->
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Acciones de Módulos</label>
            <div class="select2-purple">
              <select class="select2" multiple="multiple" name="acciones[]" style="width: 100%;">
                <?php 
                $modulosAgrupados = [];
                foreach ($acciones as $accion) {
                    if (!isset($modulosAgrupados[$accion['modulo_nombre']])) {
                        $modulosAgrupados[$accion['modulo_nombre']] = [];
                    }
                    $modulosAgrupados[$accion['modulo_nombre']][] = $accion;
                }
                ?>
                
                <?php foreach ($modulosAgrupados as $modulo => $accionesModulo): ?>
                  <optgroup label="<?= $modulo ?>">
                    <?php foreach ($accionesModulo as $accion): ?>
                      <option value="<?= $accion['accion_id'] ?>" 
                              title="<?= $accion['accion_descripcion'] ?>">
                        <?= $accion['accion_nombre'] ?> (<?= $accion['accion_clave'] ?>)
                      </option>
                    <?php endforeach; ?>
                  </optgroup>
                <?php endforeach; ?>
              </select>
            </div>
            <small class="text-muted">Seleccione las acciones específicas que este permiso permitirá realizar</small>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-12 text-right">
          <a href="<?= base_url('permisos') ?>" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save mr-1"></i> Guardar Permiso
          </button>
        </div>
      </div>
    </form>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->