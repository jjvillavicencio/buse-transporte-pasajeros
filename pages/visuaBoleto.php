<?php 
require "../dll/conexion.php";
$objeConexion = new Conexion();
extract($_GET);
extract($_POST);
$numBol=base64_decode($numBol);
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

	<title>UTPL|Reserva de Salas|Administrador</title>
	<!-- Utpl theme-->
	<link href="../UtplCss/tema.css" rel="stylesheet">
	<link href="../UtplCss/internas.css" rel="stylesheet">
	<link href="../dll/calendario_dw/calendario_dw-estilos.css" rel="stylesheet">
	<script language="javascript" src="http://code.jquery.com/jquery.js"></script>
	<script type="text/javascript" src="../dll/calendario_dw/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="../dll/calendario_dw/calendario_dw.js"></script>
	


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
					Emitir Boleto
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
			<div id="padre" class="limpiar">
				<form class="form-horizontal" name="boleto" action="../php/addBoleto.php?numFac=<?php echo $numFac; ?>" method="POST">
					<h2>Nuevo Boleto</h2>
					<div class="bloque limpiar">
						<table >
							<tbody >
								<tr>
									<td>N° Cédula:</td>
									<td class="peq15"><input type="text" name="cedCli" id="c1" disabled="true" value="<?php echo $numCed; ?>"></td>
								</tr>
								<tr>
									<td><label for="nomCli">Nombre:</label></td>
									<td colspan="3" class="names"><input type="text" name="nomCli" id="c2" disabled="true" value="<?php echo $nombres; ?>"></td>
								</tr>
								<tr>
									<td><label for="apellCli">Apellido:</label></td>
									<td colspan="3" class="names"><input type="text" name="apellCli" id="c3" disabled="true" value="<?php echo $apellidos; ?>"></td>
								</tr>
								<tr>
									<td><label for="">Dirección:</label></td>
									<td colspan="3" class="names"><input type="text" disabled="true" id="c4" value="<?php echo $direccion; ?>"></td>
								</tr>
								<tr>
									<td><label for="">Teléfono:</label></td>
									<td class="peq15"><input type="text" disabled="true" id="c5" value="<?php echo $telefono; ?>"></td>
									<td><label>Correo:</label></td>
									<td class="peq15"><input type="text" disabled="true" id="c6" correo></td>
								</tr>
								

							</tbody>
						</table>
					</div>
					<div class="bloque limpiar">
						<table>
							<tbody>
								<tr>
									<td><label for="">Fecha del Turno:</label></td>
									<td class="peq15"><input type="text" name="fecha" id="fecha"class="campofecha" size="12" value="<?php echo $fecha; ?>"></td>
									<td><label>Pais:</label></td>
									<td class="peq15">
										<input value="<?php echo $pais; ?>">
									</td>
								</tr>
								<tr>
									<td><label>Provincia:</label></td>
									<td class="peq15">
										<input type="text" value="<?php echo $provincia; ?>">
									</td>
									<td><label>Ciudad:</label></td>
									<td class="peq15">
										<input type="text" value="<?php echo $ciudad; ?>">
									</td>
								</tr>
								<tr>
									<td><label for="idTurno">Turno:</label></td>
									<td class="peq15">
										<<input type="text" value="<?php echo $turno; ?>">
									</td>
									<td><label for="idBus">N° Bus:</label></td>
									<td class="peq15">
										<input type="text" name="idBus" id="c7" value="<?php echo $bus; ?>">
									</td>
								</tr>
								<tr>
									<td><label for="hs">Hora de Salida:</label></td>
									<td class="peq15"><input type="text" name="hs" id="c8" value="<?php echo $hora; ?>"></td>
									<td ><label for="idTipo">tipo</label></td>
									<td class="peq15"><input type="text" name="idTipo" id="c9" disabled="true" value="<?php echo $tipo; ?>"></td>
								</tr>
								<tr>
									<td><label for="">Asiento:</label></td>
									<td class="peq15">
										<input type="text" value="<?php echo $asiento; ?>">
									</td>
								</tr>
								<tr>
									<td><label for="">Precio:</label></td>
									<td class="peq15">
										<input type="text" id="c11" value="<?php echo $precio; ?>">
									</td>
								</tr>
							</tbody>
						</table>

					</div>
					<div >

						<table style="margin:50px auto 0 auto;">
							<tbody>
								<tr >
									<td style="margin: 20px 0 0 0 !important; heigth:50px;">
										<center><button class=" btn btn-primary" type="submit"> Aceptar </button>
										</center></td>
									</tr>
								</tbody>
							</table>
						</div>
					</form>
				</div>

			</section>
			<script src="../boot/js/bootstrap.min.js"></script>
		</div>
		<!--==========================FIN CONTENEDOR============================== -->

<!-- FOOTER
	======================================================== -->
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