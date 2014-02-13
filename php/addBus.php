<?php 
	extract($_POST);
	/*Conexion al servidor de mysql*/
	include ('../dll/conexionsql.php');
		
	$sql="insert  into bus values('$numBus','$busCap','$anioBus','$modelBus','$placaBus','$numDisco','$rucSocio')";
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Bus agregado.');
		window.location='../pages/addBus.php'</script>";
	}else{
		echo "<script> alert('Error. Bus no agregado.');
		window.location='../pages/addBus.php'</script>";
	}
?>