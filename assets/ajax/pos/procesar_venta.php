<?php
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");
	
	require_once dirname(__FILE__).'/../../../vendor/autoload.php';
	
	use Spipu\Html2Pdf\Html2Pdf;
	use Spipu\Html2Pdf\Exception\Html2PdfException;
	use Spipu\Html2Pdf\Exception\ExceptionFormatter;
	
	header('Content-Type: application/json');

	try {
		// Iniciar transacción
		mysqli_begin_transaction($con);

		// Recibir datos del POST
		$data = json_decode(file_get_contents('php://input'), true);

		// Validar datos
		if (empty($data['contribuyente_id']) || empty($data['conceptos'])) {
			throw new Exception('Datos de venta incompletos');
		}

		// Preparar inserción de venta
		//$sql_venta = "INSERT INTO ventas (contribuyente_id, total, descuento) VALUES (?, ?, ?)";
		$sql_venta = "INSERT INTO ventas (contribuyente_id, total, descuento, titulo_descuento) VALUES (?, ?, ?, ?)";
		$stmt_venta = mysqli_prepare($con, $sql_venta);
		mysqli_stmt_bind_param($stmt_venta, "idds", 
			$data['contribuyente_id'], 
			$data['total'], 
			$data['descuento'],
			$data['titulo_descuento']
		);
		
		if (!mysqli_stmt_execute($stmt_venta)) {
			throw new Exception('Error al insertar venta: ' . mysqli_error($con));
		}
		
		$venta_id = mysqli_insert_id($con);

		// Preparar inserción de detalles
		$sql_detalle = "INSERT INTO venta_detalles (venta_id, concepto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)";
		$stmt_detalle = mysqli_prepare($con, $sql_detalle);

		// Insertar cada concepto
		foreach ($data['conceptos'] as $concepto) {
			$subtotal = $concepto['cantidad'] * $concepto['precio'];
			mysqli_stmt_bind_param($stmt_detalle, "iiddd", 
				$venta_id, 
				$concepto['id'], 
				$concepto['cantidad'], 
				$concepto['precio'], 
				$subtotal
			);
			
			if (!mysqli_stmt_execute($stmt_detalle)) {
				throw new Exception('Error al insertar detalle: ' . mysqli_error($con));
			}
		}

		// Confirmar transacción
		mysqli_commit($con);

		echo json_encode([
			'success' => true, 
			'message' => 'Venta procesada exitosamente', 
			'venta_id' => $venta_id
		]);

	} catch (Exception $e) {
		// Revertir transacción en caso de error
		mysqli_rollback($con);

		echo json_encode([
			'success' => false, 
			'message' => 'Error al procesar venta: ' . $e->getMessage()
		]);
	}

	// Cerrar declaraciones y conexión
	if (isset($stmt_venta)) mysqli_stmt_close($stmt_venta);
	if (isset($stmt_detalle)) mysqli_stmt_close($stmt_detalle);
	mysqli_close($con);
?>