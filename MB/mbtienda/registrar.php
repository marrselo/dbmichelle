<?php
session_start();
//print_r($_SESSION['articulo']);
$GLOBALS['RUTA_LOCAL']  = "http://209.45.30.34/online/mbapp/mbappvendedoras/mbwebservices/";  // para darle la ruta hasta la carpeta imagenes
$GLOBALS['NOMBRE_FULL']  = "FullCine";  // para darle la ruta hasta la carpeta imagenes
$GLOBALS['ID_FULL']  = "1";  // para darle la ruta hasta la carpeta imagenes

$_SESSION['linea']=$_GET['idLinea'];
$_SESSION['familia']=$_GET['idFamilia'];

if(isset($_POST['nombre'])){
    //print_r($_POST);
    $url = "http://localhost/online/mbapp/mbappvendedoras/mbwebservices/cliente.php";
    
    $apellidos[0]=" ";
    $apellidos[1]=" ";
    $apellidos = explode(" ", $_POST['apellidos']);
    
    $data = array( 'metodo' => 'REGISTRARCLIENTE',
                    'nombres' => $_POST['nombre'],
                    'apellidopaterno' => $apellidos[0],
                    'apellidomaterno' => $apellidos[1],
                    'sexo' => $_POST['sexo'],
                    'tipodocumento' => $_POST['tipodocumento'],
                    'documento' => $_POST['documento'],
                    'direccion' => $_POST['direccion'],
                    'correoelectronico' => $_POST['email'],
                    'correoElectronico' => $_POST['email'],
                    'nombreCompleto' => $_POST['nombre']." ".$_POST['apellidos'],
                    'ruc' => ' ',
                    'tipopersona' => 'EMP',
                    'fechanacimiento' => ' ',
                    'telefono' => $_POST['telefono'],
                    'telefonoemergencia' => $_POST['telefono'],
                    'correoelectronico' => $_POST['email'],
                    'origen' => $_POST['ciudad'],
                    'UltimoUsuario' => 'JCARBAJAL'
    ); 
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $resp = curl_exec($ch);
    curl_close($ch);
    
    $objeto = json_decode($resp);
    
    if($objeto->idCliente > 0) {
        $_SESSION['compra']['idCliente']= $objeto->idCliente;
        $_SESSION['compra']['cliente']= $data;
    }
    //$_SESSION['compra']="";
    //echo $objeto['idCliente'];
    //print_r($_SESSION['compra']);
    
}
?>
<!DOCTYPE html>
<html lang="ES">
  <head>
    <meta charset="UTF-8" />
    <title>Michelle Belau - Tienda Virtual</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tienda Virtual">
    <meta name="author" content="Michelle Belau - Tienda Virtual">
    
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">    
    <link href="css/lightbox.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
      
    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
          <p><a href="index.php"><img src="img/logo.jpg"></a></p>
      </div>

    </div>
      
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
            <input type="hidden" id="temporada" value="<?php echo $_SESSION['coleccion']; ?>" />
            <ul class="nav">
                <li class="<?php if($_SESSION['coleccion']==1) echo 'active'; ?>" ><a href="index.php?coleccion=1">OTO&Ntilde;O - INVIERNO</a></li>
                <li class="<?php if($_SESSION['coleccion']==2) echo 'active'; ?>" ><a href="index.php?coleccion=2">PRIMAVERA - VERANO</a></li>
            </ul>
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
          <div id="menu">
          <ul class="menu-items">
              <li><a href="#" class="menu-seleccionado">TEXTO</a></li>
              <li><a href="#">AVIOS</a></li>
              <li><a href="#">ACCESORIOS</a></li>
              <li><a href="#">CALZADO</a></li>
              <li><a href="#">AVIOS</a></li>
              <li><a href="#">ACCESORIOS</a></li>
              <li><a href="#">CALZADO</a></li>
              <li><a href="#">AVIOS</a></li>
              <li><a href="#">ACCESORIOS</a></li>
              <li><a href="#">CALZADO</a></li>
          </ul>
          </div>
      </div>

      <div class="row-fluid">
        <div class="span2">
            <div id="sub-menu">
            <ul class="sub-menu-items">
                <li><a href="#">Abrigo</a></li>
                <li><a href="#">Blaiser</a></li>
                <li><a href="#">Blusa</a></li>
                <li><a href="#">Capri</a></li>
                <li><a href="#">Casaca</a></li>
                <li><a href="#">Blaiser</a></li>
                <li><a href="#">Blusa</a></li>
                <li><a href="#">Capri</a></li>
                <li><a href="#">Casaca</a></li>
                <li><a href="#">Abrigo</a></li>
                <li><a href="#">Blaiser</a></li>
                <li><a href="#">Blusa</a></li>
                <li><a href="#">Capri</a></li>
                <li><a href="#">Casaca</a></li>
                <li><a href="#">Blaiser</a></li>
                <li><a href="#">Blusa</a></li>
                <li><a href="#">Capri</a></li>
                <li><a href="#">Casaca</a></li>
            </ul>
            </div>
            <?php include 'menulateral.php'; ?>        
        </div>
          
        <div class="span10">
            <div id="titulo2"><h3 class="articulo-titulo">Registro de Cliente</h3></div>
            
            <div class="span12" >
                <div class="span9" style="border-right: solid 1px #ccc; padding-right: 15px;" >
                    <!--p>Estimado cliente, complete el siguiente formulario de registro para facilitar el proceso de su siguiente compra :</p-->
                    <form method="POST" action="registrar.php" >
                        <br/>
                        <?php if(isset($_SESSION['compra']) && isset($_POST['nombre'])) echo "<div class='alert alert-success' style='width=500px;' >
                                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                                        <strong>Excelente!</strong> Su registro se ha completado con exito!.
                                                      </div>"; ?>
                        
                        <table width="550" border="0" cellspacing="5" cellpadding="0" align="center" style="margin-top:  30px;" >
                        <tr>
                            <td class="tabla-columna1">Nombres : </td>
                            <td style="width: 300px;"><input type="text" name="nombre" id="nombre" required="requiered" /></td>
                        </tr>
                        <tr>
                            <td class="tabla-columna1">Apellidos : </td>
                            <td><input type="text" name="apellidos" id="apellidos" required="requiered" /></td>
                        </tr>
                        <tr>
                            <td class="tabla-columna1">Sexo : </td>
                            <td><select name="sexo" id="sexo" required="requiered">
                                    <option value="F">Femenino</option>
                                    <option value="M">Masculino</option>
                                </select></td>
                        </tr>                        
                        <tr>
                            <td class="tabla-columna1">Documento : </td>
                            <td><select name="tipodocumento" id="tipodocumento" required="requiered" class="input-small">
                                    <option value="D">D.N.I.</option>
                                    <option value="O">C. Extranjeria</option>
                                </select> <input type="text" name="documento" id="documento" required="requiered" class="input-small"/></td>
                        </tr>                        
                        <tr>
                            <td class="tabla-columna1">Tel&eacute;fono : </td>
                            <td><input type="tel" name="telefono" id="telefono" /></td>
                        </tr>
                        <tr>
                            <td class="tabla-columna1">Direcci&oacute;n : </td>
                            <td><input type="text" name="direccion" id="direccion" required="requiered" /></td>
                        </tr>
                        <tr>
                            <td class="tabla-columna1">E-mail : </td>
                            <td><input type="text" name="email" id="email" required="requiered" /></td>
                        </tr>
                        <tr>
                            <td class="tabla-columna1">Ciudad : </td>
                            <td><input type="text" name="ciudad" id="ciudad" required="requiered" /></td>
                        </tr>
                        <tr>
                            <td class="tabla-columna1"></td>
                            <td><input type="reset" name="limpiar" id="limpiar" value="Limpiar" /> <input type="submit" name="grabar" id="grabar" value="Grabar" /> </td>
                        </tr>
                    </table>
                    </form>
                </div>
                <div class="span3" style="width: 18%; padding: 20px 0px;" >
                    <div id="share" style="position: absolute; float: left; margin-left: -55px; margin-top: -40px;"><a href="#"><img src="img/share.jpg" border="0" /></a></div>

                    <div id="carrito">

                    </div>   
                    <div id="links">
                        <a href="carritocompras.php">Ver Carrito de Compras</a>
                        <a href="carritocompras.php" style="color: #222;">Comprar</a>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- GALERIA DE FOTOS -->
        
        
      </div>
      
      
      
        <div class="container">
            
            <div class="span9 offset2" style="border-top: 1px solid #ccc;">
                
                <div class="span9" >
                    
                </div>
            </div>

        </div>

     
      <footer style="width: 100%;">
        <p>&copy; Company 2012</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
        
    <script type="text/javascript" src="js/operaciones.js"></script>
    <script type="text/javascript">
        
        var json_productos = eval('(<?php echo json_encode($_SESSION['productos']); ?>)');
        var json_producto = eval('(<?php echo json_encode($_SESSION['producto']); ?>)');
        var json_stocks = eval('(<?php echo json_encode($_SESSION['stocks']); ?>)');        
        var json_articulo = eval('(<?php echo json_encode($_SESSION['articulo']); ?>)');
        
        $(document).ready(function(){
            var idLinea = '<?php echo $_GET['linea']; ?>';
            var idFamilia = '<?php echo $_GET['familia']; ?>';
            var codProducto = '<?php echo $_GET['codigo']; ?>';
            obtenerLineas();
            //PARA SELECCIONAR LOS MENUS DE LINEA Y FAMILIA
            if(idLinea.length>0) {
                obtenerClasesPorLinea(idLinea);
                $('a[linea]').removeClass('menu-seleccionado');
                $('a[linea='+idLinea+']').addClass('menu-seleccionado');

                $('a[familia]').removeClass('sub-menu-seleccionado');
                $('a[familia='+idFamilia+']').addClass('sub-menu-seleccionado');     
            }
            else {
                $('.menu-items li a:first').click();                
                $('.sub-menu-items li a:first').click();
            }
            
            mostrarCarrito();
        });
        
        function mostrarCarrito() {
            $.ajax({
                type: "POST",
                url: "operaciones.php",
                data: ({
                    metodo: 'MOSTRARCARRITO'
                }),
                success: function(result){
                    //alert(result);
                    $('#carrito').html('');
                    $('#carrito').append(result);
                }
            });
        }
        function ocultar() {
            if( $('.span7').hasClass('oculto')==false ) {
                $('.span7').animate({opacity:"hide"});
                $('.span7').addClass('oculto');
                $('#boton-filtro').html('[+] Mostrar Filtro');
            } else {
                $('.span7').animate({opacity:"show"});
                $('.span7').removeClass('oculto');
                $('#boton-filtro').html('[-] Ocultar Filtro');
            }
        }
    </script>
  </body>
</html>
