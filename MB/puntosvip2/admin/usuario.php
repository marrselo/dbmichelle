<?php
include 'webconfig.php';
session_start();
if (!isset($_SESSION['nombre'])) {
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" href="css/estilo.css"/>
		
		<link rel="stylesheet" type="text/css" href="css/default/easyui.css">
		<link rel="stylesheet" type="text/css" href="css/icon.css">
		
		<link rel="stylesheet" type="text/css" href="css/bootstrap2.css">
		
		
		<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
		<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="js/locale/easyui-lang-es.js"></script>
		
		
	</head>
	<body class="claro" style="background-color: #F5F5F5">
		<!--BOTONES-->
		<div id="resultado"></div>
		<a href="javascript:void(0)" class="btn btn-small btn-success" onClick="dlgNuevo()" ><i class="icon-pencil icon-white"></i>&nbsp;Registrar</a>
		<a href="javascript:void(0)" class="btn btn-small btn-warning" onClick="dlgActualizar()" ><i class="icon-refresh icon-white"></i>&nbsp;Modificar</a>
		<a href="javascript:void(0)" class="btn btn-small btn-danger " onClick="fnEliminar()" ><i class="icon-remove icon-white"></i>&nbsp;Eliminar</a>
		<br/>
		<br/>
		<!--TABLA -->
		<table id="test"></table>
	    
	    <div id="dlgActualizar" class="easyui-dialog" title="Actualizar" style="width:400px;height:200px;padding:10px"   
            data-options=" 
                buttons: [{  
                    text:'Ok',  
                    iconCls:'icon-ok',  
                    handler:function(){  
                        fnGrabarCambios();  
                    }  
                },{  
                    text:'Cancel',  
                    handler:function(){  
                        $('#dlgActualizar').window('close');
                    }  
                }]  
            ">  
         	
         	<table style="width: 100%">
         		<tr>
         			<td style="width: 20%" align="right">Nombre : </td>
         			<td style="width: 80%"><input id="nombre" type="text" name="" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,40]'" /></td>
         		</tr>
         		<tr>
         			<td style="width: 20%" align="right">Clave : </td>
         			<td style="width: 80%"><input id="clave" type="password" name="" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,40]'" /></td>
         		</tr>
         		<tr>
         			<td style="width: 20%" align="right">Estado : </td>
         			<td style="width: 80%"><select id="estado">
			        	<option value="A">Activo</option>
			        	<option value="I">Inactivo</option>
			        </select></td>
         		</tr>
         	</table>
         	
	    </div>  
	    
	    <div id="dlgNuevo" class="easyui-dialog" title="Registrar" style="width:400px;height:200px;padding:10px"  
            data-options=" 
                buttons: [{  
                    text:'Ok',  
                    iconCls:'icon-ok',  
                    handler:function(){  
                        fnGrabarNuevo();  
                    }  
                },{  
                    text:'Cancel',  
                    handler:function(){  
                        $('#dlgNuevo').window('close');
                    }  
                }]  
            ">  
         	
         	<table style="width: 100%">
         		<tr>
         			<td style="width: 20%" align="right">Nombre : </td>
         			<td style="width: 80%"><input id="nombreNuevo" type="text" size="40" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,40]'" /></td>
         		</tr>
         		<tr>
         			<td style="width: 20%" align="right">Clave : </td>
         			<td style="width: 80%"><input id="claveNuevo" type="password" size="40" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,40]'" /></td>
         		</tr>
          		<tr>
         			<td style="width: 20%" align="right">Estado : </td>
         			<td style="width: 80%"><select id="estadoNuevo">
			        	<option value="A">Activo</option>
			        	<option value="I">Inactivo</option>
			        </select></td>
         		</tr>        		
         	</table>

	    </div>  
		
		<!--SCRIPTS-->
		<script src="js/bootstrap.js" ></script>
		<script src="js/layouts.js"></script>
		<script src="js/iqd.js"></script>
		<script src="js/bootstrap-modal.js"></script>
		<script type="text/javascript" src="controlador/usuario.js"></script>		
		
	</body>
</html>