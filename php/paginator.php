<?php
        //primero obtenemos el parametro que nos dice en que pagina estamos
        $page = 1; //inicializamos la variable $page a 1 por default
        if(array_key_exists('pg', $_GET)){
            $page = $_GET['pg']; //si el valor pg existe en nuestra url, significa que estamos en una pagina en especifico.
        }
        //ahora que tenemos en que pagina estamos obtengamos los resultados:
        // a) el numero de registros en la tabla
        $mysqli = new mysqli("localhost","root","","salasdb");
        if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
      }


        $conteo_query =  $mysqli->query("SELECT COUNT(*) as conteo FROM reserva");
        $conteo = "";
        if($conteo_query){
          while($obj = $conteo_query->fetch_object()){ 
            $conteo =$obj->conteo; 
          }
        }
        $conteo_query->close(); 
        unset($obj); 
        
        //ahora dividimos el conteo por el numero de registros que queremos por pagina.
        $max_num_paginas = intval($conteo/10); //en esto caso 10
      
        // ahora obtenemos el segmento paginado que corresponde a esta pagina
        $segmento = $mysqli->query("SELECT 
    reserva.idReserva,
    reserva.resEvento,
    reserva.resResponsable,
    reserva.resExtension,
    reserva.resUnidad,
    reserva.resFecha,
    reserva.resHora,
    reserva.resDuracion,
    reserva.idEdificio,
    reserva.idSalas,
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
    edificio ON reserva.idEdificio = edificio.idEdificio LIMIT ".(($page-1)*10).", 10 ");

        //ya tenemos el segmento, ahora le damos output.
        if($segmento){
          echo "<table border='0' class='table table-hover' style='font-size:10px;'>";
			
			echo "<tr>";
			echo "<th scope='col'>"."Reservado por:"."</th>";
			echo "<th scope='col'>"."Evento:"."</th>";
			echo "<th scope='col'>"."Sala"."</th>";/*idSala*/
			echo "<th scope='col'>"."Fecha Reserva"."</th>";
			echo "<th scope='col'>"."Hora Reserva"."</th>";
			echo "<th scope='col'>"."Duración"."</th>";
			echo "<th scope='col'>"."Capacidad (Personas)"."</th>";/*salas*/
			echo "<th scope='col'>"."edificio"."</th>";/*edificios*/
			echo "<th scope='col'>"."Localización"."</th>";/*salas*/
			echo "<th scope='col'>"."Descripción Sala"."</th>";/*salas*/
			echo "<th scope='col'>"."Editar"."</th>";
			echo "<th scope='col'>"."Eliminar"."</th>";
			echo "</tr>";
          while($obj2 = $segmento->fetch_object())
          {
             echo "<tr class='filas'>";

				echo "<td>".utf8_encode($obj2->resResponsable)."</td>";
				echo "<td>".utf8_encode($obj2->resEvento)."</td>";
				echo "<td>".utf8_encode($obj2->salNombre)."</td>";
				echo "<td>".utf8_encode($obj2->resFecha)."</td>";
				echo "<td>".utf8_encode($obj2->resHora)."</td>";
				echo "<td>".utf8_encode($obj2->resDuracion)."</td>";
				echo "<td>".utf8_encode($obj2->salCapacidad)."</td>";
				echo "<td>".utf8_encode($obj2->edfNombre)."</td>";
				echo "<td>".utf8_encode($obj2->sallocalizacion)."</td>";
				echo "<td>".utf8_encode($obj2->salDescripcion)."</td>";
				echo "<td>
				<a href='actSala.php?id=".$obj2->idReserva."'>
					<i class='icon-pencil'></i>
				</a>
			</td>";
			echo "<td>
			<a href='../php/listarSalas.php?id=".$obj2->idReserva."&bandera=1'>
				<i class='icon-trash'></i>
			</a>
		</td>";
		echo "</tr>";	
          }
          echo '</table><br/><br/>';
      }
  
        //ahora viene la parte importante, que es el paginado
        //recordemos que $max_num_paginas fue previamente calculado.
        for($i=0; $i<$max_num_paginas;$i++){
           echo '<a href="buscador.php?pg='.($i+1).'">'.($i+1).'</a> | ';
        }      
    ?>