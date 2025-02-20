<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id = intval($_POST['user_id_mod']);
		$passwd_new = $_POST['user_password_new3'];
		$passwd_new_rep = $_POST['user_password_repeat3'];
		
		if($passwd_new === $passwd_new_rep){
			// Hash de la contraseña
			$password_hash = password_hash($passwd_new, PASSWORD_ARGON2ID);
			$sql = "UPDATE tc_usuarios SET usuario_password_hash=? WHERE usuario_id=?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("si", $password_hash, $id);
			if ($stmt->execute()) {
				echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
			} else {
				echo json_encode(['success' => false, 'message' => $stmt->error]);
			}
			$stmt->close();
		}else{
			echo json_encode(['success' => false, 'message' => 'Contraseñas no coinciden']);
		}
	} else {
		echo json_encode(['success' => false, 'message' => 'Método no permitido']);
	}
	$con->close();
?>