function obtenerLineas() {
    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        async: false,
        data: ({
            metodo: "OBTENERLINEAS"  
        }),
        success: function(result){
            var json2 = eval('('+result+')');
            var texto1 = "";
            var texto2 = "";
            if(typeof json2 != 'undefined') {
                $('.menu-items').html('');
                texto1 = "<div class='linea'></div>";
                texto2 = "<div class='linea'></div>";
                $.each(json2.Clases, function(i, item){ 
                    if(item.Descripcionlocal!="TELAS E HILOS" && item.Descripcionlocal!="AVIOS"
                        && item.Descripcionlocal!="MERCHANDISING" && item.Descripcionlocal!="OFICINA - ADMINISTRACION"
                        && item.Descripcionlocal!="ARTICULOS DE LIMPIEZA" && item.Descripcionlocal!="MATERIALES"
                        && item.Descripcionlocal!="ACTIVOS") {
                        texto1 += "<li><a linea='"+item.Linea+"' href='articulos.php?temporada=3&linea="+item.Linea+"' style='text-transform: capitalize;'>"+item.Descripcionlocal.toLowerCase()+"</a></li>";
                        texto2 += "<li><a linea='"+item.Linea+"' href='articulos.php?temporada=2&linea="+item.Linea+"' style='text-transform: capitalize;'>"+item.Descripcionlocal.toLowerCase()+"</a></li>";
                    }
                });
                $('.menu-items-1').append(texto1);
                $('.menu-items-2').append(texto2);
            }
            else {
            }
        }
    });
}

function obtenerClasesPorLinea(idTemporada,idLinea) {
    // FAMILIAS
    // COLOCO ESTILO SELECCIONADO AL MENU
    //$('menu-items').mouseout();
    //$('.sub-menu-items').find("a[familia='"+idLinea+"']").addClass('sub-menu-seleccionado');
    $('.menu-items').find('a').removeClass('menu-seleccionado');
    //$(".menu-items li a[linea='"+idLinea+"']").addClass('menu-seleccionado');
    // CAPTURAR EL NOMBRE DE LA CATEGORIA SELECCIONADA
    var obj=$(".menu-items li a[linea='"+idLinea+"']");
    var temporada = "";
    if(idTemporada==2) temporada = "PRIMAVERA - VERANO";
    else temporada = "OTOŃO - INVIERNO";
    
    $('.sub-menu-titulo').html( obj[0].innerHTML.toUpperCase() );
    $('.sub-menu-temporada').text( temporada );
    
    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        async: false,
        data: ({
            Linea: idLinea,
            metodo: "OBTENERCLASESPORLINEA"  
        }),
        success: function(result){
            //alert(result);
            var json2 = eval('('+result+')');
            var texto = "";
            
            if(typeof json2 != 'undefined' && json2.Familias!=null) {
                $('.sub-menu-items').html('');
                $.each(json2.Familias, function(i, item){  
                     //texto += "<li><a href='index.php?idTemporada="+idTemporada+"&idLinea="+idLinea+"&idFamilia="+item.Familia+"' familia='"+item.Familia+"' onClick=\"$(this).addClass('sub-menu-seleccionado'); \">"+item.Descripcionlocal.charAt(0).toUpperCase() + item.Descripcionlocal.slice(1).toLowerCase()+"</a></li>";
                     texto += "<li><a href='#' familia='"+item.Familia+"' onclick=\"obtenerProductosPorClase('"+idLinea+"','"+item.Familia+"','"+idTemporada+"')\" >"+item.Descripcionlocal.charAt(0).toUpperCase() + item.Descripcionlocal.slice(1).toLowerCase()+"</a></li>";
                });
                $('.sub-menu-items').append(texto);
                $('.sub-menu-items').find('a').first().click();
            }
            else {         
            }
        }
    });
}

function obtenerClasesPorLinea2(idTemporada,idLinea) {
    // FAMILIAS
    // COLOCO ESTILO SELECCIONADO AL MENU
    //$('menu-items').mouseout();
    //$('.sub-menu-items').find("a[familia='"+idLinea+"']").addClass('sub-menu-seleccionado');
    $('.menu-items').find('a').removeClass('menu-seleccionado');
    //$(".menu-items li a[linea='"+idLinea+"']").addClass('menu-seleccionado');
    // CAPTURAR EL NOMBRE DE LA CATEGORIA SELECCIONADA
    var obj=$(".menu-items li a[linea='"+idLinea+"']");
    var temporada = "";
    if(idTemporada==3) temporada = "OTOŃO - INVIERNO";
    else temporada = "PRIMAVERA - VERANO";
    
    $('.sub-menu-titulo').html( obj[0].innerHTML.toUpperCase() );
    $('.sub-menu-temporada').text( temporada );
    
    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        async: false,
        data: ({
            Linea: idLinea,
            metodo: "OBTENERCLASESPORLINEA"  
        }),
        success: function(result){
            //alert(result);
            var json2 = eval('('+result+')');
            var texto = "";
            
            if(typeof json2 != 'undefined' && json2.Familias!=null) {
                $('.sub-menu-items').html('');
                $.each(json2.Familias, function(i, item){  
                     //texto += "<li><a href='index.php?idTemporada="+idTemporada+"&idLinea="+idLinea+"&idFamilia="+item.Familia+"' familia='"+item.Familia+"' onClick=\"$(this).addClass('sub-menu-seleccionado'); \">"+item.Descripcionlocal.charAt(0).toUpperCase() + item.Descripcionlocal.slice(1).toLowerCase()+"</a></li>";
                     texto += "<li><a href='#' familia='"+item.Familia+"' onclick=\"obtenerProductosPorClase('"+idLinea+"','"+item.Familia+"','"+idTemporada+"')\" >"+item.Descripcionlocal.charAt(0).toUpperCase() + item.Descripcionlocal.slice(1).toLowerCase()+"</a></li>";
                });
                $('.sub-menu-items').append(texto);
                //$('.sub-menu-items').find('a').first().click();
            }
            else {         
            }
        }
    });
}


function obtenerProductosPorClase(idLinea, idFamilia, idTemporada) {
    var temporada = "";
    if(idTemporada==3) temporada = "OTOŃO - INVIERNO";
    else temporada = "PRIMAVERA - VERANO";
    $('.sub-menu-temporada').text( temporada );
    
    $('.sub-menu-items').find("a").removeClass('sub-menu-seleccionado');
    $('.sub-menu-items').find("a[familia='"+idFamilia+"']").addClass('sub-menu-seleccionado');
    
    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        data: ({
            Familia: idFamilia,
            Linea: idLinea,
            ColeccionID: idTemporada,
            metodo: "OBTENERPRODUCTOSGENERICOS"  
        }),
        success: function(result){
            //alert(result);
            var json2 = eval('('+result+')');
            var texto = "";
            
            if(typeof json2 != 'undefined' && json2.Genericos!=null ) {
                $('.galeria-items').html('');
                texto += "<div id='titulo'><h3><span class='titulo-clase'>"+$('.sub-menu-titulo').text()+
                        "</span> : <span class='titulo-familia'>"+$(".sub-menu-seleccionado").text().toUpperCase()+"</span></h3></div>";
                $.each(json2.Genericos, function(i, item){  
                    texto += "<div id='galeria-productos'>" +
                        "<a href='articulo.php?codigo="+item.Itempreciocodigo+"&linea="+idLinea+"&familia="+idFamilia+"' >" +
                        "    <div class='galeria-imagen'>" +
                        "        <div class='galeria-foto'>" +
                        "            <img src='http://209.45.30.34/imagenes/fotos/"+item.Caracteristicavalor04+"/"+idLinea+"/"+idFamilia+"/"+item.Itempreciocodigo+".JPG' />" +
                        "        </div>" +
                        "    </div>" +
                        "    <div class='galeria-titulo'><p>"+item.Descripcionsubfamilia.substring(0, item.Descripcionsubfamilia.length-9)+"<br><b>S/. "+decimales(item.Precio,2)+"</b></p></div>" +
                        "</a></div>";
                    //texto += "<li><a href='#' onClick=\"obtenerProductosPorClase(\'"+idLinea+"\',\'"+item.Familia+"\'); $(this).addClass('sub-menu-seleccionado'); \">"+item.Descripcionlocal.charAt(0).toUpperCase() + item.Descripcionlocal.slice(1).toLowerCase()+"</a></li>";
                });
                $('.galeria-items').append(texto);
            }
            else {                                
                $('.galeria-items').html('');
                texto += "<div id='titulo'><h3><span class='titulo-clase'>"+$('.sub-menu-titulo').text()+
                        "</span> : <span class='titulo-familia'>"+$(".sub-menu-seleccionado").text().toUpperCase()+"</span></h3>"+
                        "<img src='img/muypronto.png' border='0' /></div>";
                $('.galeria-items').append(texto);
            }
        }
    });
}

