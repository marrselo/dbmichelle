<?php

class Precio
{	
	private $HOST_NAME = "192.168.1.193";
	private $DB_NAME = "mbinterface";
	private $DB_USER = "migra";
	private $DB_PASSWORD = "migramb";
	
	private $db = NULL;
		
    private function getStatusCodeMessage($status) 
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
	
	private function sendResponse($status = 200, $body = '', $content_type = 'application/json') 
	{
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this -> getStatusCodeMessage($status);
		header($status_header);
		header('Content-type: ' . $content_type);
		echo $body;
		exit;
	}
	
	public function __construct()
	{}	
	
	public function __destruct()
	{}
	
	private function dbConnect()
	{
		$this->db = mysql_connect($this->HOST_NAME, $this->DB_USER, $this->DB_PASSWORD) or die("No se pudo establecer la conexion a la base de datos");
		$existeDatabase = mysql_select_db($this->DB_NAME, $this->db);

		if ($existeDatabase) 
			return true;
		else 
			return false;
	}
	
	private function dbClose()
	{
		mysql_close($this->db);
	}
	
	public function getPrecio()
	{
		if(isset($_POST['codigogenerico']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT monto, moneda
                                        FROM co_precio P
                                        WHERE P.tiporegistro = 'P'
                                        AND P.cliente = '$$'
                                        AND P.periodovalidez = '$$'
                                        AND P.itemcodigo = '$_POST[codigogenerico]'";
				
				$queryResult = mysql_query($query);
				
				if(mysql_num_rows($queryResult) > 0)
				{
					$result = array();
					while($queryRow = mysql_fetch_array($queryResult, MYSQL_ASSOC))
					{
						$result[] = $queryRow;
					}					
					$this->dbClose();
					$this->sendResponse(200, json_encode($result));
				}
				$this->dbClose();
				$this->sendResponse(204, '');
			}
			$error = array('status' => "Failed", "msg" => "No se pudo establecer la conexion con la base de datos");
			$this->sendResponse(500, json_encode($error));
		}
		$error = array('status' => "Failed", "msg" => "Parametros invalidos");
		$this->sendResponse(400, json_encode($error));
	}
	
	public function getDescuento()
	{
		$descuentos = array();
		$descuentos[] = $this->DescuentoLineaFamiliaTemporada();
		$descuentos[] = $this->DescuentoTemporada();
		$descuentos[] = $this->DescuentoTipoCliente();
		$descuentos[] = $this->DescuentoLineaFamilia();
		$descuentos[] = $this->DescuentoItemCodigo();
		$descuentos[] = $this->DescuentoMarca();
		$descuentos[] = $this->DescuentoLinea();
		$descuentos[] = $this->DescuentoTemporadaMarca();
		$descuentos[] = $this->DescuentoLineaTemporadaMarca();
		$descuentos[] = $this->DescuentoLineaFamiliaTemporadaMarca();
		$descuentos[] = $this->DescuentoFormaPago();
		$descuentos[] = $this->DescuentoFormaPagoTemporada();
		$descuentos[] = $this->DescuentoFormaPagoLineaFamilia();
		$descuentos[] = $this->DescuentoConceptoFacturacion();
		$descuentos[] = $this->DescuentoLineaTemporada();
		$descuentos[] = $this->DescuentoConceptoFacturacionTemporada();
		$descuentos[] = $this->DescuentoConceptoFacturacionLineaTemporada();
		$descuentos[] = $this->DescuentoConceptoFacturacionLineaFamiliaTemporada();
		$descuentos[] = $this->DescuentoConceptoFacturacionLineaFamilia();
		$descuentos[] = $this->DescuentoConceptoFacturacionLinea();
		
		$mayorDescuento = max($descuentos);
		return $mayorDescuento."";
	}

	public function postDescuento(){
		$descuento = $this->getDescuento();
		$array = array('Descuento' => $descuento);
		$this->sendResponse(200, json_encode($array));
	}
	
