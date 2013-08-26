<?php
if($_POST['h_send']!=""){

require ("aut_config.inc.php");
$cnx= mysql_connect($sql_host, $sql_usuario, $sql_pass) or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db($sql_db) or die(mysql_error());
	$user_login=$_POST['txt_usuario'];
	$contra_login= md5($_POST['txt_contra']);
	$slq_login="SELECT ID,us_uario, pas_sclave,nivel_acceso FROM administ WHERE us_uario='".$user_login."' AND nivel_acceso>0";
	$rs_login=mysql_query($slq_login,$cnx);
	$row_login=mysql_fetch_assoc($rs_login);
	$exite_user=mysql_num_rows($rs_login);
	$clave_admin=$row_login['pas_sclave'];
	
	if($exite_user > 0){
		if($clave_admin==$contra_login){
			$_SESSION['s_id_admin_s']=$row_login['ID'];
			$_SESSION['s_name_admin_s']=$row_login['us_uario'];
			$_SESSION['nivel_acc']=$row_login["nivel_acceso"];
			

function generar_password () {
$i=0;
$password="";
// Aqui colocamos el largo del password
$pw_largo = 5;
// Colocamos el rango de caracteres ASCII para la creacion de el password
$desde_ascii = 50; // "2"
$hasta_ascii = 122; // "z"
// Aqui quitamos caracteres especiales
$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
while ($i < $pw_largo) {
mt_srand ((double)microtime() * 1000000);
// limites aleatorios con tabla ASCII
$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii);
if (!in_array ($numero_aleat, $no_usar)) {
$password = $password . chr($numero_aleat);
$i++;
}
}
return $password;

}
// Y aqui ejecutamos la funcion y la guardamos en $p_generado, luego simplemente la cargamos
$p_generado=generar_password();
$nuevo2=date("H");
$pwn=$nuevo.$p_generado.$nuevo2;

mysql_query("UPDATE administ SET codigoe='".$pwn."' WHERE us_uario='".$row_login['us_uario']."'");
			$_SESSION['OK']=$pwn;
			mysql_close($cnx);
		}else{
			$msj_error="La contraseña no coincide con el usuario";
		}
	}else{
		$msj_error="El Usuario no existe o no esta habilitado";
	
	}

}
?>