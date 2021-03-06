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

  <title>UTPL|Reserva de Salas|Administrador</title>
  <!-- Utpl theme-->
  <script>
      function ConfirmDelete(id,band)
      {
            if (confirm("¿Seguro desea eliminar?"))
                 location.href='../php/elimEvt.php?id='+id+'&bandera='+band;
      }
  </script>
</head>

<body style="font-family:font-family: Arial,Helvetica,Sans-serif">
  <!--========================ENCABEZADO================================ -->
  
  <header>

    <section class="encabezado">

      <div class="logo">
        <a href="www.utpl.edu.ec"><img src="http://www.utpl.edu.ec/sites/all/themes/utpl/images/logo.png"></img></a>
      </div>
      <div class="tituloPag" id="clickeable" onclick="location.href='../index.php';" style="cursor:pointer;">
        <h1 > 
          reserva de salas
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
    <?php
    include("../dll/conexionsql.php");
extract($_GET);
if(!isset($bandera)){
  /*Obtener los datos de db*/
  $sql="SELECT * FROM reserva inner join
    salas ON reserva.idSalas = salas.idSalas
        inner join
    edificio ON reserva.idEdificio = edificio.idEdificio where reserva.idReserva =".$idEvento."";
  $ressql=mysql_query($sql,$con);
  $totdatos=mysql_num_rows($ressql);
  if($totdatos>0){
    echo "<table border='0' class='table table-hover'>";
    echo "<h3 class=\"azul\">Descripción de una Reserva</h3>";
    while ($row=mysql_fetch_array($ressql)) {
      echo "<tr class='filas'>";
      echo "<td>Responsable:</td>";
      echo "<td>".$row['resResponsable']."</td>";
      echo "</tr>";
      echo "<tr class='filas'>";
      echo "<td>Motivo:</td>";
      echo "<td>".$row['resEvento']."</td>";
      echo "</tr>";
      echo "<tr class='filas'>";
      echo "<td>Extensión telefónica:</td>";
      echo "<td>".$row['resExtension']."</td>";
      echo "</tr>";
      echo "<tr class='filas'>";
      echo "<td>Unidad que organiza:</td>";
      echo "<td>".$row['resUnidad']."</td>";
      echo "</tr>";
      echo "<tr class='filas'>";
      echo "<td>Fecha:</td>";
      echo "<td>".$row['resFecha']."</td>";
      echo "</tr>";
      if($row['resAllDay']>0){
        echo "<tr class='filas'>";
        echo "<td>Duración:</td>";
        echo "<td> Todo el día</td>";
        echo "</tr>";
      }else{
        echo "<tr class='filas'>";
        echo "<td>Hora de inicio:</td>";
        echo "<td>".$row['resH'].":".$row['resM'].":00</td>";
        echo "</tr>";
        echo "<tr class='filas'>";
        echo "<td>Hora de finalización:</td>";
        echo "<td>".$row['resDurH'].":".$row['resDurM'].":00</td>";
        echo "</tr>";
      }
      echo "<tr class='filas'>";
      echo "<td>Sala reservada:</td>";
      echo "<td>".$row['salNombre']."</td>";
      echo "</tr>";
      echo "<tr class='filas'>";
      echo "<td>Edificio:</td>";
      echo "<td>".$row['edfNombre']."</td>";
      echo "</tr>";
      echo "<tr class='filas'>";
      echo "<td>Tipo:</td>";
      echo "<td>".$row['resTipo']."</td>";
      echo "</tr>";
      

      echo "<tr>";
      echo "<td>Opciones:</td>";
      $idres=$row['idReserva'];
      $band1=1;
      $ban2=2;
      $idRep=$row['idRepeticion'];
      echo "<td>
              <a href='actEvt.php?id=".$row['idReserva']."'>
                <i class='icon-pencil'></i>EDICIÓN
              </a>
              <a href='#' onclick='ConfirmDelete($idres,$band1)'>
                <i class='icon-trash'></i>ELIMINAR
              </a>
              <a href='#' onclick='ConfirmDelete($idRep,$ban2)'>
                <i class='icon-trash'></i>ELIMINAR REPETICIONES
              </a>

            </td>";
  echo "</tr>"; 
}
echo "</table";
}else{
  echo "No hay datos!!";
}
}else{
if($bandera==1){
  $sql="delete from edificio where idSalas='$id'";
  $ressql=mysql_query($sql,$con);
  header ("Location: ../pages/addedf.php");
}
}
mysql_close($con);

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