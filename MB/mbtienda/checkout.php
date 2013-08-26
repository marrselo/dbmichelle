<?php
	session_start(); 
	include('lib.inc');

	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	ini_set('date.timezone', 'America/Lima'); 
	header( 'Content-Type: text/html;charset=utf-8' );
?>
<?php

	if ( isset($_POST["carrito-cantidad"]) && isset($_SESSION["compra"]["cliente"]) && $_POST['tarjeta']=="visa") {
            $GLOBALS['RUTA_LOCAL']  = "http://localhost/online/mbapp/mbappvendedoras/mbwebservices/"; 
            $url = $GLOBALS['RUTA_LOCAL'].'tiendavirtual.php';
            $data = array( 'metodo' => 'GRABARCOMPRA',
                    'idCliente' => $_SESSION['compra']['cliente'][0]->idCliente,
                    'totalCompra' => $_SESSION['compra']['total']);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $resp = curl_exec($ch);
            curl_close($ch);
            
            //echo json_encode($resp);
            $resp = json_decode($resp);
            
            for( $x=0 ; $x<count($_SESSION['carrito']) ; $x++){
                $data = array( 'metodo' => 'GRABARCOMPRADETALLE',
                        'idCarrito' => $resp->idCarrito,
                        'idProducto' => $_SESSION['carrito'][$x]['codigo'],
                        'cantidad' => $_SESSION['carrito'][$x]['cantidad'],
                        'precio' => $_SESSION['carrito'][$x]['precio'],
                        'talla' => $_SESSION['carrito'][$x]['talla'],
                        'color' => $_SESSION['carrito'][$x]['color']
                        );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $respdetalle = curl_exec($ch);
                curl_close($ch);
            }
            
            if($resp->idCarrito>0){
                $numPedido= $resp->idCarrito;//$_POST["numPedido"];//'622';
                $codTienda = CODIGO_TIENDA;
                $mount = number_format((float)$_SESSION['compra']['total'], 2, '.', '');

                //Se arma el XML de requerimiento
                $xmlIn = "";
                $xmlIn = $xmlIn . "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
                $xmlIn = $xmlIn . "<nuevo_eticket>";
                $xmlIn = $xmlIn . "	<parametros>";
                $xmlIn = $xmlIn . "		<parametro id=\"CANAL\">3</parametro>";
                $xmlIn = $xmlIn . "		<parametro id=\"PRODUCTO\">1</parametro>";
                $xmlIn = $xmlIn . "		";
                $xmlIn = $xmlIn . "		<parametro id=\"CODTIENDA\">" . $codTienda . "</parametro>";
                $xmlIn = $xmlIn . "		<parametro id=\"NUMORDEN\">" . $numPedido . "</parametro>";
                $xmlIn = $xmlIn . "		<parametro id=\"MOUNT\">" . $mount . "</parametro>";
                $xmlIn = $xmlIn . "		<parametro id=\"DATO_COMERCIO\">JOSE</parametro>";
                $xmlIn = $xmlIn . "	</parametros>";
                $xmlIn = $xmlIn . "</nuevo_eticket>";

                //Se asigna la url del servicio
                //En producción cambiará la URL
                $servicio= URL_WSGENERAETICKET_VISA;

                //Invocación al web service
                $client = new SoapClient($servicio);
                //print_r($client->GeneraEticket);
                //exit;
                //parametros de la llamada
                $parametros=array(); 
                $parametros['xmlIn']= $xmlIn;
                //Aqui captura la cadena de resultado
                $result = $client->GeneraEticket($parametros);
                //Muestra la cadena recibida
                //echo 'Cadena de respuesta: ' . $result->GeneraEticketResult . '<br>' . '<br>';

                //Aqui carga la cadena resultado en un XMLDocument (DOMDocument)
                $xmlDocument = new DOMDocument();

                if ($xmlDocument->loadXML($result->GeneraEticketResult)){
                        /////////////////////////[MENSAJES]////////////////////////
                        //Ejemplo para determinar la cantidad de mensajes en el XML
                        $iCantMensajes= CantidadMensajes($xmlDocument);
                        //echo 'Cantidad de Mensajes: ' . $iCantMensajes . '<br>';

                        //Ejemplo para mostrar los mensajes del XML 
                        for($iNumMensaje=0;$iNumMensaje < $iCantMensajes; $iNumMensaje++){



                                $_SESSION['error'] = "<div class='alert alert-block' style='width=500px;' >
                                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                                            <strong>Mensaje: </strong>" . RecuperaMensaje($xmlDocument, $iNumMensaje+1) .
                                                          "</div>"; 
                                header("Location: carritocompras.php");
                                // 'Mensaje #' . ($iNumMensaje +1) . ': ';
                                //echo RecuperaMensaje($xmlDocument, $iNumMensaje+1);
                                //echo '<BR>';
                        }
                        /////////////////////////[MENSAJES]////////////////////////
                        //echo $xmlIn;
                        if ($iCantMensajes == 0){
                                $Eticket= RecuperaEticket($xmlDocument);
                                //echo 'Eticket: ' . $Eticket;

                                $html= htmlRedirecFormEticket($Eticket);
                                echo $html;

                                exit;
                        }

                }else{
                        //echo "Error cargando XML";
                        $_SESSION['error'] = "<div class='alert alert-block' style='width=500px;' >
                                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                                            <strong>Mensaje: </strong>Error cargando XML</div>"; 
                        header("Location: carritocompras.php");
                }	
            }		
	}else if ( isset($_POST["carrito-cantidad"]) && isset($_SESSION["compra"]["cliente"]) && $_POST['tarjeta']=="mastercard") {
            //echo "Error cargando XML";
            $_SESSION['error'] = "<div class='alert alert-block' style='width=500px;' >
                                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                                <strong>Mensaje: </strong>Estamos actualizando los pagos con MasterCard.</div>"; 
            header("Location: carritocompras.php");
        }else{
            //echo "Error cargando XML";
            $_SESSION['error'] = "<div class='alert alert-block' style='width=500px;' >
                                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                                <strong>Mensaje: </strong>Agregue articulos a su carrito de compra e Ingrese como cliente.</div>"; 
            header("Location: carritocompras.php");
        }

