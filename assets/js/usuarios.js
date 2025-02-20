$(document).ready(function() {
	var table = $('#usuarios').DataTable({
		responsive: true,
		lengthChange: false,
		autoWidth: false,
		columns: [
			{ data: 'id' },
			{ data: 'nombre' },
			{ data: 'usuario' },
			{ data: 'rol' },
			{ data: 'acciones', className: 'text-right' }
		],
		ajax: {
			url: './assets/ajax/usuarios/get_usuarios.php',
			dataSrc: ''
		},
		dom: 'Bfrtip',
		buttons: [
			{
				text: '<i class="fas fa-plus"></i> Agregar Usuario',
				className: 'btn btn-info',
				action: function (e, dt, node, config) {
					$('#nuevoUsuario').modal('show');
				}
			}
		],
		language: {
			"sProcessing": "Procesando...",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "No hay datos disponibles en esta tabla",
			"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix": "",
			"sSearch": "Buscar:",
			"sUrl": "",
			"sInfoThousands": ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst": "Primero",
				"sLast": "Último",
				"sNext": "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}
	});
	table.buttons().container().appendTo('#clientes_wrapper .col-md-6:eq(0)');
	// Manejo del envío del formulario de nuevo usuario
	$('#guardar_datos').on('click', function(e) {
		e.preventDefault();
		var formData = $('#guardar_usuario').serialize();
		$.ajax({
			type: 'POST',
			url: './assets/ajax/usuarios/guardar_usuario.php',
			data: formData,
			success: function(response) {
				var result = JSON.parse(response);
				if (result.success) {
					Swal.fire({
						icon: 'success',
						title: 'Éxito',
						text: result.message,
						showConfirmButton: true
					});
					$('#usuarios').DataTable().ajax.reload();
					$('#guardar_usuario')[0].reset(); // Limpiar el formulario
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: result.message,
						showConfirmButton: true
					});
				}
			},
			error: function() {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Error en la solicitud',
					showConfirmButton: true
				});
			}
		});
	});
	// Limpia el modal cuando se cierra
	$('#editarUsuario').on('hidden.bs.modal', function () {
		$(this).find('form')[0].reset();
	});
	// Usa la delegación de eventos
	$('#usuarios').on('click', '.edit-btn', function() {
		var id = $(this).data('id');
		
		// Limpia el formulario antes de cargar nuevos datos
		$('#editar_usuario')[0].reset();
		
		$.ajax({
			url: './assets/ajax/usuarios/get_usuario.php',
			type: 'POST',
			data: {id: id},
			dataType: 'json',
			success: function(response) {
				//console.log('Respuesta del servidor:', response);
				if (response.error) {
					//console.error('Error retrieving product data:', response.error);
					alert('Error al obtener los datos del usuario');
				} else {
					// Rellena el formulario con los datos del usuario
					$('#mod_id').val(response.usuario_id );
					$('#mod_firstname').val(response.usuario_nombre);
					$('#mod_lastname').val(response.usuario_apellido);
					$('#mod_user_usuario').val(response.usuario_usuario);
					$('#mod_user_rol').val(response.is_admin );
					
					// Abre el modal
					$('#editarUsuario').modal('show');
				}
			},
			error: function(xhr, status, error) {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Error en la solicitud AJAX',
					showConfirmButton: true
				});
			}
		});
	});
	// Manejo del envío del formulario de edición
	$('#editar_usuario').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: './assets/ajax/usuarios/update_usuario.php',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function(result) {
				if (result.success) {
					Swal.fire({
						icon: 'success',
						title: 'Éxito',
						text: result.message,
						showConfirmButton: true
					});
					$('#usuarios').DataTable().ajax.reload();
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Error al actualizar el usuario: ' + result.message,
						showConfirmButton: true
					});
				}
			},
			error: function(xhr, status, error) {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Error en la solicitud AJAX',
					showConfirmButton: true
				});
			}
		});
	});
	//Manejo del botón de actualizar contraseña
	$('#usuarios').on('click', '.passwd-btn', function() {
		var id = $(this).data('id');
		
		// Limpia el formulario antes de cargar nuevos datos
		$('#editar_password')[0].reset();
		
		$.ajax({
			url: './assets/ajax/usuarios/get_usuario.php',
			type: 'POST',
			data: {id: id},
			dataType: 'json',
			success: function(response) {
				if (response.error) {
					alert('Error al obtener los datos del usuario');
				} else {
					// Rellena el formulario con los datos del usuario
					$('#user_id_mod').val(response.usuario_id );
					// Abre el modal
					$('#editarPasswd').modal('show');
				}
			},
			error: function(xhr, status, error) {
				alert('Error en la solicitud AJAX');
			}
		});
	});
	// Manejo del envío del formulario de cambiar contraseña
	$('#editar_password').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: './assets/ajax/usuarios/update_passwd.php',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function(response) {
				if (response.success) {
					Swal.fire({
						icon: 'success',
						title: 'Éxito',
						text: response.message,
						showConfirmButton: true
					});
					$('#usuarios').DataTable().ajax.reload();
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Error al actualizar el usuario: ' + response.message,
						showConfirmButton: true
					});
				}
			},
			error: function(xhr, status, error) {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Error en la solicitud AJAX',
					showConfirmButton: true
				});
			}
		});
	});
	// Manejo del botón de eliminar
	$('#usuarios').on('click', '.delete-btn', function() {
		var id = $(this).data('id');
		Swal.fire({
			title: '¿Está seguro?',
			text: "No podrá revertir esto",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, eliminarlo'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: './assets/ajax/usuarios/delete_usuario.php',
					type: 'POST',
					data: {id: id},
					dataType: 'json',
					success: function(response) {
						if (response.success) {
							Swal.fire({
								icon: 'success',
								title: 'Eliminado',
								text: response.message,
								showConfirmButton: true
							});
							$('#usuarios').DataTable().ajax.reload();
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Error al eliminar el usuario: ' + (response.message || 'Error desconocido'),
								showConfirmButton: true
							});
						}
					},
					error: function(xhr, status, error) {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Error en la solicitud AJAX: ' + error + '\nStatus: ' + status + '\nRespuesta: ' + xhr.responseText,
							showConfirmButton: true
						});
					}
				});
			}
		});
	});
});