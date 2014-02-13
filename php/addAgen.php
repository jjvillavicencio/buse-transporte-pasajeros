<?php 
	extract($_POST);
	/*Conexion al servidor de mysql*/
	include ('../dll/conexionsql.php');
		
	$sql="insert  into agencia values('','$idCant','$dirAgen','$telfAgen','$selEmpr')";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Agencia agregada.');
		window.location='../pages/addAgencia.php'</script>";
	}else{
		echo "<script> alert('Error. Agencia no agregada.');
		window.location='../pages/addAgencia.php'</script>";
	}
?>