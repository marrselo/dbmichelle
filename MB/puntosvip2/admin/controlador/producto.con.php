<?php 		
	include("../negocio/cProducto.class.php");
	
	if($_GET["f"]=="listar"){							
		$objeto = new cProducto();	
		$res = $objeto->totalreg();
	
		$json = "{\n";
		$json .= '"total": "'.$res[0]["registros"].'",'."\n";
		$json .= '"rows": [';
                
		$res = $objeto->listar();
                //print_r($reg);
                
		foreach($res as $reg){                    
			$json .= "\n".'{';
			$json .= '"id":"'.$reg['id'].'",';
			$json .= '"id_categoria":"'.$reg['id_categoria'].'",';
			$json .= '"id_empresa":"'.$reg['id_empresa'].'",';
			$json .= '"codigo":"'.$reg['codigo'].'",';
			$json .= '"categoria":"'.$reg['categoria'].'",';
			$json .= '"empresa":"'.$reg['empresa'].'",';
			$json .= '"nombre":"'.$reg['nombre'].'",';
			$json .= '"descripcion":"'.$reg['descripcion'].'",';
			$json .= '"condiciones":"'.$reg['condiciones'].'",';
			$json .= '"puntos":"'.$reg['puntos'].'",';
			$json .= '"canjepuntos":"'.$reg['canjepuntos'].'",';
			$json .= '"canjesoles":"'.$reg['canjesoles'].'",';                        
			$json .= '"logo":"'.trim($reg['productologo']).'",';
			$json .= '"imagen":"'.trim($reg['productoimagen']).'",';
                        $json .= '"estado":"'.$reg['estado'].'"';
			$json .= '},';	 
		}
		$json = substr($json, 0, -1);		 
		$json .= ']'."\n";
		$json .= '}';	
		 
		echo $json;
	}
        if($_GET["f"]=="listarxcategoria"){							
		$objeto = new cProducto();	
		$res = $objeto->totalregxcategoria($_GET["cat"]);
	
		$json = "{\n";
		$json .= '"total": "'.$res[0]["registros"].'",'."\n";
		$json .= '"rows": ['; 
			
		$res = $objeto->listarxcategoria($_GET["cat"]);
		foreach($res as $reg){
			$json .= "\n".'{';
			$json .= '"id":"'.$reg['id'].'",';
			$json .= '"id_categoria":"'.$reg['id_categoria'].'",';
			$json .= '"id_empresa":"'.$reg['id_empresa'].'",';
			$json .= '"codigo":"'.$reg['codigo'].'",';
			$json .= '"categoria":"'.$reg['categoria'].'",';
			$json .= '"empresa":"'.$reg['empresa'].'",';
			$json .= '"nombre":"'.$reg['nombre'].'",';
			$json .= '"descripcion":"'.$reg['descripcion'].'",';
			$json .= '"condiciones":"'.$reg['condiciones'].'",';
			$json .= '"puntos":"'.$reg['puntos'].'",';
			$json .= '"canjepuntos":"'.$reg['canjepuntos'].'",';
			$json .= '"canjesoles":"'.$reg['canjesoles'].'",';
			$json .= '"estado":"'.$reg['estado'].'"';
			$json .= '},';	 
		}
		$json = substr($json, 0, -1);		 
		$json .= ']'."\n";
		$json .= '}';	
		 
		echo $json;
	}
	if($_GET["f"]=="nuevo"){
		$objeto = new cProducto();	
		$arrayData = $_POST;		
		$res = $objeto->nuevo($arrayData);
		echo $res;
	}	
	if($_GET["f"]=="revisarelacion"){
		$objeto = new cProducto();	
		$res = $objeto->revisarelacion($_POST["id"]);
		$json = '';
		$json .= '{';
		$json .= '"total":"'.$res[0]['registros'].'"';
		$json .= '}';
		echo $json;
	}
	if($_GET["f"]=="borrar"){
		$objeto = new cProducto();	
		$arrayData = $_POST;	
		$res = $objeto->borrar($arrayData);
		echo $res;
	}
	if($_GET["f"]=="actualizar"){
		$objeto = new cProducto();	
		$arrayData = $_POST;
		$res = $objeto->actualizar($arrayData);
		echo $res;
	}
	
	if($_GET["f"]=="busqueda"){
		$objeto = new cProducto();
			
		if($_GET["tipo"]=="puntos")
			$res = $objeto->busqueda($_POST["id"],$_POST["rangopuntos"],null);	
		if($_GET["tipo"]=="nombre")
			$res = $objeto->busquedaNombre($_POST["nombre"]);	
		
		$json = "[";
		foreach($res as $reg){
			$json .= '{';
			$json .= '"idproducto":"'.$reg['idproducto'].'",';
			$json .= '"empnombre":"'.$reg['empnombre'].'",';
			$json .= '"imagen":"'.$reg['imagen'].'",';
			$json .= '"logo":"'.$reg['logo'].'",';
			$json .= '"puntos":"'.$reg['puntos'].'",';
			$json .= '"canjepuntos":"'.$reg['canjepuntos'].'",';
			$json .= '"canjesoles":"'.$reg['canjesoles'].'",';                        
			$json .= '"productologo":"'.$reg['productologo'].'",';
			$json .= '"productoimagen":"'.$reg['productoimagen'].'"';
			$json .= '},';	 
		}
		$json = substr($json, 0, -1);		 
		$json .= "]";  
		echo $json;
        }	 		
	if($_GET["f"]=="buscarsugeridos"){
		$objeto = new  cProducto();	
		$Data = $_POST["id"];
		$res = $objeto->buscarsugeridos($Data);
		if(!empty($res)){
			$json = "[";
			foreach($res as $reg){
				$json .= '{';
				$json .= '"id":"'.$reg['idproducto'].'",';
                                $json .= '"codigo":"'.$reg['codigo'].'",';
                                $json .= '"id_categoria":"'.$reg['id_categoria'].'",';
				$json .= '"logo":"'.$reg['logo'].'",';
				$json .= '"imagen":"'.$reg['imagen'].'",';
				$json .= '"direccion":"'.$reg['direccion'].'",';
				$json .= '"nombre":"'.$reg['nomproducto'].'",';
				$json .= '"descripcion":"'.$reg['descripcion'].'",';
				$json .= '"condiciones":"'.$reg['condiciones'].'",';
				$json .= '"puntos":"'.$reg['puntos'].'",';
				$json .= '"canjepuntos":"'.$reg['canjepuntos'].'",';
                                $json .= '"canjesoles":"'.$reg['canjesoles'].'",';                        
                                $json .= '"productologo":"'.$reg['productologo'].'",';
                                $json .= '"productoimagen":"'.$reg['productoimagen'].'"';
				$json .= '},';	 
			}
			$json = substr($json, 0, -1);		 
			$json .= "]";  
			echo $json;
		}		
	}
        if($_GET["f"]=="buscar"){
		$objeto = new  cProducto();	
		$Data = $_POST["id"];
		$res = $objeto->buscar($Data);
		if(!empty($res)){
			$json = "[";
			foreach($res as $reg){
				$json .= '{';
				$json .= '"codigo":"'.$reg['codigo'].'",';
				$json .= '"logo":"'.$reg['logo'].'",';
				$json .= '"imagen":"'.$reg['imagen'].'",';
				$json .= '"direccion":"'.$reg['direccion'].'",';
				$json .= '"nombre":"'.$reg['nomproducto'].'",';
				$json .= '"descripcion":"'.$reg['descripcion'].'",';
				$json .= '"condiciones":"'.$reg['condiciones'].'",';
				$json .= '"puntos":"'.$reg['puntos'].'",';
				$json .= '"canjepuntos":"'.$reg['canjepuntos'].'",';
                                $json .= '"canjesoles":"'.$reg['canjesoles'].'",';                        
                                $json .= '"productologo":"'.$reg['productologo'].'",';
                                $json .= '"productoimagen":"'.$reg['productoimagen'].'"';
				$json .= '},';	 
			}
			$json = substr($json, 0, -1);		 
			$json .= "]";  
			echo $json;
		}		
	}
	if($_GET["f"]=="excel"){
            $objeto = new cProducto();	
            $filas = $objeto->listarxcategoria($_POST["idcategoria"]);

            //Traemos las librerias necesarias
            require_once("../php/PHPExcel.php");
            require_once("../php/PHPExcel/Writer/Excel2007.php");

            //objeto de PHP Excel
            $objPHPExcel = new PHPExcel();

            //algunos datos sobre autor√≠a
            $objPHPExcel->getProperties()->setCreator("Sistema de Puntos");
            $objPHPExcel->getProperties()->setLastModifiedBy("Sistema de Puntos");
            $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Reporte de Clientes");
            $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Reporte de Clientes");
            $objPHPExcel->getProperties()->setDescription("Reporte del Sistema de Puntos para Office 2007 XLSX, Usando PHPExcel.");

            //Trabajamos con la hoja activa principal
            $objPHPExcel->setActiveSheetIndex(0);

            //iteramos para los resultados
            $objPHPExcel->getActiveSheet()->SetCellValue("A1", "Categoria");
            $objPHPExcel->getActiveSheet()->SetCellValue("B1", "Empresa");
            $objPHPExcel->getActiveSheet()->SetCellValue("C1", "Producto");
            $objPHPExcel->getActiveSheet()->SetCellValue("D1", "Codigo");
            $objPHPExcel->getActiveSheet()->SetCellValue("E1", "Descripcion");
            $objPHPExcel->getActiveSheet()->SetCellValue("F1", "Condiciones");
            $objPHPExcel->getActiveSheet()->SetCellValue("G1", "Puntos");
            $objPHPExcel->getActiveSheet()->SetCellValue("H1", "Canje Puntos");
            $objPHPExcel->getActiveSheet()->SetCellValue("I1", "Canje Soles");
            $objPHPExcel->getActiveSheet()->SetCellValue("J1", "Estado");                
                
            $i=2;
            foreach($filas as $row){
                $objPHPExcel->getActiveSheet()->SetCellValue("A".$i, $row["categoria"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("B".$i, $row["empresa"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("C".$i, $row["nombre"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("D".$i, $row["codigo"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("E".$i, $row["descripcion"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("F".$i, $row["condiciones"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("G".$i, $row["puntos"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("H".$i, $row["canjepuntos"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("I".$i, $row["canjesoles"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("J".$i, $row["estado"]);                
                $i++;
            }

            //Titulo del libro y seguridad 
            $objPHPExcel->getActiveSheet()->setTitle('Reporte');
            $objPHPExcel->getSecurity()->setLockWindows(true);
            $objPHPExcel->getSecurity()->setLockStructure(true);


            // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="reporteProductos.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;		
	}	
?>