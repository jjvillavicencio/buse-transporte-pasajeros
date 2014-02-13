<?php 
require "dll/conexion.php";
$objeConexion = new Conexion();
?>
<?php
extract($_GET);
session_start();
if (isset($_SESSION['autenticado'])){
    header("Location: pages/agrevento.php");}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="boot/img/favicon.png">

	<title>UTPL|Buses de Transporte|Login</title>
	<!-- Utpl theme-->
	<link href="UtplCss/login.css" rel="stylesheet">
</head>

<body>
<!--========================ENCABEZADO================================ -->

	<header>

		<section class="encabezado">
			<div class="logo">
				<a style="float:left;display:block;" href="http://www.utpl.edu.ec"><img src="img/logo.png"></img></a>
				<h1 style="float:left;">Buses de Transporte</h1>
			</div>
			<div class="tituloPag" id="clickeable" onclick="location.href='index.php';" style="cursor:pointer;">
				<h1 > 
					ingreso al sistema
				</h1>
			</div>
		</section>

	</header>

<!--==========================FIN ENCABEZADO============================== -->



<!--=========================CONTENEDOR=============================== -->


	<div class="contenedor">

		<div class="login">
			<div class="formLogin">
				<table class="tableLogin">
					<tbody>
						<tr>
							<td> 
								<center>   

									<form class="form-horizontal" name="usuario" id="login" action="dll/ingreso.php" method="post">
										<h3>Ingreso de Usuarios:</h3>
										<table class="table tableDatos">

											<tbody>
												<tr>
													<td><label class="control-label tit" for="identificacion">Usuario:   </label>
													<input class="ingreso"  type="text" id="identificacion" name="usuario"  placeholder="Usuario..." required autofocus autocomplete></td>
												</tr>

												<tr>
													<td><label class="control-label tit" for="clave">Contraseña:   </label>
													<input class="ingreso"  type="password" id="clave"  name="contrasena" placeholder="Contraseña..." required autofocus autocomplete></td>
												</tr>
												<tr>
													<td><label class="control-label tit" for="clave">Agencia:   </label>
													<select class="ingreso"   id="clave"  name="agencia" required autofocus autocomplete>
													<?php 
																	$query = "select agencia.idAgencia, canton.nombre from Agencia
																			INNER JOIN canton
																			ON agencia.idCanton=canton.idCanton";
																	$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
																	while($row = mysqli_fetch_array($result)){
																		?>
																		<option value="<?php echo $row[0]; ?>"> 
																			<?php echo $row[1]; ?> 
																		</option>
																		<?php
																	}
																	?>
													</select>
													</td>
												</tr>
												<tr>
													<td>
														<center>
														<input  class="enviar"  type="submit" id="enviar" value="INGRESO">
														</center>
													</td>
												</tr>
											</tbody>
										</table>
									</form>
								</center>
							</td>
						</tr>	
					</tbody>	
				</table>
			</div>
		</div>

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
