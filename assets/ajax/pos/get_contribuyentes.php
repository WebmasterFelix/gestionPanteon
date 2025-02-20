<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	$query = "SELECT contribuyente_id, contribuyente_nombre, contribuyente_domicilio, contribuyente_ciudad 
          FROM tc_contribuyentes 
          WHERE contribuyente_estatus = 'activo'";
	$result = $con->query($query);

	$contribuyentes = [];
	if ($result) {
		while ($row = $result->fetch_assoc()) {
			$contribuyentes[] = $row;
		}
	}

	header('Content-Type: application/json');
	echo json_encode($contribuyentes);
?>