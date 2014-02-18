<?php 
include ("../dll/conexionsql.php");
extract($_GET);
/*Obtener los datos de db*/
$sql="SELECT e.Ruc, e.NombreEmpresa, e.Direccion, c.nombre AS Ciudad,pr.nombre AS Provincia,p.nombre AS Pais, e.Telefono, e.PermisoOperacion, per.cedula,per.Nombres, per.Apellidos,per.direccion, per.telefono,per.correo, f.usuario, f.fecha, f.hora, f.subTotal,f.iva,f.total FROM empresa e
INNER JOIN agencia
ON agencia.rucEmpresa = e.Ruc
INNER JOIN factura f
ON f.agencia = agencia.idAgencia
INNER JOIN canton c
ON e.idCanton = c.idCanton
INNER JOIN provincia pr
ON c.idProvincia = pr.idProvincia
INNER JOIN pais p
ON pr.idPais = p.idPais
INNER JOIN persona per
ON per.cedula = f.idCedula
WHERE f.idFactura=".$numFact;
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){

	while ($row=mysql_fetch_array($ressql)) {
		$Ruc=$row['Ruc'];
		$NombreEmpresa=$row['NombreEmpresa'];
		$Direccion=$row['Direccion'];
		$Ciudad=$row['Ciudad'];
		$Provincia=$row['Provincia'];
		$Pais=$row['Pais'];
		$Telefono=$row['Telefono'];
		$PermisoOperacion=$row['PermisoOperacion'];
		$cedula=$row['cedula'];
		$Nombres=$row['Nombres'];
		$Apellidos=$row['Apellidos'];
		$direccion=$row['direccion'];
		$telefono=$row['telefono'];
		$correo=$row['correo'];
		$usuario=$row['usuario'];
		$fecha=$row['fecha'];
		$hora=$row['hora'];
		$subTotal1=$row['subTotal'];
		$iva1=$row['iva'];
		$total1=$row['total'];
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
	<link rel="STYLESHEET" type="text/css" href="../UtplCss/estilo_imprimir.css" media="print">
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
			<div class="seleccion">
				<table class="encabezado2">
					<tbody>
						<tr>
							<td colspan="5" class="nomEmp"><h2><?php echo $NombreEmpresa; ?></h2></td>
						</tr>
						<tr>
							<td colspan="5" class="detalles"><?php echo $Direccion; ?></td>
						</tr>
						<tr>
							<td colspan="5" class="detalles"><?php echo $Telefono; ?></td>
						</tr>
						<tr>
							<td colspan="5" class="detalles"><?php echo $Ciudad.' - '.$Provincia.' - '.$Pais; ?></td>
						</tr>
						<tr>
							<td><h5>Ruc:</h5> <?php echo $Ruc; ?></td>
							<td><h5>Permiso Operación:</h5> <?php echo $PermisoOperacion; ?></td>
							<td colspan="2"><h4>FACTURA</h4></td>
							<td ><h5>N° FActura:</h5> <?php echo $numFact; ?></td>
						</tr>

					</tbody>
				</table>
				<table class="datos">
					<tbody>
						<tr>
							<td>Cliente:</td>
							<td colspan="3"><?php echo $Nombres.' '.$Apellidos; ?></td>
						</tr>
						<tr>
							<td>C.I:</td>
							<td><?php echo $cedula; ?></td>
							<td>Fecha:</td>
							<td><?php echo $fecha.' '.$hora; ?></td>
						</tr>
						<tr>
							<td>Dirección:</td>
							<td colspan="3"><?php echo $direccion; ?></td>
						</tr>
						<tr>
							<td>Teléfono:</td>
							<td><?php echo $telefono; ?></td>
							<td>Correo:</td>
							<td><?php echo $correo; ?></td>
						</tr>
					</tbody>
				</table>
				<table class="detalle">
					<thead>
						<th>Cant.</th>
						<th>Descripcion</th>
						<th>Valor</th>
						<th>valor Total</th>

					</thead>
					<tbody>

						<?php
						include("../php/listarDetalle.php");

						?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"></td>
							<td>Sub Total</td>
							<td><?php echo sprintf("%01.2f",$subTotal1); ?></td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td>IVA</td>
							<td><?php echo sprintf("%01.2f",$iva1); ?></td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td>Total</td>
							<td><?php echo sprintf("%01.2f",$total1); ?></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<table class="botones">
				<tbody>
					<tr>
						<td></td>
						<td>
							<center>
							<input class=" btn btn-primary" type="button" value="Aceptar" onClick="window.location='../index.php'"> 
								<input class="btn btn-warning" type="button" name="Cancelar" value="Imprimir" onClick="window.print()">

							</center>
						</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</section>
	</div>
	<!--==========================FIN CONTENEDOR============================== -->


</script>
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