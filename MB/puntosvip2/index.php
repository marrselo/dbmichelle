<?php 
$fichero=basename($_SERVER['PHP_SELF']);
$arrayMenu=array(
    'beneficios_tarjeta.php'=>'img/beneficios_tarjeta_1.jpg'
    ,'puntosvip.php'=>'img/consultas_coronitas.jpg'
    ,'preguntas_frecuentes.php'=>'img/preguntas_frecuentes.jpg'
    ,'catalogodetalle.php'=>'images/catalogo_coronitas.jpg');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="css/web.css" />
        <title>Michelle Belau</title>
        <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    </head>
    <body>
        <div class="web_seccion">
            <div class="web_fondo1">
                <div class="web_alineacion">
                    <div class="web_cabecera">
                        <?php include("header.php"); ?>
                    </div>
                    <div class="web_principal">
                        <div class="web_columna1">
                            <div class="consulta">
                                <div class="titulo">
                                    <h2 class="welcome">Bienvenido a Tarjeta Vip</h2>
                                    <h4 class="subtitle">Programa Exclusivo para Perú
                                        <img border="0" src="img/peru.jpg">
                                    </h4>
                                </div>
                                <div class="contenidoWeb">
                                    <div class="home-img">                                                                
                                        <img  border="0" src="img/galeria2.jpg">
                                    </div>
                                    <div class="inform">
                                        <a href="informacion_tarjeta.php">
                                           <img src="img/reglamento.jpg">
                                        </a>
                                    </div>	
                                    <div class="cleardiv"></div>
                                    <br />
                                    <div class="tarjeta">
                                        <img src="img/tarjeta6.jpg">
                                    </div>

                                    <?php include('enlaces.php') ?>                                    
                                    <div class="cleardiv"></div>
                                </div>




                            </div>
                        </div><br />
                    </div>
                </div>
            </div>
            <div class="web_fondo2">
                <div class="web_alineacion">
                    <div class="web_pie">
                        <div class="menu">
                            <ul>
                                <li><a href="#">Términos y/o condiciones de uso</a></li>
                                <li>|</li>
                                <li><a href="#">Copyright 2012 todos los derechos reservados</a></li>
                                <li>|</li>
                                <li><a href="#">Trabaja con Nosotros</a></li>
                                <li>|</li>
                                <li><a href="#">Registrate como cliente</a></li>
                            </ul><br />
                        </div>
                        <div class="premio"> 
                            <img alt="" src="images/premio.png" /> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/menu_horizontal.js"></script>
    </body>
</html>