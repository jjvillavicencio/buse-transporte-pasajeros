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

	<title>UTPL|Localización|Administrador</title>
	<!-- Utpl theme-->
	<link href="../UtplCss/tema.css" rel="stylesheet">
	<link href="../UtplCss/internas.css" rel="stylesheet">
	<script language="javascript" src="http://code.jquery.com/jquery.js"></script>
	<script language="javascript">
		$(document).ready(
			function(){
				$("#idpais").change(function () {
					$("#idpais option:selected").each(function () {
						elegido=$(this).val();
						$.post("../php/retornaProv.php?opc=1", { elegido: elegido }, function(data){
							$("#idProv").html(data);
						});            
					});
				})
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
					Agregar localización
				</h1>
			</div>
		</section>

	</header>

	<!--==========================FIN ENCABEZADO============================== -->


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
								<form class="form-horizontal" name="sala" action="../php/addLocalizacion.php?opc=1" method="POST">
									<fieldset>
										<legend>Agregar Pais</legend>
										<table>
											<tbody>
												<tr>
													<td><label class="control-label">Nombre:</label></td>
													<td><input name="nombPais" type="text" placeholder="Nombre del País" required></td>
												</tr>

												<tr>
													<td></td>
													<td>
														<center>
															<button class=" btn btn-primary" type="submit"> Guardar </button>
															<button class="btn btn-danger" type="reset"> Limpiar </button>
														</center>
													</td>
													<td></td>
												</tr>
											</tbody>
										</table>
									</fieldset>
								</form>
							</center>
						</td>
						<td>
							<center>
								<form class="form-horizontal" name="sala" action="../php/addLocalizacion.php?opc=2" method="POST">
									<fieldset>
										<legend>Agregar Provincia</legend>
										<table>
											<tbody>
												<tr>
													<td><label class="control-label">País:</label></td>
													<td><select required name="selPais">
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
												<td><label class="control-label">Nombre:</label></td>
												<td><input name="nombProv" type="text" placeholder="Nombre de la provincia" required></td>
											</tr>

											<tr>
												<td></td>
												<td>
													<center>
														<button class=" btn btn-primary" type="submit"> Guardar </button>
														<button class="btn btn-danger" type="reset"> Limpiar </button>
													</center>
												</td>
												<td></td>
											</tr>
										</tbody>
									</table>
								</fieldset>
							</form>
						</center>
					</td>
				</tr>
				<tr>
					<td>
						<center>
							<form class="form-horizontal" name="sala" action="../php/addLocalizacion.php?opc=3" method="POST">
								<fieldset>
									<legend>Agregar Cantón</legend>
									<table>
										<tbody>
											<tr>
												<td><label class="control-label">País:</label></td>
												<td><select required name="idpais" id="idpais">
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
											<td><label class="control-label">Nombre:</label></td>
											<td><input name="nombCant" type="text" placeholder="Nombre del Cantón" required></td>
										</tr>

										<tr>
											<td></td>
											<td>
												<center>
													<button class=" btn btn-primary" type="submit"> Guardar </button>
													<button class="btn btn-danger" type="reset"> Limpiar </button>
												</center>
											</td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</fieldset>
						</form>
					</center>
				</td>
			</tr>	
		</tbody>	
	<?php
	include("../php/listarLocali.php");
	?>
	</table>
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