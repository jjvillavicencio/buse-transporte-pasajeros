<?php 
	extract($_POST);
	/*Conexion al servidor de mysql*/
	include ('../dll/conexionsql.php');
		
	$sql="insert  into tipo values('','$tipViaj')";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Tipo de viaje agregado.');
		window.location='../pages/addTipo.php'</script>";
	}else{
		echo "<script> alert('Error. Tipo de viaje no agregado.');
		window.location='../pages/addTipo.php'</script>";
	}
?>