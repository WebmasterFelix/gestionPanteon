<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id = intval($_POST['mod_id']);
		$codigo = $_POST['mod_codigo_sap'];
		$nombre = $_POST['mod_nombre_concepto'];
		$monto = $_POST['mod_monto_concepto'];
		$categoria = $_POST['mod_categoria_concepto'];
		
		$sql = "UPDATE tc_conceptos SET codigo_sap=?, categoria_id=?, concepto_nombre=?, concepto_precio=? WHERE concepto_id=?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("sissi", $codigo, $categoria, $nombre, $monto, $id);
		if ($stmt->execute()) {
			echo json_encode(['success' => true, 'message' => 'Concepto actualizado correctamente']);
		} else {
			echo json_encode(['success' => false, 'message' => $stmt->error]);
		}
		$stmt->close();
	} else {
		echo json_encode(['success' => false, 'message' => 'Método no permitido']);
	}
	$con->close();
?>