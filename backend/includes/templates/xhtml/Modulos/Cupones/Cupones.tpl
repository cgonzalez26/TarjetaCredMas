<style>
.table_object {
    font-family: Tahoma,Times New Roman;
    text-align: center;
}

.table_object th {
    background: url("../includes/images/bc_bg.png") repeat-x scroll 50% 50% #F5F5F5;
    border-bottom: 1px solid #CCCCCC !important;
    border-left: 1px solid #CCCCCC !important;
    border-top: 1px solid #CCCCCC !important;
    border-right: 0px solid #CCCCCC !important;
    color: #911E79;
    font-family: Arial;
    font-size: 11px;
    height: 30px;
    line-height: 30px;
    margin: 0;
    padding: 0;
    text-align: center;
}

.table_object td {
    border-bottom: 1px solid #CCCCCC;
    border-left: 1px solid #CCCCCC;
    font-size: 11px;
    height: 25px;
    line-height: 25px;
    padding: 2px;
}

.title_planespromo{
	font-family:Tahoma;
	font-size:16px;
	color:#911E79;
	text-align:left;
	width:530px;
}
</style>

<center>

<div id="_divCUPONES">

<div style="width:860px;">
	<div style='width:700px;text-align:right;'>
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Plan' border='0' hspace='4' align='absmiddle'> [F9] Guardar</a>
		&nbsp;&nbsp;			
		<a href="Cupones.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='regresar' alt='regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>

