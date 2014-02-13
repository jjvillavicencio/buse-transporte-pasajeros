<?php 
/*Conexion al servidor de mysql*/
include("../dll/conexionsql.php");
extract($_GET);
if(!isset($bandera)){
	/*Obtener los datos de db*/
	$sql="SELECT rutas.idRuta, c1.nombre, c2.nombre, rutas.horaSalida, rutas.horaLlegada, tipo.nombre, rutas.valor FROM rutas
	INNER JOIN tipo
	ON rutas.idTipo = tipo.idTipo
	INNER JOIN canton c1
	ON rutas.LugarPartida = c1.idCanton
	INNER JOIN canton c2
	ON rutas.lugarLlegada = c2.idCanton";

	$ressql=mysql_query($sql,$con);
	$totdatos=mysql_num_rows($ressql);
	if($totdatos>0){
		echo "<table border='0' class='table table-hover'>";
		echo "<h3 class=\"azul\">Lista de Agencias</h3>";
		echo "<tr>";
		echo "<th scope='col'>"."Lugar Partida"."</th>";
		echo "<th scope='col'>"."Lugar Llegada"."</th>";
		echo "<th scope='col'>"."Hora Salida"."</th>";
		echo "<th scope='col'>"."Hora Llegada"."</th>";
		echo "<th scope='col'>"."Tipo"."</th>";
		echo "<th scope='col'>"."Valor"."</th>";
		echo "<th scope='col'>"."Editar"."</th>";
		echo "<th scope='col'>"."Eliminar"."</th>";
		echo "</tr>";
		while ($row=mysql_fetch_array($ressql)) {
			echo "<tr class='filas'>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td>".$row[4]."</td>";
			echo "<td>".$row[5]."</td>";
			echo "<td>".$row[6]."</td>";
			echo "<td>
			<a href='actRuta.php?id=".base64_encode($row[0])."'>
				<i class='icon-pencil'></i>
			</a>
		</td>";
		echo "<td>
		<a href='../php/listarRuta.php?id=".base64_encode($row[0])."&bandera=1'>
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
	
		$sql="delete from rutas where idRuta='$id'";
		if($ressql=mysql_query($sql,$con)){
			echo "<script>alert ('Ruta eliminada');
			window.location='../pages/addRuta.php';</script>";		
		}else{
			echo "<script>alert ('Error. Ruta no eliminada');
			window.location='../pages/addRuta.php';</script>";
		}
}
}
mysql_close($con);
?>