<?php 
require "../dll/conexion.php";
$objeConexion = new Conexion();
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

    <title>UTPL|Buses de Transporte|Administrador</title>
    <!-- Utpl theme-->
    <link href="../UtplCss/tema.css" rel="stylesheet">
    <link href="../UtplCss/internas.css" rel="stylesheet">
    <script language="javascript" src="http://code.jquery.com/jquery.js"></script>
    
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
                    Bienvenido
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
                    <div class="bloque limpiar">
                        <p style="font-size:45px; margin:20px auto 0 auto;">Bienvenido al Sistema  </p>
                    </div>
                    <div class="bloque limpiar">
                        <img src="../img/logo.png" style="height:200px;">
                    </div>
            </div>
        </section>
        <script src="http://code.jquery.com/jquery.js"></script>
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