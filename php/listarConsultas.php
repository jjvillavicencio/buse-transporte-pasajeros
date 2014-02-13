<?php 
/*Conexion al servidor de mysql*/

include("../dll/conexionsql.php");
if(!isset($bandera)){
	if (isset($_POST['buscador']))
  {
    if($_POST['diaB']==0){
      $fecha="%-";
    }else{
      $fecha=$_POST['diaB']."-";
    }
    if($_POST['mesB']==0){
      $fecha=$fecha."%-";
    }else{
      $fecha=$fecha.$_POST['mesB']."-";
    }
    if(empty($_POST['anioB'])){
      $fecha=$fecha."%";
    }else{
      $fecha=$fecha.$_POST['anioB'];
    }
    if(empty($_POST['nomEvt'])){
      $evt="%";
    }else{
      $evt=$_POST['nomEvt'];
    }
   if(empty($fecha))
   {
    echo "No se ha ingresado una cadena a buscar";
  }else{	
    /*Obtener los datos de db*/
    $sql="SELECT 
    reserva.idReserva,
    reserva.resEvento,
    reserva.resResponsable,
    reserva.resExtension,
    reserva.resUnidad,
    reserva.resFecha,
    reserva.resH,
    reserva.resM,
    reserva.resDurH,
    reserva.resDurM,
    reserva.idEdificio,
    reserva.idSalas,
    reserva.idRepeticion,
    reserva.resTipo,
    salas.salNombre,
    salas.salCapacidad,
    salas.idEdificio,
    salas.sallocalizacion,
    salas.salDescripcion,
    edificio.idEdificio,
    edificio.edfNombre
    from
    reserva
    inner join
    salas ON reserva.idSalas = salas.idSalas
    inner join
    edificio ON reserva.idEdificio = edificio.idEdificio
    WHERE reserva.resFecha like '%$fecha%' AND upper(reserva.resEvento) like upper('%$evt%')";


    $ressql=mysql_query($sql,$con);
    $totdatos=mysql_num_rows($ressql);
    if($totdatos>0){
     while ($registro=mysql_fetch_array($ressql)) {
      echo " 
      <tr> 
        <td>".$registro['resResponsable']."</td> 
        <td>".$registro['resEvento']."</td> 
        <td>".$registro['salNombre']."</td> 
        <td>".$registro['resFecha']."</td> 
        <td>".$registro['resH'].":".$registro['resM']."</td> 
        <td>".$registro['resDurH'].":".$registro['resDurM']."</td> 
        <td>".$registro['salCapacidad']."</td> 
        <td>".$registro['edfNombre']."</td> 
        <td>".$registro['sallocalizacion']."</td> 
        <td>".$registro['salDescripcion']."</td>
        <td>
          <a href='actEvt.php?id=".$registro['idReserva']."'>
            <i class='icon-pencil'></i>
          </a>
        </td>
        <td>
          <a href='../php/elimEvt.php?id=".$registro['idReserva']."&bandera=1'>
            <i class='icon-trash'></i>
          </a>
        </td>
        <td>
          <a href='../php/elimEvt.php?id=".$registro['idRepeticion']."&bandera=2'>
            <i class='icon-trash'></i>
          </a>
        </td> 

      </tr> 
      ";  
    }  
    echo "
  </table> 
</div>
";
}else{
	echo "No hay datos!!";
}
}
}
}
mysql_close($con);
?>