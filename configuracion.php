<?php
	require_once("assets/config/app.php");
	session_start();
	if (!isset($_SESSION['user_active_dif']) AND $_SESSION['user_active_dif'] != 1) {
		header("location: index-login.php");
		exit;
	}
	$title="Configuración";
	$active_configuracion="active";
	$menu_configuracion="menu-open";
	$active_menu_configuracion="active";
	
	require_once ("assets/config/db.php");
	require_once ("assets/config/conexion.php");
	$query_config=mysqli_query($con,"SELECT * FROM tc_configuracion WHERE id_config='1'");
	$row_config=mysqli_fetch_array($query_config);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("inc/head.php"); ?>
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
					<div class="container-fluid">
						<div class="row">
							
							<section class="col-lg-4">
								<div class="card">
									<div class="card-header border-0" style="cursor: move;">
										<h3 class="card-title">
											<i class="fa-regular fa-image mr-1"></i>
											Imagen
										</h3>
									</div>
									<div class="card-body text-center"> 
										<div id="load_img1">
											<img class="img-account-profile rounded-circle mb-2" src="<?php echo $row_config['logo_url'];?>" alt="">
										</div>
                                        <div class="small font-italic text-muted mb-4">JPG o PNG de no más de 1 MB</div>
										<input class="filestyle" data-input="false" data-btnClass="btn-primary" type="file" name="imagefile1" id="imagefile1" onchange="upload_image1();">
									</div>
								</div>
								
								<div class="card">
									<div class="card-header border-0" style="cursor: move;">
										<h3 class="card-title">
											<i class="fa-solid fa-database mr-1"></i>
											Respaldo BD
										</h3>
									</div>
									<div class="card-body text-center"> 
										<a href="" class="btn btn-warning" onclick="generar_respaldo();">
											<i class="fa fa-download" aria-hidden="true"></i> Generar
										</a>
									</div>
								</div>
							</section>
							<section class="col-lg-8">
								<div class="card">
									<div class="card-body"> 
										<form method="post" id="configuracion" name="configuracion">
											<div class="mb-3">
												<label class="small mb-1" for="nombre_empresa">Nombre del Sistema</label>
												<input class="form-control" id="nombre_empresa" name="nombre_empresa" type="text" value="<?php echo $row_config['nombre_empresa']?>" required>
											</div>
											<div class="row gx-3 mb-3">
												<div class="col-md-6">
													<label class="small mb-1" for="dependencia">Dependencia</label>
													<input class="form-control" id="dependencia" name="dependencia" type="text" value="<?php echo $row_config['dependencia']?>" required>
												</div>
											</div>
											<button class="btn btn-success" type="submit" id="actualizar_datos"><i class="fas fa-save"></i> Guardad Cambios</button>
										</form>
									</div>
								</div>
							</section>
						</div>
					</div>
				</section>
			</div>
			<?php include("inc/footer.php"); ?>
		</div>
		<?php include("inc/script.php"); ?>
		<script src="assets/js/VentanaCentrada.js"></script>
		<script src="assets/js/bootstrap-filestyle.js"></script>
		<script src="assets/plugins/sweetalert2/sweetalert2.js"></script>
		<script src="assets/js/configuracion.js?v=<?php echo $version;?>"></script>
	</body>
</html>