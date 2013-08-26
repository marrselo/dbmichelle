<?php
session_start();
//print_r($_SESSION);
$GLOBALS['RUTA_LOCAL']  = "http://209.45.30.34/online/mbapp/mbappvendedoras/mbwebservices/";  // para darle la ruta hasta la carpeta imagenes

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
            break;
        }
    }

}else {
    $var = get_object_vars($_SESSION['productos']);    
    for ($i = 0 ; $i < count($var['Genericos']); $i++) {
        //echo "<br><br><br>".$var['Genericos'][$i]->Itempreciocodigo."_".$_GET['codigo'];
        if($var['Genericos'][$i]->Itempreciocodigo == $_GET['codigo']) {
            $_SESSION['articulo']= array(
                'codigo' => $var['Genericos'][$i]->Itempreciocodigo,
                'nombre' => $var['Genericos'][$i]->Descripcionsubfamilia,
                'linea' => $_GET['linea'],
                'familia' => $_GET['familia'],
                'temporada' => $var['Genericos'][$i]->Caracteristicavalor04,
                'precio' => $var['Genericos'][$i]->Precio
            );
            //print_r($_SESSION['articulo']);
            break;
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
                      <li class='has-sub' ><a href="index.php"><span>OTO&Nacute;O - INVIERNO</span></a>
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
              
              <div id="titulo2">                  
                  <h3 class="articulo-titulo"><?php echo strstr($_SESSION['articulo']['nombre'], $_SESSION['articulo']['codigo'], true); ?></h3>                  
              </div>              
              
              <div class="span5 galeria-items">            
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
              <div class="span6" >

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
                        <!--  onchange="obtenerArticuloTalla()" -->
                          <td style="width: 100%; padding: 5px;" colspan="2">
                              <select class="articulo-color" style="width: 95%" 
                                     
                                      id="colorSelected">
                                  <option value='0'>SELECCIONE COLOR</option>
                              </select>
                          </td>
                      </tr>
                      <tr>
                          <!--onchange="obtenerArticuloCantidad()"-->
                          <td style="width: 100%; padding: 5px;" colspan="2">
                              <select class="articulo-talla" style="width: 95%" 
                                      id="articuloCantidad">
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
                          <td class="tabla-contenido articulo-precio-anterior" style="width: 70%">S/. <?php echo number_format($_SESSION['articulo']['precio'], 2, '.', ','); ?></td>
                      </tr>
                      <tr>
                          <td class="tabla-titulo" style="width: 30%">Precio actual</td>
                          <td class="tabla-contenido articulo-precio-actual" style="width: 70%">S/. <?php echo number_format($_SESSION['articulo']['precio'], 2, '.', ','); ?></td>
                      </tr>
                      <tr>
                          <td class="tabla-titulo" style="width: 30%">Descuento</td>
                          <td class="tabla-contenido articulo-precio-porcentaje" style="width: 70%" >25% Dscto.</td>
                      </tr>
                      <tr style="height: 40px;">
                          <td style="width: 30%"><p class="tabla-total">TOTAL</p></td>
                          <td style="padding-left: 25px;" class="articulo-precio-total">S/. <?php echo number_format($_SESSION['articulo']['precio'], 2, '.', ','); ?></td>
                      </tr>
                      <tr>
                          <td style="width: 100%" colspan="2"><div class="titulo-dorado" onclick="agregarItem()"><p>AGREGAR A LA BOLSA</b></p></div></td>
                      </tr>
                      <tr>
                          <td style="width: 100%" colspan="2"><div id="mensaje-agregado" class="alert" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Aviso:</strong> Articulo agregado a su carrito de compras.
                              </div><!--img src="img/estrellas.jpg" border="0" /--></td>
                      </tr>
                  </table>

              </div>
              <div class="container">

                  <div class="span12" style="border-top: 1px solid #ccc;">
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
            
            $('.producto-foto').html("<a href='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+codProducto+".JPG' rel='lightbox' title='Michelle Belau'><img src='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+codProducto+".JPG' /></a>");
                            
            $('.overview').append("<li><img onclick='cambiarImagen($(this))' src='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+codProducto+".JPG' /></li>");
            $('.overview').append("<li><img onclick='cambiarImagen($(this))' src='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+codProducto+"1.JPG' /></li>");
            $('.overview').append("<li><img onclick='cambiarImagen($(this))' src='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+codProducto+"2.JPG' /></li>");
            
            $('#mensaje-agregado').css('display','none');   
            
            //$('#slider1').tinycarousel({ interval: true });
                        
            obtenerArticulo(codProducto);
            //obtenerPrecioArticulo(codProducto);
            obtenerCombinaciones(codProducto);
            
            //mostrarCarrito();
        });
        function agregarItem() {
            if( $('.articulo-color').val() != 0 && $('.articulo-talla').val() != 0 && $('.articulo-cantidad').val()>0 ) {
                
                $('#mensaje-agregado').css('display','block');                
                
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
                            //mostrarCarrito();
                            //$('#mensaje-agregado').css('display','none');                
                            $('.cantidad-carrito').text("CART ("+result+" Items)");
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