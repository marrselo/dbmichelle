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
                                    <td>" . RecuperaCampos($xmlDoc, $sNumOperacion, "nombre_th") . "</td>
                                </tr>
                                <tr class='alt'>
                                    <td>Nombre del Cliente</td>
                                    <td>" . RecuperaCampos($xmlDoc, $sNumOperacion, "nom_emisor") . "</td>
                                </tr>
                                <tr>
                                    <td>Descripcion del Error</td>
                                    <td>" . RecuperaCampos($xmlDoc, $sNumOperacion, "dsc_eci") . "</td>
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
?>

<!DOCTYPE html>
<html lang="ES">
  <head>
    <meta charset="UTF-8" />
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
      
    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
          <p><a href="index.php"><img src="img/logo.jpg"></a></p>
      </div>

    </div>
      
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
            <input type="hidden" id="temporada" value="2" />
                <ul class="nav">
                  <li class="active"><a href="#">OTO&Ntilde;O - INVIERNO</a></li>
                  <li><a href="#about">PRIMAVERA - VERANO</a></li>
                </ul>
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
          <div id="menu">
          <ul class="menu-items">
              <li><a href="#" class="menu-seleccionado">TEXTO</a></li>
              <li><a href="#">AVIOS</a></li>
              <li><a href="#">ACCESORIOS</a></li>
              <li><a href="#">CALZADO</a></li>
              <li><a href="#">AVIOS</a></li>
              <li><a href="#">ACCESORIOS</a></li>
              <li><a href="#">CALZADO</a></li>
              <li><a href="#">AVIOS</a></li>
              <li><a href="#">ACCESORIOS</a></li>
              <li><a href="#">CALZADO</a></li>
          </ul>
          </div>
      </div>

      <div class="row-fluid">
        <div class="span2">
            <div id="sub-menu">
            <ul class="sub-menu-items">
                <li><a href="#">Abrigo</a></li>
                <li><a href="#">Blaiser</a></li>
                <li><a href="#">Blusa</a></li>
                <li><a href="#">Capri</a></li>
                <li><a href="#">Casaca</a></li>
                <li><a href="#">Blaiser</a></li>
                <li><a href="#">Blusa</a></li>
                <li><a href="#">Capri</a></li>
                <li><a href="#">Casaca</a></li>
                <li><a href="#">Abrigo</a></li>
                <li><a href="#">Blaiser</a></li>
                <li><a href="#">Blusa</a></li>
                <li><a href="#">Capri</a></li>
                <li><a href="#">Casaca</a></li>
                <li><a href="#">Blaiser</a></li>
                <li><a href="#">Blusa</a></li>
                <li><a href="#">Capri</a></li>
                <li><a href="#">Casaca</a></li>
            </ul>
            </div>            
            <?php include 'menulateral.php'; ?>
        </div>
        <div class="span10">
            <div id="titulo2"><h3 class="articulo-titulo">PROCESO DE COMPRA</h3></div>
            <div class="span12" >
                
                <div class="span9" style="border-right: 1px solid #ccc; padding: 20px;">
                    <br/>
                    <?php 
                        //Aqui carga la cadena resultado en un XMLDocument (DOMDocument)
                        $xmlDocument = new DOMDocument();
                        if ($xmlDocument->loadXML($result->ConsultaEticketResult)) {

                                //Ejemplo para determinar la cantidad de operaciones 
                                //asociadas al N� de pedido
                                $iCantOpe= CantidadOperaciones($xmlDocument, $eTicket);
                                //echo 'Cantidad de Operaciones: ' . $iCantOpe . '<br>';

                                //Ejemplo para mostrar los parଥtros de las operaciones
                                //asociadas al N� de pedido
                                for($iNumOperacion=0;$iNumOperacion < $iCantOpe; $iNumOperacion++){
                                        PresentaResultado($xmlDocument, $iNumOperacion+1);
                                }

                                //Ejemplo para determinar la cantidad de mensajes 
                                //asociadas al N� de pedido
                                $iCantMensajes= CantidadMensajes($xmlDocument);
                                //echo '<br><br>Cantidad de Mensajes: ' . $iCantMensajes . '<br>';

                                //Ejemplo para mostrar los mensajes de las operaciones
                                //asociadas al N� de pedido
                                for($iNumMensaje=0;$iNumMensaje < $iCantMensajes; $iNumMensaje++){
                                        echo 'Mensaje #' . ($iNumMensaje +1) . ': ';
                                        echo RecuperaMensaje($xmlDocument, $iNumMensaje+1);
                                        echo '<BR>';
                                }
                        }else{
                                echo "Error";
                        }
                    ?>
                    <br />
                    
                </div>
                
                <div class="span3" style="width: 18%; padding: 20px 0px;" >
                    <div id="carrito">

                    </div>   
                    <div id="links">
                        <a href="carritocompras.php">Ver Carrito de Compras</a>
                        <a href="carritocompras.php" style="color: #222;">Comprar</a>
                    </div>
                </div>
                
                
            </div>
            
        </div>
        <!-- GALERIA DE FOTOS -->
        
        
      </div>

      <?php include 'piepagina.php'; ?>

    </div> <!-- /container -->

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
        
        $(document).ready(function(){

            obtenerLineas();
            $('.menu-items li a:first').click();   
            obtenerClasesPorLinea($('.menu-seleccionado').attr('linea'));                        
            //mostrarCarrito();
            
        });
    
    </script>
  </body>
</html>
