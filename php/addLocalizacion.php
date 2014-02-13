<?php
extract($_GET);
extract($_POST);
include("../dll/conexionsql.php");
if($opc==1){
	$sql="insert  into pais values('','$nombPais')";
	$ressql=mysql_query($sql,$con);
	echo "<script> window.location='../pages/addLocali.php'</script>";
}
if($opc==2){
	$sql="insert  into provincia values('','$nombProv','$selPais')";
	$ressql=mysql_query($sql,$con);
	echo "<script> window.location='../pages/addLocali.php'</script>";
}
if($opc==3){
	$sql="insert  into canton values('','$idProv','$nombCant')";
	$ressql=mysql_query($sql,$con);
	echo "<script> window.location='../pages/addLocali.php'</script>";
}

?>