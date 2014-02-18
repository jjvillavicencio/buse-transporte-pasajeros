<?php 
/*Conexion al servidor de mysql*/

include("../dll/conexionsql.php");
if(!isset($bandera)){
	if (isset($_POST['buscador']))
  {
    if($_POST['anioB']==0){
      $fecha="%-";
    }else{
      $fecha=$_POST['anioB']."-";
    }
    if($_POST['mesB']==0){
      $fecha=$fecha."%-";
    }else{
      $fecha=$fecha.$_POST['mesB']."-";
    }
    if(empty($_POST['diaB'])){
      $fecha=$fecha."%";
    }else{
      $fecha=$fecha.$_POST['diaB'];
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
    WHERE factura.fecha like '%$fecha%' AND upper(factura.idCedula) like upper('%$evt%')";


    $ressql=mysql_query($sql,$con);
    $totdatos=mysql_num_rows($ressql);
    if($totdatos>0){
     while ($registro=mysql_fetch_array($ressql)) {
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
          <a href='actEvt.php?id=".$registro['idFactura']."'>
            <i class='icon-pencil'></i>
          </a>
        </td>
        <td>
          <a href='../php/elimEvt.php?id=".$registro['idFactura']."&bandera=1'>
            <i class='icon-trash'></i>
          </a>
        </td>
        <td>
          <a href='../php/elimEvt.php?id=".$registro['idFactura']."&bandera=2'>
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