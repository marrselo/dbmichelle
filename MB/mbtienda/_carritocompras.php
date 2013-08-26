<?php
    session_start();
    //print_r($_SESSION['compra']);
    //print_r($_SESSION['carrito']);
    //echo count($_SESSION['carrito']);
    $_SESSION['coleccion']=2;
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
            <input type="hidden" id="temporada" value="2" />
                <ul class="nav">
                  <li class="active"><a href="#">OTO&Ntilde;O - INVIERNO</a></li>
                  <li><a href="#about">PRIMAVERA - VERANO</a></li>
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
            <div id="titulo2"><h3 class="articulo-titulo">BOLSA DE COMPRAS</h3></div>
            <div class="span12" >
                
                <div class="span9" style="border-right: 1px solid #ccc; padding: 20px;">
                    <br/>
                    <?php if( isset($_SESSION['error']) ) echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    <form name="checkout" id="checkout" method="post" action="checkout.php">
                        <span id='tablaprincipal'></span>
                        <br />
                        <div style="text-align: center;"><a href="#" onclick="$('#checkout').submit();"><img src="img/checkout.png" border="0" /></a></div>
                    </form>
                    <br />
                    
                    <div class="span5">
                        <?php if($_SESSION['compra']['cliente'][0]->idCliente > 0) { ?>
                        <div style="border: solid 1px #ccc; border-radius: 5px; background-color: #eee; text-align: center;">
                            <p style="padding: 10px;"><b>Bienvenido!</b></p>
                            <p style="padding: 0px 20px; font-size: 11px; line-height: 13px;"><span style="color: #a47e3c"><?php echo $_SESSION['compra']['cliente'][0]->nombres; ?></span>, ahora puede realizar todas sus compras online con total garantia con sus tarjetas VISA.</p>
                            <p style="padding: 10px;"><a href="#" onclick="cerrarsesion();">[Salir]</a></p>
                        </div>                        
                        <?php } else { ?>
                        <div style="border: solid 1px #ccc; border-radius: 5px; background-color: #eee; text-align: center;">
                            <p style="padding: 10px;"><b>Acceso a clientes</b></p>
                            <p style="padding: 0px;">Ingrese su RUC o DNI</p>
                            <p><input type="text" id="documento" placeholder="Ingrese su RUC o DNI" /></p>
                            <p><input type="button" id="aceptar" value="Ingresar" onclick="buscarCliente()" /></p>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="span6" >
                        <div style="border: solid 1px #ccc; border-radius: 5px; background-color: #eee; text-align: center;">
                            sss
                        </div>
                    </div>
                    
                    <div class="span11" style="margin-top: 20px;">
                        <p style="font: normal 10px Arial;">Guia r&aacute;pida</p>
                        <ul style="font: normal 10px Arial;">
                            <li>En el cuadro se mostrar&aacute; el listado de articulos que usted agrego al carrito de compras.</li>
                            <li>Si desea cambiar la cantidad de items a comprar, cambie el valor cantidad del item deseado.</li>
                            <li>Para finalizar la compre, presione el bot&oacute;n <b>checkout</b></li>
                        </ul>
                    </div>
                </div>
                
                <div class="span3" style="width: 18%; padding: 20px 0px;" >
                    
                </div>
                
                
            </div>
            
        </div>
        <!-- GALERIA DE FOTOS -->
        
        
      </div>

      <?php include 'piepagina.php'; ?>

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
    <script type="text/javascript" src="js/jquery.tinycarousel.min.js"></script>
    <script type="text/javascript" src="js/lightbox.js"></script>
        
    <script type="text/javascript" src="js/operaciones.js"></script>
    <script type="text/javascript">
        
        var json_productos = eval('(<?php echo json_encode($_SESSION['productos']); ?>)');
        var json_producto = eval('(<?php echo json_encode($_SESSION['producto']); ?>)');
        var json_stocks = eval('(<?php echo json_encode($_SESSION['stocks']); ?>)');
        
        $(document).ready(function(){

            obtenerLineas();
            $('.menu-items li a:first').click();   
            obtenerClasesPorLinea($('.menu-seleccionado').attr('linea'));                        
            mostrarCarrito();
            
        });
        function mostrarCarrito() {
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
                    //alert('entro');
                    mostrarCarrito();
                    //alert(result);
                    //$('#tablaprincipal').html('');
                    //$('#tablaprincipal').append(result);
                    
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
