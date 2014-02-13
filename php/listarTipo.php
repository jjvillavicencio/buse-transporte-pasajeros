<?php 
/*Conexion al servidor de mysql*/
include("../dll/conexionsql.php");
extract($_GET);
if(!isset($bandera)){
	/*Obtener los datos de db*/
	$sql="SELECT * FROM tipo";
	$ressql=mysql_query($sql,$con);
	$totdatos=mysql_num_rows($ressql);
	if($totdatos>0){
		echo "<table border='0' class='table table-hover'>";
		echo "<h3 class=\"azul\">Lista de Agencias</h3>";
		echo "<tr>";
		echo "<th scope='col'>"."Tipo"."</th>";
		echo "<th scope='col'>"."Editar"."</th>";
		echo "<th scope='col'>"."Eliminar"."</th>";
		echo "</tr>";
		while ($row=mysql_fetch_array($ressql)) {
			echo "<tr class='filas'>";
			echo "<td>".$row[1]."</td>";
			echo "<td>
			<a href='actTipo.php?id=".base64_encode($row[0])."'>
				<i class='icon-pencil'></i>
			</a>
		</td>";
		echo "<td>
		<a href='../php/listarTipo.php?id=".base64_encode($row[0])."&bandera=1'>
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
	
		$sql="delete from tipo where idTipo='$id'";
		if($ressql=mysql_query($sql,$con)){
			echo "<script>alert ('Tipo eliminado');
			window.location='../pages/addTipo.php';</script>";		
		}else{
			echo "<script>alert ('Error. Tipo no eliminado');
			window.location='../pages/addTipo.php';</script>";
		}
	
}
}
mysql_close($con);
?>