function obtenerProductosPorNombre(idTemporada, cadena) {
    var temporada = "";
    if(idTemporada==3) temporada = "OTOŃO - INVIERNO";
    else temporada = "PRIMAVERA - VERANO";
    $('.sub-menu-temporada').text( temporada );
    // OCULTO LA PORTADA Y MUESTRO EL CATALOGO
    $('.row-fluid').css('display','block');
    $('.portada').css('display','none');
    // FAMILIAS
    $('.sub-menu-items').find('a').removeClass('sub-menu-seleccionado');
    
    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        data: ({
            ColeccionID: idTemporada,
            Cadena: cadena,
            metodo: "OBTENERPRODUCTOSGENERICOSPORNOMBRE"  
        }),
        success: function(result){
            //alert(result);
            var json2 = eval('('+result+')');
            var texto = "";
            
            if(typeof json2 != 'undefined' && json2.Genericos!=null) {
                $('.galeria-items').html('');
                texto += "<div id='titulo'><h3><span class='titulo-clase'>BUSCADOR"+
                        "</span> : <span class='titulo-familia'>ARTICULOS</span></h3></div>";
                $.each(json2.Genericos, function(i, item){  
                    texto += "<div id='galeria-productos'>" +
                        "<a href='articulo.php?codigo="+item.Itempreciocodigo+"&linea="+item.Linea+"&familia="+item.Familia+"' >" +
                        "    <div class='galeria-imagen'>" +
                        "        <div class='galeria-foto'>" +
                        "            <img src='http://209.45.30.34/imagenes/fotos/"+item.Caracteristicavalor04+"/"+item.Linea+"/"+item.Familia+"/"+item.Itempreciocodigo+".JPG' />" +
                        "        </div>" +
                        "    </div>" +
                        "    <div class='galeria-titulo'><p>"+item.Descripcionsubfamilia.substring(0, item.Descripcionsubfamilia.length-9)+"<br><b>S/. "+decimales(item.Precio,2)+"</b></p></div>" +
                        "</a></div>";
                    //texto += "<li><a href='#' onClick=\"obtenerProductosPorClase(\'"+idLinea+"\',\'"+item.Familia+"\'); $(this).addClass('sub-menu-seleccionado'); \">"+item.Descripcionlocal.charAt(0).toUpperCase() + item.Descripcionlocal.slice(1).toLowerCase()+"</a></li>";
                });
                $('.galeria-items').append(texto);
                $(".btn1").popover('hide');
            }
            else {
                $('.galeria-items').html('');
                texto += "<div id='titulo'><h3><span class='titulo-clase'>BUSCADOR"+
                        "</span> : <span class='titulo-familia'>ARTICULOS</span></h3>"+
                        "<img src='img/muypronto.png' border='0' /></div>";
                $('.galeria-items').append(texto);
            }
        }
    });
}
function obtenerArticulo(codProducto) {
    //$('.sub-menu-items').find('a').removeClass('sub-menu-seleccionado');
    // OCULTO LA PORTADA Y MUESTRO EL CATALOGO
    $('.row-fluid').css('display','block');
    $('.portada').css('display','none');
    // ES NECESARIO QUE SEA SINCRONO YA QUE CARGA TODA LA INFO DEL PRODUCTO EN json_producto
    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        async: false,
        data: ({
            codigo: codProducto,
            metodo: "OBTENERPRODUCTOSESPECIFICOS"  
        }),
        success: function(result){
            //alert(result);
            var json2 = eval('('+result+')');            
            if(typeof json2 != 'undefined') {
                //alert(result);
                json_producto = json2;
                //$.each(json_producto.Especificos, function(i, item){
                    //alert(item.Descripcioncompleta);
                    //texto = item.Descripcioncompleta.split($('#codigo').val());
                    
                    //$('.articulo-titulo').text(texto[0]);
                    //$('.articulo-detalle').text(item.Descripcioncompleta);
                //});
            }
        }
    });
    
    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        data: ({
            codigo: codProducto,
            metodo: "OBTENERSTOCKGENERAL"  
        }),
        success: function(result){
            //alert(result);
            var json2 = eval('('+result+')');
            if(typeof json2 != 'undefined') {
                json_stocks = json2;
                //
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        data: ({
            codigo: codProducto,
            linea: $('#linea').val(),
            lineafamilia: $('#linea').val()+$('#familia').val(),
            temporada: $('#caracteristica').val(),
            metodo: "DESCUENTO"  
        }),
        success: function(result){
            //alert(result);
            var json2 = eval('('+result+')');
            if(typeof json2 != 'undefined') {
                //json_stocks = json2.Descuento;
                var precio_final = parseFloat(json_articulo.precio)+0.00;
                precio_final -= json2.Descuento;
                $('.articulo-precio-actual').text("S/. "+decimales(precio_final,2));
                $('.articulo-precio-total').text("S/. "+decimales(precio_final,2));
                json_articulo.precio=precio_final;
                
                var porcentaje = (((json2.Descuento * 100)/json_articulo.precio)*100)/100;
                $('.articulo-precio-porcentaje').text(porcentaje.toString()+"% Dscto.");
            }
        }
    });

    // CARGO LAS IMAGENES DE COLORES AHORA POR QUE YA CARGO EL COMBOBOX
    obtenerArticuloColor();
}
function obtenerArticuloColor(){
    var colores = new Array();
    $('.articulo-color').html('');
    $('.articulo-color').html("<option value='0'>SELECCIONE COLOR</option>");
    $('.articulo-talla').html('');
    $('.articulo-talla').html("<option value='0'>SELECCIONE TALLA</option>");
    $('.articulo-cantidad').html('');
    $('.articulo-cantidad').html("<option value='0'>SELECCIONE CANTIDAD</option>");
    
    if(typeof json_producto != 'undefined') {
        
        $.each(json_producto.Especificos, function(i, item){  
            //alert(item.Color);
            if(jQuery.inArray(item.Color, colores)<0) { 
                colores.push(item.Color);
                $('.articulo-color').append("<option value='"+item.Color+"'>"+item.ColorDesc+"</option>");
            }
        });
    }
   // alert($('#linea').val());
   // alert($('#familia').val());
    var url = "http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+$('#codigo').val()+".JPG"
    url = url.substring(0,(url.length)-4);
    
    $('.articulo-color option').each(function () {
        if($(this).val().length == 3) {
            var color = $(this).val(); 
            
            $.ajax({
                type: "POST",
                url: "operaciones.php",
                async: false,
                data: ({
                    path: url+$(this).val()+'.JPG',
                    metodo: "OBTENERIMAGENESCOLORES"  
                }),
                success: function(result){                    
                    if(parseInt(eval(result))>0) {
                        $('.overview').append("<li><img onclick='cambiarImagen($(this))' src='http://209.45.30.34/imagenes/fotos/"+$('#caracteristica').val()+"/"+$('#linea').val()+"/"+$('#familia').val()+"/"+$('#codigo').val()+color+".JPG' /></li>");
                    }
                }
            });
        
        }
    });

    $('#slider1').tinycarousel({ interval: true });
}

