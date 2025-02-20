<?php
	require_once("assets/config/app.php");
	session_start();
	if (!isset($_SESSION['user_active_dif']) AND $_SESSION['user_active_dif'] != 1) {
		header("location: index-login.php");
		exit;
	}
	require_once ("assets/config/db.php");
	require_once ("assets/config/conexion.php");
	
	$title="Cobro Servicios";
	$active_cobros="active";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("inc/head.php"); ?>
		<link rel="stylesheet" href="assets/plugins/sweetalert2/sweetalert2.css">
		<style>
			.search-container {
				position: relative;
				width: 100%;
				max-width: 600px;
				margin: auto;
			}

			#search-input {
				width: 100%;
				padding: 10px;
				font-size: 16px;
				border: 1px solid #ccc;
				border-radius: 4px;
			}

			#search-list {
				position: absolute;
				top: 100%;
				left: 0;
				width: 100%;
				background: #fff;
				border: 1px solid #ccc;
				border-radius: 4px;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
				max-height: 300px;
				overflow-y: auto;
				z-index: 1000;
			}

			#search-list ul {
				list-style: none;
				margin: 0;
				padding: 0;
			}

			#search-list ul li {
				padding: 10px;
				border-bottom: 1px solid #eee;
				cursor: pointer;
			}

			#search-list ul li:hover {
				background: #f0f0f0;
			}

			.create-product-btn {
				width: 100%;
				padding: 10px;
				border: none;
				background: #007bff;
				color: #fff;
				cursor: pointer;
				border-radius: 4px;
				font-size: 16px;
			}

			.create-product-btn:hover {
				background: #0056b3;
			}

			.hidden {
				display: none;
			}
			
			.list-group-container {
				max-height: 600px; /* Ajusta la altura máxima según lo que necesites */
				overflow-y: auto; /* Activa el scroll vertical */
			}
		</style>
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
							<section class="col-lg-6">
								<div class="card h-100">
									<div class="card-header border-0">
										<h2 class="card-title">
											<i class="fa-solid fa-magnifying-glass"></i>
											Buscar Productos
										</h2>
									</div>
									<div class="card-body">
										<div class="input-group mb-3">
											<div class="search-container">
												<input type="text" id="search-input" placeholder="Buscar por nombre, categoría, SKU o código de barras" autocomplete="off" style="cursor: pointer" />
												<div id="search-list" class="hidden" style="cursor: pointer">
													<ul></ul>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-6 col-12" data-toggle="modal" data-target="#contribuyentesModal" style="cursor: pointer">
												<div class="info-box">
													<span class="info-box-icon bg-info"><i class="fa-solid fa-user"></i></span>
													<div class="info-box-content">
														<span class="info-box-text" style="font-size:17px">Añadir Contribuyente</span>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-12" data-toggle="modal" data-target="#descuentosModal" style="cursor: pointer">
												<div class="info-box">
													<span class="info-box-icon bg-success"><i class="fa-solid fa-tag"></i></span>
													<div class="info-box-content">
														<span class="info-box-text" style="font-size:17px">Añadir Descuento</span>
													</div>
												</div>
											</div>
											<?php
												include("assets/modal/pos/contribuyentes.php");
												include("assets/modal/pos/nuevo_contribuyente.php");
												include("assets/modal/pos/descuentos.php");
											?>
										</div>
									</div>
								</div>
							</section>
							<section class="col-lg-6">
								<div class="card h-100">
									<div class="card-header border-0">
										<div class="d-flex justify-content-between">
											<h2 class="card-title">Conceptos</h2>
											<a href="#" class="btn btn-danger" id="vaciar-carrito"><i class="fa-solid fa-trash"></i> Vaciar Carrito</a>
										</div>
									</div>
									<div class="card-body">
										<div class="callout callout-danger">
											<h5><span id="carrito-contribuyente">Ninguno Contribuyente</span></h5>
										</div>
										<table id="carrito" class="table table-bordered">
											<thead>
												<tr>
													<th style="width:40%">Nombre</th>
													<th>Precio</th>
													<th>Cantidad</th>
													<th>Total</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tbody>
												<!-- Productos seleccionados se agregarán aquí -->
											</tbody>
										</table>
									</div>
									<div class="card-footer">
										<div class="callout callout-info d-none" id="descuento-aplicado">
											<h5><span>Descuento de: </span></h5>
											<button id="eliminar-descuento" class="btn btn-sm btn-danger">Eliminar Descuento</button>
										</div>
										<div class="d-flex justify-content-between align-items-center mt-3">
											<h4>Total:</h4>
											<h4>$0.00</h4>
										</div>
										<button id="procesar-venta" class="btn btn-success btn-block mt-3">Procesar Venta</button>
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
		<script src="assets/plugins/sweetalert2/sweetalert2.js"></script>
		<script src="assets/js/VentanaCentrada.js"></script>
		<script src="assets/js/pos.js?v=<?php echo $version;?>"></script>
	</body>
</html>