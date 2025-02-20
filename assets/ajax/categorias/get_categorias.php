<?php
	session_start();
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	$sql = "SELECT * FROM tc_categoria";
	$result = $con->query($sql);

	$categorias = array();
	
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if($_SESSION['is_admin']==1) {
				$botones='
					<button class="btn btn-warning btn-sm edit-btn" data-id="'.$row["categoria_id"].'" data-toggle="modal" data-target="#editarCategoria"><i class="fas fa-user-edit"></i></button>
					<button class="btn btn-danger btn-sm delete-btn" data-id="'.$row["categoria_id"].'"><i class="fas fa-trash"></i></button>
				';
			}else{
				$botones='';
			}
			$categorias[] = array(
				'id' => $row['categoria_id'],
				'nombre' => $row['categoria_nombre'],
				'acciones' => $botones
			);
		}
	}

	$con->close();

	header('Content-Type: application/json');
	echo json_encode($categorias);
?>