<?php //
session_start();
$GLOBALS['RUTA_LOCAL']  = "http://localhost/online/mbapp/mbappvendedoras/mbwebservices/";  // para darle la ruta hasta la carpeta imagenes
$GLOBALS['NOMBRE_FULL']  = "FullCine";  // para darle la ruta hasta la carpeta imagenes
$GLOBALS['ID_FULL']  = "1";  // para darle la ruta hasta la carpeta imagenes

 
if($_POST["metodo"]=="BUSCARCLIENTE") { 
    $url = $GLOBALS['RUTA_LOCAL'].'cliente.php';

    $data = array( 'metodo' => 'BUSCARCLIENTEPORDNI',
                    'documento' => $_POST['documento'] );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $resp = curl_exec($ch);
    curl_close($ch);
    
    if(count(json_decode($resp))>0) {
        $_SESSION['compra']['cliente'] = json_decode($resp);
        echo "0";
    } else {
        $_SESSION['error'] = json_decode($resp);
        echo json_encode($resp);
    }
    //echo json_encode($resp);
}
///////////////////////////////////////////////////////////////////////////////
    if($_POST["metodo"]=="CERRARSESION") { 
        unset($_SESSION['compra']['cliente']);
        
    }
    if($_POST["metodo"]=="AGREGARCARRITO") { 
        $articulo = array (
            'codigo' => $_POST['codigo'],
            'cantidad' => $_POST['cantidad'],
            'nombre' => $_POST['nombre'],
            'precio' => $_POST['precio'],
            'talla' => $_POST['talla'],
            'color' => $_POST['color']
        );
        
        $arreglo = $_SESSION['carrito'];
        $flag = false;
        for($i=0;$i<count($arreglo);$i++) {
            if($_SESSION['carrito'][$i]['codigo']==$_POST['codigo']) {
                $_SESSION['carrito'][$i]['cantidad']+=$_POST['cantidad'];
                $flag = true;
                break;
            }
        }
        if(!$flag) { $_SESSION['carrito'][] = $articulo; }
        
        echo count($_SESSION['carrito']);
    }
    if($_POST["metodo"]=="ACTUALIZARCARRITO") { 
        $arreglo = $_SESSION['carrito'];
        $flag = false;
        for($i=0;$i<count($arreglo);$i++) {
            if($_SESSION['carrito'][$i]['codigo']==$_POST['codigo']) {
                $_SESSION['carrito'][$i]['cantidad']=$_POST['cantidad'];
                $flag = true;
                break;
            }
        }
    }
    if($_POST["metodo"]=="BORRARCARRITO") { 
        $arreglo = $_SESSION['carrito'];
        for($i=0;$i<count($arreglo);$i++) {
            if($_SESSION['carrito'][$i]['codigo']==$_POST['codigo']) {
                unset($_SESSION['carrito'][$i]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                break;
            }
        }
        echo count($_SESSION['carrito']);
    }
    if($_POST["metodo"]=="MOSTRARCARRITO") { 
        $arreglo = $_SESSION['carrito'];
        $flag = false;
        $texto = "<table class='carrito' border='1'>";
        $texto .= "<tr style='text-align: center; background-color: #777; color: #FFF;'>
                        <td></td>
                        <td style='font-size: 8px;'>Productos</td>
                        <td>#</td>
                    </tr>";
        for($i=0;$i<count($arreglo);$i++) {
            $texto .= "<tr>
                        <td>".($i+1)."</td>
                        <td style='font-size: 8px;'>".substr($_SESSION['carrito'][$i]['nombre'],0,20)."<br />".$_SESSION['carrito'][$i]['codigo']."</td>
                        <td>".$_SESSION['carrito'][$i]['cantidad']."</td>
                    </tr>";                
        }
        $texto .= "</table>";
        echo $texto;
        //if(!$flag) { $_SESSION['carrito'][] = $articulo; }
    }
    if($_POST["metodo"]=="MOSTRARDETALLECARRITO") { 
        $arreglo = $_SESSION['carrito'];
        $flag = false;
        $total = 0;
        $texto = "<table class='carritodetalle' border='1'>
                        <tr style='font: normal 12px Arial; padding: 3px; background-color: #777; color: #FFF;'>
                            <td style='width: 30px;'>#</td>
                            <td style='width: 500px;'>Producto</td>                            
                            <td style='width: 110px;'>Precio</td>
                            <td style='width: 90px;'>Cantidad</td>
                            <td style='width: 120px;'>Sub-Total</td>
                        <tr>";                        
        for($i=0;$i<count($arreglo);$i++) {
            $texto .= "<tr>
                        <td style='text-align: center'>".($i+1)."</td>
                        <td>".substr($_SESSION['carrito'][$i]['nombre'],0,20)." (".$_SESSION['carrito'][$i]['codigo'].") <br /><span style='font-size: 10px;'>Talla : ".$_SESSION['carrito'][$i]['talla']."</span><br /><span style='font-size: 10px;'>Color : ".$_SESSION['carrito'][$i]['color']."</span></td>
                        <td style='text-align: right'>S/.".number_format(round($_SESSION['carrito'][$i]['precio'],2),2,'.',',')."</td>
                        <td style='text-align: center; padding-top: 5px;'><input name='carrito-cantidad' id='carrito-cantidad' type='text' value='".$_SESSION['carrito'][$i]['cantidad']."' onchange=\"actualizarCarrito('".$_SESSION['carrito'][$i]['codigo']."',$(this).val())\" style='width: 20px; height: 8px; margin=0px; padding=0px; vertical-align:top; font: normal 10px Arial;' /><img src='img/borrar.png' border='0' style='cursor: pointer;' onclick=\"borrarCarrito('".$_SESSION['carrito'][$i]['codigo']."')\" /></td>
                        <td style='text-align: right'>S/.".number_format(round(($_SESSION['carrito'][$i]['cantidad']*$_SESSION['carrito'][$i]['precio']),2),2,'.',',')."</td>
                    </tr>";                
            $total += ($_SESSION['carrito'][$i]['cantidad']*$_SESSION['carrito'][$i]['precio']);
        }
        $texto .= "<tr>
                            <td colspan='3'></td>
                            <td>Total</td>
                            <td style='text-align: right'><span id='carrito-total'>S/. ".number_format(round($total, 2),2,'.',',')."</span></td>
                        <tr>
                    </table>";
        $_SESSION['totalcarrito']=number_format(round($total, 2),2,'.',',');
        $_SESSION['compra']['total']=round($total, 2);
        echo $texto;
        //if(!$flag) { $_SESSION['carrito'][] = $articulo; }
    }
    
    if($_POST["metodo"]=="OBTENERLINEAS") { 
        $url = $GLOBALS['RUTA_LOCAL'].'vendedoras.php';
                            
        $data = array( 'metodo' => 'OBTENERLINEAS' );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        echo json_encode($resp);
    }
    if($_POST["metodo"]=="OBTENERCLASESPORLINEA") { 
        $url = $GLOBALS['RUTA_LOCAL'].'vendedoras.php';
                            
        $data = array( 'metodo' => 'OBTENERCLASESPORLINEA',
                        'Linea' => $_POST['Linea']);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        echo json_encode($resp);
    }  
    if($_POST["metodo"]=="OBTENERPRODUCTOSGENERICOS") { 
        $url = $GLOBALS['RUTA_LOCAL'].'vendedoras.php';
                            
        $data = array( 'metodo' => 'OBTENERPRODUCTOSGENERICOS',
                        'Familia' => $_POST['Familia'],
                        'Linea' => $_POST['Linea'],
                        'ColeccionID' => $_POST['ColeccionID']
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        
        session_start();
        $_SESSION['productos']=json_decode($resp);
        
        echo json_encode($resp);
    }
    if($_POST["metodo"]=="OBTENERPRODUCTOSGENERICOSPORCOLOR") { 
        $url = $GLOBALS['RUTA_LOCAL'].'tiendavirtual.php';
                            
        $data = array( 'metodo' => 'OBTENERPRODUCTOSGENERICOSPORCOLOR',
                        'Familia' => $_POST['Familia'],
                        'Linea' => $_POST['Linea'],
                        'ColeccionID' => $_POST['ColeccionID'],
                        'Color' => $_POST['Color']
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        
        session_start();
        $_SESSION['productos']=json_decode($resp);
        
        echo json_encode($resp);
    } 
    if($_POST["metodo"]=="OBTENERPRODUCTOSGENERICOSPORNOMBRE") { 
        $url = $GLOBALS['RUTA_LOCAL'].'tiendavirtual.php';
                            
        $data = array( 'metodo' => 'OBTENERPRODUCTOSGENERICOSPORNOMBRE',
                        'ColeccionID' => $_POST['ColeccionID'],
                        'Cadena' => $_POST['Cadena']
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        
        session_start();
        $_SESSION['productos']=json_decode($resp);
        
        echo json_encode($resp);
    } 
    //OBTENERCOMBINACIONES
    if($_POST["metodo"]=="OBTENERCOMBINACIONES") { 
        $url = $GLOBALS['RUTA_LOCAL'].'vendedoras.php';
                            
        $data = array( 'metodo' => 'OBTENERCOMBINACIONES',
                        'Itempreciocodigo' => $_POST['codigo']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        
        $_SESSION['combinaciones']=json_decode($resp);
        
        echo json_encode($resp);
    }
    if($_POST["metodo"]=="OBTENERPRODUCTOSESPECIFICOS") { 
        $url = $GLOBALS['RUTA_LOCAL'].'vendedoras.php';
                            
        $data = array( 'metodo' => 'OBTENERPRODUCTOSESPECIFICOS',
                        'Itempreciocodigo' => $_POST['codigo']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        
        $_SESSION['producto']=json_decode($resp);
        
        echo json_encode($resp);
    }
    if($_POST["metodo"]=="OBTENERCOLORESPORLINEA") {         
        $url = $GLOBALS['RUTA_LOCAL'].'tiendavirtual.php';
        $data = array( 'metodo' => 'OBTENERCOLORESPORLINEA',
                        'Familia' => $_POST['Familia'],
                        'Linea' => $_POST['Linea'],
                        'ColeccionID' => $_POST['ColeccionID']
        );        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);        
        echo json_encode($resp);                
    }
    if($_POST["metodo"]=="OBTENERIMAGENESCOLORES") {         
        $url = $GLOBALS['RUTA_LOCAL'].'tiendavirtual.php';
        $data = array( 'metodo' => 'OBTENERIMAGENESCOLORES',
                        'path' => $_POST['path']
        );        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);        
        echo json_encode($resp);                
    }  
    //OBTENERSTOCKGENERAL
    if($_POST["metodo"]=="OBTENERSTOCKGENERAL") { 
        $url = $GLOBALS['RUTA_LOCAL'].'tiendavirtual.php';
                            
        $data = array( 'metodo' => 'OBTENERSTOCKGENERAL',
                        'Item' => $_POST['codigo']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        
        $_SESSION['stocks']=json_decode($resp);
        
        echo json_encode($resp);
    }
    if($_POST["metodo"]=="DESCUENTO") { 
        $url = $GLOBALS['RUTA_LOCAL'].'precio.php';
                            
        $data = array( 'metodo' => 'DESCUENTO',
                        'codigo' => $_POST['codigo'],
                        'lineafamilia' => $_POST['lineafamilia'],
                        'linea' => $_POST['linea'],
                        'temporada' => $_POST['temporada']
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        echo json_encode($resp);
    }
    
    if($_POST["metodo"]=="ArticuloCantidadAjax") { 
        $url = $GLOBALS['RUTA_LOCAL'].'vendedoras.php';
                            
        $data = array( 'metodo' => 'OBTENERARTICULOSCANTIDAD',
                        'Linea' => $_POST['Linea']);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        echo json_encode($resp);
    }  
    
    if($_POST["metodo"]=="obtenerArticuloTallaAjax") { 
        $url = $GLOBALS['RUTA_LOCAL'].'vendedoras.php';
                            
        $data = array( 'metodo' => 'OBTENERARTICULOTALLA',
                        'Linea' => $_POST['Linea']);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        echo json_encode($resp);
    }  
    if($_POST["metodo"]=='obtenerArticuloCantidadAjax'){
        $url = $GLOBALS['RUTA_LOCAL'].'vendedoras.php';
                            
        $data = array( 'metodo' => 'OBTENERARTICULOCANTIDAD',
                        'Linea' => $_POST['Linea']);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        echo json_encode($resp);
    }
    
    
?>
