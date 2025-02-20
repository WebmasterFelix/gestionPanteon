<?php
	//require_once("../is_logged.php");
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$user_id = intval($_POST['user_id']);
		$monto_apertura = $_POST['monto_apertura'];
		$hoy=date('Y-m-d');
		if ($user_id && $monto_apertura) {
			// Verificar si ya existe una apertura de caja para el usuario y la fecha actual
			$sql_verificar = "SELECT COUNT(*) AS total FROM apertura_caja WHERE user_id = ? AND fecha_apertura = ?";
			$stmt_verificar = $con->prepare($sql_verificar);
			if ($stmt_verificar) {
				$stmt_verificar->bind_param("is", $user_id, $hoy);
				$stmt_verificar->execute();
				$resultado = $stmt_verificar->get_result();
				$fila = $resultado->fetch_assoc();
				$stmt_verificar->close();

				if ($fila['total'] > 0) {
					echo json_encode(['success' => false, 'message' => 'Ya tienes una caja abierta para el día de hoy.']);
					exit;
				}
			} else {
				echo json_encode(['success' => false, 'message' => 'Error al verificar apertura de caja.']);
				exit;
			}	
				
			// Si no existe una caja abierta, procedemos a insertarla
			$sql_insertar = "INSERT INTO apertura_caja (user_id, monto_apertura, fecha_apertura) VALUES (?, ?, ?)";
			$stmt_insertar = $con->prepare($sql_insertar);
			if ($stmt_insertar) {
				$stmt_insertar->bind_param("ids", $user_id, $monto_apertura, $hoy);
				if ($stmt_insertar->execute()) {
					echo json_encode(['success' => true, 'message' => 'Apertura de caja registrada correctamente.']);
				} else {
					echo json_encode(['success' => false, 'message' => 'Error al registrar la apertura de caja.']);
				}
				$stmt_insertar->close();
			} else {
				echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta.']);
			}
		} else {
			echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
		}
	} else {
		echo json_encode(['success' => false, 'message' => 'Método no permitido']);
	}
	$con->close();
?>