<?php
$sql_host="174.37.91.26"; 
$sql_usuario="michelle";        // 
$sql_pass="1ne328171x";           // contraseña de Mysql
$sql_db="bapp";
$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
$conn = mysql_connect($sql_host,$sql_usuario,$sql_pass);
mysql_select_db($sql_db, $db_conexion);
?>