<body style="background-color:#FFFFFF">
<center>
	<div id='' style='width:75%;text-align:right;margin-right:10px;'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Empleado' border='0' hspace='4' align='absmiddle'> 
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Empleado' alt='Nuevo Empleado' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<img src='{IMAGES_DIR}/back.png' title='Buscar Empleado' alt='Buscar Empleado' border='0' hspace='4' align='absmiddle'> 
		<a href="Empleados.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
	<form id="formEmpleado" action="AdminEmpleados.php" method="POST">
	<input type="hidden" id="idEmpleado" name="idEmpleado" value="{ID_EMPLEADO}" />
	<input type="hidden" id="hdnLogin" name="hdnLogin" value="{LOGIN}" />

	<fieldset id='cuadroEmpleado' style="height:355px;width:80%">
		<legend> Datos del Empleado</legend>			
		<table id='TableCustomer' cellpadding="0" cellspacing="5" class="TableCustomer">
		<tr>
			<th class='borde'> Apellido: </th>
			<td> <input id="sApellido" name="sApellido" value='{APELLIDO}' type='text' style='width:200px;'/> <sup>*</sup></td>
		    
			<th> Nombre: </th>
			<td class='borde'> <input id="sNombre" name="sNombre" value='{NOMBRE}' type='text' style='width:200px;'/> <sup>*</sup> </td>
		</tr>
		
		<tr>
			<th class='borde'> Sucursal: </th>
			<td>
				<select name='idSucursal' id='idSucursal' style='width:200px;'>
				{OPTIONS_SUCURSALES}
				</select>
			</td>
			<th class='borde'> Oficina: </th>
			<td>
				<select name='idOficina' id='idOficina' style='width:200px;'>
				{OPTIONS_OFICINAS}
				</select>
			</td>
		</tr>			
		
		<tr>
	    	<th class='borde'> Area: </th>
			<td>
				<select name='idArea' id='idArea' style='width:200px;'>
				{OPTIONS_AREAS}
				</select>
			</td>
	    	<th class='borde'>Email:</th>
	    	<td><input type='text' id="sMail" name='sMail' value='{MAIL}' style='width:200px;'/></td>
		</tr>
		<tr>
	   		<th class='borde'>Direcci&oacute;n:</th>
	    	<td>
	    		<input type='text' id="sDireccion" name='sDireccion' value='{DIRECCION}' style='width:200px;'/></td>	    
	    	<th>Celular:</th>
	    	<td class='borde'><input type='text' id="sMovil" name='sMovil' value='{MOVIL}' style='width:200px;'/>
		    	<br/><span style="font-style:italic;font-size:7pt; " >Ejemplo: 387-4222222<span>
		    	<span style="font-style:italic;font-size:7pt;color: red;" >SIN "0" NI "15"<span>
	    	</td>  
		</tr>		
		<tr>
	        <th class='borde'>Login:</th>
	    	<td><input type='text' id="sLogin" name='sLogin' value='{LOGIN}' style='width:200px;'/> <sup>*</sup></td> 
	    	<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
	    	<th class='borde'>Password:</th>
	    	<td><input type='password' id="sPassword" name='sPassword' value='{MASKPASSWORD}' style='width:200px;'/> <sup>*</sup></td>
	        <th class='borde'>Repetir Password:</th>
	    	<td><input type='password' id="sRepeatPassword" name='sRepeatPassword' value='{MASKPASSWORD}' style='width:200px;'/> <sup>*</sup></td> 
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr>
			<th colspan="4" style="text-align: left">Asignaci&oacute;n de Tipos de Empleados</th>
		</tr>
		<tr>
			<td colspan="4">
				<table id='TableCustomer' cellpadding="5" cellspacing="0" class="TableCustomer" style="border:1px solid;margin:5px">
				<tr>
					<th style='width:200px;text-align: center;border-bottom :1px solid; height:20px' align="center"> Unidad de Negocio </th>
					<th style="text-align: center;border-bottom:1px solid"> Tipo de Empleado </th>
				</tr>
				<tr>
					<th class='borde' style="text-align: center; height:25px"> {UNIDAD_NEGOCIO1} </th>
					<td>
						<select name='idTipoEmpleado1' id='idTipoEmpleado1' style='width:200px;'>
						{OPTIONS_TIPOSEMPLEADOS1}
						</select>
					</td>
				</tr>
				<tr>
					<th class='borde' style="text-align: center; height:25px"> {UNIDAD_NEGOCIO2} </th>
					<td>
						<select name='idTipoEmpleado2' id='idTipoEmpleado2' style='width:200px;'>
						{OPTIONS_TIPOSEMPLEADOS2}
						</select>
					</td>
				</tr>
				<tr>
					<th class='borde' style="text-align: center; height:25px"> {UNIDAD_NEGOCIO3} </th>
					<td>
						<select name='idTipoEmpleado3' id='idTipoEmpleado3' style='width:200px;'>
						{OPTIONS_TIPOSEMPLEADOS3}
						</select>
					</td>
				</tr>
				</table>
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
	function saveDatos(){
		var Formu = document.forms['formEmpleado'];
		if(validarDatosForm(Formu)){
			if(confirm('Esta seguro de realizar esta operacion?')){	
				//viewMessageLoad('divMessage');
				//alert('paso');
				xajax_updateEmpleado(xajax.getFormValues('formEmpleado'));
			}	
		}
	}			
	
	function validarDatosForm() {
		var Formu = document.forms['formEmpleado'];
		var errores = '';
		with (Formu){
			if( !trim(sApellido.value) )
			errores += "- El campo Apellido es requerido.\n";
		
			if( !trim(sNombre.value) )
			errores += "- El campo Nombre es requerido.\n";
				
			if( idOficina.value == 0 )	
			errores += "- El campo Oficina es requerido.\n";
				
			/*if( idTipoEmpleado.value == 0 )
			errores += "- El campo Tipo es requerido.\n";*/
			
			if( !trim(sLogin.value) )	
			errores += "- El campo Login es requerido.\n";
	
			if( !trim(sPassword.value))	
			errores += "- El campo Password es requerido.\n";
	
			if (!trim(sPassword.value))
			errores += "- La campo Contraseña  es requerida.\n";
			
			if (!trim(sRepeatPassword.value))
			errores += "- El campo Repetir Contraseña  es requerido.";
				
			if((sPassword.value != "")||(sRepeatPassword.value!= ""))
				if(sPassword.value != sRepeatPassword.value){
					errores += "- El campo Contraseña y Repetir Contraseña deben ser iguales.";
			}
		}
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	
	function resetDatosForm() {
		var Formu = document.forms['formEmpleado'];
		//Formu.reset();
		Formu.idEmpleado.value = 0;
		Formu.sNombre.value = "";
		Formu.sApellido.value = "";
		Formu.idOficina.value = 0;
		Formu.idTipoEmpleado.value = 0;
		Formu.sDireccion.value = "";
		Formu.sMovil.value = "";
		Formu.sMail.value = "";
		Formu.sLogin.value = "";
		Formu.sPassword.value = "";
		Formu.sRepeatPassword.value = "";
	}

	

</script>