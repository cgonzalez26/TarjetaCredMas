<center>

<div style="width:800px;">
	<div id='' style='width:700px;text-align:right;'>
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Comercio' border='0' hspace='4' align='absmiddle'> [F9] Guardar</a>
		&nbsp;&nbsp;			
		<!--<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Limite' alt='Nuevo Limite' border='0' hspace='4' align='absmiddle'> Nuevo</a>
			&nbsp;&nbsp;			
		</div>-->
		<a href="TiposPlanes.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='Buscar Limites' alt='Buscar Limites' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>

<form id="formTiposPlanes" action="AdminTiposPlanes.php" method="POST">	
	<input type="hidden" name="_op" id="_op" value="{_op}" />	
	<input type="hidden" name="_i" id="_i" value="{_i}" />	
	<fieldset id='cuadroAjuste' style="width:700px;border:1px solid #CCC;">
	<legend> TIPOS PLANES</legend>
   	<table cellpadding="0" cellspacing="0" width="100%" border="0" align="center" class="TablaGeneral">  
   	<tr>
    <td valign="top" style="padding-top:20px">
    
	    <table cellspacing="0" cellpadding="0" width="500" align="center" border="0" class="TablaGeneral">
			<tbody>
			<!--<tr>
				<td valign="middle" align="center" height="20" class="Titulo">
					TIPOS PLANES	
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
								<label id="">Tipos de Planes:
								</label>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>(*)Nombre :</span>
							</td>
							<td class="SubHead">
								<span>(*)Autorizable:</span>
							</td>								

							
						</tr>
						
						<tr>
							<td valign="top">
								<input id="sNombre" name="sNombre" type="text" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id);" value="{sNombre}"></td>
							<td valign="top">
								<select id="sAutorizable" name="sAutorizable" class="FormTextBox" style="width:200px;">
									{optionsAutorizable}
								</select>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>(*)Financiable:</span>
							</td>		
							<td class="SubHead">
								<span>(*)Compra:</span>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<input name="iFinanciable" type="text" id="iFinanciable" class="FormTextBox" onKeyUp="this.value=numero_parse_entero(this.value);" value="{iFinanciable}">
							</td>
							<td class="SubHead">
								<input name="iCompra" type="text" id="iCompra" class="FormTextBox" onkeypress="return IsNumberInteger(event,'iCompra');" value="{iCompra}">
							</td>
						</tr>
						<tr>
							<td>
								<span>(*)Credito:</span>
							</td>
						</tr>
						<tr>
							<td>
								<input name="iCredito" type="text" id="iCredito" class="FormTextBox" onkeypress="return IsNumberInteger(event,'iCredito');" value="{iCredito}">
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
		</fieldset>
	</form>
</center>
<script>

	//InputMask('dFechaInicioActividad','99/99/9999');
	
	document.getElementById('sNombre').focus(); 
	
	function saveDatos(){
		var Formu = document.forms['formTiposPlanes'];
		
		if(validarDatosForm()){		
			
			if(confirm('Esta seguro de realizar esta operacion?')){
				xajax_sendFormTiposPlanes(xajax.getFormValues('formTiposPlanes'));
			}
	
		}		
	}
	
	
	function validarDatosForm(){
		var Formu = document.forms['formTiposPlanes'];
		var errores = '';
		
		
		if(Formu.sNombre.value == ''){
			errores += 'El campo Nombre es requerido. \n';
		}
		
		/*if(Formu.sAutorizable.value == 0){
			errores += 'El campo Autorizable es requerido. \n';
		}*/
		
		if(Formu.iFinanciable.value == ''){
			errores += 'El campo Financiable es requerido. \n';
		}
		
		if(Formu.iCompra.value == ''){
			errores += 'El campo Compra es requerido. \n';
		}
		
		if(Formu.iCredito.value == ''){
			errores += 'El campo Credito es requerido. \n';
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
	

	
	function resetForm(){
		
		document.getElementById('sNombre').value = '';
		
		document.getElementById('sAutorizable').value = 0;
		
		document.getElementById('iFinanciable').value = 0;
		
		document.getElementById('iCompra').value = '';
		
		document.getElementById('iCredito').value = '';

	}


	/*Prueba para simular TAB ::: ENTER*/
	function redirectObject(e,object,option){
		var k=null;
		var Formu = document.forms['formTiposPlanes'];	
		
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
	
	
	var nav4 = window.Event ? true : false;
	
	function IsNumberInteger(evt, tagName){

		// Backspace = 8, Enter = 13, ë0? = 48, ë9? = 57, ë-í = 45
		var key = nav4 ? evt.which : evt.keyCode;
		
		if(key <= 13 || (key >= 48 && key <= 57) || key == 45){
			
			if(key == 45){
				
				var haystack = String( document.getElementById(tagName).value );				
				
				var pos = haystack.indexOf("-",0);
				
				if(pos === -1){
					if(haystack == ''){
						return true;	
					}else{
						return false;
					}
					
				}else{
					
					if(haystack == ''){
						return true;	
					}else{
						return false;
					}
				}
			}else{
				return true;
			}
					
	
				
		}else{
			return false;
		}
	
	}	
	
	function numero_parse_entero_con_negativos( numero ) {
		
		numero = String( numero );
		//return Number( numero.replace(/([^0-9]+)/,'') );
		
		
		
		
		return numero.replace(/([^0-9\-]+)/,'');
	}
	
	

</script>