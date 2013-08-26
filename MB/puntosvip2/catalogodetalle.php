<?php require_once('functions/core.php'); 
$fichero=basename($_SERVER['PHP_SELF']);
$arrayMenu=array(
    'beneficios_tarjeta.php'=>'img/beneficios_tarjeta_1.jpg'
    ,'puntosvip.php'=>'img/consultas_coronitas.jpg'
    ,'informacion_tarjeta.php'=>'img/info_tarjeta.jpg'
    ,'catalogodetalle.php'=>'images/catalogo_coronitas.jpg')
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
                                    <h3 class="princess">Michelle Belau</h3>
                                    <br />
                                    <?php echo titles($fichero) ?>
                                </div>
                                <div class="contenidoWeb">
                                    <div class="textoVertical"> 
                                        <br /><br /><br /><br /><br /><br /><br />
                                        <br /><br /><br /><br /><br /><br /><br />
                                        <br /><br /><br /><br /><br /><br /><br />
                                        <br /><br /><br /><br /><br /><br /><br />                                                                                                                                                          
                                    </div>
                                   
                                </div>

 <?php include('enlaces.php') ?>


                            </div>
                        </div><br />
                    </div>
                </div>
            </div>
            <div class="web_fondo2">
                <div class="web_alineacion">
                    <div class="web_pie">
                        <?php include('footer.php') ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/menu_horizontal.js"></script>
    </body>
</html>