<?php 
include ("../dll/bloqueDeSeguridad.php");
require "../dll/conexion.php";
$objeConexion = new Conexion();
include ("../dll/conexionsql.php");
extract($_GET);
/*Obtener los datos de db*/
$id=base64_decode($id);
$sql="SELECT * from socio where rucSocio = '$id'";
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){

	while ($row=mysql_fetch_array($ressql)) {
		$rucSocio=$row['rucSocio'];
		$rucEmpresa=$row['rucEmpresa'];
		$cedulaPersona=$row['cedulaPersona'];
	}
}else{
	echo "No hay datos!!";
}
?>
<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="boot/img/favicon.png">

	<title>UTPL|Socio|Administrador</title>
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
					Socios
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
							<form class="form-horizontal" name="Socio" action="../php/actSocio.php?id=<?php echo base64_encode($rucSocio); ?>" method="POST">
								<fieldset>
									<legend>Editar Socio</legend>
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
															if($row['Ruc']==$rucEmpresa){
																echo '<option selected value= "'.$row["Ruc"].'"">'.$row["NombreEmpresa"].'</option>';
															}else{
																echo '<option value= "'.$row["Ruc"].'"">'.$row["NombreEmpresa"].'</option>';
															}
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td><label class="control-label">Persona:</label></td>
												<td>
													<select required name="cedula" id="cedula">
														<?php 
														$query = "select cedula,Nombres,Apellidos from persona";
														$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
														while($row = mysqli_fetch_array($result)){
															if($cedulaPersona==$row['cedula']){
																echo '<option selected value="'.$row["cedula"].'">'.$row["Nombres"].' '.$row["Apellidos"]. '</option>';
															}else{
																echo '<option  value="'.$row["cedula"].'">'.$row["Nombres"].' '.$row["Apellidos"]. '</option>';

															}

														}
														?>
													</select>
												</td>
											</tr>

											<tr>
												<td><label class="control-label">Ruc Socio:</label></td>
												<td><input name="rucSocio" type="text" placeholder="Ruc del Socio" value="<?php echo $rucSocio; ?>" required></td>
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
		include("../php/listarSocio.php");
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