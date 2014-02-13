<?php 
	include("../dll/zonahoraria.php");
	extract($_POST);
	/*Conexion al servidor de mysql*/
	include ('../dll/conexionsql.php');
	$fecha=date("Y")."-".date("m")."-".date("d");
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
	$sql="insert  into boleto values('','$cedula','$fecha','$hora','$idTurno','$agencia','$usuario','$asiento')";
	
	
	if($ressql=mysql_query($sql,$con)){
		echo "<script> alert('Turno agregado.');
		window.location='../pages/addBoleto.php'</script>";
	}else{
		die();
		echo "<script> alert('Error. Turno no agregado.');
		window.location='../pages/addBoleto.php'</script>";
	}
?>