<?php 
include ("../dll/conexionsql.php");
extract($_GET);
/*Obtener los datos de db*/
$id=base64_decode($id);
$sql="SELECT * FROM empresa
INNER JOIN  agencia 
ON agencia.rucEmpresa = empresa.Ruc
INNER JOIN factura
ON factura.idAgencia = agencia.idAgencia
WHERE factura.idFactura =".$numFact;
echo $sql;
$sql="SELECT * from empresa where idUsuario = '$id'";
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){

	while ($row=mysql_fetch_array($ressql)) {
		$idUsuario=$row['idUsuario'];
		$cedula=$row['cedula'];
		$usrNombre=$row['usrNombre'];
		$nombreUsr=$row['nombreUsr'];
	}
}else{
	echo "No hay datos!!";
}
?>
<!DOCTYPE html>
<?php 
include ("../dll/bloqueDeSeguridad.php");

?>

<html>

<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="boot/img/favicon.png">

	<title>UTPL|Agencia|Administrador</title>
	<!-- Utpl theme-->
	<link href="../UtplCss/tema.css" rel="stylesheet">
	<link href="../UtplCss/internas.css" rel="stylesheet">
	<script language="javascript" src="http://code.jquery.com/jquery.js"></script>
	
</head>


<body>
	<!--========================ENCABEZADO================================ -->

	<header>

		<section class="encabezado">
			<div class="logo">
				<a style="float:left;display:block;" href="http://www.utpl.edu.ec"><img src="../img/logo.png"></img></a>
				<h1 style="float:left;">Buses de Transporte</h1>
			</div>
			<div class="tituloPag" id="clickeable" onclick="location.href='../index.php';" style="cursor:pointer;">
				<h1 > 
					Factura
				</h1>
			</div>
		</section>

	</header>

	<!--==========================FIN ENCABEZADO============================== -->


	<!--=========================CONTENEDOR=============================== -->


	<div class="contenedor">
		<?php 
		include ("../php/menu_admin.php");
		?>
		<section id="content">

			<table class="encabezado">
				<tbody>
					<tr>
						<td colspan="3" class="nomEmp"><h3>Nombre EMpresa</h3></td>
					</tr>
					<tr>
						<td colspan="3" class="detalles">Dirección</td>
					</tr>
					<tr>
						<td colspan="3" class="detalles">Telefono</td>
					</tr>
					<tr>
						<td colspan="3" class="detalles">canton-pais</td>
					</tr>
					<tr>
						<td>Ruc</td>
						<td rowspan="2">FACTURA</td>
						<td rowspan="2">N° FActura</td>
					</tr>
					<tr>
						<td>Permiso Operación:</td>
					</tr>
				</tbody>
			</table>
			<?php
			include("../php/listarAgencias.php");
			?>

		</section>
	</div>
	<!--==========================FIN CONTENEDOR============================== -->

	<!-- FOOTER	======================================================== -->
	<footer>


		<div class="containerdiv">          
			<div id="cc">
				<a href="http://creativecommons.org/licenses/by-nc-nd/3.0/ec/" target="_blank"><img src="http://www.utpl.edu.ec/sites/all/themes/utpl/images/cc.jpg"></a>
			</div>  
			<div id="contactinfo">  
				<p>San Cayetano Alto  - Loja Ecuador - Línea Gratuita: 1800 8875 8875</p>
			</div>
			<div id="q">  
				Universidad Técnica Particular de Loja
			</div>        
		</div>
	</footer>
	<!-- FIN FOOTER======================================================== -->


</body>
</html>