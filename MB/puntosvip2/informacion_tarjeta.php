<?php require_once('functions/core.php');
$fichero=basename($_SERVER['PHP_SELF']);
$arrayMenu=array(
    'beneficios_tarjeta.php'=>'img/beneficios_tarjeta_1.jpg'
    ,'puntosvip.php'=>'img/consultas_coronitas.jpg'
    ,'preguntas_frecuentes.php'=>'img/preguntas_frecuentes.jpg'
    ,'catalogodetalle.php'=>'images/catalogo_coronitas.jpg')?>
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
                                        <p>Cómo Obtenerla e información general</p>  

                                        <p>Al comprar y registrar tu compra en cualquiera de nuestros 
                                            Atelieres Michèlle Belau o Boutiques Essentiel  S/.300 en 
                                            un solo ticket o S/.600 en varios tickets,  te conviertes automáticamente 
                                            en una VIP. (Very Important Princess). Previa firma del Convenio VIP  
                                            <a target="_blank" href="contrato_mb.pdf" style="color: #e2307c; font-weight: bold;">
                                                Descargar PDF
                                            </a>
                                            </>

                                            <p>La tarjeta física será entregada en el Domicilio indicado
                                                a los 15 días siguientes aproximadamente después de haberla obtenido.</p>

                                            <p>Tu código VIP será tu DNI, el cual te permite ser utilizado para registrar
                                                tu compras y acumular coronitas (puntos), 
                                                así como hacer las consultas de tu estado de cuenta.
                                                Al ser ya una VIP y registrar tus compras, acumularás 5 coronitas (puntos) 
                                                por cada S/.100, estas funcionaran como dinero en efectivo y podrás utilizarlas con
                                                el pago de una suma adicional de ser requerido para adquirir la prenda que elijas. 
                                                Valor de la coronita para canjear: 1 coronita = S/.1</p>

                                            <p>Las coronitas serán ingresadas a tu cuenta a los 3 días calendario de haber sido 
                                                obtenidas y vencen a los 3 meses.</p> 

                                            <p>Si tienes alguna duda, consulta o quieres contactarnos, escríbenos a <a href="mailto:tarjetavip@michellebelau.com">tarjetavip@michellebelau.com</a></p>
                                            <br /><br /><br /><br /><br />
                                    </div>
                                    <?php include('enlaces.php') ?>
                                    <img  src="img/tarjeta6.jpg" 
                                          style="float: left; margin-left: 68px;">
                                </div>




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