<?php 
include ("../dll/bloqueDeSeguridad.php");
require "../dll/conexion.php";
$objeConexion = new Conexion();
include ("../dll/conexionsql.php");
extract($_GET);
/*Obtener los datos de db*/
$id=base64_decode($id);
$sql="SELECT * from tipo where idTipo = '$id'";
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){

	while ($row=mysql_fetch_array($ressql)) {
		$idTipo=$row['idTipo'];
		$nombre=$row['nombre'];
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

	<title>UTPL|Reserva de Salas|Administrador</title>
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
					Editar Tipo de Viaje
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
							<form class="form-horizontal" name="edificio" action="../php/actTipo.php?id=<?php echo base64_encode($idTipo); ?>" method="POST">
								<fieldset>
									<legend>Editar Tipo de Viaje</legend>
									<table>
										<tbody>
											
											<tr>
												<td><label class="control-label">Descripcion del Tipo:</label></td>
												<td><input name="tipViaj" type="text" placeholder="Tipo de Viaje" required value="<?php echo $nombre; ?>"></td>
											</tr>
											<tr>
												<td></td>
												<td>
													<center><button class=" btn btn-primary" type="submit"> Guardar </button>
														<button class="btn btn-danger" type="reset"> Limpiar </button>
														<input class="btn btn-warning" type="button" name="Cancelar" value="Cancelar" onClick="location.href='../index.php'">

													</center></td>
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
			include("../php/listarTipo.php");
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