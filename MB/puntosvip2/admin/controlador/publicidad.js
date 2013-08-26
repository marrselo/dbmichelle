$(document).ready(function() {
        
	$('#dlgNuevo').dialog('close');
	$('#dlgActualizar').dialog('close');
        $('#dlgProducto').dialog('close');
	
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
            url:'controlador/publicidad.con.php?f=listar',
            sortName: 'nombre',
            sortOrder: 'asc',
            remoteSort: false,
            idField:'id',
            columns:[[
                {field:'id',title:'ID',width:120,hidden:true},
                {field:'nombre',title:'Nombre',width:120,sortable: true},
                {field:'imagen',title:'Imagen',width:220,formatter: function(value,row,index){
                        return "<img src='"+value+"' height='50' />";
                }},
                {field:'estado',title:'Estado',width:150}
            ]],
            pagination:true,
            rownumbers:true,
            pageList: [10,20,50,100]
	});
});
function dlgActualizar(){
	var selected = $('#test').datagrid('getSelected');
	if (selected){
		$('#nombre').val(selected.nombre);
		$('#estado').val(selected.estado);
		
		$('#file').val(selected.imagen);
		$("#iframe").contents().find("img").remove();
		$("#iframe").contents().find("body").append("<img id='fotoiframe' ruta='"+selected.imagen+"' src='"+selected.imagen+"' style='width:128px; height:128px;' />");
		
		$('#dlgActualizar').dialog('open');
	}else{
		alert('Seleccione un registro.');
	}
}
function dlgNuevo(){
	$('#nombreNuevo').val('');
	$('#fileNuevo').val('');
	$('#estadoNuevo').val('A');
	
	$('#dlgNuevo').dialog('open');
}
function fnGrabarNuevo(){
	
	$.ajax({
		type: "POST",
		url: "controlador/publicidad.con.php?f=nuevo",
		data: ({
			nombre : $('#nombreNuevo').val(),
			imagen : $("#iframeNuevo").contents().find("img").attr('ruta'),
			estado : $('#estadoNuevo').val()
			}),
		success: function(msg){
			if(!$.isNumeric(msg)){
				alert('No se completo el registro. Revise la informacion ingresada.');
			}
			else{
				$('#nombreNuevo').val('');
				$('#fileNuevo').val('');
				$('#estadoNuevo').val('');
				window.location.href = 'publicidad.php';
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
		url: "controlador/publicidad.con.php?f=actualizar",
		data: ({
			id : selected.id,
			nombre : $('#nombre').val(),
			imagen : $("#iframe").contents().find("img").attr('ruta'),
			estado : $('#estado').val()
			}),
		success: function(msg){
			if(!$.isNumeric(msg)){
				alert('No se completo el registro. Revise la informacion ingresada.');
			}
			else{
				$('#nombre').val('');
				$('#file').val('');
				$('#estado').val('');
				window.location.href = 'publicidad.php';
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
				url: "controlador/publicidad.con.php?f=borrar",
				data: ({
					id : selected.id,
					imagen : selected.imagen
					}),
				success: function(msg){
					if(!$.isNumeric(msg)){
						alert('No se completo el registro. Revise la informacion ingresada.');
					}
					else{
						window.location.href = 'publicidad.php';
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
