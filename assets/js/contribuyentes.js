$(document).ready(function() {
	var table = $('#contribuyentes').DataTable({
		responsive: true,
		lengthChange: false,
		autoWidth: false,
		columns: [
			{ data: 'id' },
			{ data: 'nombre' },
			{ data: 'domicilio' },
			{ data: 'ciudad' },
			{ data: 'acciones', className: 'text-right' }
		],
		ajax: {
			url: './assets/ajax/contribuyentes/get_contribuyentes.php',
			dataSrc: ''
		},
		dom: 'Bfrtip',
		buttons: [
			{
				text: '<i class="fas fa-plus"></i> Agregar Contribuyente',
				className: 'btn btn-info',
				action: function (e, dt, node, config) {
					$('#nuevoContribuyente').modal('show');
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
	table.buttons().container().appendTo('#contribuyentes_wrapper .col-md-6:eq(0)');
	// Manejo del envío del formulario de nuevo usuario
	$('#guardar_datos').on('click', function(e) {
		e.preventDefault();
		var formData = $('#guardar_contribuyente').serialize();
		$.ajax({
			type: 'POST',
			url: './assets/ajax/contribuyentes/guardar_contribuyente.php',
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
					$('#contribuyentes').DataTable().ajax.reload();
					$('#guardar_contribuyente')[0].reset(); // Limpiar el formulario
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
	$('#editarContribuyente').on('hidden.bs.modal', function () {
		$(this).find('form')[0].reset();
	});
	// Usa la delegación de eventos
	$('#contribuyentes').on('click', '.edit-btn', function() {
		var id = $(this).data('id');
		
		// Limpia el formulario antes de cargar nuevos datos
		$('#editar_contribuyente')[0].reset();
		
		$.ajax({
			url: './assets/ajax/contribuyentes/get_contribuyente.php',
			type: 'POST',
			data: {id: id},
			dataType: 'json',
			success: function(response) {
				if (response.error) {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Error al obtener los datos del contribuyente',
						showConfirmButton: true
					});
					
				} else {
					// Rellena el formulario con los datos del contribuyente
					$('#mod_id').val(response.contribuyente_id );
					$('#mod_nombre_contribuyente').val(response.contribuyente_nombre);
					$('#mod_domicilio_contribuyente').val(response.contribuyente_domicilio);
					$('#mod_ciudad_contribuyente').val(response.contribuyente_ciudad);
					
					// Abre el modal
					$('#editarContribuyente').modal('show');
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
	$('#editar_contribuyente').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: './assets/ajax/contribuyentes/update_contribuyente.php',
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
					$('#contribuyentes').DataTable().ajax.reload();
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Error al actualizar el contribuyente: ' + result.message,
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
	$('#contribuyentes').on('click', '.delete-btn', function() {
		var id = $(this).data('id');
		Swal.fire({
			title: '¿Está seguro?',
			text: "No podrá revertir esto",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, eliminarla'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: './assets/ajax/contribuyentes/delete_contribuyente.php',
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
							$('#contribuyentes').DataTable().ajax.reload();
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Error al eliminar el contribuyente: ' + (response.message || 'Error desconocido'),
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