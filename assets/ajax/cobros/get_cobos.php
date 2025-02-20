<?php
    require_once("../../config/db.php");
    require_once("../../config/conexion.php");

    // Obtener las fechas desde los parámetros de la solicitud
    $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
    $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

    // Modificar la consulta SQL para incluir el filtro de fechas
    $sql = "SELECT 
        ventas.venta_id,
        ventas.fecha,
        ventas.total,
        ventas.descuento,
        ventas.estado,
        ventas.titulo_descuento,
        tc_contribuyentes.contribuyente_nombre,
        tc_contribuyentes.contribuyente_domicilio,
        tc_contribuyentes.contribuyente_ciudad,
		tc_conceptos.codigo_sap,
		tc_conceptos.concepto_nombre,
		venta_detalles.cantidad,
		venta_detalles.precio_unitario,
		venta_detalles.subtotal
    FROM 
        ventas
    JOIN 
		tc_contribuyentes ON ventas.contribuyente_id = tc_contribuyentes.contribuyente_id
	JOIN 
		venta_detalles ON ventas.venta_id = venta_detalles.venta_id
	JOIN 
		tc_conceptos ON venta_detalles.concepto_id = tc_conceptos.concepto_id
    WHERE 
        ventas.fecha BETWEEN '$fechaInicio' AND '$fechaFin';"; // Agrega el filtro de fechas
        
    $result = $con->query($sql);

    $conceptos = array();
    
	$totalActivos = 0;
	
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Solo suma el total si el estado es "activo"
			if ($row['estado'] === 'activo') {
				$totalActivos += $row['total'];
			}
			
			$conceptos[] = array(
                'id' => $row['venta_id'],
                'contribuyente' => $row['contribuyente_nombre'],
                'fecha' => date('d/m/Y', strtotime($row['fecha'])),
                'codigo' => $row['codigo_sap'],
                'concepto' => $row['concepto_nombre'],
                'total' => $row['total'],
                'estatus' => $row['estado'],
                'acciones' => ($row['estado'] === 'activo') 
					? '<button class="btn btn-danger btn-sm cancel-btn" data-id="'.$row["venta_id"].'"><i class="fas fa-times"></i> Cancelar</button>'
					: '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-ban"></i> Cancelado</button>'
            );
        }
    }

    $con->close();

    header('Content-Type: application/json');
	echo json_encode([
		'data' => $conceptos,
		'totalActivos' => $totalActivos // Incluir la sumatoria como parte de la respuesta
	]);
?>