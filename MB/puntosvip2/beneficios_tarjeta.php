<?php require_once('functions/core.php'); 
$fichero=basename($_SERVER['PHP_SELF']);
$arrayMenu=array(
    'informacion_tarjeta.php'=>'img/info_tarjeta.jpg'
    ,'puntosvip.php'=>'img/consultas_coronitas.jpg'   
    ,'preguntas_frecuentes.php'=>'img/preguntas_frecuentes.jpg'
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
                                        <p>Ser VIP es ser parte de un exclusivo grupo de personas que gozan de beneficios aún más especiales en nuestros Atelieres Michèlle Belau, boutiques Essentiel y en establecimientos asociados.
                                            Previa firma del convenio VIP <span style="color: #e2307c; font-weight: bold;">
                                                <a style="color: #e2307c" href='contrato_mb.pdf' 
                                                   target="_blank">Descargar PDF</a>
                                            </span>
                                        </p>

                                        <p><strong>Beneficios VIP Michèlle Belau</strong></p>
                                        <ul class="lista" >
                                            <li>Al realizar y registrar tus compras en nuestros Atelieres Michèlle Belau y boutique Essentiel, acumularás puntos (coronitas).</li>
                                            <li>Acumulas 5 coronitas por cada S/.100 en compras realizadas en Nuestros Atelieres Michèlle Belau y Essentiel. </li>
                                            <li>En tu 1° compra siendo VIP acumulas el triple de coronitas.</li>
                                            <li>Puedes pagar hasta el 100% del valor de la prenda con coronitas. </li>
                                            <li>Tendrás acceso a promociones y a eventos exclusivos.</li>
                                            <li>En el mes de tu cumpleaños (durante todo el mes) tendrás el descuento especial del 15% en todas tus compras sobre precio regular y 5% adicional de ya estar con descuento la pieza. Además de la acumulación de coronitas.</li>
                                        </ul>                
                                        <p><strong>Beneficios Establecimientos Asociados</strong></p>
                                        <p><a href="establecimientos_afiliados.php">
                                                Has click  aquí
                                            </a>
                                        </p>    
                                        <br /><br /><br />
                                        <p>Si tienes alguna duda, consulta o quieres contactarnos, escríbenos a <a href="mailto:tarjetavip@michellebelau.com">tarjetavip@michellebelau.com</a></p> 
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
                        <?php include('footer.php')?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/menu_horizontal.js"></script>
    </body>
</html>