<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id = intval($_POST['mod_id']);
		$nombre = $_POST['mod_nombre_categoria'];
		$sql = "UPDATE tc_categoria SET categoria_nombre=? WHERE categoria_id=?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("si", $nombre, $id);
		if ($stmt->execute()) {
			echo json_encode(['success' => true, 'message' => 'Categoría actualizada correctamente']);
		} else {
			echo json_encode(['success' => false, 'message' => $stmt->error]);
		}
		$stmt->close();
	} else {
		echo json_encode(['success' => false, 'message' => 'Método no permitido']);
	}
	$con->close();
?>