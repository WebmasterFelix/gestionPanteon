<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id = intval($_POST['mod_id']);
		$nombre = $_POST['mod_firstname'];
		$apellido = $_POST['mod_lastname'];
		$usuario = $_POST['mod_user_usuario'];
		$rol = $_POST['mod_user_rol'];
		$sql = "UPDATE tc_usuarios SET usuario_nombre=?, usuario_apellido=?, usuario_usuario=?, is_admin=? WHERE usuario_id=?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("ssssi", $nombre, $apellido, $usuario, $rol, $id);
		if ($stmt->execute()) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => $stmt->error]);
		}
		$stmt->close();
	} else {
		echo json_encode(['success' => false, 'message' => 'Método no permitido']);
	}
	$con->close();
?>