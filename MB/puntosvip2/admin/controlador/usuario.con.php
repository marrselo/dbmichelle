<?php 		
	include("../negocio/cUsuario.class.php");
	
	if($_GET["f"]=="listar"){							
		$objeto = new cUsuario();	
		$res = $objeto->totalreg();
	
		$json = "{\n";
		$json .= '"total": "'.$res[0]["registros"].'",'."\n";
		$json .= '"rows": ['; 
				
		//{"code":"001","name":"Name 1","addr":"Address 11","col4":"col4 data"}, 		
				
		$res = $objeto->listar();
		foreach($res as $reg){
			$json .= "\n".'{';
			$json .= '"id":"'.$reg['id'].'",';
			$json .= '"nombre":"'.$reg['nombre'].'",';
			$json .= '"clave":"'.$reg['clave'].'",';
			$json .= '"estado":"'.$reg['estado'].'"';
			$json .= '},';	 
		}
		$json = substr($json, 0, -1);		 
		$json .= ']'."\n";
		$json .= '}';	
		 
		echo $json;
	}
	if($_GET["f"]=="listado"){							
		$objeto = new cUsuario();	
		$res = $objeto->listar();
		$json = "[";
		foreach($res as $reg){
			$json .= '{';
			$json .= '"id":"'.$reg['id'].'",';
			$json .= '"nombre":"'.$reg['nombre'].'",';
			$json .= '"clave":"'.$reg['clave'].'",';
			$json .= '"estado":"'.$reg['estado'].'"';
			$json .= '},';	 
		}
		$json = substr($json, 0, -1);		 
		$json .= "]";  
		echo $json;
	}
	if($_GET["f"]=="nuevo"){
		$objeto = new cUsuario();	
		$arrayData = $_POST;		
		$res = $objeto->nuevo($arrayData);
		echo $res;
	}	
	if($_GET["f"]=="borrar"){
		$objeto = new cUsuario();	
		$arrayData = $_POST;	
		$res = $objeto->borrar($arrayData);
		echo $res;
	}
	if($_GET["f"]=="actualizar"){
		$objeto = new cUsuario();	
		$arrayData = $_POST;
		$res = $objeto->actualizar($arrayData);
		echo $res;
	}
	if($_GET["f"]=="login"){
		/*$url = 'http://www.onlinestudioproductions.com/mbws/clientemast.php';
		$data = array('metodo' => 'LISTARCLIENTE','pagina'=>'-1');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$resp = curl_exec($ch);
		curl_close($ch);
		echo $resp;*/
		$objeto = new cUsuario();	
		$arrayData = $_POST;
		$res = $objeto->login($arrayData);
		if( is_numeric($res[0]["id"]) ) {
			session_start();
			$_SESSION['id']=$res[0]["id"];
			$_SESSION['nombre']=$res[0]["nombre"];
			$_SESSION['estado']=$res[0]["estado"];
			echo $res[0]["id"];
		} else {
			echo null;
		}
	}
        if($_GET["f"]=="buscarcliente"){
            $url = 'http://209.45.30.34/online/mbapp/mbappvendedoras/mbwebservices/cliente.php';
            $data = array('metodo' => 'BUSCARCLIENTEPORDNI', 'Cliente' => $_POST['dni']);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $resp = curl_exec($ch);
            curl_close($ch);
            echo $resp;
        }
        if($_GET["f"]=="loginweb"){
            $url = 'http://localhost/online/mbapp/mbappvendedoras/mbwebservices/cliente.php';
            $data = array('metodo' => 'BUSCARCLIENTEPORDNI', 'documento' => $_POST['dni']);                                   
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $resp = curl_exec($ch);
            curl_close($ch);            
            $array1 = json_decode($resp);            
         
            if (count($array1) > 0) {                 
                //echo 'prueba';
                $data = array('metodo' => 'PUNTOSACUMULADOS', 'Cliente' => $array1[0]->idCliente);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $resp = curl_exec($ch); 
                curl_close($ch);
                $array = json_decode($resp);
				$licencia=$array1[0]->LicenciaNumero;
				$premio=$array1[0]->contratopremio;
				$cliente_vip=(!empty($licencia) && !empty($premio))? 'true' : 'false' ;                 
                $json = "[";
                $json .= '{';
                $json .= '"nombre":"'.$array1[0]->nombreCompleto.'",';
                $json .= '"coronitas":"'.$array->coronitas.'",';
                $json .= '"coronitas_vencer":"'.$array->coronitas_vencer.'",';
                $json .= '"cliente_vip":"'.$cliente_vip.'"';				
                $json .= '}';		 
		$json .= "]";  
		echo $json;
            }
            else {
                echo null;
            }
	}
        if($_GET["f"]=="obtenerpuntos"){
            $url = 'http://209.45.30.34/online/mbapp/mbws/clientemast.php';
            $data = array('metodo' => 'LISTAR_PUNTOS_GENERALES', 'cliente' => $_POST['id']);            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $resp = curl_exec($ch);
            curl_close($ch);
            
            $array = json_decode($resp);
            
            if (count($array) > 0) { 
                $json = "[";
                $json .= '{';
                $json .= '"cliente":"'.$array[0]->cliente.'",';
                $json .= '"licencia_nro":"'.$array[0]->licencia_nro.'",';
                $json .= '"p_canjear":"'.$array[0]->p_canjear.'",';
                $json .= '"p_vencer":"'.$array[0]->p_vencer.'",';
                $json .= '"p_vencido":"'.$array[0]->p_vencido.'",';
                $json .= '"p_obtenido":"'.$array[0]->p_obtenido.'"';
                $json .= '}';		 
		$json .= "]";  
		echo $json;
            } else {
                echo null;
            }
	}
        if($_GET["f"]=="obtenercompras"){
            $url = 'http://209.45.30.34/online/mbapp/mbws/co_documento.php';
            $data = array('metodo' => 'LISTARDOCUMENTO', 'ClienteNumero' => $_POST['id']);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $resp = curl_exec($ch);
            curl_close($ch);
            
            $array = json_decode($resp);
            
            if (count($array) > 0) { 
                $json = "[";
                $json .= '{';
                $json .= '"puntosganados":"'.$array[0]->puntosganados.'",';
                $json .= '"FechaDocumento":"'.$array[0]->FechaDocumento.'"';
                $json .= '}';		 
		$json .= "]";  
		echo $json;
            } else {
                echo null;
            }
	}
	if($_GET["f"]=="cerrarlogin"){
		session_start(); 
		unset ( $_SESSION['id'] );
		unset ( $_SESSION['nombre'] );
		unset ( $_SESSION['estado'] );
		session_destroy();	
	}
        if($_GET["f"]=="cerrarloginweb"){
		session_start(); 
		unset ( $_SESSION['id'] );
		unset ( $_SESSION['nombre'] );
		unset ( $_SESSION['estado'] );
		session_destroy();	
	}
	if($_GET["f"]=="buscar"){
		$objeto = new  cUsuario();	
		$Data = $_POST["id"];
		$res = $objeto->buscar($Data);
		if(!empty($res)){
			$json = "";
			$json .= "{";
			$json .= '"rows" : [';$json .= '{"campo" : "id", "valor" : "'.$res[0]["id"].'"}';$json .= ',{"campo" : "nombre", "valor" : "'.$res[0]["nombre"].'"}';							
			$json .= "]";
			$json .= "}";		
			echo $json;
		}		
	}
	if($_GET["f"]=="busqueda"){
		$objeto = new cUsuario();	
		$res = $objeto->busqueda($_POST["filtro"]);		
		foreach($res as $reg){ 
			?>          
			<tr height="3" class="filaresultado" id="<?php echo $reg["id"]; ?>"  nombre="<?php echo $reg["nombre"]; ?>" >  
						<td width="70" style="padding:2px;">
							<?php echo $reg["nombre"]; ?>
						</td> 
			</tr>
			<?php 
			
		}
		
    }	 
	
?>