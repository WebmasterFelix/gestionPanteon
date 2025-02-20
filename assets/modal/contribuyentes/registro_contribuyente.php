<div class="modal fade" id="nuevoContribuyente">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="nuevoContribuyenteLabel"><i class="fa-solid fa-file-circle-plus"></i> Agregar Contribuyente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="guardar_contribuyente" name="guardar_contribuyente">
					<div class="form-group">
						<label for="nombre_contribuyente">Nombre</label>
						<input type="text" class="form-control" id="nombre_contribuyente" name="nombre_contribuyente" placeholder="Nombre" required>
					</div>
					<div class="form-group">
						<label for="domicilio_contribuyente">Domicilio</label>
						<input type="text" class="form-control" id="domicilio_contribuyente" name="domicilio_contribuyente" placeholder="Domicilio" required>
					</div>
					<div class="form-group">
						<label for="ciudad_contribuyente">Ciudad</label>
						<input type="text" class="form-control" id="ciudad_contribuyente" name="ciudad_contribuyente" placeholder="Ciudad" required>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-success" id="guardar_datos">Guardar datos</button>
			</div>
				</form>
		</div>
	</div>
</div>