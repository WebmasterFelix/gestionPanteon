<!-- Lista de permisos -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Listado de permisos disponibles</h3>
    <div class="card-tools">
      <a href="<?= base_url('permisos/nuevo') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Nuevo Permiso
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
          <th>Clave</th>
          <th>Descripción</th>
          <th style="width: 100px">Creado</th>
          <th style="width: 130px">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($permisos)): ?>
          <tr>
            <td colspan="6" class="text-center">No hay permisos registrados</td>
          </tr>
        <?php else: ?>
          <?php foreach ($permisos as $index => $permiso): ?>
            <tr>
              <td><?= $permiso['permiso_id'] ?></td>
              <td><?= $permiso['permiso_nombre'] ?></td>
              <td><code><?= $permiso['permiso_clave'] ?></code></td>
              <td><?= $permiso['permiso_descripcion'] ?? '-' ?></td>
              <td><?= date('d/m/Y', strtotime($permiso['created_at'])) ?></td>
              <td>
                <div class="btn-group">
                  <a href="<?= base_url('permisos/ver/' . $permiso['permiso_id']) ?>" class="btn btn-info btn-sm" title="Ver">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="<?= base_url('permisos/editar/' . $permiso['permiso_id']) ?>" class="btn btn-warning btn-sm" title="Editar">
                    <i class="fas fa-edit"></i>
                  </a>
                  <?php if ($permiso['permiso_id'] > 7): ?>
                    <a href="<?= base_url('permisos/eliminar/' . $permiso['permiso_id']) ?>" class="btn btn-danger btn-sm btn-eliminar" title="Eliminar" 
                       onclick="return confirm('¿Está seguro que desea eliminar este permiso?');">
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