<form id="formCupones" action="AdminPlanes.php" method="POST" name="formCupones">	
	<input type="hidden" name="_op" id="_op" value="{_op}" />	
	<input type="hidden" name="_i" id="_i" value="{_i}" />	
	<input type="hidden" name="_ic" id="_ic" value="{_ic}" />	
	<input type="hidden" name="hdnLimiteCredito" id="hdnLimiteCredito" value="{limite_credito}" />	
	<fieldset id='cuadroAjuste' style="width:860px;border:1px solid #CCC;">
	<legend> Cupones</legend>
	
	<table cellpadding="0" cellspacing="0" width="100%" border="0" align="center" class="TablaGeneral">
	<tr>
		<td align="right">
			<div id="div_reimprimir_cupon" style="width:700px;align:right;"> 
			</div>
		</td>
	</tr>
	<tr>
	<td valign="top" style="padding-top:20px">
	
	<table cellspacing="0" cellpadding="0" width="100%" align="center" border="0" class="TablaGeneral">
		<tbody>
			<!--<tr>
				<td valign="middle" align="center" height="20" class="Titulo">
					CUPONES	
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
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">Cuenta:</label>
							</td>
						</tr>
						<tr>
							<td>
								<span>(*)Cuenta:</span>
							</td>
							<td colspan="3">
								<input id="sNumeroCuenta" name="sNumeroCuenta" type="text" class="FormTextBox" style="width:200px;" value="{sNumeroCuenta}" />
								<input type="hidden" name="_icu" id="_icu" />
								<input type="hidden" name="_it" id="_it" />
								
								<input type="button" name="search_cuenta" id="search_cuenta" value="buscar" style="" onclick="buscarDatosUsuarioPorCuenta();" />
								
								<!--<input type="button" name="advanced_search_cuenta" id="advanced_search_cuenta" value="busqueda avanzada" style="" onclick="displayWindow('BuscarUsuario.php',700,500);" />-->
								
								<input type="button" name="advanced_search_cuenta" id="advanced_search_cuenta" value="busqueda avanzada" style="" onclick="_createWindows('BuscarUsuario.php','usuario','usuario');" />
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<center>
								<div style="width:700px;text-align:left;" id="datos_cuenta">
									{datos_cuenta}
								</div>
								</center>
							</td>
						</tr>						
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">Comercio:</label>
							</td>
						</tr>
						<tr>
							<td>
								<span>(*)Comercio:</span>
							</td>
							<td colspan="3">
								<input type="hidden" name="_ico" id="_ico" />
								<input type="hidden" name="_tp" id="_tp" />
								<input type="hidden" name="_ip" id="_ip" />
								
								<input id="sNumeroComercio" name="sNumeroComercio" type="text" class="FormTextBox" style="width:200px;" value="{sNumeroComercio}" />
								
								<input type="button" name="search_comercio" id="search_comercio" value="buscar" style="" onclick="buscarDatosComercioPorNumero();" />
								<!--<input type="button" name="advanced_search_comercio" id="advanced_search_comercio" value="busqueda avanzada" style="" onclick="displayWindow('BuscarComercio.php',700,500);" />-->
								<input type="button" name="advanced_search_comercio" id="advanced_search_comercio" value="busqueda avanzada" style="" onclick="_createWindows('BuscarComercio.php','comercio','comercio');" />
								
							</td>
						</tr>						
						
						<tr>
							<td colspan="4">
								<center>
								<div style="width:700px;text-align:left;" id="div_datos_comercio">
									{datos_comercio}
								</div>
								</center>
							</td>
						</tr>

						<tr>
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">Promociones/Planes:</label>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<center>
								<div style="width:700px;text-align:left;" id="div_datos_planes">
									{datos_planes}
								</div>
								</center>
							</td>
						</tr>
						<tr>
							<td>
								<span>(*)Cantidad Cuotas:</span>
							</td>
							<td colspan="3">
								<span id="xsCantidadCuota" style="font-family:Tahoma;font-size:14px;">&nbsp;</span>
								<input id="iCantidadCuota" name="iCantidadCuota" type="hidden" class="FormTextBox" style="width:50px;">
							</td>
						</tr>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">Datos Cupon:</label>
							</td>
						</tr>
						<tr>
							<td>
								<span style="font-size:14px;font-weight:bold;">Limite Credito:</span>
							</td>
							<td colspan="3">
								<div id="div_limite_credito" style="font-size:14px;font-weight:bold;">{fLimiteCredito}</div>
							</td>
						</tr>
						<tr>
							<td>
								<span>(*)Importe:</span>
							</td>
							<td colspan="3">
								<input id="fImporte" name="fImporte" type="text" class="FormTextBox" style="width:200px;" onkeypress="return IsNumberNaN(event,'fImporte');" value="{fImporte}">
							</td>
						</tr>
						<tr>
							<td>
								<span>(*)Nro. Cupon:</span>
							</td>
							<td>
								<input id="sNumeroCupon" name="sNumeroCupon" type="text" class="FormTextBox" style="width:200px;" value="{sNumeroCupon}">
							</td>
							<td>
								<span>(*)Tipo Moneda:</span>
							</td>
							<td>
								<select id="idTipoMoneda" name="idTipoMoneda" class="FormTextBox" style="width:200px;">
									{optionsTiposMonedas}
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<span>(*)Fecha Cupon:</span>
							</td>
							<td>
								<input id="dFechaConsumo" name="dFechaConsumo" type="text" class="FormTextBox" style="width:200px;" value="{dFechaConsumo}" onKeyDown="redirectObject(event,this,1);">
							</td>
							<td>
								<span>(*)Fecha Presentacion:</span>
							</td>
							<td>
								<input id="dFechaPresentacion" name="dFechaPresentacion" type="text" class="FormTextBox" style="width:200px;" value="{dFechaPresentacion}" onKeyDown="redirectObject(event,this,2);">
							</td>
						</tr>						
						<tr>
							<td>
								<span>(*)Nro. Terminal:</span>
							</td>
							<td colspan="3">
								<input id="sNumeroTerminal" name="sNumeroTerminal" type="text" class="FormTextBox" style="width:200px;" value="{sNumeroTerminal}">
							</td>
						</tr>
						<tr>
							<td>
								<span>Observaciones:</span>
							</td>
							<td colspan="3">
								<textarea name="sObservacion" id="sObservacion" style="width:563px;height:79px;"></textarea>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						{OPTIONS_SUCURSALES}
						{OPTIONS_OFICINAS}
						{SELECT_EMPLEADOS}
						</tbody>
						</table>					
				</td>
			</tr>
			<tr>
				<td class="SubHeadRed" align="left" height="30">&nbsp;</td>
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
		</tbody>	
		</table>
	</table>	
		
	</fieldset>	
	</form>
	
