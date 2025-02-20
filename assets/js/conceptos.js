$(document).ready(function() {
	var table = $('#conceptos').DataTable({
		responsive: true,
		lengthChange: false,
		autoWidth: false,
		columns: [
			{ data: 'id' },
			{ data: 'codigo' },
			{ data: 'nombre' },
			{ data: 'categoria' },
			{ data: 'monto' },
			{ data: 'acciones', className: 'text-right' }
		],
		ajax: {
			url: './assets/ajax/conceptos/get_conceptos.php',
			dataSrc: ''
		},
		dom: 'Bfrtip',
		buttons: [
			{
				text: '<i class="fas fa-plus"></i> Agregar Concepto',
				className: 'btn btn-info',
				action: function (e, dt, node, config) {
					$('#nuevoConcepto').modal('show');
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
	table.buttons().container().appendTo('#conceptos_wrapper .col-md-6:eq(0)');
	
	// Función para obtener categorías del servidor
    function fetchCategories() {
        $.ajax({
            url: './assets/ajax/conceptos/get_categorias.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var select = $('#categoria_concepto');
                select.empty();
                select.append('<option value="">Seleccione una opción</option>');

                $.each(response, function(index, category) {
                    select.append('<option value="' + category.categoria_id + '">' + category.categoria_nombre + '</option>');
                });
            },
            error: function(error) {
                console.error('Error fetching categories:', error);
                // Gestionar el error, por ejemplo, mostrar un mensaje de error al usuario
            }
        });
    }

    // Llamar a la función de búsqueda de categorías al cargar la página
    fetchCategories();
	
	// Manejo del envío del formulario de nuevo usuario
	$('#guardar_datos').on('click', function(e) {
		e.preventDefault();
		var formData = $('#guardar_concepto').serialize();
		$.ajax({
			type: 'POST',
			url: './assets/ajax/conceptos/guardar_concepto.php',
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
					$('#conceptos').DataTable().ajax.reload();
					$('#guardar_concepto')[0].reset(); // Limpiar el formulario
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
	$('#editarConcepto').on('hidden.bs.modal', function () {
		$(this).find('form')[0].reset();
	});
	// Usa la delegación de eventos
	$('#conceptos').on('click', '.edit-btn', function() {
		var id = $(this).data('id');
		// Limpia el formulario antes de cargar nuevos datos
		$('#editar_concepto')[0].reset();
		$.ajax({
			url: './assets/ajax/conceptos/get_concepto.php',
			type: 'POST',
			data: {id: id},
			dataType: 'json',
			success: function(response) {
				if (response.error) {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Error al obtener los datos del concepto',
						showConfirmButton: true
					});
					
				} else {
					// Rellena el formulario con los datos del categoría
					$('#mod_id').val(response.concepto_id);
					$('#mod_codigo_sap').val(response.codigo_sap);
					$('#mod_nombre_concepto').val(response.concepto_nombre);
					$('#mod_monto_concepto').val(response.concepto_precio);
					$('#mod_categoria_concepto').val(response.categoria_id);
					
					// Abre el modal
					$('#editarConcepto').modal('show');
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
	// Función para obtener categorías del servidor
    function fetchModCategories() {
        $.ajax({
            url: './assets/ajax/conceptos/get_categorias.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var select = $('#mod_categoria_concepto');
                select.empty();
                select.append('<option value="">Seleccione una opción</option>');

                $.each(response, function(index, category) {
                    select.append('<option value="' + category.categoria_id + '">' + category.categoria_nombre + '</option>');
                });
            },
            error: function(error) {
                console.error('Error fetching categories:', error);
                // Gestionar el error, por ejemplo, mostrar un mensaje de error al usuario
            }
        });
    }
    // Llamar a la función de búsqueda de categorías al cargar la página
    fetchModCategories();
	// Manejo del envío del formulario de edición
	$('#editar_concepto').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: './assets/ajax/conceptos/update_concepto.php',
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
					$('#conceptos').DataTable().ajax.reload();
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Error al actualizar el concepto: ' + result.message,
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
	$('#conceptos').on('click', '.delete-btn', function() {
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
					url: './assets/ajax/conceptos/delete_concepto.php',
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
							$('#conceptos').DataTable().ajax.reload();
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Error al eliminar el concepto: ' + (response.message || 'Error desconocido'),
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