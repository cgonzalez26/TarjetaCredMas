<center>
	<div id='' style='width:65%;text-align:right;margin-right:10px;'>
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Promotor' border='0' hspace='4' align='absmiddle'> [F9] Guardar</a>
		&nbsp;&nbsp;			
		<a href="Promotores.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='Buscar Promotores' alt='Buscar Promotores' border='0' hspace='4' align='absmiddle'> Volver</a>
	</div>
	<form id="formPromotor" action="AdminPromotores.php" method="POST">
	
		<input type="hidden" id="idEmpleado" name="idEmpleado" value="{ID_EMPLEADO}" />
		<input type="hidden" id="idOficina" name="idOficina" value="{ID_OFICINA}" />
		<input type="hidden" id="sEstado" name="sEstado" value="{ESTADO}" />
		<input type="hidden" id="idGrupoPromotor" name="idGrupoPromotor" value="{ID_GRUPOPROMOTOR}" />
		
		<fieldset id='cuadroOficina' style="height:120px;width:300px">
			<legend> Datos del Promotor</legend>			
			<table id='TablaCanal' cellpadding="0" cellspacing="5" class="TablaGeneral" width="650px">
			<tr>
				<th> Empleado: </th>
				<td> 
					<select id="idEmpleado" name="idEmpleado" class="FormTextBox">
					{optionsEmpleados}
				</select>
				</td>
			</tr>
			<tr>
				<th> Canal:</th>
				<td><select id="idCanal" name="idCanal" class="FormTextBox">
					{optionsCanales}
				</select>
				</td>
			</tr>
			</table>
		</fieldset>
	</form>
</center>
<script>
	//document.getElementById('sDescripcion').focus(); 
	
	function saveDatos(){
		var Formu = document.forms['formPromotor'];
		/*if(validarDatosForm(Formu))
		{*/		
			if(confirm('Esta seguro de realizar esta operacion?'))
			{		
				xajax_updateDatosPromotores(xajax.getFormValues('formPromotor'));
			}	
		//}		
	}

	
	function validarDatosForm(){
		var Formu = document.forms['formPromotor'];
		var errores = '';
		 
		with (Formu){
			if( idCanal.value == 0 )
			errores += "- El campo Canal es requerido.\n";					
		}		
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	function resetDatosForm(){
		window.location = "AdminPromotores.php?action=new";
	}
</script>