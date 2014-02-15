<?php 
	extract($_POST);
	/*Conexion al servidor de mysql*/
	include ('../dll/conexionsql.php');
	$sql="insert  into rutas values('','$idCant','$idCant2')";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Ruta agregada.');
		window.location='../pages/addRuta.php'</script>";
	}else{
		echo "<script> alert('Error. Ruta no agregada.');
		window.location='../pages/addRuta.php'</script>";
	}
?>