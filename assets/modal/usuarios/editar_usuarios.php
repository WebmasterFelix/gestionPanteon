<div class="modal fade" id="editarUsuario">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="editarUsuarioLabel"><i class='fa fa-edit'></i> Editar usuario</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="editar_usuario" name="editar_usuario">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="mod_firstname">Nombres</label>
								<input type="text" class="form-control" id="mod_firstname" name="mod_firstname" placeholder="Nombres" required>
								<input type="hidden" id="mod_id" name="mod_id">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="mod_lastname">Apellidos</label>
								<input type="text" class="form-control" id="mod_lastname" name="mod_lastname" placeholder="Apellidos" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="mod_user_usuario">Usuario</label>
						<input type="text" class="form-control" id="mod_user_usuario" name="mod_user_usuario" placeholder="Usuario" required>
					</div>
					<div class="form-group">
						<label for="mod_user_rol">Rol</label>
						<select class="form-control" id="mod_user_rol" name="mod_user_rol">
							<option>Seleccione una opción</option>
							<option value="1">Administrador</option>
							<option value="2">Contabilidad</option>
							<option value="3">Operador</option>
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