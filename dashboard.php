<?php
	require_once("assets/config/app.php");
	session_start();
	if (!isset($_SESSION['user_active_dif']) AND $_SESSION['user_active_dif'] != 1) {
		header("location: index-login.php");
		exit;
	}
	require_once ("assets/config/db.php");
	require_once ("assets/config/conexion.php");
	
	$title="Dashboard";
	$active_dashboard="active";
	$id_user=$_SESSION['user_id'];
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
						<?php
							include("assets/modal/caja/aperturaCaja.php");
						?>
						<div class="row">
							<?php
                                $today=date('Y-m-d');
                                $sql_caja=mysqli_query($con, "SELECT * FROM apertura_caja WHERE user_id='".$id_user."' AND fecha_apertura='".$today."'");
                                $count_caja=mysqli_num_rows($sql_caja);
                                if ($count_caja==0){
							?>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-info">
									<div class="inner">
										<h3>Apertura </h3>
										<p>de Caja</p>
									</div>
									<div class="icon">
										<i class="fa-solid fa-cash-register"></i>
									</div>
									<a data-toggle="modal" data-target="#aperturaCaja" style="cursor: default" class="small-box-footer">Abrir <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<?php
                               }else{
                            ?>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3>Realizar</h3>
										<p>Cobro</p>
									</div>
									<div class="icon">
										<i class="fa-solid fa-cash-register"></i>
									</div>
									<a href="pos.php" class="small-box-footer">Entrar <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<?php
                                }
                            ?>
						</div>
					</div>
				</section>
			</div>
			<?php include("inc/footer.php"); ?>
		</div>
		<?php include("inc/script.php"); ?>
		<script src="assets/plugins/sweetalert2/sweetalert2.js"></script>
		<script>
            $('#guardar_datos').on('click', function(e) {
				e.preventDefault();
				
				// Validar los datos del formulario
				let montoApertura = $('#monto_apertura').val();
				if (!montoApertura || isNaN(montoApertura) || montoApertura <= 0) {
					Swal.fire({
						icon: 'warning',
						title: 'Advertencia',
						text: 'Por favor, ingresa un monto de apertura válido.',
						showConfirmButton: true
					});
					return;
				}
				
				var formData = $('#apertura_caja').serialize();
				$.ajax({
					type: 'POST',
					url: './assets/ajax/caja/apertura_caja.php',
					data: formData,
					success: function(response) {
						var result = JSON.parse(response);
						if (result.success) {
							Swal.fire({
								icon: 'success',
								title: 'Éxito',
								text: result.message,
								showConfirmButton: true
							}).then(() => {
								// Ocultar modal y recargar la página
								$('#apertura_caja')[0].reset(); // Limpiar el formulario
								$('#aperturaCaja').modal('hide');
								location.reload(); // Recarga la página
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: result.message,
								showConfirmButton: true
							});
						}
					},
					error: function() {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Error en la solicitud',
							showConfirmButton: true
						});
					}
				});
			});
        </script>
	</body>
</html>