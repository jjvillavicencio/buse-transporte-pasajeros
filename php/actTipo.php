<?php
extract($_POST);
extract($_GET);
$id=base64_decode($id);
include("../dll/conexionsql.php");
	/*Obtener los datos de db*/
	
	$sql="update tipo set nombre='$tipViaj' WHERE idTipo='$id'";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Datos actualizados');
		 window.location='../pages/addTipo.php'</script>";
	}else{
		echo "<script> alert('Error. Datos no actualizados');
		 window.location='../pages/addTipo.php'</script>";
	}
	?>