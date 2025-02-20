<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");
	
	$data = json_decode(file_get_contents('php://input'), true);
	$query = $data['query'] ?? '';

	if (!empty($query)) {
		// Búsqueda por nombre o categoría
		$stmt = $con->prepare("
			SELECT 
				concepto_id, 
				concepto_nombre, 
				concepto_precio 
			FROM 
				tc_conceptos 
			WHERE 
				concepto_nombre LIKE ? 
				OR categoria_id IN (SELECT categoria_id FROM tc_categoria WHERE categoria_nombre LIKE ?)
		");
		$likeQuery = "%$query%";
		$stmt->bind_param('ss', $likeQuery, $likeQuery);
	} else {
		// Si no hay búsqueda, muestra todos los conceptos
		$stmt = $con->prepare("
			SELECT 
				concepto_id, 
				concepto_nombre, 
				concepto_precio 
			FROM 
				tc_conceptos
		");
	}
	$stmt->execute();
	$result = $stmt->get_result();
	$conceptos = $result->fetch_all(MYSQLI_ASSOC);

	echo json_encode($conceptos);

?>