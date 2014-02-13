<?php 
require "../dll/conexion.php";
$objeConexion = new Conexion();
extract($_GET);
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
					Agregar Persona
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
								<form class="form-horizontal" name="usuario" action="../php/addPersona.php<?php if(isset($act)){echo '?act='.$act;}else{echo'';} ?>" method="POST">
									<fieldset>
										<legend>Agregar Usuario:</legend>
										<table>
											<tbody>
												<tr>
													<td><label class="control-label">N° de Cédula:</label></td>
													<td><input name="numCed1" type="text" placeholder="Número de Cédula" required value="<?php if(isset($ced)){echo $ced;}else{echo'';} ?>"></td>
												</tr>
												<tr>
													<td><label class="control-label">Nombre:</label></td>
													<td><input type="text" placeholder="Nombres:" name="nombres1" required></td>
												</tr>
												<tr>
													<td><label class="control-label">Apellidos:</label></td>
													<td><input type="text" placeholder="Apellidos:" name="apellidos1" required></td>
												</tr>
												<tr>
													<td><label class="control-label">Dirección:</label></td>
													<td><input type="text" placeholder="Direccion de la persona:" name="dir1" required></td>
												</tr>
												<tr>
													<td><label class="control-label">Teléfono:</label></td>
													<td><input type="text" name="telf1" placeholder="número telefónico" required></td>
												</tr>
												<tr>
													<td><label class="control-label">Correo:</label></td>
													<td><input type="email" name="mail" placeholder="Correo Electrónico" required></td>
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
			include("../php/listarPersona.php");
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