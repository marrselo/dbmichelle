<?php session_start();
$fichero = basename($_SERVER['PHP_SELF']);
$arrayMenu = array(
    'beneficios_tarjeta.php' => 'img/beneficios_tarjeta_1.jpg'
    , 'puntosvip.php' => 'img/consultas_coronitas.jpg'
    , 'preguntas_frecuentes.php' => 'img/preguntas_frecuentes.jpg'
    , 'catalogodetalle.php' => 'images/catalogo_coronitas.jpg');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="css/web.css" />
        <link href="css/custom-theme/jquery-ui-1.10.3.custom.css" rel="stylesheet">
        <title>Michelle Belau</title>
        <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
    </head>
    <body>
        <div class="web_seccion">
            <div class="web_fondo1">
                <div class="web_alineacion">
                    <div class="web_cabecera">
                        <?php include("header.php"); ?>
                    </div>
                    <div class="web_principal">
                        <div class="web_columna1">
                            <div class="consulta">
                                <div class="titulo">
                                    <h3 class="princess">Michelle Belau</h3>
                                    <h3 class="coronitas">Consulta tus coronitas VIP</h3>
                                    <h3 class="ingresa">Ingresa tu código VIP o DNI</h3>
                                </div>
                                <div class="contenido">
                                    <div class="codigos">
                                        <img src="images/uno.png" width="50" 
                                             value="1" border="0" width="50" />
                                        <img src="images/dos.png" width="50" 
                                             value="2" border="0" width="50" />
                                        <img src="images/tres.png" width="50" 
                                             value="3" border="0" width="50" />
                                        <img src="images/cuatro.png" width="50" 
                                             value="4" border="0" width="50" />
                                        <img src="images/cinco.png" width="50" 
                                             value="5" border="0" width="50" />
                                        <img src="images/seis.png" width="50" 
                                             value="6" border="0" width="50" />
                                        <img src="images/siete.png" width="50" 
                                             value="7" border="0" width="50" />
                                        <img src="images/ocho.png" width="50" 
                                             value="8" border="0" width="50" />
                                        <img src="images/nueve.png" width="50" 
                                             value="9" border="0" width="50" />
                                        <img src="images/cero.png" width="50" 
                                             value="0" border="0" width="50" />
                                        <img src="images/limpiar.png" width="104" 
                                             height="41" value="limpiar"/>
                                        <img src="images/aceptar.png" width="156"
                                             value="aceptar" id="aceptar"/>
                                    </div>
                                    <div class="documento">
                                        <div class="boton">
                                            <img alt="" src="images/carnetextranjeria.png" 
                                                 class="transparente" value="E"/>
                                        </div>
                                        <div class="boton">
                                            <img alt="" src="images/dni.png" 
                                                  class="transparente" value="D"/>
                                        </div>
                                        <h3>Número de Documento</h3>
                                        <input type="text" name="nd" id="numerodocumento"  />
                                        <div style="display: inline; color: #f00; width: 100%;  ">
                                            <p id="msj-error" style="margin: 0px; padding: 0px;"> </p>
                                        </div>
                                    </div>
                                    <?php include('enlaces.php') ?>
                                    <br />
                                    <div class="lema"><h3>lema</h3></div>
                                </div>
                            </div>
                        </div><br />
                    </div>
                </div>
            </div>
            <div class="web_fondo2">
                <div class="web_alineacion">
                    <div class="web_pie">
                        <div class="menu">
                            <ul>
                                <li><a href="#">Términos y/o condiciones de uso</a></li>
                                <li>|</li>
                                <li><a href="#">Copyright 2012 todos los derechos reservados</a></li>
                                <li>|</li>
                                <li><a href="#">Trabaja con Nosotros</a></li>
                                <li>|</li>
                                <li><a href="#">Registrate como cliente</a></li>
                            </ul><br />
                        </div>
                        <div class="premio"> 
                            <img alt="" src="images/premio.png" /> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/menu_horizontal.js"></script>
         <script type="text/javascript" >
        $(document).ready(function(){ 
            $('.documento img').click(function () {
                if($(this).attr('value') != 'numero') {
                    $('.documento img').addClass('transparente');
                    $('.documento img').removeClass('seleccionado');
                    $(this).removeClass('transparente'); 
                    $(this).addClass('seleccionado'); 
                    $('#msj-error').html('');
                }
            });
            $('.codigos img').click(function () {
                if($('#numerodocumento').val().length < 12 && parseInt($(this).attr('value'))>=0 ) {
                    var texto = $('#numerodocumento').val() + $(this).attr('value');
                    $('#numerodocumento').val(texto);
                    $('#msj-error').html('');
                }
                if($(this).attr('value')=='limpiar')
                {
                    $('#numerodocumento').val('');
                }
                else if($(this).attr('value')=='aceptar')
                {
                    if($('.seleccionado').size()==0) {
                        $('#msj-error').html('Por favor seleccione Carnet de Extranjeria o DNI');
                    } else if($('#numerodocumento').val().length <=5) {
                        $('#msj-error').html('Numero de documento no valido');
                    } else {
                        //alert($('#numerodocumento').val());
                        login();
                    }
                }
            });
        });
	function mostrarModal(vip){
             var divModal = 'light_novip';
             if(vip!=''){
                 divModal='light';
             }
           
             $('#'.divModal).dialog({
                        width: 580,
			height: 580,
			modal: true
		});           
	}
        function login(){
                   
           // $('#cargando').css('display','block');    
            $('#light_novip').dialog({
                        width: 580,
                        height: 580,
                        modal: true
                });  
            $.ajax({
                type: "POST",
                url: "../mbpuntos/admin/controlador/usuario.con.php?f=loginweb",
                dataType: 'json',
                
                data: ({
                    dni : $('#numerodocumento').val(),
                    tipo: $('.seleccionado').attr('value')
                }),
                success: function(result){
                    alert(result);
                    //$('#cargando').css('display','none');
                    //$('#fondonormal').css('display','none');
                    var json2 = eval(result);
                    var vip = 'false';
                    //alert(json2);
                    if(json2 != null){
                        $.each(json2, function(i, item){
                            $('#nombrecliente').text(item.nombre);
                            $('#puntosacumulados').text(item.coronitas);
                            $('#puntosporvencer').text(item.coronitas_vencer);
                            vip = item.cliente_vip;
                                                        
                            if(vip=='true'){
                                $('#light').dialog({
                                        width: 580,
                                        height: 580,
                                        modal: true
                                }); 
                            }
                            else{ 
                               // mostrarModal('');                               
                                $('#light_novip').dialog({
                                        width: 580,
                                        height: 580,
                                        modal: true
                                }); 
                                $('#idcliente').val('');
                            }
                        });
                    } else {   
                        alert("asdasddsa");
                        $('#light_novip').dialog({
                                        width: 580,
                                        height: 580,
                                        modal: true
                                });                               
                        $('#idcliente').val('');                                                
                    }
                },
                error: function(d,e){
                
                       // alert(e);
                }
            });
        }   
    </script>





