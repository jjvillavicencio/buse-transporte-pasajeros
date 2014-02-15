<?php
include("../dll/conexionsql.php");

extract($_POST);
extract($_GET);
switch ($opc) {
	case 1:
	list($dia, $mes, $año) = split('[/.-]', $fecha);
	$fecha=$año."-".sprintf("%02s",$mes)."-".sprintf("%02s",$dia);
	$sql="SELECT turno.idTurno,c1.nombre AS partida,c2.nombre AS llegada 
	FROM turno
	INNER JOIN rutas 
	ON turno.idRuta = rutas.idRuta
	INNER JOIN	canton  c1
	ON rutas.LugarPartida = c1.idCanton 
	INNER JOIN	canton  c2
	ON rutas.lugarLlegada = c2.idCanton
	WHERE turno.fecha =\"".$fecha."\" AND c1.idCanton=".$elegido;
	$ressql=mysql_query($sql,$con);
	$totdatos=mysql_num_rows($ressql);
	if($totdatos>0){
		echo '<option value="null" selected=""> Seleccione</option>';
		while($row=mysql_fetch_array($ressql)){
			echo "<option value=\"".$row[0]."\">".$row[1]." - ".$row[2]."</option>";
		}
	}else{
		echo '<option value="null" selected="">'.$sql.' </option>';

	}
	break;
	case 2:
		$var=$variable;
		$var2=$varia;
		$sql="SELECT turno.numBus,turno.idRuta,turno.fecha,tipo.nombre,turno.horaSalida AS partida, turno.valor 
		FROM turno 
		INNER JOIN	tipo 
		ON turno.tipo = tipo.idTipo 
		WHERE turno.idTurno =".$var;
		$ressql=mysql_query($sql,$con);
		$totdatos=mysql_num_rows($ressql);
		if($totdatos>0){
			while($row=mysql_fetch_array($ressql)){
				$respuesta['c1'] = $row[0];
				$respuesta['c2'] = $row[4];
				$respuesta['c3'] = $row[3];
				$respuesta['c4'] = $row[5];
				echo json_encode($respuesta);
			}
		}else{
			$respuesta['c1']=$sql;
			echo json_encode($respuesta);

		}


	break;

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
				$cantidad=$row[0];
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
		for ($i=1; $i <= $cantidad; $i++) { 
			array_push($numeros, $i);
		}
		
		$vacios=array_diff($numeros, $asientosUsados);
		echo '<option value="null" selected=""> Seleccione</option>';
		foreach ($vacios as $libre) {
			echo "<option value=\"".$libre."\">".$libre."</option>";
		}
		
		
		break;
	
	
	default:
		# code...
	break;
}




?>