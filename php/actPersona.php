<?php
extract($_POST);
extract($_GET);
$id=base64_decode($id);
include("../dll/conexionsql.php");
	/*Obtener los datos de db*/
	
	$sql="update persona set cedula='$numCed1',Nombres='$nombres1', Apellidos='$apellidos1', direccion='$dir1', telefono='$telf1', correo='$mail' WHERE cedula='$id'";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Datos actualizados');
		 window.location='../pages/addPersona.php'</script>";
	}else{
		echo "<script> alert('Error. Datos no actualizados');
		 window.location='../pages/addPersona.php'</script>";
	}
	?>