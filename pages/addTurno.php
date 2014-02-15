<?php 
require "../dll/conexion.php";
$objeConexion = new Conexion();
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

	<title>UTPL|Turnos|Administrador</title>
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
					Agregar Turno
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
							<form class="form-horizontal" name="Socio" action="../php/addTurno.php" method="POST">
								<fieldset>
									<legend>Agregar Turno</legend>
									<table>
										<tbody>
											<tr>
												<td><label class="control-label">Numero de bus:</label></td>
												<td>
													<select required name="numBus" class="tamauto">
														<option value="null">Seleccione</option>
														<?php 
														$query = "select numBus from bus";
														$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
														while($row = mysqli_fetch_array($result)){
															?>
															<option value="<?php echo $row["0"]; ?>"> 
																<?php echo $row["0"]; ?> 
															</option>
															<?php
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td><label class="control-label">Ruta:</label></td>
												<td>
													<select required name="idRuta" id="idRuta" size="5" class="tamauto">
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
															?>
															<option value="<?php echo $row[0]; ?>"> 
																<?php echo $row[1].' - '.$row[2].'('.$row[3].')'; ?> 
															</option>
															<?php
														}
														?>
													</select>
												</td>
											</tr>

											<tr>
												<td><label class="control-label">Fecha:</label></td>
												<td><input type="text" name="fecha" class="campofecha" size="12"></td>
											</tr>

											<tr>
													<td>
														<label class="control-label">Hora:</label>
													</td>
													<td>
														<span> HH: </span>
														<select name="horaPartida" style="width:55px;" id="hora" >
															<?php
															for ($i=0; $i<=23; $i++) {
																if ($i == date("G"))
																	echo '<option value="'.$i.'" selected>'.sprintf("%02s",$i).'</option>';
																else
																	echo '<option value="'.$i.'">'.sprintf("%02s",$i).'</option>';
															}
															?>
														</select>
														<span> MM:</span>
														<select name="minutosPartida" style="width:65px;" id="minutos" >
															<?php
															for ($i=00; $i<=59; $i=$i+10) {
																if ($i == date("i"))
																	echo '<option value="'.$i.'" selected>'.sprintf("%02s",$i).'</option>';
																else
																	echo '<option value="'.$i.'">'.sprintf("%02s",$i).'</option>';
															}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td><label class="control-label">Tipo:</label></td>
													<td>
														<select required name="idTipo" id="idTipo">
															<?php 
															$query = "select * from tipo";
															$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
															while($row = mysqli_fetch_array($result)){
																?>
																<option value="<?php echo $row["0"]; ?>"> 
																	<?php echo $row["1"]; ?> 
																</option>
																<?php
															}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td><label class="control-label">Valor:</label></td>
													<td><input type="text" placeholder="Valor del boleto" name="valor" required onkeypress="return justNumbers(event);"></td>
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
			Universidad Técnica Particular de Loja
		</div>        
	</div>
</footer>
<!-- FIN FOOTER======================================================== -->


</body>
</html>