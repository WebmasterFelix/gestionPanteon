<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if (isset($_POST['id'])) {
		$id = intval($_POST['id']); // Sanitizar el ID recibido

		// Verifica si el cobro existe
		$query = $con->prepare("SELECT estado FROM ventas WHERE venta_id = ?");
		$query->bind_param("i", $id);
		$query->execute();
		$result = $query->get_result();

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			if ($row['estado'] === 'activo') {
				// Cambiar el estado a "cancelado"
				$update = $con->prepare("UPDATE ventas SET estado = 'cancelado' WHERE venta_id = ?");
				$update->bind_param("i", $id);
				if ($update->execute()) {
					echo json_encode(['success' => true, 'message' => 'Cobro cancelado exitosamente.']);
				} else {
					echo json_encode(['success' => false, 'message' => 'Error al cancelar el cobro.']);
				}
			} else {
				echo json_encode(['success' => false, 'message' => 'El cobro ya está cancelado o no es válido.']);
			}
		} else {
			echo json_encode(['success' => false, 'message' => 'El cobro no existe.']);
		}
	} else {
		echo json_encode(['success' => false, 'message' => 'ID no proporcionado.']);
	}
?>
