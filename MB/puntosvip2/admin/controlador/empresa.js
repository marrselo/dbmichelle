$(document).ready(function() {
	$('#dlgNuevo').dialog('close');
	$('#dlgActualizar').dialog('close');
	
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
		url:'controlador/empresa.con.php?f=listar',
		sortName: 'nombre',
		sortOrder: 'asc',
		remoteSort: false,
		idField:'id',
		columns:[[
			{field:'id',title:'ID',width:120,hidden:true},
			{field:'nombre',title:'Nombre',width:120,sortable: true},
			{field:'direccion',title:'Direccion',width:120,sortable: true},
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
});
function dlgActualizar(){
	var selected = $('#test').datagrid('getSelected');
	if (selected){
		$('#nombreActualizar').val(selected.nombre);
		$('#direccionActualizar').val(selected.direccion);
		$('#estadoActualizar').val(selected.estado);
		
		//$('#fileActualizar').val(selected.imagen);
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
	$('#direccion').val('');
	$('#estado').val('A');
	
	$('#dlgNuevo').dialog('open');
}
function fnGrabarNuevo(){
	
	$.ajax({
		type: "POST",
		url: "controlador/empresa.con.php?f=nuevo",
		data: ({
			nombre : $('#nombre').val(),
			direccion : $('#direccion').val(),
			logo : $("#iframelogo").contents().find("img").attr('ruta'),
			imagen : $("#iframeimagen").contents().find("img").attr('ruta'),
			estado : $('#estado').val()
			}),
		success: function(msg){
			if(!$.isNumeric(msg)){
				alert('No se completo el registro. Revise la informacion ingresada.');
			}
			else{
				$('#nombre').val('');
				$('#direccion').val('');
				$('#estado').val('');
				window.location.href = 'empresa.php';
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
		url: "controlador/empresa.con.php?f=actualizar",
		data: ({
			id : selected.id,
			nombre : $('#nombreActualizar').val(),
			direccion : $('#direccionActualizar').val(),
			logo : $("#iframelogoActualizar").contents().find("img").attr('ruta'),
			imagen : $("#iframeimagenActualizar").contents().find("img").attr('ruta'),
			estado : $('#estadoActualizar').val()
			}),
		success: function(msg){
			if(!$.isNumeric(msg)){
				alert('No se completo el registro. Revise la informacion ingresada.');
			}
			else{
				$('#nombreActualizar').val('');
				$('#direccionActualizar').val('');
				$('#estadoActualizar').val('');
				window.location.href = 'empresa.php';
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
				url: "controlador/empresa.con.php?f=borrar",
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
						window.location.href = 'empresa.php';
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
