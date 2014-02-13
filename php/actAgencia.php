<?php
extract($_POST);
extract($_GET);
$id=base64_decode($id);
include("../dll/conexionsql.php");
	/*Obtener los datos de db*/
	
	$sql="update agencia set idCanton='$idCant',direccion='$dirAgen', telefono='$telfAgen',rucEmpresa='$selEmpr' WHERE idAgencia='$id'";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Datos actualizados');
		 window.location='../pages/addAgencia.php'</script>";
	}else{
		echo "<script> alert('Error. Datos no actualizados');
		 window.location='../pages/addAgencia.php'</script>";
	}
	?>