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

	<title>UTPL|Bus|Administrador</title>
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
					Agregar Bus
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
							<form class="form-horizontal" name="edificio" action="../php/addBus.php" method="POST">
								<fieldset>
									<legend>Agregar Bus</legend>
									<table>
										<tbody>

											<tr>
												<td><label class="control-label">Número de Bus:</label></td>
												<td><input name="numBus" type="text" placeholder="Número del Bus" required></td>
											</tr>
											<tr>
												<td><label class="control-label">Ruc Socio:</label></td>
												<td>
													<select required name="rucSocio">
														<option value="null">Seleccione</option>
														<?php 
														$query = "SELECT persona.Nombres,persona.Apellidos,persona.cedula,socio.rucSocio,socio.cedulaPersona 
														FROM persona
														INNER JOIN socio ON persona.cedula = socio.cedulaPersona";
														$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
														while($row = mysqli_fetch_array($result)){
															?>
															<option value="<?php echo $row[3]; ?>"> 
																<?php echo $row[0].' '.$row[1]; ?> 
															</option>
															<?php
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td><label class="control-label">Capacidad:</label></td>
												<td><input name="busCap" type="text" placeholder="Capacidad del Bus" required></td>
											</tr>
											<tr>
												<td><label class="control-label">Año de fabricación:</label></td>
												<td><input name="anioBus" type="tel" placeholder="Año de fabricación" required></td>
											</tr>
											<tr>
												<td><label class="control-label">Modelo:</label></td>
												<td><input name="modelBus" type="text" placeholder="Modelo del Bus" required></td>
											</tr>
											<tr>
												<td><label class="control-label">Placa:</label></td>
												<td><input name="placaBus" type="tel" placeholder="Placa del Bus sin guión" required></td>
											</tr>
											<tr>
												<td><label class="control-label">Número de Disco:</label></td>
												<td><input name="numDisco" type="text" placeholder="Número de Disco del Bus" required></td>
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
		include("../php/listarBus.php");
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