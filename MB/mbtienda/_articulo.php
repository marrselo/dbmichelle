<?php
session_start();
//print_r($_SESSION['articulo']);
$GLOBALS['RUTA_LOCAL']  = "http://209.45.30.34/online/mbapp/mbappvendedoras/mbwebservices/";  // para darle la ruta hasta la carpeta imagenes
$GLOBALS['NOMBRE_FULL']  = "FullCine";  // para darle la ruta hasta la carpeta imagenes
$GLOBALS['ID_FULL']  = "1";  // para darle la ruta hasta la carpeta imagenes

$_SESSION['linea']=$_GET['idLinea'];
$_SESSION['familia']=$_GET['idFamilia'];

//CUANDO HACEN CLIC EN EL LINK DE -COMBINA CON-
if($_GET['enlace']==1){
    $var = get_object_vars($_SESSION['combinaciones']);
    for ($i = 0 ; $i < count($var['Combinaciones']); $i++) {
        if($var['Combinaciones'][$i]->Itempreciocodigo == $_GET['codigo']) {
            $_SESSION['articulo']= array(
                'codigo' => $var['Combinaciones'][$i]->Itempreciocodigo,
                'nombre' => $var['Combinaciones'][$i]->Descripcioncompleta,
                'linea' => $var['Combinaciones'][$i]->Codigolinea,
                'familia' => $var['Combinaciones'][$i]->Codigofamilia,
                'temporada' => $var['Combinaciones'][$i]->Codigotemporada,
                'precio' => $var['Combinaciones'][$i]->Precio
            );
        }
    }
}else {
    $var = get_object_vars($_SESSION['productos']);
    for ($i = 0 ; $i < count($var['Genericos']); $i++) {
        if($var['Genericos'][$i]->Itempreciocodigo == $_GET['codigo']) {
            $_SESSION['articulo']= array(
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
          <div style="margin: auto 0; padding: 5px; padding-bottom: 0px; margin: 0px; margin-left: 85%; height: 20px; display: block; line-height: 20px;">
              <input type="text" name="buscador" id="texto-buscar" placeholder="Buscar ..." style="float: left; display: block;
                    height: 16px;
                    border-radius: 0px;
                    padding-left: 20px;
                    width: 90px;
                    background-color: #d8d8d8; 
                    border: 0px;
                    font: normal 11px Arial;
                    background-image: url('img/lupa2.png');
                    background-position: left;
                    background-repeat: no-repeat;" onkeydown="presionartecla(event)" /> 
              <input type="button" name="buscar" id="boton-buscar" style="float: left; display: block;
                    height: 24px;
                    border-radius: 0px;
                    margin-left: 5px;
                    width: 20px;
                    background-color: #d8d8d8; 
                    border: 0px;
                    font: normal 11px Arial;
                    background-image: url('img/flecha3.png');
                    background-position: left;
                    background-repeat: no-repeat;" onclick="buscar()" />
          </div>
          <div style="margin: auto 0; padding: 0px; margin: 0px;"><a href="index.php"><img src="img/logo.jpg"></a></div>
      </div>

    </div>
      
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
            <input type="hidden" id="temporada" value="<?php echo $_SESSION['coleccion']; ?>" />
            <ul class="nav">
                <li class="<?php if($_SESSION['coleccion']==1) echo 'active'; ?>" ><a href="index.php?coleccion=1&idLinea=<?php echo $_SESSION['linea']; ?>&idFamilia=<?php echo $_SESSION['familia']; ?>">OTO&Ntilde;O - INVIERNO</a></li>
                <li class="<?php if($_SESSION['coleccion']==2) echo 'active'; ?>" ><a href="index.php?coleccion=2&idLinea=<?php echo $_SESSION['linea']; ?>&idFamilia=<?php echo $_SESSION['familia']; ?>">PRIMAVERA - VERANO</a></li>
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
            <div id="titulo2"><h3 class="articulo-titulo"><?php echo strstr($_SESSION['articulo']['nombre'], $_SESSION['articulo']['codigo'], true); ?></h3></div>
            <div class="span12" >
                <div class="span4" >
                    <div id="galeria-producto">
                        <!--a href="articulo.php" -->
                            <div class="producto-fondo">
                                <div class="producto-foto">
                                    <a href="img/articulo-foto.jpg" rel="lightbox" title="Michelle Belau"><img src="img/articulo-foto.jpg" /></a>                                    
                                </div>
                            </div>
                        
                            <div style="cursor: pointer;" class="producto-titulo" onclick="$('.producto-foto a:first').click()"><p><img src="img/lupa.png" border="0" /> &nbsp;ZOOM</p></div>
                            
                            <div class="producto-sociales"> 
                                <div id="fb-root"></div>
                                <script>(function(d, s, id) {
                                  var js, fjs = d.getElementsByTagName(s)[0];
                                  if (d.getElementById(id)) return;
                                  js = d.createElement(s); js.id = id;
                                  js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";
                                  fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));</script>
                                <!--img src="img/twitter.jpg" /-->  <div class="fb-like" data-href="https://www.facebook.com/michellebelau" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
                            </div>
                            
                    </div>
                
                </div>
                <div class="span5" style="border-right: 1px solid #ccc;">
                    
                    <div id="slider1">
                            <a class="buttons prev" href="#">left</a>
                            <div class="viewport">
                                <ul class="overview">
                                </ul>
                            </div>
                            <a class="buttons next" href="#">right</a>
                    </div>
                    
                    <table id="tabla" style="margin-bottom: 40px;">
                        <tr>
                            <td class="tabla-titulo" style="width: 30%; color: #aaa;">Detalle</td>
                            <td class="tabla-contenido" style="width: 70%">
                                <p class="articulo-detalle"><?php echo $_SESSION['articulo']['nombre']; ?>.</p>
                                <input type="hidden" id="caracteristica" value="<?php echo $_SESSION['articulo']['temporada']; ?>" />
                                <input type="hidden" id="linea" value="<?php echo $_SESSION['articulo']['linea']; ?>" />
                                <input type="hidden" id="familia" value="<?php echo $_SESSION['articulo']['familia']; ?>" />
                                <input type="hidden" id="codigo" value="<?php echo $_SESSION['articulo']['codigo']; ?>" />            
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; padding: 5px;" colspan="2">
                                <select class="articulo-color" style="width: 95%" onchange="obtenerArticuloTalla()">
                                    <option value='0'>SELECCIONE COLOR</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; padding: 5px;" colspan="2">
                                <select class="articulo-talla" style="width: 95%" onchange="obtenerArticuloCantidad()">
                                    <option value='0'>SELECCIONE TALLA</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; padding: 5px;" colspan="2">
                                <select class="articulo-cantidad" style="width: 95%">
                                    <option value='0'>SELECCIONE CANTIDAD</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="tabla-titulo" style="width: 30%">Precio anterior</td>
                            <td class="tabla-contenido articulo-precio-anterior" style="width: 70%">S/. <?php echo number_format($_SESSION['articulo']['precio'],2,'.',','); ?></td>
                        </tr>
                        <tr>
                            <td class="tabla-titulo" style="width: 30%">Precio actual</td>
                            <td class="tabla-contenido articulo-precio-actual" style="width: 70%">S/. <?php echo number_format($_SESSION['articulo']['precio'],2,'.',','); ?></td>
                        </tr>
                        <tr>
                            <td class="tabla-titulo" style="width: 30%">Descuento</td>
                            <td class="tabla-contenido articulo-precio-porcentaje" style="width: 70%" >25% Dscto.</td>
                        </tr>
                        <tr style="height: 40px;">
                            <td style="width: 30%"><p class="tabla-total">TOTAL</p></td>
                            <td style="padding-left: 25px;" class="articulo-precio-total">S/. <?php echo number_format($_SESSION['articulo']['precio'],2,'.',','); ?></td>
                        </tr>
                        <tr>
                            <td style="width: 100%" colspan="2"><div class="titulo-dorado" onclick="agregarItem()"><p>AGREGAR A LA BOLSA</b></p></div></td>
                        </tr>
                        <tr>
                            <td style="width: 100%" colspan="2"><!--img src="img/estrellas.jpg" border="0" /--></td>
                        </tr>
                    </table>
                    
                </div>
                <div class="span3" style="width: 18%; padding: 20px 0px;" >                    
                    <div id="share" style="position: absolute; float: left; margin-left: -55px; margin-top: -40px;"><a href="#" ><img src="img/share.jpg" border="0" /></a></div>

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
                    <div id="combinaciones"> 
                        <p>Combina con:</p>
                        <div class="combionaciones-item">
                            <a href="articulo.php?codigo=1"><img src="img/producto1.jpg" border="0" /></a>
                        </div>
                    </div>
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
    <script type="text/javascript" src="js/jquery.tinycarousel.min.js"></script>
    <script type="text/javascript" src="js/lightbox.js"></script>
        
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
            //alert(codProducto);
            $('.producto-foto').html("<a href='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+codProducto+".JPG' rel='lightbox' title='Michelle Belau'><img src='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+codProducto+".JPG' /></a>");
                            
            $('.overview').append("<li><img onclick='cambiarImagen($(this))' src='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+codProducto+".JPG' /></li>");
            $('.overview').append("<li><img onclick='cambiarImagen($(this))' src='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+codProducto+"1.JPG' /></li>");
            $('.overview').append("<li><img onclick='cambiarImagen($(this))' src='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+codProducto+"2.JPG' /></li>");
            
            //$('#slider1').tinycarousel({ interval: true });
                        
            obtenerArticulo(codProducto);
            //obtenerPrecioArticulo(codProducto);
            obtenerCombinaciones(codProducto);
            
            mostrarCarrito();
        });
        function agregarItem() {
            if( $('.articulo-color').val() != 0 && $('.articulo-talla').val() != 0 && $('.articulo-cantidad').val()>0 ) {
                itemcodigo = $('#codigo').val()+$('.articulo-color').val()+$('.articulo-talla').val();
                itemcantidad = $('.articulo-cantidad').val();
                itemnombre = $('.articulo-detalle').text();
                itemnombre = itemnombre.split($('#codigo').val());
                itemprecio = json_articulo.precio; <?php //echo number_format($_SESSION['articulo']['precio'],2,'.',','); ?>
                itemtalla = $('.articulo-talla').val();
                itemcolor = $('.articulo-color').val();
                $.ajax({
                        type: "POST",
                        url: "operaciones.php",
                        dataType: 'json',
                        data: ({
                            metodo: 'AGREGARCARRITO',
                            codigo: itemcodigo,
                            cantidad: itemcantidad,
                            nombre: itemnombre[0],
                            talla: itemtalla,
                            color: itemcolor,
                            precio: itemprecio
                        }),
                        success: function(result){
                            //alert(result);
                            mostrarCarrito();
                        }
                });            
            } else {
                alert('Ingrese la informacion de forma completa.');
            }
        }
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
    </script>
  </body>
</html>
