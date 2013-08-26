<?php
    session_start();
    $_SESSION['coleccion']=2;

    include('lib.inc');
	
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    ini_set('date.timezone', 'America/Lima'); 
    header( 'Content-Type: text/html;charset=utf-8' );
?>
<?php

	if (isset($_POST["eticket"])) {
		//print_r($_POST);
	
		//Se asigna el Eticket
		$eTicket= $_POST["eticket"];
		$codTienda = CODIGO_TIENDA;
		
		//Se arma el XML de requerimiento
		$xmlIn = "";
		$xmlIn = $xmlIn . "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
		$xmlIn = $xmlIn . "<consulta_eticket>";
		$xmlIn = $xmlIn . "	<parametros>";
		$xmlIn = $xmlIn . "		<parametro id=\"CODTIENDA\">";
		$xmlIn = $xmlIn . $codTienda;//Aqui se asigna el C򣨧o de tienda
		$xmlIn = $xmlIn . "</parametro>";
		$xmlIn = $xmlIn . "		<parametro id=\"ETICKET\">";
		$xmlIn = $xmlIn . $eTicket;//Aqui se asigna el eTicket
		$xmlIn = $xmlIn . "</parametro>";
		$xmlIn = $xmlIn . "	</parametros>";
		$xmlIn = $xmlIn . "</consulta_eticket>";
		
		//Se asigna la url del servicio
		//En producci򬟣ambiar�a URL
		$servicio= URL_WSCONSULTAETICKET_VISA; 
		
		//Invocaci򬟡l web service
		$client = new SoapClient($servicio);
		//print_r($client);
		//exit;
		//parametros de la llamada
		$parametros=array(); //parametros de la llamada
		$parametros['xmlIn']= $xmlIn;
		//Aqui captura la cadena de resultado
		$result = $client->ConsultaEticket($parametros);
		//Muestra la cadena recibida
		//echo '<br><br>Cadena de respuesta: ' . $result->ConsultaEticketResult . '<br>' . '<br>';
		
		
	}
?>

