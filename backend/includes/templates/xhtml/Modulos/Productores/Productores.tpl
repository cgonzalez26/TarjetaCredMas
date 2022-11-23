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
		<a href="ProductoresLiderar.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
	<form id="formulario" action="AdminProductoresLiderar.php" method="POST">
	<input type="hidden" id="idProductor" name="idProductor" value="{ID_PRODUCTOR}" />

	<fieldset id='cuadroOficina' style="height:350px;width:50%">
		<legend> Datos del Productor:</legend>			
		<table id='TableCustomer' cellpadding="0" cellspacing="5" class="TableCustomer">		
			<tr>
				<th class="celda_form" style="width:250px"><b>(*)Apellido:</b></th>			
				<td class="celda_form">
					<input type="text" id="sApellido" name="sApellido" maxlength="50" size="25" value="{APELLIDO}">
					<input type="hidden" name="ApeOld" maxlength="50" size="25" value="{APELLIDO}">
				</td>				
				<th class="celda_form"><b>(*)Nombre:</b></th>
				<td class="celda_form">
					<input type="text" id="sNombre" name="sNombre" maxlength="50" size="25" value="{NOMBRE}">
					<input type="hidden" name="NomOld" maxlength="50" size="25" value="{NOMBRE}">
				</td>
			</tr>
			<tr>					
				<th class="celda_form"><b>(*)D.N.I:</b></th>
				<td class="celda_form">
					<input type="text" id="sDni" name="sDni" maxlength="50" size="25" value="{DNI}">
					<input type="hidden" name="DNIOld" maxlength="50" size="25" value="{DNI}">
				</td>
			</tr>
			<tr>
				<th class="celda_form"><b>(*)Direcci&oacute;n:</b></th>
				<td class="celda_form"><input type="text" id="sDireccion" name="sDireccion" style="width:200px;" value="{DIRECCION}"></td>
				<th class="celda_form"><b>Telefono:</b></th>			
				<td class="celda_form"><input type="text" id="sTelefono" name="sTelefono" maxlength="50" size="25" value="{TELEFONO}"></td>
			</tr>
			<tr>
				<th class="celda_form"><b>Movil:</b></th>					
				<td class="celda_form"><input type="text" id="sMovil" name="sMovil" maxlength="50" size="25" value="{MOVIL}"></td>										
				<th class="celda_form"><b>Comision:</b></th>			
				<td class="celda_form"><input type="text" id="iComision" name="iComision" maxlength="50" size="25" value="{COMISION}"></td>
			</tr>
			<tr>
				<th class="celda_form"><b>Matricula:</b></th>
				<td class="celda_form"><input type="text" id="sMatricula" name="sMatricula" maxlength="50" size="25" value="{MATRICULA}">
									<input type="hidden" name="MatriculaOld" maxlength="50" size="25" value="{MATRICULA}"></td>
				<th class="celda_form"><b>(*)Num. de Liderar:</b></th>
				<td class="celda_form"><input type="text" id="sNumeroLiderar" name="sNumeroLiderar" maxlength="50" size="25" value="{NUMERO_LIDERAR}"></td>
			</tr>
			<tr>
				<th class="celda_form"><b>Num. de Producto:</b></th>
				<td class="celda_form">
					<input type="text" id="sNumeroProducto" name="sNumeroProducto" maxlength="50" size="25" value="{NUMERO_PRODUCTO}">
				</td>
				<th class="celda_form"><b>Lugar:</b></th>
				<td colspan="2">
					<input type="text" id="sLugar" name="sLugar" maxlength="50" style="width:200px;" value="{LUGAR}">				
				</td>
			</tr>
			<tr>
				<th class="celda_form"><b>Provincia:</b></th>
				<td class="celda_form">
					<select name='idProvincia' id='idProvincia' style="width:200px;">
					{optionsProvincias}
					</select>		
				</td>
				<th class="celda_form"><b>Localidad:</b></th>
				<td class="celda_form">
					<select name='idLocalidad' id='idLocalidad' style="width:200px;">
					{optionsLocalidades}		
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="left"><b>Observaci&oacute;n:</b></td>
			</tr>
			<tr>
				<td class="celda_form" colspan="4" valign="top">
					<textarea id="sObservaciones" name="sObservaciones" style="width:100%;height:80px">{OBSERVACIONES}</textarea></td>
			</tr>

		</table>
	</fieldset>	
</form>

<script language="javascript">
	function saveDatos(){
		var formu=document.forms['formulario']; 
		if(!validar(document.forms['formulario'])){
			return;
		}
		xajax_updateDatosProductor(xajax.getFormValues('formulario'));
	}	
	function validar(form){
		var errores = "";
		with (form){
			if (sApellido.value <= 0){
				errores += "- El campo Apellido es requerido.\n";
			}
			if (sNombre.value <= 0){
				errores += "- El campo Nombre es requerido.\n";
			}
			if (sDni.value <= 0){
				errores += "- El campo D.N.I. es requerido.\n";
			}		
			if(sDni.value != ""){
				if(!esEntero(sDni.value)){
					errores += "- El campo D.N.I. no es válido.\n";
				}
			}	
			if(sDireccion.value <= 0){
				errores += "- El campo Dirección es requerido.\n";
			}	
			if(sNumeroLiderar.value <= 0){
				errores += "- El campo Num. de Liderar es requerido.\n";
			}	
			if(iComision.value != ""){
				if(!esEntero(iComision.value)){
					errores += "- El campo Comisión no es válido.\n";
				}
			}
		}		
		if (errores){
			alert("Por favor, revise los siguientes errores:\n"+ errores);
			return false;
		}
		else return true;
	}
	
	function esEntero(valor){		 
		 var entero = /([^0-9.]+)/;
	     var expreg = new RegExp(entero);
	     if(!expreg.test(valor))
	          return true;
	     else 
	          return false;  
	}
	//--------------------------------------------
	
	xajax.loadingFunction = function(){
		Dialog.info("<b style='color:#901E76;'><img src='../imagenes/logo2.gif' style='width:200px;'/><br>Por favor espere unos segundos estamos procesando la Peticion...<b>",
		            {width:260, height:150, showProgress: true,className:"alphacube"}
		            );
	}; 
	xajax.doneLoadingFunction = function(){ Dialog.closeInfo(); };
	
	//--------------------------------------------
	
</script>