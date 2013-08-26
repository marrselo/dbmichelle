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
            url:'controlador/categoria.con.php?f=listar',
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
                {field:'estado',title:'Estado',width:150},
                {field:'acciones',title:'Acciones',width:150,formatter: function(value,row,index){
                        return "<input type='button' value='Ver detalle' onclick='dlgProducto("+row.id+")' />";
                }}
            ]],
            pagination:true,
            rownumbers:true,
            pageList: [10,20,50,100]
	});
});
function dlgProducto(idCategoria){
    $('#idcategoria').val(idCategoria);
    $('#test1').datagrid({
		title:'Resultados',
		iconCls:'icon-save',
		width:700,
		height:370,
		nowrap: true,
		autoRowHeight: true,
		striped: true,
		collapsible:false,
		singleSelect:true,
		url:'controlador/producto.con.php?f=listarxcategoria&cat='+idCategoria,
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
			{field:'estado',title:'Estado',width:40}
		]],
		pagination:true,
		pageList: [10,20,50,100],
		rownumbers:true
	});
    
    $('#dlgProducto').dialog('open');
}
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
		url: "controlador/categoria.con.php?f=nuevo",
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
				window.location.href = 'categoria.php';
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
		url: "controlador/categoria.con.php?f=actualizar",
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
				window.location.href = 'categoria.php';
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
				url: "controlador/categoria.con.php?f=borrar",
				data: ({
					id : selected.id,
					imagen : selected.imagen
					}),
				success: function(msg){
					if(!$.isNumeric(msg)){
						alert('No se completo el registro. Revise la informacion ingresada.');
					}
					else{
						window.location.href = 'categoria.php';
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

function fnExportarExcel(){
	var selected = $('#test').datagrid('getSelected');
	$.ajax({
		type: "POST",
		url: "controlador/categoria.con.php?f=actualizar",
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
				window.location.href = 'categoria.php';
			}
		},
		error: function(d,e){
			alert(e);
		}
	});
}


function getSelected(){
	var selected = $('#test').datagrid('getSelected');
	if (selected){
		return selected.nombre;
	}
}
function getSelections(){
	var ids = [];
	var rows = $('#test').datagrid('getSelections');
	for(var i=0;i<rows.length;i++){
		ids.push(rows[i].code);
	}
	alert(ids.join(':'));
	
	
}
function clearSelections(){
	$('#test').datagrid('clearSelections');
}
function selectRow(){
	$('#test').datagrid('selectRow',2);
}
function selectRecord(){
	$('#test').datagrid('selectRecord','002');
}
function unselectRow(){
	$('#test').datagrid('unselectRow',2);
}
function mergeCells(){
	$('#test').datagrid('mergeCells',{
		index:2,
		field:'addr',
		rowspan:2,
		colspan:2
	});
}
