<?php 
include ("../dll/bloqueDeSeguridad.php");
require "../dll/conexion.php";
$objeConexion = new Conexion();
include ("../dll/conexionsql.php");
extract($_POST);
extract($_GET);
$mas=0;
/*Obtener los datos de db*/
$id=base64_decode($id);
$numFac=base64_decode($numFac);
$sql="SELECT b.numBoleto,b.numFactura,b.cedulaCliente, b.idTurno, b.numAsiento, t.fecha, c.idProvincia,p.idPais
from boleto b
INNER JOIN turno t
ON t.idTurno = b.idTurno
INNER JOIN rutas r
ON r.idRuta = t.idRuta
INNER JOIN canton c
ON c.idCanton = r.LugarPartida
INNER JOIN provincia p
ON p.idProvincia = c.idProvincia
where numBoleto = '$id'";
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){

	while ($row=mysql_fetch_array($ressql)) {
		$numBoleto=$row['numBoleto'];
		$numFactura=$row['numFactura'];
		$cedulaCliente=$row['cedulaCliente'];
		$idTurno=$row['idTurno'];
		$numAsiento=$row['numAsiento'];
		$fecha=$row['fecha'];
		$idProvincia=$row['idProvincia'];
		$idPais=$row['idPais'];
	}
list($año, $mes, $dia) = split('[/.-]', $fecha);
	$fecha=$dia."/".$mes."/".$año;
}else{
	echo "No hay datos!!";
}
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
	<link href="../dll/calendario_dw/calendario_dw-estilos.css" rel="stylesheet">
	<script language="javascript" src="http://code.jquery.com/jquery.js"></script>
	<script type="text/javascript" src="../dll/calendario_dw/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="../dll/calendario_dw/calendario_dw.js"></script>
	<script>
		$(document).ready(function(){
			document.getElementById("cod").value= "<?php echo $cedulaCliente ?>";
			document.getElementById("fecha").value= "<?php echo $fecha ?>";
			document.getElementById("idpais").value= "<?php echo $idPais ?>";
		})
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".campofecha").calendarioDW();
		})
	</script>
	<script>
		$(function(){

			function siRespuesta(r){

        // Crear HTML con las respuestas del servidor
        if(r.c1=='no hay'){
        	alert('no existe el cliente');
        	window.location='addPersona.php?ced='+$('#cod').val()+'&act=boleto';
        }else{
        	document.getElementById("c1").value= r.c1;
        	document.getElementById("c2").value= r.c2;
        	document.getElementById("c3").value= r.c3;
        	document.getElementById("c4").value= r.c4;
        	document.getElementById("c5").value= r.c5;
        	document.getElementById("c6").value= r.c6;
        }
        
    }

    function siError(e){
    	alert('Ocurrió un error al realizar la petición: '+e.statusText);
    }

    function peticion(e){
        // Realizar la petición
        var parametros = {
        	variable1: $('#cod').val()
        };

        var post = $.post("../php/consultaCliente.php", parametros, siRespuesta, 'json');

        /* Registrar evento de la petición (hay mas)
        (no es obligatorio implementarlo, pero es muy recomendable para detectar errores) */

    	post.error(siError);         // Si ocurrió un error al ejecutar la petición se ejecuta "siError"
    }

    $('#botonCalcular').click(peticion); // Registrar evento al boton "Calcular" con la funcion "peticion"
});
</script>
<script>
	$(function valores(){
		$("#idTurno").change(peticion2);

		function siRespuesta2(r){
        // Crear HTML con las respuestas del servidor
        if(r.c1!="no hay"){
        	document.getElementById("c7").value= r.c1;
        	document.getElementById("c8").value= r.c2;
        	document.getElementById("c9").value= r.c3;
        	document.getElementById("c11").value= r.c4;
        	asientos();
        }
    }

    function siError2(e){
    	alert('Ocurrió un error al realizar la petición: '+e.statusText);
    }

    function peticion2(e){
        // Realizar la petición
        var turno = $("#idTurno").val();        
        var parametros2 = {
        	variable: turno,
        	varia:null
        };
        var post2 = $.post("../php/retornaTurnos.php?opc=2", parametros2, siRespuesta2, 'json');

        /* Registrar evento de la petición (hay mas)
        (no es obligatorio implementarlo, pero es muy recomendable para detectar errores) */

    	post2.error(siError2);         // Si ocurrió un error al ejecutar la petición se ejecuta "siError"
    }
    function asientos(){
    	$("#idTurno option:selected").each(function () {
    		elegido=$(this).val();
    		$.post("../php/retornaTurnos.php?opc=3", { elegido: elegido }, function(data){
    			$("#c10").html(data);
    		});            
    	});
    }
    
});</script>

<script language="javascript">
	$(document).ready(
		function (){
			$("#idpais").change(function () {
				$("#idpais option:selected").each(function () {
					elegido=$(this).val();
					$.post("../php/retornaProv.php?opc=1", { elegido: elegido }, function(data){
						$("#idProv").html(data);
					});            
				});
			});
			
			$("#idProv").change(function () {
				$("#idProv option:selected").each(function () {
					elegido=$(this).val();
					$.post("../php/retornaProv.php?opc=2", { elegido: elegido }, function(data){
						$("#idCant").html(data);
					});            
				});
			});
			$("#idCant").change(function () {
				$("#idCant option:selected").each(function () {
					elegido=$(this).val();
					fecha= $('#fecha').val();

					$.post("../php/retornaTurnos.php?opc=1", { elegido: elegido, fecha: fecha }, function(data){
						$("#idTurno").html(data);
					});            
				});
			});

		});
