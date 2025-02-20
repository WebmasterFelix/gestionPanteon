<?php 
    include('is_logged.php');
    require_once("../config/db.php");
    require_once("../config/conexion.php");
    require_once("../clases/NumeroALetras.php");
    
    // Validar el parámetro de entrada
    $venta_id = filter_input(INPUT_GET, 'venta_id', FILTER_VALIDATE_INT);
    if (!$venta_id) {
        echo "<script>alert('Folio inválido.')</script>";
        echo "<script>window.close();</script>";
        exit;
    }
    
    // Verificar si existe la venta
    $stmt = $con->prepare("SELECT COUNT(*) as total FROM ventas WHERE venta_id = ?");
    $stmt->bind_param("i", $venta_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['total'] == 0) {
        echo "<script>alert('No hay ventas con este Folio: $venta_id')</script>";
        echo "<script>window.close();</script>";
        exit;
    }
    
    // Obtener detalles de la venta
    $stmt = $con->prepare("
        SELECT 
            ventas.venta_id,
            ventas.fecha,
            ventas.total,
            ventas.descuento,
            ventas.estado,
            ventas.titulo_descuento,
            tc_contribuyentes.contribuyente_nombre,
            tc_contribuyentes.contribuyente_domicilio,
            tc_contribuyentes.contribuyente_ciudad
        FROM 
            ventas
        JOIN 
            tc_contribuyentes ON ventas.contribuyente_id = tc_contribuyentes.contribuyente_id
        WHERE 
            ventas.venta_id = ?
    ");
    $stmt->bind_param("i", $venta_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rw = $result->fetch_assoc();

    // Variables de la venta
    $folio = $rw['venta_id'];
    $contribuyente = $rw['contribuyente_nombre'];
    $domicilio = $rw['contribuyente_domicilio'];
    $ciudad = $rw['contribuyente_ciudad'];
    $fechaCompleta = $rw['fecha'];
	// Separar la parte de la fecha y la hora
	//list($fecha, $hora) = explode(' ', $fechaCompleta);
	// Formatear la fecha
	list($año, $mes, $dia) = explode('-', $fechaCompleta);
	// Convertir el número del mes a su nombre en texto
	$meses = [ 
		'01' => 'Enero',
		'02' => 'Febrero',
		'03' => 'Marzo',
		'04' => 'Abril',
		'05' => 'Mayo',
		'06' => 'Junio',
		'07' => 'Julio',
		'08' => 'Agosto',
		'09' => 'Septiembre',
		'10' => 'Octubre',
		'11' => 'Noviembre',
		'12' => 'Diciembre'
	];
	
	$nombreMes = $meses[$mes];
	// Obtener los últimos dos dígitos del año
	$añoCorto = substr($año, -2);
	
    $total = $rw['total'];

    // Convertir total a letras
    $numALetras = new NumeroALetras();
	$total_letras = $numALetras->toInvoice($total, 2, 'M.N.');
    $total_formateado = '$' . number_format($total, 2);
    
	//Consultar conceptos
	$stmt_detalles = $con->prepare("
		SELECT 
			vd.detalle_id,
			vd.cantidad,
			vd.precio_unitario,
			vd.subtotal,
			c.concepto_nombre AS concepto
		FROM 
			venta_detalles vd
		JOIN 
			tc_conceptos c ON vd.concepto_id = c.concepto_id
		WHERE 
			vd.venta_id = ?
	");
	$stmt_detalles->bind_param("i", $venta_id);
	$stmt_detalles->execute();
	$result_detalles= $stmt_detalles->get_result();
	$rw_detalles = $result_detalles->fetch_assoc();
	
	$concepto=$rw_detalles['concepto'];
	
	
    // Datos para la plantilla
    $datosVenta = [
        'folio' => $folio,
        'contribuyente' => $contribuyente,
        'domicilio' => $domicilio,
        'ciudad' => $ciudad,
        'fecha' => "$dia/$mes/$año",
        'total' => $total_formateado,
        'total_letras' => $total_letras // Aquí agregamos el total en letras
    ];
    
    require_once dirname(__FILE__).'/../../vendor/autoload.php';
    
    use Spipu\Html2Pdf\Html2Pdf;
    use Spipu\Html2Pdf\Exception\Html2PdfException;
    use Spipu\Html2Pdf\Exception\ExceptionFormatter;
    
    try {
        // Validar si existe la plantilla HTML
        $plantilla = dirname(__FILE__) . '/pos_html/pos_html.php';
        if (!file_exists($plantilla)) {
            echo "Error: No se encontró la plantilla.";
            exit;
        }
        // Cargar contenido de la plantilla
        ob_start();
        include $plantilla;
        $content = ob_get_clean();
        
        $html2pdf = new Html2Pdf('P', 'A6', 'es', true, 'UTF-8', 3);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        
        // Salida del archivo PDF
        $html2pdf->output("venta_{$venta_id}.pdf", 'I'); // Mostrar en el navegador

    } catch (Html2PdfException $e) {
         $formatter = new ExceptionFormatter($e);
        error_log("Error generando PDF: " . $formatter->getHtmlMessage());
        echo "Ocurrió un error al generar el documento.";
    }
?>