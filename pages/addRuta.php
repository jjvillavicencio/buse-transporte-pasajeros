<?php 
require "../dll/zonahoraria.php";
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

	<title>UTPL|Reserva de Salas|Administrador</title>
	<!-- Utpl theme-->
	<link href="../UtplCss/tema.css" rel="stylesheet">
	<link href="../UtplCss/internas.css" rel="stylesheet">
	<script language="javascript" src="http://code.jquery.com/jquery.js"></script>
	<script language="javascript">
		$(document).ready(
			function (){
				$("#idpais").change(function () {
					$("#idpais option:selected").each(function () {
						elegido=$(this).val();
						$.post("../php/retornaProv.php?opc=1", { elegido: elegido }, function(data){
							$("#idProv").html(data);
						});            
					});
				});

				$("#idProv").change(function () {
					$("#idProv option:selected").each(function () {
						elegido=$(this).val();
						$.post("../php/retornaProv.php?opc=2", { elegido: elegido }, function(data){
							$("#idCant").html(data);
						});            
					});
				});


				$("#idpais2").change(function () {
					$("#idpais2 option:selected").each(function () {
						elegido=$(this).val();
						$.post("../php/retornaProv.php?opc=1", { elegido: elegido }, function(data){
							$("#idProv2").html(data);
						});            
					});
				});

				$("#idProv2").change(function () {
					$("#idProv2 option:selected").each(function () {
						elegido=$(this).val();
						$.post("../php/retornaProv.php?opc=2", { elegido: elegido }, function(data){
							$("#idCant2").html(data);
						});            
					});
				});
			});
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
					Agregar Ruta
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
						<td>
							<center>
								<form class="form-horizontal" name="usuario" action="../php/addRuta.php" method="POST">
									<fieldset>
										<legend>Agregar Ruta:</legend>
										<table>
											<tbody>
												<tr> 
													<td><p>Partida:</p></td>
												</tr>
												<tr>
													<td><label class="control-label">País:</label></td>
													<td>
														<select required name="idpais" id="idpais">
															<option value="null">Seleccione</option>
															<?php 
															$query = "select * from pais";
															$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
															while($row = mysqli_fetch_array($result)){
																?>
																<option value="<?php echo $row["idPais"]; ?>"> 
																	<?php echo $row["Nombre"]; ?> 
																</option>
																<?php
															}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<label class="control-label">Provincia:</label>
													</td>
													<td>
														<select  name="idProv" id="idProv">
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<label class="control-label">Cantón:</label>
													</td>
													<td>
														<select  name="idCant" id="idCant">
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<label class="control-label">Hora:</label>
													</td>
													<td>
														<span> HH: </span>
														<select name="horaPartida" style="width:55px;" id="hora" >
															<?php
															for ($i=6; $i<=23; $i++) {
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
													<td><p>LLegada:</p></td>
												</tr>

												<tr>
													<td><label class="control-label">País:</label></td>
													<td>
														<select required name="idpais2" id="idpais2">
															<option value="null">Seleccione</option>
															<?php 
															$query = "select * from pais";
															$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
															while($row = mysqli_fetch_array($result)){
																?>
																<option value="<?php echo $row["idPais"]; ?>"> 
																	<?php echo $row["Nombre"]; ?> 
																</option>
																<?php
															}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<label class="control-label">Provincia:</label>
													</td>
													<td>
														<select  name="idProv2" id="idProv2">
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<label class="control-label">Cantón:</label>
													</td>
													<td>
														<select  name="idCant2" id="idCant2">
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<label class="control-label">Hora:</label>
													</td>
													<td>
														<span> HH: </span>
														<select name="horaLlegada" style="width:55px;" id="hora">
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
														<select name="minutosLlegada" style="width:65px;" id="minutos" >
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
													<td>
														<p>Datos:</p>
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
													<td>
														<center>
															<button class=" btn btn-primary" type="submit"> Guardar </button>
															<button class="btn btn-danger" type="reset"> Limpiar </button>
														</center>
													</td>
												</tr>

											</tbody>
										</table>
									</fieldset>
								</form>
							</center>
						</td>
					</tr>
				</tbody>
			</table>

			<?php
			include("../php/listarRuta.php");
			?>
		</section>
	</div>
	<!--==========================FIN CONTENEDOR============================== -->
	<script>
		function justNumbers(e)
		{
			var keynum = window.event ? window.event.keyCode : e.which;
			if ((keynum == 8) || (keynum == 46))
				return true;

			return /\d/.test(String.fromCharCode(keynum));
		}
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