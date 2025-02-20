<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	$sql = "SELECT * FROM tc_contribuyentes";
	$result = $con->query($sql);

	$contribuyentes = array();
	
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$contribuyentes[] = array(
				'id' => $row['contribuyente_id'],
				'nombre' => $row['contribuyente_nombre'],
				'domicilio' => $row['contribuyente_domicilio'],
				'ciudad' => $row['contribuyente_ciudad'],
				'acciones' => '
					<button class="btn btn-warning btn-sm edit-btn" data-id="'.$row["contribuyente_id"].'" data-toggle="modal" data-target="#editarContribuyente"><i class="fas fa-user-edit"></i></button>
					<button class="btn btn-danger btn-sm delete-btn" data-id="'.$row["contribuyente_id"].'"><i class="fas fa-trash"></i></button>'
			);
		}
	}

	$con->close();

	header('Content-Type: application/json');
	echo json_encode($contribuyentes);
?>