	//-------------------------------------------------------------------------
	// CALCULO DE DESCUENTOS POR DESCUENTOS
	//-------------------------------------------------------------------------
	private function DescuentoLineaFamiliaTemporada()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['lineafamilia']) && isset($_POST['temporada']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
							AND D.periodovalidez <> '$$'
							AND LEFT(D.periodovalidez,10)<= CURDATE()
							AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
							AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
							AND D.lineafamilia = '$_POST[lineafamilia]'
							AND D.criteria = '$_POST[temporada]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow[descuento];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoTemporada()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['temporada']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND D.FormadePago='$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND criteria = '$_POST[temporada]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoTipoCliente()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['tipocliente']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.tipocliente = '$_POST[tipocliente]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoLineaFamilia()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['lineafamilia']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
							AND D.periodovalidez <> '$$'
							AND LEFT(D.periodovalidez,10)<= CURDATE()
							AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
							AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
							AND D.lineafamilia = '$_POST[lineafamilia]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoItemCodigo()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.itemcodigo = '$_POST[codigogenerico]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoMarca()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['marca']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.unidadnegocio = '$_POST[marca]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoLinea()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['linea']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.tipofacturacion = '$_POST[linea]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult, MYSQL_ASSOC))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoTemporadaMarca()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['temporada'])&& isset($_POST['marca']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.criteria = '$_POST[temporada]'
						  AND D.unidadnegocio = '$_POST[marca]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult, MYSQL_ASSOC))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoLineaTemporadaMarca()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['linea']) && isset($_POST['temporada'])&& isset($_POST['marca']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.tipofacturacion = '$_POST[linea]'
						  AND D.criteria = '$_POST[temporada]'
						  AND D.unidadnegocio = '$_POST[marca]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoLineaFamiliaTemporadaMarca()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['lineafamilia']) && isset($_POST['temporada'])&& isset($_POST['marca']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.lineafamilia = '$_POST[lineafamilia]'
						  AND D.criteria = '$_POST[temporada]'
						  AND D.unidadnegocio = '$_POST[marca]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoFormaPago()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['formapago']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.formadepago = '$_POST[formapago]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult, MYSQL_ASSOC))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoFormaPagoTemporada()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['formapago'])&& isset($_POST['temporada']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.formadepago = '$_POST[formapago]'
						  AND D.criteria = '$_POST[temporada]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult, MYSQL_ASSOC))
					{
						$result[] = $queryRow;
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoFormaPagoLineaFamilia()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['formapago'])&& isset($_POST['lineafamilia']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.formadepago = '$_POST[formapago]'
						  AND D.lineafamilia = '$_POST[lineafamilia]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoConceptoFacturacion()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['conceptofacturacion']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.conceptofacturacion = '$_POST[conceptofacturacion]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoLineaTemporada()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['linea']) && isset($_POST['temporada']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.linea = '$_POST[linea]'
						  AND D.criteria = '$_POST[temporada]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoConceptoFacturacionLineaTemporada()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['conceptofacturacion']) && isset($_POST['linea']) && isset($_POST['temporada']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
						  AND D.periodovalidez <> '$$'
						  AND LEFT(D.periodovalidez,10)<= CURDATE()
						  AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
						  AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
						  AND D.conceptofacturacion = '$_POST[conceptofacturacion]'
						  AND D.linea = '$_POST[linea]'
						  AND D.criteria = '$_POST[temporada]'";
				
				$queryResult = mysql_query($query);
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}
				}
				$this->dbClose();
			}
		}
		return $result;
	}
	
	private function DescuentoConceptoFacturacionTemporada()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['conceptofacturacion']) && isset($_POST['temporada']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
							AND D.periodovalidez <> '$$'
							AND LEFT(D.periodovalidez,10)<= CURDATE()
							AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
							AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
							AND D.conceptofacturacion = '$_POST[conceptofacturacion]'
							AND D.criteria = '$_POST[temporada]'";
				
				$queryResult = mysql_query($query);
				
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}					
				}
				$this->dbClose();				
			}
		}
		return $result;
	}
	
	private function DescuentoConceptoFacturacionLineaFamiliaTemporada()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['conceptofacturacion']) && isset($_POST['lineafamilia']) && isset($_POST['temporada']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
							AND D.periodovalidez <> '$$'
							AND LEFT(D.periodovalidez,10)<= CURDATE()
							AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
							AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
							AND D.conceptofacturacion = '$_POST[conceptofacturacion]'
							AND D.lineafamilia = '$_POST[lineafamilia]'
							AND D.criteria = '$_POST[temporada]'";
				
				$queryResult = mysql_query($query);
				
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}					
				}
				$this->dbClose();				
			}
		}
		return $result;
	}
	
	private function DescuentoConceptoFacturacionLineaFamilia()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['conceptofacturacion']) && isset($_POST['lineafamilia']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
							AND D.periodovalidez <> '$$'
							AND LEFT(D.periodovalidez,10)<= CURDATE()
							AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
							AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
							AND D.conceptofacturacion = '$_POST[conceptofacturacion]'
							AND D.lineafamilia = '$_POST[lineafamilia]'";
				
				$queryResult = mysql_query($query);
				
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}					
				}
				$this->dbClose();				
			}
		}
		return $result;
	}
	
	private function DescuentoConceptoFacturacionLinea()
	{
		$result = 0.0;
		if(isset($_POST['codigogenerico']) && isset($_POST['conceptofacturacion']) && isset($_POST['linea']))
		{
			if($this->dbConnect())
			{
				$query = "SELECT MAX(monto) AS descuento
						  FROM co_precio D
						  WHERE D.tiporegistro = 'D'
							AND D.periodovalidez <> '$$'
							AND LEFT(D.periodovalidez,10)<= CURDATE()
							AND SUBSTR(D.periodovalidez,20,10) >= CURDATE()
							AND (
						  		D.itemexcluido IS NULL
			                    OR (
			                    	D.itemexcluido IS NOT NULL AND
									D.itemexcluido NOT LIKE CONCAT('%', '$_POST[codigogenerico]', '%')
			                      )
			                  )
							AND D.conceptofacturacion = '$_POST[conceptofacturacion]'
							AND D.linea = '$_POST[linea]'";
				
				$queryResult = mysql_query($query);
				
				if(mysql_num_rows($queryResult) > 0)
				{
					while($queryRow = mysql_fetch_array($queryResult))
					{
						$result = $queryRow['descuento'];
					}					
				}
				$this->dbClose();				
			}
		}
		return $result;
	}

	//-------------------------------------------------------------------------
	// LISTA DE PARAMETROS
	//-------------------------------------------------------------------------

	public function getFormaPago()
	{
		if($this->dbConnect())
		{
			$query = "SELECT formadepago, descripcion
						FROM ma_formadepago
					   WHERE estado = 'A'";
			$queryResult = mysql_query($query);
			if(mysql_num_rows($queryResult) > 0)
			{
				$result = array();
				while($queryRow = mysql_fetch_array($queryResult))
				{
					$result[] = array(
										"FormaDePago" => $queryRow['formadepago'],
										"Descripcion" => utf8_encode($queryRow['descripcion'])
									  );
				}
				$this->dbClose();
				$this->sendResponse(200, json_encode($result));

			}
			$this->dbClose();
			$this->sendResponse(204, '');
		}
		$error = array('status' => "Failed", "msg" => "No se pudo establecer la conexion con la base de datos");
		$this->sendResponse(500, json_encode($error));
	}
}

$precio = new Precio();

if( isset($_POST['metodo']))
{
	$nombreMetodo = $_POST['metodo'];
	if( strcmp($nombreMetodo, "DESCUENTO") == 0 )
	{
 		$precio-> postDescuento();
 	}
	if( strcmp($nombreMetodo, "FORMADEPAGO") == 0 )
	{
 		$precio-> getFormaPago();
 	} 	
}

?>