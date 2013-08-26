<?php
require 'webconfig.php';
session_start(); 
unset ( $_SESSION['id'] );
unset ( $_SESSION['nombre'] );
unset ( $_SESSION['estado'] );
session_destroy();	
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8" />
		<title>Administrador de Contenido</title>
		<link href="css/bootstrap.css" rel="stylesheet" media="screen" />
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link href="css/estilo.css" rel="stylesheet" />
                
                <!--[if lt IE 9]>
                    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                  <![endif]-->
	</head>
	<body class="inicio">
		<div class="container">
			<br/>
			<form class="form-horizontal transparent-white" id="loginform" method="post" style="border: 0px solid #BBB;">
				<div class="centrado"><img src="css/mb.png" style="padding: 10px;"/>
				</div>
				<div id="resultado"></div>
				<div class="control-group">
					<label class="control-label" for="Usuario">Usuario</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"  style="height: 20px;"><i class="icon-user"></i></span>
							<input type="text" id="txtUsuario" class="span3" name="txtUsuario" placeholder="Ingrese su Usuario" required >
						</div>
						
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Password">Contrase&ntilde;a</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"  style="height: 20px;"><i class="icon-lock"></i></span>
							<input type="password" id="txtPasswd" class="span3" name="txtPasswd" placeholder="ingrese su Contrase&ntilde;a" required >
						</div>
						
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn"  onclick="fnLogin()">
							Entrar
						</button>
					</div>
				</div>
				<br/>
			</form>
		</div>
		<!-- SCRIPTS -->
		<script src="js/jquery-1.8.1.min.js"></script>
		<script src="js/bootstrap.js" ></script>
		<script src="controlador/usuario.js" ></script>
		
	</body>
</html>
