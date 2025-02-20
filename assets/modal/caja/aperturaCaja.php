<?php	
	if (isset($con)){	
	date_default_timezone_set('America/Mexico_City');
	$hoy=date('Y-m-d'); 
?>
<div class="modal fade" id="aperturaCaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header bg-warning">
				<h5 class="modal-title" id="exampleModalLabel">Apertura de Caja</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form class="form-horizontal" method="post" id="apertura_caja" name="apertura_caja">
                    <div id="resultados_ajax"></div>
					
					<div class="form-group text-center">
						<img src="assets/img/icono-caja-registradora.png" class="img-thumbnail" alt="..."><br>
						<label for="monto_apertura" class="control-label">Monto de Apertura</label>
						<input type="text" class="form-control" id="monto_apertura" name="monto_apertura" required>
				        <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $id_user;?>" required>
			        </div>
					<div class="form-group text-center">
						<label for="fecha_inicio" class="control-label">Fecha</label>
						<input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $hoy; ?>" readonly>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cerrar</button>
				<button type="submit" class="btn btn-success" id="guardar_datos"><i class="fas fa-sign-in-alt"></i> Aperturar Caja </button>
                </form>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>