?>

<HTML>
<HEAD>
    <title>Michelle Belau - Tienda Virtual</title>

</HEAD>
<BODY>
    <div align="center">
        <span class="Estilo1">Ejemplo de pago usando E-Ticket</span>
    </div>

</BODY>
</HTML>

<?php
	//Funcion de ejemplo que obtiene la cantidad de operaciones
	function CantidadOperaciones($xmlDoc, $numPedido){
		$cantidaOpe= 0;
		$xpath = new DOMXPath($xmlDoc);
		$nodeList = $xpath->query('//pedido[@id="' . $numPedido . '"]', $xmlDoc);
		
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
	//Funcion que muestra en pantalla los parámetros de cada operacion
	//asociada al Número de pedido consultado
	function PresentaResultado($xmlDoc, $iNumOperacion){
			//ESTA FUNCION ES SOLAMENTE UN EJEMPLO DE COMO ANALIZAR LA RESPUESTA
			$sNumOperacion = "";
	
			$sNumOperacion = $iNumOperacion;
	
			$strValor = "";
			$strValor = $strValor . "Respuesta: " . RecuperaCampos($xmlDoc, $sNumOperacion, "respuesta") . "<BR>";
			$strValor = $strValor . "cod_tienda: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_tienda") . "<BR>";
			$strValor = $strValor . "nordent: " . RecuperaCampos($xmlDoc, $sNumOperacion, "nordent") . "<BR>";
			$strValor = $strValor . "cod_accion: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_accion") . "<BR>";
			$strValor = $strValor . "pan: " . RecuperaCampos($xmlDoc, $sNumOperacion, "pan") . "<BR>";
			$strValor = $strValor . "eci: " . RecuperaCampos($xmlDoc, $sNumOperacion, "eci") . "<BR>";
			$strValor = $strValor . "cod_autoriza: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_autoriza") . "<BR>";
			$strValor = $strValor . "ori_tarjeta: " . RecuperaCampos($xmlDoc, $sNumOperacion, "ori_tarjeta") . "<BR>";
			$strValor = $strValor . "nom_emisor: " . RecuperaCampos($xmlDoc, $sNumOperacion, "nom_emisor") . "<BR>";
			$strValor = $strValor . "dsc_eci: " . RecuperaCampos($xmlDoc, $sNumOperacion, "dsc_eci") . "<BR>";
			$strValor = $strValor . "cod_rescvv2: " . RecuperaCampos($xmlDoc, $sNumOperacion, "cod_rescvv2") . "<BR>";
			$strValor = $strValor . "imp_autorizado: " . RecuperaCampos($xmlDoc, $sNumOperacion, "imp_autorizado") . "<BR>";
			$strValor = $strValor . "fechayhora_tx: " . RecuperaCampos($xmlDoc, $sNumOperacion, "fechayhora_tx") . "<BR>";
	
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
	
	//Funcion que recupera el valor del Eticket
	function RecuperaEticket($xmlDoc){
		$strReturn = "";
			
			$xpath = new DOMXPath($xmlDoc);
			$nodeList = $xpath->query("//registro/campo[@id='ETICKET']");
			
			$XmlNode= $nodeList->item(0);
			
			if($XmlNode==null){
				$strReturn = "";
			}else{
				$strReturn = $XmlNode->nodeValue;
			}
			return $strReturn;
	}
?>