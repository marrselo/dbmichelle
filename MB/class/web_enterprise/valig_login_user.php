<?php
require ("aut_config.inc.php");
$cnx= mysql_connect($sql_host, $sql_usuario, $sql_pass) or die("No se pudo conectar a la Base de datos") or die(mysql_error());

    mysql_select_db($sql_db) or die(mysql_error());
	$ruc=$_POST['empresa'];
	$pass= $_POST['pass'];
	$slq_login="SELECT id,nombre,ruc,pass FROM empresa WHERE 
            ruc='".$ruc."' AND pass='".$pass."'";
	$rs_login=mysql_query($slq_login,$cnx);
	$row_login=mysql_fetch_assoc($rs_login);        
        if(!empty($row_login)){
            header("Location: ../puntosvip2/validar_vip.php");
        }else{
            $msj_error="Datos incorrectos, intente de nuevo";
        }

        
//	$exite_user=mysql_num_rows($rs_login);
//	$clave_admin=$row_login['pass'];
	
//        if($exite_user > 0){}

?>