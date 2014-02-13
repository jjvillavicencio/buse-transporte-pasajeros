<?php 
/*Conexion al servidor de mysql*/
include("../dll/conexionsql.php");
extract($_GET);
if(!isset($bandera)){
	/*Obtener los datos de db*/
	$sql="SELECT agencia.idAgencia, canton.nombre, agencia.direccion,agencia.telefono,empresa.NombreEmpresa FROM agencia
	INNER JOIN canton
	ON agencia.idCanton = canton.idCanton
	INNER JOIN empresa
	ON agencia.rucEmpresa = empresa.Ruc";
	$ressql=mysql_query($sql,$con);
	$totdatos=mysql_num_rows($ressql);
	if($totdatos>0){
		echo "<table border='0' class='table table-hover'>";
		echo "<h3 class=\"azul\">Lista de Agencias</h3>";
		echo "<tr>";
		echo "<th scope='col'>"."Lugar"."</th>";
		echo "<th scope='col'>"."Dirección"."</th>";
		echo "<th scope='col'>"."Teléfono"."</th>";
		echo "<th scope='col'>"."Empresa"."</th>";
		echo "<th scope='col'>"."Editar"."</th>";
		echo "<th scope='col'>"."Eliminar"."</th>";
		echo "</tr>";
		while ($row=mysql_fetch_array($ressql)) {
			echo "<tr class='filas'>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td>".$row[4]."</td>";
			echo "<td>
			<a href='actAgencia.php?id=".base64_encode($row[0])."'>
				<i class='icon-pencil'></i>
			</a>
		</td>";
		echo "<td>
		<a href='../php/listarAgencias.php?id=".base64_encode($row[0])."&bandera=1'>
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
		$sql="delete from agencia where idAgencia='$id'";
		if($ressql=mysql_query($sql,$con)){
			echo "<script>alert ('Agencia eliminada');
			window.location='../pages/addAgencia.php';</script>";		
		}else{
			echo "<script>alert ('Error. Agencia no eliminada (En Uso)');
			window.location='../pages/addAgencia.php';</script>";
		}

	}
}

mysql_close($con);
?>