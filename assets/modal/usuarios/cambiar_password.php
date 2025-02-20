<div class="modal fade" id="editarPasswd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="editarPasswdLabel"><i class='fa fa-edit'></i> Cambiar Contraseña</h4>
			</div>
			<div class="modal-body">
				<form method="post" id="editar_password" name="editar_password">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="user_password_new3">Nueva contraseña</label>
								<input type="password" class="form-control" id="user_password_new3" name="user_password_new3" placeholder="Nueva contraseña" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
								<input type="hidden" id="user_id_mod" name="user_id_mod">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="user_password_repeat3">Repite contraseña</label>
								<input type="password" class="form-control" id="user_password_repeat3" name="user_password_repeat3" placeholder="Repite contraseña" pattern=".{6,}" required>
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-success" id="actualizar_datos3">Cambiar contraseña</button>
			</div>
				</form>
		</div>
	</div>
</div>