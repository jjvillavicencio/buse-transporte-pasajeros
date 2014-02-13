<?php 
	extract($_POST);
	/*Conexion al servidor de mysql*/
	include ('../dll/conexionsql.php');
	list($dia, $mes, $año) = split('[/.-]', $fecha);
	$fecha=$año."-".$mes."-".$dia;
	$sql="insert  into turno values('','$numBus','$idRuta','$fecha')";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Turno agregado.');
		window.location='../pages/addTurno.php'</script>";
	}else{
		echo "<script> alert('Error. Turno no agregado.');
		window.location='../pages/addTurno.php'</script>";
	}
?>