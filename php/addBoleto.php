<?php 
	include("../dll/zonahoraria.php");
	extract($_POST);
	extract($_GET);
	echo $numFac;
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
	$sql="insert  into boleto values('','$numFac','$cedula','$idTurno','$asiento')";
	
	
	if($ressql=mysql_query($sql,$con)){
		if($mas==0){
			echo "<script> alert('Boleto agregado.');
			window.location='../pages/genFactura.php?numFact=".$numFac."'</script>";
		}else{
				echo "<script> alert('Boleto agregado.');
			window.location='../pages/addBoleto.php?numFact=".$numFac."'</script>";
		}
	}else{
		echo $sql;
		die();
		echo "<script> alert('Error. boleto no agregado.');
		window.location='../pages/addBoleto.php?numFac=<?php $numFac?>'</script>";
	}
?>