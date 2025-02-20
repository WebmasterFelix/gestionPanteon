<?php
	//require_once("../is_logged.php");
	require_once("../../config/db.php");
	require_once("../../config/conexion.php");
	
	if (isset($_FILES["imagefile1"])){
		$target_dir="../../img/";
		$image_name = time()."_".basename($_FILES["imagefile1"]["name"]);
		$target_file = $target_dir . $image_name;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$imageFileZise=$_FILES["imagefile1"]["size"];
				
		if(($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) and $imageFileZise>0) {
			$errors[]= "<p>Lo sentimos, sólo se permiten archivos JPG , JPEG, PNG y GIF.</p>";
		} else if ($imageFileZise > 1048576) {//1048576 byte=1MB
			$errors[]= "<p>Lo sentimos, pero el archivo es demasiado grande. Selecciona logo de menos de 1MB</p>";
		} else{				
			if ($imageFileZise>0){
				move_uploaded_file($_FILES["imagefile1"]["tmp_name"], $target_file);
				$logo_update="logo_url='assets/img/$image_name'";
			
			} else { $logo_update="";}
			
			$sql = "UPDATE tc_configuracion SET $logo_update WHERE id_config='1';";
			$query_new_insert = mysqli_query($con,$sql);
			
			if ($query_new_insert) {	?>
				<img class="img-account-profile rounded-circle mb-2" src="assets/img/<?php echo $image_name;?>" alt="Logo"><?php
			} else {
				$errors[] = "Lo sentimos, actualización falló. Intente nuevamente. ".mysqli_error($con);
			}
		}
	}		
	
	if (isset($errors)){	?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Error! </strong><?php
			foreach ($errors as $error){
				echo $error;
			}	?>
		</div>	<?php
	}
?>