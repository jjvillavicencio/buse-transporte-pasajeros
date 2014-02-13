<?php 
//Extraer datos enviados por el formulario
extract($_POST);
//Obtener nombre de las salas por ID para alert(log)  cruze de horarios
function nomSalas($idSal,$idEdf) 
{
	//sql para consulta del  nombre de la sala y del edificio
	$sql2="SELECT salas.idEdificio, 
	salas.salNombre,
	edificio.edfNombre 
	from salas 
	inner join edificio on salas.idEdificio = edificio.idEdificio 
	where salas.idSalas = '$idSal' AND salas.idEdificio = '$idEdf'";
	//Importar datos de conexion a la base de datos
	include("../dll/conexionsql.php");
	//Ejecutar SQL
	$ressql=mysql_query($sql2,$con);
	while ($row=mysql_fetch_array($ressql)) {
		//se guarda en una variable el nombre de la sala y del edificio
		$txt= $row['edfNombre']." - ".$row['salNombre'];
		//se retorna la variable
		return $txt;	
	}
}
/*Conexion al servidor de mysql*/
include("../dll/conexionsql.php");
//Fecha de la reserva en formato dd/mm/yyyy (texto)
$fechRes=sprintf("%02s",$dia)."-".sprintf("%02s",$mes)."-".$anio;
//condición para realizar acciones si esta definida una fecha tope
if(isset($diaTop)){
	//Fecha tope en formato dd/mmm/yyyy(texto)
	$fechaTope=sprintf("%02s",$diaTop)."-".sprintf("%02s",$mesTop)."-".$anioTop;
	//fecha tope en formato DATE
	$fechaTope=new DateTime ($fechaTope);
}else{
	//Fecha tope es 00-00-0000 si no esta definida
	$fechaTope=new DateTime ("00-00-0000");
}

//Condición para realizar acciones si el evento esta defido como todo el dia
if(isset($todoDia)){
	//indica que  un evento es todo el dia
	$resAll=true;
	//hora y minutos de reserva y duración son igual a 0
	$horaDur="00";
	$minutosDur="00";
	$hora="00";
	$minutos="00";
}else{
	//Se formatea la hora y minutos de la reserva(texto)
	$hora=sprintf("%02s",$hora);
	$minutos=sprintf("%02s",$minutos);
	//indica que el evento no se realiza todo el día
	$resAll=false;
	//Se guarda la hora y minutos de reserva en nuevas variables
	$resH=$hora;
	$resM=$minutos;
	//se guarda la hora de reserva en formato DATE para calcular la duración
	$resDur=new DateTime(''.$hora.':'.$minutos.':00');
	//Se guarda en nuevas variables la hora y minutos de duración obtenidos del formulario
	$resDurH=$horaDur;
	$resDurM=$minutosDur;
	//Se suman la hora y minutos de duracion a la hora y minutos de reserva
	$resDur->add(new DateInterval('PT'.$resDurH.'H'.$minutosDur.'M'));
	//se obtiene la hora y minutos de duración calculados en variables independientes
	$horaDur=date_format($resDur, 'H');
	$minutosDur=date_format($resDur, 'i');
	//Se almacena la hora de inicio en formato DATE
	$horaTemp=new DateTime(''.$hora.':'.$minutos.':00');
}


