<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Sistema | <?= $titulo ?? 'Panel de Control' ?></title>

		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Tempusdominus Bootstrap 4 -->
		<link rel="stylesheet" href="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
		<!-- iCheck -->
		<link rel="stylesheet" href="<?= base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
		<!-- JQVMap -->
		<link rel="stylesheet" href="<?= base_url('assets/plugins/jqvmap/jqvmap.min.css') ?>">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
		<!-- overlayScrollbars -->
		<link rel="stylesheet" href="<?= base_url('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
		<!-- Daterange picker -->
		<link rel="stylesheet" href="<?= base_url('assets/plugins/daterangepicker/daterangepicker.css') ?>">
		<!-- summernote -->
		<link rel="stylesheet" href="<?= base_url('assets/plugins/summernote/summernote-bs4.min.css') ?>">
		<!-- DataTables -->
		<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
		<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
		<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
		<!-- JavaScript -->
		<!-- Asegurarnos de cargar jQuery primero -->
		<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
		<!-- Select2 -->
		<link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css') ?>">
		<link rel="stylesheet" href="<?= base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Preloader -->
			<div class="preloader flex-column justify-content-center align-items-center">
				<img class="animation__shake" src="<?= base_url('assets/dist/img/AdminLTELogo.png') ?>" alt="AdminLTELogo" height="60" width="60">
			</div>
			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Left navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>
					<li class="nav-item d-none d-sm-inline-block">
						<a href="<?= base_url('dashboard') ?>" class="nav-link">Inicio</a>
					</li>
				</ul>

				<!-- Right navbar links -->
				<ul class="navbar-nav ml-auto">
					<!-- Notifications Dropdown Menu -->
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="#">
							<i class="far fa-bell"></i>
							<span class="badge badge-warning navbar-badge">0</span>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<span class="dropdown-item dropdown-header">0 Notificaciones</span>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fas fa-envelope mr-2"></i> No hay notificaciones
							</a>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-widget="fullscreen" href="#" role="button">
							<i class="fas fa-expand-arrows-alt"></i>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('auth/logout') ?>" role="button" title="Cerrar sesión">
							<i class="fas fa-sign-out-alt"></i>
						</a>
					</li>
				</ul>
			</nav>
			<!-- /.navbar -->

			<!-- Main Sidebar Container -->
			<aside class="main-sidebar sidebar-dark-primary elevation-4">
				<!-- Brand Logo -->
				<a href="<?= base_url('dashboard') ?>" class="brand-link">
					<img src="<?= base_url('assets/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
					<span class="brand-text font-weight-light">Sistema</span>
				</a>

				<!-- Sidebar -->
				<div class="sidebar">
					<!-- Sidebar user panel (optional) -->
					<div class="user-panel mt-3 pb-3 mb-3 d-flex">
						<div class="image">
							<img src="<?= base_url(session()->get('usuario_foto')) ?>" class="img-circle elevation-2" alt="User Image">
						</div>
						<div class="info">
							<a href="<?= base_url('perfil') ?>" class="d-block"><?= session()->get('usuario_nombre') . ' ' . session()->get('usuario_apellido') ?></a>
						</div>
					</div>

					<!-- Sidebar Menu -->
					<nav class="mt-2">
						<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
							<!-- Add icons to the links using the .nav-icon class
							with font-awesome or any other icon font library -->
							<li class="nav-item">
								<a href="<?= base_url('dashboard') ?>" class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>">
									<i class="nav-icon fas fa-tachometer-alt"></i>
									<p>Dashboard</p>
								</a>
							</li>
							<li class="nav-item <?= strpos(uri_string(), 'usuarios') !== false ? 'menu-open' : '' ?>">
								<a href="#" class="nav-link <?= strpos(uri_string(), 'usuarios') !== false ? 'active' : '' ?>">
									<i class="nav-icon fas fa-users"></i>
									<p>
										Usuarios
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="<?= base_url('usuarios') ?>" class="nav-link <?= uri_string() == 'usuarios' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Listar Usuarios</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= base_url('usuarios/nuevo') ?>" class="nav-link <?= uri_string() == 'usuarios/nuevo' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Nuevo Usuario</p>
										</a>
									</li>
								</ul>
							</li>
			  
							<li class="nav-item <?= strpos(uri_string(), 'roles') !== false ? 'menu-open' : '' ?>">
								<a href="#" class="nav-link <?= strpos(uri_string(), 'roles') !== false ? 'active' : '' ?>">
									<i class="nav-icon fas fa-user-tag"></i>
									<p>
										Roles
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="<?= base_url('roles') ?>" class="nav-link <?= uri_string() == 'roles' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Listar Roles</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= base_url('roles/nuevo') ?>" class="nav-link <?= uri_string() == 'roles/nuevo' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Nuevo Rol</p>
										</a>
									</li>
								</ul>
							</li>
			  
							<li class="nav-item <?= strpos(uri_string(), 'permisos') !== false ? 'menu-open' : '' ?>">
								<a href="#" class="nav-link <?= strpos(uri_string(), 'permisos') !== false ? 'active' : '' ?>">
									<i class="nav-icon fas fa-key"></i>
									<p>
										Permisos
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="<?= base_url('permisos') ?>" class="nav-link <?= uri_string() == 'permisos' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Listar Permisos</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= base_url('permisos/nuevo') ?>" class="nav-link <?= uri_string() == 'permisos/nuevo' ? 'active' : '' ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Nuevo Permiso</p>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="<?= base_url('perfil') ?>" class="nav-link <?= uri_string() == 'perfil' ? 'active' : '' ?>">
									<i class="nav-icon fas fa-user"></i>
									<p>Mi Perfil</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= base_url('auth/logout') ?>" class="nav-link">
									<i class="nav-icon fas fa-sign-out-alt"></i>
									<p>Cerrar Sesión</p>
								</a>
							</li>
						</ul>
					</nav>
					<!-- /.sidebar-menu -->
				</div>
				<!-- /.sidebar -->
			</aside>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0"><?= $titulo ?? 'Panel de Control' ?></h1>
							</div><!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Inicio</a></li>
									<li class="breadcrumb-item active"><?= $titulo ?? 'Panel de Control' ?></li>
								</ol>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<?php if (session()->getFlashdata('error')): ?>
						<div class="alert alert-danger">
							<?= session()->getFlashdata('error') ?>
						</div>
						<?php endif; ?>

						<?php if (session()->getFlashdata('mensaje')): ?>
						<div class="alert alert-success">
							<?= session()->getFlashdata('mensaje') ?>
						</div>
						<?php endif; ?>

						<?php if (isset($vista_contenido)) echo view($vista_contenido); ?>
					</div><!-- /.container-fluid -->
				</section>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->  
			<footer class="main-footer">
				<strong>Copyright &copy; <?= date('Y') ?> <a href="<?= base_url() ?>">Sistema</a>.</strong>
				Todos los derechos reservados.
				<div class="float-right d-none d-sm-inline-block">
					<b>Version</b> 1.0.0
				</div>
			</footer>

			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Control sidebar content goes here -->
			</aside>
			<!-- /.control-sidebar -->
		</div>
		<!-- ./wrapper -->

		<!-- jQuery ya se cargó en el encabezado -->
		<!-- jQuery UI 1.11.4 -->
		<script src="<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
		  $.widget.bridge('uibutton', $.ui.button)
		</script>
		<!-- Bootstrap 4 -->
		<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
		<!-- ChartJS -->
		<script src="<?= base_url('assets/plugins/chart.js/Chart.min.js') ?>"></script>
		<!-- Sparkline -->
		<script src="<?= base_url('assets/plugins/sparklines/sparkline.js') ?>"></script>
		<!-- JQVMap -->
		<script src="<?= base_url('assets/plugins/jqvmap/jquery.vmap.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') ?>"></script>
		<!-- jQuery Knob Chart -->
		<script src="<?= base_url('assets/plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
		<!-- daterangepicker -->
		<script src="<?= base_url('assets/plugins/moment/moment.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
		<!-- Summernote -->
		<script src="<?= base_url('assets/plugins/summernote/summernote-bs4.min.js') ?>"></script>
		<!-- overlayScrollbars -->
		<script src="<?= base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
		<!-- AdminLTE App -->
		<script src="<?= base_url('assets/dist/js/adminlte.js') ?>"></script>
		<!-- DataTables  & Plugins -->
		<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/jszip/jszip.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/pdfmake/pdfmake.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/pdfmake/vfs_fonts.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
		<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>

		<!-- Select2 -->
		<script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>

		<!-- Page specific script -->
		<script>
			$(function () {
				// DataTable initialization if exists
				if ($('.datatable').length) {
					$('.datatable').DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"language": {
							"url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
						}
					});
				}
			
				// Inicializar Select2 para selección múltiple si existe
				if ($('.select2').length) {
					$('.select2').select2({
						theme: 'bootstrap4',
						placeholder: "Seleccione una opción",
						allowClear: true
					});
				}
			
				// Mostrar el nombre del archivo seleccionado en el input file
				$('input[type="file"]').change(function(e) {
					if (e.target.files.length > 0) {
						var fileName = e.target.files[0].name;
						$(this).next('.custom-file-label').html(fileName);
					}
				});
			
				// Manejo de pestañas con hash en la URL (para la vista de perfil)
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
	</body>
</html>