<div style="width:700px;">
	<div id='' style='width:700px;text-align:right;'>
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Plan' border='0' hspace='4' align='absmiddle'> [F9] Guardar</a>
		&nbsp;&nbsp;			
		<!--<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Limite' alt='Nuevo Limite' border='0' hspace='4' align='absmiddle'> Nuevo</a>
			&nbsp;&nbsp;			
		</div>-->
		<a href="Cupones.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='regresar' alt='regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>

</div>

</center>


<script>

	

	var message_default_comercio = "{message_default_comecio}";
	var message_default_cuenta 	= "{message_default_cuenta}";
	var message_default_planes 	= "{message_default_planes}";

	InputMask('dFechaConsumo','99/99/9999');
	InputMask('dFechaPresentacion','99/99/9999');
	
	document.getElementById('sNumeroCuenta').focus(); 
	
	function saveDatos(){
		var Formu = document.forms['formCupones'];
		
		if(validarDatosForm()){		
		//if(true){			
			if(confirm('Esta seguro de realizar esta operacion?')){
				document.getElementById('div_reimprimir_cupon').innerHTML = '';
				//alert("paso");
				xajax_sendFormCupones__(xajax.getFormValues('formCupones'));
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
		var Formu = document.forms['formCupones'];
		var errores = '';
		
		if(Formu.sNumeroCuenta.value == ""){
			errores += 'El campo Numero Cuenta Usuario es requerido.\n';
		}
		
		if(Formu.sNumeroComercio.value == ""){
			errores += 'El campo Numero Comercio es requerido.\n';
		}

		if(Formu.fImporte.value == "" || Formu.fImporte.value == "0" || Formu.fImporte.value == "0.00" || Formu.fImporte.value == "0.0"){
			errores += 'El campo Importe es requerido. \n';
		}		
		
		if(parseFloat(Formu.hdnLimiteCredito.value) < parseFloat(Formu.fImporte.value)){
			errores += 'El Margen de Credito no es suficiente, credito disponible es '+Formu.hdnLimiteCredito.value+' \n';
		}
		
		if(Formu.sNumeroCupon.value == ""){
			errores += 'El campo Numero Cupon es requerido. \n';
		}
		
		if(Formu.idTipoMoneda.value == 0){
			errores += 'El campo Tipo Moneda es requerido. \n';
		}
		
		if(Formu.dFechaConsumo.value == ""){
			errores += 'El campo Fecha Cupon es requerido. \n';
		}
		
		if(Formu.dFechaPresentacion.value == ""){
			errores += 'El campo Fecha Presentacion es requerido. \n';
		}
		
		/*if(Formu.sNumeroTerminal.value == ""){
			errores += 'El campo Numero Terminal es requerido. \n';
		}		

		if(Formu.sObservacion.value == ""){
			errores += 'El campo Observaciones es requerido. \n';
		}*/
		
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
		
		document.getElementById('sNumeroCuenta').value = "";
		
		document.getElementById('sNumeroComercio').value = "";

		document.getElementById('fImporte').value = "";
		
		document.getElementById('sNumeroCupon').value = "";
		
		document.getElementById('idTipoMoneda').value = 0;
		
		document.getElementById('dFechaConsumo').value = "{dFechaConsumo}";
		
		document.getElementById('dFechaPresentacion').value = "{dFechaPresentacion}";

		document.getElementById('sNumeroTerminal').value = "";

		document.getElementById('sObservacion').value = "";
		
		document.getElementById('datos_cuenta').innerHTML = "";
		document.getElementById('div_datos_comercio').innerHTML = "";
		
		document.getElementById('_icu').value = "";
		document.getElementById('_it').value = "";
		document.getElementById('_ico').value = "";
		document.getElementById('_tp').value = "";
		document.getElementById('_ip').value = "";
		
		
		document.getElementById('div_datos_planes').innerHTML = "";
		document.getElementById('iCantidadCuota').value = 0;

	}


	/*Prueba para simular TAB ::: ENTER*/
	function redirectObject(e,object,option){
		var k=null;
		var Formu = document.forms['formCupones'];	
		
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

 								document.getElementById('dFechaPresentacion').focus();

 							}else{

	 							alert('-La Fecha no es valida.\n');

	 							document.getElementById('dFechaConsumo').focus();

								//return false;

 							}					       
				       break; 
				    case 2:
 							var check = validarFecha(object);
 							
 							if(check){
								var Fecha1 = document.getElementById('dFechaConsumo').value;
								var Fecha2 = document.getElementById('dFechaPresentacion').value;
								var mayor = DiferenciaFechas(Fecha1,Fecha2);
								if(mayor < 0){

		 							alert('-La Fecha de Presentacion debe ser mayor o igual a la fecha de consumo.\n');

		 							document.getElementById('dFechaPresentacion').focus();

								}else{
									document.getElementById('sNumeroTerminal').focus();	
								}
 								

 							}else{

	 							alert('-La Fecha no es valida.\n');

	 							document.getElementById('dFechaPresentacion').focus();

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
	
	/*_messageBox = new DHTML_modalMessage();
	_messageBox.setShadowOffset(5);	
	
	function displayWindow(url_,ancho,alto) {
		_messageBox.setSource(url_);
		_messageBox.setCssClassMessageBox(false);
		_messageBox.setSize(ancho,alto);
		_messageBox.setShadowDivVisible(true);//Enable shadow for these boxes
		_messageBox.display();
	}

	function _closeWindow() { 
		//resetJsCache();
		_messageBox.close();	
	}	*/
	
	var dhxWins1;
	function _createWindows(sUrl,sTitulo,_x){
		
	    var idWind = "window_search" + _x;
		
	     	dhxWins1 = new dhtmlXWindows();     	
		    dhxWins1.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
		    _popup_ = dhxWins1.createWindow(idWind, 0, 0, 700, 420);
		    _popup_.setText(sTitulo);
		    _popup_.center();
		    _popup_.button("close").attachEvent("onClick", __closeWindows);
			_url_ = sUrl;
		    _popup_.attachURL(_url_);
		
	} 
	
	function __closeWindows(_x){
		 var idWind = "window_search" + _x;
		 
		 
		  var isWin = dhxWins1.isWindow(idWind);
		  
		  if(isWin){
		 	dhxWins1.window(idWind).close(); 	
		  }
		  
		  var isWin = dhxWins1.isWindow("window_searchusuario");
		  
		  if(isWin){
		 	dhxWins1.window("window_searchusuario").close(); 	
		  }		  
		 
		  var isWin = dhxWins1.isWindow("window_searchcomercio");
		  
		  if(isWin){
		 	dhxWins1.window("window_searchcomercio").close(); 	
		  }
		 
		//recargar();
		//parent.dhxWins.close(); // close a window
	}	

	function setDatosCuentaUsuario(_icu,_user,_tarjeta,_tipotarjeta,_version,_numero_cuenta,_li,_it){
		var string = '';
		
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left;\'>Usuario: </label><label>' + _user + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tarjeta: </label><label>' + _tarjeta + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tipo Tarjeta: </label><label>' + _tipotarjeta + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>version: </label><label>' + _version + '</label></div>';
		
		document.getElementById('datos_cuenta').innerHTML = string;
		document.getElementById('div_limite_credito').innerHTML = _li;
		document.getElementById('_icu').value = _icu;
		document.getElementById('_it').value = _it;
		document.getElementById('sNumeroCuenta').value = _numero_cuenta;
		document.getElementById('hdnLimiteCredito').value = _li;
		//_closeWindow();
		__closeWindows('usuario');
		
	}
	
	function setDatosCuentaUsuarioN2(_icu,_user,_tarjeta,_tipotarjeta,_version,_numero_cuenta,_it){
		var string = '';
		
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left;\'>Usuario: </label><label>' + _user + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tarjeta: </label><label>' + _tarjeta + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tipo Tarjeta: </label><label>' + _tipotarjeta + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>version: </label><label>' + _version + '</label></div>';
		
		document.getElementById('datos_cuenta').innerHTML = string;
		document.getElementById('_icu').value = _icu;
		document.getElementById('_it').value = _it;
		document.getElementById('sNumeroCuenta').value = _numero_cuenta;
		
	}

	function setLimiteCredito(_importe){
		document.getElementById('div_limite_credito').innerHTML = _importe;
		document.getElementById('hdnLimiteCredito').value = _importe;
	}
	
	function _imageLoading_(_div_){
		
		document.getElementById(_div_).innerHTML = "<img src='../includes/images/ajax-loader.gif' title='buscando' hspace='4'> buscando...";
		
	}
	
	function buscarDatosUsuarioPorCuenta(){
		
		var _numeroCuenta = document.getElementById('sNumeroCuenta').value;
		//alert(_numeroCuenta);
		if(_numeroCuenta != ''){
			_imageLoading_('datos_cuenta');
			xajax_buscarDatosUsuarioPorCuenta(_numeroCuenta);
		}else{
			alert('debe ingresar un numero de cuenta');
			document.getElementById('sNumeroCuenta').focus();
			document.getElementById('datos_cuenta').innerHTML = message_default_cuenta;
		}

	}
	
	function setNotFoundCuenta(){
		var string = '';
		
		string += '<label style=\'display:block;\'>No se encontro coincidencia</label>';
		
		document.getElementById('datos_cuenta').innerHTML = string;
		document.getElementById('_icu').value = '';
	}
	
	function setDatosComercio(_ico,_razon_social,_nombre_fantasia,_cuit,_numero_comercio){
		var string = '';
		
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Razon Social: </label><label>' + _razon_social + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Nombre Fantasia: </label><label>' + _nombre_fantasia + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>C.U.I.T.: </label><label>' + _cuit + '</label></div>';
		
		document.getElementById('div_datos_comercio').innerHTML = string;
		document.getElementById('_ico').value = _ico;
		document.getElementById('sNumeroComercio').value = _numero_comercio;
		
		_imageLoading_('div_datos_planes');
		
		xajax_buscarDatosPromocionesPlanesComercio(_ico);
		
		//_closeWindow();
		__closeWindows('comercio');
		
	}	
			 
	function setDatosComercioN2(_ico,_razon_social,_nombre_fantasia,_cuit,_numero_comercio){
		var string = '';
		//alert(_nombre_fantasia);
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Razon Social: </label><label>' + _razon_social + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Nombre Fantasia: </label><label>' + _nombre_fantasia + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>C.U.I.T.: </label><label>' + _cuit + '</label></div>';
		
		document.getElementById('div_datos_comercio').innerHTML = string;
		document.getElementById('_ico').value = _ico;
		document.getElementById('sNumeroComercio').value = _numero_comercio;
		
	}
	
	function setNotFoundComercio(){
		var string = '';
		
		string += '<label style=\'display:block;\'>No se encontro coincidencia</label>';
		
		document.getElementById('div_datos_comercio').innerHTML = string;
		document.getElementById('_ico').value = '';
	}
	
	function setNotFoundPromocionesPlanesComercio(){
		var string = '';
		
		string += '<label style=\'display:block;color:#F00;\'>No se encontraron Promociones o Planes vigentes</label>';
		
		document.getElementById('div_datos_planes').innerHTML = string;
		document.getElementById('_ico').value = '';
	}
	
	function buscarDatosComercioPorNumero(){
		
		var _numeroCuenta = document.getElementById('sNumeroComercio').value;
		
		if(_numeroCuenta != ''){
			_imageLoading_('div_datos_comercio');
			xajax_buscarDatosComercioPorNumero(_numeroCuenta);
		}else{
			alert('debe ingresar un numero de comercio');
			document.getElementById('sNumeroComercio').focus();
			document.getElementById('div_datos_comercio').innerHTML = message_default_comercio;
		}

	}

	function setDatosCuotas(_ip,_tp,_c){

			document.getElementById('_ip').value = _ip;
			document.getElementById('_tp').value = _tp;
			
			document.getElementById('iCantidadCuota').value = _c;
			
			document.getElementById('xsCantidadCuota').innerHTML = _c;

	}
	
	
	function _print(){ 
		/*document.getElementById('impresiones').innerHTML = _printHTML ;*/ 
		
		window.print(); 
	}
	

</script>