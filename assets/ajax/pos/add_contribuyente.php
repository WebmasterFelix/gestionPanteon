<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Sanitización y validación de datos
		$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
		$domicilio = filter_input(INPUT_POST, 'domicilio', FILTER_SANITIZE_STRING);
		$ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_STRING);
		
		if (empty($nombre)) {
			echo json_encode(['success' => false, 'message' => 'El nombre es obligatorio.']);
			exit;
		}
		
		$sql = "INSERT INTO tc_contribuyentes (contribuyente_nombre,contribuyente_domicilio,contribuyente_ciudad) VALUES (?,?,?)";
		$stmt = $con->prepare($sql);
		if ($stmt) {
			$stmt->bind_param("sss", $nombre, $domicilio, $ciudad);
			if ($stmt->execute()) {
				echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
			} else {
				echo json_encode(['success' => false, 'message' => 'Error al registrar el contribuyente']);
			}
			$stmt->close();
		} else {
			echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
		}
	}else {
		echo json_encode(['success' => false, 'message' => 'Método no permitido']);
	}
	$con->close();
?>