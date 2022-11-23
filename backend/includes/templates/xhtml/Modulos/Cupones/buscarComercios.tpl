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

<!--<div style="width:50px;text-align:right;margin-right:-15px;float:right;margin-top:-15px;">
	<a href='javascript:_closeWindow();'><img src='{IMAGES_DIR}/closePopin.png' alt='Cerrar' title='Cerrar' border='0'></a>
</div>-->
<form action="#" method="POST" name="formBuscarComercio" id="formBuscarComercio">
<table align="center" style="font-size:11px;"> 
	<tr>
		<td colspan="4" style=""> 
			<img src='{IMAGES_DIR}/searchPopin.png' alt='Cerrar' title='Cerrar' border='0' align="absmiddle">&nbsp;BUSCAR COMERCIO
		</td>
	</tr>
	<tr>
		<td align="right">
			Numero:&nbsp;
		</td>
		<td>
			<input name="sNumero" type="text" id="sNumero" class="FormTextBox" value="{sNumero}">
		</td>
		<td align="right">
			CUIT:&nbsp;
		</td>
		<td>
			<input name="sCUIT" type="text" id="sCUIT" class="FormTextBox" value="{sCUIT}">			
		</td>
	</tr>
	<tr>
		<td align="right">
			Rason Social:&nbsp;
		</td>
		<td>
			<input name="sRazonSocial" type="text" id="sRazonSocial" class="FormTextBox" value="{sRazonSocial}">			
		</td>
		<td align="right">
			Nombre Fantasia:&nbsp;
		</td>
		<td>
			<input name="sNombreFantasia" type="text" id="sNombreFantasia" class="FormTextBox" value="{sNombreFantasia}">
		</td>
	</tr>
	<tr>
		<td align="center" colspan="4">
			<input type="button" name="buscar_comercio" id="buscar_comercio" value="buscar comercio" style="padding:5px;" onclick="_buscarDatosComercios_();"> 
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
	
	function _buscarDatosComercios_(){

		//_imageLoading_();

		xajax_buscarDatosComercio(xajax.getFormValues('formBuscarComercio'));

	}
	

	

</script>