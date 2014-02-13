<?php 
/*Conexion al servidor de mysql*/
include("../dll/conexionsql.php");
extract($_GET);
if(!isset($bandera)){
	/*Obtener los datos de db*/
	$sql="SELECT * FROM persona";
	$ressql=mysql_query($sql,$con);
	$totdatos=mysql_num_rows($ressql);
	if($totdatos>0){
		echo "<table border='0' class='table table-hover'>";
		echo "<h3 class=\"azul\">Lista de Personas</h3>";
		echo "<tr>";
		echo "<th scope='col'>"."Cédula"."</th>";
		echo "<th scope='col'>"."Nombres"."</th>";
		echo "<th scope='col'>"."Apellidos"."</th>";
		echo "<th scope='col'>"."Dirección"."</th>";
		echo "<th scope='col'>"."Teléfono"."</th>";
		echo "<th scope='col'>"."Correo"."</th>";
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
			echo "<td>
			<a href='actPersona.php?id=".base64_encode($row[0])."'>
				<i class='icon-pencil'></i>
			</a>
		</td>";
		echo "<td>
		<a href='../php/listarPersona.php?id=".base64_encode($row[0])."&bandera=1'>
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
	
		$sql="delete from persona where cedula='$id'";
		if($ressql=mysql_query($sql,$con)){
			echo "<script>alert ('Persona eliminada');
			window.location='../pages/addPersona.php';</script>";		
		}else{
			echo "<script>alert ('Error. Persona no eliminada (En Uso)');
			window.location='../pages/addPersona.php';</script>";
		}
}
}
mysql_close($con);
?>