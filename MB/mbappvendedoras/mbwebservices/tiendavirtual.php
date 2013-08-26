<?php

class Tiendavirtual
{
    function getStatusCodeMessage($status) 
	{
		$codes = Array(100 => 'Continue', 101 => 'Switching Protocols', 200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 
		204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content', 300 => 'Multiple Choices', 301 => 'Moved Permanently', 
		302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 306 => '(Unused)', 307 => 'Temporary Redirect', 400 => 'Bad Request', 
		401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 
		407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 
		413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 
		417 => 'Expectation Failed', 500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 
		504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported');

		return (isset($codes[$status])) ? $codes[$status] : '';
	}
	
	function sendResponse($status = 200, $body = '', $content_type = 'application/json') 
	{
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this -> getStatusCodeMessage($status);
		header($status_header);
		header('Content-type: ' . $content_type);
		echo $body;
		exit;
	}
	
	function __construct()
	{}	
	
	function __destruct()
	{}

	
	function ObtenerImagenesColores() //path
	{
		//http://209.45.30.34/imagenes/fotos/B13/01/001/AB0169BNN.JPG
		$path = "../../../../".substr($_POST["path"],20);
		if (file_exists($path)) {
			$this->sendResponse(200, "1");
		} else {
			$this->sendResponse(200, "0");
		}
	}
	
	function ObtenerColoresPorLinea()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "SELECT CO.color, CO.descripcioncorta 
						FROM 
						  wh_itemmast I  
						  inner join wh_itemmast PG on PG.item = I.itempreciocodigo   
						  inner join colormast CO on CO.color = I.Color 
						  inner join coleccion C on C.ColeccionID = '$_POST[ColeccionID]'  
						WHERE 
						  I.familia = '$_POST[Familia]'   
						  AND I.linea = '$_POST[Linea]'  
						  AND ( 
						  C.Temporada1 = I.caracteristicavalor04 
						  OR 
						  C.Temporada2 = I.caracteristicavalor04 
						  OR 
						  C.Temporada3 = I.caracteristicavalor04 
						  OR 
						  C.Temporada4 = I.caracteristicavalor04 
						  OR 
						  C.Temporada5 = I.caracteristicavalor04 
						  ) 
						  GROUP BY CO.color 
						  ORDER BY CO.descripcioncorta";
			
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Colores" => array());
				mysql_close($database_conn);
				$this->sendResponse("Error en el query.");	
			} 
			else 
			{
				$temp_result = array();
				while ($query_row = mysql_fetch_array($query_resource)) 
				{
					$temp_array[] = array
									(
										  'Color'=>$query_row['color'],
										  'Descripcion'=>$query_row['descripcioncorta']
									);
				}
				
				$query_result = array("Colores" => $temp_array);
				mysql_close($database_conn);
				$this->sendResponse(200, json_encode($query_result));
			}			
		} 
		else 
		{
			$mysql_close($database_conn);
			$this->sendResponse(500, "No existe la base de datos.");
		}		
	}
	function ObtenerProductosGenericosPorColor()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT DISTINCT PG.item, PG.descripcionlocal, PG.caracteristicavalor04, PG.marcacodigo, P.monto, P.moneda
						FROM
							wh_itemmast I,
							wh_itemmast PG,
							coleccion C,
							co_precio P,
							wh_ItemFoto F
						WHERE
							PG.item = I.itempreciocodigo 
							AND I.Color = '$_POST[Color]' 
							AND I.item = F.item
							AND P.tiporegistro = 'P'
							AND P.cliente = '$$'
							AND P.periodovalidez = '$$'
							AND PG.item = P.itemcodigo
							AND I.familia = '$_POST[Familia]'
							AND I.linea = '$_POST[Linea]'
							AND C.ColeccionID = '$_POST[ColeccionID]'
							AND (
								C.Temporada1 = I.caracteristicavalor04 OR
								C.Temporada2 = I.caracteristicavalor04 OR
								C.Temporada3 = I.caracteristicavalor04 OR
								C.Temporada4 = I.caracteristicavalor04 OR
								C.Temporada5 = I.caracteristicavalor04						
								)";
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Genericos" => array());
				mysql_close($database_conn);
				$this->sendResponse(500, "Error en el query.");	
			} 
			else 
			{
				$temp_result = array();
				while ($query_row = mysql_fetch_array($query_resource)) 
				{
					$temp_array[] = array
									(
										  'Itempreciocodigo'=>$query_row['item'],
										  'Descripcionsubfamilia'=>utf8_encode($query_row['descripcionlocal']),
										  'Caracteristicavalor04'=>$query_row['caracteristicavalor04'],
										  'Precio'=>$query_row['monto'],
										  'Moneda'=>$query_row['moneda'],
										  'Marca'=>$query_row['marcacodigo']
									);
				}
				
				$query_result = array("Genericos" => $temp_array);
				mysql_close($database_conn);
				$this->sendResponse(200, json_encode($query_result));
			}			
		} 
		else 
		{
			$mysql_close($database_conn);
			$this->sendResponse(500, "No existe la base de datos.");
		}		
	}
	function ObtenerProductosGenericosPorNombre()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT DISTINCT PG.item
						              , PG.descripcionlocal
						              , PG.caracteristicavalor04
						              , PG.marcacodigo
						              , P.monto
						              , P.moneda
						              , I.linea 
						              , I.familia 
						FROM
						  wh_itemmast I,
						  wh_itemmast PG,
						  coleccion C,
						  co_precio P,
						  wh_ItemFoto F
						WHERE
						  PG.item = I.itempreciocodigo
						  AND I.item = F.item
						  AND P.tiporegistro = 'P'
						  AND P.cliente = '$$'
						  AND P.periodovalidez = '$$'
						  AND PG.item = P.itemcodigo
						  AND PG.descripcionlocal LIKE '%%$_POST[Cadena]%%' 
						  AND C.ColeccionID = '2'
						  AND (
						  C.Temporada1 = I.caracteristicavalor04
						  OR
						  C.Temporada2 = I.caracteristicavalor04
						  OR
						  C.Temporada3 = I.caracteristicavalor04
						  OR
						  C.Temporada4 = I.caracteristicavalor04
						  OR
						  C.Temporada5 = I.caracteristicavalor04
						  )";
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Genericos" => array());
				mysql_close($database_conn);
				$this->sendResponse("Error en el query.");	
			} 
			else 
			{
				$temp_result = array();
				while ($query_row = mysql_fetch_array($query_resource)) 
				{
					$temp_array[] = array
									(
										  'Itempreciocodigo'=>$query_row['item'],
										  'Descripcionsubfamilia'=>utf8_encode($query_row['descripcionlocal']),
										  'Caracteristicavalor04'=>$query_row['caracteristicavalor04'],
										  'Precio'=>$query_row['monto'],
										  'Moneda'=>$query_row['moneda'],
										  'Marca'=>$query_row['marcacodigo'],
										  'Linea'=>$query_row['linea'],
										  'Familia'=>$query_row['familia']
									);
				}
				
				$query_result = array("Genericos" => $temp_array);
				mysql_close($database_conn);
				$this->sendResponse(200, json_encode($query_result));
			}			
		} 
		else 
		{
			$mysql_close($database_conn);
			$this->sendResponse(500, "No existe la base de datos.");
		}		
	}
		
	/* SERVICO PARA LA TIENDA VIRTUAL - WEB JAA */
	function ObtenerStockGeneral()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT I.tallacodigo, I.color, sum(A.stockactual - A.stockcomprometido) as stockdisponible
						FROM 
							wh_itemmast I,
							wh_itemalmacenlote A,
							co_fiscalestablecimiento E
						WHERE
							I.item = A.item AND
							E.almacendefault = A.almacencodigo AND
							I.itempreciocodigo = '$_POST[Item]' AND
							E.TipoTienda <> '' AND
							E.direccioncomercial IS NOT NULL
						GROUP BY
							I.ItemPrecioCodigo, I.Color, I.TallaCodigo
						ORDER BY
							I.ItemPrecioCodigo, I.Color, I.TallaCodigo";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("StockLocal" => array());
				mysql_close($database_conn);
				$this->sendResponse("Error en el query.");	
			} 
			else 
			{
				$temp_result = array();
				while ($query_row = mysql_fetch_array($query_resource)) 
				{
					$temp_array[] = array
									(
										'Tallacodigo'=>$query_row['tallacodigo'],
										'Colorcodigo'=>$query_row['color'],
										'Stockdisponible'=>$query_row['stockdisponible']
									);
				}
				
				$query_result = array("StockLocal" => $temp_array);
				mysql_close($database_conn);
				$this->sendResponse(200, json_encode($query_result));
			}			
		
		} 
		else 
		{
			$mysql_close($database_conn);
			$this->sendResponse(500, "No existe la base de datos.");
		}
	}
	function GrabarCompra()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = " INSERT INTO web_carrito
						    (pagototal, 
						    	idCliente)
						VALUES
						    ('$_POST[totalCompra]',
						    	'$_POST[idCliente]')
						  ";

			mysql_query($query);

			$idCliente = mysql_insert_id();
			
			if (intval($idCliente) > 0)
			{
				$response = array('idCarrito' => $idCliente);
			}
			if(intval($idCliente)== 0)
			{
				$response = array('idCarrito' => 0);
			}
                            
            mysql_close($databaseConn);
			$this->sendResponse(200,json_encode($response));
		} 
		else 
		{
			$mysql_close($database_conn);
			$this->sendResponse(500, "No existe la base de datos.");
		}		
	}
	function GrabarCompraDetalle()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = " INSERT INTO web_carrito_detalle 
						    (idCarrito, idProducto, cantidad, precio, idProductoEspecifico) 
						VALUES
						    ('$_POST[idCarrito]', '$_POST[idProducto]', '$_POST[cantidad]', '$_POST[precio]', '$_POST[idProducto]') 
						  ";

			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("idCarritoDetalle" => 0);
				mysql_close($database_conn);
				$this->sendResponse("Error en el query.");	
			} 
			else 
			{
				$query_result = array("idCarritoDetalle" => 1);
				mysql_close($database_conn);
				$this->sendResponse(200, json_encode($query_result));
			}		
		} 
		else 
		{
			$mysql_close($database_conn);
			$this->sendResponse(500, "No existe la base de datos.");
		}		
	}

        function ObtenerStockEspecifico()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT I.tallacodigo, I.color, sum(A.stockactual - A.stockcomprometido) as stockdisponible
						FROM 
							wh_itemmast I,
							wh_itemalmacenlote A,
							co_fiscalestablecimiento E
						WHERE
							I.item = A.item AND
							E.almacendefault = A.almacencodigo AND
							I.itempreciocodigo = '$_POST[Item]' AND
							E.TipoTienda <> '' AND
							E.direccioncomercial IS NOT NULL
                                                        AND I.color ='$_POST[color]'
						GROUP BY
							I.ItemPrecioCodigo, I.Color, I.TallaCodigo
						ORDER BY
							I.ItemPrecioCodigo, I.Color, I.TallaCodigo";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("StockLocal" => array());
				mysql_close($database_conn);
				$this->sendResponse("Error en el query.");	
			} 
			else 
			{
				$temp_result = array();
				while ($query_row = mysql_fetch_array($query_resource)) 
				{
					$temp_array[] = array
									(
										'Tallacodigo'=>$query_row['tallacodigo'],
										'Colorcodigo'=>$query_row['color'],
										'Stockdisponible'=>$query_row['stockdisponible']
									);
				}
				
				$query_result = array("StockLocal" => $temp_array);
				mysql_close($database_conn);
				$this->sendResponse(200, json_encode($query_result));
			}			
		
		} 
		else 
		{
			$mysql_close($database_conn);
			$this->sendResponse(500, "No existe la base de datos.");
		}
	}
        
}	
$vendedora = new tiendavirtual();

