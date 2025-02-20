<?php
	//require_once("../is_logged.php");
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$nombre_empresa = $_POST['nombre_empresa'];
		$dependencia = $_POST['dependencia'];
		$id=1;
		
		$sql = "UPDATE tc_configuracion SET nombre_empresa=?, dependencia=?  WHERE id_config=?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("ssi", $nombre_empresa, $dependencia , $id);
		
		if ($stmt->execute()) {
			echo json_encode(['success' => true, 'message' => 'Configuración actualizada correctamente']);
		} else {
			echo json_encode(['success' => false, 'message' => $stmt->error]);
		}
		$stmt->close();
		
	} else {
		echo json_encode(['success' => false, 'message' => 'Método no permitido']);
	}
	$con->close();
?>