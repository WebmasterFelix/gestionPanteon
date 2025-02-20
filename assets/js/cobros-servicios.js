$(document).ready(function() {
    var table = $('#cobros').DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        columns: [
            { data: 'id' },
            { data: 'contribuyente'},
            { data: 'fecha'},
            { data: 'codigo'},
            { data: 'concepto'},
            { data: 'total'},
            { data: 'estatus'},
            { data: 'acciones', className: 'text-right no-export' }
        ],
        ajax: {
            url: './assets/ajax/cobros/get_cobos.php',
            dataSrc: function(json) {
                // Mostrar el total de activos en algún lugar de la interfaz
                $('#totalActivos').text('Total: $' + json.totalActivos.toFixed(2));
                return json.data; // Retornar solo los datos de las filas
            },
            data: function(d) {
                var fechaInicio = $('#fechaInicio').val();
                var fechaFin = $('#fechaFin').val();
                if (fechaInicio && fechaFin) {
                    d.fechaInicio = fechaInicio;
                    d.fechaFin = fechaFin;
                }
            }
        },
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Consultar',
                className: 'btn btn-info',
                action: function (e, dt, node, config) {
                    $('#fechaModal').modal('show');
                }
            },
            {
                extend: 'excelHtml5',
                text: 'Exportar a Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':not(.no-export)' // Exportar solo columnas visibles
                },
                filename: 'Reporte_Cobros',
                title: 'Reporte de Cobros',
				customize: function(xlsx) {
					var sheet = xlsx.xl.worksheets['sheet1.xml'];
					var rows = $('row', sheet);

					var total = 0;
					table.rows({ search: 'applied' }).data().each(function(data) {
						// Filtrar registros por estado y sumar solo si están activos
						if (data.estatus === 'activo') {
							var value = parseFloat(data.total.replace(/[^0-9.-]+/g, ''));
							total += isNaN(value) ? 0 : value;
						}
					});

					var lastRowIndex = rows.length + 1;
					$(sheet).find('sheetData').append(
						`<row r="${lastRowIndex}">
							<c t="inlineStr" r="A${lastRowIndex}">
								<is><t>TOTAL</t></is>
							</c>
							<c t="inlineStr" r="B${lastRowIndex}">
								<is><t>${total.toFixed(2)}</t></is>
							</c>
						</row>`
					);
				}
            },
            {
                extend: 'pdfHtml5',
                text: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':not(.no-export)' // Exportar solo columnas visibles
                },
                filename: 'Reporte_Cobros',
                title: 'Reporte de Cobros',
                orientation: 'landscape',
                pageSize: 'A4',
                customize: function(doc) {
                    // Estilos del título y encabezados
					doc.styles.title = {
						color: 'red',
						fontSize: '20',
						alignment: 'center'
					};
					doc.styles.tableHeader = {
						fillColor: '#4CAF50',
						color: 'white',
						alignment: 'center'
					};
					
					// Asegúrate de que los anchos coincidan con el número exacto de columnas
					//doc.content[1].table.widths = Array(7).fill('auto'); // Para anchos automáticos
					// O si prefieres mantener los porcentajes específicos:
					// doc.content[1].table.widths = ['5%', '25%', '15%', '10%', '20%', '15%', '10%'];
					//doc.content[1].table.widths = [30, 100, 60, 40, 80, 60, 40];
					doc.content[1].table.widths = ['5%', '25%', '15%', '10%', '20%', '15%', '10%'];
					//doc.content[1].table.widths = undefined;
					doc.content[1].table.widths = Array(7).fill('*');

					// Calcular el total directamente desde la tabla DataTable
					var total = 0;
					table.rows({ search: 'applied' }).data().each(function(data) {
						if (data.estatus === 'activo') {
							var value = parseFloat(data.total.replace(/[^0-9.-]+/g, ''));
							total += isNaN(value) ? 0 : value;
						}
					});

					// Agregar fila de total
					doc.content[1].table.body.push([
						{ text: 'TOTAL', colSpan: 5, alignment: 'right', bold: true },
						{}, {}, {}, {},
						{ text: total.toFixed(2), alignment: 'right', bold: true },
						{}  // Para la columna de estatus
					]);
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

    $('#formFechas').on('submit', function(event) {
        event.preventDefault();
        
        table.ajax.reload(); // Recarga los datos en la tabla con las nuevas fechas
        $('#fechaModal').modal('hide');
    });
    
    table.buttons().container().appendTo('#cobros_wrapper .col-md-6:eq(0)');
	
	//Cancelar Cobro
	$(document).on('click', '.cancel-btn', function() {
		var id = $(this).data('id');
		Swal.fire({
			title: '¿Estás seguro de que deseas cancelar este cobro?',
			text: "No podrá revertir esto",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, Cancelarlo'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: './assets/ajax/cobros/cancelar_cobro.php',
					type: 'POST',
					data: {id: id},
					dataType: 'json',
					success: function(response) {
						if (response.success) {
							Swal.fire({
								icon: 'success',
								title: 'Cancelado',
								text: response.message,
								showConfirmButton: true
							});
							$('#cobros').DataTable().ajax.reload();
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Error al cancelar el cobro: ' + (response.message || 'Error desconocido'),
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