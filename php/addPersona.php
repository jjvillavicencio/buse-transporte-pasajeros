<?php 
	extract($_POST);
	extract($_GET);
	/*Conexion al servidor de mysql*/
	include('../dll/conexionsql.php');
	/*Obtener los datos de db*/
	
	$sql="insert  into persona values('$numCed1','$nombres1','$apellidos1','$dir1','$telf1','$mail')";	
	if($ressql=mysql_query(utf8_decode($sql),$con)){
		if(isset($act)){
			if($act=='boleto'){
			echo "<script> alert('Persona agregada.');
			window.location='../pages/addBoleto.php?ced=".$numCed1."';</script>";	
		}
		if($act=='encomienda'){
			echo "<script> alert('Persona agregada.');
			window.location='../pages/addPersona.php'</script>";			
		}

		}
		

		if(!isset($act)){
			echo "<script> alert('Persona agregada.');
			window.location='../pages/addPersona.php'</script>";			
		}
	}else{
		echo "<script> alert('Error. Persona no agregada.');
		window.location='../pages/addPersona.php'</script>";
	}
?>