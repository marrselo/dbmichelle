<?php
define('CODIGO_TIENDA','154531905');

//// DESARROLLO
//define('URL_FORMULARIO_VISA','http://cal2testing.sytes.net/formularioweb/formulariopago.asp');
//define('URL_WSGENERAETICKET_VISA','http://cal2testing.sytes.net/WSGenerarEticket/WSEticket.asmx?WSDL');
//define('URL_WSCONSULTAETICKET_VISA','http://cal2testing.sytes.net/WSConsulta/WSConsultaEticket.asmx?WSDL');

define('URL_FORMULARIO_VISA','http://qas.multimerchantvisanet.com/formularioweb/formulariopago.asp');
define('URL_WSGENERAETICKET_VISA','http://qas.multimerchantvisanet.com/wsgenerareticket/wseticket.asmx?wsdl');
define('URL_WSCONSULTAETICKET_VISA','http://qas.multimerchantvisanet.com/wsconsulta/wsconsultaeticket.asmx?wsdl');

//// CALIDAD
//define('URL_FORMULARIO_VISA','http://qas.posmultimerchantvisa.com/formularioweb/formulariopago.asp');
//define('URL_WSGENERAETICKET_VISA','http://qas.posmultimerchantvisa.com/WSGenerarEticket/WSEticket.asmx?wsdl');
//define('URL_WSCONSULTAETICKET_VISA','http://qas.posmultimerchantvisa.com/WSConsulta/WSConsultaEticket.asmx?wsdl');

//define('URL_WSCONSULTAETICKET_VISA','http://qas.multimerchantvisanet.com/formularioweb/formulariopago.asp');

//// PRODUCCI�N
//define('URL_FORMULARIO_VISA','http://www.multimerchantvisanet.com/formularioweb/formulariopago.asp');
//define('URL_WSGENERAETICKET_VISA','http://www.multimerchantvisanet.com/WSGenerarEticket/WSEticket.asmx');
//define('URL_WSCONSULTAETICKET_VISA','http://www.multimerchantvisanet.com/WSConsulta/WSConsultaEticket.asmx');
    

function noCache() {
  header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
}

function htmlRedirecFormAnt($CODTIENDA, $NUMORDEN, $MOUNT){
	$html='<Html>
	<head>
	<title>Pagina prueba Visa</title>
	</head>
	<Body onload="fm.submit();">

	<form name="fm" method="post" action="'.URL_FORMULARIO_VISA.'">
	    <input type="hidden" name="CODTIENDA" value="#CODTIENDA#" /><BR>
	    <input type="hidden" name="NUMORDEN" value="#NUMORDEN#" /><BR>
	    <input type="hidden" name="MOUNT" value="#MOUNT#" /><BR>
	</form>
	</Body>
	</Html>';

	$html=ereg_replace("#CODTIENDA#",$CODTIENDA,$html);
	$html=ereg_replace("#NUMORDEN#",$NUMORDEN,$html);
	$html=ereg_replace("#MOUNT#",$MOUNT,$html);

	return $html;
}

function htmlRedirecFormEticket($ETICKET){
   
	$html='<Html>
	<head>
	<title>Pagina prueba Visa</title>
	</head>
	<Body onload="fm.submit();">

	<form name="fm" method="post" action="'.URL_FORMULARIO_VISA.'">
	    <input type="hidden" name="ETICKET" value="#ETICKET#" /><BR>
	</form>
	</Body>
	</Html>';

	$html= str_replace("#ETICKET#", $ETICKET, $html);

	return $html;
}

?>
