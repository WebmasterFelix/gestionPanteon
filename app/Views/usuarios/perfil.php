<div class="row">
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle"
               src="<?= base_url($usuario['usuario_foto']) ?>"
               alt="Foto de perfil">
        </div>

        <h3 class="profile-username text-center"><?= $usuario['usuario_nombre'] . ' ' . $usuario['usuario_apellido'] ?></h3>

        <p class="text-muted text-center"><?= $usuario['usuario_usuario'] ?></p>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Estado</b> <a class="float-right">
              <?php if ($usuario['usuario_estado'] == 'activo'): ?>
                <span class="badge badge-success">Activo</span>
              <?php elseif ($usuario['usuario_estado'] == 'inactivo'): ?>
                <span class="badge badge-danger">Inactivo</span>
              <?php else: ?>
                <span class="badge badge-warning">Pendiente</span>
              <?php endif; ?>
            </a>
          </li>
          <li class="list-group-item">
            <b>Miembro desde</b> <a class="float-right"><?= date('d/m/Y', strtotime($usuario['created_at'])) ?></a>
          </li>
        </ul>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link <?= strpos(current_url(), '#password') === false ? 'active' : '' ?>" href="#profile" data-toggle="tab">Perfil</a></li>
          <li class="nav-item"><a class="nav-link <?= strpos(current_url(), '#password') !== false ? 'active' : '' ?>" href="#password" data-toggle="tab">Contraseña</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <?php if (session()->getFlashdata('errors')): ?>
          <div class="alert alert-danger">
              <ul>
              <?php foreach (session('errors') as $error): ?>
                  <li><?= $error ?></li>
              <?php endforeach; ?>
              </ul>
          </div>
        <?php endif; ?>
        
        <div class="tab-content">
          <div class="<?= strpos(current_url(), '#password') === false ? 'active' : '' ?> tab-pane" id="profile">
            <form class="form-horizontal" action="<?= base_url('usuario/guardarPerfil') ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>
              <input type="hidden" name="accion" value="actualizar_perfil">
              <div class="form-group row">
                <label for="usuario_nombre" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre" value="<?= $usuario['usuario_nombre'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="usuario_apellido" class="col-sm-2 col-form-label">Apellido</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="usuario_apellido" name="usuario_apellido" value="<?= $usuario['usuario_apellido'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="usuario_foto" class="col-sm-2 col-form-label">Foto de Perfil</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="usuario_foto" name="usuario_foto" accept="image/*">
                      <label class="custom-file-label" for="usuario_foto">Seleccionar archivo</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                  <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.tab-pane -->
          <div class="<?= strpos(current_url(), '#password') !== false ? 'active' : '' ?> tab-pane" id="password">
            <form class="form-horizontal" action="<?= base_url('usuario/guardarPerfil') ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="accion" value="cambiar_password">
              <div class="form-group row">
                <label for="actual_password" class="col-sm-3 col-form-label">Contraseña Actual</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="actual_password" name="actual_password" placeholder="Ingrese su contraseña actual">
                </div>
              </div>
              <div class="form-group row">
                <label for="nuevo_password" class="col-sm-3 col-form-label">Nueva Contraseña</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="nuevo_password" name="nuevo_password" placeholder="Ingrese su nueva contraseña">
                </div>
              </div>
              <div class="form-group row">
                <label for="confirmar_password" class="col-sm-3 col-form-label">Confirmar Contraseña</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" placeholder="Confirme su nueva contraseña">
                </div>
              </div>
              <div class="form-group row">
                <div class="offset-sm-3 col-sm-9">
                  <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                </div>
              </div>
            </form>
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

<script>
  $(function() {
    // Mostrar el nombre del archivo seleccionado en el input file
    $('input[type="file"]').change(function(e) {
      var fileName = e.target.files[0].name;
      $(this).next('.custom-file-label').html(fileName);
    });
    
    // Activar la pestaña correcta según el hash de la URL
    var hash = window.location.hash;
    if (hash) {
      $('.nav-pills a[href="' + hash + '"]').tab('show');
    }
    
    // Al hacer clic en un tab, actualizar la URL con el hash
    $('.nav-pills a').on('click', function (e) {
      window.location.hash = $(this).attr('href');
    });
  });
</script>