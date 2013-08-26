$(document).ready(function() {
	$('#dlgNuevo').dialog('close');
	$('#dlgActualizar').dialog('close');
	$("#empresa").html('');
	$("#categoria").html('');
	
	$('#test').datagrid({
		title:'Resultados',
		iconCls:'icon-save',
		width:700,
		height:370,
		nowrap: true,
		autoRowHeight: true,
		striped: true,
		collapsible:false,
		singleSelect:true,
		url:'controlador/producto.con.php?f=listar',
		sortName: 'nombre',
		sortOrder: 'asc',
		remoteSort: false,
		idField:'id',
		columns:[[
			{field:'id',title:'ID',width:120,hidden:true},
			{field:'id_categoria',title:'ID',width:120,hidden:true},
			{field:'id_empresa',title:'ID',width:120,hidden:true},
			{field:'codigo',title:'Codigo',width:70,sortable:true},
			{field:'categoria',title:'Categoria',width:80,sortable:true},
			{field:'empresa',title:'Empresa',width:80,sortable:true},
			{field:'nombre',title:'Nombre',width:120,sortable: true},
			{field:'descripcion',title:'Descripcion',width:120,hidden:true},
			{field:'condiciones',title:'Condiciones',width:120,hidden:true},
			{field:'puntos',title:'Puntos',width:50,sortable: true},
			{field:'canjepuntos',title:'Canje Puntos',width:50,sortable: true},
			{field:'canjesoles',title:'Canje Soles',width:120,sortable: true},
                        {field:'logo',title:'Logo',width:170,formatter: function(value,row,index){
				return "<img src='"+value+"' height='50' />";
			}},
                        {field:'imagen',title:'Imagen',width:170,formatter: function(value,row,index){
				return "<img src='"+value+"' height='50' />";
			}},
			{field:'estado',title:'Estado',width:40}
		]],
		pagination:true,
		pageList: [10,20,50,100],
		rownumbers:true
	});
	
	//LLENAR LOS COMBOBOX 
	$.ajax({
		type: "POST",
		url: "controlador/categoria.con.php?f=listado",
		success: function(result){
			var json2 = eval(result);
			$.each(json2, function(i, item){
            	//alert(item.nombre);
            	$('#categoria').append('<option value="'+item.id+'">'+item.nombre+'</option>');
            	$('#categoriaActualizar').append('<option value="'+item.id+'">'+item.nombre+'</option>');
        	});
		},
		error: function(d,e){
			alert(e);
		}
	});
	$.ajax({
		type: "POST",
		url: "controlador/empresa.con.php?f=listado",
		success: function(result){
			var json2 = eval(result);
			$.each(json2, function(i, item){
            	$('#empresa').append('<option value="'+item.id+'">'+item.nombre+'</option>');
            	$('#empresaActualizar').append('<option value="'+item.id+'">'+item.nombre+'</option>');
        	});
		},
		error: function(d,e){
			alert(e);
		}
	});
});
function dlgActualizar(){
	var selected = $('#test').datagrid('getSelected');
	if (selected){
		$('#nombreActualizar').val(selected.nombre);
		$('#codigoActualizar').val(selected.codigo);
		$('#estadoActualizar').val(selected.estado);
		$('#descripcionActualizar').val(selected.descripcion);
		$('#condicionesActualizar').val(selected.condiciones);
		$('#puntosActualizar').val(selected.puntos);
		$('#canjepuntosActualizar').val(selected.canjepuntos);
		$('#canjesolesActualizar').val(selected.canjesoles);
		$('#empresaActualizar').val(selected.id_empresa);
		$('#categoriaActualizar').val(selected.id_categoria);
                
                $("#iframelogoActualizar").contents().find("img").remove();
		$("#iframelogoActualizar").contents().find("body").append("<img ruta='"+selected.logo+"' src='"+selected.logo+"' style='width:128px; height:128px;' />");
		
		$("#iframeimagenActualizar").contents().find("img").remove();
		$("#iframeimagenActualizar").contents().find("body").append("<img ruta='"+selected.imagen+"' src='"+selected.imagen+"' style='width:128px; height:128px;' />");
		
		$('#dlgActualizar').dialog('open');
	}else{
		alert('Seleccione un registro.');
	}
}
function dlgNuevo(){
	$('#nombre').val('');
	$('#codigo').val('');
	$('#estado').val('A');
	$('#descripcion').val('');
	$('#condiciones').val('');
	$('#puntos').val('');
	$('#canjepuntos').val('');
	$('#canjesoles').val('');
	$('#categoria').val(1);
	$('#empresa').val(1);
	
	$('#dlgNuevo').dialog('open');
}
function fnGrabarNuevo(){
	
	$.ajax({
		type: "POST",
		url: "controlador/producto.con.php?f=nuevo",
		data: ({		
			nombre : $('#nombre').val(),
			codigo : $('#codigo').val(),
			descripcion : $('#descripcion').val(),
			condiciones : $('#condiciones').val(),
			puntos : $('#puntos').val(),
			canjepuntos : $('#canjepuntos').val(),
			canjesoles : $('#canjesoles').val(),
			estado: $('#estado').val(),
			id_categoria : $('#categoria').val(),
			id_empresa : $('#empresa').val(),                        
			logo : $("#iframelogo").contents().find("img").attr('ruta'),
			imagen : $("#iframeimagen").contents().find("img").attr('ruta')
			}),
		success: function(msg){
			if(!$.isNumeric(msg)){
				alert('No se completo el registro. Revise la informacion ingresada.');
			}
			else{
				$('#nombre').val('');
				$('#codigo').val('');
				$('#estado').val('A');
				$('#descripcion').val('');
				$('#condiciones').val('');
				$('#puntos').val('');
				$('#canjepuntos').val('');
				$('#canjesoles').val('');
				$('#categoria').val(1);
				$('#empresa').val(1);
				window.location.href = 'producto.php';
			}
		},
		error: function(d,e){
			alert(e);
		}
	});
}
function fnGrabarCambios(){
	var selected = $('#test').datagrid('getSelected');
	$.ajax({
		type: "POST",
		url: "controlador/producto.con.php?f=actualizar",
		data: ({
			id : selected.id,
			nombre : $('#nombreActualizar').val(),
			codigo : $('#codigoActualizar').val(),
			descripcion : $('#descripcionActualizar').val(),
			condiciones : $('#condicionesActualizar').val(),
			puntos : $('#puntosActualizar').val(),
			canjepuntos : $('#canjepuntosActualizar').val(),
			canjesoles : $('#canjesolesActualizar').val(),
			estado: $('#estadoActualizar').val(),
			id_categoria : $('#categoriaActualizar').val(),
			id_empresa : $('#empresaActualizar').val(),
			logo : $("#iframelogoActualizar").contents().find("img").attr('ruta'),
			imagen : $("#iframeimagenActualizar").contents().find("img").attr('ruta')
			}),
		success: function(msg){
			if(!$.isNumeric(msg)){
				alert('No se completo el registro. Revise la informacion ingresada.');
			}
			else{
				$('#nombreActualizar').val('');
				$('#codigoActualizar').val('');
				$('#estadoActualizar').val('A');
				$('#descripcionActualizar').val('');
				$('#condicionesActualizar').val('');
				$('#puntosActualizar').val('');
				$('#canjepuntosActualizar').val('');
				$('#canjesolesActualizar').val('');
				$('#categoriaActualizar').val(1);
				$('#empresaActualizar').val(1);
				window.location.href = 'producto.php';
			}
		},
		error: function(d,e){
			alert(e);
		}
	});
}
function fnEliminar(){
	var selected = $('#test').datagrid('getSelected');
	if (selected){
		$.messager.confirm('Confirmacion','Esta seguro que desea borrar este registro?',function(r){  
	    if (r){  
	        var selected = $('#test').datagrid('getSelected');
			$.ajax({
				type: "POST",
				url: "controlador/producto.con.php?f=borrar",
				data: ({
					id : selected.id,
                                        logo : selected.logo,
                                        imagen : selected.imagen
					}),
				success: function(msg){
					if(!$.isNumeric(msg)){
						alert('No se completo el registro. Revise la informacion ingresada.');
					}
					else{
						window.location.href = 'producto.php';
					}
				},
				error: function(d,e){
					alert(e);
				}
			});  
	    }  
		});
	}
	else {
		alert('Seleccione un registro.');
	}
}
