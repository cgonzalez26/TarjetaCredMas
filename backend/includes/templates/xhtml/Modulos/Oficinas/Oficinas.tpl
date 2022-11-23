<body style="background-color:#FFFFFF">
<center>
	<div id='' style='width:75%;text-align:right;margin-right:10px;'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Oficina' border='0' hspace='4' align='absmiddle'> 
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nueva Oficina' alt='Nueva Oficina' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<img src='{IMAGES_DIR}/back.png' title='Buscar Oficina' alt='Buscar Oficina' border='0' hspace='4' align='absmiddle'> 
		<a href="Oficinas.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
	<form id="formOficina" action="AdminOficinas.php" method="POST">
	<input type="hidden" id="idOficina" name="idOficina" value="{ID_OFICINA}" />

	<fieldset id='cuadroOficina' style="height:230px;width:50%">
		<legend> Datos de Oficina:</legend>			
		<table id='TableCustomer' cellpadding="0" cellspacing="5" class="TableCustomer">
		<tr>
			<th class='borde'> Sucursal: </th>
			<td> 
				<select name='idSucursal' id='idSucursal' style='width:200px;'>
				{OPTIONS_SUCURSALES}
				</select> <sup>*</sup>
			</td>
		    
			<th> Apodo: </th>
			<td class='borde'> <input id="sApodo" name="sApodo" value='{APODO}' type='text' style='width:200px;'/> <sup>*</sup> </td>
		</tr>
		<tr>
	   		<th class='borde'>Direcci&oacute;n:</th>
	    	<td><input type='text' id="sDireccion" name='sDireccion' value='{DIRECCION}' style='width:200px;'/> <sup>*</sup></td>	    
			<th>Tel. de la Oficina:</th>
			<td>
				<input type='text' id="sTelefono" name='sTelefono' value='{TELEFONO}' style='width:200px;'/>
			</td>
		</tr>
		<tr>
		</tr>
		<tr>
			<th>Celular 1:</th>
			<td>
				<input type='text' id="sCelular1" name='sCelular1' value='{CELULAR1}' style='width:200px;'/>
			</td>
			<th>Celular 2:</th>
			<td>
				<input type='text' id="sCelular2" name='sCelular2' value='{CELULAR2}' style='width:200px;'/>
			</td>		
		</tr>
		<tr>
			<th>Provincia:</th>
			<td class="celda_form">
				<select style="width: 150px;" id="idProvincia" name="idProvincia">
				{OPTIONS_PROVINCIAS}
				</select>
			</td>	
			<th>Localidad:</th>
			<td class="celda_form">
				<select style="width: 150px;" id="idLocalidad" name="idLocalidad">
					<option value='0'>Seleccione una Provincia ... </option>
				</select>{SCRIPT_LOCALIDADES}
			</td>
		</tr>
		<tr>
			<th>Codigo Postal: </th>
			<td>
				<input type='text' id="sCodigoPostal" name='sCodigoPostal' value='{CP}' style='width:200px;'/>
			</td>
	    	<th>Fecha de Inicio:</th>
	    	<td class='borde'><input type='text' id="dFechaInicio" name='dFechaInicio' value='{FECHA_INICIO}' style='width:200px;'/>
	    	<br/><span style="font-style:italic;font-size:7pt; " >Ejemplo: dd/mm/aaaa<span>	    				
	    	</td>  
			
		</tr>
		</table>
		
	</fieldset>
	</form>
<!--
{TAG_ADICIONALES}
-->


<input type='hidden' id="id_aseguradoID" name='asegurado[ID]' value='{asegurado_ID}' />

<script type='text/javascript'>		

	InputMask("dFechaInicio","99/99/9999");

	function saveDatos()
	{
		var Formu = document.forms['formOficina'];
		
		if(validarDatosForm(Formu))
		{
			if(confirm('Esta seguro de realizar esta operacion?'))
			{				
				xajax_updateOficina(xajax.getFormValues('formOficina'));
			}	
		}
	}			
	
	function validarDatosForm() {
		var Formu = document.forms['formOficina'];
		var errores = '';
		with (Formu){
			if( idSucursal.value == 0 )	
			errores += "- El campo Sucursal requerido.\n";
			
			if( !trim(sApodo.value) )
			errores += "- El campo Apodo es requerido.\n";
		
			if( !trim(sDireccion.value) )
			errores += "- El campo Dirección es requerido.\n";
		}
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	
	function resetDatosForm() {
		var Formu = document.forms['formOficina'];
		//Formu.reset();
		Formu.idOficina.value = 0;
		Formu.idSucursal.value = 0;
		Formu.sApodo.value = "";
		Formu.sDireccion.value = "";
		Formu.dFechaInicio.value = "";
	}

</script>