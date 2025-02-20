$(document).ready(function() {
	var table = $('#categorias').DataTable({
		responsive: true,
		lengthChange: false,
		autoWidth: false,
		columns: [
			{ data: 'id' },
			{ data: 'nombre' },
			{ data: 'acciones', className: 'text-right' }
		],
		ajax: {
			url: './assets/ajax/categorias/get_categorias.php',
			dataSrc: ''
		},
		dom: 'Bfrtip',
		buttons: [
			{
				text: '<i class="fas fa-plus"></i> Agregar Categoría',
				className: 'btn btn-info',
				action: function (e, dt, node, config) {
					$('#nuevaCategoria').modal('show');
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
	table.buttons().container().appendTo('#categorias_wrapper .col-md-6:eq(0)');
	// Manejo del envío del formulario de nuevo usuario
	$('#guardar_datos').on('click', function(e) {
		e.preventDefault();
		var formData = $('#guardar_categoria').serialize();
		$.ajax({
			type: 'POST',
			url: './assets/ajax/categorias/guardar_categoria.php',
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
					$('#categorias').DataTable().ajax.reload();
					$('#guardar_categoria')[0].reset(); // Limpiar el formulario
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
	$('#editarCategoria').on('hidden.bs.modal', function () {
		$(this).find('form')[0].reset();
	});
	// Usa la delegación de eventos
	$('#categorias').on('click', '.edit-btn', function() {
		var id = $(this).data('id');
		
		// Limpia el formulario antes de cargar nuevos datos
		$('#editar_categoria')[0].reset();
		
		$.ajax({
			url: './assets/ajax/categorias/get_categoria.php',
			type: 'POST',
			data: {id: id},
			dataType: 'json',
			success: function(response) {
				if (response.error) {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Error al obtener los datos de la categoría',
						showConfirmButton: true
					});
					
				} else {
					// Rellena el formulario con los datos del categoría
					$('#mod_id').val(response.categoria_id );
					$('#mod_nombre_categoria').val(response.categoria_nombre);
					
					// Abre el modal
					$('#editarCategoria').modal('show');
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
	$('#editar_categoria').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: './assets/ajax/categorias/update_categoria.php',
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
					$('#categorias').DataTable().ajax.reload();
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Error al actualizar la categoría: ' + result.message,
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
	$('#categorias').on('click', '.delete-btn', function() {
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
					url: './assets/ajax/categorias/delete_categoria.php',
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
							$('#categorias').DataTable().ajax.reload();
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Error al eliminar la categoría: ' + (response.message || 'Error desconocido'),
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