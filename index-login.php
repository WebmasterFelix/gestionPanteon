<?php
	require_once("assets/config/app.php");
	require_once("assets/config/db.php");
	require_once("assets/clases/Login.php");
	
	$login = new Login();
	if ($login->isUserLoggedIn() == true) {
		header("location: dashboard.php");
	} else {
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Sistema de cobro de ingresos del DIF Municipal de Uriangato" />
		<meta name="author" content="LI. Félix Omar Ramírez Vázquez" />
		<title>Sistema de Ingresos | Iniciar Sesión</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/adminlte.css">
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<a href="dashboard.php"><b>Sistema</b> Ingresos</a>
			</div>
			<div class="card">
				<div class="card-body login-card-body">
					<p class="login-box-msg">Bienvenido</p>
					<?php
						if (isset($login)) {
							if ($login->errors) {	?>
								<div class="alert alert-danger alert-dismissible" role="alert">
									<strong>Error!</strong> 
									<?php 
										foreach ($login->errors as $error) {
											echo $error;
										}
									?>
								</div> <?php
							}
							if ($login->messages) {	?>
								<div class="alert alert-success alert-dismissible" role="alert">
									<strong>Aviso!</strong>
									<?php
										foreach ($login->messages as $message) {
											echo $message;
										}
									?>
								</div> <?php 
							}
						}
					?>
					<form action="index-login.php" method="post" autocomplete="off">
						<div class="input-group mb-3">
							<input type="text" class="form-control" name="user_usuario" id="user_usuario" placeholder="Usuario">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-envelope"></span>
								</div>
							</div>
						</div>
						<div class="input-group mb-3">
							<input type="password" class="form-control" name="user_password" id="user_password" placeholder="Contraseña">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
							</div>
							<div class="col-6">
								<button type="submit" name="login" id="submit" class="btn btn-primary btn-block">Sign In</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script src="assets/plugins/jquery/jquery.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/adminlte.js"></script>
	</body>
</html>
<?php	}	?>