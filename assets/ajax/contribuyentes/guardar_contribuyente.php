<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Sanitización y validación de datos
		$nombre = filter_input(INPUT_POST, 'nombre_contribuyente', FILTER_SANITIZE_STRING);
		$domicilio = filter_input(INPUT_POST, 'domicilio_contribuyente', FILTER_SANITIZE_STRING);
		$ciudad = filter_input(INPUT_POST, 'ciudad_contribuyente', FILTER_SANITIZE_STRING);

		if ($nombre && $domicilio && $ciudad) {
			$sql = "INSERT INTO tc_contribuyentes (contribuyente_nombre,contribuyente_domicilio,contribuyente_ciudad) VALUES (?,?,?)";
			$stmt = $con->prepare($sql);
			if ($stmt) {
				$stmt->bind_param("sss", $nombre, $domicilio, $ciudad);
				if ($stmt->execute()) {
					echo json_encode(['success' => true, 'message' => 'Contribuyente registrado correctamente']);
				} else {
					echo json_encode(['success' => false, 'message' => 'Error al registrar el contribuyente']);
				}
				$stmt->close();
			} else {
				echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
			}
		} else {
			echo json_encode(['success' => false, 'message' => 'Datos inválidos o contraseñas no coinciden']);
		}
	} else {
		echo json_encode(['success' => false, 'message' => 'Método no permitido']);
	}
	$con->close();
?>