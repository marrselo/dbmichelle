<?php
$sql_host="192.168.1.193"; 
$sql_usuario="migra";        // 
$sql_pass="migramb";           // contrase�a de Mysql
$sql_db="mbinterface";
$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
$conn = mysql_connect($sql_host,$sql_usuario,$sql_pass);
mysql_select_db($sql_db, $db_conexion);
?>