function obtenerArticuloTalla(){
    var tallas = new Array();           
    $('.articulo-talla').html('');
    $('.articulo-talla').html("<option value='0'>SELECCIONE TALLA</option>");
    $('.articulo-cantidad').html('');
    $('.articulo-cantidad').html("<option value='0'>SELECCIONE CANTIDAD</option>");
    if(typeof json_producto != 'undefined') {
        
         $.each(json_producto.Especificos, function(i, item){  
            //alert(item.Color);
            if(jQuery.inArray(item.Talla, colores)<0) { 
                colores.push(item.Color);
                $('.articulo-color').append("<option value='"+item.Talla+"'>"+item.ColorDesc+"</option>");
            }
        });
        // RECORRE EL ARRAY EN MEMORIA Y VERIFICA QUE NO ESTE EN LA PILA (TALLA)
        // YA QUE SOLO DEBO MOSTRAR LAS TALLAS SIN REPETIDOS        
//        $.each(json_producto.Especificos, function(i, item){
            //alert(json_producto.Especificos.Color);
//            if(item.Color==$('.articulo-color').val()) {
//                if(jQuery.inArray(item.Talla, tallas)<0) { 
//                    //alert(item.Talla);
//                    tallas.push(item.Talla);
//                    $('.articulo-talla').append("<option value='"+item.Talla+"'>"+item.TallaDesc+"</option>");
//                }
//            }
//        });
    }    
}
function obtenerArticuloCantidad(){        
    var constock = false;
    $('.articulo-cantidad').html('');
    $('.articulo-cantidad').html("<option value='0'>SELECCIONE CANTIDAD</option>");
    if(typeof json_stocks != 'undefined') {
        $.each(json_stocks.StockLocal, function(i, item){
//            alert(json_stocks.StockLocal);
            if(item.Colorcodigo==$('.articulo-color').val() 
                    && item.Tallacodigo==$('.articulo-talla').val()) { 
                if(parseInt(item.Stockdisponible)>0) {
                    constock = true;
                    for(var x=1; x<=(item.Stockdisponible/100); x++) {
                        $('.articulo-cantidad').append("<option value="+x+">"+x+"</option>");
                    }
                }
            }
        });
        if(!constock) {
            $('.articulo-cantidad').html('');
            $('.articulo-cantidad').html("<option value='0'>TEMPORALMENTE AGOTADO</option>");            
        }
    }    
}
function obtenerCombinaciones(codProducto) {
    $('.combionaciones-item').html('');
    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        data: ({
            codigo: codProducto,
            metodo: "OBTENERCOMBINACIONES"  
        }),
        success: function(result){
            var json2 = eval('('+result+')');
            var texto = "";
            if(typeof json2 != 'undefined') {
                json_combinaciones = json2;
                
                $.each(json2.Combinaciones, function(i, item){
                    //alert(item.Itempreciocodigo);
                    if(i <= 13) { 
                        texto += "<a href='articulo.php?enlace=1&codigo="+item.Itempreciocodigo+"&linea="+item.Codigolinea+"&familia="+item.Codigofamilia+"'><img src='http://209.45.30.34/imagenes/fotos/"+item.Codigotemporada+"/"+item.Codigolinea+"/"+item.Codigofamilia+"/"+item.Itempreciocodigo+".JPG' width='50' border='0' /></a>";
                    }
                });
                
                $('.combionaciones-item').append(texto);
            }
            else {
            }
        }
    });
}
function cambiarImagen(objeto) {
    $('.producto-foto').fadeOut("100", function () {
        $('.producto-foto').html("<a href='"+objeto.attr('src')+"' rel='lightbox' title='Michelle Belau' ><img src='"+objeto.attr('src')+"' />").fadeIn('100');
    });
}
function decimales(Numero, Decimales) {
    var pot = Math.pow(10, Decimales);
    var num = parseInt(Numero * pot) / pot;
    var nume = num.toString().split('.');
 
    var entero = nume[0];
    var decima = nume[1];
 
    var fin;
    if (decima != undefined) {
        fin = Decimales - decima.length;
    }
    else {
        decima = '';
        fin = Decimales;
    }
 
    for (i = 0; i < fin; i++)
        decima += String.fromCharCode(48);
 
    var buffer = "";
    var marca = entero.length - 1;
    var chars = 1;
    while (marca >= 0) {
        if ((chars % 4) == 0) {
            buffer = "." + buffer;
        }
        buffer = entero.charAt(marca) + buffer;
        marca--;
        chars++;
    }
    if (decima != '')
        num = buffer + ',' + decima;
    else
        num = buffer;
    return num;
}
function buscarCliente() {
    //$('.combionaciones-item').html('');
    if( $('#documento').val().length > 4 ) {
        $.ajax({
            type: "POST",
            url: "operaciones.php",
            dataType: 'json',
            data: ({
                documento: $('#documento').val(),
                metodo: "BUSCARCLIENTE"  
            }),
            success: function(result){
                if(result == "0")
                    document.location.reload();
                else {
                    var texto = "<div class='alert alert-block' style='width=500px;' ><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Mensaje:</strong> "+result+"</strong></div>";
                    $('#mensajes').html(texto);
                }
                //var json2 = eval(result);
                //alert(json2);
                
            }
        });
    }
}
/* ARRAY DE COLORES */

function obtenerColoresPorLinea(idlinea, idfamilia) {
    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',        
        data: ({
            metodo: "OBTENERCOLORESPORLINEA",
            Linea: idlinea,
            Familia: idfamilia,
            ColeccionID: $('#temporada').val()
        }),
        success: function(result){   
            //alert(result);
            var json2 = eval('('+result+')');
            var texto = "<h4 style='color: #6f643b'>COLOR</h4>";
            if(typeof json2 != 'undefined') {
                $('.listado-colores').html('');
                $.each(json2.Colores, function(i, item){                      
                    texto += "<div id='colores'>"+
                        "<a href='index.php?idLinea="+idlinea+"&idFamilia="+idfamilia+"&color="+item.Color+"'>"+
                        "    <div class='redondo' style='background-color: "+buscarColor(item.Descripcion.toLowerCase())+";'></div>"+
                        "    <div class='color'>"+item.Descripcion.toLowerCase()+"</div>"+
                        "</a></div>";
                //alert(item.Descripcion);
                });
                $('.listado-colores').append(texto);
            }
        }
    });
}



