<?php
extract($_POST);
extract($_GET);
$id=base64_decode($id);
include("../dll/conexionsql.php");
$horaP=$horaPartida.':'.$minutosPartida;
$horaL=$horaLlegada.':'.$minutosLlegada;
	/*Obtener los datos de db*/
	
	$sql="update rutas set LugarPartida='$idCant',lugarLlegada='$idCant2',horaSalida='$horaP',horaLlegada='$horaL',idTipo='$idTipo',valor='$valor' WHERE idRuta='$id'";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Datos actualizados');
		 window.location='../pages/addRuta.php'</script>";
	}else{
		echo "<script> alert('Error. Datos no actualizados');
		 window.location='../pages/addRuta.php'</script>";
	}
	?>