<script type='text/javascript'>
	function reset_cmd_search(){
		document.getElementById('cmd_search').removeAttribute("disabled");
	}
	
	
	function search_form(){
		
			_imageLoading_('div_result_search','buscando...');
	
			xajax_reporteCobranzasEmpleados(xajax.getFormValues('form_search'));		
	}


	/*function delete(_n,_i){
		var ok = confirm('Esta seguro de borrar : \"' + _n + '\" ?');
		var index = 'div_' + _i ;
		if(ok){
			
			_imageLoading_(index,'');
	
			xajax_delete(_i);
		}
	}*/	
	
	
	function printReportesCobranzasEmpleados(){
		document.getElementById('impresiones').innerHTML = document.getElementById('div_result_search').innerHTML;
		window.print();
	}
	
	function _imageLoading_(_div_,_text_){
		document.getElementById(_div_).innerHTML = "<img src=\"{IMAGES_DIR}/ajax-loader.gif\" title=\"cargando\" alt=\"...\" width=\"16\" height=\"16\" align=\"absmiddle\"> <span style='font-size:11px;'>" + _text_ + "</span>";
	}	

	{javascript_adicional}
	
	function validarDatosForm(Formu) 
	{
		var Formu = document.getElementById('formReporte');
		var errores = '';
		with (Formu)
		{
			if( idGrupoAfinidadResumen.value == 0 )
			errores += "- El campo Grupo Afinidad es requerido.\n";	
			
			if( dPeriodoResumen.value == 0 )
			errores += "- El campo Periodo Calendario es requerido.\n";						
		}
		if( errores ) { alert(errores); return false; } 
		else return true;
		
	}
	
	function mostrarFechas(dPeriodo){
		if(dPeriodo != ""){
			var idGrupoAfinidad = document.getElementById('idGrupoAfinidadResumen').value;
			if(idGrupoAfinidad == 0){
				alert("Debe seleccionar un Grupo Afinidad");
				return;
			}
			xajax_mostrarFechasPeriodo(idGrupoAfinidad,dPeriodo);
		}
	}
	
	function exportarXLS(){
		var idGrupoAfinidad = document.getElementById('idGrupoAfinidadResumen').value;
		var idRegion = document.getElementById('idRegionResumen').value;
		var idSucursal = document.getElementById('idSucursalResumen').value;
		var idOficina = document.getElementById('idOficinaResumen').value;
		var dPeriodo = document.getElementById('dPeriodoResumen').value;
		var fImporte = document.getElementById('fImporteResumen').value;
		var dFechaDesde = document.getElementById('dFechaDesdeResumen').value;
		var dFechaHasta = document.getElementById('dFechaHastaResumen').value;
		
		var url = "idGrupoAfinidad="+idGrupoAfinidad+"&idRegion="+idRegion+"&idSucursal="+idSucursal+"&idOficina="+idOficina+"&dPeriodo="+dPeriodo+"&fImporte="+fImporte+"&dFechaDesde="+dFechaDesde+"&dFechaHasta="+dFechaHasta;
		window.location = "xlsResumenesConCobranzas.php?"+url;
	}
</script>
<center>

<form action="ResumenesConCobranzas.php" method="POST" onsubmit="return validarDatosForm()" id='formReporte' name='formReporte'><center>

<input type="hidden" id="dFechaDesdeResumen" name="dFechaDesdeResumen" value='{FECHA_DESDE_SINFORMAT}' />
<input type="hidden" id="dFechaHastaResumen" name="dFechaHastaResumen" value='{FECHA_HASTA_SINFORMAT}' />
<input type="hidden" id="dFechaDesdeResumenFormat" name="dFechaDesdeResumenFormat" value='{FECHA_DESDE}' />
<input type="hidden" id="dFechaHastaResumenFormat" name="dFechaHastaResumenFormat" value='{FECHA_HASTA}' />

	<div style="width:780px;">
		<fieldset style="border-top:2px solid #000;border-right:0px solid #CCC;border-bottom:2px solid #000;border-left:0px solid #CCC;">
		<legend style="text-align:left;border:0px solid #FFF;">
			<img src='{IMAGES_DIR}/search32.png' title='buscar' alt='buscar' hspace='4' align='absmiddle' />
			FILTRO RESUMENES
		</legend>	
		
		<table style="width:780px !important;font-size:11px;" cellspacing="3" cellpadding="3" border="0">
		 <tr>
		  	<td align="right" width="140">Grupo Afinidad<sup>*</sup>: </td> 
			<td style="width:150px">
			 	<select id="idGrupoAfinidadResumen" name="idGrupoAfinidadResumen">{optionsGrupos}</select>
			</td>		
		  	<td align="right" width="100">Periodo<sup>*</sup>:</td>
		  	<td width="150">
		  		<select id="dPeriodoResumen" name="dPeriodoResumen" onchange="mostrarFechas(this.value)">{optionsPeriodos}</select>
		  	</td>
			<td align="right" width="100">Importe:</td>
			<td width="150"><input type="text" id="fImporteResumen" name="fImporteResumen" style="width:150px;" value="{IMPORTE}" /></td>
		</tr>
		<tr>
		  	<td align="right" width="100">Region:</td>
		  	<td width="150">
		  		<select name="idRegionResumen" id="idRegionResumen" style="width:150px;">
		  			{options_regiones}
		  		</select>		  	
		  	</td>
		  	<td align="right" width="100">Sucursal:</td>
		  	<td width="150">
		  		<select name="idSucursalResumen" id="idSucursalResumen" style="width:150px;">
		  			{options_sucursales}
		  		</select>
		  	</td>
		  	<td align="right" width="100">Oficina:</td>
		  	<td width="150">
		  		<select name="idOficinaResumen" id="idOficinaResumen" style="width:150px;">
		  			{options_oficinas}
		  		</select>
		  	</td>
		 </tr>		 
		 <tr>
		  	<td align="right" width="140">DESDE:</td>
		  	<td width="150"><span name="lblFechaDesdeResumen" id="lblFechaDesdeResumen">{FECHA_DESDE}</span></td>
		  	<td align="right" width="140">HASTA:</td>
		  	<td width="150"><span name="lblFechaHastaResumen" id="lblFechaHastaResumen">{FECHA_HASTA}</span></td>
		 </tr>
		 <tr>
			<!--<td align="center" colspan="4">
				<button type='button' name='buscar' style="width:120px;padding:5px;" onclick="search_form();return false;"> Buscar </button>-->
			<td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' id="buscar" name='buscar' style="width:120px;padding:5px;"> Buscar </button></td>
				<input type="hidden" name="cmd_search" id="cmd_search" value="1" />
			</td>
		 </tr>
		 </table>		
		</fieldset>
	</div>
	</center>
	
</form>
	

	<br />

{search_form}

<center>
<div id='div_message_operations' style='width:720px;'>
{message}
</div>
</center>


<div id='div_result_button'>
 	{buttons}
</div>
<br />
<div id="div_result_header">
	{table}
</div>
<div id="div_result_search" style="height:550px; overflow-x: hidden; overflow-y:auto;">
	{tableDatos}
</div>

<!--</div>-->
</center>