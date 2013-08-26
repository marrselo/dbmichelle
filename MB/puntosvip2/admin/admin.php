<?php
session_start();
if (!isset($_SESSION['nombre'])) {
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8" />
		<title>Sistemas de Administracion</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/bootstrap-responsive.css" rel="stylesheet" />
		<link href="css/bootstrap.css" rel="stylesheet" />
                  <!--[if lt IE 9]>
                    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                  <![endif]-->
	</head>
	<body>
		<!-- BARRA DE TITULO -->
		<div class="navbar navbar-static-top">
			<div class="navbar-inner">
				<a class="brand" href="#">Administrador de Contenido</a>
				<ul class="nav pull-right">
					<li>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo "Usuario: ".utf8_decode($_SESSION['nombre']." "); ?><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="index.php" onclick="fnCerrarSesion();">Cerrar Sesion</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- CONTENIDO -->
		<div class="container-fluid">
			<br/>
			<!-- COLUMNA LATERAL -->
			<div class="row-fluid">
				<section class="span2 well well-small" style="height:83%; overflow:auto;" >
					<ul class="nav nav-list">
						<li class="nav-header">
							TABLAS
						</li>
						<li class="divider"></li>
						<li id="0" class="active">
							<a href="categoria.php" target="if1" onclick="muestra_oculta(0)"><small><b>Categorias</b></small></a>
						</li>
						<li class="divider"></li>
						<li id="1">
							<a href="empresa.php" target="if1" onclick="muestra_oculta(1)"><small><b>Empresas</b></small></a>
						</li>
						<li class="divider"></li>
						<li id="2">
							<a href="producto.php" target="if1" onclick="muestra_oculta(2)"><small><b>Productos</b></small></a>
						</li>
						<li class="divider"></li>
						<li id="3">
							<a href="usuario.php" target="if1" onclick="muestra_oculta(3)"><small><b>Usuario</b></small></a>
						</li>
						<li class="divider"></li>
                                                <li id="4">
							<a href="publicidad.php" target="if1" onclick="muestra_oculta(4)"><small><b>Publicidad</b></small></a>
						</li>
						<li class="divider"></li>
					</ul>
				</section>
				<!--IFRAME PARA MOSTRAR -->
				<iframe name="if1" class="well well-small span10" src="categoria.php" height="550"></iframe>
			</div>
		</div>
		<!-- SCRIPTS -->
		<script src="js/jquery-1.8.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
			function muestra_oculta(id) {
				for(var i = 0; i < 12; i++) {
					var clase = '#' + i;
					$(clase).removeClass('active');
				};
				clase = '#' + id;
				$(clase).addClass('active');
			}
		</script>
	</body>
</html>
