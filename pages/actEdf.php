<?php 
include ("../dll/bloqueDeSeguridad.php");
require "../dll/conexion.php";
$objeConexion = new Conexion();
include ("../dll/conexionsql.php");
extract($_GET);
/*Obtener los datos de db*/
$id=base64_decode($id);
$sql="SELECT * from edificio where idEdificio = '$id'";
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){

	while ($row=mysql_fetch_array($ressql)) {
		$id_reg=$row['idEdificio'];
		$nombreEdf=$row['edfNombre'];
		$correo=$row['usrCorreo'];
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
	<link href="../UtplCss/login.css" rel="stylesheet">
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
							<form class="form-horizontal" name="edificio" action="../php/actEdf.php?id=<?php echo base64_encode($id_reg) ?>" method="POST">
								<h3>Editar Edificio:</h3>
								<table>
									<tbody>
									
										<tr>
											<td><label class="control-label">Nombre del Edificio:</label></td>
											<td><input name="edfNombre" type="text" placeholder="Nombre del Edificio" required value="<?php echo "$nombreEdf"; ?>"></td>
										</tr>
										<tr>
											<td><label class="control-label">Correo Administrador:</label></td>
											<td><input name="usrCorreo" type="email" placeholder="Correo Administrador" required value="<?php echo "$correo"; ?>"></td>
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
								</form>
							</center>
						</td>
					</tr>	
				</tbody>	
			</table>
			<?php
			include("../php/listarEdf.php");
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