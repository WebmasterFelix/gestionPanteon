<?php
	session_start();
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	$sql = "SELECT 
		c.categoria_id,
		c.categoria_nombre,
		con.concepto_id,
		con.codigo_sap,
		con.concepto_nombre,
		con.concepto_precio
	FROM 
		tc_categoria c
	INNER JOIN 
		tc_conceptos con ON c.categoria_id = con.categoria_id;";
	$result = $con->query($sql);

	$conceptos = array();
	
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if($_SESSION['is_admin']==1) {
				$botones='
					<button class="btn btn-warning btn-sm edit-btn" data-id="'.$row["concepto_id"].'" data-toggle="modal" data-target="#editarConcepto"><i class="fas fa-user-edit"></i></button>
					<button class="btn btn-danger btn-sm delete-btn" data-id="'.$row["concepto_id"].'"><i class="fas fa-trash"></i></button>
				';
			}else{
				$botones='';
			}
			
			$conceptos[] = array(
				'id' => $row['concepto_id'],
				'codigo' => $row['codigo_sap'],
				'nombre' => $row['concepto_nombre'],
				'categoria' => $row['categoria_nombre'],
				'monto' => $row['concepto_precio'],
				'acciones' => $botones
			);
		}
	}

	$con->close();

	header('Content-Type: application/json');
	echo json_encode($conceptos);
?>