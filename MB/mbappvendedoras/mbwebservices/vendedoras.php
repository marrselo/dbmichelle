<?php

class Vendedoras
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

	
	function ObtenerEstablecimientosPorMarca()
	{
			$host_name = '192.168.1.193';
			$host_password = 'migramb';
			$host_user = 'migra';
			$database_name = 'mbinterface';
			
			$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
			$exists_database = mysql_select_db($database_name);
			if ($exists_database) 
			{	
				$query = "SELECT * FROM co_fiscalestablecimiento WHERE TipoTienda = '$_POST[Marca]' ";
				$query_resource = mysql_query($query);

				if ($query_resource == FALSE) 
				{
					$query_result = array("Establecimientos" => array());
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
                                                "Establecimientocodigo" => $query_row['EstablecimientoCodigo'], 
                                                "Descripcionlocal" => utf8_encode($query_row['DescripcionLocal']), 
                                                "Direccion"=> utf8_encode($query_row['DireccionComercial']), 
                                                "Almacendefault" => $query_row['almacendefault'],
                                                "UsuarioT" => $query_row['UsuarioT'],
                                                "UltimoUsuario" => $query_row['UltimoUsuario'],
                                                "CentroCosto" => $query_row['CentroCosto']

                                            );
					}
					
					$query_result = array("Establecimientos" => $temp_array);
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

	function ObtenerGruposLineas()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "	SELECT distinct G.grupolinea, G.descripcionlocal
						FROM wh_claselinea L, wh_clasegrupolinea G
						WHERE L.grupolinea = G.grupolinea
						AND L.grupolinea like '0%'";
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Clases" => array());
				mysql_close($database_conn);
				$this->sendResponse(500, "Error en el query.");	
			} 
			else 
			{
				$query_result = array();
				while ($query_row = mysql_fetch_array($query_resource)) 
				{
					$query_result[] = array
									(
										  'GrupoLinea'=>$query_row['grupolinea'],
										  'Descripcionlocal'=>$query_row['descripcionlocal']
									);
				}
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

	function ObtenerFamiliasPorGrupoLinea()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "	SELECT F.familia, F.descripcionlocal, F.linea
						FROM
						  wh_claselinea L,
						  wh_clasegrupolinea G,
						  wh_clasefamilia F
						WHERE L.grupolinea = G.grupolinea
						AND L.linea = F.linea
						AND L.grupolinea = '$_POST[grupolinea]' ";
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Clases" => array());
				mysql_close($database_conn);
				$this->sendResponse(500, "Error en el query.");	
			} 
			else 
			{
				$query_result = array();
				while ($query_row = mysql_fetch_array($query_resource)) 
				{
					$query_result[] = array
									(
										  'Familia'=>$query_row['familia'],
										  'Descripcionlocal'=>utf8_encode($query_row['descripcionlocal']),
										  'Linea'=>$query_row['linea']
									);
				}
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
	
	function ObtenerLineas()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "SELECT * FROM wh_claselinea ";
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Clases" => array());
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
										  'Linea'=>$query_row['linea'],
										  'Descripcionlocal'=>$query_row['descripcionlocal']
									);
				}
				
				$query_result = array("Clases" => $temp_array);
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
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
                                            'Descripcionlocal'=>utf8_encode($query_row['descripcionlocal']),
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
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
	
	function ObtenerProductosGenericos()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT DISTINCT PG.item, PG.descripcionlocal, PG.caracteristicavalor04, PG.marcacodigo, P.monto, P.moneda, I.UnidadCodigo
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
                                            'Marca'=>$query_row['marcacodigo'],
                                            'Unidad'=>$query_row['UnidadCodigo']
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
	
	function ObtenerProductosEspecificos()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "SELECT DISTINCT I.item, I.descripcioncompleta, I.descripcionlocal, I.color, C.descripcioncorta AS ColorDesc, I.tallacodigo, T.descripcionlocal AS TallaDesc
						FROM 
							wh_itemmast I,
							wh_talla T,
							colormast C
						WHERE
							I.color = C.color AND
							I.tallacodigo = T.talla AND
							I.itempreciocodigo = '$_POST[Itempreciocodigo]' ";
								
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
					$descripcion = $query_row['descripcioncompleta'];
					if($descripcion == null OR $descripcion == "")
						$descripcion = $query_row['descripcionlocal'];
					$temp_array[] = array
									(
										  'Item'=>$query_row['item'],
										  'Descripcioncompleta'=>utf8_encode($descripcion),
										  'Color'=>$query_row['color'],
										  'ColorDesc'=>$query_row['ColorDesc'],
										  'Talla'=>$query_row['tallacodigo'],
										  'TallaDesc'=>$query_row['TallaDesc']
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
				$query = "  SELECT DISTINCT I.itempreciocodigo, PG.descripcionlocal, F.descripcionlocal AS FamiliaDesc, I.caracteristicavalor04, I.linea, I.familia,  PG.marcacodigo, P.monto, P.moneda
							FROM
							  combinacion C,
							  wh_itemmast I,
							  wh_itemmast PG,
							  co_precio P,
							  wh_clasefamilia F
							WHERE C.Item2 = I.itempreciocodigo
							AND PG.item = I.itempreciocodigo							
							AND P.tiporegistro = 'P'
							AND P.cliente = '$$'
							AND P.periodovalidez = '$$'
							AND PG.item = P.itemcodigo
							AND I.linea = F.linea
							AND F.familia = I.familia
							AND C.Item1 =  '$_POST[Itempreciocodigo]'
							UNION 
							SELECT DISTINCT I.itempreciocodigo, PG.descripcionlocal, F.descripcionlocal AS FamiliaDesc, I.caracteristicavalor04,  I.linea, I.familia,  PG.marcacodigo, P.monto, P.moneda
							FROM
							  combinacion C,
							  wh_itemmast I,
							  wh_itemmast PG,
							  co_precio P,
							  wh_clasefamilia F
							WHERE C.Item1 = I.itempreciocodigo
							AND PG.item = I.itempreciocodigo
							AND P.tiporegistro = 'P'
							AND P.cliente = '$$'
							AND P.periodovalidez = '$$'
							AND PG.item = P.itemcodigo
							AND I.linea = F.linea
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
										'Precio'=>$query_row['monto'],
										'Moneda'=>$query_row['moneda'],
										'Marca'=>$query_row['marcacodigo']
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
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
							E.almacendefault = A.almacencodigo AND
							I.item = '$_POST[Item]' AND
							E.establecimientocodigo <> '$_POST[Establecimientocodigo]' AND
							E.tipotienda <> '' AND
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
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
							E.almacendefault = A.almacencodigo AND
							I.itempreciocodigo = '$_POST[Item]' AND
							E.establecimientocodigo = '$_POST[Establecimientocodigo]' AND
							E.TipoTienda <> '' AND
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

	function ObtenerStockClientas()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT I.tallacodigo, I.color, (A.stockactual - A.stockcomprometido)as stockdisponible
						FROM
							wh_itemmast I,
							wh_itemalmacenlote A,
             				wh_almacentext T
						WHERE
							I.item = A.item AND
							T.almacencodigo = A.almacencodigo AND
							I.itempreciocodigo = '$_POST[Item]'";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("StockLocal" => array());
				mysql_close($database_conn);
				$this->sendResponse("Error en el query.");	
			} 
			else 
			{
				$result = array();
				while ($query_row = mysql_fetch_array($query_resource)) 
				{
					$result[] = array
									(
										'Tallacodigo'=>$query_row['tallacodigo'],
										'Colorcodigo'=>$query_row['color'],
										'Stockdisponible'=>$query_row['stockdisponible']
									);
				}
				
				mysql_close($database_conn);
				$this->sendResponse(200, json_encode($result));
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{			
			$query = "  SELECT I.tallacodigo, I.color, (A.stockactual - A.stockcomprometido)as stockdisponible 
						FROM 
							wh_itemmast I,
							wh_itemalmacenlote A,
							co_fiscalestablecimiento E 
						WHERE 
							I.Item = A.Item AND 
							E.almacendefault = A.AlmacenCodigo AND 
							I.item = '$_POST[ItemEspecifico]' AND 
							E.EstablecimientoCodigo = '$_POST[Establecimientocodigo]' AND 
							E.TipoTienda <> '' AND 
							E.direccioncomercial IS NOT NULL ";
								
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
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

		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{				
			$query = "	SELECT DISTINCT PG.item, PG.linea AS CodigoLinea, PG.familia AS CodigoFamilia,PG.Caracteristicavalor04 AS Temporada,PG.descripcionlocal AS Producto, F.descripcionlocal AS Familia, C.Descripcion AS Descripcion, P.monto, P.moneda
						FROM
							wh_itemmast PG,
							wh_clasefamilia F,
							coleccion C,
							co_precio P
						WHERE
							PG.item = '$_POST[codigo_producto]'
						AND P.tiporegistro = 'P'
						AND P.cliente = '$$'
						AND P.periodovalidez = '$$'
						AND PG.item = P.itemcodigo
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
										  'Coleccion'=>utf8_encode($query_row['Descripcion']),
										  'Moneda'=>$query_row['moneda'],
										  'Precio'=>$query_row['monto'],
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
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

	function registrarReserva()
	{
		$correlativo = $this->getCorrelativo();
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$tipoFacturacion = $this->getTipoFacturacion();
		$tipoVenta = $this->getTipoVenta();
		$formaPago = $this->getFormaDePago();
		$monedaDocumento = $this->getMonedaDocumento();
		$unidadNegocio = $this->getUnidadNegocio();
		$tipoCambio = $this->getTipoCambio();

		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
		
		//$centroCosto = $this->getCentroCosto($_POST[EstablecimientoCodigo]);
			if($correlativo != null && $correlativo > 0)
			{	
				$query = "  INSERT INTO co_documento (
                                CompaniaSocio,
                                NumeroDocumento,
                                TipoDocumento,
                                Estado,
                                ClienteNumero,
                                ClienteRUC,
                                ClienteNombre,
                                TipoVenta,
                                EstablecimientoCodigo,
                                Vendedor,
                                UltimoUsuario,
                                FormadePago,
                                ConceptoFacturacion,
                                FechaDocumento,
                                CentroCosto,
                                ClienteDireccion,
                                FormaFacturacion,
                                TipoFacturacion,
                                ClienteCobrarA,
                                FechaVencimiento,
                                MonedaDocumento,
                                PreparadoPor,
                                FechaPreparacion,
                                ImpresionPendienteFlag,
                                DocumentoMoraFlag,
                                ContabilizacionPendienteFlag,
                                UltimaFechaModif,
                                AlmacenCodigo,
                                VoucherPeriodo,
                                UnidadNegocio,
                                UnidadReplicacion,
                                MontoAfecto,
                                MontoNoAfecto,
                                MontoImpuestoVentas,
                                MontoImpuestos,
                                MontoDescuentos,
                                MontoRedondeo,
                                MontoTotal,
                                MontoPagado,
                                TipodeCambio
                                )

                                VALUES (
                                        '01000000',
                                        '$correlativo',
                                        'PE',
                                        'AP',
                                        '$_POST[ClienteNumero]',
                                        '$_POST[ClienteRUC]',
                                        '$_POST[ClienteNombre]',
                                        '$tipoVenta',
                                        '$_POST[EstablecimientoCodigo]',
                                        '$_POST[CodigoVendedor]',
                                        '$_POST[UltimoUsuario]',
                                        '$formaPago',
                                        '$_POST[ConceptoFacturacion]',
                                        NOW(),
                                        '$_POST[CentroCosto]',
                                        '$_POST[ClienteDireccion]',
                                        'F',
                                        '$tipoFacturacion',
                                        '$_POST[ClienteNumero]',
                                        NOW(),
                                        '$monedaDocumento',
                                        '$_POST[CodigoVendedor]',
                                        NOW(),
                                        'S',
                                        'N',
                                        'S',
                                        NOW(),
                                        '$_POST[CodigoAlmacen]',
                                        CONCAT(YEAR(NOW()),Date_format(now(),'%m')),
                                        '$unidadNegocio',
                                        '$_POST[EstablecimientoCodigo]',
                                        '$_POST[MontoAfecto]',
                                        '0.0',
                                        '$_POST[Impuestos]',
                                        '0',
                                        '0',
                                        '0',
                                        '$_POST[Monto]',
                                        '0',
                                        '$tipoCambio'

                                        )";

				$query_resource = mysql_query($query);
				if ($query_resource == FALSE)
				{
					mysql_close($database_conn);
					$this->sendResponse(500,"Error en el query.");	
				}
				else 
				{
					$query_result = array("reserva" => $correlativo);
					mysql_close($database_conn);
					$this->sendResponse(200, json_encode($query_result));
				}
			}
			else
			{
				$mysql_close($database_conn);
				$this->sendResponse(500, "Error en el numero correlativo");
			}
		
		} 
		else 
		{
			$mysql_close($database_conn);
			$this->sendResponse(500, "No existe la base de datos.");
		}
	}
	
	function getUnidadNegocio()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT  MA_UnidadNegocio.UnidadNegocio  as texto1
							FROM MA_UnidadNegocio      
							WHERE MA_UnidadNegocio.UnidadNegocio = '01' 
							   and MA_UnidadNegocio.estado = 'A' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$unidadnegocio = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$unidadnegocio = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $unidadnegocio;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return 0;	
		}	
		
	}
	
	function getTipoFacturacion()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT TEXTO as texto1
							FROM ParametrosMast
							WHERE PARAMETROCLAVE = 'DOCTIPOFAC'
							AND COMPANIACODIGO = '999999'
							AND APLICACIONCODIGO = 'CO' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$tipofacturacion = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$tipofacturacion = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $tipofacturacion;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return 0;	
		}	
		
	}
	
	function getTipoVenta ()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT TEXTO as texto1
							FROM ParametrosMast
							WHERE PARAMETROCLAVE = 'DOCTIPOVTA'
							AND COMPANIACODIGO = '999999'
							AND APLICACIONCODIGO = 'CO'";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$tipoVenta = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$tipoVenta = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $tipoVenta;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return 0;	
		}	
		
	}
	
	function getFormaDePago()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT TEXTO as texto1
							FROM ParametrosMast
							WHERE PARAMETROCLAVE = 'DOCFORFAPE'
							AND COMPANIACODIGO = '999999'
							AND APLICACIONCODIGO = 'CO' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$formaPago = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$formaPago = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $formaPago;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return 0;	
		}	
		
	}
	
	function getMonedaDocumento()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT TEXTO as texto1
							FROM ParametrosMast
							WHERE PARAMETROCLAVE = 'CURRENCY'
							AND COMPANIACODIGO = '999999'
							AND APLICACIONCODIGO = 'CO' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$monedaDocumento = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$monedaDocumento = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $monedaDocumento;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return 0;	
		}	
		
	}
	
	function getCentrocosto($centroCostoLlega)
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT CentroCosto as texto1
							FROM co_fiscalestablecimiento
							WHERE EstablecimientoCodigo = '$centroCostoLlega' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$centro_Costo = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$centro_Costo = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $centro_Costo;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return 0;	
		}	
		
	}
	
	function getTipoCambio()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = " SELECT FactorCompra as texto1
							from TipoCambioMast 
							where FechaCambio = CONCAT(CURDATE(),' 00:00:00') ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$tipocambio = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$tipocambio = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $tipocambio;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return 0;	
		}	
		
	}
	
	
	function registrarReservaItem()
	{
		$codigoEstablecimiento1 = $this->getCodigoEstablecimiento($_POST['codigoEstablecimiento']);
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{	
			$query = "  INSERT INTO co_documentodetalle (
													TipoDocumento,
													NumeroDocumento,
													Linea,
													ItemCodigo,
													CantidadPedida,
													PrecioUnitarioOriginal,
													PrecioUnitario,
													PrecioUnitarioFinal,
													Monto,
													MontoFinal,
													DocumentoRelacLinea,
													Estado,
													CentroCosto,
													IGVExoneradoFlag,
													CompaniaSocio,
													AlmacenCodigo,
													TipoDetalle,
													Condicion,
													Descripcion,
													UnidadCodigo,
													PorcentajeDescuento01,
													PorcentajeDescuento02,
													PorcentajeDescuento03,
													PrecioUnitarioDoble
													
													)													
													VALUES (
														'PE',
														'$_POST[NumeroDocumento]',
														'$_POST[Linea]',
														'$_POST[ItemCodigo]',
														'$_POST[CantidadPedida]',
														'$_POST[PrecioUnitarioOriginal]',
														'$_POST[PrecioUnitario]',
														'$_POST[PrecioUnitarioFinal]',
														'$_POST[Monto]',
														'$_POST[MontoFinal]',
														'$_POST[CodigoVendedor]',
														'PR',
														'$_POST[CentroCosto]',
														'N',
														'01000000',
														'$codigoEstablecimiento1',
														'I',
														'0',
														'$_POST[Descripcion]',
														'$_POST[Unidad]',
														'$_POST[Descuento]',
														'0',
														'$_POST[Descuento]',
														'$_POST[PrecioUnitarioFinal]'
														
														)";
								
			$query_resource = mysql_query($query);
				if ($query_resource == FALSE) 
				{
					mysql_close($database_conn);
					$this->sendResponse(500,"Error en el query.");	
				}
				else 
				{
					$query = "UPDATE CorrelativosMast SET flag = 1 WHERE serie = 'COPE'";
					mysql_query($query);

					$query_result = array("reserva" => '1');
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

	function registrarReservaItemClientas()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{	
			$query = "  INSERT INTO co_documentodetalle (
													TipoDocumento,
													NumeroDocumento,
													Linea,
													ItemCodigo,
													CantidadPedida,
													PrecioUnitarioOriginal,
													PrecioUnitario,
													PrecioUnitarioFinal,
													Monto,
													MontoFinal,
													DocumentoRelacLinea,
													Estado,
													CentroCosto,
													IGVExoneradoFlag,
													CompaniaSocio,
													AlmacenCodigo												
													)													
													VALUES (
														'PE',
														'$_POST[NumeroDocumento]',
														'$_POST[Linea]',
														'$_POST[ItemCodigo]',
														'$_POST[CantidadPedida]',
														'$_POST[PrecioUnitarioOriginal]',
														'$_POST[PrecioUnitario]',
														'$_POST[PrecioUnitarioFinal]',
														'$_POST[Monto]',
														'$_POST[MontoFinal]',
														'$_POST[CodigoVendedor]',
														'PR',
														'$_POST[CentroCosto]',
														'N',
														'01000000',
														'$_POST[codigoEstablecimiento]')";
								
			$query_resource = mysql_query($query);
				if ($query_resource == FALSE) 
				{
					mysql_close($database_conn);
					$this->sendResponse(500,"Error en el query.");	
				}
				else 
				{

					$query = "UPDATE CorrelativosMast SET flag = 1 WHERE serie = 'COPE'";
					mysql_query($query);
					$query_result = array("reserva" => '1');
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

	function getCorrelativo()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT (correlativonumero + 1) AS correlativonumero
						FROM CorrelativosMast
						WHERE serie = 'COPE' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$correlativo = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$correlativo = $query_row['correlativonumero'];
				}
				$size = strlen($correlativo);
				if($size < 10)
				{
					$dif = 10 - $size;
					for ($i=0; $i < $dif; $i++) { 
						$correlativo = "0".$correlativo;
					}
				}
				mysql_close($database_conn);
				return $correlativo;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return 0;	
		}	
		
	}

	function getVendedor()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{	
			$query = "  SELECT V.vendedor, P.nombrecompleto
						FROM
							co_vendedor V,
							personamast P
						WHERE
							V.vendedor = P.persona
						AND V.vendedor = '$_POST[vendedor]'
						AND V.estado = 'A' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{
				$query_result = array("Vendedor" => array());
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
										'Codigo'=> $query_row['vendedor'],
										'Nombre' => $query_row['nombrecompleto']
									);
				}
				
				$query_result = array("Vendedor" => $temp_array);
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
		
	function getCodigoEstablecimiento($val)
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "SELECT V.almacendefault as codigo
						FROM
							co_fiscalestablecimiento V					
						WHERE
							V.EstablecimientoCodigo = '$val'";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return null;	
			}
			else 
			{
				$codigoestablec = null;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$codigoestablec = $query_row['codigo'];
				}
								
				mysql_close($database_conn);
				return $codigoestablec;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return null;	
		}	
		
	}

	function eliminarReserva()
	{
		
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{	
			$query = "DELETE from co_documento where NumeroDocumento='$_POST[codigodocumento]'";
								
			$query_resource = mysql_query($query);
				if ($query_resource == FALSE) 
				{
					mysql_close($database_conn);
					$this->sendResponse(500,"Error en el query.");	
				}
				else 
				{
					$query_result = array("estadoEliminado" => '1');					
				}
			$query = "DELETE from co_documentodetalle where NumeroDocumento='$_POST[codigodocumento]'";
								
			$query_resource = mysql_query($query);
				if ($query_resource == FALSE) 
				{
					mysql_close($database_conn);
					$this->sendResponse(500,"Error en el query.");
				}
				else 
				{
					$query_result = array("estadoEliminado" => '1');
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
	
        function obtenerArticulosCantidad(){
            $host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "SELECT V.almacendefault as codigo
						FROM
							co_fiscalestablecimiento V					
						WHERE
							V.EstablecimientoCodigo = '$val'";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return null;	
			}
			else 
			{
				$codigoestablec = null;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$codigoestablec = $query_row['codigo'];
				}
								
				mysql_close($database_conn);
				return $codigoestablec;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return null;	
		}	
        }
        
        function obtenerArticulosTalla()
        {
            $host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexi�n con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "SELECT V.almacendefault as codigo
						FROM
							co_fiscalestablecimiento V					
						WHERE
							V.EstablecimientoCodigo = '$val'";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return null;	
			}
			else 
			{
				$codigoestablec = null;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$codigoestablec = $query_row['codigo'];
				}
								
				mysql_close($database_conn);
				return $codigoestablec;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return null;	
		}	
        }
}

