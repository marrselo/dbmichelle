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
	    
	    <div id="dlgActualizar" class="easyui-dialog" title="Actualizar" style="width:600px;height:480px;padding:10px"  
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
            
            <table style="width: 100%;">
         		<tr>
         			<td style="width: 20%" align="right">Categoria : </td>
         			<td style="width: 80%"><select id="categoriaActualizar"><option value="0">Seleccion</option></select></td>
         		</tr>
         		<tr>
         			<td style="width: 20%" align="right">Empresa : </td>
         			<td style="width: 80%"><select id="empresaActualizar"><option value="0">Seleccion</option></select></td>
         		</tr>
         		<tr>
         			<td style="width: 20%" align="right">Codigo : </td>
         			<td style="width: 80%"><input id="codigoActualizar" type="text" size="20" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,40]'" /></td>
         		</tr>
         		<tr>
         			<td style="width: 20%" align="right">Nombre : </td>
         			<td style="width: 80%"><input id="nombreActualizar" type="text" size="50" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,50]'" /></td>
         		</tr>
         		<tr>
         			<td style="width: 20%" align="right">Descripcion : </td>
         			<td style="width: 80%"><textarea id="descripcionActualizar" cols="40" rows="6" ></textarea></td>
         		</tr>
         		<tr>
         			<td style="width: 20%" align="right">Condiciones : </td>
         			<td style="width: 80%"><textarea id="condicionesActualizar" cols="40" rows="6" ></textarea></td>
         		</tr>
         		<tr>
         			<td style="width: 20%" align="right">Canje por puntos : </td>
         			<td style="width: 80%"><input id="puntosActualizar" type="text" size="10" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,40]'" /></td>
         		</tr>
         		<tr>
         			<td style="width: 20%" align="right">Canje combinado : </td>
         			<td style="width: 80%"><input id="canjepuntosActualizar" type="text" size="10" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,40]'" />
	        Puntos - <input id="canjesolesActualizar" type="text" name="" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,20]'" /> Tarjeta </td>
         		</tr>        
                        <tr>
         			<td style="width: 20%" align="right">Logo : <br><br />Dimensiones <br />(370px x 120px)<br /><br />Peso m&aacute;ximo 400kb</td>
         			<td style="width: 80%">
                                    <form action="image_promocion.php" target="iframelogoActualizar" method="post" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <input type="file" name="file" id="filelogoActualizar" class="well" />
                                            <input type="submit" name="submit" value="Cargar" class="btn btn-small btn-primary" /><br />
                                            <iframe name="iframelogoActualizar" id="iframelogoActualizar" class="well well-small" style="width: 250px; height: 145px;"></iframe>
                                        </div>
                                    </form>
                                </td>
         		</tr>  
         		<tr>
         			<td style="width: 20%" align="right">Imagen : <br><br />Dimensiones <br />(380px x 290px)<br /><br />Peso m&aacute;ximo 400kb</td>
         			<td style="width: 80%"><form action="image_promocion.php" target="iframeimagenActualizar" method="post" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <input type="file" name="file" id="fileimagenActualizar" class="well" />
                                            <input type="submit" name="submit" value="Cargar" class="btn btn-small btn-primary" /><br />
                                            <iframe name="iframeimagenActualizar" id="iframeimagenActualizar" class="well well-small" style="width: 250px; height: 145px;"></iframe>
                                        </div>
                                    </form></td>    
         		</tr>  
         		<tr>
         			<td style="width: 20%" align="right">Estado : </td>
         			<td style="width: 80%"><select id="estadoActualizar">
			        	<option value="A">Activo</option>
			        	<option value="I">Inactivo</option>
			        </select></td>
         		</tr>     		
         	</table>
	    </div>  
	    
	    <div id="dlgNuevo" class="easyui-dialog" title="Registrar" style="width:600px;height:480px;padding:10px"  
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

            <table style="width: 100%;">
                    <tr>
                            <td style="width: 20%" align="right">Categoria : </td>
                            <td style="width: 80%"><select id="categoria"><option value="0">Seleccion</option></select></td>
                    </tr>
                    <tr>
                            <td style="width: 20%" align="right">Empresa : </td>
                            <td style="width: 80%"><select id="empresa"><option value="0">Seleccion</option></select></td>
                    </tr>
                    <tr>
                            <td style="width: 20%" align="right">Codigo : </td>
                            <td style="width: 80%"><input id="codigo" type="text" size="20" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,40]'" /></td>
                    </tr>
                    <tr>
                            <td style="width: 20%" align="right">Nombre : </td>
                            <td style="width: 80%"><input id="nombre" type="text" size="50" value="" class="easyui-validatebox" data-options="required:true,validType:'length[3,50]'" /></td>
                    </tr>
                    <tr>
                            <td style="width: 20%" align="right">Descripcion : </td>
                            <td style="width: 80%"><textarea id="descripcion" cols="40" rows="6" ></textarea></td>
                    </tr>
                    <tr>
                            <td style="width: 20%" align="right">Condiciones : </td>
                            <td style="width: 80%"><textarea id="condiciones" cols="40" rows="6" ></textarea></td>
                    </tr>
                    <tr>
                            <td style="width: 20%" align="right">Canje por puntos : </td>
                            <td style="width: 80%"><input id="puntos" type="text" size="10" value="" class="easyui-validatebox" data-options="required:true,validType:'length[2,40]'" /></td>
                    </tr>
                    <tr>
                            <td style="width: 20%" align="right">Canje combinado : </td>
                            <td style="width: 80%"><input id="canjepuntos" type="text" size="10" value="" class="easyui-validatebox" data-options="required:true,validType:'length[2,40]'" />
            Puntos - <input id="canjesoles" type="text" name="" value="" class="easyui-validatebox" data-options="required:true,validType:'length[2,20]'" /> Tarjeta </td>
                    </tr>    
                    <tr>
                            <td style="width: 20%" align="right">Icono : <br><br />Dimensiones <br />(370px x 120px)<br /><br />Peso m&aacute;ximo 400kb</td>
                            <td style="width: 80%">
                                    <form action="image_promocion.php" target="iframelogo" method="post" enctype="multipart/form-data">
                                            <div class="control-group">
                                                    <input type="file" name="file" id="filelogo" class="well" />
                                                    <input type="submit" name="submit" value="Cargar" class="btn btn-small btn-primary" /><br />
                                                    <iframe name="iframelogo" id="iframelogo" class="well well-small" style="width: 250px; height: 145px;"></iframe>
                                            </div>
                                    </form></td>
                    </tr>
                    <tr>
                            <td style="width: 20%" align="right">Imagen : <br><br />Dimensiones <br />(380px x 290px)<br /><br />Peso m&aacute;ximo 400kb</td>
                            <td style="width: 80%">
                                    <form action="image_promocion.php" target="iframeimagen" method="post" enctype="multipart/form-data">
                                            <div class="control-group">
                                                    <input type="file" name="file" id="filelogo" class="well" />
                                                    <input type="submit" name="submit" value="Cargar" class="btn btn-small btn-primary" /><br />
                                                    <iframe name="iframeimagen" id="iframeimagen" class="well well-small" style="width: 250px; height: 145px;"></iframe>
                                            </div>
                                    </form></td>
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
		
		<!--SCRIPTS-->
		<script src="js/bootstrap.js" ></script>
		<script src="js/layouts.js"></script>
		<script src="js/iqd.js"></script>
		<script src="js/bootstrap-modal.js"></script>
		<script type="text/javascript" src="controlador/producto.js"></script>		
		
	</body>
</html>