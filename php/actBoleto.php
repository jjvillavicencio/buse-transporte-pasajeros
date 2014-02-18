<?php
extract($_POST);
extract($_GET);
$numBol=base64_decode($numBol);
$numFac=base64_decode($numFac);
include("../dll/conexionsql.php");
	/*Obtener los datos de db*/
	
	$sql="update boleto set cedulaCliente='$cedula',idTurno='$idTurno', numAsiento='$asiento' WHERE numBoleto='$numBol'";

	if($ressql=mysql_query(utf8_decode($sql),$con)){
		
		echo "<script> alert('Datos actualizados');
		 window.location='../pages/genFactura.php?numFact=".base64_encode($numFac)."'</script>";
	}else{
		echo "<script> alert('Error. Datos no actualizados');
		 window.location='../pages/genFactura.php?numFact=".base64_encode($numFac)."'</script>";
	}
	?>