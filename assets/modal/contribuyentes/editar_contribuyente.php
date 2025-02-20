<div class="modal fade" id="editarContribuyente">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="editarContribuyenteLabel"><i class="fa-solid fa-file-pen"></i> Editar Contribuyente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="editar_contribuyente" name="editar_contribuyente">
					<div class="form-group">
						<label for="mod_nombre_contribuyente">Nombre</label>
						<input type="text" class="form-control" id="mod_nombre_contribuyente" name="mod_nombre_contribuyente" placeholder="Nombre" required>
						<input type="hidden" id="mod_id" name="mod_id">
					</div>
					<div class="form-group">
						<label for="mod_domicilio_contribuyente">Domicilio</label>
						<input type="text" class="form-control" id="mod_domicilio_contribuyente" name="mod_domicilio_contribuyente" placeholder="Domicilio" required>
					</div>
					<div class="form-group">
						<label for="mod_ciudad_contribuyente">Ciudad</label>
						<input type="text" class="form-control" id="mod_ciudad_contribuyente" name="mod_ciudad_contribuyente" placeholder="Ciudad" required>
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