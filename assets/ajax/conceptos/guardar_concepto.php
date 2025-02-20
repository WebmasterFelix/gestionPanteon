<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Sanitización y validación de datos
		$codigo = filter_input(INPUT_POST, 'codigo_sap', FILTER_SANITIZE_STRING);
		$nombre = filter_input(INPUT_POST, 'nombre_concepto', FILTER_SANITIZE_STRING);
		$monto = filter_input(INPUT_POST, 'monto_concepto', FILTER_SANITIZE_STRING);
		$categoria = filter_input(INPUT_POST, 'categoria_concepto', FILTER_SANITIZE_STRING);

		if ($nombre) {
			$sql = "INSERT INTO tc_conceptos (codigo_sap,categoria_id,concepto_nombre,concepto_precio) VALUES (?,?,?,?)";
			$stmt = $con->prepare($sql);
			if ($stmt) {
				$stmt->bind_param("siss", $codigo, $categoria, $nombre, $monto);
				if ($stmt->execute()) {
					echo json_encode(['success' => true, 'message' => 'Concepto registrado correctamente']);
				} else {
					echo json_encode(['success' => false, 'message' => 'Error al registrar el concepto']);
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