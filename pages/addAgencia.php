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

	<title>UTPL|Agencia|Administrador</title>
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
	<script language="javascript">
		$(document).ready(
			function(){
				$("#idProv").change(function () {
					$("#idProv option:selected").each(function () {
						elegido=$(this).val();
						$.post("../php/retornaProv.php?opc=2", { elegido: elegido }, function(data){
							$("#idCant").html(data);
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
					Agregar Agencia
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
							<form class="form-horizontal" name="edificio" action="../php/addAgen.php" method="POST">
								<fieldset>
									<legend>Agregar Agencia</legend>
									<table>
										<tbody>
											<tr>
												<td><label class="control-label">Empresa:</label></td>
												<td>
													<select required name="selEmpr">
														<?php 
														$query = "select Ruc,NombreEmpresa from empresa";
														$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
														while($row = mysqli_fetch_array($result)){
															?>
															<option value="<?php echo $row["Ruc"]; ?>"> 
																<?php echo $row["NombreEmpresa"]; ?> 
															</option>
															<?php
														}
														?>
													</select>
												</td>
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
												<td><label class="control-label">Dirección:</label></td>
												<td><input name="dirAgen" type="text" placeholder="Dirección" required></td>
											</tr>
											<tr>
												<td><label class="control-label">Teléfono:</label></td>
												<td><input name="telfAgen" type="tel" placeholder="número de teléfono" required></td>
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
		include("../php/listarAgencias.php");
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