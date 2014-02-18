<?php 
/*Conexion al servidor de mysql*/
include("../dll/conexionsql.php");
extract($_GET);
if(!isset($bandera)){
	/*Obtener los datos de db*/
	$sql="SELECT b.numBoleto, b.cedulaCliente,per.Nombres,per.Apellidos, t.numBus, t.fecha, t.horaSalida, tip.nombre,t.valor  from boleto b
INNER JOIN turno t
ON t.idTurno = b.idTurno
INNER JOIN tipo tip
ON t.tipo = tip.idTipo
INNER JOIN persona per
ON b.cedulaCliente = per.cedula
WHERE numFactura=".$numFact;
$subTotal=0;
$iva=1.12;
$total=0;
	$ressql=mysql_query($sql,$con);
	$totdatos=mysql_num_rows($ressql);
	if($totdatos>0){
		while ($row=mysql_fetch_array($ressql)) {
			echo "<tr>";
			echo "<td>1</td>";
			echo "<td>".$row[0]."| ".$row[1]."| ".$row[2]." ".$row[3]."| N° Bus: ".$row[4]."| ".$row[5]."| ".$row[6]."| ".$row[7]."| "."</td>";
			echo "<td>".$row['valor']."</td>";
			echo "<td>".$row['valor']."</td>";
			if(!isset($visua)){
			echo "<td>
					<a href='actBoleto.php?id=".base64_encode($row[0])."&numFac=".$numFact."'>
						<i class='icon-pencil'></i>
					</a>
				</td>";
			echo "<td>
					<a href='../php/listarDetalle.php?id=".base64_encode($row[0])."&bandera=1&numFact=".$numFact."'>
						<i class='icon-trash'></i>
					</a>
				</td>";
			}
			$subTotal = $subTotal + $row['valor'];
			echo "</tr>";	
	
			}
	if(!isset($visua)){
	$total=$iva*$subTotal;
	$iva=$total-$subTotal;

	$sql2="update factura set subTotal='$subTotal', iva='$iva', total='$total' WHERE idFactura='$numFact'";
	
	
	$ressql=mysql_query($sql2,$con);
}
}else{
	echo "No hay datos!!";
}
}else{
	if($bandera==1){
		$id=base64_decode($id);
		$sql="delete from boleto where numBoleto='$id'";
		if($ressql=mysql_query($sql,$con)){
			echo "<script>alert ('Boleto eliminado');
			window.location='../pages/genFactura.php?numFact=".$numFact."';</script>";		
		}else{
			echo "<script>alert ('Error. Boleto no eliminada (En Uso)');
			window.location='../pages/genFactura.php?numFact=".$numFact."';</script>";
		}

	}
}

mysql_close($con);
?>