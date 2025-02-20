<!-- Modal para selección de fechas -->
<div class="modal fade" id="fechaModal" tabindex="-1" role="dialog" aria-labelledby="fechaModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="fechaModalLabel">Seleccionar Fecha de Inicio y Fin</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formFechas">
					<div class="form-group">
						<label for="fechaInicio">Fecha de Inicio:</label>
						<input type="date" class="form-control" id="fechaInicio" name="fechaInicio" value="<?php echo date('Y-m-d');?>" required>
					</div>
					<div class="form-group">
						<label for="fechaFin">Fecha de Fin:</label>
						<input type="date" class="form-control" id="fechaFin" name="fechaFin" value="<?php echo date('Y-m-d');?>" required>
					</div>
					<button type="submit" class="btn btn-success">Consultar</button>
				</form>
			</div>
		</div>
	</div>
</div>
