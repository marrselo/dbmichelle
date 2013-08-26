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
		url:'controlador/usuario.con.php?f=listar',
		sortName: 'nombre',
		sortOrder: 'asc',
		remoteSort: false,
		idField:'id',
		columns:[[
			{field:'id',title:'ID',width:120,hidden:true},
			{field:'nombre',title:'Nombre',width:120,sortable: true},
			{field:'clave',title:'Clave',width:120,hidden:true},
			{field:'estado',title:'Estado',width:150
			}
		]],
		pagination:true,
		pageList: [10,20,50,100],
		rownumbers:true
	});
});
function dlgActualizar(){
	var selected = $('#test').datagrid('getSelected');
	if (selected){
		$('#nombre').val(selected.nombre);
		$('#clave').val(selected.clave);
		$('#estado').val(selected.estado);
		
		$('#dlgActualizar').dialog('open');
	}else{
		alert('Seleccione un registro.');
	}
}
function dlgNuevo(){
	$('#nombreNuevo').val('');
	$('#claveNuevo').val('');
	$('#estadoNuevo').val('A');
	
	$('#dlgNuevo').dialog('open');
}
function fnGrabarNuevo(){
	
	$.ajax({
		type: "POST",
		url: "controlador/usuario.con.php?f=nuevo",
		data: ({
			nombre : $('#nombreNuevo').val(),
			clave : $("#claveNuevo").val(),
			estado : $('#estadoNuevo').val()
			}),
		success: function(msg){
			if(!$.isNumeric(msg)){
				alert('No se completo el registro. Revise la informacion ingresada.');
			}
			else{
				$('#nombreNuevo').val('');
				$('#claveNuevo').val('');
				$('#estadoNuevo').val('');
				window.location.href = 'usuario.php';
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
		url: "controlador/usuario.con.php?f=actualizar",
		data: ({
			id : selected.id,
			nombre : $('#nombre').val(),
			clave : $("#clave").val(),
			estado : $('#estado').val()
			}),
		success: function(msg){
			if(!$.isNumeric(msg)){
				alert('No se completo el registro. Revise la informacion ingresada.');
			}
			else{
				$('#nombre').val('');
				$('#clave').val('');
				$('#estado').val('');
				window.location.href = 'usuario.php';
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
				url: "controlador/usuario.con.php?f=borrar",
				data: ({
					id : selected.id,
					usuario : selected.usuario
					}),
				success: function(msg){
					if(!$.isNumeric(msg)){
						alert('No se completo el registro. Revise la informacion ingresada.');
					}
					else{
						window.location.href = 'usuario.php';
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
function fnLogin(){
	$.ajax({
		type: "POST",
		url: "controlador/usuario.con.php?f=login",
		data: ({
			nombre : $('#txtUsuario').val(),
			clave : $("#txtPasswd").val()
			}),
		success: function(msg){
			if(!$.isNumeric(msg)){
				alert('El usuario o clave no estan registrados. Revise la informacion ingresada.');
			}
			else{
				window.location.href = 'admin.php';
			}
		},
		error: function(d,e){
			alert(e);
		}
	});
}

function fnCerrarSesion(){
	$.ajax({
		type: "POST",
		url: "controlador/usuario.con.php?f=cerrarlogin",
		success: function(msg){
			window.location.href = 'index.php';
		},
		error: function(d,e){
			alert(e);
		}
	});
}