<?php
include ("../dll/bloqueDeSeguridad.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="docs-assets/ico/favicon.png">
  <link href="../UtplCss/tema.css" rel="stylesheet">
  <link href="../UtplCss/internas.css" rel="stylesheet">

  <title>UTPL|Buscador|Administrador</title>
  <!-- Utpl theme-->
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
          Agregar Tipo de Viaje
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
    <form class="form-inline" action="buscador.php" method="post">
      <label >N° Cédula:</label>
      <input type="text" name="nomEvt">
      <label >Día:</label>
      <select name="diaB"  style="width:60px">
        <?php
        echo '<option value="0" selected>--</option>';
        for ($i=1; $i<=31; $i++) {
          echo '<option value="'.$i.'">'.$i.'</option>';
        }
        ?>
      </select>
      <label>Mes:</label>
      <select name="mesB" style="width:100px">
        <option value="0" selected>--</option>
        <option value="01">Enero</option>
        <option value="02">Febrero</option>
        <option value="03">Marzo</option>
        <option value="04">Abril</option>
        <option value="05">Mayo</option>
        <option value="06">Junio</option>
        <option value="07">Julio</option>
        <option value="08">Agosto</option>
        <option value="09">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11" >Noviembre</option>
        <option value="12">Diciembre</option>
      </select>
      <label>Año:</label>
      <input type="text" class="input-mini" placeholder="Año" name="anioB" style="width:50px">
      <button class="btn" type="button submit" name="buscador" value="1">Buscar</button>
      <button class="btn" type="button submit" name="buscador" value="2">Todos</button>
    </form>

    <div align='center'> 
      <table border='0' class='table table-hover' style='font-size:10px;'> 
        <tr>
          <th scope='col'>N° Factura:</th>
          <th scope='col'>CI Cliente:</th>
          <th scope='col'>Cliente:</th>
          <th scope='col'>Usuario:</th>
          <th scope='col'>Agencia venta</th>
          <th scope='col'>Fecha de Venta</th>
          <th scope='col'>Hora de Venta</th>
          <th scope='col'>SubTotal</th>
          <th scope='col'>IVA</th>
          <th scope='col'>Total</th>
          <th scope='col'>Ver</th>
        </tr>
        <?php 
        if (isset($_POST['buscador']) || isset($_GET['pagi'])){
          if(@$_POST['buscador']==1){
            include("../php/listarConsultas.php");
          }
          if(@$_POST['buscador']==2 || isset($_GET['pagi'])){
            @$pagi = $_GET['pagi'];

$contar_pagi = (strlen($pagi));    // Contamos el numero de caracteres

// Numero de registros por pagina

$numer_reg = 10;

include('../dll/conexionsql.php'); 


// Contamos los registros totales

$query0 = "SELECT 
factura.idFactura,
factura.idCedula,
persona.Nombres,
persona.Apellidos,
agencia.direccion,
factura.usuario,
factura.fecha,
factura.hora,
factura.subTotal,
factura.iva,
factura.total
from
factura
INNER JOIN persona
ON persona.cedula = factura.idCedula
INNER JOIN agencia
ON agencia.idAgencia = factura.agencia
ORDER BY STR_TO_DATE( factura.fecha, '%d-%m-%Y' ) desc";
// Esta linea hace la consulta
$result0 = mysql_query($query0); 
$numero_registros0 = mysql_num_rows($result0); 

##############################################
// ----------------------------- Pagina anterior
$prim_reg_an = $numer_reg - $pagi;
$prim_reg_ant = abs($prim_reg_an);        // Tomamos el valor absoluto

if ($pagi <> 0) 
{ 
  $pag_anterior = "<a href='buscador.php?pagi=$prim_reg_ant'>Pagina anterior</a>";
}
// ----------------------------- Pagina siguiente
$prim_reg_sigu = $numer_reg + $pagi;

if ($pagi < $numero_registros0 - ($numer_reg - 1)) 
{ 
  $pag_siguiente = "<a href='buscador.php?pagi=$prim_reg_sigu'>Pagina siguiente</a>";
}
// ----------------------------- Separador
if ($pagi <> 0 and $pagi < $numero_registros0 - ($numer_reg - 1)) 
{ 
  $separador = "|";
}
// Creamos la barra de navegacion

@$pagi_navegacion = "$pag_anterior $separador $pag_siguiente";

// -----------------------------
##############################################

if ($contar_pagi > 0) 
{ 
// Si recibimos un valor por la variable $page ejecutamos esta consulta

  $query = "SELECT 
factura.idFactura,
factura.idCedula,
persona.Nombres,
persona.Apellidos,
agencia.direccion,
factura.usuario,
factura.fecha,
factura.hora,
factura.subTotal,
factura.iva,
factura.total
from
factura
INNER JOIN persona
ON persona.cedula = factura.idCedula
INNER JOIN agencia
ON agencia.idAgencia = factura.agencia
ORDER BY STR_TO_DATE( factura.fecha, '%d-%m-%Y' ) desc LIMIT $pagi,$numer_reg";
} 
else 
{ 
// Si NO recibimos un valor por la variable $page ejecutamos esta consulta

  $query = "SELECT 
factura.idFactura,
factura.idCedula,
persona.Nombres,
persona.Apellidos,
agencia.direccion,
factura.usuario,
factura.fecha,
factura.hora,
factura.subTotal,
factura.iva,
factura.total
from
factura
INNER JOIN persona
ON persona.cedula = factura.idCedula
INNER JOIN agencia
ON agencia.idAgencia = factura.agencia
ORDER BY STR_TO_DATE( factura.fecha, '%d-%m-%Y' ) desc LIMIT 0,$numer_reg";
} 
$result = mysql_query($query); 
$numero_registros = mysql_num_rows($result); 

while ($registro = mysql_fetch_array($result)){ 
  echo " 
  <tr> 
    <td>".$registro['idFactura']."</td> 
    <td>".$registro['idCedula']."</td> 
    <td>".$registro['Nombres']." ".$registro['Apellidos']."</td> 
    <td>".$registro['usuario']."</td> 
    <td>".$registro['direccion']."</td> 
    <td>".$registro['fecha']."</td> 
    <td>".$registro['hora']."</td> 
    <td>".$registro['subTotal']."</td> 
    <td>".$registro['iva']."</td> 
    <td>".$registro['total']."</td> 
    <td>
      <a href='visuaFactura.php?numFact=".$registro['idFactura']."&visua=1'>
        <i class='icon-pencil'></i>
      </a>
    </td>
    

  </tr> 
  ";  
}  
echo "
</table> 
</div>

<div align='center'> 
  <table border='0' cellpadding='0' cellspacing='0' width='600'>
    <tr> 
      <td width='600' colspan='4'>&nbsp;</td> 
    </tr>
    <tr> 
      <td width='600' colspan='4'><p align='right'>Registros: $numero_registros de un total de $numero_registros0</td> 
    </tr>
  </table> 
</div>

<p align='center'>$pagi_navegacion</p>
";
}
}





?> 


</div>
<!--==========================FIN CONTENEDOR============================== -->
</div>

<!-- FOOTER======================================================== -->
<footer>


  <div class="containerdiv">          
    <div id="cc">
      <a href="http://creativecommons.org/licenses/by-nc-nd/3.0/ec/" target="_blank"><img src="http://www.utpl.edu.ec/sites/all/themes/utpl/images/cc.jpg"></a>
    </div>  
    <div id="contactinfo">  
      <p>San Cayetano Alto  - Loja Ecuador - Línea Gratuita: 1800 8875 8875</p>
    </div>
    <div id="q">  
      Unidad de Gestión de la Comunicación<br>
      Comunicación Digital
    </div>        
  </div>
</footer>
<!-- FIN FOOTER======================================================== -->

</body>
</html>