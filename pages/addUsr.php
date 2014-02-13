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

	<title>UTPL|Usuarios|Administrador</title>
	<!-- Utpl theme-->
	<link href="../UtplCss/tema.css" rel="stylesheet">
	<link href="../UtplCss/internas.css" rel="stylesheet">

</head>


<body>
	<!--========================ENCABEZADO================================ -->
	
	<header>

		<section class="encabezado">
			<div class="logo">
				<a href="www.utpl.edu.ec"><img src="http://www.utpl.edu.ec/sites/all/themes/utpl/images/logo.png"></img></a>
			</div>
			<div class="tituloPag" id="clickeable" onclick="location.href='../index.php';" style="cursor:pointer;">
				<h1 > 
					Usuarios
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
								<form class="form-horizontal" name="usuario" action="../php/addUsr.php" method="POST">
									<fieldset>
										<legend>Agregar Usuario:</legend>
										<table>
											<tbody>
												<tr>
													<td><label class="control-label">Cédula:</label></td>
													<td>
														<select required name="idCed" id="idCed">
															<option selected="true" value="null">Seleccione</option>
															<?php 
															$query = "select cedula,nombres,apellidos from persona";
															$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
															while($row = mysqli_fetch_array($result)){
																?>
																<option value="<?php echo $row[0]; ?>"> 
																	<?php echo $row[1].' '.$row[2]; ?> 
																</option>
																<?php
															}
															?>
														</select>
													</td>
												</tr>
												
												<tr>
													<td><label class="control-label">Usuario:</label></td>
													<td><input type="text" placeholder="usuario login:" name="usuario1" required></td>
												</tr>
												<tr>
													<td><label class="control-label">Contraseña:</label></td>
													<td><input type="password" name="contraseña1" placeholder="contraseña login" required></td>
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
			include("../php/listarUsr.php");
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