<center>
<!--<div id='BODY'>-->

<!--<center>
<div class='title_section' style='width:720px;'>
	&nbsp;&nbsp;Reporte Solicitudes por Empleados
</div>
</center>-->

<!--{pathBrowser}-->
<form action="javascript:void(0);" method="POST" name="form_search" id="form_search"><center>
	<div style="width:720px;">
		<fieldset style="border-top:2px solid #000;border-right:0px solid #CCC;border-bottom:2px solid #000;border-left:0px solid #CCC;">
		<legend style="text-align:left;border:0px solid #FFF;">
			<img src='{IMAGES_DIR}/search32.png' title='buscar' alt='buscar' hspace='4' align='absmiddle' />
			FILTRO SOLICITUDES
		</legend>	
		
		<table style="width:680px !important;font-size:11px;" cellspacing="2" cellpadding="2" border="0">
		 <tr>
		  	<td align="right" width="140">Region:</td>
		  	<td width="">
		  		<select name="idRegion" id="idRegion" style="width:150px;">
		  			{options_regiones}
		  		</select>		  	
		  	</td>
		 </tr>
		 <tr>
		  	<td align="right" width="140">Sucursal:</td>
		  	<td width="150">
		  		<select name="idSucursal" id="idSucursal" style="width:150px;">
		  			{options_sucursales}
		  		</select>
		  	</td>
		  	<td align="right" width="140">Oficina:</td>
		  	<td width="150">
		  		<select name="idOficina" id="idOficina" style="width:150px;">
		  			{options_oficinas}
		  		</select>
		  	</td>
		 </tr>
		 <!--<tr>
		  	<td align="right" width="140">Tipo Ajuste:</td>
		  	<td width="">
		  		<select name="idTipoAjuste" id="idTipoAjuste" style="width:150px;">
		  			{options_tipos_ajustes}
		  		</select>
		  	</td>
		 </tr>-->
		 <tr>
		  	<td align="right" width="140">DESDE:</td>
		  	<td width="150"><input type="text" name="dFechaDesde" id="dFechaDesde" value='{dFechaDesde}'></td>
		  	<td align="right" width="140">HASTA:</td>
		  	<td width="150"><input type="text" name="dFechaHasta" id="dFechaHasta" value='{dFechaHasta}'></td>
		 </tr>
		 <tr>
			<td align="center" colspan="4">
				&nbsp;
			</td>
		 </tr>		 
		 <tr>
			<td align="center" colspan="4">
				<button type='submit' name='buscar' style="width:120px;padding:5px;" onclick="javascript:search_form();return false;"> Buscar </button>
				<input type='hidden' name='cmd_search' id='cmd_search' value='1' />
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



<div id='div_result_button'>{buttons}</div>

<br />

<div id="div_result_search">{table}</div>

<script type='text/javascript'>

	InputMask('dFechaDesde','99/99/9999');
	InputMask('dFechaHasta','99/99/9999');
	
	function reset_cmd_search(){
		document.getElementById('cmd_search').removeAttribute("disabled");
	}
	
	
	function search_form(){
			//_imageLoading_('div_result_search','buscando...');
	
			var errores = checkForm();
			
			if(errores == ''){
				xajax_reporteSolicitudesEmpleados(xajax.getFormValues('form_search'));
			}else{
				alert(errores);
			}	
	}


	/*function delete(_n,_i){
		var ok = confirm('Esta seguro de borrar : \"' + _n + '\" ?');
		var index = 'div_' + _i ;
		if(ok){
			
			_imageLoading_(index,'');
	
			xajax_delete(_i);
		}
	}*/


	function printReporteSolicitudEmpleado(){
		document.getElementById('impresiones').innerHTML = document.getElementById('div_result_search').innerHTML;
		window.print();
	}
	
	function checkForm(){
		var form = document.forms['form_search'];
		var error = '';
		
		if(form.dFechaDesde.value == '' || form.dFechaDesde.value == '__/__/____'){
			error = error + 'Campo Fecha Desde requerido. \n';
		}
		
		if(form.dFechaHasta.value == '' || form.dFechaHasta.value == '__/__/____'){
			error = error + 'Campo Fecha Hasta requerido. \n';
		}
		
		return error;
	}	

	{javascript_adicional}

</script>



<!--</div>-->
</center>