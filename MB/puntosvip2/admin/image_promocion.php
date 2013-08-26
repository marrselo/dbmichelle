<?php
	require 'webconfig.php';
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = end(explode(".", $_FILES["file"]["name"]));

	if ($_FILES["file"]["error"] > 0)
    {
		echo "Codigo de Error: " . $_FILES["file"]["error"] . "<br />";
    }
  
	if (file_exists("img/" . $_FILES["file"]["name"]))
	{
		echo $_FILES["file"]["name"] . " Imagen ya existe. ";
	}
	else
	{
		list($nombrefile, $extencionfile) = explode('.',$_FILES['file']['name']);
		$nombrefile = date('Ymdhis');
		$targetFile =  str_replace('//','/',$targetPath) . strtolower($nombrefile.'.'.$extencionfile);
		move_uploaded_file($_FILES["file"]["tmp_name"],"img/" . $targetFile );
		session_start();
		echo "<img id='fotoiframe' ruta='img/".$nombrefile.'.'.$extencionfile."' src='". $GLOBALS['RUTA_DIRECTORIO']. "img/" . $targetFile  . " ' style='width:128px; height:128px;'/>";
		$_SESSION['rutafoto'] = $GLOBALS['RUTA_DIRECTORIO']. "img/" . $targetFile ;
	}
?>