<?php 
require "../dll/conexion.php";
$objeConexion = new Conexion();
extract($_GET);
$fecha=date("Y")."-".date("m")."-".date("d");
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

	<title>UTPL|Factura|Administrador</title>
	<!-- Utpl theme-->
	<link href="../UtplCss/tema.css" rel="stylesheet">
	<link href="../UtplCss/internas.css" rel="stylesheet">
	<script language="javascript" src="http://code.jquery.com/jquery.js"></script>
	
	<script>
		$(function(){

			function siRespuesta(r){

        // Crear HTML con las respuestas del servidor
        if(r.c1=='no hay'){
        	alert('no existe el cliente');
        	window.location='addPersona.php?ced='+$('#cod').val()+'&act=factura';
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
        var parametros2 = {
        	variable: 3,
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
					Factura
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
				<form class="form-horizontal" name="Socio" action="../php/factura.php?fecha=<?php echo base64_encode($fecha)?>" method="POST">
					<h2>Nueva Factura</h2>
					<div class="bloqueFactura limpiar">
						<table >
							<tbody >
								<tr>
									<td><label>Cédula:</label></td>
									<td class="peq15"><input required type="text" id="cod" name="ced" size="10" value="<?php if(isset($ced)){echo $ced;}else{echo'';} ?>"></td>
									<td><input type="button" value="Buscar" id="botonCalcular" onClick="();" ></td>
								</tr>
								<tr>
									<td>N° de Factura:</td>
									<td class="peq15"><input required type="text" name="numFac" id="numFac"  onkeypress="return justNumbers(event);"></td>
								</tr>
								<tr>
									<td>N° Cédula:</td>
									<td class="peq15"><input type="text" name="cedCli" id="c1" disabled="true"></td>
									<td><label for="">Fecha:</label></td>
									<td class="peq15"><input type="text" name="fecha" id="fecha" value="<?php echo $fecha;?>" size="12" disabled="true"></td>
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
								<tr >
									<td style="margin: 20px 0 0 0 !important; heigth:50px;" colspan="4">
										<center>
											<button class=" btn btn-primary" type="submit"> Guardar </button>
											<button class="btn btn-danger" type="reset"> Limpiar </button>
											<input class="btn btn-warning" type="button" name="Cancelar" value="Cancelar" onClick="location.href='../index.php'">

										</center>
									</td>
								</tr>

							</tbody>
						</table>
					</div>
				</form>
			</div>

		</section>
		<script>
		function justNumbers(e)
		{
			var keynum = window.event ? window.event.keyCode : e.which;
			if ((keynum == 8) || (keynum == 46))
				return true;

			return /\d/.test(String.fromCharCode(keynum));
		}
	</script>
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