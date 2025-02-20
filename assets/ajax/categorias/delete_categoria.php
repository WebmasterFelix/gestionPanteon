<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
		$id = intval($_POST['id']);
		
		// Validación: Verificar si existen conceptos asociados a la categoría
		$sql_check = "SELECT COUNT(*) FROM tc_conceptos WHERE categoria_id = ?";
		$stmt_check = $con->prepare($sql_check);
		$stmt_check->bind_param("i", $id);
		$stmt_check->execute();
		$stmt_check->bind_result($count);
		$stmt_check->fetch();
		$stmt_check->close();
		
		if ($count > 0) {
			echo json_encode(['success' => false, 'message' => 'No se puede eliminar la categoría. Existen conceptos asociados a ella.']);
		}else {
			$sql = "DELETE FROM tc_categoria WHERE categoria_id = ?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("i", $id);

			if ($stmt->execute()) {
				echo json_encode(['success' => true, 'message' => 'Categoría eliminada con éxito']);
			} else {
				echo json_encode(['success' => false, 'message' => $con->error]);
			}

			$stmt->close();
		}
	} else {
		echo json_encode(['success' => false, 'message' => 'ID no proporcionado o método no permitido']);
	}
	$con->close();
?>