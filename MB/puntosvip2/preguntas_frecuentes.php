<?php require_once('functions/core.php');
$fichero=basename($_SERVER['PHP_SELF']);
$arrayMenu=array(
    'beneficios_tarjeta.php'=>'img/beneficios_tarjeta_1.jpg'
    ,'puntosvip.php'=>'img/consultas_coronitas.jpg'
    ,'informacion_tarjeta.php'=>'img/info_tarjeta.jpg'
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
                                        <b>1. ¿Puede otra persona utilizar mi tarjeta? </b>                                        
                                        <p>NO. La tarjeta VIP Michelle Belau es personal e intrasferible <br />
                                            Se debe solicitar DNI para corroborar la titularidad de la misma
                                        </p>
                                        <b>2. ¿Los puntos y las coronitas son lo mismo? </b>                                        
                                        <p>SI. Los puntos y las coronitas son lo mismo.</p>                                        
                                        <b>3. ¿Cuanto vale cada coronita? </b>                                        
                                        <p>Cada coronita es igual a 1 sol </p>
                                        <b>4. ¿Cómo se acumulan las coronitas? </b>                                        
                                        <p> 
                                            Cada 100 soles de compra se acumulan 5 coronitas, por cada 20 soles
                                            se acumula 1 coronita
                                        </p>
                                        <b>5. ¿Todas mis compras automáticamente acumulan coronitas? </b>                                        
                                        <p>NO. Únicamente las compras que sean registradas con la tarjeta VIP en<br />
                                            cualquiera de los Atelieres MB o las boutiques essentiel 
                                        </p>
                                        <b>6. ¿Cuanto duran mis coronitas? </b>                                        
                                        <p>
                                            Las coronitas se vencen a los 3 meses de haber sido acumuladas y no canjeadas
                                        </p>
                                        <b>7. ¿Como canjeo mis coronitas? </b>                                        
                                        <p> Presentando tu tarjeta a la hora de realizar y pagar tus compras 
                                            en cualquiera de los Ateliers MB y Boutiques Essentiel
                                        </p>
                                        <b>8. ¿Cuantas coronitas puedo usar para mis compras? </b>                                        
                                        <p>Puedes usar tus coronitas como quieras.Pagando solo una parte de tu compra
                                            o utilizandolas para pagar el total de la misma, siempre dependiendo del monto total
                                            de monto total de tu compra y el saldo disponible que tengas.
                                        </p>                                        
                                        <b>9. ¿Cuantas coronitas puedo usar para mis compras? </b>                                        
                                        <p>NO. La tarjeta únicamente es válida para compreas en cualquiera de los <br />
                                            Ateliers M.B o Boutiques Essentiel
                                        </p>
                                        <b>10. ¿Puedo usar mi tarjeta VIP para compras en Ripley? </b>                                        
                                        <p>NO.La tarjeta unicamente es válida para compras en cualquiera de los Ateliers M.B.
                                            o boutiques Essentiel, o en ,<a href="www.michellebellau.com">
                                                www.michellebellau.com</a>
                                        </p>
                                        <b>11. ¿Qué hago en caso de que me roben o se me pierda? </b>                                        
                                        <p>En caso de extravío o robo de tu tarjeta VIP deberas contactarte al:
                                            <br />
                                            <a href="mailto:tarjetavip@michellebelau.com" >tarjetavip@michellebelau.com</a>
                                        </p>
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