<div class="modal fade" id="nuevoConcepto">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="nuevoUsuarioLabel"><i class="fa-solid fa-file-circle-plus"></i> Agregar Concepto</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="guardar_concepto" name="guardar_concepto">
					<div class="form-group">
						<label for="codigo_sap">Código SAP</label>
						<input type="text" class="form-control" id="codigo_sap" name="codigo_sap" placeholder="Código SAP" required>
					</div>
					<div class="form-group">
						<label for="nombre_concepto">Nombre del Concepto</label>
						<input type="text" class="form-control" id="nombre_concepto" name="nombre_concepto" placeholder="Nombre del Concepto" required>
					</div>
					<div class="form-group">
						<label for="monto_concepto">Monto del Concepto</label>
						<input type="text" class="form-control" id="monto_concepto" name="monto_concepto" placeholder="Monto del Concepto" required>
					</div>
					<div class="form-group">
						<label for="categoria_concepto">Categoría</label>
						<select class="form-control" id="categoria_concepto" name="categoria_concepto">
							<option>Seleccione una opción</option>
                        </select>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-success" id="guardar_datos">Guardar Datos</button>
			</div>
				</form>
		</div>
	</div>
</div>