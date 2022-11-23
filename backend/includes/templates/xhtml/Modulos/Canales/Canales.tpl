<center>
	<div id='' style='width:65%;text-align:right;margin-right:10px;'>
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Canal' border='0' hspace='4' align='absmiddle'> [F9] Guardar</a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Canal' alt='Nuevo Canal' border='0' hspace='4' align='absmiddle'> Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<a href="CanalesVentas.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='Buscar Canales' alt='Buscar Canales' border='0' hspace='4' align='absmiddle'> Volver</a>
	</div>
	<form id="formCanal" action="AdminCanales.php" method="POST">
	
		<input type="hidden" id="idCanal" name="idCanal" value="{ID_CANAL}" />
		<input type="hidden" id="sEstado" name="sEstado" value="{ESTADO}" />
		
		<fieldset id='cuadroOficina' style="height:100px;width:300px">
			<legend> Datos del Canal</legend>			
			<table id='TablaCanal' cellpadding="0" cellspacing="5" class="TablaGeneral" width="650px">
			<tr>
				<th> Codigo: </th>
				<td> 
					<input id="sCodigo" name="sCodigo" value='{CODIGO}' type='text' style='width:200px;' readonly='readonly' />
				</td>
				<th> Nombre: </th>
				<td class='borde'> <input id="sNombre" name="sNombre" value='{NOMBRE}' type='text' style='width:200px;' onKeyUp="aMayusculas(this.value,this.id)"/> <sup>*</sup> </td>
			</tr>
			<tr>
				<th> Region: </th>
				<td><select id="idRegion" name="idRegion" class="FormTextBox" style='width:200px;'>
					{optionsRegiones}
				</select> <sup>*</sup>
				</td>
			</tr>
			</table>
		</fieldset>
	</form>
</center>
<script>
	document.getElementById('sNombre').focus(); 
	
	function saveDatos(){
		var Formu = document.forms['formCanal'];
		
		if(validarDatosForm(Formu))
		{		
			if(confirm('Esta seguro de realizar esta operacion?'))
			{		
				xajax_updateDatosCanales(xajax.getFormValues('formCanal'));
			}	
		}		
	}

	
	function validarDatosForm(){
		var Formu = document.forms['formCanal'];
		var errores = '';
		 
		with (Formu)
		{
			if( !trim(sNombre.value) )
			errores += "- El campo Nombre es requerido.\n";			
			
			if( idRegion.value == 0 )
			errores += "- El campo Region es requerido.\n";	
		}
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	function resetDatosForm(){
		window.location = "AdminCanales.php?action=new";
		/*var Formu = document.forms['formCanal'];
		
		Formu.idCanal.value = 0;
		Formu.sNombre.value = "";*/
		//Formu.iNumeroModeloResumen.value = "";
	}
	
</script>