<div id="light" title="Consulta tus coronitas">
    <div style="position: relative; float: left; width: 100%; padding: 0px 0;">
        <img src="img/logotarjeta.png" border="0" />
    </div>
    <div style="position: relative; float: left; width: 100%; padding: 15px 0; color: #fff;">
        <p><b>Documento de Identidad: </b><b style="font: normal 20px Verdana;">
                <span id="nombrecliente">Juana Perez Perez</span></b></p>
        <p><b>Puntos por canjear: </b><b style="font: normal 20px Verdana;">
                <span id="puntosacumulados">200</span> pts</b>
        </p>
        <p><b>Puntos acumulados:  </b><b style="font: normal 20px Verdana;">
                <span id="puntosporvencer">200</span> pts</b></p>

    </div>
</div>
    <div id="light_novip" class="modal" title="Consulta tus coronitas">           
        <div style="position: relative; float: left; width: 100%; padding: 15px 0; color: #fff;">
            <br /><br />
            <b style="font: normal 20px Verdana;">

            <span id="nombrecliente">Ud. no se encuentra asociada(o) a la tarjeta de Coronitas. Por favor, contactenos al telefono 
                (01)7022777 anexo 111 o envienos un correo a info@michellebelau.com. Muchas gracias
            </span>
            </b>

        </div>
    </div>


    </body>
</html>