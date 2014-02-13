<?php
extract($_GET);
include("../dll/conexionsql.php");
if($opc==1){
$sql="SELECT idProvincia, nombre FROM provincia where idPais = \"".$_POST['elegido']."\"";
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){
	echo '<option value="null" selected=""> Seleccione</option>';
    while($row=mysql_fetch_array($ressql)){
    	if($row['idProvincia']==$_POST['prov']){
			echo "<option selected value=\"".$row['idProvincia']."\">".$row['nombre']."</option>";
		}else{
        echo "<option value=\"".$row['idProvincia']."\">".$row['nombre']."</option>";
    }
    }
}else{
	echo '<option value="null" selected=""> no existen datos</option>';

}
}
if($opc==2){
$sql="SELECT idCanton, nombre FROM canton where idProvincia = \"".$_POST['elegido']."\"";
$ressql=mysql_query($sql,$con);
$totdatos=mysql_num_rows($ressql);
if($totdatos>0){
	echo '<option value="null" selected=""> Seleccione</option>';
    while($row=mysql_fetch_array($ressql)){
    	if($row['idCanton']==$_POST['cant']){
			echo "<option selected value=\"".$row['idCanton']."\">".$row['nombre']."</option>";
		}else{
        echo "<option value=\"".$row['idCanton']."\">".$row['nombre']."</option>";
    }
    }
}else{
	echo '<option value="null" selected=""> no existen datos</option>';

}

}


?>