function obtenerProductosPorClase2(idLinea, idFamilia) {
    // FAMILIAS
    $('.sub-menu-items').find('a').removeClass('sub-menu-seleccionado');
    
    $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        data: ({
            Familia: idFamilia,
            Linea: idLinea,
            ColeccionID: $('#temporada').val(),
            metodo: "OBTENERPRODUCTOSGENERICOS"  
        }),
        success: function(result){
            //alert(result);
            var json2 = eval('('+result+')');
            var texto = "";
            
            if(typeof json2 != 'undefined') {
                $('.galeria-items').html('');
                $.each(json2.Genericos, function(i, item){  
                    texto += "<div id='galeria-productos'>" +
                        "<a href='articulo.php?codigo="+item.Itempreciocodigo+"&linea="+idLinea+"&familia="+idFamilia+"' >" +
                        "    <div class='galeria-imagen'>" +
                        "        <div class='galeria-foto'>" +
                        "            <img src='http://209.45.30.34/imagenes/fotos/"+item.Caracteristicavalor04+"/"+idLinea+"/"+idFamilia+"/"+item.Itempreciocodigo+".JPG' />" +
                        "        </div>" +
                        "    </div>" +
                        "    <div class='galeria-titulo'><p>"+item.Descripcionsubfamilia.substring(0, item.Descripcionsubfamilia.length-9)+"<br><b>S/. "+decimales(item.Precio,2)+"</b></p></div>" +
                        "</a></div>";
                    //texto += "<li><a href='#' onClick=\"obtenerProductosPorClase(\'"+idLinea+"\',\'"+item.Familia+"\'); $(this).addClass('sub-menu-seleccionado'); \">"+item.Descripcionlocal.charAt(0).toUpperCase() + item.Descripcionlocal.slice(1).toLowerCase()+"</a></li>";
                });
                $('.galeria-items').append(texto);
            }
            else {
            }
        }
    });
}
var colores=[    
    ['turqueza','#77EEEE'],
    ['aqua','#00FFFF'],
    ['azulino','#9AAAEE'],
    ['vino','#8B0045'],
    ['palo rosa','#FF7AC8'],
    ['marron claro','#8B6345'],
    ['lila','#FF7FFF'],
    ['cobre','#CDBA85'],
    ['melon','#FFF3DA'],
    ['guinda','#8B0063'],
    ['habano','#CDCD92'],
    ['hueso','#FFFFD2'],
    ['kaki','#FFF9BF'],
    ['mostaza','#FFE77F'],    
    ['aceituna','#808000'],
    ['aciano azul','#6495ED'],
    ['adobe ligero','#FFEECA'],
    ['agua','#00FFFF'],
    ['aguamarina','#7FFFD4'],
    ['aguamarina 1','#7FFFD4'],
    ['aguamarina 2','#76EEC6'],
    ['aguamarina 3','#66CDAA'],
    ['aguamarina 4','#458B74'],
    ['aguamarina medio','#66CDAA'],
    ['aguamarina medio','#66CDAA'],
    ['almendra palido','#FFEBCD'],
    ['amarillo','#FFFF00'],
    ['amarillo 1','#FFFF00'],
    ['amarillo 2','#EEEE00'],
    ['amarillo 3','#CDCD00'],
    ['amarillo 4','#8B8B00'],
    ['amarillo alambre dorado claro','#FAFAD2'],
    ['amarillo claro','#FFFFE0'],
    ['amarillo claro','#FFFFE0'],
    ['amarillo claro 2','#EEEED1'],
    ['amarillo claro 3','#CDCDB4'],
    ['amarillo claro 4','#8B8B7A'],
    ['amarillo verde','#ADFF2F'],
    ['ambrosia 1','#F0FFF0'],
    ['ambrosia 2','#E0EEE0'],
    ['ambrosia 3','#C1CDC1'],
    ['ambrosia 4','#838B83'],
    ['añil','#4B0082'],
    ['añil 2','#218868'],
    ['arena ligera','#FEFFEF'],
    ['azul','#0000FF'],
    ['azul 1','#0000FF'],
    ['azul 2','#0000EE'],
    ['azul 3','#0000CD'],
    ['azul 4','#00008B'],
    ['azul acero','#4682B4'],
    ['azul acero','#4682B4'],
    ['azul acero 1','#63B8FF'],
    ['azul acero 2','#5CACEE'],
    ['azul acero 3','#4F94CD'],
    ['azul acero 4','#36648B'],
    ['azul acero claro','#B0C4DE'],
    ['azul acero claro','#B0C4DE'],
    ['azul acero claro 1','#CAE1FF'],
    ['azul acero claro 2','#BCD2EE'],
    ['azul acero claro 3','#A2B5CD'],
    ['azul acero claro 4','#6E7B8B'],
    ['azul aciano','#6495ED'],
    ['azul alicia','#F0F8FF'],
    ['azul alicia','#F0F8FF'],
    ['azul cadete','#5F9EA0'],
    ['azul cadete','#5F9EA0'],
    ['azul cadete 1','#98F5FF'],
    ['azul cadete 2','#8EE5EE'],
    ['azul cadete 3','#7AC5CD'],
    ['azul cadete 4','#53868B'],
    ['azul capota 1','#1E90FF'],
    ['azul capota 2','#1C86EE'],
    ['azul capota 3','#1874CD'],
    ['azul capota 4','#104E8B'],
    ['azul cielo','#87CEEB'],
    ['azul cielo','#87CEEB'],
    ['azul cielo 1','#87CEFF'],
    ['azul cielo 2','#7EC0EE'],
    ['azul cielo 3','#6CA6CD'],
    ['azul cielo 4','#4A708B'],    
    ['azul cielo claro','#87CEFA'],
    ['azul cielo claro 1','#B0E2FF'],
    ['azul cielo claro 2','#A4D3EE'],
    ['azul cielo claro 3','#8DB6CD'],
    ['azul cielo claro 4','#607B8B'],
    ['azul cielo intenso','#00BFFF'],
    ['azul cielo profundo 1','#00BFFF'],
    ['azul cielo profundo 2','#00B2EE'],
    ['azul cielo profundo 3','#009ACD'],
    ['azul cielo profundo 4','#00688B'],
    ['azul claro','#ADD8E6'],
    ['azul claro','#ADD8E6'],
    ['azul claro 1','#BFEFFF'],
    ['azul claro 2','#B2DFEE'],
    ['azul claro 3','#9AC0CD'],
    ['azul claro 4','#68838B'],
    ['azul claro sgi','#7D9EC0'],
    ['azul dodger','#1E90FF'],
    ['azul heraldico 1','#F0FFFF'],
    ['azul heraldico 2','#E0EEEE'],
    ['azul heraldico 3','#C1CDCD'],
    ['azul heraldico 4','#838B8B'],
    ['azul marino','#000080'],
    ['azul medianoche','#191970'],
    ['azul medianoche','#191970'],
    ['azul medio','#0000CD'],
    ['azul medio','#0000CD'],
    ['azul naval','#000080'],
    ['azul oscuro','#00008B'],
    ['azul oscuro','#00008B'],
    ['azul pizarra','#6A5ACD'],
    ['azul pizarra','#6A5ACD'],
    ['azul pizarra 1','#836FFF'],
    ['azul pizarra 2','#7A67EE'],
    ['azul pizarra 3','#6959CD'],
    ['azul pizarra 4','#473C8B'],
    ['azul pizarra claro','#8470FF'],
    ['azul pizarra medio','#7B68EE'],
    ['azul pizarra medio','#7B68EE'],
    ['azul pizarra oscuro','#483D8B'],
    ['azul pizarra oscuro','#483D8B'],
    ['azul pizarra sgi','#7171C6'],
    ['azul polvo','#B0E0E6'],
    ['azul real','#4169E1'],
    ['azul real','#4169E1'],
    ['azul real 1','#4876FF'],
    ['azul real 2','#436EEE'],
    ['azul real 3','#3A5FCD'],
    ['azul real 4','#27408B'],
    ['azul violeta','#8A2BE2'],
    ['azul violeta','#8A2BE2'],
    ['azur','#F0FFFF'],
    ['batido de papaya','#FFEFD5'],
    ['beige','#F5F5DC'],
    ['beis','#F5F5DC'],
    ['beis zambullida','#FEE0C6'],
    ['bisque 1','#FFE4C4'],
    ['bisque 2','#EED5B7'],
    ['bisque 2','#EED5B7'],
    ['bisque 3','#CDB79E'],
    ['bisque 4','#8B7D6B'],
    ['blanco','#FFFFFF'],
    ['blanco','#FFFFFF'],
    ['blanco almendra','#FFEBCD'],
    ['blanco antiguo','#FAEBD7'],
    ['blanco antiguo','#FAEBD7'],
    ['blanco antiguo 1','#FFEFDB'],
    ['blanco antiguo 2','#EEDFCC'],
    ['blanco antiguo 3','#CDC0B0'],
    ['blanco antiguo 4','#8B8378'],
    ['blanco fantasma','#F8F8FF'],
    ['blanco fantasma','#F8F8FF'],
    ['blanco floral','#FFFAF0'],
    ['blanco floral','#FFFAF0'],
    ['blanco navajo','#FFDEAD'],
    ['blanco navajo 1','#FFDEAD'],
    ['blanco navajo 2','#EECFA1'],
    ['blanco navajo 3','#CDB38B'],
    ['blanco navajo 4','#8B795E'],
    ['blanco orquidea','#FDFDF0'],
    ['blanco plantacion','#FFFFFE'],
    ['blanco porcelana','#FEF9ED'],
    ['blanco puro','#FFFFFF'],
    ['blanco sutil','#FEFFF1'],
    ['blanco vela','#FFFFF3'],
    ['bronceado','#D2B48C'],
    ['bronceado','#D2B48C'],
    ['bronceado 1','#FFA54F'],
    ['bronceado 2','#EE9A49'],
    ['bronceado 3','#CD853F'],
    ['bronceado 4','#8B5A2B'],
    ['bronceado carmelo','#FEF0C9'],
    ['burlywood','#DEB887'],
    ['burlywood 1','#FFD39B'],
    ['burlywood 2','#EEC591'],
    ['burlywood 3','#CDAA7D'],
    ['burlywood 4','#8B7355'],
    ['cajon de arena','#FEF5CA'],
    ['cal helada','#F6F9ED'],
    ['caqui','#F0D58C'],
    ['caqui','#F0E68C'],
    ['caqui 1','#FFF68F'],
    ['caqui 2','#EEE685'],
    ['caqui 3','#CDC673'],
    ['caqui 4','#8B864E'],
    ['caqui oscuro','#BDB76B'],
    ['caqui oscuro','#BDB76B'],
    ['cardo','#D8BFD8'],
    ['cardo','#D8BFD8'],
    ['cardo 1','#FFE1FF'],
    ['cardo 2','#EED2EE'],
    ['cardo 3','#CDB5CD'],
    ['cardo 4','#8B7B8B'],
    ['carmesi','#DC143C'],
    ['carmesi','#DC143C'],
    ['castaño','#B03060'],
    ['castaño 1','#FF34B3'],
    ['castaño 2','#EE30A7'],
    ['castaño 3','#CD2990'],
    ['castaño 4','#8B1C62'],
    ['cerceta sgi','#388E8E'],
    ['celeste','#87CEFA'],
    ['chartreuse','#7FFF00'],
    ['chartreuse 1','#7FFF00'],
    ['chartreuse 2','#76EE00'],
    ['chartreuse 3','#66CD00'],
    ['chartreuse 4','#458B00'],
    ['chartreuse sgi','#71C671'],
    ['chiffon limon 1','#FFFACD'],
    ['chiffon limon 2','#EEE9BF'],
    ['chiffon limon 3','#CDC9A5'],
    ['chiffon limon 4','#8B8970'],
    ['chocolate','#D2691E'],
    ['chocolate','#D2691E'],
    ['chocolate 1','#FF7F24'],
    ['chocolate 2','#EE7621'],
    ['chocolate 3','#CD661D'],
    ['chocolate 4','#8B4513'],
    ['cian','#00FFFF'],
    ['cian 1','#00FFFF'],
    ['cian 2','#00EEEE'],
    ['cian 3','#00CDCD'],
    ['cian 4','#008B8B'],
    ['cian claro','#E0FFFF'],
    ['cian claro','#E0FFFF'],
    ['cian claro 1','#E0FFFF'],
    ['cian claro 2','#D1EEEE'],
    ['cian claro 3','#B4CDCD'],
    ['cian claro 4','#7A8B8B'],
    ['cian oscuro','#008B8B'],
    ['cian oscuro','#008B8B'],
    ['ciruela','#DDA0DD'],
    ['ciruela','#DDA0DD'],
    ['ciruela 1','#FFBBFF'],
    ['ciruela 2','#EEAEEE'],
    ['ciruela 3','#CD96CD'],
    ['ciruela 4','#8B668B'],
    ['concha','#FFF5EE'],
    ['concha marina 1','#FFF5EE'],
    ['concha marina 2','#EEE5DE'],
    ['concha marina 3','#CDC5BF'],
    ['concha marina 4','#8B8682'],
    ['coral','#FF7F50'],
    ['coral','#FF7F50'],
    ['coral 1','#FF7256'],
    ['coral 2','#EE6A50'],
    ['coral 3','#CD5B45'],
    ['coral 4','#8B3E2F'],
    ['coral claro','#F08080'],
    ['coral claro','#F08080'],
    ['cordon viejo','#FDF5E6'],
    ['crema','#F5FFFA'],
    ['crema de menta','#F5FFFA'],
    ['dorado','#FFD700'],
    ['dorado alambre','#DAA520'],
    ['dorado alambre oscuro','#B8860B'],
    ['dorado alambre palido','#EEE8AA'],
    ['encaje antiguo','#FDF5E6'],
    ['escala de grises','#555555'],
    ['fucsia','#FF00FF'],
    ['fusta de papaya','#FFEFD5'],
    ['gainsboro','#DCDCDC'],
    ['gainsboro','#DCDCDC'],
    ['gasa limon','#FFFACD'],
    ['granate','#800000'],
    ['gris','#BEBEBE'],
    ['gris aceituna','#6B8E23'],
    ['gris brillante sgi','#C5C1AA'],
    ['gris claro','#D3D3D3'],
    ['gris claro','#D3D3D3'],
    ['gris claro','#D3D3D3'],
    ['gris claro sgi','#AAAAAA'],
    ['gris debil','#696969'],
    ['gris difuso','#696969'],
    ['gris medio sgi','#848484'],
    ['gris muy claro sgi','#D6D6D6'],
    ['gris muy oscuro sgi','#282828'],
    ['gris oscuro','#A9A9A9'],
    ['gris oscuro','#A9A9A9'],
    ['gris pizarra','#708090'],
    ['gris pizarra','#708090'],
    ['gris pizarra 1','#C6E2FF'],
    ['gris pizarra 2','#B9D3EE'],
    ['gris pizarra 3','#9FB6CD'],
    ['gris pizarra 4','#6C7B8B'],
    ['gris pizarra claro','#778899'],
    ['gris pizarra claro','#778899'],
    ['gris pizarra claro','#778899'],
    ['gris pizarra oscuro','#2F4F4F'],
    ['gris pizarra oscuro','#2F4F4F'],
    ['gris pizarra oscuro','#2F4F4F'],
    ['gris pizarra oscuro 1','#97FFFF'],
    ['gris pizarra oscuro 2','#8DEEEE'],
    ['gris pizarra oscuro 3','#79CDCD'],
    ['gris pizarra oscuro 4','#528B8B'],
    ['gris roca','#EBECE4'],
    ['gris sgi 0 (negro)','#000000'],
    ['gris sgi 100 (blanco)','#FFFFFF'],
    ['gris sgi 12','#1E1E1E'],
    ['gris sgi 16','#282828'],
    ['gris sgi 20','#333333'],
    ['gris sgi 24','#3D3D3D'],
    ['gris sgi 28','#474747'],
    ['gris sgi 32','#515151'],
    ['gris sgi 36','#5B5B5B'],
    ['gris sgi 4','#0A0A0A'],
    ['gris sgi 40','#666666'],
    ['gris sgi 44','#707070'],
    ['gris sgi 48','#7A7A7A'],
    ['gris sgi 52','#848484'],
    ['gris sgi 56','#8E8E8E'],
    ['gris sgi 60','#999999'],
    ['gris sgi 64','#A3A3A3'],
    ['gris sgi 68','#ADADAD'],
    ['gris sgi 72','#B7B7B7'],
    ['gris sgi 76','#C1C1C1'],
    ['gris sgi 8','#141414'],
    ['gris sgi 80','#CCCCCC'],
    ['gris sgi 84','#D6D6D6'],
    ['gris sgi 88','#E0E0E0'],
    ['gris sgi 92','#EAEAEA'],
    ['gris sgi 96','#F4F4F4'],
    ['hojaldre de melocoton 1','#FFDAB9'],
    ['hojaldre de melocoton 2','#EECBAD'],
    ['hojaldre de melocoton 3','#CDAF95'],
    ['hojaldre de melocoton 4','#8B7765'],
    ['horizonte lejano','#ECF1EF'],
    ['humo blanco','#F5F5F5'],
    ['humo blanco','#F5F5F5'],
    ['indigo','#4B0082'],
    ['ladrillo refractario','#B22222'],
    ['ladrillo refractario','#B22222'],
    ['ladrillo refractario 1','#FF3030'],
    ['ladrillo refractario 2','#EE2C2C'],
    ['ladrillo refractario 3','#CD2626'],
    ['ladrillo refractario x4','#8B1A1A'],
    ['lavanda','#E6E6FA'],
    ['lavanda','#E6E6FA'],
    ['lavanda rubor 1','#FFF0F5'],
    ['lavanda rubor 2','#EEE0E5'],
    ['lavanda rubor 3','#CDC1C5'],
    ['lavanda rubor 4','#8B8386'],
    ['ligeramente ruborizado','#FEEED4'],
    ['lima','#00FF00'],
    ['lino','#FAF0E6'],
    ['lino','#FAF0E6'],
    ['madera fornida','#DEB887'],
    ['magenta','#FF00FF'],
    ['magenta 1','#FF00FF'],
    ['magenta 2','#EE00EE'],
    ['magenta 3','#CD00CD'],
    ['magenta 4','#8B008B'],
    ['magenta oscuro','#8B008B'],
    ['magenta oscuro','#8B008B'],
    ['marfil','#FFFFF0'],
    ['marfil 1','#FFFFF0'],
    ['marfil 2','#EEEEE0'],
    ['marfil 3','#CDCDC1'],
    ['marfil 4','#8B8B83'],
    ['marfil colmillo','#FDFCDC'],
    ['marron','#A52A2A'],
    ['marron','#A52A2A'],
    ['marron 1','#FF4040'],
    ['marron 2','#EE3B3B'],
    ['marron 3','#CD3333'],
    ['marron 4','#8B2323'],
    ['marron arena','#F4A460'],
    ['marron arenoso','#F4A460'],
    ['marron montura','#8B4513'],
    ['marron montura','#8B4513'],
    ['marron rosaceo','#BC8F8F'],
    ['marron rosaceo 1','#FFC1C1'],
    ['marron rosaceo 2','#EEB4B4'],
    ['marron rosaceo 3','#CD9B9B'],
    ['marron rosaceo 4','#8B6969'],
    ['marron rosado','#BC8F8F'],
    ['melocoton helado','#FCF8DC'],
    ['melon verde','#F0FFF0'],
    ['merengue tostado','#F1EDC2'],
    ['mocasin','#FFE4B5'],
    ['mocasin','#FFE4B5'],    
    ['morado','#8B008B'],
    ['nacar','#FFFFF2'],
    ['naranja','#FFA500'],
    ['naranja 1','#FFA500'],
    ['naranja 2','#EE9A00'],
    ['naranja 3','#CD8500'],
    ['naranja 4','#8B5A00'],
    ['naranja oscuro','#FF8C00'],
    ['naranja oscuro','#FF8C00'],
    ['naranja oscuro 1','#FF7F00'],
    ['naranja oscuro 2','#EE7600'],
    ['naranja oscuro 3','#CD6600'],
    ['naranja oscuro 4','#8B4500'],
    ['naranja rojo','#FF4500'],
    ['nata liquida','#FEFEF2'],
    ['negro','#000000'],
    ['negro','#000000'],
    ['niebla matutina','#FDF2EE'],
    ['nieve','#FFFAFA'],
    ['nieve 1','#FFFAFA'],
    ['nieve 2','#EEE9E9'],
    ['nieve 3','#CDC9C9'],
    ['nieve 4','#8B8989'],
    ['oliva palido','#FBF5E6'],
    ['oro 1','#FFD700'],
    ['oro 2','#EEC900'],
    ['oro 3','#CDAD00'],
    ['oro 4','#8B7500'],
    ['orquidea','#DA70D6'],
    ['orquidea','#DA70D6'],
    ['orquidea 1','#FF83FA'],
    ['orquidea 2','#EE7AE9'],
    ['orquidea 3','#CD69C9'],
    ['orquidea 4','#8B4789'],
    ['orquidea medio','#BA55D3'],
    ['orquidea medio','#BA55D3'],
    ['orquidea medio 1','#E066FF'],
    ['orquidea medio 2','#D15FEE'],
    ['orquidea medio 3','#B452CD'],
    ['orquidea medio 4','#7A378B'],
    ['orquidea oscuro','#9932CC'],
    ['orquidea oscuro','#9932CC'],
    ['orquidea oscuro 1','#BF3EFF'],
    ['orquidea oscuro 2','#B23AEE'],
    ['orquidea oscuro 3','#9A32CD'],
    ['orquidea oscuro 4','#68228B'],
    ['peru','#CD853F'],
    ['peru','#CD853F'],
    ['plata','#C0C0C0'],
    ['pluma de avestruz','#FEF1E9'],
    ['polvo azul','#B0E0E6'],
    ['purpura','#800080'],
    ['purpura','#A020F0'],
    ['purpura 1','#9B30FF'],
    ['purpura 2','#912CEE'],
    ['purpura 3','#7D26CD'],
    ['purpura 4','#551A8B'],
    ['purpura medio','#9370DB'],
    ['purpura medio','#9370DB'],
    ['purpura medio 1','#AB82FF'],
    ['purpura medio 2','#9F79EE'],
    ['purpura medio 3','#8968CD'],
    ['purpura medio 4','#5D478B'],
    ['rastro polvoriento','#FEF1E1'],
    ['remolacha sgi','#8E388E'],
    ['rojo','#FF0000'],
    ['rojo 1','#FF0000'],
    ['rojo 2','#EE0000'],
    ['rojo 3','#CD0000'],
    ['rojo 4','#8B0000'],
    ['rojo anaranjado 1','#FF4500'],
    ['rojo anaranjado 2','#EE4000'],
    ['rojo anaranjado 3','#CD3700'],
    ['rojo anaranjado 4','#8B2500'],
    ['rojo indio','#CD5C5C'],
    ['rojo indio','#CD5C5C'],
    ['rojo indio 1','#FF6A6A'],
    ['rojo indio 2','#EE6363'],
    ['rojo indio 3','#CD5555'],
    ['rojo indio 4','#8B3A3A'],
    ['rojo oscuro','#8B0000'],
    ['rojo oscuro','#8B0000'],
    ['rojo violeta','#D02090'],
    ['rojo violeta 1','#FF3E96'],
    ['rojo violeta 2','#EE3A8C'],
    ['rojo violeta 3','#CD3278'],
    ['rojo violeta 4','#8B2252'],
    ['rojo violeta medio','#C71585'],
    ['rojo violeta palido','#DB7093'],
    ['rojo violeta palido 1','#FF82AB'],
    ['rojo violeta palido 2','#EE799F'],
    ['rojo violeta palido 3','#CD6889'],
    ['rojo violeta palido 4','#8B475D'],
    ['rosa','#FFC0CB'],
    ['rosa','#FFC0CB'],
    ['rosa 1','#FFB5C5'],
    ['rosa 2','#EEA9B8'],
    ['rosa 3','#CD919E'],
    ['rosa 4','#8B636C'],
    ['rosa brumosa','#FFE4E1'],
    ['rosa calido','#FF69B4'],
    ['rosa calido 1','#FF6EB4'],
    ['rosa calido 2','#EE6AA7'],
    ['rosa calido 3','#CD6090'],
    ['rosa calido 4','#8B3A62'],
    ['rosa caliente','#FF69B4'],
    ['rosa claro','#FFB6C1'],
    ['rosa claro','#FFB6C1'],
    ['rosa claro 1','#FFAEB9'],
    ['rosa claro 2','#EEA2AD'],
    ['rosa claro 3','#CD8C95'],
    ['rosa claro 4','#8B5F65'],
    ['rosa humedo','#FFE4E1'],
    ['rosa humedo 1','#FFE4E1'],
    ['rosa humedo 2','#EED5D2'],
    ['rosa humedo 3','#CDB7B5'],
    ['rosa humedo 4','#8B7D7B'],
    ['rosa intenso','#FF1493'],
    ['rosa polvoriento','#FEEECD'],
    ['rosa profundo 1','#FF1493'],
    ['rosa profundo 2','#EE1289'],
    ['rosa profundo 3','#CD1076'],
    ['rosa profundo 4','#8B0A50'],
    ['salmon','#FA8072'],
    ['salmon','#FA8072'],
    ['salmon 1','#FF8C69'],
    ['salmon 2','#EE8262'],
    ['salmon 3','#CD7054'],
    ['salmon 4','#8B4C39'],
    ['salmon claro','#FFA07A'],
    ['salmon claro','#FFA07A'],
    ['salmon claro 1','#FFA07A'],
    ['salmon claro 2','#EE9572'],
    ['salmon claro 3','#CD8162'],
    ['salmon claro 4','#8B5742'],
    ['salmon oscuro','#E9967A'],
    ['salmon oscuro','#E9967A'],
    ['salmon sgi','#C67171'],
    ['seda de grano 1','#FFF8DC'],
    ['seda de grano 2','#EEE8CD'],
    ['seda de grano 3','#CDC8B1'],
    ['seda de grano 4','#8B8878'],
    ['seda de maiz','#FFF8DC'],
    ['siena','#A0522D'],
    ['siena','#A0522D'],
    ['siena 1','#FF8247'],
    ['siena 2','#EE7942'],
    ['siena 3','#CD6839'],
    ['siena 4','#8B4726'],
    ['sombra caliente','#FEF6E4'],
    ['sonrojo lavanda','#FFF0F5'],
    ['sopa','#FFE4C4'],
    ['soplido melocoton','#FFDAB9'],
    ['tomate','#FF6347'],
    ['tomate 1','#FF6347'],
    ['tomate 2','#EE5C42'],
    ['tomate 3','#CD4F39'],
    ['tomate 4','#8B3626'],
    ['trigo','#F5DEB3'],
    ['trigo','#F5DEB3'],
    ['trigo 1','#FFE7BA'],
    ['trigo 2','#EED8AE'],
    ['trigo 3','#CDBA96'],
    ['trigo 4','#8B7E66'],
    ['turquesa','#40E0D0'],
    ['turquesa','#AFEEEE'],
    ['turquesa','#40E0D0'],
    ['turquesa 1','#00F5FF'],
    ['turquesa 2','#00E5EE'],
    ['turquesa 3','#00C5CD'],
    ['turquesa 4','#00868B'],
    ['turquesa medio','#48D1CC'],
    ['turquesa medio','#48D1CC'],
    ['turquesa oscuro','#00CED1'],
    ['turquesa oscuro','#00CED1'],
    ['turquesa palido','#AFEEEE'],
    ['turquesa palido 1','#BBFFFF'],
    ['turquesa palido 2','#AEEEEE'],
    ['turquesa palido 3','#96CDCD'],
    ['turquesa palido 4','#668B8B'],
    ['vara de oro','#DAA520'],
    ['vara de oro 1','#FFC125'],
    ['vara de oro 2','#EEB422'],
    ['vara de oro 3','#CD9B1D'],
    ['vara de oro 4','#8B6914'],
    ['vara de oro amarilla claro','#FAFAD2'],
    ['vara de oro claro','#EEDD82'],
    ['vara de oro claro 1','#FFEC8B'],
    ['vara de oro claro 2','#EEDC82'],
    ['vara de oro claro 3','#CDBE70'],
    ['vara de oro claro 4','#8B814C'],
    ['vara de oro oscuro','#B8860B'],
    ['vara de oro oscuro 1','#FFB90F'],
    ['vara de oro oscuro 2','#EEAD0E'],
    ['vara de oro oscuro 3','#CD950C'],
    ['vara de oro oscuro 4','#8B6508'],
    ['vara de oro palido','#EEE8AA'],
    ['velo de boda','#FFFFFD'],
    ['verano caliente','#FCF6CF'],
    ['verde','#008000'],
    ['verde 1','#00FF00'],
    ['verde 2','#00EE00'],
    ['verde 3','#00CD00'],
    ['verde 4','#008B00'],
    ['verde aceituna oscuro','#556B2F'],
    ['verde amarillento','#ADFF2F'],
    ['verde amarillento','#9ACD32'],
    ['verde amarillo','#9ACD32'],
    ['verde bosque','#228B22'],
    ['verde bosque','#228B22'],
    ['verde cerceta','#008080'],
    ['verde cesped','#7CFC00'],
    ['verde cesped','#7CFC00'],
    ['verde claro','#90EE90'],
    ['verde claro','#90EE90'],
    ['verde lima','#32CD32'],
    ['verde lima','#32CD32'],
    ['verde mar','#2E8B57'],
    ['verde mar','#2E8B57'],
    ['verde mar 1','#54FF9F'],
    ['verde mar 2','#4EEE94'],
    ['verde mar 3','#43CD80'],
    ['verde mar 4','#2E8B57'],
    ['verde mar claro','#20B2AA'],
    ['verde mar claro','#20B2AA'],
    ['verde mar intenso','#8FBC8F'],
    ['verde mar medio','#3CB371'],
    ['verde mar medio','#3CB371'],
    ['verde mar oscuro','#8FBC8F'],
    ['verde mar oscuro 1','#C1FFC1'],
    ['verde mar oscuro 2','#B4EEB4'],
    ['verde mar oscuro 3','#9BCD9B'],
    ['verde mar oscuro 4','#698B69'],
    ['verde oliva militar','#6B8E23'],
    ['verde oliva militar 1','#C0FF3E'],
    ['verde oliva militar 2','#B3EE3A'],
    ['verde oliva militar 3','#9ACD32'],
    ['verde oliva militar 4','#698B22'],
    ['verde oliva militar sgi','#8E8E38'],
    ['verde oliva oscuro','#556B2F'],
    ['verde oliva oscuro 1','#CAFF70'],
    ['verde oliva oscuro 2','#BCEE68'],
    ['verde oliva oscuro 3','#A2CD5A'],
    ['verde oliva oscuro 4','#6E8B3D'],
    ['verde oscuro','#006400'],
    ['verde oscuro','#006400'],
    ['verde palido','#98FB98'],
    ['verde palido','#98FB98'],
    ['verde palido 1','#9AFF9A'],
    ['verde palido 2','#90EE90'],
    ['verde palido 3','#7CCD7C'],
    ['verde palido 4','#548B54'],
    ['verde primavera','#00FF7F'],
    ['verde primavera 1','#00FF7F'],
    ['verde primavera 2','#00EE76'],
    ['verde primavera 3','#00CD66'],
    ['verde primavera 4','#008B45'],
    ['verde primavera medio','#00FA9A'],
    ['verde primavera medio','#00FA9A'],
    ['verde velo','#EEF3E2'],
    ['violeta','#EE82EE'],
    ['violeta','#EE82EE'],
    ['violeta oscuro','#9400D3'],
    ['violeta oscuro','#9400D3'],
    ['violeta rojo medio','#C71585'],
    ['violeta rojo palido','#DB7093']
    ];

