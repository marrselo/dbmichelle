<?php
session_start();
$_SESSION['coleccion']=2;
$_SESSION['linea']=$_GET['idLinea'];
$_SESSION['familia']=$_GET['idFamilia'];

if($_GET['coleccion']) {
    $_SESSION['coleccion']=$_GET['coleccion'];
}
else {
    $_SESSION['coleccion'];
}
//print_r($_SESSION);
//print_r($_SESSION['productos']);
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
                    background-repeat: no-repeat;"  onkeydown="presionartecla(event)"/> 
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
            
            <!--form class="navbar-form pull-right">
              <input class="span2" type="text" placeholder="Email">
              <input class="span2" type="password" placeholder="Password">
              <button type="submit" class="btn">Sign in</button>
            </form-->
          <!--/div>
          <!--a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Project name</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul-->
            <!--form class="navbar-form pull-right">
              <input class="span2" type="text" placeholder="Email">
              <input class="span2" type="password" placeholder="Password">
              <button type="submit" class="btn">Sign in</button>
            </form-->
          <!--/div></.nav-collapse -->
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
          
        <div class="span9">
            <div id="titulo"><h2>VESTIDO</h2></div>
            <div class="span11" >
                <div style="width: 100%; padding: 10px;">
                    <a href="index.php?idLinea=<?php echo $_SESSION['linea']; ?>&idFamilia=<?php echo $_SESSION['familia']; ?>">[x] Borrar Filtro </a> 
                    <a href="#" id="boton-filtro" onclick="ocultar()">[-] Ocultar Filtro</a>
                </div>
            </div>
            <div class="span9 offset2 listado-colores" style="padding-bottom: 20px;">
                <h4 style="color: #6f643b">COLOR</h4>
                <div id="colores">
                    <a href="#">
                        <div class='redondo' style="background-color: #00f;"></div>
                        <div class='color'>Azul</div>
                    </a>
                </div>
                <div id="colores">
                    <a href="#">
                        <div class='redondo' style="background-color: #eee;"></div>
                        <div class='color'>Blanco</div>
                    </a>
                </div>
                <div id="colores">
                    <a href="#">
                        <div class='redondo' style="background-color: #fff56e;"></div>
                        <div class='color'>Amarillo</div>
                    </a>
                </div>
                <div id="colores">
                    <a href="#">
                        <div class='redondo' style="background-color: #0f0;"></div>
                        <div class='color'>Verde</div>
                    </a>
                </div>
            </div>
        </div>
        <!-- GALERIA DE FOTOS -->
        <div class="span9 galeria-items" style="border-top: 2px solid #aaa;">
            <div id="galeria-productos">
                <a href="articulo.php" >
                    <div class="galeria-imagen">
                        <div class="galeria-foto">
                            <img src="img/cargando.jpg" border="0" title="Michelle Belau" />
                        </div>
                    </div>
                    <div class="galeria-titulo"><p>Cargando<br><b>Galeria</b></p></div>
                </a>
            </div>
        </div>
        
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

    <script type="text/javascript" src="js/operaciones.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
            var color = '<?php echo $_GET['color']; ?>';
            var idLinea = '<?php echo $_GET['idLinea']; ?>';
            var idFamilia = '<?php echo $_GET['idFamilia']; ?>';
            obtenerLineas();
            
            if(color.length>0) {
                obtenerClasesPorLinea(idLinea);
                obtenerProductosPorClaseColor(idLinea, idFamilia, color);
                $('a[linea]').removeClass('menu-seleccionado');
                $('a[linea='+idLinea+']').addClass('menu-seleccionado');

                $('a[familia]').removeClass('sub-menu-seleccionado');
                $('a[familia='+idFamilia+']').addClass('sub-menu-seleccionado');   
                
                obtenerColoresPorLinea( idLinea, idFamilia );
            }
            else if(idLinea.length>0) {
                obtenerClasesPorLinea(idLinea);
                obtenerProductosPorClase(idLinea, idFamilia);
                $('a[linea]').removeClass('menu-seleccionado');
                $('a[linea='+idLinea+']').addClass('menu-seleccionado');

                $('a[familia]').removeClass('sub-menu-seleccionado');
                $('a[familia='+idFamilia+']').addClass('sub-menu-seleccionado');
                
                obtenerColoresPorLinea( idLinea, idFamilia );
            }
            else {
                $('.menu-items li a:first').click();                
                $('#titulo').html('<h2>'+$('.sub-menu-items li a:first').text().toUpperCase() +'</h2>');
                obtenerProductosPorClase($('.menu-items li a:first').attr('linea'), $('.sub-menu-items li a:first').attr('familia'));                
                $('.sub-menu-items li a:first').click();
                //alert($('.menu-items li a:first').attr('linea') + $('.sub-menu-items li a:first').attr('familia'));
                obtenerColoresPorLinea( $('.menu-items li a:first').attr('linea'), $('.sub-menu-items li a:first').attr('familia') );
            }
            
            $('#titulo').html('<h2>'+$("a[class='sub-menu-seleccionado']").text().toUpperCase() +'</h2>');
            
        });
        function ocultar() {
            //$(".span7").css('visibility', "hidden");
            //$('.span7').css({opacity: 0.0, visibility: "hidden"}).animate({opacity: 1.0});
            //$('.drop1').css({opacity: 1.0, visibility: "visibe"}).animate({opacity: 0})}, 200);
            if( $('.listado-colores').hasClass('oculto')==false ) {
                $('.listado-colores').animate({opacity:"hide"});
                $('.listado-colores').addClass('oculto');
                $('#boton-filtro').html('[+] Mostrar Filtro');
            } else {
                $('.listado-colores').animate({opacity:"show"});
                $('.listado-colores').removeClass('oculto');
                $('#boton-filtro').html('[-] Ocultar Filtro');
            }
        }
        function buscar() {
            if($('#texto-buscar').val().length < 3) { 
                alert('Por favor, ingrese el nombre del producto que desea buscar.'); 
            }
            else{
                $('#titulo h2').text('BUSCADOR');
                ocultar();
                obtenerProductosPorNombre($('#texto-buscar').val());
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
