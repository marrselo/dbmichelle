<?php

class Cliente
{	
    function getStatusCodeMessage($status) 
	{
		$codes = Array(100 => 'Continue', 101 => 'Switching Protocols', 200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 
		204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content', 300 => 'Multiple Choices', 301 => 'Moved Permanently', 
		302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 306 => '(Unused)', 307 => 'Temporary Redirect', 400 => 'Bad Request', 
		401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 
		407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 
		413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 
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

	function VerificaAcceso()
	{

		$hostName = "192.168.1.193";
		$databaseName = "mbinterface";
		$hostUser = "migra";
		$hostPassword = "migramb";

		$databaseCon = mysql_connect($hostName, $hostUser, $hostPassword) or die("No se pudo establecer la conexion a la base de datos");
		$existeDatabase = mysql_select_db($databaseName, $databaseCon);

		if ($existeDatabase) 
			return 1;
		 else 
			return 0;
	}
 
	function getCorrelativo()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT (correlativonumero + 1) AS correlativonumero
						FROM CorrelativosMast
						WHERE serie = 'COCL' ";
								
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
	
	function registrarCliente()
	{
		if ( isset($_POST['apellidopaterno']) && isset($_POST['origen']) && isset($_POST['apellidomaterno']) && isset($_POST['nombres']) && isset($_POST['tipodocumento']) &&
			 isset($_POST['documento']) && isset($_POST['ruc']) && isset($_POST['tipopersona']) && isset($_POST['fechanacimiento']) && isset($_POST['direccion']) &&
			 isset($_POST['telefono']) && isset($_POST['telefonoemergencia']) && isset($_POST['correoelectronico']) && isset($_POST['nombreCompleto']) && isset($_POST['UltimoUsuario'])
			)
		{
			$correlativo = $this->getCorrelativo();
			if ($this -> VerificaAcceso() == 1) 
			{				
				if ($correlativo > 0)
				{
					mysql_query("BEGIN");								
					$query = "INSERT INTO personamast (
                                                Persona,
                                                Origen,
                                                ApellidoPaterno,
                                                ApellidoMaterno,
                                                Nombres,
                                                NombreCompleto,
                                                Busqueda,
                                                Sexo,
                                                TipoDocumento,
                                                Documento,
                                                DocumentoIdentidad,
                                                DocumentoFiscal,
                                                EsCliente,
                                                EsProveedor,
                                                EsEmpleado,
                                                EsOtro,
                                                TipoPersona,
                                                FechaNacimiento,
                                                Direccion,
                                                Telefono,
                                                TelefonoEmergencia,
                                                CorreoElectronico,
                                                Estado,
                                                IngresoFechaRegistro,
                                                IngresoAplicacionCodigo,
                                                UltimoUsuario,
                                                IngresoUsuario,
                                                UltimaFechaModif

													   )
											VALUES (
														'$correlativo',
														'$_POST[origen]',
														UCASE('$_POST[apellidopaterno]'),
														UCASE('$_POST[apellidomaterno]'),
														UCASE('$_POST[nombres]'),
														UCASE('$_POST[nombreCompleto]'),
														UCASE('$_POST[nombreCompleto]'),
														'$_POST[sexo]',
														'$_POST[tipodocumento]',
														'$_POST[documento]',
														'$_POST[documentoIdentidad]',
														'$_POST[ruc]',
														'S',
														'N',
														'N',
														'N',
														UCASE('$_POST[tipopersona]'),
														'$_POST[fechanacimiento]',
														UCASE('$_POST[direccion]'),
														'$_POST[telefono]',
														'$_POST[telefonoemergencia]',
														'$_POST[correoelectronico]',
														'A',
														NOW(),
														'CO',
														'TABLETA',
														'$_POST[UltimoUsuario]',
														NOW()
														
													)";
	                $sql = mysql_query($query);
					
					//$idCliente = mysql_insert_id();
	                if($sql == TRUE) {
							$registro = $this -> registrarClienteMast($correlativo);
							if($registro) {
								mysql_query("COMMIT");
								$query = "UPDATE CorrelativosMast SET flag = 1 WHERE serie = 'COCL'";
								mysql_query($query);
								$response = array('idCliente' => $correlativo);
								$val = $this -> registrarClienteUpd($correlativo, $_POST['UltimoUsuario']);
							} else {
								mysql_query("ROLLBACK");
								$response = array('idCliente' => 0);
							}
							mysql_close($databaseConn);
							$this->sendResponse(200,json_encode($response));
					} else {
	                                
						mysql_close($databaseConn);
						$this->sendResponse(404, "Error en el query");
					}
				} else {
					$this -> sendResponse(500, 'Error en el codigo correlativo');
				}
			}
			else
			{
				$this -> sendResponse(500, 'No se pudo establecer la conexion con la base de datos');
			}
		}
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	function registrarClienteRazonSocial()
	{
		if ( isset($_POST['apellidopaterno']) && isset($_POST['origen']) && isset($_POST['apellidomaterno']) && isset($_POST['nombres']) && isset($_POST['tipodocumento']) &&
			 isset($_POST['documento']) && isset($_POST['ruc']) && isset($_POST['tipopersona']) && isset($_POST['fechanacimiento']) && isset($_POST['direccion']) &&
			 isset($_POST['telefono']) && isset($_POST['telefonoemergencia']) && isset($_POST['correoelectronico']) && isset($_POST['nombreCompleto']) && isset($_POST['UltimoUsuario'])
			)
		{
			$correlativo = $this->getCorrelativo();
			if ($this -> VerificaAcceso() == 1) 
			{
				if ($correlativo > 0)
				{			
					mysql_query("BEGIN");								
					$query = "INSERT INTO personamast (
														Persona,
														Origen,
														ApellidoPaterno,
														ApellidoMaterno,
														Nombres,
														NombreCompleto,
														Busqueda,
														
														TipoDocumento,
														
														DocumentoIdentidad,
														DocumentoFiscal,
														EsCliente,
														EsProveedor,
														EsEmpleado,
														EsOtro,
														TipoPersona,
														FechaNacimiento,
														Direccion,
														Telefono,
														TelefonoEmergencia,
														CorreoElectronico,
														Estado,
														IngresoFechaRegistro,
														IngresoAplicacionCodigo,
														UltimoUsuario,
														IngresoUsuario,
														UltimaFechaModif

													   )
											VALUES (
														'$correlativo',
														'$_POST[origen]',
														UCASE('$_POST[apellidopaterno]'),
														UCASE('$_POST[apellidomaterno]'),
														UCASE('$_POST[nombres]'),
														UCASE('$_POST[nombreCompleto]'),
														UCASE('$_POST[nombreCompleto]'),
														
														'$_POST[tipodocumento]',
														
														'$_POST[documento]',
														'$_POST[ruc]',
														'S',
														'N',
														'N',
														'N',
														UCASE('$_POST[tipopersona]'),
														'$_POST[fechanacimiento]',
														UCASE('$_POST[direccion]'),
														'$_POST[telefono]',
														'$_POST[telefonoemergencia]',
														'$_POST[correoelectronico]',
														'A',
														NOW(),
														'CO',
														'$_POST[UltimoUsuario]',
														'$_POST[UltimoUsuario]',
														NOW()
														
													)";
	                $sql = mysql_query($query);
					
					//$idCliente = mysql_insert_id();
	                if($sql == TRUE){
							$registro = $this -> registrarClienteMast($correlativo);
							if($registro) {
								mysql_query("COMMIT");
								$query = "UPDATE CorrelativosMast SET flag = 1 WHERE serie = 'COCL'";
								mysql_query($query);
								$response = array('idCliente' => $correlativo);
								$val = $this -> registrarClienteUpd($correlativo, $_POST['UltimoUsuario']);
							} else {
								mysql_query("ROLLBACK");
								$response = array('idCliente' => 0);
							}
							mysql_close($databaseConn);
							$this->sendResponse(200,json_encode($response));
					} else {
	                                
						mysql_close($databaseConn);
						$this->sendResponse(404, "Error en el query");
					}
				} else {
					$this -> sendResponse(500, 'Error en el codigo correlativo');
				}
			}
			else
			{
				$this -> sendResponse(500, 'No se pudo establecer la conexion con la base de datos');
			}
		}
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	function registrarClienteMast($idCliente){
		$formaPago = $this->getFormaDePago();
		$tipoDocumento = $this->getTipoDocumento();
		$formaFacturacion = $this->getFormaFacturacion();
		$tipoFacturacion = $this->getTipoFacturacion();
		$tipoVenta = $this->getTipoVenta();
		$conceptoFacturacion = $this->getConceptoFacturacion();
		$vendedor = $this->getVendedor();
		
		$query = "INSERT INTO clientemast (
													Cliente,
													Clasificacion,
													TipoActividad,
													FormadePago,
													TipoDocumento,
													FormaFacturacion,
													TipoFacturacion,
													TipoVenta,
													ConceptoFacturacion,
													Vendedor,
													Nacionalidad
													
												   )
										VALUES (
													'$idCliente',
													'B',
													'I',
													'$formaPago',
													'$tipoDocumento',
													'$formaFacturacion',
													'$tipoFacturacion',
													'$tipoVenta',
													'$conceptoFacturacion',
													$vendedor,
													'N'
													
												)";
		$sql = mysql_query($query);
		if($sql) {
			return TRUE;
		}
		return FALSE;
	}
	
	function getFormaDePago()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT texto as texto1
							FROM ParametrosMast
							WHERE parametroclave = 'CLIFPDEF'
							AND estado = 'A' ";
								
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
	
	function getTipoDocumento()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT Texto as texto1
							FROM ParametrosMast WHERE ( ParametrosMast.CompaniaCodigo ='999999' ) 
							AND ( ParametrosMast.AplicacionCodigo ='CO' ) 
							AND ( ParametrosMast.ParametroClave ='DOCTIPODOC' ) 
							and estado = 'A' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$tipoDocumento = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$tipoDocumento = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $tipoDocumento;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return 0;	
		}	
		
	}
	
	function getFormaFacturacion()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT Texto as texto1
							FROM ParametrosMast 
							WHERE ( ParametrosMast.CompaniaCodigo ='999999' ) 
							AND ( ParametrosMast.AplicacionCodigo ='CO' ) 
							AND ( ParametrosMast.ParametroClave ='DOCFORFACT' ) 
							and estado = 'A' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$formaFacturacion = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$formaFacturacion = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $formaFacturacion;
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT Texto as texto1
							FROM ParametrosMast 
							WHERE ( ParametrosMast.CompaniaCodigo ='999999' ) 
							AND ( ParametrosMast.AplicacionCodigo ='CO' ) 
							AND ( ParametrosMast.ParametroClave ='DOCTIPOFAC' ) 
							and estado = 'A' ";
								
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT Texto as texto1
							FROM ParametrosMast 
							WHERE ( ParametrosMast.CompaniaCodigo ='999999' ) 
							AND ( ParametrosMast.AplicacionCodigo ='CO' ) 
							AND ( ParametrosMast.ParametroClave ='DOCTIPOVTA' ) 
							and estado = 'A' ";
								
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
	
	function getConceptoFacturacion()
	{
		$host_name = '192.168.1.193';
		$host_password = 'migramb';
		$host_user = 'migra';
		$database_name = 'mbinterface';
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT Texto as texto1
							FROM ParametrosMast 
							WHERE ( ParametrosMast.CompaniaCodigo ='999999' ) 
							AND ( ParametrosMast.AplicacionCodigo ='CO' ) 
							AND ( ParametrosMast.ParametroClave ='DOCCONCEPT' )
							and estado = 'A' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$conceptoFacturacion = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$conceptoFacturacion = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $conceptoFacturacion;
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
		
		$database_conn = mysql_connect($host_name, $host_user, $host_password) or die ('No se pudo establecer la conexión con la base de datos');
		$exists_database = mysql_select_db($database_name);
		
		if ($exists_database) 
		{
			$query = "  SELECT ParametrosMast.Numero as texto1
							FROM ParametrosMast 
							WHERE ( ParametrosMast.CompaniaCodigo ='999999' ) 
							AND ( ParametrosMast.AplicacionCodigo ='CO' ) 
							AND ( ParametrosMast.ParametroClave ='DOCVENDEDO' ) 
							and estado = 'A' ";
								
			$query_resource = mysql_query($query);

			if ($query_resource == FALSE) 
			{			
				mysql_close($database_conn);
				return 0;	
			}
			else 
			{
				$vendedor = 0;
				while ($query_row = mysql_fetch_array($query_resource))
				{
					$vendedor = $query_row['texto1'];
				}
								
				//mysql_close($database_conn);
				return $vendedor;
			}			
		
		}
		else 
		{
			$mysql_close($database_conn);
			return 0;	
		}	
		
	}
	
	function registrarClienteUpd($Cliente, $ultimoUsuario ){
		if ($this -> VerificaAcceso() == 1)
			{
				$query = "INSERT INTO cliente_upd (	
													Cliente,
													UltimoUsuario,
													Flag,
													UltimaFechaModif
												   )
										VALUES (
													
													'$Cliente',
													'$ultimoUsuario',
													'0',
													NOW()
												)";
				
                $sql = mysql_query($query);
				                                
				if ( $sql)
				{
					return 1;
				}
				return 0;
				
			}
		return 0;
		
	}
	
	function registrarClientePersona()
	{
		if ( isset($_POST['Cliente']))
		{
			
			if ($this -> VerificaAcceso() == 1)
			{
				$query = "INSERT INTO clientemast (
													Cliente													
												   )
										VALUES (
													'$_POST[Cliente]'
													
												)";
				
                mysql_query($query);
				
				$idCliente = mysql_insert_id();
                                
				if (intval($idCliente) > 0)
				{
					$response = array('idCliente' => $idCliente);
				}
				if(intval($idCliente)== 0)
				{
					$response = array('idCliente' => 0);
				}
                                
                mysql_close($databaseConn);
				$this->sendResponse(200,json_encode($response));
			}
			else
			{
				$this -> sendResponse(500, 'No se pudo establecer la conexion con la base de datos');
			}
		}
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	public function getClientePorDNI()
	{
		if(isset($_POST['documento']))
		{
			
			if ($this -> VerificaAcceso() == 1)
			{
			$query = "SELECT P.Persona,P.ApellidoPaterno,P.ApellidoMaterno,P.Nombres,
				P.NombreCompleto,P.Sexo,DATE_FORMAT(P.FechaNacimiento,'%Y/%m/%d') AS FechaNacimiento,
				P.TipoDocumento,P.DocumentoIdentidad,P.DocumentoFiscal,P.TipoPersona,
				P.Direccion,P.Telefono,
				P.TelefonoEmergencia,P.CorreoElectronico
				,C.TipoCliente
				,C.LicenciaNumero,C.contratopremio
				FROM personamast P 
				INNER JOIN clientemast C ON C.Cliente = P.Persona
				WHERE DocumentoIdentidad = '$_POST[documento]' 
				AND estado = 'A'				
				AND P.TipoPersona = 'N'
								";
				$queryResult = mysql_query($query);
				$result = array();
				if(mysql_num_rows($queryResult) > 0 )
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
                                        $result[] = array(
                                        "idCliente" => $queryRow['Persona'],
                                        "apellidoPaterno" => utf8_encode($queryRow['ApellidoPaterno']),
                                        "apellidoMaterno" => utf8_encode($queryRow['ApellidoMaterno']),
                                        "nombres" => utf8_encode($queryRow['Nombres']),
                                        "nombreCompleto" => utf8_encode($queryRow['NombreCompleto']),
                                        "sexo" => $queryRow['Sexo'],
                                        "fechaNacimiento" => $queryRow['FechaNacimiento'],
                                        "tipoDocumento" => $queryRow['TipoDocumento'],
                                        "documento" => $queryRow['DocumentoIdentidad'],
                                        "documentoFiscal" => $queryRow['DocumentoFiscal'],
                                        "tipoPersona" => $queryRow['TipoPersona'],
                                        "direccion" => utf8_encode($queryRow['Direccion']),
                                        "telefono" => $queryRow['Telefono'],
                                        "telefonoEmergencia" => $queryRow['TelefonoEmergencia'],
                                        "correoElectronico" => $queryRow['CorreoElectronico'],
                                        "TipoCliente" => $queryRow['TipoCliente'],
                                        "LicenciaNumero"=>$queryRow['LicenciaNumero'],
                                        "contratopremio"=>$queryRow['contratopremio']  );
					}
					mysql_close($databaseConn);
					$this -> sendResponse(200, json_encode($result));
				} else {
					mysql_close($databaseConn);
					$this -> sendResponse(200, "DNI o RUC no esta asociado a ningun cliente ." );
				}
			}
			else
			{
				$this -> sendResponse(500, 'No se pudo establecer la conexion con la base de datos');
			}
		}
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	public function getClientePorRUC()
	{
		if(isset($_POST['documento']))
		{
			
			if ($this -> VerificaAcceso() == 1)
			{
				$query = "SELECT P.Persona,P.ApellidoPaterno,P.ApellidoMaterno,P.Nombres,P.NombreCompleto,P.Sexo,DATE_FORMAT(P.FechaNacimiento,'%Y/%m/%d') AS FechaNacimiento,
									P.TipoDocumento,P.DocumentoIdentidad,P.DocumentoFiscal,P.TipoPersona,P.Direccion,P.Telefono,
									P.TelefonoEmergencia,P.CorreoElectronico,C.TipoCliente
								FROM personamast P, clientemast C
								
								WHERE DocumentoFiscal = '$_POST[documento]' 
										AND estado = 'A'
										AND C.Cliente = P.Persona
										AND P.TipoPersona = 'J'";
				$queryResult = mysql_query($query);
				$result = array();
				if(mysql_affected_rows() > 0 )
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result[] = array(
											"idCliente" => $queryRow['Persona'],
											"apellidoPaterno" => utf8_encode($queryRow['ApellidoPaterno']),
											"apellidoMaterno" => utf8_encode($queryRow['ApellidoMaterno']),
											"nombres" =>utf8_encode($queryRow['Nombres']),
											"nombreCompleto" => utf8_encode($queryRow['NombreCompleto']),
											"sexo" => $queryRow['Sexo'],
											"fechaNacimiento" => $queryRow['FechaNacimiento'],
											"tipoDocumento" => $queryRow['TipoDocumento'],
											"documento" => $queryRow['DocumentoIdentidad'],
											"documentoFiscal" => $queryRow['DocumentoFiscal'],
											"tipoPersona" => $queryRow['TipoPersona'],
											"direccion" => utf8_encode($queryRow['Direccion']),
											"telefono" => $queryRow['Telefono'],
											"telefonoEmergencia" => $queryRow['TelefonoEmergencia'],
											"correoElectronico" => $queryRow['CorreoElectronico'],
											"TipoCliente" => $queryRow['TipoCliente']
										  );
					}
					mysql_close($databaseConn);
					$this -> sendResponse(200, json_encode($result));
				}				
				
				mysql_close($databaseConn);
				$this -> sendResponse(200, json_encode($result));
			}
			else
			{
				$this -> sendResponse(500, 'No se pudo establecer la conexion con la base de datos');
			}
		}
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	public function existClienteDNI()
	{
		if(isset($_POST['documento']))
		{
			
			if ($this -> VerificaAcceso() == 1)
			{
				$query = "SELECT estado FROM personamast WHERE DocumentoIdentidad = '$_POST[documento]'";
				$queryResult = mysql_query($query);
				$result = array(); 
				if(mysql_num_rows($queryResult) > 0){
					$result = mysql_fetch_array($queryResult,MYSQL_ASSOC);
				}
				else
				{
					$result = array("estado" => "false");
				}
				mysql_close($databaseConn);
				$this -> sendResponse(200, json_encode($result));
			}
			else
			{
				$this -> sendResponse(500, 'No se pudo establecer la conexion con la base de datos');
			}
		}
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	public function existClienteRUC()
	{
		if(isset($_POST['documento']))
		{
			
			if ($this -> VerificaAcceso() == 1)
			{
				$query = "SELECT estado FROM personamast WHERE DocumentoFiscal = '$_POST[documento]'";
				$queryResult = mysql_query($query);
				$result = array(); 
				if(mysql_num_rows($queryResult) > 0){
					$result = mysql_fetch_array($queryResult,MYSQL_ASSOC);
				}
				else
				{
					$result = array("estado" => "false");
				}
				mysql_close($databaseConn);
				$this -> sendResponse(200, json_encode($result));
			}
			else
			{
				$this -> sendResponse(500, 'No se pudo establecer la conexion con la base de datos');
			}
		}
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	function actualizarCliente()
	{
		if ( isset($_POST['clienteid']) && isset($_POST['apellidopaterno']) && isset($_POST['apellidomaterno']) && isset($_POST['nombres']) && isset($_POST['tipodocumento']) &&
			 isset($_POST['documento']) && isset($_POST['ruc']) && isset($_POST['tipopersona']) && isset($_POST['fechanacimiento']) && isset($_POST['direccion']) &&
			 isset($_POST['telefono']) && isset($_POST['telefonoemergencia']) && isset($_POST['correoelectronico']) && isset($_POST['nombreCompleto']) && isset($_POST['UltimoUsuario'])
			)
		{	
			
			if ($this -> VerificaAcceso() == 1)
			{
				mysql_query('BEGIN');
				$query = "UPDATE personamast SET
													ApellidoPaterno ='$_POST[apellidopaterno]',
													ApellidoMaterno = '$_POST[apellidomaterno]',
													Nombres = '$_POST[nombres]',
													NombreCompleto = '$_POST[nombreCompleto]',
													Busqueda = '$_POST[nombreCompleto]',
													Sexo = '$_POST[sexo]',
													TipoDocumento = '$_POST[tipodocumento]',
													Documento = '$_POST[documento]',
													DocumentoIdentidad = '$_POST[documento]',
													DocumentoFiscal = '$_POST[ruc]',
													TipoPersona = '$_POST[tipopersona]',
													FechaNacimiento = '$_POST[fechanacimiento]',
													Direccion = '$_POST[direccion]',
													Telefono = '$_POST[telefono]',
													TelefonoEmergencia = '$_POST[telefonoemergencia]',
													CorreoElectronico = '$_POST[correoelectronico]',
													UltimoUsuario = '$_POST[UltimoUsuario]',
													UltimaFechaModif = NOW()
													
													
											WHERE Persona = '$_POST[clienteid]' AND Estado = 'A' ";
				
                mysql_query($query);
				      
				if(mysql_affected_rows() > 0)	
				{
					$val = $this -> registrarClienteUpd($_POST['clienteid'], $_POST['UltimoUsuario']);
					if($val == 1) {					
						mysql_query('COMMIT');
						$response = array("actualizo" => "1");
					} else {
						mysql_query('ROLLBACK');
						$response = array("actualizo" => "0");
					}
                } else {
					if(mysql_affected_rows() == 0)
					{
						$response = array("actualizo" => "0");
					}
				}
                                
                mysql_close($databaseConn);
				$this->sendResponse(200,json_encode($response));
			}
			else
			{
				$this -> sendResponse(500, 'No se pudo establecer la conexion con la base de datos');
			}
		}
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	function ObtenerUltimaCompra()
	{	
		if ( isset($_POST['codigo_persona']))
		{
			
			if ($this -> VerificaAcceso() == 1)
			{
				$query = "  SELECT DISTINCT D.NumeroDocumento AS Documento, D.tipodocumento AS Tipo, 
											E.descripcionlocal AS Local, D.montototal AS Monto,
											D.fechadocumento AS Fecha, D.montoafecto AS Monto_Afecto, 
											D.montonoafecto AS Monto_NoAfecto, D.montoimpuestoventas AS Impuesto,
											D.puntoscanjeados AS Canjeados, D.puntosganados AS Ganados  
											FROM							
												co_documento D,
												co_fiscalestablecimiento E
												
											WHERE
												D.ClienteNumero = '$_POST[codigo_persona]'
													AND D.EstablecimientoCodigo = E.EstablecimientoCodigo
											ORDER BY
													D.FechaDocumento DESC
											limit 1						
							";
				$query_resource = mysql_query($query);

				if ($query_resource == FALSE) 
				{
					$query_result = array("ultimaCompra" => array());
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
											  'Documento'=>$query_row['Documento'],
											  'Tipo'=>$query_row['Tipo'],
											  'Local'=>$query_row['Local'],
											  'Monto'=>$query_row['Monto'],
											  'Fecha'=>$query_row['Fecha'],
											  'Monto_Afecto'=>$query_row['Monto_Afecto'],
											  'Monto_NoAfecto'=>$query_row['Monto_NoAfecto'],
											  'Impuesto'=>$query_row['Impuesto'],
											  'Canjeados'=>$query_row['Canjeados'],
											  'Ganados'=>$query_row['Ganados']);
					}
					
					$query_result = array("ultimaCompra" => $temp_array);
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
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	function ObtenerComprasPorFecha()
	{		
		if ( isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin']) && isset($_POST['codigo_persona']))
		{
					
			if ($this -> VerificaAcceso() == 1)
			{
				$query = "SELECT D.NumeroDocumento AS Documento, D.montototal AS Monto, DATE_FORMAT(D.fechadocumento,'%Y/%m/%d') AS Fecha
											FROM							
												co_documento D											
												
											WHERE
												D.ClienteNumero = '$_POST[codigo_persona]'
												AND DATE_FORMAT(D.FechaDocumento,'%Y/%m/%d') >= STR_TO_DATE('$_POST[fecha_inicio]','%Y/%m/%d') 
												AND DATE_FORMAT(D.FechaDocumento,'%Y/%m/%d') <= STR_TO_DATE('$_POST[fecha_fin]','%Y/%m/%d')
											ORDER BY
													D.FechaDocumento ASC";
				$query_resource = mysql_query($query);

				if ($query_resource == FALSE) 
				{
					$query_result = array("ultimaCompra" => array());
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
											  'Documento'=>$query_row['Documento'],											 
											  'Monto'=>$query_row['Monto'],
											  'Fecha'=>$query_row['Fecha']);
					}
					
					$query_result = array("ultimaCompra" => $temp_array);
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
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	function ObtenerCompra()
	{	
		if ( isset($_POST['codigo_persona']))
		{
			
			if ($this -> VerificaAcceso() == 1)
			{
				$query = "  SELECT DISTINCT D.NumeroDocumento AS Documento, D.tipodocumento AS Tipo, 
											E.descripcionlocal AS Local, D.montototal AS Monto,
											DATE_FORMAT(D.fechadocumento,'%Y/%m/%d') AS Fecha, D.montoafecto AS Monto_Afecto, 
											D.montonoafecto AS Monto_NoAfecto, D.montoimpuestoventas AS Impuesto,
											D.puntoscanjeados AS Canjeados, D.puntosganados AS Ganados  
											FROM
												co_documento D,
												co_fiscalestablecimiento E
												
											WHERE
												D.ClienteNumero = '$_POST[codigo_persona]'
													AND D.EstablecimientoCodigo = E.EstablecimientoCodigo
											ORDER BY
													D.FechaDocumento DESC
											limit 1						
							";
				$query_resource = mysql_query($query);

				if ($query_resource == FALSE) 
				{
					$query_result = array("ultimaCompra" => array());
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
											  'Documento'=>$query_row['Documento'],
											  'Tipo'=>$query_row['Tipo'],
											  'Local'=>$query_row['Local'],
											  'Monto'=>$query_row['Monto'],
											  'Fecha'=>$query_row['Fecha'],
											  'Monto_Afecto'=>$query_row['Monto_Afecto'],
											  'Monto_NoAfecto'=>$query_row['Monto_NoAfecto'],
											  'Impuesto'=>$query_row['Impuesto'],
											  'Canjeados'=>$query_row['Canjeados'],
											  'Ganados'=>$query_row['Ganados']);
					}
					
					$query_result = array("ultimaCompra" => $temp_array);
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
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	function ObtenerCompraDetalle()
	{
		if ( isset($_POST['codigo_documento']))
		{
			
			if ($this -> VerificaAcceso() == 1) 
			{
				$query = "  SELECT DISTINCT DD.descripcion AS DescripcionD, DD.cantidadentregada AS Cantidad, DD.preciounitariofinal AS PrecioU, DD.montofinal AS Monto							
							FROM	
								co_documentodetalle DD
							WHERE
								DD.NumeroDocumento = '$_POST[codigo_documento]'	
							";
				$query_resource = mysql_query($query);

				if ($query_resource == FALSE) 
				{
					$query_result = array("ultimaCompraDetalle" => array());
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
											  'DescripcionD'=>$query_row['DescripcionD'],
											  'Cantidad'=>$query_row['Cantidad'],
											  'PrecioU'=>$query_row['PrecioU'],
											  'Monto'=>$query_row['Monto']
										);
					}
					
					$query_result = array("ultimaCompraDetalle" => $temp_array);
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
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}

	function ListarPuntos()
	{
		if ( isset($_POST['ClienteNumero']))
		{
			
			if ($this -> VerificaAcceso() == 1) 
			{
				$query = "SELECT puntosganados, puntoscanjeados
						FROM co_documento
						WHERE clientenumero = '$_POST[ClienteNumero]'
						AND FechaVencimiento >= CURDATE()";
				$query_resource = mysql_query($query);

				if ($query_resource == FALSE) 
				{
					$query_result = array("coronitas" => array());
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
											'puntosganados'=>$query_row['puntosganados'],
											'puntoscanjeados'=>$query_row['puntoscanjeados']
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
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
	function ListarPuntosAcumulados()
	{
		if ( isset($_POST['Cliente']))
		{
			
			if ($this -> VerificaAcceso() == 1) 
			{
				$query = "SELECT p_canjear,p_obtenido
						FROM cliente_puntos
						WHERE cliente = '$_POST[Cliente]'";
				$query_resource = mysql_query($query);

				if ($query_resource == FALSE) 
				{
					$query_result = array("coronitas" => array());
					mysql_close($database_conn);
					$this->sendResponse("Error en el query.");	
				} 
				else 
				{
					$result = null;
					while ($query_row = mysql_fetch_array($query_resource)) 
					{
                                            $result = array
                                            (
                                                      'coronitas'=>$query_row['p_canjear'],
                                                      'coronitas_vencer'=>$query_row['p_obtenido']
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
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}

	function ObtenerComprasTop()
	{	
		if ( isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin']))
		{
					
			if ($this -> VerificaAcceso() == 1)
			{
				$query = "	SELECT ClienteNumero, ClienteNombre , SUM(montototal) AS Monto
							FROM co_documento
							WHERE
								DATE_FORMAT(FechaDocumento,'%Y/%m/%d') >= STR_TO_DATE('$_POST[fecha_inicio]','%Y/%m/%d') 
								AND DATE_FORMAT(FechaDocumento,'%Y/%m/%d') <= STR_TO_DATE('$_POST[fecha_fin]','%Y/%m/%d')
								AND TipoVenta = 'TDA'
							GROUP BY ClienteNumero
								ORDER BY Monto DESC
								LIMIT 10";
													
				$query_resource = mysql_query($query);

				if ($query_resource == FALSE) 
				{
					$query_result = array("ultimaCompra" => array());
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
											  'ClienteNumero'=>$query_row['ClienteNumero'],											 
											  'Monto'=>$query_row['Monto'],
											  'ClienteNombre'=>$query_row['ClienteNombre']);
					}
					
					$query_result = array("ultimaCompra" => $temp_array);
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
		else
		{
			$this -> sendResponse(406, 'Faltan los datos para utilizar este servicio');
		}
	}
	
}
	
$cliente = new Cliente();

if( isset($_POST['metodo']))
{
	$nombreMetodo = $_POST['metodo'];
 	if( strcmp($nombreMetodo, "REGISTRARCLIENTE") == 0 )
	{
 		$cliente-> RegistrarCliente();
 	}
	if( strcmp($nombreMetodo, "REGISTRARCLIENTERAZONSOCIAL") == 0 )
	{
 		$cliente-> registrarClienteRazonSocial();	
	}
	if( strcmp($nombreMetodo, "BUSCARCLIENTEPORDNI") == 0 )
	{
 		$cliente-> getClientePorDNI();
 	}
	if( strcmp($nombreMetodo, "BUSCARCLIENTEPORRUC") == 0 )
	{
 		$cliente-> getClientePorRUC();
 	}
	if( strcmp($nombreMetodo, "ACTUALIZARCLIENTE") == 0 )
	{
 		$cliente-> actualizarCliente();
 	}
	if( strcmp($nombreMetodo, "EXISTECLIENTEDNI") == 0 )
	{
 		$cliente-> existClienteDNI();
 	}
	if( strcmp($nombreMetodo, "EXISTECLIENTERUC") == 0 )
	{
 		$cliente-> existClienteRUC();
 	}
	if( strcmp($nombreMetodo, "OBTENERULTIMACOMPRA") == 0 )
	{
 		$cliente-> ObtenerUltimaCompra();
 	}	
	if( strcmp($nombreMetodo, "OBTENERCOMPRADETALLE") == 0 )
	{
 		$cliente-> ObtenerCompraDetalle();
 	}
	if( strcmp($nombreMetodo, "PUNTOSACUMULADOS") == 0 )
	{
 		$cliente-> ListarPuntosAcumulados();
 	}
 	if( strcmp($nombreMetodo, "OBTENERPUNTOS") == 0 )
	{
 		$cliente-> ListarPuntos();
 	}
	if( strcmp($nombreMetodo, "OBTENERCOMPRASPORFECHA") == 0 )
	{
 		$cliente-> ObtenerComprasPorFecha();
 	}
	if( strcmp($nombreMetodo, "OBTENERCOMPRA") == 0 )
	{
 		$cliente-> ObtenerCompra();
 	}
	if( strcmp($nombreMetodo, "OBTENERCOMPRASTOP") == 0 )
	{
 		$cliente-> ObtenerComprasTop();
 	}
	
	if( strcmp($nombreMetodo, "REGISTRARCLIENTEPERSONA") == 0 )
	{
 		$cliente-> registrarClientePersona();
 	}
	
}
	
?>