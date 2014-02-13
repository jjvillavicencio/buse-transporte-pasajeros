<?php
extract($_POST);
extract($_GET);
$id=base64_decode($id);
include("../dll/conexionsql.php");
	/*Obtener los datos de db*/
	
	$sql="update usuarios set cedula='$idCed',nombreUsr='$usuario1',claveUsr=MD5('$contraseña1') where idUsuario='$id'";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Datos de Usuario actualizados.');
		window.location='../pages/addUsr.php'</script>";
	}else{
		echo "<script> alert('Error. Datos de Usuario no actualizados.');
		window.location='../pages/addUsr.php'</script>";
	}
	?>