<?php
session_start();
require ("./aut_config.inc.php");
session_destroy();
header("Location: ../../index.php");
?>