function buscarColor(nombrecolor){
    var i=0;
    for(i=0;i<colores.length;i++){
        if(colores[i][0]===nombrecolor){
            return colores[i][1];
        }
        /*else if(colores[i][0].search(nombrecolor)>=0){
            return colores[i][1];
        }*/
    }
    return "#F4F4F4";
}

function obtenerArticuloCantidadAjax(color,codigo){    
     
     $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        data: ({
            Familia: idFamilia,
            Linea: idLinea,
            ColeccionID: $('#temporada').val(),
            metodo: "ArticuloCantidadAjax"  
        }),
        success: function(result){
            //alert(result);
            var json2 = eval('('+result+')');
            var texto = "";
            
            if(typeof json2 != 'undefined') {
                $('.galeria-items').html('');
                $.each(json2.Genericos, function(i, item){  
                    texto += "<div id='galeria-productos'>" +
                        "<a href='articulo.php?codigo="+item.Itempreciocodigo+"&linea="+idLinea+"&familia="+idFamilia+"' >" +
                        "    <div class='galeria-imagen'>" +
                        "        <div class='galeria-foto'>" +
                        "            <img src='http://209.45.30.34/imagenes/fotos/"+item.Caracteristicavalor04+"/"+idLinea+"/"+idFamilia+"/"+item.Itempreciocodigo+".JPG' />" +
                        "        </div>" +
                        "    </div>" +
                        "    <div class='galeria-titulo'><p>"+item.Descripcionsubfamilia.substring(0, item.Descripcionsubfamilia.length-9)+"<br><b>S/. "+decimales(item.Precio,2)+"</b></p></div>" +
                        "</a></div>";
                    //texto += "<li><a href='#' onClick=\"obtenerProductosPorClase(\'"+idLinea+"\',\'"+item.Familia+"\'); $(this).addClass('sub-menu-seleccionado'); \">"+item.Descripcionlocal.charAt(0).toUpperCase() + item.Descripcionlocal.slice(1).toLowerCase()+"</a></li>";
                });
                $('.galeria-items').append(texto);
            }
            else {
            }
        }
    });
}

