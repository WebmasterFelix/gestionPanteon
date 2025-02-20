function generar_respaldo(){
	VentanaCentrada('./myphp-backup.php','Generar Respaldo','','950','250','true');
}

$('#configuracion').on('submit', function(event) {
	event.preventDefault();
	$.ajax({
		url: './assets/ajax/configuracion/update_configuracion.php',
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
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Error al actualizar los datos de configuración: ' + result.message,
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

function upload_image1(){
	var inputFileImage = document.getElementById("imagefile1");
	var file = inputFileImage.files[0];
	if( (typeof file === "object") && (file !== null) ){
		$("#load_img1").text('Cargando...');	
		var data = new FormData();
		data.append('imagefile1',file);
		$.ajax({
			url: "./assets/ajax/configuracion/imagen_ajax.php",
			type: "POST",
			data: data, 	
			contentType: false,
			cache: false,  
			processData:false,
			success: function(data){
				$("#load_img1").html(data);
			}
		});	
	}
}