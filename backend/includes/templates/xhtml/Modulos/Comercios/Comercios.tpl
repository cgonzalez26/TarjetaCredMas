<center>

<div style="width:800px;">
	<div id='' style='width:90%;text-align:right;'>
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Comercio' border='0' hspace='4' align='absmiddle'> [F9] Guardar</a>
		&nbsp;&nbsp;			
		<!--<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Limite' alt='Nuevo Limite' border='0' hspace='4' align='absmiddle'> Nuevo</a>
			&nbsp;&nbsp;			
		</div>-->
		<a href="Comercios.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='Regresar' alt='Regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>

<form id="formComercio" action="AdminComercios.php" method="POST">	
	<input type="hidden" name="_op" id="_op" value="{_op}" />	
	<input type="hidden" name="_i" id="_i" value="{_i}" />	
	<fieldset id='cuadroAjuste' style="width:860px;border:1px solid #CCC;">
	<legend>COMERCIOS</legend>
    <table cellpadding="0" cellspacing="0" width="100%" border="0" align="center" class="TablaGeneral">  
    <tr>
    <td valign="top" style="padding-top:20px">
    
	    <table cellspacing="0" cellpadding="0" width="90%" align="center" border="0" class="TablaGeneral">
			<tbody>
			<!--<tr>
				<td valign="middle" align="center" height="20" class="Titulo">
					COMERCIOS	
				</td>
			</tr>-->
			<tr>
				<td align="left" bgcolor="#ffffff" style="height:20px;color:red;font-weight:bold">
					<div id="div_message">{message}</div>
				</td>
			</tr>

			<tr>
				<td class="SubHead" align="left" bgcolor="#ffffff">
					<table id="TablaTitular" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
						<tbody>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5">
								<label id="Solicitudes_plTituloTitular">Datos del Comercio:
								</label>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>(*)Nombre Fantasia:</span>
							</td>
							<td class="SubHead">
								<span>(*)Razon Social:</span>
							</td>								
							<td class="SubHead">
								<span>(*)C.U.I.T.:</span>
							</td>		
							<td class="SubHead">
								<span>(*)Forma Juridica:</span>
							</td>
							<td>
								<span>(*)Inico Actividad:</span>
							</td>								
						</tr>
						
						<tr>
							<td valign="top">
								<input id="sNombreFantasia" name="sNombreFantasia" type="text" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas_SinEspeciales(this.value,this.id);" value="{sNombreFantasia}" maxlength="50"></td>
							<td valign="top">
								<input id="sRazonSocial"  name="sRazonSocial" type="text" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas_SinEspeciales(this.value,this.id);" value="{sRazonSocial}" maxlength="50">
							</td>														
							<td class="SubHead">
								<input name="sCUIT" type="text" id="sCUIT" class="FormTextBox" onKeyDown="redirectObject(event,this,12);" value="{sCUIT}">
							</td>
							<td class="SubHead">
								<input id="sFormaJuridica"  name="sFormaJuridica" type="text" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas_SinEspeciales(this.value,this.id);" value="{sFormaJuridica}" maxlength="50">
							</td>	
							<td>
								<input id="dFechaInicioActividad" name="dFechaInicioActividad" type="text" class="FormTextBox" style="width:150px;" value="{dFechaInicioActividad}" onKeyDown="redirectObject(event,this,14);">
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>(*)Sector:</span>
							</td>
							<td class="SubHead">
								<span>(*)Ingresos Brutos:</span>
							</td>
							<td class="SubHead">
								<span>(*)Domicilio Comercial:</span>
							</td>								
							<td class="SubHead">
								<span>(*)Domicilio Solicitar Comp.:</span>
							</td>		
							<td class="SubHead">
								
							</td>

						</tr>
						<tr>
							<td class="SubHead">
								<input name="sSector" type="text" id="sSector" class="FormTextBox" onKeyUp="aMayusculas(this.value,this.id);" value="{sSector}">
							</td>	
							<td valign="top">
								<input id="sIngresosBrutoDGR" name="sIngresoBrutoDGR" type="text" class="FormTextBox" style="width:200px;" value="{sIngresoBrutoDGR}" maxlength="50"></td>
							<td valign="top">
								<input id="sDomicilioComercial"  name="sDomicilioComercial" type="text" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id);" value="{sDomicilioComercial}" maxlength="50">
							</td>														
							<td class="SubHead">
								<input name="sDomicilioSolicitarComprobante" type="text" id="sDomicilioSolicitarComprobante" class="FormTextBox" onKeyUp="aMayusculas(this.value,this.id);" value="{sDomicilioSolicitarComprobante}">
							</td>
							<td>

							</td>
						</tr>						
						
						
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5">
								<label id="Solicitudes_plTituloTitular">Datos del Responsable:
								</label>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>(*)Apellido:</span>
							</td>
							<td class="SubHead">
								<span>(*)Nombre:</span>
							</td>
							<td class="SubHead">
								<span>(*)Telefono:</span>
							</td>		
							<td class="SubHead">
								<span>(*)Email:</span>
							</td>
							<td>
								<span>(*)Fax:</span>
							</td>								
						</tr>
						
						<tr>
							<td valign="top">
								<input id="sApellido"  name="sApellido" type="text" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas_SinEspeciales(this.value,this.id);" value="{sApellido}" maxlength="50">
							</td>						
							<td valign="top">
								<input id="sNombre" name="sNombre" type="text" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas_SinEspeciales(this.value,this.id);" value="{sNombre}" maxlength="50">
							</td>
							<td class="SubHead">
								<input name="sTelefono" type="text" id="sTelefono" class="FormTextBox" onblur="validarCuit(this)" value="{sTelefono}">
							</td>
							<td class="SubHead">
								<input id="sMail"  name="sMail" type="text" class="FormTextBox" style="width:200px;" value="{sMail}" maxlength="50">
							</td>	
							<td>
								<input id="sFax" name="sFax" type="text" class="FormTextBox" style="width:150px;" value="{sFax}">
							</td>
						</tr>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5">
								<label> Condiciones del Comercio </label>
							</td>
						</tr>						
						<tr>
							<td class="SubHead">
							
								(*)Condicion Comercio:
							</td>
							<td>
								(*)Rubro:
							</td>
							<td>
								(*)SubRubro:
							</td>
													


							<td class="SubHead">
								(*)Condicion AFIP:
							</td>	
							<td>
								(*)Condicion D.G.R.:
							</td>							

							
						</tr>
						<tr>
							<td valign="top">
								<select id="idCondicionComercio" name="idCondicionComercio" class="FormTextBox" style="width:200px;">
									{optionsCondicionesComercios}
								</select>
							</td>
							<td valign="top">
								<select id="idRubro" name="idRubro" class="FormTextBox" style="width:200px;">
									{optionsRubros}
								</select>
							</td>
							<td valign="top">
								<select id="idSubRubro" name="idSubRubro" class="FormTextBox" style="width:200px;">
									{optionsSubRubros}
								</select>
							</td>							
							<td valign="top">
								<select id="idCondicionAFIP" name="idCondicionAFIP" class="FormTextBox" style="width:200px;">
									{optionsCondicionesAFIP}
								</select>
							</td>
							<td valign="top">
								<select id="idCondicionDGR" name="idCondicionDGR" class="FormTextBox" style="width:150px;">
									{optionsCondicionesDGR}
								</select>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								(*)Retenciones IVA:
							</td>						
							<td>
								(*)Cond. Retencion Ganancias:
							</td>
							<td class="SubHead">
								(*)Retenciones DGR:
							</td>
							<td class="SubHead">
								
							</td>							
							<td class="SubHead">
								<!--(*)Tipo Comercio:-->
							</td>	
							
						</tr>
						<tr>
							<td valign="top">
								<select id="idRetencionIVA" name="idRetencionIVA" class="FormTextBox" style="width:200px;">
									{optionsRetencionesIVA}
								</select>
							</td>
							<td valign="top">
								<select id="idRetencionGanancia" name="idRetencionGanancia" class="FormTextBox" style="width:200px;">
									{optionsRetencionesGanancias}
								</select>
							</td>
							<td valign="top">
								<select id="idRetencionDGR" name="idRetencionDGR" class="FormTextBox" style="width:200px;">
									{optionsRetencionesDGR}
								</select>
							</td>
							<td valign="top">

							</td>							
							<td valign="top">
								<!--<select id="idTipoComercio" name="idTipoComercio" class="FormTextBox" style="width:200px;">
									{optionsTiposComercios}
								</select>-->
							</td>
						</tr>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5">
								<label> Convenios </label>
							</td>
						</tr>						
						<tr>
							<td>
								(*)Forma Pago
							</td>						
							<td class="SubHead">							
								(*)Banco:
							</td>
							<td>
								(*)CBU:
							</td>
							<td class="SubHead">
								
							</td>	
							<td>
								
							</td>							
						<tr>
							<td valign="top">
								<select id="idFormaPago" name="idFormaPago" class="FormTextBox" style="width:200px;">
									{optionsFormasPagos}
								</select>
							</td>						
							<td valign="top">
								<select id="idBanco" name="idBanco" class="FormTextBox" style="width:200px;">
									{optionsBancos}
								</select>
							</td>
							<td valign="top">
								<input id="sCBU" name="sCBU" type="text" class="FormTextBox" style="width:200px;" value="{sCBU}">
							</td>
							<td valign="top">

							</td>							
							<td valign="top">
							</td>
						</tr>
							
						</tr>						
						</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td class="SubHeadRed" align="left" height="30">&nbsp;
						</td>
				</tr>
				<tr valign="top">
					<td class="SubHead">
						(*)Datos requeridos.
						</td>
				</tr>
				<tr valign="top">
					<td align="center">
						<!--<input type="button" id="cmd_alta" name="cmd_alta" onclick="javascript:darAltaSolicitud();" value="Dar Alta" {MOSTRAR_DAR_ALTA} tabindex="81"/>&nbsp;&nbsp;
						<input type="button" id="cmd_enviar" name="cmd_enviar" onclick="javascript:sendFormSolicitud();" value="Guardar" {MOSTRAR_GUARDAR} tabindex="82"/>&nbsp;&nbsp;
						<input type="button" id="cmd_borrar" name="cmd_borrar" onclick="this.form.reset()" value="Borrar" {MOSTRAR_BORRAR} tabindex="83"/>
						<input type="button" id="cmd_volver" name="cmd_volver" onclick="window.location='{URL_PRINCIPAL}'" value="Volver" tabindex="84"/>-->
					</td>
				</tr>
			</table>
		</fieldset>	
		
	</form>