//Se ejecutan acciones de acuerdo al tipo de repetición($rep_type) seleccionada en el formulario
switch ($rep_type) {
	//En caso de NINGUNA REPETICIÓN
	case 0:
	//Variable para guardar los nombres salas y edificios de reservas que interfieren
	$log="";
	$noAgregados=0;
	//Se realiza un recorrido de las salas seleccionadas
	for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
		$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
		$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
		$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
		if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
			echo "<script>alert ('Existe un evento todo el dia');
			window.location='../pages/index.php';
		</script>";
		//Si no existen reservas de todo el dia
	}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
		$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
		$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
		$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
		$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
		if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
			if($totdatos>0){
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
				while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
					$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
					$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
					if ($horaTemp==$horaResTemp AND $resDur==$horaResDurTemp) {
							//Se indica que existe una interferencia
						$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
						$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
					}
						//Si aun no se encuentra ninguna interferencia realizar
					if($band==0){
							//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
						if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
						}
					}
						//Si aun no se encuentra ninguna interferencia realizar
					if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
						if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
				}
			}
		}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
			if($totdatos>0){
					//Se indica que provocara una interferencia
				$band = $band+1;
			}
		}
			//Si no existe ninguna interferencia
		if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
			$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
			$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','0')";
				//Ejecuta la sentencia
			if($ressql=mysql_query($sql,$con)){
				
			}
		}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
			if(isset($todoDia)){
					//Mensaje
				echo "<script>alert('Ya existe una reserva en este día');</script>";

			}else{
				$noAgregados=$noAgregados+1;
			}
		}
	}
}
if($noAgregados==0){
	echo "<script>alert('Se agrego la reserva correctamente')</script>";
}else{
	echo "<script>alert('No se agrego la reserva en los siguientes días:\\n $log');</script>";
}
break;
	//En caso de REPETICION DIARIA
