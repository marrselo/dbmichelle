<?php
    session_start();
    $_SESSION['linea']=$_GET['idLinea'];
    $_SESSION['familia']=$_GET['idFamilia'];

    if (isset($_GET['idTemporada'])) {
        $_SESSION['coleccion'] = $_GET['idTemporada'];
    } else {
        if (!isset($_SESSION['coleccion']))
            $_SESSION['coleccion'] = 2;
    }

    include('lib.inc');
	
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    ini_set('date.timezone', 'America/Lima'); 
    header( 'Content-Type: text/html;charset=utf-8' );
    
    $keyMerchant = "";
    $arrDatos = "";
    
    function hmacsha1($key, $data, $hex = false) {
        $blocksize = 64;
        $hashfunc = 'sha1';
        if (strlen($key) > $blocksize)
            $key = pack('H*', $hashfunc($key));
        $key = str_pad($key, $blocksize, chr(0x00));
        $ipad = str_repeat(chr(0x36), $blocksize);
        $opad = str_repeat(chr(0x5c), $blocksize);
        $hmac = pack('H*', $hashfunc(($key ^ $opad) . pack('H*', $hashfunc(($key ^ $ipad) . $data))));
        if ($hex == false) {
            return $hmac;
        } else {
            return bin2hex($hmac);
        }
    }
    
    function pad($n, $length) {
        //$n = $n.toString();
        while(strlen($n) < $length) 
            $n = "0" . $n;
        return $n;
    }

    function getMensajeError($codError){
        $codigoErrores = array (	"0"	 =>	"Approved or Completed Successfully "	,
                                    "1"	 =>	"Refer to Card Issuer "	,
                                    "3"	 =>	"Invalid Merchant "	,
                                    "4"	 =>	"Capture Card "	,
                                    "5"	 =>	"Denegado "	,
                                    "12"	 =>	"Invalid Transaction "	,
                                    "13"	 =>	"Invalid Amount "	,
                                    "14"	 =>	"Invalid Card Number "	,
                                    "15"	 =>	"Invalid Issuer "	,
                                    "30"	 =>	"Format Error "	,
                                    "41"	 =>	"Lost Card "	,
                                    "43"	 =>	"Stolen Card "	,
                                    "45"	 =>	"Tarj. Es cuotas "	,
                                    "51"	 =>	"Insufficiente Funds/Over Credit Limit "	,
                                    "54"	 =>	"Expire Card "	,
                                    "57"	 =>	"Transaction not Permitted to Issuer/Cardholder "	,
                                    "58"	 =>	"Transaction not Permitted to Acquirer/Terminal "	,
                                    "61"	 =>	"Exceeds Withdrawal Amount Limit "	,
                                    "62"	 =>	"Restricted Card "	,
                                    "63"	 =>	"Security Violation "	,
                                    "65"	 =>	"Exceeds Withdrawal Count Limit "	,
                                    "76"	 =>	"Invalid/Non Existent 'To' Account Specified "	,
                                    "77"	 =>	"Invalid/Non Existent 'From' Account Specified "	,
                                    "78"	 =>	"Invalid/Non Existent Account Specified (General) "	,
                                    "84"	 =>	"Invalid Authorization Life Cycle "	,
                                    "91"	 =>	"Authorization System or Issuer System Inoperative "	,
                                    "92"	 =>	"Unable to Route Transaction "	,
                                    "94"	 =>	"Duplicate Transmission Detected "	,
                                    "96"	 =>	"System Error"	,
                                    "ND"	 =>	"Punto-Web Sistema No Disponible"	,
                                    "PD"	 =>	"Punto-Web Permiso Denegado"	,
                                    "KD"	 =>	"Punto-Web Llave Denegada"	,
                                    "NR"	 =>	"Punto-Web Número de Referencia Inválido"	,
                                    "NC"	 =>	"Punto-Web CVC2 Inválido"	,
                                    "NE"	 =>	"Punto-Web Fecha de Expiración Inválida"	,
                                    "IM"	 =>	"Punto-Web Moneda Inválida"	,
                                    "FI"	 =>	"Punto-Web Fecha Inválida"	,
                                    "HI"	 =>	"Punto-Web Hora Inválida"	,
                                    "ID"	 =>	"Punto-Web Diferido Inválido"	,
                                    "IC"	 =>	"Punto-Web Cuota Inválida"	,
                                    "IA"	 =>	"Punto-Web Monto Inválido"	,
                                    "CC"	 =>	"Punto-Web Tarjeta de Crédito Inválida"	,
                                    "MC"	 =>	"Punto-Web Comercio Inválido"	,
                                    "SM"	 =>	"Punto-Web Secure Code Mensaje"	,
                                    "EC"	 =>	"Punto-Web Error de Criptografía"	,
                                    "HM"	 =>	"Punto-Web Hash Inválido"	);

        if(array_key_exists($codError,$codigoErrores))
            return $codigoErrores[$codError]; //." (".$codError.")";
        else
            return "Operacion Denegada.";
    }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Michelle Belau - Tienda Virtual</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Tienda Virtual">
        <meta name="author" content="Michelle Belau - Tienda Virtual">

        <!-- Le styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">

        <link href="css/lightbox.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="shortcut icon" href="../assets/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    </head>

    <body>    

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <input type="hidden" id="temporada" value="<?php echo $_SESSION['coleccion']; ?>" />
                    <ul class="nav">
                        <li class="active"><a href="index.php">SHOP ON-LINE</a></li>
                        <li><a href="http://www.michellebelau.com/es/bienvenido">WEB</a></li>
                        <li><a href="#">CAT&Aacute;LOGO</a></li>
                    </ul>
                    <div style="position: absolute; left: 67%; display: block; height: 35px; width: 110px; padding-top: 5px;">
                        <a href="https://www.facebook.com/michellebelau" target="_blank"><img src="img/ico-fb-blanco.png" /></a>
                        <a href="#"><img src="img/ico-tw-blanco.png" /></a>
                        <a href="http://www.youtube.com/channel/UCXxb52AXcva5ZQQtPFtPjcw?feature=mhee" target="_blank"><img src="img/ico-yt-blanco.png" /></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit">        
                <div style="margin: auto 0; padding: 25px 0px; margin: 0px;">
                    <a href="index.php"><img src="img/logo.jpg"></a>
                </div>
            </div>

        </div>

        <div class="container" style="border-top: 2px solid #d0d0d0;">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit">

                <div id='cssmenu'>
                    <ul>
                        <li><a href='index.php'><span><img src="img/ico-hm-plomo.png" border="0" /></span></a></li>
                        <li class='has-sub' ><a href="index.php"><span>OTO&Nacute;O - INVIERNO</span></a>
                            <ul class="menu-items menu-items-1">
                                <div class="linea"></div>
                                <li><a href="#"><span>Cargando ... </span></a></li>
                            </ul>
                        </li>
                        <li class='has-sub'><a href="index.php    "><span>PRIMAVERA - VERANO</span></a>
                            <ul class="menu-items menu-items-2">                          
                                <div class="linea"></div>
                                <li><a href="#"><span>Cargando ... </span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div id="buscador" >
                    <input type="text" name="buscador" id="texto-buscar" placeholder="SEARCH MB" onkeydown="presionartecla(event)"/> 
                    <input type="button" name="buscar" id="boton-buscar" onclick="buscar()" />
                    <a href="carritocompras.php"><img src="img/ico-sh-plomo.png" border="0" /> CART</a>
                </div>

            </div>

            <div class="row-fluid">

                <div id="titulo2"><h3 class="articulo-titulo">PROCESO DE COMPRA</h3></div>

                <br/><br/>
                <?php 
                $strValor = "";
                //echo $_POST['O1'];
                if( $_POST['O1'] == 'A' ) {
                    $keyMerchant = "n9yA9r4SedrUmuSeh4wRejEpAc7aHeCE";
                    
                    $HashPuntoWeb = urldecode(O20);

                    $arrDatos[] = $_POST['O1']; //Resultado
                    $arrDatos[] = $_POST['O2']; //Cod Autorizacion
                    $arrDatos[] = $_POST['O3']; //Nro Referencia
                    $arrDatos[] = $_POST['O8']; //Moneda
                    $arrDatos[] = $_POST['O9']; //Monto
                    $arrDatos[] = $_POST['O10']; //Nro Orden
                    $arrDatos[] = $_POST['O13']; //Codigo respuesta
                    $arrDatos[] = $_POST['O15']; // Tarjeta de Credito
                    $arrDatos[] = $_POST['O18']; // Codigo Cliente
                    $arrDatos[] = $_POST['O19']; // Codigo Pais
                    $arrDatos[] = $keyMerchant; // KeyMerchant

                    $cadenafinal = implode("", $arrDatos);

                    $strHash = base64_encode(hmacsha1($keyMerchant, $cadenafinal));

                    if($HashPuntoWeb == $strHash) {
                        $strValor .= "

                        <div class='datagrid'>
                            <table>
                            <tbody>
                                <tr>
                                    <td>Estado de la operaci&oacute;n</td>
                                    <td><b>Denegada</b></td>
                                </tr>
                                <tr class='alt'>
                                    <td>N&uacute;mero de Pedido</td>
                                    <td>".$_POST['O10']."</td>
                                </tr>
                                <tr>
                                    <td>C&oacute;digo de Autorizaci&oacute;n</td>
                                    <td>".$_POST['O2']."</td>
                                </tr>
                                <tr class='alt'>
                                    <td>Monto de la Transacci&oacute;n</td>
                                    <td>".$_POST['O9']."</td>
                                </tr>
                                <tr>
                                    <td>Numero de Tarjeta</td>
                                    <td>".$_POST['O15']."</td>
                                </tr>
                                <tr  class='alt'>
                                    <td>Descripcion del Error</td>
                                    <td>".getMensajeError($_POST['O13'])."</td>
                                </tr>
                                <tr>
                                    <td>Fecha y Hora</td>
                                    <td>".$_POST['O11']." ".$_POST['O12']."</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>";
                    }
                    else {
                        $strValor .= "

                        <div class='datagrid'>
                            <table>
                            <tbody>
                                <tr>
                                    <td>Estado de la operaci&oacute;n</td>
                                    <td><b>Denegada</b></td>
                                </tr>
                                <tr class='alt'>
                                    <td>N&uacute;mero de Pedido</td>
                                    <td>".$_POST['O10']."</td>
                                </tr>
                                <tr class='alt'>
                                    <td>Monto de la Transacci&oacute;n</td>
                                    <td>".$_POST['O9']."</td>
                                </tr>
                                <tr>
                                    <td>Numero de Tarjeta</td>
                                    <td>".$_POST['O15']."</td>
                                </tr>
                                <tr  class='alt'>
                                    <td>Descripcion del Error</td>
                                    <td>".getMensajeError($_POST['O13'])."</td>
                                </tr>
                                <tr>
                                    <td>Fecha y Hora</td>
                                    <td>".$_POST['O11']." ".$_POST['O12']."</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>";
                    }
                }
                else {
                    
                    $strValor .= "

                    <div class='datagrid'>
                        <table>
                        <tbody>
                            <tr>
                                <td>Estado de la operaci&oacute;n</td>
                                <td><b>Denegada</b></td>
                            </tr>
                            <tr class='alt'>
                                <td>N&uacute;mero de Pedido</td>
                                <td>".$_POST['O10']."</td>
                            </tr>
                            <tr>
                                <td>Monto de la Transacci&oacute;n</td>
                                <td>".$_POST['O9']."</td>
                            </tr>
                            <tr class='alt'>
                                <td>Numero de Tarjeta</td>
                                <td>".$_POST['O15']."</td>
                            </tr>
                            <tr>
                                <td>Descripcion del Error</td>
                                <td>".getMensajeError($_POST['O13'])."</td>
                            </tr>
                            <tr  class='alt'>
                                <td>Fecha y Hora</td>
                                <td>".$_POST['O11']." ".$_POST['O12']."</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>";
                }
                echo $strValor;
                 ?>           
                <br />



            </div>
            
            <?php include 'piepagina.php'; ?>
            
        </div>

        

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    
    <script type="text/javascript" src="js/jquery.tinycarousel.min.js"></script>
    <script type="text/javascript" src="js/lightbox.js"></script>
    <script type="text/javascript" src="js/operaciones.js"></script>
    
    <script type="text/javascript">
        
        var json_productos = eval('(<?php echo json_encode($_SESSION['productos']); ?>)');
        var json_producto = eval('(<?php echo json_encode($_SESSION['producto']); ?>)');
        var json_stocks = eval('(<?php echo json_encode($_SESSION['stocks']); ?>)');        
        var json_articulo = eval('(<?php echo json_encode($_SESSION['articulo']); ?>)');
        
        $(document).ready(function(){

            obtenerLineas();
                        
        });
        
        function presionartecla(e){
            var key;  
            var keychar;  

            if(window.event || !e.which) // IE  
            {  
                key = e.keyCode; // para IE  
            }  
            else if(e) // netscape  
            {  
                key = e.which;  
            }  
            else  
            {  
                return true;  
            }  

            if (key==13) //Enter  
            {  
              // codigo aqui  
              buscar();
            }  
        }
        
        
        function buscar() {         
            if($('#texto-buscar').val().length < 3 && $('#texto-buscar').val().length > 10) { 
                alert('Por favor, ingrese el nombre valido del producto que desea buscar.'); 
            }
            else{
                document.location.href = 'articulos.php?temporada=1&buscar=true&texto='+$('#texto-buscar').val();
            }
        }
    
    </script>
  </body>
</html>