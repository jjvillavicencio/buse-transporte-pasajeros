<?php 
	extract($_POST);
	/*Conexion al servidor de mysql*/
	include ('../dll/conexionsql.php');
		
	$sql="insert  into socio values('$rucSocio','$selEmpr','$cedula')";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Socio agregado.');
		window.location='../pages/addSocio.php'</script>";
	}else{
		echo "<script> alert('Error. Socio no agregado.');
		window.location='../pages/addSocio.php'</script>";
	}
?>