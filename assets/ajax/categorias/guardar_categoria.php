<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Sanitización y validación de datos
		$nombre = filter_input(INPUT_POST, 'nombre_categoria', FILTER_SANITIZE_STRING);

		if ($nombre) {
			$sql = "INSERT INTO tc_categoria (categoria_nombre) VALUES (?)";
			$stmt = $con->prepare($sql);
			if ($stmt) {
				$stmt->bind_param("s", $nombre);
				if ($stmt->execute()) {
					echo json_encode(['success' => true, 'message' => 'Categoría registrada correctamente']);
				} else {
					echo json_encode(['success' => false, 'message' => 'Error al registrar la categoría']);
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