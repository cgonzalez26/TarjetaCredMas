<center>

<div style="width:800px;">
	<div id='' style='width:500px;text-align:right;'>
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Plan' border='0' hspace='4' align='absmiddle'> [F9] Guardar</a>
		&nbsp;&nbsp;			
		<!--<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Limite' alt='Nuevo Limite' border='0' hspace='4' align='absmiddle'> Nuevo</a>
			&nbsp;&nbsp;			
		</div>-->
		<a href="PromocionesPlanes.php?_i={_ic}" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='regresar' alt='regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>

<form id="FormPromocionesPlanes" action="AdminPromocionesPlanes.php" method="POST">	
	<input type="hidden" name="_op" id="_op" value="{_op}" />	
	<input type="hidden" name="_i" id="_i" value="{_i}" />	
	<input type="hidden" name="_ic" id="_ic" value="{_ic}" />	
   <table cellpadding="0" cellspacing="0" width="600" border="0" align="center" class="TablaGeneral">
  
   <tr>
    <td valign="top" style="padding-top:20px">
    
	    <table cellspacing="0" cellpadding="0" width="600" align="center" border="0" class="TablaGeneral">
			<tbody><tr>
				<td valign="middle" align="center" height="20" class="Titulo">
					PROMOCIONES PLANES	
				</td>
			</tr>
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
								<label id="">Promociones Planes:
								</label>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>(*)Tipo Plan :</span>
							</td>
							<td class="SubHead">
								<span>(*)Nombre:</span>
							</td>								

							
						</tr>
						
						<tr>
							<td valign="top">
								<select id="idTipoPlan" name="idTipoPlan" class="FormTextBox" style="width:200px;">
									{optionsTiposPlanes}
								</select>
							<td valign="top">
								<input id="sNombre" name="sNombre" type="text" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id);" value="{sNombre}"></td>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>(*)Vigencia Desde:</span>
							</td>
							<td class="SubHead">
								<span>(*)Vigencia Hasta:</span>
							</td>							
						</tr>
						<tr>
							<td class="SubHead">
								<input name="dVigenciaDesde" type="text" id="dVigenciaDesde" class="FormTextBox" value="{dVigenciaDesde}" onKeyDown="redirectObject(event,this,1);">
							</td>
							<td class="SubHead">
								<input name="dVigenciaHasta" type="text" id="dVigenciaHasta" class="FormTextBox" value="{dVigenciaHasta}" onKeyDown="redirectObject(event,this,2);">
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>(*)Dia Cierre:</span>
							</td>		
							<td class="SubHead">
								<span>(*)Dia Corrido Pago:</span>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<input name="iDiaCierre" type="text" id="iDiaCierre" class="FormTextBox" onKeyUp="this.value=numero_parse_entero(this.value);" value="{iDiaCierre}">
							</td>
							<td class="SubHead">
								<input name="iDiaCorridoPago" type="text" id="iDiaCorridoPago" class="FormTextBox" onKeyUp="this.value=numero_parse_entero(this.value);" value="{iDiaCorridoPago}">
							</td>
						</tr>
						
						<tr>
							<td class="SubHead">
								<span>(*)Arancel:</span>
							</td>
							<td class="SubHead">
								<span>(*)Costo Financiero:</span>
							</td>							
						</tr>
						<tr>
							<td class="SubHead">
								<input name="fArancel" type="text" id="fArancel" class="FormTextBox" onkeypress="return IsNumberNaN(event,'fArancel');" value="{fArancel}">
							</td>
							<td class="SubHead">
								<input name="fCostoFinanciero" type="text" id="fCostoFinanciero" class="FormTextBox" onkeypress="return IsNumberNaN(event,'fCostoFinanciero');" value="{fCostoFinanciero}">
							</td>
						</tr>

						<tr>
							<td class="SubHead">
								<span>(*)Cant. Cuotas:</span>
							</td>
							<td class="SubHead">
								<span>(*)Interes Usuario:</span>
							</td>							
						</tr>
						<tr>
							<td class="SubHead">
								<input name="iCantidadCuotas" type="text" id="iCantidadCuotas" class="FormTextBox" onKeyUp="this.value=numero_parse_entero(this.value);" value="{iCantidadCuotas}">
							</td>
							<td class="SubHead">
								<input name="fInteresUsuario" type="text" id="fInteresUsuario" class="FormTextBox" onkeypress="return IsNumberNaN(event,'fInteresUsuario');"  value="{fInteresUsuario}">
							</td>
						</tr>

						<tr>
							<td class="SubHead">
								<span>(*)Descuento Usuario:</span>
							</td>
							<td class="SubHead">
								<span>(*)Diferimiento Usuario:</span>
							</td>							
						</tr>
						<tr>
							<td class="SubHead">
								<input name="fDescuentoUsuario" type="text" id="fDescuentoUsuario" class="FormTextBox" onkeypress="return IsNumberNaN(event,'fDescuentoUsuario');" value="{fDescuentoUsuario}">
							</td>
							<td class="SubHead">
								<input name="iDiferimientoUsuario" type="text" id="iDiferimientoUsuario" class="FormTextBox" onKeyUp="this.value=numero_parse_entero(this.value);"  value="{iDiferimientoUsuario}">
							</td>
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
		
	</form>