function obtenerArticuloTallaAjax(){
     $.ajax({
        type: "POST",
        url: "operaciones.php",
        dataType: 'json',
        data: ({
            Familia: idFamilia,
            Linea: idLinea,
            ColeccionID: $('#temporada').val(),
            metodo: " obtenerArticuloTallaAjax"  
        }),
        success: function(result){
            //alert(result);
            var json2 = eval('('+result+')');
            var texto = "";
            
            if(typeof json2 != 'undefined') {
                $('.galeria-items').html('');
                $.each(json2.Genericos, function(i, item){  
                    texto += "<div id='galeria-productos'>" +
                        "<a href='articulo.php?codigo="+item.Itempreciocodigo+"&linea="+idLinea+"&familia="+idFamilia+"' >" +
                        "    <div class='galeria-imagen'>" +
                        "        <div class='galeria-foto'>" +
                        "            <img src='http://209.45.30.34/imagenes/fotos/"+item.Caracteristicavalor04+"/"+idLinea+"/"+idFamilia+"/"+item.Itempreciocodigo+".JPG' />" +
                        "        </div>" +
                        "    </div>" +
                        "    <div class='galeria-titulo'><p>"+item.Descripcionsubfamilia.substring(0, item.Descripcionsubfamilia.length-9)+"<br><b>S/. "+decimales(item.Precio,2)+"</b></p></div>" +
                        "</a></div>";
                    //texto += "<li><a href='#' onClick=\"obtenerProductosPorClase(\'"+idLinea+"\',\'"+item.Familia+"\'); $(this).addClass('sub-menu-seleccionado'); \">"+item.Descripcionlocal.charAt(0).toUpperCase() + item.Descripcionlocal.slice(1).toLowerCase()+"</a></li>";
                });
                $('.galeria-items').append(texto);
            }
            else {
            }
        }
    });
}



