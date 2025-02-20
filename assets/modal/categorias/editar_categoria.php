<div class="modal fade" id="editarCategoria">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="editarCategoriaLabel"><i class="fa-solid fa-file-pen"></i> Editar Categoría</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="editar_categoria" name="editar_categoria">
					<div class="form-group">
						<label for="mod_nombre_categoria">Nombre Categoría</label>
						<input type="text" class="form-control" id="mod_nombre_categoria" name="mod_nombre_categoria" placeholder="Nombre Categoría" required>
						<input type="hidden" id="mod_id" name="mod_id">
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