<?php
	//Funcion de ejemplo que obtiene la cantidad de operaciones
	function CantidadOperaciones($xmlDoc, $eTicket){
		$cantidaOpe= 0;
		$xpath = new DOMXPath($xmlDoc);
		$nodeList = $xpath->query('//pedido[@eticket="' . $eTicket . '"]', $xmlDoc);
		
		$XmlNode= $nodeList->item(0);
		
		if($XmlNode==null){
			$cantidaOpe= 0;
		}else{
			$cantidaOpe= $XmlNode->childNodes->length;
		}
		return $cantidaOpe; 
	}
	
	//Funcion que recupera el valor de uno de los campos del XML de respuesta
	function RecuperaCampos($xmlDoc,$sNumOperacion,$nomCampo){
			$strReturn = "";
			
			$xpath = new DOMXPath($xmlDoc);
			$nodeList = $xpath->query("//operacion[@id='" . $sNumOperacion . "']/campo[@id='" . $nomCampo . "']");
			
			$XmlNode= $nodeList->item(0);
			
			if($XmlNode==null){
				$strReturn = "";
			}else{
				$strReturn = $XmlNode->nodeValue;
			}
			return $strReturn;
	}
	//Funcion que muestra en pantalla los parଥtros de cada operacion
	//asociada al N� de pedido consultado
	function PresentaResultado($xmlDoc, $iNumOperacion){
			//ESTA FUNCION ES SOLAMENTE UN EJEMPLO DE COMO ANALIZAR LA RESPUESTA
			$sNumOperacion = "";
	
			$sNumOperacion = $iNumOperacion;
                        
                        $cod_error = RecuperaCampos($xmlDoc, $sNumOperacion, 'cod_accion');
			
                        $strValor = "";
                        $strValor .= "
                            
                        
                            
                        <div class='datagrid'>
                            <table>
                            <tbody>
                                <tr>
                                    <td>Estado de la operaci&oacute;n</td>
                                    <td><b>" . RecuperaCampos($xmlDoc, $sNumOperacion, "estado") . "</b></td>
                                </tr>
                                <tr class='alt'>
                                    <td>N&uacute;mero de Pedido</td>
                                    <td>" . RecuperaCampos($xmlDoc, $sNumOperacion, "nordent") . "</td>
                                </tr>
                                <tr>
                                    <td>Nombre del Banco</td>
                                    <td>" . RecuperaCampos($xmlDoc, $sNumOperacion, "nom_emisor") . "</td>
                                </tr>
                                <tr class='alt'>
                                    <td>Nombre del Cliente</td>
                                    <td>" . RecuperaCampos($xmlDoc, $sNumOperacion, "nombre_th") . "</td>
                                </tr>
                                <tr>
                                    <td>Descripcion del Error</td>
                                    <td>" . getMensajeError($cod_error) . "</td>
                                </tr>
                                <tr class='alt'>
                                    <td>Fecha y Hora</td>
                                    <td>" . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_tx") . "</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>";
                        
			//$strValor = $strValor . "<LI> Respuesta: " . RecuperaCampos($xmlDoc, $sNumOperacion, "respuesta") . "<BR>";
			//$strValor = $strValor . "<LI> Estado de la operaci&oacute;n : " . RecuperaCampos($xmlDoc, $sNumOperacion, "estado") . "<BR>";
			//$strValor = $strValor . "<LI> cod_tienda: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_tienda") . "<BR>";
			//$strValor = $strValor . "<LI> Num. de Pedido : " . RecuperaCampos($xmlDoc, $sNumOperacion, "nordent") . "<BR>";
			//$strValor = $strValor . "<LI> cod_accion: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_accion") . "<BR>";
			//$strValor = $strValor . "<LI> pan: " . RecuperaCampos($xmlDoc, $sNumOperacion, "pan") . "<BR>";
			//$strValor = $strValor . "<LI> Nombre del Banco : " . RecuperaCampos($xmlDoc, $sNumOperacion, "nombre_th") . "<BR>";
			//$strValor = $strValor . "<LI> ori_tarjeta: " . RecuperaCampos($xmlDoc, $sNumOperacion, "ori_tarjeta") . "<BR>";
			//$strValor = $strValor . "<LI> Nombre del Cliente : " . RecuperaCampos($xmlDoc, $sNumOperacion, "nom_emisor") . "<BR>";
			//$strValor = $strValor . "<LI> eci: " . RecuperaCampos($xmlDoc, $sNumOperacion, "eci") . "<BR>";
			//$strValor = $strValor . "<LI> Descripcion del Error : " . RecuperaCampos($xmlDoc, $sNumOperacion, "dsc_eci") . "<BR>";
			//$strValor = $strValor . "<LI> cod_autoriza: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_autoriza") . "<BR>";
			//$strValor = $strValor . "<LI> cod_rescvv2: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_rescvv2") . "<BR>";
			//$strValor = $strValor . "<LI> imp_autorizado: " . RecuperaCampos($xmlDoc, $sNumOperacion, "imp_autorizado") . "<BR>";
			//$strValor = $strValor . "<LI> Fecha y Hora : " . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_tx") . "<BR>";
			//$strValor = $strValor . "<LI> fechayhora_deposito: " . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_deposito") . "<BR>";
			//$strValor = $strValor . "<LI> fechayhora_devolucion: " . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_devolucion") . "<BR>";
			//$strValor = $strValor . "<LI> dato_comercio: " . RecuperaCampos($xmlDoc, $sNumOperacion, "dato_comercio") . "<BR>";
	
			echo($strValor);
	}
	
	//Funcion de ejemplo que obtiene la cantidad de mensajes
	function CantidadMensajes($xmlDoc){
		$cantMensajes= 0;
		$xpath = new DOMXPath($xmlDoc);
		$nodeList = $xpath->query('//mensajes', $xmlDoc);
		
		$XmlNode= $nodeList->item(0);
		
		if($XmlNode==null){
			$cantMensajes= 0;
		}else{
			$cantMensajes= $XmlNode->childNodes->length;
		}
		return $cantMensajes; 
	}
	//Funcion que recupera el valor de uno de los mensajes XML de respuesta
	function RecuperaMensaje($xmlDoc,$iNumMensaje){
		$strReturn = "";
			
			$xpath = new DOMXPath($xmlDoc);
			$nodeList = $xpath->query("//mensajes/mensaje[@id='" . $iNumMensaje . "']");
			
			$XmlNode= $nodeList->item(0);
			
			if($XmlNode==null){
				$strReturn = "";
			}else{
				$strReturn = $XmlNode->nodeValue;
			}
			return $strReturn;
	}
        function getMensajeError($codError){
            $codigoErrores = array(	"101"	 =>	"Operación Denegada. Tarjeta Vencida. "	,
                                "102"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "104"	 =>	"Operación Denegada. Operacion no permitida para esta tarjeta "	,
                                "106"	 =>	"Operación Denegada. Intentos de pin excedidos "	,
                                "107"	 =>	"Operación Denegada. Contactar con el emisor "	,
                                "108"	 =>	"Operación Denegada. Exceso de actividad "	,
                                "109"	 =>	"Operación Denegada. Identificación inválida de establecimiento "	,
                                "110"	 =>	"Operación Denegada. Operacion no permitida para esta tarjeta "	,
                                "111"	 =>	"Operación Denegada. El monto de la transacción supera el valor máximo permitido para operaciones virtuales "	,
                                "112"	 =>	"Operación Denegada. Se requiere clave "	,
                                "116"	 =>	"Operación Denegada. Fondos insuficientes. "	,
                                "117"	 =>	"Operación Denegada. Clave incorrecta "	,
                                "118"	 =>	"Operación Denegada. Tarjeta Inválida. "	,
                                "119"	 =>	"Operación Denegada. Exceso de intentos de ingreso de PIN "	,
                                "121"	 =>	"Operación Denegada. "	,
                                "126"	 =>	"Operación Denegada. PIN inválido "	,
                                "129"	 =>	"Operación Denegada. Tarjeta no operativa "	,
                                "180"	 =>	"Operación Denegada. Tarjeta inválida "	,
                                "181"	 =>	"Operación Denegada Tarjeta con restricciones de Débito "	,
                                "182"	 =>	"Operación Denegada. Tarjeta con restricciones de Crédito "	,
                                "183"	 =>	"Operación Denegada. Error de sistema "	,
                                "190"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "191"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "192"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "199"	 =>	"Operación Denegada. "	,
                                "201"	 =>	"Operación Denegada. Tarjeta Vencida. "	,
                                "202"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "204"	 =>	"Operación Denegada. Operación no permitida para esta tarjeta "	,
                                "206"	 =>	"Operación Denegada. Exceso de intentos de ingreso de PIN "	,
                                "207"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "208"	 =>	"Operación Denegada. Tarjeta Perdida. "	,
                                "209"	 =>	"Operación Denegada. Tarjeta Robada. "	,
                                "263"	 =>	"Operación Denegada. Error en el envío de parámetros. "	,
                                "264"	 =>	"Operación Denegada. Banco Emisor no esta disponible para realizar la autenticación. "	,
                                "265"	 =>	"Operación Denegada. Password de tarjeta habiente incorrecto. "	,
                                "266"	 =>	"Operación Denegada. Tarjeta Vencida. "	,
                                "280"	 =>	"Operación Denegada. Clave errónea "	,
                                "290"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "300"	 =>	"Operación Denegada. Número de pedido del comercio duplicado. Favor no atender. "	,
                                "306"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "401"	 =>	"Operación Denegada. Tienda inhabilitada "	,
                                "402"	 =>	"Operación Denegada. Tienda con rango de IP no valido. "	,
                                "403"	 =>	"Operación Denegada. Tarjeta no autenticada "	,
                                "404"	 =>	"Operación Denegada. El monto de la transacción supera el valor máximo permitido "	,
                                "405"	 =>	"Operación Denegada. La tarjeta ha superado la cantidad máxima de transacciones en el día. "	,
                                "406"	 =>	"Operación Denegada. La tienda ha superado la cantidad máxima de transacciones en el día. "	,
                                "407"	 =>	"Operación Denegada. El monto de la transacción no llega al mínimo permitido. "	,
                                "408"	 =>	"Operación Denegada. CVV2 no coincide "	,
                                "409"	 =>	"Operación Denegada. CVV2 no procesado por Banco "	,
                                "410"	 =>	"Operación Denegada. CVV2 no procesado por no ingresado "	,
                                "411"	 =>	"Operación Denegada. CVV2 no procesado por Banco "	,
                                "412"	 =>	"Operación Denegada. CVV2 no reconocido por Banco "	,
                                "413"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "414"	 =>	"Operación Denegada. "	,
                                "415"	 =>	"Operación Denegada. "	,
                                "416"	 =>	"Operación Denegada. "	,
                                "417"	 =>	"Operación Denegada. "	,
                                "418"	 =>	"Operación Denegada. "	,
                                "419"	 =>	"Operación Denegada. "	,
                                "420"	 =>	"Operación Denegada. Tarjeta no es VISA "	,
                                "421"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "422"	 =>	"Operación Denegada. El comercio no está configurado para usar este medio de pago. "	,
                                "423"	 =>	"Operación Denegada. Se canceló el proceso de pago / Cancelled checkout. "	,
                                "424"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "425"	 =>	"Operación Denegada. País emisor incorrecto "	,
                                "666"	 =>	"Operación Denegada. Problemas de comunicación. Intente mas tarde. "	,
                                "667"	 =>	"Operación Denegada. Transacción sin autenticación. "	,
                                "668"	 =>	"Operación Denegada. "	,
                                "669"	 =>	"Operación Denegada. "	,
                                "670"	 =>	"Operación Denegada. "	,
                                "807"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "900"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "904"	 =>	"Operación Denegada. Formato de mensaje erróneo "	,
                                "909"	 =>	"Operación Denegada. Error de sistema "	,
                                "910"	 =>	"Operación Denegada. Error de sistema "	,
                                "912"	 =>	"Operación Denegada. Emisor no disponible "	,
                                "913"	 =>	"Operación Denegada. Transmisión duplicada "	,
                                "916"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "928"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "940"	 =>	"Operación Denegada. Transacción anulada previamente "	,
                                "941"	 =>	"Operación Denegada. Transacción ya anulada previamente "	,
                                "942"	 =>	"Operación Denegada. "	,
                                "943"	 =>	"Operación Denegada. Datos originales distintos "	,
                                "945"	 =>	"Operación Denegada. Referencia repetida "	,
                                "946"	 =>	"Operación Denegada. Operación de anulación en proceso "	,
                                "947"	 =>	"Operación Denegada. Comunicación duplicada "	,
                                "948"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "949"	 =>	"Operación Denegada. Contactar con emisor "	,
                                "965"	 =>	"Operación Denegada. Contactar con emisor "	);
        
            if(array_key_exists($codError,$codigoErrores))
                return $codigoErrores[$codError]; //." (".$codError.")";
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


                <br/>
                <?php
                //Aqui carga la cadena resultado en un XMLDocument (DOMDocument)
                $xmlDocument = new DOMDocument();
                if ($xmlDocument->loadXML($result->ConsultaEticketResult)) {

                    //Ejemplo para determinar la cantidad de operaciones 
                    //asociadas al N� de pedido
                    $iCantOpe = CantidadOperaciones($xmlDocument, $eTicket);
                    //echo 'Cantidad de Operaciones: ' . $iCantOpe . '<br>';
                    //Ejemplo para mostrar los parଥtros de las operaciones
                    //asociadas al N� de pedido
                    for ($iNumOperacion = 0; $iNumOperacion < $iCantOpe; $iNumOperacion++) {
                        PresentaResultado($xmlDocument, $iNumOperacion + 1);
                    }

                    //Ejemplo para determinar la cantidad de mensajes 
                    //asociadas al N� de pedido
                    $iCantMensajes = CantidadMensajes($xmlDocument);
                    //echo '<br><br>Cantidad de Mensajes: ' . $iCantMensajes . '<br>';
                    //Ejemplo para mostrar los mensajes de las operaciones
                    //asociadas al N� de pedido
                    for ($iNumMensaje = 0; $iNumMensaje < $iCantMensajes; $iNumMensaje++) {
                        echo 'Mensaje #' . ($iNumMensaje + 1) . ': ';
                        echo RecuperaMensaje($xmlDocument, $iNumMensaje + 1);
                        echo '<BR>';
                    }
                } else {
                    echo "Error";
                }
                ?>
                <br />



            </div>

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
            var idTemporada = '<?php echo $_GET['idTemporada']; ?>';
            if($('#texto-buscar').val().length < 3) { 
                alert('Por favor, ingrese el nombre del producto que desea buscar.'); 
            }
            else{        
                if(typeof idTemporada === 'undefined' || !idTemporada ) {
                    $(".menu-items").find('a:first').click();
                }
                else{
                    obtenerProductosPorNombre(idTemporada,$('#texto-buscar').val());
                }
            }
        }
    
    </script>
  </body>
</html>