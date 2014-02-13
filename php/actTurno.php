<?php
extract($_POST);
extract($_GET);
$id=base64_decode($id);
include("../dll/conexionsql.php");
	/*Obtener los datos de db*/
	list($dia, $mes, $año) = split('[/.-]', $fecha);
	$fecha=$año."-".$mes."-".$dia;
	$sql="update turno set numBus='$numBus',idRuta='$idRuta', fecha='$fecha' WHERE idTurno='$id'";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Datos actualizados');
		 window.location='../pages/addTurno.php'</script>";
	}else{
		echo "<script> alert('Error. Datos no actualizados');
		 window.location='../pages/addTurno.php'</script>";
	}
	?>