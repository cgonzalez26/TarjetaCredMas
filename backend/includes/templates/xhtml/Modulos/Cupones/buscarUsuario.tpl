<style>
.table_object {
    font-family: Tahoma,Times New Roman;
    text-align: center;
}

.table_object th {
    background: url("../includes/images/bc_bg.png") repeat-x scroll 50% 50% #F5F5F5;
    border-bottom: 1px solid #CCCCCC;
    border-left: 1px solid #CCCCCC;
    border-top: 1px solid #CCCCCC;
    color: #911E79;
    font-family: Arial;
    font-size: 11px;
    height: 30px;
    line-height: 30px;
    margin: 0;
    padding: 0;
    text-align: center;
}

.table_object td {
    border-bottom: 1px solid #CCCCCC;
    border-left: 1px solid #CCCCCC;
    font-size: 11px;
    height: 25px;
    line-height: 25px;
    padding: 2px;
}
</style>

<!--<div style="width:50px;text-align:right;margin-right:-15px;float:right;margin-top:-15px;z-index:2000000;">
	<a href='javascript:_closeWindow();'><img src='{IMAGES_DIR}/closePopin.png' alt='Cerrar' title='Cerrar' border='0'></a>
</div>-->
<form action="#" method="POST" name="formBuscarUsuario" id="formBuscarUsuario">
<table align="center" style="font-size:11px;"> 
	<tr>
		<td colspan="4" style=""> 
			<img src='{IMAGES_DIR}/searchPopin.png' alt='Cerrar' title='Cerrar' border='0' align="absmiddle">&nbsp;BUSCAR USUARIO
		</td>
	</tr>
	<tr>
		<td align="right">
			Apellido:&nbsp;
		</td>
		<td>
			<input name="sApellido" type="text" id="sApellido" class="FormTextBox" value="{sApellido}">
		</td>
		<td align="right">
			Nombre:&nbsp;
		</td>
		<td>
			<input name="sNombre" type="text" id="sNombre" class="FormTextBox" value="{sNombre}">
		</td>
	</tr>
	<tr>
		<td align="right">
			Tipo Documento:&nbsp;
		</td>
		<td>
			<select id="idTipoDocumento" name="idTipoDocumento" class="FormTextBox">
			{optionsTipoDoc}
			</select>			
		</td>
		<td align="right">
			DNI:&nbsp;
		</td>
		<td>
			<input name="sDocumento" type="text" id="sDocumento" class="FormTextBox" value="{sDocumento}">
		</td>
		  <tr>
			 <td height="30" align="right" style="width:130px">Nro. de Cuenta:&nbsp;</td>
			 <td height="30"><input type="text" name="sNumeroCuenta" id="sNumeroCuenta" maxlength="16" value='{sNumeroCuenta}'></td> 
			 <td align="right">Nro. de Tarjeta:&nbsp;</td>
			 <td height="30"><input type="text" name="sNumeroTarjeta" id="sNumeroTarjeta" maxlength="16" value='{sNumeroTarjeta}'></td> 
		  </tr>
	</tr>
	<tr>
		<td align="center" colspan="4">
			<input type="button" name="buscar_usuario" id="buscar_usuario" value="buscar usuario" style="padding:5px;" onclick="_buscarDatosUsuario_();"> 
		</td>

	</tr>
<table>
</form>
<br />
<center>
<!--<div id="resultado_busqueda" style="width:680px;text-align:center;">

</div>-->
<table style="width:680px;text-align:center;">
<tr>
<td id='resultado_busqueda'></td>
</tr>
</table>
</center>


<script type="text/javascript">
	function _imageLoading_(){
		
		document.getElementById('resultado_busqueda').innerHTML = "<img src='{IMAGES_DIR}/ajax-loader.gif' title='buscando' hspace='4'> buscando...";
		
	}
	
	function _buscarDatosUsuario_(){

		_imageLoading_();

		xajax_buscarDatosUsuario(xajax.getFormValues('formBuscarUsuario'));

	}
	

</script>