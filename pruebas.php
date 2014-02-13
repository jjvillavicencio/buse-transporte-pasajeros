<?php
$numeros = array();
for ($i=1; $i < 11; $i++) { 
	array_push($numeros, $i);
}
print_r($numeros);
?>


function asientos(){
    	$("#idTurno option:selected").each(function () {
    		elegido=$(this).val();
    		$.post("../php/retornaTurnos.php?opc=3", { elegido: elegido }, function(data){
    			$("#c10").html(data);
    		});            
    	});
    }




    case 3:
	$numTurno=$elegido;
	$cantidad=0;
	$sql="SELECT bus.capacidad
	FROM bus
	INNER JOIN turno 
	ON bus.numBus = turno.numBus
	WHERE turno.idTurno =".$numTurno;
	$ressql=mysql_query($sql,$con);
	$totdatos=mysql_num_rows($ressql);
	if($totdatos>0){
		while($row=mysql_fetch_array($ressql)){
			$cantidad=row[0];
		}
	}else{
		echo "No hay datos";
	}
	$asientosUsados=array();
	$sql="SELECT  numAsiento FROM boleto WHERE idTurno =".$numTurno;
	$ressql=mysql_query($sql,$con);
	$totdatos=mysql_num_rows($ressql);
	if($totdatos>0){
		while($row=mysql_fetch_array($ressql)){
			array_push($asientosUsados, $row[0]);
		}
	}else{
		echo "No hay datos";
	}
	$numeros = array();
	for ($i=1; $i < $cantidad; $i++) { 
		array_push($numeros, $i);
	}
	
	$vacios=array_diff($numeros, $asientosUsados)
	echo '<option value="null" selected=""> Seleccione</option>';
	foreach ($vacios as $libre) {
		echo "<option value=\"".$libre."\">".$libre."</option>";
	}

	break;