case 1:
//Obtenemos el numero de auto incremento que toca para la reserva ya que se lo usara para identificar el grupo de reservas
$rs = mysql_query("select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA='salasdb' and TABLE_NAME='reserva'");
if ($row = mysql_fetch_row($rs)) {
	$id = trim($row[0]);
}
//Guardamos en una variable temporal la fecha de inicio de la reserva
$fechaTemp = new DateTime($fechRes);
$noAgregados=0;
//Variable para guardar los nombres salas y edificios de reservas que interfieren
$log="";
//Mintras la fecha temporal de la reserva sea menor a la fecha limite
while ($fechaTemp <= $fechaTope){
	//Formateamos la fecha en la que se va realizar la reserva
	$fechRes=date_format($fechaTemp, 'd-m-Y');
	//Se realiza un recorrido de las salas seleccionadas
	for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
		$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
		$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
		$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
		if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
			echo "<script>alert ('Existe un evento todo el dia '');
			window.location='../pages/index.php';
		</script>";
			//Si no existen reservas de todo el dia
	}else{	
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
		$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
		$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
		$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
		$band= 0;

			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
		if(!isset($todoDia)){
			if($totdatos>0){
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
				while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
					$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
					$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
					if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
						$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
						$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
					}
						//Si aun no se encuentra ninguna interferencia realizar
					if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
						if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
				}
			}
		}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
			if($totdatos>0){
					//Se indica que provocara una interferencia
				$band = $band+1;
			}
		}
			//Si no existe ninguna interferencia
		if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
			$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
			$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','$id')";
				//Ejecuta la sentencia
			if($ressql=mysql_query($sql,$con)){
				
			}else{
				echo "<script> alert('Error. Reserva no agregada.');</script>";
			}
		}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
			if(isset($todoDia)){
					//Mensaje
				echo "<script>alert('Ya existe una reserva en este día');</script>";

			}else{
				$noAgregados=$noAgregados+1;
			}
		}
	}
}
$intervalo = new DateInterval('P1D');
$fechaTemp->add($intervalo);
}
if($noAgregados==0){
	echo "<script>alert('Se agrego la reserva correctamente')</script>";
}else{
	echo "<script>alert('No se agrego la reserva en los siguientes días:\\n $log');</script>";
}
break;
case 2:
//Obtenemos el numero de auto incremento que toca para la reserva ya que se lo usara para identificar el grupo de reservas
$rs = mysql_query("select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA='salasdb' and TABLE_NAME='reserva'");
if ($row = mysql_fetch_row($rs)) {
	$id = trim($row[0]);
}
//Variable para guardar los nombres salas y edificios de reservas que interfieren
$log="";
$noAgregados=0;
//Guardamos en una variable temporal la fecha de inicio de la reserva
$fechaTemp = new DateTime($fechRes);
$fechRes=$fechaTemp->format('d-m-Y');
//Se realiza un recorrido de las salas seleccionadas
for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
	$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
	$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
	$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
	if($totdatos>0){
		//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
		echo "<script>alert ('Existe un evento todo el dia');window.location='../pages/index.php';</script>";
		//Si no existen reservas de todo el dia
	}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
		$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
		$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
		$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
		$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
		if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
			if($totdatos>0){
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
				while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
					$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
					$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
					if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
						$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
						$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
					}
						//Si aun no se encuentra ninguna interferencia realizar
					if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
						if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
				}
			}
		}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
			if($totdatos>0){
					//Se indica que provocara una interferencia
				$band = $band+1;
			}
		}
			//Si no existe ninguna interferencia
		if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
			$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
			$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','$id')";
				//Ejecuta la sentencia
			if($ressql=mysql_query($sql,$con)){
				
			}else{
				echo "<script> alert('Error. Reserva no agregada.');</script>";
			}
		}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
			if(isset($todoDia)){
					//Mensaje
				echo "<script>alert('Ya existe una reserva en este día');</script>";

			}else{
					$noAgregados=$noAgregados+1;
			}
		}
	}
}
while ($fechaTemp <= $fechaTope) {
	$intervalo = new DateInterval('P1D');
	$fechaTemp->add($intervalo);
	$fecha= "".$fechaTemp->format('Y/m/d'); 
	$consDia = strtotime($fecha);
	$fechRes=$fechaTemp->format('d-m-Y');
	if(isset($rep_day1)){
		if(( jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$consDia),date("d",$consDia), date("Y",$consDia))) == '1')){
			//Se realiza un recorrido de las salas seleccionadas
			for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
				$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
				$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
				$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
				if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
					echo "<script>alert ('Existe un evento todo el dia');
					window.location='../pages/index.php';
				</script>";
		//Si no existen reservas de todo el dia
			}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
				$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
				$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
				$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
				$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
				if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
					if($totdatos>0){
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
						while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
							$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
							$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
							if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
								$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
							}
						//Si aun no se encuentra ninguna interferencia realizar
							if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
								if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
									$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
									$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

								}
							}
						//SI aun no existe una interferencia
							if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
								if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
									$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
									$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
								}
							}
						//SI aun no existe una interferencia
							if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
								if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
									$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
									$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
								}
							}
						}
					}
				}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
					if($totdatos>0){
					//Se indica que provocara una interferencia
						$band = $band+1;
					}
				}
			//Si no existe ninguna interferencia
				if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
					$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
					$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','$id')";
				//Ejecuta la sentencia
					if($ressql=mysql_query($sql,$con)){
						
					}else{
						echo "<script> alert('Error. Reserva no agregada.');</script>";
					}
				}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
					if(isset($todoDia)){
					//Mensaje
						echo "<script>alert('Ya existe una reserva en este día');</script>";

					}else{
						$noAgregados=$noAgregados+1;
					}
				}
			}
		}
	}
}
if(isset($rep_day2)){
	if(( jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$consDia),date("d",$consDia), date("Y",$consDia))) == '2')){
			//Se realiza un recorrido de las salas seleccionadas
		for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
			$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
			$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
			$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
			if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
				echo "<script>alert ('Existe un evento todo el dia');
				window.location='../pages/index.php';
			</script>";
		//Si no existen reservas de todo el dia
		}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
			$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
			$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
			$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
			$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
			if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
				if($totdatos>0){
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
					while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
						$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
						$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
						if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
							$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
						}
						//Si aun no se encuentra ninguna interferencia realizar
						if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
							if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
					}
				}
			}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
				if($totdatos>0){
					//Se indica que provocara una interferencia
					$band = $band+1;
				}
			}
			//Si no existe ninguna interferencia
			if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
				$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
				$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','$id')";
				//Ejecuta la sentencia
				if($ressql=mysql_query($sql,$con)){
					
				}else{
					echo "<script> alert('Error. Reserva no agregada.');</script>";
				}
			}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
				if(isset($todoDia)){
					//Mensaje
					echo "<script>alert('Ya existe una reserva en este día');</script>";

				}else{
					$noAgregados=$noAgregados+1;
				}
			}
		}
	}
}
}
if(isset($rep_day3)){
	if(( jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$consDia),date("d",$consDia), date("Y",$consDia))) == '3')){
			//Se realiza un recorrido de las salas seleccionadas
		for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
			$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
			$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
			$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
			if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
				echo "<script>alert ('Existe un evento todo el dia');
				window.location='../pages/index.php';
			</script>";
		//Si no existen reservas de todo el dia
		}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
			$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
			$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
			$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
			$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
			if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
				if($totdatos>0){
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
					while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
						$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
						$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
						if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
							$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
						}
						//Si aun no se encuentra ninguna interferencia realizar
						if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
							if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
					}
				}
			}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
				if($totdatos>0){
					//Se indica que provocara una interferencia
					$band = $band+1;
				}
			}
			//Si no existe ninguna interferencia
			if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
				$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
				$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','$id')";
				//Ejecuta la sentencia
				if($ressql=mysql_query($sql,$con)){
					
				}else{
					echo "<script> alert('Error. Reserva no agregada.');</script>";
				}
			}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
				if(isset($todoDia)){
					//Mensaje
					echo "<script>alert('Ya existe una reserva en este día');</script>";

				}else{
					$noAgregados=$noAgregados+1;
				}
			}
		}
	}
}
}
if(isset($rep_day4)){
	if(( jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$consDia),date("d",$consDia), date("Y",$consDia))) == '4')){
			//Se realiza un recorrido de las salas seleccionadas
		for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
			$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
			$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
			$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
			if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
				echo "<script>alert ('Existe un evento todo el dia');
				window.location='../pages/index.php';
			</script>";
		//Si no existen reservas de todo el dia
		}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
			$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
			$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
			$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
			$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
			if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
				if($totdatos>0){
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
					while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
						$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
						$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
						if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
							$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
						}
						//Si aun no se encuentra ninguna interferencia realizar
						if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
							if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
					}
				}
			}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
				if($totdatos>0){
					//Se indica que provocara una interferencia
					$band = $band+1;
				}
			}
			//Si no existe ninguna interferencia
			if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
				$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
				$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','$id')";
				//Ejecuta la sentencia
				if($ressql=mysql_query($sql,$con)){
					
				}else{
					echo "<script> alert('Error. Reserva no agregada.');</script>";
				}
			}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
				if(isset($todoDia)){
					//Mensaje
					echo "<script>alert('Ya existe una reserva en este día');</script>";

				}else{
					$noAgregados=$noAgregados+1;
				}
			}
		}
	}
}
}
if(isset($rep_day5)){
	if(( jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$consDia),date("d",$consDia), date("Y",$consDia))) == '5')){
			//Se realiza un recorrido de las salas seleccionadas
		for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
			$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
			$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
			$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
			if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
				echo "<script>alert ('Existe un evento todo el dia');
				window.location='../pages/index.php';
			</script>";
		//Si no existen reservas de todo el dia
		}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
			$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
			$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
			$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
			$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
			if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
				if($totdatos>0){
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
					while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
						$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
						$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
						if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
							$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
						}
						//Si aun no se encuentra ninguna interferencia realizar
						if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
							if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
					}
				}
			}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
				if($totdatos>0){
					//Se indica que provocara una interferencia
					$band = $band+1;
				}
			}
			//Si no existe ninguna interferencia
			if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
				$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
				$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','$id')";
				//Ejecuta la sentencia
				if($ressql=mysql_query($sql,$con)){
					
				}else{
					echo "<script> alert('Error. Reserva no agregada.');</script>";
				}
			}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
				if(isset($todoDia)){
					//Mensaje
					echo "<script>alert('Ya existe una reserva en este día');</script>";

				}else{
					$noAgregados=$noAgregados+1;
				}
			}
		}
	}
}
}
if(isset($rep_day6)){
	if(( jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$consDia),date("d",$consDia), date("Y",$consDia))) == '6')){
			//Se realiza un recorrido de las salas seleccionadas
		for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
			$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
			$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
			$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
			if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
				echo "<script>alert ('Existe un evento todo el dia');
				window.location='../pages/index.php';
			</script>";
		//Si no existen reservas de todo el dia
		}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
			$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
			$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
			$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
			$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
			if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
				if($totdatos>0){
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
					while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
						$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
						$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
						if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
							$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
						}
						//Si aun no se encuentra ninguna interferencia realizar
						if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
							if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
					}
				}
			}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
				if($totdatos>0){
					//Se indica que provocara una interferencia
					$band = $band+1;
				}
			}
			//Si no existe ninguna interferencia
			if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
				$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
				$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','$id')";
				//Ejecuta la sentencia
				$ressql=mysql_query($sql,$con);
			}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
				if(isset($todoDia)){
					//Mensaje
					echo "<script>alert('Ya existe una reserva en este día');</script>";

				}else{
					$noAgregados=$noAgregados+1;
				}
			}
		}
	}
}
}
if(isset($rep_day0)){
	if(( jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$consDia),date("d",$consDia), date("Y",$consDia))) == '0')){
			//Se realiza un recorrido de las salas seleccionadas
		for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
			$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
			$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
			$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
			if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
				echo "<script>alert ('Existe un evento todo el dia');
				window.location='../pages/index.php';
			</script>";
		//Si no existen reservas de todo el dia
		}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
			$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
			$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
			$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
			$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
			if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
				if($totdatos>0){
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
					while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
						$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
						$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
						if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
							$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
						}
						//Si aun no se encuentra ninguna interferencia realizar
						if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
							if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
						//SI aun no existe una interferencia
						if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
							if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
								$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
								$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
							}
						}
					}
				}
			}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
				if($totdatos>0){
					//Se indica que provocara una interferencia
					$band = $band+1;
				}
			}
			//Si no existe ninguna interferencia
			if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
				$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
				$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','$id')";
				//Ejecuta la sentencia
				$ressql=mysql_query($sql,$con);
			}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
				if(isset($todoDia)){
					//Mensaje
					echo "<script>alert('Ya existe una reserva en este día');</script>";

				}else{
					$noAgregados=$noAgregados+1;
				}
			}
		}
	}
}
}


}
if($noAgregados==0){
	echo "<script>alert('Se agrego la reserva correctamente')</script>";
}else{
	echo "<script>alert('No se agrego la reserva en los siguientes días:\\n $log');</script>";
}

