<?php session_start(); require_once('functions/core.php'); 
$fichero = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="css/web.css" />
<!--        <link href="css/custom-theme/jquery-ui-1.10.3.custom.css" rel="stylesheet">-->
        <title>Michelle Belau</title>
        <script type="text/javascript" src="js/jquery-1.4.4.js"></script>
<!--        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>-->
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
                                    <br />
<!--                                    <h3 class="coronitas">Consulta tus coronitas VIP</h3>-->
<!--                                    <h3 class="ingresa">Ingresa tu código VIP o DNI</h3>-->
                                        <?php  echo titles($fichero) ?>
                                         
                                </div>
                                <div class="contenido">
                                    
                                    <div class="documento">
                                       <div class="boton">
                                            <img alt="" src="images/carnetextranjeria.png" 
                                                 class="transparente" value="E"/>
                                        </div>
                                        <div class="boton">
                                            <img alt="" src="images/dni.png" 
                                                  class="transparente" value="D"/>
                                        </div>
                                          <img src="images/aceptar.png" width="156"
                                             value="aceptar" id="aceptar"/>
                                    </div>
                                    <div class="codigos">
                                         <h4>Número de Documento</h4>
                                          <input type="text" id="numerodocumento" size="28"  />
                                    </div>
                                    <br /> <br /> <br />
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
        
<div id="cargando" class="cargando" ></div>
<div id="fondonormal" class="fondonormal">
   <img src="img/loading3.gif" /><p> Cargando...</p>
</div>

<div id="fade" class="overlay"></div>
<div id="light" class="modal2">
    <div style="position: absolute; float: right; right: 20px; padding: 5   px; cursor: pointer; z-index: 999;" 
         onclick="ocultarModal('true')">x</div>    
    <div style="margin-left:auto; margin-right:auto;position: relative; float: left; width: 100%; padding: 15px 0; color: #fff;" align="center">
        <p>
            <b style="font: normal 20px Verdana;">
            <span id="nombrecliente">Juana Perez Perez</span>
            <br/>
            <span >es cliente VIP</span>
            </b>
        </p>      
    </div>
</div>
<div id="light_novip" class="modal">
    <div style="position: absolute; float: right; right: 20px; padding: 5px; cursor: pointer; z-index: 999;" 
         onclick="ocultarModal('')">x</div>
    <div style="position: relative; float: left; width: 100%; padding: 0px 0;">        
    </div>
    <div style="margin-left:auto; margin-right:auto;position: relative; float: left; width: 100%; padding: 15px 0; color: #fff;" align="center">
        <br /><br />
        <b style="font: normal 20px Verdana;">
            
        <span id="nombrecliente">Ud. no se encuentra asociada(o) a la tarjeta de Coronitas. Por favor, contactenos al telefono 
            (01)7022777 anexo 111 o envienos un correo a: tarjetavip@michellebelau.com . Muchas gracias
        </span>
        </b>
        
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
            $('#aceptar').click(function () {
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
	
        function login(){
            $('#cargando').css('display','block');
            $.ajax({
                type: "POST",
                url: "admin/controlador/usuario.con.php?f=loginweb",
                dataType: 'json',
                data: ({
                    dni : $('#numerodocumento').val()
                }),
                success: function(result){
                    //alert(result);
                    $('#cargando').css('display','none');
                    //$('#fondonormal').css('display','none');
                    var json2 = eval(result);
                    var vip = 'false';
                    //alert(json2);
                    if(json2 != null){
                        $.each(json2, function(i, item){                                                                                 
                            vip = item.cliente_vip;						
                            if(vip=='true'){
                                 $('#nombrecliente').text(item.nombre);                                
                            }else{
                                $('#nombrecliente').text(item.nombre+" \n\
                     no es cliente VIP");                              
                            }   
                            mostrarModal(vip);
                        });
                    } else {
                         mostrarModal('');                               
                        $('#idcliente').val('');                       
                    }
                },
                error: function(d,e){
                        //alert(e);
                }
            });
        }   
        
        function mostrarModal(vip){
            document.getElementById('fade').style.display='block';
            if(vip != ''){
                document.getElementById('light').style.display='block';
            }else{
                document.getElementById('light_novip').style.display='block';
            }
	}
    
	function ocultarModal(vip){
            document.getElementById('fade').style.display='none';
            if(vip!=''){                
                    document.getElementById('light').style.display='none';
            }else{
                    document.getElementById('light_novip').style.display='none';                                            
            }
        }
         
    </script>
    </body>
</html>