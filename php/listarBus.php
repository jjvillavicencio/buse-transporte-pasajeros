<?php 
/*Conexion al servidor de mysql*/
include("../dll/conexionsql.php");
extract($_GET);
if(!isset($bandera)){
	/*Obtener los datos de db*/
	$sql="SELECT bus.numBus,bus.capacidad,bus.año,bus.modelo,bus.placa,bus.numDisco,persona.Nombres,persona.Apellidos FROM bus
	INNER JOIN socio
	ON bus.rucSocio = socio.rucSocio
	INNER JOIN persona
	ON socio.cedulaPersona = persona.cedula";
	
	$ressql=mysql_query(utf8_decode($sql),$con);
	$totdatos=mysql_num_rows($ressql);
	if($totdatos>0){
		echo "<table border='0' class='table table-hover'>";
		echo "<h3 class=\"azul\">Lista de Buses</h3>";
		echo "<tr>";
		echo "<th scope='col'>"."N° Bus"."</th>";
		echo "<th scope='col'>"."Capacidad"."</th>";
		echo "<th scope='col'>"."Año"."</th>";
		echo "<th scope='col'>"."Modelo"."</th>";
		echo "<th scope='col'>"."Placa"."</th>";
		echo "<th scope='col'>"."N° Disco"."</th>";
		echo "<th scope='col'>"."Socio"."</th>";
		echo "<th scope='col'>"."Editar"."</th>";
		echo "<th scope='col'>"."Eliminar"."</th>";
		echo "</tr>";
		while ($row=mysql_fetch_array($ressql)) {
			echo "<tr class='filas'>";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td>".$row[4]."</td>";
			echo "<td>".$row[5]."</td>";
			echo "<td>".$row[6]." ".$row[7]."</td>";
			echo "<td>
			<a href='actBus.php?id=".base64_encode($row[0])."'>
				<i class='icon-pencil'></i>
			</a>
		</td>";
		echo "<td>
		<a href='../php/listarBus.php?id=".base64_encode($row[0])."&bandera=1'>
			<i class='icon-trash'></i>
		</a>
	</td>";
	echo "</tr>";	
}
echo "</table";
}else{
	echo "No hay datos!!";
}
}else{
	if($bandera==1){
		$id=base64_decode($id);
		$sql="delete from bus where numBus='$id'";
		if($ressql=mysql_query($sql,$con)){
			echo "<script>alert ('Bus eliminado');
			window.location='../pages/addBus.php';</script>";		
		}else{
			echo "<script>alert ('Error. Bus no eliminado(En Uso)');
			window.location='../pages/addBus.php';</script>";
		}

	}
}
mysql_close($con);
?>