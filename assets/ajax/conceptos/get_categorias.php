<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");	
	
	$sql = "SELECT categoria_id, categoria_nombre FROM tc_categoria";
	$result = $con->query($sql);

	$categories = array();
	while($row = $result->fetch_assoc()) {
		$categories[] = $row;
	}

	echo json_encode($categories);

	$con->close();
?>