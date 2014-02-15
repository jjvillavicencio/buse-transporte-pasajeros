<?php
include('../dll/zonahoraria.php');
extract($_POST);
extract($_GET);
$fecha=base64_decode($fecha);
/*Conexion al servidor de mysql*/
	include ('../dll/conexionsql.php');
	$hora=date("G").":".date("i").":".date("s");
	$sql2="SELECT idUsuario,idAgencia FROM sesiones";
	$ressql1=mysql_query($sql2,$con);
$totdatos=mysql_num_rows($ressql1);
if($totdatos>0){
    while($row=mysql_fetch_array($ressql1)){
    	$agencia=$row[1];
    	$usuario=$row[0];
    }
}
	$sql="insert  into factura values('$numFac','$ced','$agencia','$usuario','$fecha','$hora','0','0','0')";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Factura Creada.');
		window.location='../pages/addBoleto.php?numFact=".$numFac."&cedula=".$ced."'</script>";
	}else{
		echo "<script> alert('Error. Factura no creada.');
		window.location='../pages/addBoleto.php'</script>";
	}
?>