<!-- Lista de usuarios -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Listado de usuarios registrados</h3>
    <div class="card-tools">
      <a href="<?= base_url('usuarios/nuevo') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Nuevo Usuario
      </a>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <table class="table table-bordered table-striped datatable">
      <thead>
        <tr>
          <th style="width: 50px">#</th>
          <th>Nombre</th>
          <th>Usuario</th>
          <th>Estado</th>
          <th style="width: 100px">Creado</th>
          <th style="width: 100px">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($usuarios)): ?>
          <tr>
            <td colspan="6" class="text-center">No hay usuarios registrados</td>
          </tr>
        <?php else: ?>
          <?php foreach ($usuarios as $index => $usuario): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td>
                <img src="<?= base_url($usuario['usuario_foto']) ?>" class="img-circle mr-2" alt="User Image" width="30" height="30">
                <?= $usuario['usuario_nombre'] . ' ' . $usuario['usuario_apellido'] ?>
              </td>
              <td><?= $usuario['usuario_usuario'] ?></td>
              <td>
                <?php if ($usuario['usuario_estado'] == 'activo'): ?>
                  <span class="badge badge-success">Activo</span>
                <?php elseif ($usuario['usuario_estado'] == 'inactivo'): ?>
                  <span class="badge badge-danger">Inactivo</span>
                <?php else: ?>
                  <span class="badge badge-warning">Pendiente</span>
                <?php endif; ?>
              </td>
              <td><?= date('d/m/Y', strtotime($usuario['created_at'])) ?></td>
              <td>
                <div class="btn-group">
                  <a href="<?= base_url('usuarios/editar/' . $usuario['usuario_id']) ?>" class="btn btn-warning btn-sm" title="Editar">
                    <i class="fas fa-edit"></i>
                  </a>
                  <?php if ($usuario['usuario_id'] != session()->get('usuario_id')): ?>
                    <a href="<?= base_url('usuarios/eliminar/' . $usuario['usuario_id']) ?>" class="btn btn-danger btn-sm btn-eliminar" title="Eliminar" 
                       onclick="return confirm('¿Está seguro que desea eliminar este usuario?');">
                      <i class="fas fa-trash"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->