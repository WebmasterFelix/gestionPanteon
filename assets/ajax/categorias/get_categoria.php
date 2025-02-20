<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
		
		$sql = "SELECT * FROM tc_categoria WHERE categoria_id = ?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			echo json_encode($row);
		} else {
			echo json_encode(['error' => 'Categoría no encontrada']);
		}

		$stmt->close();
	} else {
		echo json_encode(['error' => 'ID no proporcionado']);
	}

	$con->close();
?>