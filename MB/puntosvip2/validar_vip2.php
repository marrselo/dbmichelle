<?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Tarjetas Vip | Michelle Belau</title>
    <link href="css/estilos.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.4.4.js"></script>
    <script type="text/javascript" >
        $(document).ready(function(){
            $('.reglamento img').click(function () {
                if($(this).attr('value') != 'numero') {
                    $('.reglamento img').addClass('transparente');
                    $('.reglamento img').removeClass('seleccionado');
                    $(this).removeClass('transparente'); 
                    $(this).addClass('seleccionado'); 
                    $('#msj-error').html('');
                }
            });
            $('.fotos img').click(function () {
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
                                 $('#nombrecliente').text(item.nombre+" es cliente VIP");                                
                            }else{
                                $('#nombrecliente').text(item.nombre+" no es cliente VIP");                              
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
</head>

<body>

<div id="cargando" class="cargando" ></div>
<div id="fondonormal" class="fondonormal">
   <img src="img/loading3.gif" /><p> Cargando...</p>
</div>

<div id="fade" class="overlay"></div>
<div id="light" class="modal">
    <div style="position: absolute; float: right; right: 20px; padding: 5   px; cursor: pointer; z-index: 999;" 
         onclick="ocultarModal('true')">x</div>    
    <div style="position: relative; float: left; width: 100%; padding: 15px 0; color: #fff;">
        <p>
            <b style="font: normal 20px Verdana;">
            <span id="nombrecliente">Juana Perez Perez</span></b>
        </p>      
    </div>
</div>
<div id="light_novip" class="modal">
    <div style="position: absolute; float: right; right: 20px; padding: 5   px; cursor: pointer; z-index: 999;" 
         onclick="ocultarModal('')">x</div>
    <div style="position: relative; float: left; width: 100%; padding: 0px 0;">        
    </div>
    <div style="position: relative; float: left; width: 100%; padding: 15px 0; color: #fff;">
        <br /><br />
        <b style="font: normal 20px Verdana;">
            
        <span id="nombrecliente">Ud. no se encuentra asociada(o) a la tarjeta de Coronitas. Por favor, contactenos al telefono 
            (01)7022777 anexo 111 o envienos un correo a info@michellebelau.com. Muchas gracias
        </span>
        </b>
        
    </div>
</div>
<div id="conte">
<div id="conte1">

	<div id="linea"></div>

	<div id="cabecera">
            <div class="logo">
                <img src="img/michelle.jpg" width="240" />
            </div>
            <div class="social">
                <p align="center">
                <a href="https://www.facebook.com/michellebelau" title="facebook"><img src="img/facebook.jpg" title="Facebook" alt="Facebook" /></a>
                <a href="http://www.michellebelau.com/es/twitter" title="twitter"><img src="img/twitter.jpg" title="Twitter" alt="Twitter" /></a>
                <a href="http://www.michellebelau.com/es/credit-card" title="coronita"><img src="img/icono3.jpg" /></a>
                <a href="http://www.youtube.com/channel/UCXxb52AXcva5ZQQtPFtPjcw?feature=mhee" title="youtube"><img src="img/youtube.jpg" title="YouTube" alt="YouTube" /></a>
                <a href="http://www.linkedin.com/" title="linkid"><img src="img/icono2.jpg" /></a>
                </p>
            </div>
	</div>

	<div id="menutop">
		<?php include("menu.html");?>
	</div>
	
	<div id="barra">
		
            <h3><img src="img/princess.jpg" border="0" /></h3><br />
            <h3><img src="img/consultaclientes.jpg" border="0" /></h3>
            <div class="right_form">                        
                <div class="reglamento" style="width: 220px;">
                    <img src="img/carnetextranjeria.png" value="carnet" border="0" class="transparente" /><br /><br />
                    <img src="img/dni.png" border="0" value="dni" class="transparente" /><br /><br />
                    <img src="img/numerodocumento.png" value="numero" border="0" style="opacity:1 !important;" /><br /><br />
                    <input type="text" id="numerodocumento" size="28"  />
                    <br /><br />
                    <div style="display: inline; color: #f00; width: 100%;  ">
                        <p id="msj-error" style="margin: 0px; padding: 0px;"> </p>
                    </div>
                </div>
                <div class="fotos" style="margin-left: 150px; width: 180px;">              
                    <img src="img/aceptar.png" value="aceptar" border="0" width="156" />
                </div>
           </div>
                        
            <div class="premio"><img src="img/premio.png" border="0" /></div>
            
            <div style="float: left; height: 100px; width: 100%; text-align: center; ">
                <img src="img/lema1.png" border="0" />
            </div>
	</div>	
	
    <div id="pie">
    
    <div class="pie-menu">
        <?php include("menupie.html");?>
    </div>           

    </div>
	
</div>
</div>

</body>
</html>