if( isset($_POST['metodo']))
{
	$nombreMetodo = $_POST['metodo'];
 	if( strcmp($nombreMetodo, "OBTENERIMAGENESCOLORES") == 0 ){
 		$vendedora-> ObtenerImagenesColores();
 	}
 	if( strcmp($nombreMetodo, "OBTENERCOLORESPORLINEA") == 0 ){
 		$vendedora-> ObtenerColoresPorLinea();
 	}
 	if( strcmp($nombreMetodo, "OBTENERSTOCKGENERAL") == 0 ){
 		$vendedora-> ObtenerStockGeneral();
 	}
 	if( strcmp($nombreMetodo, "OBTENERPRODUCTOSGENERICOSPORCOLOR") == 0 ){
 		$vendedora-> ObtenerProductosGenericosPorColor();
 	}
 	if( strcmp($nombreMetodo, "OBTENERPRODUCTOSGENERICOSPORNOMBRE") == 0 ){
 		$vendedora-> ObtenerProductosGenericosPorNombre();
 	}
 	if( strcmp($nombreMetodo, "GRABARCOMPRA") == 0 ){
 		$vendedora-> GrabarCompra();
 	}
 	if( strcmp($nombreMetodo, "GRABARCOMPRADETALLE") == 0 ){
 		$vendedora-> GrabarCompraDetalle();
 	}
        /*implementar */
        if( strcmp($nombreMetodo, "OBTENERSTOCKESPECIFICO") == 0 ){
 		$vendedora->ObtenerStockEspecifico();
 	}
}
	
?>