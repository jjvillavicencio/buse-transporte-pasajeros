<?php
extract($_POST);
extract($_GET);
$id=base64_decode($id);
include("../dll/conexionsql.php");
	/*Obtener los datos de db*/
	
	$sql="update socio set rucSocio='$rucSocio',rucEmpresa='$selEmpr', cedulaPersona='$cedula' WHERE rucSocio='$id'";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Datos actualizados');
		 window.location='../pages/addSocio.php'</script>";
	}else{
		echo "<script> alert('Error. Datos no actualizados');
		 window.location='../pages/addSocio.php'</script>";
	}
	?>