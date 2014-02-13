<?php 
include ("../dll/bloqueDeSeguridad.php");
require "../dll/conexion.php";
$objeConexion = new Conexion();
include ("../dll/conexionsql.php");
extract($_GET);
/*Obtener los datos de db*/
$id=base64_decode($id);
$sql="SELECT * from agencia where idAgencia = '$id'";
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){

	while ($row=mysql_fetch_array($ressql)) {
		$idAgencia=$row[0];
		$idCanton=$row[1];
		$direccion=$row[2];
		$telefono=$row[3];
		$rucEmpresa=$row[4];
	}
}else{
	echo "No hay datos!!";
}

$sql="SELECT pais.idPais, provincia.idProvincia from canton 
INNER JOIN provincia
ON provincia.idProvincia = canton.idProvincia
INNER JOIN pais
ON pais.idPais = provincia.idPais
where canton.idCanton = '$idCanton'";
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){

	while ($row=mysql_fetch_array($ressql)) {
		$idPais=$row[0];
		$idProvincia=$row[1];
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
					Agencias
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
							<form class="form-horizontal" name="edificio" action="../php/actAgencia.php?id=<?php echo base64_encode($idAgencia); ?>" method="POST">
								<fieldset>
									<legend>Editar Agencia</legend>
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
																echo '<option selected value="'.$row['Ruc'].'">'.$row['NombreEmpresa'].'</option>';
															}else{
																echo '<option value="'.$row['Ruc'].'">'.$row['NombreEmpresa'].'</option>';

															}
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td><label class="control-label">País:</label></td>
												<td>
													<select required name="idpais" id="idpais">
														<?php 
														$query = "select * from pais";
														$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
														while($row = mysqli_fetch_array($result)){
															if($row[0]==$idPais){
																echo '<option selected value="'.$row[0].'">'.$row[1].'</option>';
															}else{
																echo '<option value="'.$row[0].'">'.$row[1].'</option>';

															}
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
													<?php 
														$query = "select * from provincia";
														$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
														while($row = mysqli_fetch_array($result)){
															if($row[0]==$idProvincia){
																echo '<option selected value="'.$row[0].'">'.$row[1].'</option>';
															}else{
																echo '<option value="'.$row[0].'">'.$row[1].'</option>';

															}
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td>
													<label class="control-label">Cantón:</label>
												</td>
												<td>
													<select  name="idCant" id="idCant">
													<?php 
														$query = "select * from canton";
														$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
														while($row = mysqli_fetch_array($result)){
															if($row[0]==$idCanton){
																echo '<option selected value="'.$row[0].'">'.$row['nombre'].'</option>';
															}else{
																echo '<option value="'.$row[0].'">'.$row['nombre'].'</option>';

															}
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td><label class="control-label">Dirección:</label></td>
												<td><input name="dirAgen" type="text" placeholder="Dirección" value="<?php echo $direccion; ?>" required></td>
											</tr>
											<tr>
												<td><label class="control-label">Teléfono:</label></td>
												<td><input name="telfAgen" type="tel" placeholder="número de teléfono" value="<?php echo $telefono; ?>" required></td>
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