<?php 
/*Conexion al servidor de mysql*/
include("../dll/conexionsql.php");
extract($_GET);
if(!isset($bandera)){
	/*Obtener los datos de db*/
	$sql="SELECT socio.rucSocio, persona.Nombres, persona.Apellidos, socio.cedulaPersona FROM socio
	INNER JOIN persona
	ON socio.cedulaPersona = persona.cedula";
	$ressql=mysql_query($sql,$con);
	$totdatos=mysql_num_rows($ressql);
	if($totdatos>0){
		echo "<table border='0' class='table table-hover'>";
		echo "<h3 class=\"azul\">Lista de Socios</h3>";
		echo "<tr>";
		echo "<th scope='col'>"."Ruc Socio"."</th>";
		echo "<th scope='col'>"."Nombre"."</th>";
		echo "<th scope='col'>"."Cedula"."</th>";
		echo "<th scope='col'>"."Editar"."</th>";
		echo "<th scope='col'>"."Eliminar"."</th>";
		echo "</tr>";
		while ($row=mysql_fetch_array($ressql)) {
			echo "<tr class='filas'>";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]." ".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td>
			<a href='actSocio.php?id=".base64_encode($row[0])."'>
				<i class='icon-pencil'></i>
			</a>
		</td>";
		echo "<td>
		<a href='../php/listarSocio.php?id=".base64_encode($row[0])."&bandera=1'>
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

		$sql="delete from socio where rucSocio='$id'";
		if($ressql=mysql_query($sql,$con)){
			echo "<script>alert ('Socio eliminado');
			window.location='../pages/addSocio.php';</script>";		
		}else{
			echo "<script>alert ('Error. Socio no eliminado (En Uso)');
			window.location='../pages/addSocio.php';</script>";
		}

	}
}
mysql_close($con);
?>