<?php
	require_once("assets/config/app.php");
	session_start();
	if (!isset($_SESSION['user_active_dif']) AND $_SESSION['user_active_dif'] != 1) {
		header("location: index-login.php");
		exit;
	}
	
	$title="Contribuyentes";
	$active_contribuyentes="active";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("inc/head.php"); ?>
		<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
		<link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
		<link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.css">
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php include("inc/navbar.php"); ?>
			<?php include("inc/sidebar.php"); ?>
			<div class="content-wrapper">
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1><?php echo $title; ?></h1>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
								</ol>
							</div>
						</div>
					</div>
				</section>
				<section class="content">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Contribuyentes</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
								<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
									<i class="fas fa-times"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<table id="contribuyentes" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th width="10%">#</th>
										<th width="30%">Nombre</th>
										<th width="20%">Domicilio</th>
										<th width="20%">Ciudad</th>
										<th width="20%" class="text-right">Acciones</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
							<?php
								include("assets/modal/contribuyentes/registro_contribuyente.php");
								include("assets/modal/contribuyentes/editar_contribuyente.php");
							?>
						</div>
					</div>
				</section>
			</div>
			<?php include("inc/footer.php"); ?>
		</div>
		<?php include("inc/script.php"); ?>
		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
		<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
		<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
		<script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
		<script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
		<script src="assets/plugins/jszip/jszip.min.js"></script>
		<script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
		<script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
		<script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
		<script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
		<script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
		<script src="assets/plugins/sweetalert2/sweetalert2.js"></script>
		<script src="assets/js/contribuyentes.js?v=<?php echo $version;?>"></script>
	</body>
</html>