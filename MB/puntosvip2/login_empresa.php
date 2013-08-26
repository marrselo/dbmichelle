<?php session_start(); require_once('functions/core.php'); 
$fichero = basename($_SERVER['PHP_SELF']);
if(isset($_POST['ispost']))
{
include("../class/web_enterprise/valig_login_user.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="css/web.css" />
<!--        <link href="css/custom-theme/jquery-ui-1.10.3.custom.css" rel="stylesheet">-->
        <title>Michelle Belau</title>
        <script type="text/javascript" src="js/jquery-1.4.4.js"></script>
<!--        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>-->
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
<!--                                    <h3 class="coronitas">Consulta tus coronitas VIP</h3>-->
<!--                                    <h3 class="ingresa">Ingresa tu código VIP o DNI</h3>-->
                                        <?php  echo titles($fichero) ?>
                                         
                                </div>
                                <div class="contenido">
                                    
                                    <div class="documento">
                                         <?php if(isset($msj_error)){ ?>
                                            <div class="alert"><?php echo $msj_error?></div>
                                            <?php }?>
                                        <form action="" method="post" id="fr_login"> 
                                        <h4>Ingresar RUC</h4>
                                         <input type="text"  name="empresa" >                                        
                                        <br /><br />
                                        <h4>Contraseña</h4>
                                         <input  type="password" name="pass" >
                                        <input type="hidden" name="ispost" value="true">
                                        <div style="display: inline; color: #f00; width: 100%;">
                                            <p id="msj-error" style="margin: 0px; padding: 0px;"> </p>
                                        </div>   
                                        <br />
                                        <img src="images/aceptar.png" width="156"
                                             value="aceptar" id="aceptar"/>
                                         </form> 
                                    </div>

                                    <br /> <br /> <br />
                                    <div class="lema"><h3>lema</h3></div>
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
         <script type="text/javascript" >
        $(document).ready(function(){ 
            $('#aceptar').click(function () {                
                $('#fr_login').submit();
            });
           
        });	       
    </script>
    </body>
</html>