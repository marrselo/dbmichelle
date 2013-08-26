<?php
session_start();
//print_r(count($_SESSION['carrito']));
//print_r($_SESSION['compra']['cliente'][0]->idCliente);
$GLOBALS['RUTA_LOCAL'] = "http://localhost/online/mbapp/mbappvendedoras/mbwebservices/";  // para darle la ruta hasta la carpeta imagenes

$_SESSION['linea'] = $_GET['idLinea'];
$_SESSION['familia'] = $_GET['idFamilia'];

//CUANDO HACEN CLIC EN EL LINK DE -COMBINA CON-
if ($_GET['enlace'] == 1) {
    $var = get_object_vars($_SESSION['combinaciones']);
    for ($i = 0; $i < count($var['Combinaciones']); $i++) {
        if ($var['Combinaciones'][$i]->Itempreciocodigo == $_GET['codigo']) {
            $_SESSION['articulo'] = array(
                'codigo' => $var['Combinaciones'][$i]->Itempreciocodigo,
                'nombre' => $var['Combinaciones'][$i]->Descripcioncompleta,
                'linea' => $var['Combinaciones'][$i]->Codigolinea,
                'familia' => $var['Combinaciones'][$i]->Codigofamilia,
                'temporada' => $var['Combinaciones'][$i]->Codigotemporada,
                'precio' => $var['Combinaciones'][$i]->Precio
            );
        }
    }
} else {
    $var = get_object_vars($_SESSION['productos']);
    for ($i = 0; $i < count($var['Genericos']); $i++) {
        if ($var['Genericos'][$i]->Itempreciocodigo == $_GET['codigo']) {
            $_SESSION['articulo'] = array(
                'codigo' => $var['Genericos'][$i]->Itempreciocodigo,
                'nombre' => $var['Genericos'][$i]->Descripcionsubfamilia,
                'linea' => $_GET['linea'],
                'familia' => $_GET['familia'],
                'temporada' => $var['Genericos'][$i]->Caracteristicavalor04,
                'precio' => $var['Genericos'][$i]->Precio
            );
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
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

      <div class="navbar navbar-fixed-top">
          <div class="navbar-inner">
              <div class="container">
                  <input type="hidden" id="temporada" value="<?php echo $_SESSION['coleccion']; ?>" />
                  <ul class="nav">
                      <li class="active"><a href="index.php">SHOP ON-LINE</a></li>
                      <li><a href="http://www.michellebelau.com/es/bienvenido">WEB</a></li>
                      <li><a href="#">CAT&Aacute;LOGO</a></li>
                  </ul>
                  <div style="position: absolute; left: 67%; display: block; height: 35px; width: 110px; padding-top: 5px;">
                      <a href="https://www.facebook.com/michellebelau" target="_blank"><img src="img/ico-fb-blanco.png" /></a>
                      <a href="#"><img src="img/ico-tw-blanco.png" /></a>
                      <a href="http://www.youtube.com/channel/UCXxb52AXcva5ZQQtPFtPjcw?feature=mhee" target="_blank"><img src="img/ico-yt-blanco.png" /></a>
                  </div>
              </div>
          </div>
      </div>

      <div class="container">

          <!-- Main hero unit for a primary marketing message or call to action -->
          <div class="hero-unit">        
              <div style="margin: auto 0; padding: 25px 0px; margin: 0px;">
                  <a href="index.php"><img src="img/logo.jpg"></a>
              </div>
          </div>

      </div>

      <div class="container" style="border-top: 2px solid #d0d0d0;">

          <!-- Main hero unit for a primary marketing message or call to action -->
          <div class="hero-unit">

              <div id='cssmenu'>
                  <ul>
                      <li><a href='index.php'><span><img src="img/ico-hm-plomo.png" border="0" /></span></a></li>
                      <li class='has-sub' ><a href="index.php"><span>OTOÑO - INVIERNO</span></a>
                          <ul class="menu-items menu-items-1">
                              <div class="linea"></div>
                              <li><a href="#"><span>Cargando ... </span></a></li>
                          </ul>
                      </li>
                      <li class='has-sub'><a href="index.php    "><span>PRIMAVERA - VERANO</span></a>
                          <ul class="menu-items menu-items-2">                          
                              <div class="linea"></div>
                              <li><a href="#"><span>Cargando ... </span></a></li>
                          </ul>
                      </li>
                  </ul>
              </div>

              <div id="buscador" >
                  <input type="text" name="buscador" id="texto-buscar" placeholder="SEARCH MB" onkeydown="presionartecla(event)"/> 
                  <input type="button" name="buscar" id="boton-buscar" onclick="buscar()" />
                  <a href="carritocompras.php"><img src="img/ico-sh-plomo.png" border="0" /><span class='cantidad-carrito'>CART (<?php echo count($_SESSION['carrito'])." items)"; ?></span></a>
              </div>

          </div>

          <div class="container portada">
              <div class="hero-unit">        
                  <div style="margin: 30px 0px;">
                      <a href="index.php"><img src="img/imagen-portada.png"></a>
                  </div>
              </div>
          </div>

          <div class="row-fluid" style="display: none;">


              <div class="span12" >

                  <br/>
                  <span id="mensajes"><?php if (isset($_SESSION['error'])) echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                  <div style="display: block; width: 100%; height: 90px; background: url('img/login_fondo.jpg') no-repeat center; ">
                      <?php if ($_SESSION['compra']['cliente'][0]->idCliente > 0) { ?>
                          <div style="padding: 5px; text-align: left; width: 50%;">
                              <p style="padding: 10px; color: #6a6a6a; font-size: 12px; line-height: 15px; "><b style="color: #FFF; text-shadow: 1px 1px 1px #6a6a6a;">BIENVENIDO!</b><br />
                                  <span style="color: #000"><?php echo $_SESSION['compra']['cliente'][0]->nombres; ?></span>, ahora puede realizar todas sus compras online con total garantia con sus tarjetas VISA.<br />
                                  <a href="#" onclick="cerrarsesion();" style="font-weight: bold; color: #FFF; text-shadow: 1px 1px 1px #6a6a6a;">[SALIR]</a></p>
                          </div> 
                      <?php } else { ?>
                          <div style="padding: 5px; text-align: left; width: 50%;">
                              <p style="padding: 10px; color: #6a6a6a; font-size: 12px; line-height: 15px; "><b style="color: #FFF; text-shadow: 1px 1px 1px #6a6a6a;">ACCESO A CLIENTES</b>
                                  <br />
                                  <br /><input type="text" id="documento" placeholder="Ingrese su RUC o DNI" style="
                                                    float: left; 
                                                    display: block;
                                                    height: 15px;
                                                    width: 160px;
                                                    background-color: #FFF; 
                                                    font: normal 11px Arial;
                                                    border-radius: 0px;
                                                    border: 0px;
                                               " /> <input type="button" id="aceptar" value="ENVIAR" onclick="buscarCliente()" style="
                                                    float: left; 
                                                    display: block;
                                                    height: 24px;
                                                    width: 80px;
                                                    background-color: #7d7769; 
                                                    font: normal 11px Arial;
                                                    border-radius: 0px;
                                                    border: 0px;
                                                    color: #FFF;
                                               " />
                              </p>
                          </div> 
                      <?php } ?>
                  </div>
                  <form name="checkout" id="checkout" method="post" action="checkout.php">
                      <span id='tablaprincipal'></span>
                      <br />  
                      <div style="text-align: center; height: 40px;">
                          <input type="checkbox" name="terminos" id='terminos' value='1' style="padding: 0px; margin: 0px;" /> Acepto los <a href="#myModal2" role="button" data-toggle="modal">T&eacute;rminos y Condiciones </a>
                      </div>
                      <div style="text-align: center;">
                          <input type="radio" name="tarjeta" id='visa' value="visa" /> <img src="img/logo VISA.jpg" border="0" width="40" />
                          <input type="radio" name="tarjeta" id='mastercad' value="mastercard" /> <img src="img/mc_accpt_050_gif.gif" border="0" width="40" />&nbsp;&nbsp;&nbsp;
                          
                          <a href="#" onclick="validarcheckout(); return false;"><img src="img/checkout.png" border="0" /></a>
                      </div>
                      <!-- Modal -->
                        <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 606px; height: 500px;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 id="myModalLabel">T&eacute;rminos y Condiciones</h4>
                            </div>
                            <div class="modal-body" style="padding: 20px !important;">
                                <p>Los t&eacute;rminos y condiciones de su compra en nuestra tienda virtual se detallan a continuaci&oacute;n:</p>
                            </div>
                        </div>
                  </form>
                  <form name="mccheckout" id="mccheckout" method="post" action="mccheckout.php">
                      
                  </form>
                  <br />

                  <div class="span11" style="margin-top: 20px;">
                      <p style="font: normal 10px Arial;">Guia r&aacute;pida</p>
                      <ul style="font: normal 10px Arial;">
                          <li>En el cuadro se mostrar&aacute; el listado de articulos que usted agrego al carrito de compras.</li>
                          <li>Si desea cambiar la cantidad de items a comprar, cambie el valor cantidad del item deseado.</li>
                          <li>Para finalizar la compre, presione el bot&oacute;n <b>checkout</b></li>
                      </ul>
                  </div>
                  
              </div>
              
          </div>
          <?php include 'piepagina.php'; ?>    
      </div>
      

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
        
        $(document).ready(function(){
            obtenerLineas();             
            mostrarCarrito();
        });
        function validarcheckout(){
            $('#mensajes').html("");
            if($('#terminos').is(':checked')) {
                if( $('input[name=tarjeta]:checked').val() == 'visa' || $('input[name=tarjeta]:checked').val() == 'mastercard' ) 
                    if( $('input[name=tarjeta]:checked').val() == 'visa') $('#checkout').submit();     
                    else if( $('input[name=tarjeta]:checked').val() == 'mastercard') $('#mccheckout').submit();     
                else {
                    var texto = "<div class='alert alert-block' style='width=500px;' ><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Mensaje:</strong> Estimado cliente, seleccione el metodo de pago adecuado para Usted (Visa o MasterCard).</strong></div>";
                    $('#mensajes').html(texto);
                }
            }
            else {
                var texto = "<div class='alert alert-block' style='width=500px;' ><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Mensaje:</strong> Estimado cliente, para continuar acepte los terminos y condiciones haciendo clic sobre el recuadro.</strong></div>";
                $('#mensajes').html(texto);
            }
        }
        function mostrarCarrito() {
            $('.row-fluid').css('display','block');
            $('.portada').css('display','none');
            $.ajax({
                type: "POST",
                url: "operaciones.php",
                data: ({
                    metodo: 'MOSTRARDETALLECARRITO'
                }),
                success: function(result){
                    //alert(result);
                    $('#tablaprincipal').html('');
                    $('#tablaprincipal').append(result);        
                }
            });
        }
        function actualizarCarrito(nombre,cantidad){
            $.ajax({
                type: "POST",
                url: "operaciones.php",
                data: ({
                    metodo: 'ACTUALIZARCARRITO',
                    codigo: nombre,
                    cantidad: cantidad
                }),
                success: function(result){                    
                    mostrarCarrito();
                }
            });
        }
        function borrarCarrito(nombre){
            $.ajax({
                type: "POST",
                url: "operaciones.php",
                data: ({
                    metodo: 'BORRARCARRITO',
                    codigo: nombre
                }),
                success: function(result){
                    $('.cantidad-carrito').text("CART ("+result+" Items)");
                    mostrarCarrito();
                }
            });
        }
        function cerrarsesion(){
            $.ajax({
                type: "POST",
                url: "operaciones.php",
                data: ({
                    metodo: 'CERRARSESION'
                }),
                success: function(result){
                    document.location.reload();
                }
            });
        }
        function presionartecla(e){
            var key;  
            var keychar;  

            if(window.event || !e.which) // IE  
            {  
                key = e.keyCode; // para IE  
            }  
            else if(e) // netscape  
            {  
                key = e.which;  
            }  
            else  
            {  
                return true;  
            }  

            if (key==13) //Enter  
            {  
              // codigo aqui  
              buscar();
            }  
        }
        function buscar() {         
            if($('#texto-buscar').val().length < 3 && $('#texto-buscar').val().length > 10) { 
                alert('Por favor, ingrese el nombre valido del producto que desea buscar.'); 
            }
            else{
                document.location.href = 'articulos.php?temporada=1&buscar=true&texto='+$('#texto-buscar').val();
            }
        }
    </script>
  </body>
</html>

