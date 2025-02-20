<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	$sql = "SELECT * FROM tc_usuarios";
	$result = $con->query($sql);

	$usuarios = array();
	// Mapeo de roles
	$roles = array(
		1 => 'Administrador',
		2 => 'Contabilidad',
		3 => 'Operador'
	);
	
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$rol_nombre = isset($roles[$row['is_admin']]) ? $roles[$row['is_admin']] : 'Desconocido';
			$usuarios[] = array(
				'id' => $row['usuario_id'],
				'nombre' => $row['usuario_nombre'].' '.$row['usuario_apellido'],
				'usuario' => $row['usuario_usuario'],
				'rol' => $rol_nombre,
				'acciones' => '
					<button class="btn btn-warning btn-sm edit-btn" data-id="'.$row["usuario_id"].'" data-toggle="modal" data-target="#editarUsuario"><i class="fas fa-user-edit"></i></button>
					<button class="btn btn-info btn-sm passwd-btn" data-id="'.$row["usuario_id"].'" data-toggle="modal" data-target="#editarPasswd"><i class="fas fa-users-cog"></i></button>
					<button class="btn btn-danger btn-sm delete-btn" data-id="'.$row["usuario_id"].'"><i class="fas fa-trash"></i></button>'
			);
		}
	}

	$con->close();

	header('Content-Type: application/json');
	echo json_encode($usuarios);
?>