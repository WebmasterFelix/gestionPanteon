<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
		$id = intval($_POST['id']);

		$sql = "DELETE FROM tc_usuarios WHERE usuario_id = ?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("i", $id);

		if ($stmt->execute()) {
			echo json_encode(['success' => true, 'message' => 'Usuario eliminado con éxito']);
		} else {
			echo json_encode(['success' => false, 'message' => $con->error]);
		}

		$stmt->close();
	} else {
		echo json_encode(['success' => false, 'message' => 'ID no proporcionado o método no permitido']);
	}
	$con->close();
?>