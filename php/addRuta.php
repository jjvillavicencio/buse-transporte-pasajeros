<?php 
	extract($_POST);
	/*Conexion al servidor de mysql*/
	include ('../dll/conexionsql.php');
		$hora1=$horaPartida.":".$minutosPartida.":00";
		$hora2=$horaLlegada.":".$minutosLlegada.":00";
	$sql="insert  into rutas values('','$idCant','$idCant2','$hora1','$hora2','$idTipo','$valor')";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Ruta agregada.');
		window.location='../pages/addRuta.php'</script>";
	}else{
		echo "<script> alert('Error. Ruta no agregada.');
		window.location='../pages/addRuta.php'</script>";
	}
?>