<body style="background-color:#FFFFFF">
<center>
	<div id='' style='width:860px;text-align:right;margin-right:10px;'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Grupo' border='0' hspace='4' align='absmiddle'> 
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo' alt='Nuevo' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<img src='{IMAGES_DIR}/back.png' title='Buscar' alt='Buscar' border='0' hspace='4' align='absmiddle'> 
		<a href="FacturacionCargos.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
	<form id="formFacturacionCargos" action="AdminFacturacionCargos.php" method="POST">
		<input type="hidden" id="idFacturacionCargos" name="idFacturacionCargos" value="{ID_FACTURACION_CARGOS}" />
		<input type="hidden" id="sEstado" name="sEstado" value="{ESTADO}" />
		
		<fieldset id='cuadroOficina' style="height:200px;width:860px">
			<legend> Facturacion de Cargos </legend>			
			<table id='TablaGrupoAfinidad' cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%">
			<tr>
				<th> Grupo Afinidad: </th>
				<td> 
					<select name='idGrupoAfinidad' id='idGrupoAfinidad' style='width:200px;'>
					{OPTIONS_AFINIDADES}					
					</select> <sup>*</sup>
				</td>
			</tr>
			<tr>
				<th> Tipo Ajuste: </th>
				<td> 
					<select name='idTipoAjuste' id='idTipoAjuste' style='width:200px;'>
					{OPTIONS_TIPOS_AJUSTES}					
					</select> <sup>*</sup>
				</td>
			</tr>				
			<tr>
				<th> Variable Tipo Ajuste: </th>
				<td> 
					<select name='idVariableTipoAjuste' id='idVariableTipoAjuste' style='width:200px;'>
					{OPTIONS_VARIABLES_TIPOS_AJUSTES}					
					</select> <sup>*</sup>
				</td>					
			</tr>	
			<tr>
				<th> Tipo Facturacion: </th>
				<td> 
					<select name='idTipoFacturacion' id='idTipoFacturacion' style='width:200px;'>
					{OPTIONS_TIPO_FACTURACION}					
					</select> <sup>*</sup>
				</td>					
			</tr>			
			<tr>
				<th> Estado de Cuenta: </th>
				<td> 
					<select name='idTipoEstadoCuenta' id='idTipoEstadoCuenta' style='width:200px;'>
					{OPTIONS_TIPO_ESTADO_CUENTAS}{OPTIONS_TIPO_ESTADO_CUENTAS2}				
					</select> <sup>*</sup>
				</td>					
			</tr>			    
			<tr>
				<th> Valor: </th>		
				<td> 
					<input type='text' id="fValor" name='fValor' onblur="this.value=numero_parse_flotante(this.value);" value='{VALOR}' style='width:50px;'/>
				</td>
			</tr>				
			</table>
		</fieldset>
	</form>
</center>
</body>

<script type='text/javascript'>	

	function saveDatos()
	{
		var Formu = document.forms['formFacturacionCargos'];

				
		if(validarDatosForm(Formu))
		{		
			if(confirm('Esta seguro de realizar esta operacion?'))
			{		
				xajax_updateDatosFacturacionDeCargos(xajax.getFormValues('formFacturacionCargos'));
			}	
		} 		
	}

	
	function validarDatosForm() 
	{
		
		var Formu = document.forms['formFacturacionCargos'];
		var errores = '';
		 
		with (Formu)
		{
			if(idGrupoAfinidad.value == 0 )	
			errores += "- Seleccione un Grupo de Afinidad.\n";			
			
			if(idTipoAjuste.value == 0 )	
			errores += "- Seleccione un Tipo de Ajuste.\n";		
						
			if(idVariableTipoAjuste.value == 0 )	
			errores += "- Seleccione Variable Tipo Ajuste.\n";
			
			if(idTipoFacturacion.value == 0 )	
			errores += "- Seleccione un Tipo de Faturacion.\n";
			
			if( !trim(fValor.value) )
			errores += "- El campo Valor es obligatorio.\n";			
		}
		
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	
	function resetDatosForm()
	{
		var Formu = document.forms['formFacturacionCargos'];
		
		Formu.idFacturacionCargos.value = 0;
		Formu.idGrupoAfinidad.value = 0;
		Formu.idTipoAjuste.value = 0;
		Formu.idVariableTipoAjuste.value = 0;
		Formu.idTipoFacturacion.value = 0;
		Formu.fValor.value = "";
		Formu.sEstado.value = "A";				
	}

</script>
