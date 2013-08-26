<?php
session_start();
$_SESSION['linea']=$_GET['idLinea'];
$_SESSION['familia']=$_GET['idFamilia'];

if (isset($_GET['idTemporada'])) {
    $_SESSION['coleccion'] = $_GET['idTemporada'];
} else {
    if (!isset($_SESSION['coleccion']))
        $_SESSION['coleccion'] = 2;
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
    <link rel="shortcut icon" href="ico/favicon.ico">
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
                  <li class='has-sub' >
                      <a href="index.php?coleccion=2&idLinea=<?php echo $_SESSION['linea']; ?>&idFamilia=<?php echo $_SESSION['familia']; ?>">
                          <span>OTOÑO - INVIERNO</span>
                      </a>
                      <ul class="menu-items menu-items-1">
                          <div class="linea"></div>
                          <li><a href="#"><span>Cargando ... </span></a></li>
                      </ul>
                  </li>
                  <li class='has-sub'><a href="index.php?coleccion=3&idLinea=<?php echo $_SESSION['linea']; ?>&idFamilia=<?php echo $_SESSION['familia']; ?>"><span>PRIMAVERA - VERANO</span></a>
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
              <a href="carritocompras.php"><img src="img/ico-sh-plomo.png" border="0" /> CART (<?php echo count($_SESSION['carrito'])." items"; ?>)</a>
          </div>
          
      </div>

      <div class="row-fluid">
          
          <div class="span4" style="border-right: 1px solid #ccc;">              
              <div id="sub-menu">
                  <p class="sub-menu-temporada"></p>
                  <p class="sub-menu-titulo"></p>
                  <ul class="sub-menu-items">
                  </ul>
              </div>             
              <div style="float: right;"><a style="text-align: left;" href="#" class="btn1" data-toggle="popover" data-placement="left" data-content="Cargando ..." title="Buscador">&nbsp;</a></div>
              <?php //include 'menulateral.php'; ?>
          </div>

          <div class="span8 galeria-items">
              <div id="titulo"><h3><span class="titulo-clase">TEXTIL</span> : <span class="titulo-familia">ABRIGO</span></h3></div>
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
            var idLinea = '<?php echo $_GET['linea']; ?>';
            var idTemporada = '<?php echo $_GET['temporada']; ?>';
            var articuloBuscar = '<?php echo $_GET['texto']; ?>';

            obtenerLineas();
            
            if( articuloBuscar.length >= 3 ) {                
                obtenerClasesPorLinea(idTemporada,'01');
                $('#texto-buscar').val(articuloBuscar);                
                buscar();
            }
            else{                
                obtenerClasesPorLinea(idTemporada,idLinea);
                if(typeof idLinea === 'undefined' || !idLinea || typeof idTemporada === 'undefined' || !idTemporada ) {     
                    
                }
                else{
                    //obtenerClasesPorLinea(idLinea);
                }
            }
            $(".btn1").popover();
        });
    
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
            var idTemporada = '<?php echo $_GET['temporada']; ?>';
            $(".btn1").popover('show');
            if($('#texto-buscar').val().length < 3) { 
                alert('Por favor, ingrese el nombre del producto que desea buscar.'); 
            }
            else{        
                if(typeof idTemporada === 'undefined' || !idTemporada ) {
                    $(".menu-items").find('a:first').click();
                }
                else{
                    obtenerProductosPorNombre(idTemporada,$('#texto-buscar').val());
                }
            }
        }
    </script>
  </body>
</html>
