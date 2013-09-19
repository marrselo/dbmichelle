<?php
    session_start(); 

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
    
    if (isset($_SESSION['carrito']) && isset($_SESSION["compra"]["cliente"])) {
        $GLOBALS['RUTA_LOCAL'] = "http://localhost/online/mbapp/mbappvendedoras/mbwebservices/";
        $url = $GLOBALS['RUTA_LOCAL'] . 'tiendavirtual.php';
        $data = array('metodo' => 'GRABARCOMPRA',
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

        for ($x = 0; $x < count($_SESSION['carrito']); $x++) {
            $data = array('metodo' => 'GRABARCOMPRADETALLE',
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

        if ($resp->idCarrito > 0) {
            ///// MARTERCARD
            $keyMerchant = "n9yA9r4SedrUmuSeh4wRejEpAc7aHeCE";
            $I1 = '4000251';
            $I2 = pad($resp->idCarrito,5);
            $I3 = number_format((float) $_SESSION['compra']['total'], 2, '.', '');
            $I4 = 'PEN';
            $I5 = date("Ymd");
            $I6 = date("His");
            $I7 = date("YmdHis");
            $I8 = $_SESSION['compra']['cliente'][0]->idCliente;
            $I9 = 'PER';

            $arrDatos[] = $I1; //Comercio
            $arrDatos[] = $I2; //Id Carro de Compras
            $arrDatos[] = $I3; //Monto
            $arrDatos[] = $I4; //Moneda
            $arrDatos[] = $I5; //fecha
            $arrDatos[] = $I6; //hora
            $arrDatos[] = $I7; //cadena aleatoria
            $arrDatos[] = $I8; // Id del cliente
            $arrDatos[] = $I9; // Pais
            $arrDatos[] = $keyMerchant; // Firna

            $cadenafinal = implode("", $arrDatos);

            $strHash = base64_encode(hmacsha1($keyMerchant, $cadenafinal));
        }
    } else {
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
    <BODY onload="document.mccheckout.submit();">
        <form method="POST" action="http://server.punto-web.com/gateway/PagoWebHd.asp" name="mccheckout" id="mccheckout">
            <input type="hidden" name="I1" value="<?php echo $I1; ?>" />
            <input type="hidden" name="I2" value="<?php echo $I2; ?>" />
            <input type="hidden" name="I3" value="<?php echo $I3; ?>" />
            <input type="hidden" name="I4" value="<?php echo $I4; ?>" />
            <input type="hidden" name="I5" value="<?php echo $I5; ?>" />
            <input type="hidden" name="I6" value="<?php echo $I6; ?>" />
            <input type="hidden" name="I7" value="<?php echo $I7; ?>" />
            <input type="hidden" name="I8" value="<?php echo $I8; ?>" />
            <input type="hidden" name="I9" value="<?php echo $I9;?>" />
            <input type="hidden" name="I10" value="<?php echo $strHash; ?>" />                      
        </form>

    </BODY>
</HTML>
