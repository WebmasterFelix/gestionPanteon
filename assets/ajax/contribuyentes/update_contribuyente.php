<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id = intval($_POST['mod_id']);
		$nombre = $_POST['mod_nombre_contribuyente'];
		$dimicilio = $_POST['mod_domicilio_contribuyente'];
		$ciudad = $_POST['mod_ciudad_contribuyente'];
		
		$sql = "UPDATE tc_contribuyentes SET contribuyente_nombre=?, contribuyente_domicilio=?, contribuyente_ciudad=? WHERE contribuyente_id=?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("sssi", $nombre, $dimicilio, $ciudad, $id);
		if ($stmt->execute()) {
			echo json_encode(['success' => true, 'message' => 'Contribuyente actualizado correctamente']);
		} else {
			echo json_encode(['success' => false, 'message' => $stmt->error]);
		}
		$stmt->close();
	} else {
		echo json_encode(['success' => false, 'message' => 'Método no permitido']);
	}
	$con->close();
?>