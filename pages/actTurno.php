<?php 
include ("../dll/bloqueDeSeguridad.php");
require "../dll/conexion.php";
$objeConexion = new Conexion();
include ("../dll/conexionsql.php");
extract($_GET);
/*Obtener los datos de db*/
$id=base64_decode($id);
$sql="SELECT * from turno where idTurno = '$id'";
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){

	while ($row=mysql_fetch_array($ressql)) {
		$idTurno=$row['idTurno'];
		$numBus=$row['numBus'];
		$idRuta=$row['idRuta'];
		$fecha=$row['fecha'];
	}
}else{
	echo "No hay datos!!";
}
list($año, $mes, $dia) = split('[/.-]', $fecha);
	$fecha=$dia."/".$mes."/".$año;
?>
<!DOCTYPE html>

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
	<link href="../dll/calendario_dw/calendario_dw-estilos.css" type="text/css" rel="STYLESHEET">
	<script language="javascript" src="http://code.jquery.com/jquery.js"></script>
	<script type="text/javascript" src="../dll/calendario_dw/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="../dll/calendario_dw/calendario_dw.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".campofecha").calendarioDW();
		})
	</script>

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
					Editar Turno
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

			<table class="table">
				<tbody>
					<tr>
						<td> <center>   
							<form class="form-horizontal" name="Socio" action="../php/actTurno.php?id=<?php echo base64_encode($idTurno); ?>" method="POST">
								<fieldset>
									<legend>Editar Turno</legend>
									<table>
										<tbody>
											<tr>
												<td><label class="control-label">Numero de bus:</label></td>
												<td>
													<select required name="numBus">
														<?php 
														$query = "select numBus from bus";
														$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
														while($row = mysqli_fetch_array($result)){
															if($row['$numBus']==$numBus){
																echo '<option selected value="'.$row['numBus'].'">'.$row['numBus'].'</option>';
															}else{
																echo '<option  value="'.$row['numBus'].'">'.$row['numBus'].'</option>';

															}
															
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td><label class="control-label">Ruta:</label></td>
												<td>
													<select required name="idRuta" id="idRuta">
														<?php 
														$query = "select rutas.idRuta,  c1.nombre AS partida,c2.nombre AS llegada,tipo.nombre AS tipo 
														from rutas
														INNER JOIN	canton  c1
														ON rutas.LugarPartida = c1.idCanton 
														INNER JOIN	canton  c2
														ON rutas.lugarLlegada = c2.idCanton
														INNER JOIN tipo";
														$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
														while($row = mysqli_fetch_array($result)){
															if($row['$idRuta']==$idRuta){
																echo '<option selected value="'.$row['idRuta'].'">'.$row['partida'].' - '.$row['llegada'].'</option>';
															}else{
																echo '<option  value="'.$row['idRuta'].'">'.$row['partida'].' - '.$row['llegada'].'('.$row['tipo'].')</option>';

															}
														}
														?>
													</select>
												</td>
											</tr>

											<tr>
												<td><label class="control-label">Fecha:</label></td>
												<td><input type="text" name="fecha" class="campofecha" size="12" value="<?php echo $fecha; ?>"></td>
											</tr>

											<tr>
												<td></td>
												<td>
													<center>
														<button class=" btn btn-primary" type="submit"> Guardar </button>
														<button class="btn btn-danger" type="reset"> Limpiar </button>
														<input class="btn btn-warning" type="button" name="Cancelar" value="Cancelar" onClick="location.href='../index.php'">

													</center>
												</td>
												<td></td>
											</tr>
										</tbody>
									</table>
									<p></p>
								</fieldset>
							</form>
						</center>
					</td>
				</tr>	
			</tbody>	
		</table>
		<?php
		include("../php/listarTurno.php");
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
			Unidad de Gestión de la Comunicación<br>
			Comunicación Digital
		</div>        
	</div>
</footer>
<!-- FIN FOOTER======================================================== -->


</body>
</html>