$('#colorSelected').on('change',function(){
    var color = $(this).val();          
    var tallas = new Array();
    $('.articulo-talla').html('');
    $('.articulo-talla').html("<option value='0'>SELECCIONE TALLA</option>");
    $('.articulo-cantidad').html('');
    $('.articulo-cantidad').html("<option value='0'>SELECCIONE CANTIDAD</option>");
    if(typeof json_stocks != 'undefined') {                
         $.each(json_stocks.StockLocal, function(i, item){  

            if(item.Colorcodigo==color) {
            //alert(item.Tallacodigo);
                if(jQuery.inArray(item.Tallacodigo,tallas)<0) { 
                     tallas.push(item.Tallacodigo);
                    $('.articulo-talla').append("<option value='"+item.Tallacodigo+"_"+color+"'>"+item.Tallacodigo+"</option>");
                }
            }
        });
    }                    
});
    
$('#articuloCantidad').on('change',function(){    
    var constock = false;
    var str =  $(this).val();  
    var n=str.split("_");
    var talla= n[0];
    var color= n[1];
   
    
    $('.articulo-cantidad').html('');
    $('.articulo-cantidad').html("<option value='0'>SELECCIONE CANTIDAD</option>");
    if(typeof json_stocks != 'undefined') {
        $.each(json_stocks.StockLocal, function(i, item){
            
            if(item.Colorcodigo==color && item.Tallacodigo==talla){ 
                
                if(parseInt(item.Stockdisponible)>0) { 
                    var limit=10;
                    constock = true;
                    var stock=eval(item.Stockdisponible);
                    if(stock<10){
                        limit=stock
                    }
                    for(var x=1; x<=limit; x++) {
                        $('.articulo-cantidad').append("<option value='"+x+"'>"+x+"</option>");
                        //$('.articulo-cantidad').append("<option value="+x+">"+x+"</option>");
                    }
                }else{                
                    $('.articulo-cantidad').html('');
                    $('.articulo-cantidad').html("<option value='0'>TEMPORALMENTE AGOTADO</option>");            
                }
            }
        });
      
            
        
    }   
});
