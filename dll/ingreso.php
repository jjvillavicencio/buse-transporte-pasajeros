<?php

extract($_POST);
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
	die('Could not connect: ' . mysql_error());
}else{

//echo 'Conectado con éxito al servidor.';

	if (!mysql_select_db("buses_db",$link)) 
	{ 
     // echo "Error seleccionando la base de datos."; 
		exit(); 

	} else{
		$password_original = $contrasena;
		$password_codificado = md5($password_original);
		$result=mysql_query("select idUsuario,nombreUsr, claveUsr from usuarios where nombreUsr = '$usuario' && claveUsr = '$password_codificado'",$link);

		if($row = mysql_fetch_array($result)) { 
			session_start();
			$_SESSION["autenticado"]= $row[0];
			$session_id = session_id();
			$sql2="INSERT INTO sesiones VALUES ('$row[0]','$session_id','$agencia')";
			$result2=mysql_query($sql2,$link);
			echo '<script language = JavaScript> location.href="../pages/agrevento.php" ; </script>';
		} else {
			echo '<script language = JavaScript> alert("Error usuario o contraseña");location.href="../" ; </script>';
		}
		mysql_free_result($result);
	}
}
mysql_close($link);
?>




