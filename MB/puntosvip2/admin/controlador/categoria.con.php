<?php 		
	include("../negocio/cCategoria.class.php");
	
	if($_GET["f"]=="listar"){							
		$objeto = new cCategoria();	
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
			$json .= '"imagen":"'.$reg['imagen'].'",';
			$json .= '"estado":"'.$reg['estado'].'"';
			$json .= '},';	 
		}
		$json = substr($json, 0, -1);		 
		$json .= ']'."\n";
		$json .= '}';	
		 
		echo $json;
	}
	if($_GET["f"]=="listado"){							
		$objeto = new cCategoria();	
		$res = $objeto->listarweb();
		$json = "[";
		foreach($res as $reg){
			$json .= '{';
			$json .= '"id":"'.$reg['id'].'",';
			$json .= '"nombre":"'.$reg['nombre'].'",';
			$json .= '"imagen":"'.$reg['imagen'].'",';
			$json .= '"estado":"'.$reg['estado'].'"';
			$json .= '},';	 
		}
		$json = substr($json, 0, -1);		 
		$json .= "]";  
		echo $json;
	}
	if($_GET["f"]=="nuevo"){
		$objeto = new cCategoria();	
		$arrayData = $_POST;		
		$res = $objeto->nuevo($arrayData);
		echo $res;
	}	
	if($_GET["f"]=="revisarelacion"){
		$objeto = new cCategoria();	
		$res = $objeto->revisarelacion($_POST["id"]);
		$json = '';
		$json .= '{';
		$json .= '"total":"'.$res[0]['registros'].'"';
		$json .= '}';
		echo $json;
	}
	if($_GET["f"]=="borrar"){
		$objeto = new cCategoria();	
		$arrayData = $_POST;	
		$res = $objeto->borrar($arrayData);
		echo $res;
	}
	if($_GET["f"]=="actualizar"){
		$objeto = new cCategoria();	
		$arrayData = $_POST;
		$res = $objeto->actualizar($arrayData);
		echo $res;
	}		
	if($_GET["f"]=="buscar"){
		$objeto = new  cCategoria();	
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
		$objeto = new cCategoria();	
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