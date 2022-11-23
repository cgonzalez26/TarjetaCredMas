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
<body style="background-color:#FFFFFF">
<center>
<form action="#" method="POST" name="formBuscarMaterial" id="formBuscarMaterial" style="padding-top:5px">

<table class='formulario' align="center" style="font-size:11px;width:450px;border:solid 1px #CCC" cellspacing="0" cellpadding="0"> 	
	 <tr> 
	  	<th colspan="4" class="cabecera"> BUSCAR MATERIALES </th> 
	  </tr>
	<tr>
		<th align="right">
			Codigo:&nbsp;
		</th>
		<td>
			<input name="sCodigo" type="text" id="sCodigo" class="FormTextBox" value="{CODIGO}">
		</td>
		<th align="right">
			Descripcion:&nbsp;
		</th>
		<td>
			<input name="sDescripcion" type="text" id="sDescripcion" class="FormTextBox" value="{sDescripcion}">			
		</td>
	</tr>
	<tr>
		<th align="right">
			Familia:&nbsp;
		</th>
		<td>
			<select id="idFamilia" name="idFamilia" class="FormTextBox" style="width:200px">
				{optionsFamilias}
			</select>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="4">
			<input type="button" name="buscar_material" id="buscar_material" value="buscar material" style="padding:5px;" onclick="_buscarDatosMateriales_();"> 
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
	
	function _buscarDatosMateriales_(){

		//_imageLoading_();

		xajax_buscarDatosMaterialesSolicitud(xajax.getFormValues('formBuscarMaterial'));

	}
</script>