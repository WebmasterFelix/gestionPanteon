<!-- Detalles del permiso -->
<div class="row">
  <div class="col-md-4">
    <!-- Información del permiso -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Información del Permiso</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <strong><i class="fas fa-id-badge mr-1"></i> ID</strong>
        <p class="text-muted"><?= $permiso['permiso_id'] ?></p>
        <hr>
        
        <strong><i class="fas fa-tag mr-1"></i> Nombre</strong>
        <p class="text-muted"><?= $permiso['permiso_nombre'] ?></p>
        <hr>
        
        <strong><i class="fas fa-key mr-1"></i> Clave</strong>
        <p class="text-muted"><code><?= $permiso['permiso_clave'] ?></code></p>
        <hr>
        
        <strong><i class="fas fa-align-left mr-1"></i> Descripción</strong>
        <p class="text-muted"><?= $permiso['permiso_descripcion'] ?? 'Sin descripción' ?></p>
        <hr>
        
        <strong><i class="fas fa-calendar-alt mr-1"></i> Fecha Creación</strong>
        <p class="text-muted"><?= date('d/m/Y H:i:s', strtotime($permiso['created_at'])) ?></p>
        <?php if (!empty($permiso['updated_at'])): ?>
          <hr>
          <strong><i class="fas fa-edit mr-1"></i> Última Actualización</strong>
          <p class="text-muted"><?= date('d/m/Y H:i:s', strtotime($permiso['updated_at'])) ?></p>
        <?php endif; ?>
        
        <div class="mt-3 text-center">
          <a href="<?= base_url('permisos/editar/' . $permiso['permiso_id']) ?>" class="btn btn-warning">
            <i class="fas fa-edit mr-1"></i> Editar
          </a>
          <?php if ($permiso['permiso_id'] > 7): ?>
            <a href="<?= base_url('permisos/eliminar/' . $permiso['permiso_id']) ?>" class="btn btn-danger" 
              onclick="return confirm('¿Está seguro que desea eliminar este permiso?');">
              <i class="fas fa-trash mr-1"></i> Eliminar
            </a>
          <?php endif; ?>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- ./col -->
  
  <div class="col-md-8">
    <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link active" href="#acciones" data-toggle="tab">Acciones</a></li>
          <li class="nav-item"><a class="nav-link" href="#roles" data-toggle="tab">Roles</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <!-- Acciones asignadas -->
          <div class="active tab-pane" id="acciones">
            <?php if (empty($acciones)): ?>
              <div class="alert alert-info">
                Este permiso no tiene acciones asignadas.
              </div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 50px">#</th>
                      <th>Módulo</th>
                      <th>Acción</th>
                      <th>Clave</th>
                      <th>Descripción</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($acciones as $accion): ?>
                      <tr>
                        <td><?= $accion['accion_id'] ?></td>
                        <td><?= $accion['modulo_nombre'] ?></td>
                        <td><?= $accion['accion_nombre'] ?></td>
                        <td><code><?= $accion['accion_clave'] ?></code></td>
                        <td><?= $accion['accion_descripcion'] ?? '-' ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
          <!-- /.tab-pane -->
          
          <!-- Roles asignados -->
          <div class="tab-pane" id="roles">
            <?php if (empty($roles)): ?>
              <div class="alert alert-info">
                No hay roles asignados a este permiso.
              </div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 50px">#</th>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th style="width: 100px">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($roles as $rol): ?>
                      <tr>
                        <td><?= $rol['rol_id'] ?></td>
                        <td><?= $rol['rol_nombre'] ?></td>
                        <td><?= $rol['rol_descripcion'] ?? '-' ?></td>
                        <td>
                          <a href="<?= base_url('roles/ver/' . $rol['rol_id']) ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="<?= base_url('roles/editar/' . $rol['rol_id']) ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div><!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->