</center>
<script>

	InputMask('dVigenciaDesde','99/99/9999');
	InputMask('dVigenciaHasta','99/99/9999');
	
	document.getElementById('idTipoPlan').focus(); 
	
	function saveDatos(){
		var Formu = document.forms['FormPromocionesPlanes'];
		
		if(validarDatosForm()){		
			
			if(confirm('Esta seguro de realizar esta operacion?')){
				xajax_sendFormPromocionesPlanes(xajax.getFormValues('FormPromocionesPlanes'));
			}
	
		}		
	}
	
	var nav4 = window.Event ? true : false;
	
	function IsNumberNaN(evt, tagName){

		// Backspace = 8, Enter = 13, ‘0? = 48, ‘9? = 57, ‘.’ = 46
		var key = nav4 ? evt.which : evt.keyCode;
		
		if(key <= 13 || (key >= 48 && key <= 57) || key == 46){
			
			if(key == 46){
				var haystack = String( document.getElementById(tagName).value );				
				
				var pos = haystack.indexOf(".",0);
				
				if(pos === -1){
					return true;
				}else{
					return false;
				}
			}else{
				return true;
			}
					
	
				
		}else{
			return false;
		}
	
	}	
	
	
	function validarDatosForm(){
		var Formu = document.forms['FormPromocionesPlanes'];
		var errores = '';

		if(Formu.idTipoPlan.value == 0){
			errores += 'El campo Tipo Plan es requerido. \n';
		}
		
		if(Formu.sNombre.value == ''){
			errores += 'El campo Nombre es requerido. \n';
		}
		
		if(Formu.dVigenciaDesde.value == ''){
			errores += 'El campo Vigencia Desde es requerido. \n';
		}else{
			/*var check = validarFecha(Formu.dVigenciaDesde);

			if(check){

				errores += 'El Formato del campo Vigencia Desde es incorrecto. \n';

			}else{

				errores += 'El Formato del campo Vigencia Desde es incorrecto. \n';

			}*/
		}
		
		if(Formu.dVigenciaHasta.value == ''){
			errores += 'El campo Vigencia Hasta es requerido. \n';
		}else{
			/*var check = validarFecha(Formu.dVigenciaDesde);

			if(check){

				errores += 'El Formato del campo Vigencia Desde es incorrecto. \n';

			}else{

				errores += 'El Formato del campo Vigencia Desde es incorrecto. \n';

			}*/			
		}
		
		if(Formu.iDiaCierre.value == ''){
			errores += 'El campo Dia Cierre es requerido. \n';
		}
		
		if(Formu.iDiaCorridoPago.value == ''){
			errores += 'El campo Dia Corrido Pago es requerido. \n';
		}		
		
		if(Formu.fArancel.value == ''){
			errores += 'El campo Arancel es requerido. \n';
		}
		
		if(Formu.fCostoFinanciero.value == ''){
			errores += 'El campo Costo Financiero es requerido. \n';
		}

		if(Formu.iCantidadCuotas.value == ''){
			errores += 'El campo Cantidad de Cuotas es requerido. \n';
		}
		
		if(Formu.fInteresUsuario.value == ''){
			errores += 'El campo Interes Usuario es requerido. \n';
		}
		
		if(Formu.fDescuentoUsuario.value == ''){
			errores += 'El campo Descuento Usuario es requerido. \n';
		}

		if(Formu.iDiferimientoUsuario.value == ''){
			errores += 'El campo Diferimiento Usuario es requerido. \n';
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
		 	obj = obj.replace(/([^a-zA-ZÁÉÍÓÚáéíóú\t\s]+)/,'');
		 	obj = obj.toUpperCase();
	 	document.getElementById(id).value = obj;
		 //}
	}

	function aMayusculas(obj,id){
		 var RegExPattern = /[a-zA-Z]/;
		 
		 	obj = obj.replace(/([^a-zA-Z0-9ÁÉÍÓÚáéíóú\t\s]+)/,'');
		 	obj = obj.toUpperCase();
	 	document.getElementById(id).value = obj;
		 //}
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
		
		document.getElementById('idTipoPlan').value = 0;
		document.getElementById('sNombre').value = '';		
		document.getElementById('dVigenciaDesde').value = '';
		document.getElementById('dVigenciaHasta').value = '';
		document.getElementById('iDiaCierre').value = '';
		document.getElementById('iDiaCorridoPago').value = '';
		document.getElementById('fArancel').value = '';
		document.getElementById('fCostoFinanciero').value = '';
		document.getElementById('iCantidadCuotas').value = '';
		document.getElementById('fInteresUsuario').value = '';
		document.getElementById('fDescuentoUsuario').value = '';
		document.getElementById('iDiferimientoUsuario').value = '';

	}


	/*Prueba para simular TAB ::: ENTER*/
	function redirectObject(e,object,option){
		var k=null;
		var Formu = document.forms['FormPromocionesPlanes'];	
		
		(e.keyCode) ? k=e.keyCode : k=e.which;
		
		
		
		if(k == 13 || k == 9 || k == 11) {
			//if(object){

				//e.cancelBubble is supported by IE – this will kill the bubbling process.
				e.cancelBubble = true;
				e.returnValue = false;
				//e.stopPropagation works only in Firefox.
				if (e.stopPropagation) {
					e.stopPropagation();
					e.preventDefault();
				}

				switch (option) {
				    case 1:
 							var check = validarFecha(object);
 							
 							if(check){

 								document.getElementById('dVigenciaHasta').focus();

 							}else{

	 							alert('-La Fecha no es valida.\n');

	 							document.getElementById('dVigenciaDesde').focus();

								//return false;

 							}					       
				       break; 
				    case 2:
 							var check = validarFecha(object);
 							
 							if(check){

 								document.getElementById('iDiaCierre').focus();

 							}else{

	 							alert('-La Fecha no es valida.\n');

	 							document.getElementById('dVigenciaHasta').focus();

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