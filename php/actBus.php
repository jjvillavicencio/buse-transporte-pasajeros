<?php
extract($_POST);
extract($_GET);
$id=base64_decode($id);
include("../dll/conexionsql.php");
	/*Obtener los datos de db*/
	
	$sql="update bus set numBus='$numBus',capacidad='$busCap', año='$anioBus',modelo='$modelBus', placa='$placaBus', numDisco='$numDisco',rucSocio='$rucSocio' WHERE numBus='$id'";

	if($ressql=mysql_query(utf8_decode($sql),$con)){
		echo "<script> alert('Datos actualizados');
		 window.location='../pages/addBus.php'</script>";
	}else{
		echo "<script> alert('Error. Datos no actualizados');
		 window.location='../pages/addBus.php'</script>";
	}
	?>