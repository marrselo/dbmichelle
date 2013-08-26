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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
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
	function ObtenerClasesPorLinea()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "SELECT * FROM wh_clasefamilia WHERE linea = '$_POST[Linea]' ";
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Familias" => array());
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
										  'Familia'=>$query_row['familia'],
										  'Descripcionlocal'=>$query_row['descripcionlocal'],
										  'Linea'=>$query_row['linea']
									);
				}
				
				$query_result = array("Familias" => $temp_array);
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
	
	function ObtenerTemporadas()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "SELECT * FROM wh_caracteristicavalues WHERE estado = 'A' ";
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Temporadas" => array());
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
										  'Valor'=>$query_row['valor'],
										  'Descripcion'=>utf8_encode($query_row['descripcion'])
									);
				}
				
				$query_result = array("Temporadas" => $temp_array);
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
	
	function ObtenerColecciones()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "SELECT * FROM coleccion WHERE estado = 'A' ";
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Colecciones" => array());
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
										'ColeccionID'=>$query_row['ColeccionID'],
										'Descripcion'=>utf8_encode($query_row['Descripcion'])
									);
				}
				
				$query_result = array("Colecciones" => $temp_array);
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
	
	
	
	function ObtenerProductosEspecificos() // MODIFICADO
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "SELECT I.itempreciocodigo, I.item, I.descripcioncompleta, 
							I.color, C.descripcioncorta AS ColorDesc,
							I.tallacodigo, T.descripcionlocal AS TallaDesc,
							sum((A.stockactual - A.stockcomprometido)) AS stockdisponible, 
							P.monto 
						FROM  
							wh_itemmast I, 
							wh_itemalmacenlote A, 
							co_fiscalestablecimiento E, 
							colormast C, 
						    wh_talla T, 
							co_precio P 
						WHERE 
							I.itempreciocodigo = '$_POST[Itempreciocodigo]' AND 
							I.item = A.item AND 
							E.almacendefault = A.almacendefault AND 
							(A.stockactual - A.stockcomprometido) > 0 AND 
							E.marca <> '' AND 
							E.direccioncomercial IS NOT NULL AND 
							C.color = I.color AND 
							T.talla = I.tallacodigo AND  
							I.itempreciocodigo = P.itemcodigo AND 
							P.tiporegistro= 'P' AND 
							P.cliente = '$$' AND 
							P.periodovalidez = '$$' 					
						GROUP BY I.item, I.color, I.tallacodigo
						ORDER BY C.color ASC,T.talla DESC ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Especificos" => array());
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
										  'Item'=>$query_row['itempreciocodigo'],
										  'ItemColor'=>$query_row['item'],
										  'Descripcioncompleta'=>utf8_encode($query_row['descripcioncompleta']),
										  'Color'=>$query_row['color'],
										  'ColorDesc'=>$query_row['ColorDesc'],
										  'Talla'=>$query_row['tallacodigo'],
										  'TallaDesc'=>$query_row['TallaDesc'],
										  'Stockdisponible'=>$query_row['stockdisponible'],
										  'monto'=>$query_row['monto']
									);
				}
				
				$query_result = array("Especificos" => $temp_array);
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
	
	function ObtenerCombinaciones()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
				$query = "  SELECT DISTINCT I.itempreciocodigo, PG.descripcionlocal, F.descripcionlocal AS FamiliaDesc, I.caracteristicavalor04, I.linea, I.familia
							FROM
							  combinacion C,
							  wh_itemmast I,
							  wh_itemmast PG,
							  wh_itemalmacenlote A,
							  co_fiscalestablecimiento E,
							  wh_clasefamilia F
							WHERE C.Item2 = I.itempreciocodigo 
							AND PG.item = I.itempreciocodigo 
							AND I.linea = F.linea 
							AND I.item = A.item 
							AND E.almacendefault = A.almacendefault 
							AND F.familia = I.familia 
							AND C.Item1 =  '$_POST[Itempreciocodigo]' 
							UNION 
							SELECT DISTINCT I.itempreciocodigo, PG.descripcionlocal, F.descripcionlocal AS FamiliaDesc, I.caracteristicavalor04,  I.linea, I.familia
							FROM
							  combinacion C,
							  wh_itemmast I,
							  wh_itemmast PG,
							  wh_itemalmacenlote A,
							  co_fiscalestablecimiento E,
							  wh_clasefamilia F
							WHERE C.Item1 = I.itempreciocodigo 
							AND PG.item = I.itempreciocodigo 
							AND I.linea = F.linea 
							AND I.item = A.item 
							AND E.almacendefault = A.almacendefault 
							AND F.familia = I.familia 
							AND C.Item2 =  '$_POST[Itempreciocodigo]' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Combinaciones" => array());
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
										'Itempreciocodigo'=>$query_row['itempreciocodigo'],
										'Descripcioncompleta'=>$query_row['descripcionlocal'],
										'Familia'=>$query_row['FamiliaDesc'],
										'Codigotemporada'=>$query_row['caracteristicavalor04'],
										'Codigolinea'=>$query_row['linea'],
										'Codigofamilia'=>$query_row['familia'],
									);
				}
				
				$query_result = array("Combinaciones" => $temp_array);
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
	
	function ObtenerStockOtrasTiendas()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT E.descripcionlocal, (A.stockactual - A.stockcomprometido)as stockdisponible
						FROM 
							wh_itemmast I,
							wh_itemalmacenlote A,
							co_fiscalestablecimiento E
						WHERE
							I.item = A.item AND
							E.almacendefault = A.almacendefault AND
							I.item = '$_POST[Item]' AND
							E.establecimientocodigo <> '$_POST[Establecimientocodigo]' AND
							E.marca <> '' AND
							E.direccioncomercial IS NOT NULL";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("StockOtrasTiendas" => array());
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
										'Descripcionlocal'=>$query_row['descripcionlocal'],
										'Stockdisponible'=>$query_row['stockdisponible']
									);
				}
				
				$query_result = array("StockOtrasTiendas" => $temp_array);
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
	
	function ObtenerStockLocal()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT I.tallacodigo, I.color, (A.stockactual - A.stockcomprometido)as stockdisponible
						FROM 
							wh_itemmast I,
							wh_itemalmacenlote A,
							co_fiscalestablecimiento E
						WHERE
							I.item = A.item AND
							E.almacendefault = A.almacendefault AND
							I.itempreciocodigo = '$_POST[Item]' AND
							E.establecimientocodigo = '$_POST[Establecimientocodigo]' AND
							E.marca <> '' AND
							E.direccioncomercial IS NOT NULL";
								
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
	
	function ObtenerStockLocalItemEspecifico()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT I.tallacodigo, I.color, (A.stockactual - A.stockcomprometido)as stockdisponible
						FROM 
							wh_itemmast I,
							wh_itemalmacenlote A,
							co_fiscalestablecimiento E
						WHERE
							I.item = A.item AND
							E.almacendefault = A.almacendefault AND
							I.item = '$_POST[ItemEspecifico]' AND
							E.establecimientocodigo = '$_POST[Establecimientocodigo]' AND
							E.marca <> '' AND
							E.direccioncomercial IS NOT NULL";
								
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
	
	function ObtenerPrecios()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT DISTINCT P.cliente, P.monto AS precio, D.monto AS descuento
						FROM
						  co_precio P LEFT JOIN co_precio D ON (P.itemcodigo = D.itemcodigo)
						WHERE D.tiporegistro = 'D'
						  AND P.tiporegistro = 'P'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Precios" => array());
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
										'Cliente'=>$query_row['cliente'],
										'Precio'=>$query_row['precio'],
										'Descuento'=>$query_row['descuento']
									);
				}
				
				$query_result = array("Precios" => $temp_array);
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
	
	function ObtenerClientePorDNI()
	{
					$host_name = '192.168.1.193';
					$host_password = 'migramb';
					$host_user = 'migra';
					$database_name = 'mbinterface';

					$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
					$exists_database = mysql_select_db($database_name);

					if ($exists_database)
					{
							$query = "SELECT * FROM personamast
									  WHERE documentoidentidad = '$_POST[DNI]'
										AND estado = 'A'
										AND escliente = 'S'";
							$query_resource = mysql_query($query);

							if ($query_resource == FALSE)
							{
									$query_result = array("Clientes" => array());
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
															  "Busqueda" => $query_row['busqueda'],
															  "Tipopersona" => utf8_encode($query_row['tipopersona']),
															  "Documentoidentidad"=> utf8_encode($query_row['documentoidentidad']),
															  "RUC"=> utf8_encode($query_row['documentofiscal']),
															  "Tarjetadecredito" => $query_row['tarjetacredito'],
															  "Direccion" => $query_row['direccion'],
															  "Telefono" => $query_row['telefono'],
															  "Telefonoemergencia" => $query_row['telefonoemergencia'],
															  "Correoelectronico" => $query_row['correoelectronico']
															);
									}

									$query_result = array("Clientes" => $temp_array);
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
	
	function ObtenerProductoPorCodigo()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT DISTINCT PG.item, PG.linea AS CodigoLinea, PG.familia AS CodigoFamilia,PG.Caracteristicavalor04 AS Temporada,PG.descripcionlocal AS Producto, F.descripcionlocal AS Familia, C.Descripcion AS Descripcion
						FROM
							wh_itemmast PG,
							wh_clasefamilia F,
							coleccion C
							
						WHERE
							PG.item = '$_POST[codigo_producto]'
						AND PG.itemtipo = 'PG'
						AND PG.linea = F.linea
						AND PG.familia = F.familia
						AND (
							C.Temporada1 = PG.caracteristicavalor04 OR
							C.Temporada2 = PG.caracteristicavalor04 OR
							C.Temporada3 = PG.caracteristicavalor04 OR
							C.Temporada4 = PG.caracteristicavalor04 OR
							C.Temporada5 = PG.caracteristicavalor04						
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
										  'Producto'=>$query_row['Producto'],
										  'CodigoLinea'=>$query_row['CodigoLinea'],
										  'CodigoFamilia'=>$query_row['CodigoFamilia'],
										  'Familia'=>$query_row['Familia'],
										  'Temporada'=>$query_row['Temporada'],
										  'Coleccion'=>utf8_encode($query_row['Descripcion'])
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
	
	function ObtenerProductoCodigo()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
				$query = " SELECT P.moneda AS TipoMoneda, PD.descripcioncompleta AS Descripcion									
							FROM
							co_precio P,
							wh_itemmast PD
							WHERE
								PD.item = '$_POST[codigo_producto]'
								AND PD.itempreciocodigo = P.itemcodigo
								AND P.tiporegistro = 'P'
								AND P.cliente = '$$'
								AND P.periodovalidez = '$$'
							";
				$query_resource = mysql_query($query);

			if ($query_resource == FALSE)
			{
				$query_result = array("Producto" => array());
				mysql_close($database_conn);
				$this->sendResponse("Error en el query.");	
			} 
			else 
			{
				$temp_result = array();
				while ($query_row = mysql_fetch_array($query_resource)) 
				{
					$temp_array[] = array(					
									'TipoMoneda'=>$query_row['TipoMoneda'],
									'Descripcion'=>$query_row['Descripcion']);									
				}				
				$query_result = array("Producto" => $temp_array);
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
	
	function ObtenerProductos()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
				$query = " SELECT distinct I.itempreciocodigo as descripcion
							FROM 
								wh_itemmast I,
								wh_ItemFoto F,
								coleccion C
							WHERE
								I.item = F.item AND
								I.ItemTipo = 'PT'AND
								C.estado = 'A'
							AND (
								C.Temporada1 = I.caracteristicavalor04 OR
								C.Temporada2 = I.caracteristicavalor04 OR
								C.Temporada3 = I.caracteristicavalor04 OR
								C.Temporada4 = I.caracteristicavalor04 OR
								C.Temporada5 = I.caracteristicavalor04
							)

							";
				$query_resource = mysql_query($query);

			if ($query_resource == FALSE)
			{
				$query_result = array("Producto" => array());
				mysql_close($database_conn);
				$this->sendResponse("Error en el query.");	
			} 
			else 
			{
				$temp_result = array();
				while ($query_row = mysql_fetch_array($query_resource)) 
				{
					$temp_array[] = array(									
									'descripcion'=>$query_row['descripcion']);									
				}				
				$query_result = array("Producto" => $temp_array);
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
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
 	/*if( strcmp($nombreMetodo, "OBTENERCLASESPORLINEA") == 0 ){
 		$vendedora-> ObtenerClasesPorLinea();
 	}
 	if( strcmp($nombreMetodo, "OBTENERTEMPORADAS") == 0 ){
 		$vendedora-> ObtenerTemporadas();
 	}
 	if( strcmp($nombreMetodo, "OBTENERPRODUCTOSGENERICOS") == 0 ){
 		$vendedora-> ObtenerProductosGenericos();
 	}
	if( strcmp($nombreMetodo, "OBTENERPRODUCTOSESPECIFICOS") == 0 ){
 		$vendedora-> ObtenerProductosEspecificos();
 	}
	if( strcmp($nombreMetodo, "OBTENERCOMBINACIONES") == 0 ){
 		$vendedora-> ObtenerCombinaciones();
 	}
	if( strcmp($nombreMetodo, "OBTENERSTOCKOTRASTIENDAS") == 0 ){
 		$vendedora-> ObtenerStockOtrasTiendas();
 	}	
	if( strcmp($nombreMetodo, "OBTENERCOLECCIONES") == 0 ){
 		$vendedora-> ObtenerColecciones();
 	}
	if( strcmp($nombreMetodo, "OBTENERSTOCKLOCAL") == 0 ){
 		$vendedora-> ObtenerStockLocal();
 	}
 	
	if( strcmp($nombreMetodo, "OBTENERCLIENTEPORDNI") == 0 ){
 		$vendedora-> ObtenerClientePorDNI();
 	}		
	if( strcmp($nombreMetodo, "BUSCARPRODUCTOPORCODIGO") == 0 ){
 		$vendedora-> ObtenerProductoPorCodigo();
 	}
	if( strcmp($nombreMetodo, "BUSCARPRODUCTOPORCODIGOESPECIFICO") == 0 ){
 		$vendedora-> ObtenerStockLocalItemEspecifico();
 	}
	if( strcmp($nombreMetodo, "OBTENERPRODUCTOCODIGO") == 0 ){		
 		$vendedora-> ObtenerProductoCodigo();
	}
	if( strcmp($nombreMetodo, "OBTENERPRODUCTOS") == 0 ){		
 		$vendedora-> ObtenerProductos();
	}	*/
}
	
?>$_POST[Linea]