$vendedora = new vendedoras();

if( isset($_POST['metodo']))
{
	$nombreMetodo = $_POST['metodo'];
 	if( strcmp($nombreMetodo, "OBTENERESTABLECIMIENTOSPORMARCA") == 0 ){
 		$vendedora-> ObtenerEstablecimientosPorMarca();
 	}
 	if( strcmp($nombreMetodo, "OBTENERGRUPOSLINEAS") == 0 ){
 		$vendedora-> ObtenerGruposLineas();
 	}
 	if( strcmp($nombreMetodo, "OBTENERFAMILIAPORGRUPOLINEA") == 0 ){
 		$vendedora-> ObtenerFamiliasPorGrupoLinea();
 	}
 	if( strcmp($nombreMetodo, "OBTENERLINEAS") == 0 ){
 		$vendedora-> ObtenerLineas();
 	}
 	if( strcmp($nombreMetodo, "OBTENERCLASESPORLINEA") == 0 ){
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
 	if( strcmp($nombreMetodo, "OBTENERSTOCKCLIENTAS") == 0 ){
 		$vendedora-> ObtenerStockClientas();
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
	}
	if( strcmp($nombreMetodo, "REGISTRARRESERVA") == 0 ){
 		$vendedora-> registrarReserva();
 	}
	if( strcmp($nombreMetodo, "REGISTRARRESERVAITEM") == 0 ){
 		$vendedora-> registrarReservaItem();
 	}
 	if( strcmp($nombreMetodo, "REGISTRARRESERVAITEMCLIENTAS") == 0 ){
 		$vendedora-> registrarReservaItemClientas();
 	}
 	if( strcmp($nombreMetodo, "GETCORRELATIVO") == 0 ){
 		$vendedora-> getCorrelativo();
 	}
 	if( strcmp($nombreMetodo, "BUSCARVENDEDORA") == 0 ){
 		$vendedora-> getVendedor();
 	}
	if( strcmp($nombreMetodo, "ELIMINARRESERVA") == 0 ){
 		$vendedora-> eliminarReserva();
 	}
        if( strcmp($nombreMetodo, "OBTENERARTICULOSCANTIDAD") == 0 ){
 		$vendedora-> obtenerArticulosCantidad();
 	}if( strcmp($nombreMetodo, "OBTENERARTICULOTALLA") == 0 ){
 		$vendedora-> obtenerArticulosTalla();
 	}
	
}
	
?>