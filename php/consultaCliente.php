<?php 

$var1 = $_POST['variable1'];
 include("../dll/conexionsql.php");

$resultado=mysql_query("SELECT * FROM persona WHERE cedula='$var1'"); 
if($registro=mysql_fetch_row($resultado)){
// Array con las respuestas
$respuesta['c1'] = $registro[0];
$respuesta['c2'] = $registro[1];
$respuesta['c3'] = $registro[2];
$respuesta['c4'] = $registro[3];
$respuesta['c5'] = $registro[4];
$respuesta['c6'] = $registro[5];
 
echo json_encode($respuesta);	// Enviar la respuesta al cliente en formato JSON
}else{
	$respuesta['c1']="no hay";
	echo json_encode($respuesta);
}
?>