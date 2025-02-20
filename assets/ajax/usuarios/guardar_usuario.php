<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Sanitización y validación de datos
		$nombre = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
		$apellidos = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
		$usuario = filter_input(INPUT_POST, 'user_usuario', FILTER_SANITIZE_EMAIL);
		$rol = filter_input(INPUT_POST, 'user_rol', FILTER_SANITIZE_STRING);
		$passwd_new = filter_input(INPUT_POST, 'user_password_new', FILTER_SANITIZE_STRING);
		$passwd_new_rep = filter_input(INPUT_POST, 'user_password_repeat', FILTER_SANITIZE_STRING);
		$date_added = date("Y-m-d H:i:s");
		
		if ($nombre && $apellidos && $usuario && $rol && $passwd_new) {
			if($passwd_new === $passwd_new_rep){
				$password_hash = password_hash($passwd_new, PASSWORD_ARGON2ID);
				$sql = "INSERT INTO tc_usuarios (usuario_nombre, usuario_apellido, usuario_password_hash, usuario_usuario, is_admin, date_added) VALUES (?, ?, ?, ?, ?, ?)";
				$stmt = $con->prepare($sql);
				if ($stmt) {
					$stmt->bind_param("ssssss", $nombre, $apellidos, $password_hash, $usuario, $rol, $date_added);
					if ($stmt->execute()) {
						echo json_encode(['success' => true, 'message' => 'Usuario registrado correctamente']);
					} else {
						echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario']);
					}
					$stmt->close();
				} else {
					echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
				}
			}else{
				echo json_encode(['success' => false, 'message' => 'Contraseñas no coinciden']);
			}
			
		} else {
			echo json_encode(['success' => false, 'message' => 'Datos inválidos o contraseñas no coinciden']);
		}
	} else {
		echo json_encode(['success' => false, 'message' => 'Método no permitido']);
	}
	$con->close();
?>