<div class="modal fade" id="nuevaCategoria">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="nuevaCategoriaLabel"><i class="fa-solid fa-file-circle-plus"></i> Agregar Categoría</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="guardar_categoria" name="guardar_categoria">
					<div class="form-group">
						<label for="nombre_categoria">Nombre Categoría</label>
						<input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" placeholder="Nombre Categoría" required>
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