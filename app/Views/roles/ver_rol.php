<!-- Detalles del rol -->
<div class="row">
  <div class="col-md-4">
    <!-- Información del rol -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Información del Rol</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <strong><i class="fas fa-id-badge mr-1"></i> ID</strong>
        <p class="text-muted"><?= $rol['rol_id'] ?></p>
        <hr>
        
        <strong><i class="fas fa-tag mr-1"></i> Nombre</strong>
        <p class="text-muted"><?= $rol['rol_nombre'] ?></p>
        <hr>
        
        <strong><i class="fas fa-align-left mr-1"></i> Descripción</strong>
        <p class="text-muted"><?= $rol['rol_descripcion'] ?? 'Sin descripción' ?></p>
        <hr>
        
        <strong><i class="fas fa-calendar-alt mr-1"></i> Fecha Creación</strong>
        <p class="text-muted"><?= date('d/m/Y H:i:s', strtotime($rol['created_at'])) ?></p>
        <?php if (!empty($rol['updated_at'])): ?>
          <hr>
          <strong><i class="fas fa-edit mr-1"></i> Última Actualización</strong>
          <p class="text-muted"><?= date('d/m/Y H:i:s', strtotime($rol['updated_at'])) ?></p>
        <?php endif; ?>
        
        <div class="mt-3 text-center">
          <a href="<?= base_url('roles/editar/' . $rol['rol_id']) ?>" class="btn btn-warning">
            <i class="fas fa-edit mr-1"></i> Editar
          </a>
          <?php if (!in_array($rol['rol_id'], [1, 2, 3])): ?>
            <a href="<?= base_url('roles/eliminar/' . $rol['rol_id']) ?>" class="btn btn-danger" 
              onclick="return confirm('¿Está seguro que desea eliminar este rol?');">
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
          <li class="nav-item"><a class="nav-link active" href="#permisos" data-toggle="tab">Permisos</a></li>
          <li class="nav-item"><a class="nav-link" href="#usuarios" data-toggle="tab">Usuarios</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <!-- Permisos asignados -->
          <div class="active tab-pane" id="permisos">
            <?php if (empty($permisos)): ?>
              <div class="alert alert-info">
                Este rol no tiene permisos asignados.
              </div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 50px">#</th>
                      <th>Nombre</th>
                      <th>Clave</th>
                      <th>Descripción</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($permisos as $permiso): ?>
                      <tr>
                        <td><?= $permiso['permiso_id'] ?></td>
                        <td><?= $permiso['permiso_nombre'] ?></td>
                        <td><code><?= $permiso['permiso_clave'] ?></code></td>
                        <td><?= $permiso['permiso_descripcion'] ?? '-' ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
          <!-- /.tab-pane -->
          
          <!-- Usuarios asignados -->
          <div class="tab-pane" id="usuarios">
            <?php if (empty($usuarios)): ?>
              <div class="alert alert-info">
                No hay usuarios asignados a este rol.
              </div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 50px">#</th>
                      <th>Usuario</th>
                      <th>Estado</th>
                      <th style="width: 100px">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                      <tr>
                        <td><?= $usuario['usuario_id'] ?></td>
                        <td>
                          <img src="<?= base_url($usuario['usuario_foto']) ?>" class="img-circle mr-2" alt="User Image" width="30" height="30">
                          <?= $usuario['usuario_nombre'] . ' ' . $usuario['usuario_apellido'] ?>
                          <br>
                          <small class="text-muted"><?= $usuario['usuario_usuario'] ?></small>
                        </td>
                        <td>
                          <?php if ($usuario['usuario_estado'] == 'activo'): ?>
                            <span class="badge badge-success">Activo</span>
                          <?php elseif ($usuario['usuario_estado'] == 'inactivo'): ?>
                            <span class="badge badge-danger">Inactivo</span>
                          <?php else: ?>
                            <span class="badge badge-warning">Pendiente</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <a href="<?= base_url('usuarios/editar/' . $usuario['usuario_id']) ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-user-edit"></i>
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