break;
case 3:
//Obtenemos el numero de auto incremento que toca para la reserva ya que se lo usara para identificar el grupo de reservas
$rs = mysql_query("select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA='salasdb' and TABLE_NAME='reserva'");
if ($row = mysql_fetch_row($rs)) {
	$id = trim($row[0]);
}
//Almacenamos la fecha de inicio de la reserva
$fechaTemp = new DateTime($fechRes);
$noAgregados=0;
//Variable para guardar los nombres salas y edificios de reservas que interfieren
$log="";
//Mientras la fecha temporal sea menor a la fecha tope
while ($fechaTemp <= $fechaTope){
	$fechRes = "".$fechaTemp->format('d-m-Y');
	//Se realiza un recorrido de las salas seleccionadas
	for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
		$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
		$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
		$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
		if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
			echo "<script>alert ('Existe un evento todo el dia');
			window.location='../pages/index.php';
		</script>";
		//Si no existen reservas de todo el dia
	}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
		$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
		$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
		$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
		$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
		if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
			if($totdatos>0){
				
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
				while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
					$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
					$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
					if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
						$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
						$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
					}
						//Si aun no se encuentra ninguna interferencia realizar
					if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
						if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
				}
			}
		}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
			if($totdatos>0){
					//Se indica que provocara una interferencia
				$band = $band+1;
			}
		}
			//Si no existe ninguna interferencia
		if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
			$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
			$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','0')";
				//Ejecuta la sentencia
			if($ressql=mysql_query($sql,$con)){
				
			}else{
				echo "<script> alert('Error. Reserva no agregada.');</script>";
			}
		}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
			if(isset($todoDia)){
					//Mensaje
				echo "<script>alert('Ya existe una reserva en este día');</script>";

			}else{
				$noAgregados=$noAgregados+1;
			}
		}
	}
}
$intervalo = new DateInterval('P1M');
$fechaTemp->add($intervalo);
}
if($noAgregados==0){
	echo "<script>alert('Se agrego la reserva correctamente')</script>";
}else{
	echo "<script>alert('No se agrego la reserva en los siguientes días:\\n $log');</script>";
}
break;
case 4:
//Obtenemos el numero de auto incremento que toca para la reserva ya que se lo usara para identificar el grupo de reservas
$rs = mysql_query("select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA='salasdb' and TABLE_NAME='reserva'");
if ($row = mysql_fetch_row($rs)) {
	$id = trim($row[0]);
}
//Almacenamos la fecha de inicio de la reserva
$fechaTemp = new DateTime($fechRes);
//Variable para guardar los nombres salas y edificios de reservas que interfieren
$log="";
$noAgregados=0;
while ($fechaTemp <= $fechaTope){
	$fechRes = "".$fechaTemp->format('d-m-Y');
	//Se realiza un recorrido de las salas seleccionadas
	for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
		$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
		$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
		$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
		if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
			echo "<script>alert ('Existe un evento todo el dia');
			window.location='../pages/index.php';
		</script>";
		//Si no existen reservas de todo el dia
	}else{
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
		$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
		$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
		$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
		$band= 0;
			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
		if(!isset($todoDia)){
				//Solo en caso de que existan reservas en el dia seleccionado
			if($totdatos>0){
				
					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
				while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
					$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
					$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
					if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
						$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
						$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
					}
						//Si aun no se encuentra ninguna interferencia realizar
					if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
						if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
				}
			}
		}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
			if($totdatos>0){
					//Se indica que provocara una interferencia
				$band = $band+1;
			}
		}
			//Si no existe ninguna interferencia
		if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
			$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
			$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','0')";
				//Ejecuta la sentencia
			if($ressql=mysql_query($sql,$con)){
				
			}else{
				echo "<script> alert('Error. Reserva no agregada.');</script>";
			}
		}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
			if(isset($todoDia)){
					//Mensaje
				echo "<script>alert('Ya existe una reserva en este día');</script>";

			}else{
				$noAgregados=$noAgregados+1;
			}
		}
	}
}
$intervalo = new DateInterval('P1Y');
$fechaTemp->add($intervalo);
}
if($noAgregados==0){
	echo "<script>alert('Se agrego la reserva correctamente')</script>";
}else{
	echo "<script>alert('No se agrego la reserva en los siguientes días:\\n $log');</script>";
}
break;
case 5:
//Guardamos en una variable temporal la fecha de inicio de la reserva
$fechaTemp = new DateTime($fechRes);
$semanas=$nsemanas*7;
$intervaloSemana = new DateInterval('P'.$semanas.'D');
$fechaTope=new DateTime($fechRes);
$fechaTope=$fechaTope->add($intervaloSemana);
//Obtenemos el numero de auto incremento que toca para la reserva ya que se lo usara para identificar el grupo de reservas
$rs = mysql_query("select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA='salasdb' and TABLE_NAME='reserva'");
if ($row = mysql_fetch_row($rs)) {
	$id = trim($row[0]);
}
$log="";
$noAgregados=0;
//Mintras la fecha temporal de la reserva sea menor a la fecha limite
while ($fechaTemp <= $fechaTope){
	//Formateamos la fecha en la que se va realizar la reserva
	$fechRes=date_format($fechaTemp, 'd-m-Y');
	//Se realiza un recorrido de las salas seleccionadas
	for ($i=0;$i<count($salas);$i++) {
		//SQL para verificar si en la sala seleccionada el dia seleccionado no exista un evento de todo el dia(resAllDay = 1)
		$sql="SELECT idReserva, resEvento, resResponsable FROM reserva WHERE  resAllDay = 1 AND resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ";
		//Se ejecuta el sql
		$ressql=mysql_query($sql,$con);
		//Cuenta los resultados de la consulta
		$totdatos=mysql_num_rows($ressql);
		//Si se a encontrado resuldados de todo el dia
		if($totdatos>0){
			//Presenta una alerta de que ya existe un evento todo el dia y se redirige al index
			echo "<script>alert ('Existe un evento todo el dia '');
			window.location='../pages/index.php';
		</script>";
			//Si no existen reservas de todo el dia
	}else{	
			//SQL para obtener todos los eventos en la fecha, la  sala y el edificio selecionado y ordenarlos por la hora de reserva
		$sql="SELECT idReserva, resEvento, resResponsable, resH, resM, resDurH,resDurM FROM reserva WHERE  resFecha = '$fechRes' AND idSalas = '$salas[$i]' AND idEdificio='$edificio' ORDER BY resH";
			//Ejecutar SQL
		$ressql=mysql_query($sql,$con);
			//Contar el total de resultados
		$totdatos=mysql_num_rows($ressql);
			//Bandera si existe alguna reserva que interfiera con la reserva a crear (==0 si no interfiere =+1 para contar cuantas reservas interfieren)
		$band= 0;

			//Se realiza las acciones solo si no se a marcado la casilla de todo el dia
		if(!isset($todoDia)){
			if($totdatos>0){
					//Variable para guardar los nombres salas y edificios de reservas que interfieren

					//Mientras existan reservas en en la fecha seleccionada y ninguna interfiera aun con la reserva actual
				while ($row=mysql_fetch_array($ressql) AND $band==0) {
						//Hora de inicio de la reserva de la consulta a base de datos tipo DATE
					$horaResTemp=new DateTime(''.$row['resH'].':'.$row['resM'].':00');
						//Hora de duracion de la reserva de la consulta a base de datos tipo DATE
					$horaResDurTemp=new DateTime(''.$row['resDurH'].':'.$row['resDurM'].':00');
						//Si la hora de inicio a reservar esta entre la hora de inicio y la hora de duracion del evento de la consulta
					if ($horaTemp>$horaResTemp AND $horaTemp<$horaResDurTemp) {
							//Se indica que existe una interferencia
						$band = $band+1;
							//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
						$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";
					}
						//Si aun no se encuentra ninguna interferencia realizar
					if($band==0){
							//Si la duracion de la reserva actual esta entre la hora y la duracion del evento de la consulta
						if ($resDur>$horaResTemp AND $resDur<$horaResDurTemp) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";

						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de inicio del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResTemp AND $horaResTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
						//SI aun no existe una interferencia
					if($band==0){
							//Si la hora de duracion del evento de la consulta BD se encuentra en tre la hora de inicio y duracion de la reserva a realizar
						if ($horaTemp<$horaResDurTemp AND $horaResDurTemp<$resDur) {
								//Se indica que existe una interferencia
							$band = $band+1;
								//Se  guarda la fecha en la que existe la interferencia  y el nombr de la sala y del edificio
							$log = " ".$log.$fechRes."en  ". nomSalas($salas[$i],$edificio)."\\n";	
						}
					}
				}
			}
		}else{
				//SI esta marcada la opcion todo el dia y existen mas reservas en la fecha seleccionada
			if($totdatos>0){
					//Se indica que provocara una interferencia
				$band = $band+1;
			}
		}
			//Si no existe ninguna interferencia
		if($band==0){
				//Obtengo el id de la sala en la q esta el FOR
			$sala=$salas[$i];
				//SQL para insertar los valores de la reserva
			$sql="insert  into reserva values('','$nomEv','$perRes','$telfExt','$uniOrg','$fechRes','$hora','$minutos','$horaDur','$minutosDur','$resAll',$edificio,'$sala','$tipo','$id')";
				//Ejecuta la sentencia
			if($ressql=mysql_query($sql,$con)){
				
			}else{
				echo "<script> alert('Error. Reserva no agregada.');</script>";
			}
		}else{
				//Si existen interferencias
				//Si esta seleccionada la opcion todo el dia
			if(isset($todoDia)){
					//Mensaje
				echo "<script>alert('Ya existe una reserva en este día');</script>";

			}else{
				$noAgregados=$noAgregados+1;
			}
		}
	}
}
$intervalo = new DateInterval('P1D');
$fechaTemp->add($intervalo);
}
if($noAgregados==0){
	echo "<script>alert('Se agrego la reserva correctamente')</script>";
}else{
	echo "<script>alert('No se agrego la reserva en los siguientes días:\\n $log');</script>";
}

break;
default:
	# code...
break;
}
echo "<script> window.location='../pages/index.php'</script>";
?>