</center>
<script>

	InputMask('dFechaInicioActividad','99/99/9999');
	
	document.getElementById('sNombreFantasia').focus(); 
	
	function saveDatos(){
		var Formu = document.forms['formComercio'];
		
		if(validarDatosForm()){		
			
			if(confirm('Esta seguro de realizar esta operacion?')){
				xajax_sendFormComercio(xajax.getFormValues('formComercio'));
			}
	
		}		
	}
	
	
	function validarDatosForm(){
		var Formu = document.forms['formComercio'];
		var errores = '';
		
		if (Formu.sNombreFantasia.value == ""){
			errores += 'El campo Nombre de Fantasia es requerido.\n';
		}

		if (Formu.sRazonSocial.value == ""){
			errores += 'El campo Razon Social es requerido.\n';
		}
		
		if (Formu.sCUIT.value == ""){
			errores += 'El campo CUIT es requerido.\n';
		}
		
		if (Formu.sFormaJuridica.value == ""){
			errores += 'El campo Forma Juridica es requerido.\n';
		}
		
		if (Formu.dFechaInicioActividad.value == ""){
			errores += 'El campo Fecha Inicio Actividad es requerido.\n';
		}
		
		if (Formu.sSector.value == ""){
			errores += 'El campo Sector es requerido.\n';
		}		
		
		if (Formu.sIngresoBrutoDGR.value == ""){
			errores += 'El campo Ingresos Brutos D.G.R. es requerido.\n';
		}
		
		if (Formu.sDomicilioComercial.value == ""){
			errores += 'El campo Domicilio Comercial es requerido.\n';
		}
		
		if (Formu.sDomicilioSolicitarComprobante.value == ""){
			errores += 'El campo Domicilio Solicitar Comprobante es requerido.\n';
		}
		
		if (Formu.sApellido.value == ""){
			errores += 'El campo Apellido de Responsable es requerido.\n';
		}
		
		if (Formu.sNombre.value == ""){
			errores += 'El campo Nombre de Responsable es requerido.\n';
		}
		
		if (Formu.sTelefono.value == ""){
			errores += 'El campo Telefono de Responsable es requerido.\n';
		}
		
		if (Formu.sMail.value == ""){
			errores += 'El campo Email de Responsable es requerido.\n';
		}
		
		if (Formu.sFax.value == ""){
			errores += 'El campo Fax de Responsable es requerido.\n';
		}
		
		if(Formu.idCondicionComercio.value == 0){
			errores += 'El campo Condicion Comercio es requerido. \n';
		}
				
		if(Formu.idRubro.value == 0){
			errores += 'El campo Rubro es requerido. \n';
		}

		if(Formu.idSubRubro.value == 0){
			errores += 'El campo SubRubro es requerido. \n';
		}
		
		if(Formu.idCondicionAFIP.value == 0){
			errores += 'El campo Condicion AFIP es requerido. \n';
		}

		if(Formu.idCondicionDGR.value == 0){
			errores += 'El campo Condicion D.G.R. es requerido. \n';
		}
				
		/*if(Formu.idTipoComercio.value == 0){
			errores += 'El campo Tipo Comercio es requerido. \n';
		}*/
		
		if(Formu.idRetencionIVA.value == 0){
			errores += 'El campo Retencion I.V.A. es requerido. \n';
		}
				
		if(Formu.idRetencionGanancia.value == 0){
			errores += 'El campo Retencion Ganancia es requerido. \n';
		}
		
		if(Formu.idRetencionDGR.value == 0){
			errores += 'El campo Retencion D.G.R. es requerido. \n';
		}

	
		if( errores ) { alert('Han ocurrido los siguientes errores: \n' + errores); return false; } 
		else return true;
	}
	
	function resetDatosForm(){
		//window.location = "AdminComercios.php?action=new";
	}
	
	
	function aMayusculas_SinEspeciales(obj,id){
		 var RegExPattern = /[a-zA-Z]/; 
		 
		 //if(obj.match(RegExPattern)){
		 	obj = obj.replace(/([^a-zA-Z¡…Õ”⁄·ÈÌÛ˙\t\s]+)/,'');
		 	obj = obj.toUpperCase();
	 	document.getElementById(id).value = obj;
		 //}
	}

	function aMayusculas(obj,id){
		 var RegExPattern = /[a-zA-Z]/;
		 
		 	obj = obj.replace(/([^a-zA-Z0-9¡…Õ”⁄·ÈÌÛ˙\t\s]+)/,'');
		 	obj = obj.toUpperCase();
	 	document.getElementById(id).value = obj;
		 //}
	}	
	
	function validarCuit(obj){
		if(!validaCuit(obj.value)){
			//alert("El Numero de CUIT no es valido.");
			return false;
		}else{
			return true;	
		}
		
	}	
	
	function validarFecha(obj){
		if(!validaFecha(obj.value)){
			//alert('-La Fecha no es valida.\n');
			return false;
		}else{
			return true;
		}
	}
	
	function resetForm(){
		
		document.getElementById('idRetencionGanancia').value = 0;
		
		document.getElementById('idCondicionDGR').value = 0;
		
		document.getElementById('idCondicionAFIP').value = 0;
		
		document.getElementById('idCondicionComercio').value = 0;
		
		document.getElementById('idRetencionIVA').value = 0;
		
		document.getElementById('idRubro').value = 0;
		
		document.getElementById('idSubRubro').value = 0;
		
		/*document.getElementById('idTipoComercio').value = 0;*/
		
		document.getElementById('idRetencionDGR').value = 0;
		
		document.getElementById('sNombreFantasia').value = '';
		
		document.getElementById('sRazonSocial').value = '';
		
		document.getElementById('sCUIT').value = '';
		
		document.getElementById('sFormaJuridica').value = '';
		
		document.getElementById('dFechaInicioActividad').value = '';
		
		document.getElementById('sIngresosBrutosDGR').value = '';
		
		document.getElementById('sDomicilioComercial').value = '';
		
		document.getElementById('sDomicilioSolicitarComprobante').value = '';
		
		document.getElementById('sNombre').value = '';
		
		document.getElementById('sApellido').value = '';
		
		document.getElementById('sTelefono').value = '';
		
		document.getElementById('sMail').value = '';
		
		document.getElementById('sFax').value = '';

	}


	/*Prueba para simular TAB ::: ENTER*/
	function redirectObject(e,object,option){
		var k=null;
		var Formu = document.forms['formComercio'];	
		
		(e.keyCode) ? k=e.keyCode : k=e.which;
		
		
		
		if(k == 13 || k == 9 || k == 11) {
			//if(object){

				//e.cancelBubble is supported by IE ñ this will kill the bubbling process.
				e.cancelBubble = true;
				e.returnValue = false;
				//e.stopPropagation works only in Firefox.
				if (e.stopPropagation) {
					e.stopPropagation();
					e.preventDefault();
				}

				switch (option) {
				    case 1:
				       
				       break;
				    case 12:
 							//onblur="validarCuit(this)"
 							var check = validarCuit(object);
 							
 							if(check){

 								document.getElementById('sFormaJuridica').focus();

 							}else{

	 							alert("El Numero de CUIT no es valido.");

	 							document.getElementById('sCUIT').focus();

								//return false;

 							}
 							
				       break
				    case 14:
				    	// onchange="validarFecha(this)"
 							
 							var check = validarFecha(object);
 							
 							if(check){

 								document.getElementById('sSector').focus();

 							}else{

	 							alert('-La Fecha no es valida.\n');

	 							document.getElementById('dFechaInicioActividad').focus();

								//return false;

 							}				    	
				    break;   

				    default:
				       
				} 

			//}
		}
	}
	
	shortcut.add("F9",function (){
			saveDatos();
	},{
		'type':'keydown',
		'propagate':true,
		'target':document
	});	
	
	

</script>