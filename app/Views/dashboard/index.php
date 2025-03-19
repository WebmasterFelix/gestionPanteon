<!-- Tarjetas informativas -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $estadisticas['totalUsuarios'] ?></h3>
        <p>Usuarios</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="<?= base_url('usuarios') ?>" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= $estadisticas['totalRoles'] ?></h3>
        <p>Roles</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?= $estadisticas['totalPermisos'] ?></h3>
        <p>Permisos</p>
      </div>
      <div class="icon">
        <i class="ion ion-key"></i>
      </div>
      <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?= $estadisticas['totalModulos'] ?></h3>
        <p>Módulos</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->

<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-7 connectedSortable">
    <!-- Usuarios recientes -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-users mr-1"></i>
          Usuarios Recientes
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div><!-- /.card-header -->
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Fecha Registro</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($usuariosRecientes)): ?>
                <tr>
                  <td colspan="4" class="text-center">No hay usuarios recientes</td>
                </tr>
              <?php else: ?>
                <?php foreach ($usuariosRecientes as $usuario): ?>
                  <tr>
                    <td><a href="<?= base_url('usuarios/editar/' . $usuario['usuario_id']) ?>"><?= $usuario['usuario_id'] ?></a></td>
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
                      <div class="sparkbar" data-color="#00a65a" data-height="20">
                        <?= date('d/m/Y', strtotime($usuario['created_at'])) ?>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer text-center">
        <a href="<?= base_url('usuarios') ?>" class="uppercase">Ver Todos los Usuarios</a>
      </div>
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->

    <!-- Estado de Usuarios -->
    <div class="card">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="fas fa-th mr-1"></i>
          Estado de Usuarios
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-sm btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-8">
            <div class="chart-responsive">
              <canvas id="usuariosChart" height="150"></canvas>
            </div>
            <!-- ./chart-responsive -->
          </div>
          <div class="col-md-4">
            <ul class="chart-legend clearfix">
              <li><i class="far fa-circle text-success"></i> Activos (<?= $estadisticas['usuariosActivos'] ?>)</li>
              <li><i class="far fa-circle text-warning"></i> Pendientes (<?= $estadisticas['usuariosPendientes'] ?>)</li>
              <li><i class="far fa-circle text-danger"></i> Inactivos (<?= $estadisticas['totalUsuarios'] - $estadisticas['usuariosActivos'] - $estadisticas['usuariosPendientes'] ?>)</li>
            </ul>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- /.Left col -->
  
  <!-- right col (We are only adding the ID to make the widgets sortable)-->
  <section class="col-lg-5 connectedSortable">
    <!-- Actividad Reciente -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-history mr-1"></i>
          Actividad Reciente
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <!-- The timeline -->
        <div class="timeline timeline-inverse">
          <?php if (empty($actividadReciente)): ?>
            <div>
              <i class="fas fa-info bg-info"></i>
              <div class="timeline-item">
                <h3 class="timeline-header border-0">No hay actividad reciente</h3>
              </div>
            </div>
          <?php else: ?>
            <?php 
            $currentDate = ''; 
            foreach ($actividadReciente as $actividad): 
              $activityDate = date('Y-m-d', strtotime($actividad['created_at']));
              if ($currentDate != $activityDate): 
                $currentDate = $activityDate;
            ?>
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-danger">
                  <?= date('d M, Y', strtotime($actividad['created_at'])) ?>
                </span>
              </div>
              <!-- /.timeline-label -->
            <?php endif; ?>
            
            <!-- timeline item -->
            <div>
              <?php
              $icon = 'fas fa-user';
              $bgColor = 'bg-primary';
              
              if ($actividad['accion'] == 'crear') {
                $icon = 'fas fa-plus';
                $bgColor = 'bg-success';
              } elseif ($actividad['accion'] == 'actualizar') {
                $icon = 'fas fa-edit';
                $bgColor = 'bg-warning';
              } elseif ($actividad['accion'] == 'eliminar') {
                $icon = 'fas fa-trash';
                $bgColor = 'bg-danger';
              }
              ?>
              <i class="<?= $icon ?> <?= $bgColor ?>"></i>

              <div class="timeline-item">
                <span class="time"><i class="far fa-clock"></i> <?= date('H:i', strtotime($actividad['created_at'])) ?></span>

                <h3 class="timeline-header">
                  <?php if (!empty($actividad['usuario_nombre'])): ?>
                    <img src="<?= base_url($actividad['usuario_foto'] ?? 'assets/images/perfil/user2-160x160.jpg') ?>" class="img-circle mr-2" alt="User Image" width="30" height="30">
                    <a href="#"><?= $actividad['usuario_nombre'] . ' ' . $actividad['usuario_apellido'] ?></a>
                  <?php else: ?>
                    <span>Usuario desconocido</span>
                  <?php endif; ?>
                </h3>

                <div class="timeline-body">
                  <?= ucfirst($actividad['accion']) ?> en <?= $actividad['modulo'] ?>: <?= $actividad['descripcion'] ?>
                </div>
              </div>
            </div>
            <!-- END timeline item -->
            <?php endforeach; ?>
            
            <div>
              <i class="far fa-clock bg-gray"></i>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- Calendar -->
    <div class="card bg-gradient-success">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="far fa-calendar-alt"></i>
          Calendario
        </h3>
        <!-- tools card -->
        <div class="card-tools">
          <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
        <!-- /. tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body pt-0">
        <!--The calendar -->
        <div id="calendar" style="width: 100%"></div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- right col -->
</div>
<!-- /.row -->

<!-- Script para inicializar el gráfico de usuarios -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Gráfico de usuarios
  var usuariosChartCanvas = document.getElementById('usuariosChart').getContext('2d');
  var usuariosData = {
    labels: ['Activos', 'Pendientes', 'Inactivos'],
    datasets: [
      {
        data: [
          <?= $estadisticas['usuariosActivos'] ?>, 
          <?= $estadisticas['usuariosPendientes'] ?>, 
          <?= $estadisticas['totalUsuarios'] - $estadisticas['usuariosActivos'] - $estadisticas['usuariosPendientes'] ?>
        ],
        backgroundColor: ['#00a65a', '#f39c12', '#f56954'],
      }
    ]
  };
  
  var usuariosOptions = {
    maintainAspectRatio: false,
    responsive: true,
  };
  
  new Chart(usuariosChartCanvas, {
    type: 'doughnut',
    data: usuariosData,
    options: usuariosOptions
  });
  
  // Calendario
  $('#calendar').datetimepicker({
    format: 'L',
    inline: true
  });
});
</script>