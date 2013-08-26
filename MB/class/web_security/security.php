<?php
session_start();
require ("aut_config.inc.php");
$_num_coe="SELECT codigoe FROM administ where ID='".$_SESSION['s_id_admin_s']."' and codigoe='".$_SESSION['OK']."'";

	$coe=mysql_query($_num_coe,$db_conexion);
	$row_coe=mysql_fetch_assoc($coe);
	 $d_coe=$row_coe["codigoe"];

if (($_SESSION['OK']!=$d_coe)||(empty($_SESSION['OK'])))
{
session_destroy();
 header("Location:index.php");
}
?>