</script>
<script>
	function enviar(opc){
		if(opc==1){
			document.getElementById("mas").value=1;
			document.boleto.submit();
		}

	}
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
					Editar Boleto
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
			<div id="padre" class="limpiar">
				<form class="form-horizontal" name="boleto" action="../php/actBoleto.php?numBol=<?php echo base64_encode($numBoleto); ?>&numFac=<?php echo base64_encode($numFac); ?>" method="POST">
					<h2>Editar Boleto</h2>
					<div class="bloque limpiar" style="height:200px;">
						<table >
							<tbody >
								<tr>
									<td><label>Cédula:</label></td>
									<td class="peq15"><input type="text" id="cod" name="cedula" size="10" value="<?php if(isset($cedula)){echo $cedula;}else{echo'';} ?>"></td>
									<td><input type="button" value="Buscar" id="botonCalcular" onClick="();"></td>
								</tr>
								<tr>
									<td>N° Cédula:</td>
									<td class="peq15"><input type="text" name="cedCli" id="c1" disabled="true"></td>
								</tr>
								<tr>
									<td><label for="nomCli">Nombre:</label></td>
									<td colspan="3" class="names"><input type="text" name="nomCli" id="c2" disabled="true"></td>
								</tr>
								<tr>
									<td><label for="apellCli">Apellido:</label></td>
									<td colspan="3" class="names"><input type="text" name="apellCli" id="c3" disabled="true"></td>
								</tr>
								<tr>
									<td><label for="">Dirección:</label></td>
									<td colspan="3" class="names"><input type="text" disabled="true" id="c4"></td>
								</tr>
								<tr>
									<td><label for="">Teléfono:</label></td>
									<td class="peq15"><input type="text" disabled="true" id="c5"></td>
									<td><label>Correo:</label></td>
									<td class="peq15"><input type="text" disabled="true" id="c6"></td>
								</tr>
								<tr>
								<td>
								<input type="hidden"  id="mas" name="mas" value="<?php echo $mas; ?>">
								</td>
								</tr>

							</tbody>
						</table>
					</div>
					<div class="bloque limpiar" style="height:200px;">
						<table>
							<tbody>
								<tr>
									<td><label for="">Fecha del Turno:</label></td>
									<td class="peq15"><input type="text" name="fecha" id="fecha"class="campofecha" size="12"></td>
									<td><label>Pais:</label></td>
									<td class="peq15">
										<select id="idpais">
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
									<td><label>Provincia:</label></td>
									<td class="peq15">
										<select id="idProv">
											<?php 
											$query = "select * from provincia where idPais=$idPais";
											$result = mysqli_query($objeConexion->conectarse(), $query) or die(mysqli_error());;
											while($row = mysqli_fetch_array($result)){
												if($row["idProvincia"]==$idProvincia){
												echo '<option selected value="'.$row["idProvincia"].'">'.$row["nombre"].'</option>';
												}else{
												echo '<option  value="'.$row["idProvincia"].'">'.$row["nombre"].'</option>';	
												}

											}
											?>
										</select>
									</td>
									<td><label>Ciudad:</label></td>
									<td class="peq15">
										<select id="idCant">
											<option></option>
										</select>
									</td>
								</tr>
								<tr>
									<td><label for="idTurno">Turno:</label></td>
									<td class="peq15">
										<select id="idTurno" name="idTurno">
											<option selected="true">

											</option>
										</select>
									</td>
									<td><label for="idBus">N° Bus:</label></td>
									<td class="peq15">
										<input type="text" name="idBus" id="c7">
									</td>
								</tr>
								<tr>
									<td><label for="hs">Hora de Salida:</label></td>
									<td class="peq15"><input type="text" name="hs" id="c8"></td>
									<td ><label for="idTipo">tipo</label></td>
									<td class="peq15"><input type="text" name="idTipo" id="c9" disabled="true"></td>
								</tr>
								<tr>
									<td><label for="">Asiento:</label></td>
									<td class="peq15">
										<select name="asiento" id="c10">
											<option></option>
										</select>
									</td>
								</tr>
								<tr>
									<td><label for="">Precio:</label></td>
									<td class="peq15">
										<input type="text" id="c11">
									</td>
								</tr>
							</tbody>
						</table>

					</div>
					<div >

						<table style="margin:50px auto 0 auto;">
							<tbody>
								<tr >
									<td style="margin: 20px 0 0 0 !important; heigth:50px;">
										<center><button class=" btn btn-primary" type="submit"> Aceptar </button>
										<input class="btn btn-warning" type="button" name="Cancelar" value="Cancelar" onClick="location.href='../index.php'">
										<button class="btn btn-warning" type="reset"> Limpiar </button>
										</center></td>
									</tr>
								</tbody>
							</table>
						</div>
					</form>
				</div>

			</section>
			<script src="../boot/js/bootstrap.min.js"></script>
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