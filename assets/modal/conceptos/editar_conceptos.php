<div class="modal fade" id="editarConcepto">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="editarConceptoLabel"><i class="fa-solid fa-file-pen"></i> Editar Concepto</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="editar_concepto" name="editar_concepto">
					<div class="form-group">
						<label for="mod_codigo_sap">Código SAP</label>
						<input type="text" class="form-control" id="mod_codigo_sap" name="mod_codigo_sap" placeholder="Código SAP" required>
						<input type="hidden" id="mod_id" name="mod_id">
					</div>
					<div class="form-group">
						<label for="mod_nombre_concepto">Nombre del Concepto</label>
						<input type="text" class="form-control" id="mod_nombre_concepto" name="mod_nombre_concepto" placeholder="Nombre del Concepto" required>
					</div>
					<div class="form-group">
						<label for="mod_monto_concepto">Monto del Concepto</label>
						<input type="text" class="form-control" id="mod_monto_concepto" name="mod_monto_concepto" placeholder="Monto del Concepto" required>
					</div>
					<div class="form-group">
						<label for="mod_categoria_concepto">Categoría</label>
						<select class="form-control" id="mod_categoria_concepto" name="mod_categoria_concepto">
							<option>Seleccione una opción</option>
                        </select>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-success" id="actualizar_datos">Actualizar datos</button>
			</div>
				</form>
		</div>
	</div>
</div>