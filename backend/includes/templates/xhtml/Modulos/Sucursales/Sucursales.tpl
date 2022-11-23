<body style="background-color:#FFFFFF">
<center>
	<div id='' style='width:75%;text-align:right;margin-right:10px;'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar sucursal' border='0' hspace='4' align='absmiddle'> 
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nueva sucursal' alt='Nueva sucursal' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<img src='{IMAGES_DIR}/back.png' title='Buscar sucursal' alt='Buscar sucursal' border='0' hspace='4' align='absmiddle'> 
		<a href="Sucursales.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
	<form id="formSucursal" action="AdminSucursales.php" method="POST">
	<input type="hidden" id="idSucursal" name="idSucursal" value="{ID_SUCURSAL}" />
	<input type="hidden" id="iOtrosDatos" name="iOtrosDatos" value={iOtrosDatos} />
	<input type="hidden" id="num_suc_old" name="num_suc_old" value="{NUMERO_SUCURSAL}">
	
	<fieldset id='cuadroSucursal' style="height:250px;width:50%">
		<legend> Datos de Sucursal</legend>			
		<table id='TableCustomer' cellpadding="0" cellspacing="5" class="TableCustomer" width="100%">
		<tr>
			<th class='borde' style="width:150px"> Regi&oacute;n: </th>
			<td> 
				<select name='idRegion' id='idRegion' value ="{ID_REGION}" style='width:200px;' tabindex="1">
				{OPTIONS_REGIONES}
				</select> <sup>*</sup>
			</td>
		    <th class='borde'> Provincia: </th>
			<td align="left">
				<select name="idProvincia" id="idProvincia" class="FormTextBox" tabindex="6" style='width:200px;'>
					{optionsProvincias}
				</select>
			</td>				
		</tr>
		<tr>
			<th> N&uacute;mero Sucursal: </th>
			<td class='borde'> 
				<input id="sNumeroSucursal" name="sNumeroSucursal" value='{NUMERO_SUCURSAL}' type='text' tabindex="2" style='width:200px;'/> <sup>*</sup>
			</td>	
			<th class='borde'> Nombre: </th>
			<td class='borde'> <input id="sNombre" name="sNombre" value='{NOMBRE}' type='text' tabindex="3" style='width:200px;'/> <sup>*</sup> </td>			
		</tr>
		<tr>
			<th>Fecha de Inicio:</th>
	    	<td class='borde'><input type='text' id="dFechaInicio" name='dFechaInicio' value='{FECHA_INICIO}' tabindex="4" style='width:200px;'/> <sup>*</sup>
	    	<br/><span style="font-style:italic;font-size:7pt; " >Ejemplo: dd/mm/aaaa<span>	    				
	    	</td>  	    	
		</tr>
	</table>	
		<div id="divCampos" name="divCampos" style="{MOSTRAR_OTROSDATOS}">
			<table id='TableCustomer' cellpadding="0" cellspacing="5" class="TableCustomer"  width="100%">
			<tr>
				<th class='borde' style="width:150px"> Localidad: </th>
				<td align="left">
				<select name="idLocalidad" id="idLocalidad" class="FormTextBox" tabindex="7" style='width:200px;'>
					{optionsLocalidades}
				</select>
				</td>	
				<td colspan="2">&nbsp;</td>					
			</tr>
			<tr>
				<th class='borde'> Comision Vieja: </th>
				<td class='borde'> 
					<input id="fComisionVieja" name="fComisionVieja" value='{COMISION_VIEJA}'  onblur="this.value = numero_parse_flotante(this.value);" type='text' tabindex="2" style='width:200px;'/> <sup>*</sup>
				</td>	
				<th class='borde'> Comision Nueva: </th>
				<td class='borde'> 
					<input id="fComisionNueva" name="fComisionNueva" value='{COMISION_NUEVA}' type='text' onblur="this.value = numero_parse_flotante(this.value);" tabindex="2" style='width:200px;'/> <sup>*</sup>
				</td>	
			</tr>
			
			</table>
		</div>
		
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
		var Formu = document.forms['formSucursal'];
		if(validarDatosForm(Formu)){
			if(confirm('Esta seguro de realizar esta operacion?')){	
				xajax_updateSucursal(xajax.getFormValues('formSucursal'));
			}	
		}
	}			
	
	function validarDatosForm() 
	{
		var Formu = document.forms['formSucursal'];
		var errores = '';
		 
		with (Formu){
			if( idRegion.value == 0 )	
			errores += "- El campo Region es requerido.\n";
			
			if( sNumeroSucursal.value == "" )
			errores += "- El campo Numero de sucursal es requerido.\n";
				
			if( sNombre.value == "" )
			errores += "- El campo Nombre es requerido.\n";

			if( dFechaInicio.value == "" )
			errores += "- El campo Fecha de Inicio es requerido.\n";	
		}
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	
	function resetDatosForm() {
		var Formu = document.forms['formSucursal'];
		//Formu.reset();
		Formu.idSucursal.value = 0;
		Formu.idRegion.value = 0;
		Formu.idProvincia.value= 0;
		Formu.sNombre.value = "";
		Formu.dFechaInicio.value = "";
		Formu.sNumeroSucursal.value = "";
		Formu.idLocalidad.value= 0;
		Formu.fComisionVieja.value = "";
		Formu.fComisionNueva.value = "";
	}

	function mostrarCampos(parametro){
		if(parametro == 1)	{
			document.getElementById('divCampos').style.display='inline';
			document.getElementById('iOtrosDatos').value = 1;
		}else{
			document.getElementById('divCampos').style.display='none';
			document.getElementById('iOtrosDatos').value = 0;
		}
	}

</script>