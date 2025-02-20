<div class="modal fade" id="nuevoUsuario">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="nuevoUsuarioLabel"><i class='fa fa-edit'></i> Agregar Nuevo Usuario</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="guardar_usuario" name="guardar_usuario">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="firstname">Nombres</label>
								<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Nombres" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="lastname">Apellidos</label>
								<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Apellidos" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="user_usuario">Usuario</label>
						<input type="text" class="form-control" id="user_usuario" name="user_usuario" placeholder="Usuario" required>
					</div>
					<div class="form-group">
						<label for="user_rol">Rol</label>
						<select class="form-control" id="user_rol" name="user_rol">
							<option>Seleccione una opción</option>
							<option value="1">Administrador</option>
							<option value="2">Contabilidad</option>
							<option value="3">Operador</option>
                        </select>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="user_password_new">Contraseña</label>
								<input type="password" class="form-control" id="user_password_new" name="user_password_new" placeholder="Contraseña" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="user_password_repeat">Repite contraseña</label>
								<input type="password" class="form-control" id="user_password_repeat" name="user_password_repeat" placeholder="Repite contraseña" pattern=".{6,}" required>
							</div>
						</div>
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