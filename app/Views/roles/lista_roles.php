<!-- Lista de roles -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Listado de roles disponibles</h3>
    <div class="card-tools">
      <a href="<?= base_url('roles/nuevo') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Nuevo Rol
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
          <th>Descripción</th>
          <th style="width: 100px">Creado</th>
          <th style="width: 130px">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($roles)): ?>
          <tr>
            <td colspan="5" class="text-center">No hay roles registrados</td>
          </tr>
        <?php else: ?>
          <?php foreach ($roles as $index => $rol): ?>
            <tr>
              <td><?= $rol['rol_id'] ?></td>
              <td><?= $rol['rol_nombre'] ?></td>
              <td><?= $rol['rol_descripcion'] ?? '-' ?></td>
              <td><?= date('d/m/Y', strtotime($rol['created_at'])) ?></td>
              <td>
                <div class="btn-group">
                  <a href="<?= base_url('roles/ver/' . $rol['rol_id']) ?>" class="btn btn-info btn-sm" title="Ver">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="<?= base_url('roles/editar/' . $rol['rol_id']) ?>" class="btn btn-warning btn-sm" title="Editar">
                    <i class="fas fa-edit"></i>
                  </a>
                  <?php if (!in_array($rol['rol_id'], [1, 2, 3])): ?>
                    <a href="<?= base_url('roles/eliminar/' . $rol['rol_id']) ?>" class="btn btn-danger btn-sm btn-eliminar" title="Eliminar" 
                       onclick="return confirm('¿Está seguro que desea eliminar este rol?');">
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