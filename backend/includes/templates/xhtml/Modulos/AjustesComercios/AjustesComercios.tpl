<center>

<div id="CUPONES">

<div style="width:700px;">
	<div style='width:700px;text-align:right;'>
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Plan' border='0' hspace='4' align='absmiddle'> [F9] Guardar</a>
		&nbsp;&nbsp;			
		<a href="AjustesComercios.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='regresar' alt='regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>

<form id="formCupones" action="AdminPlanes.php" method="POST" name="formCupones">	
	<input type="hidden" name="_op" id="_op" value="{_op}" />	
	<input type="hidden" name="_i" id="_i" value="{_i}" />	
	<input type="hidden" name="_ic" id="_ic" value="{_ic}" />
	<input type="hidden" id="bDiscriminaIVA" name="bDiscriminaIVA" value="{DISCRIMINA_IVA}" />	
	<input type="hidden" id="fTasaIVA" name="fTasaIVA" value="{TASA_IVA}" />
			
	<table cellpadding="0" cellspacing="0" width="700" border="0" align="center" class="TablaGeneral">
	<tr>
		<td align="right">
			<div id="div_reimprimir_cupon" style="width:700px;align:right;">
			</div>    
		</td>
	</tr>
	<tr>
	<td valign="top" style="padding-top:20px">
	
	    <table cellspacing="0" cellpadding="0" width="700" align="center" border="0" class="TablaGeneral">
		<tbody>
			<tr>
				<td valign="middle" align="left" height="20" class="Titulo">
					AJUSTES DE COMERCIOS	
				</td>
			</tr>
			<tr>
				<td align="left" bgcolor="#ffffff" style="height:20px;color:red;font-weight:bold">
					<div id="div_message">{message}</div>
				</td>
			</tr>
			<tr>
				<td class="SubHead" align="left" bgcolor="#ffffff">
						<table id="TablaTitular" cellspacing="5" cellpadding="0" width="700" border="0" class="TablaGeneral">
						<tbody>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">Comercio</label>
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
								<input type="button" name="advanced_search_comercio" id="advanced_search_comercio" value="busqueda avanzada" style="" onclick="_createWindows('../Cupones/BuscarComercio.php','comercio','comercio');" />
								
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
								<label id="">Planes / Promociones</label>
							</td>
						</tr>
						<tr>
					    	<td>Planes:</td>
					    	<td> 
								<select name='idPlan' id='idPlan' value='{PLAN}' onchange="setPromocionPlan('0');" style='width:200px;'>
									{OPTIONS_PLANES}					
								</select><sup>*</sup>
							</td>
							<td>Promociones:</td>
					    	<td> 
								<select name='idPlanPromocion' id='idPlanPromocion' value='{PROMOCION}' onchange= "setPromocionPlan('1');" style='width:200px;'>
									{OPTIONS_PROMOCIONES}					
								</select><sup>*</sup>
							</td>			
								
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">Datos del Ajuste</label>
							</td>
						</tr>
								<tr>			
									<td>Tasa IVA: </td>
									<td> 
										<select name='idTasaIVA' id='idTasaIVA' value='{TASA_IVA}' onchange= "GetTasaIVA(this.value)(this.value);" style='width:200px;'">
											{OPTIONS_TASAS_IVA}					
										</select><sup>*</sup>
									</td> 					   		
								</tr>
								<tr>				
								</tr>
								<tr>
							    	<td>Tipo Moneda:</td>
							    	<td> 
										<select name='idTipoMoneda' id='idTipoMoneda' value='{TIPO_MONEDA}' style='width:200px;'>
											{OPTIONS_TIPOS_MONEDAS}					
										</select><sup>*</sup>
									</td>
									<td>Cuotas:</td>
							    	<td>
							    	  <input type='text' id="iCuotas" name='iCuotas' readonly  onblur="numero_parse_entero(this.value);" value='{CUOTAS}' style='width:200px;'/><sup>*</sup>
							       	</td> 			
								</tr>
								<tr>		   		
								</tr>
								<tr>
									<td>Tipo Ajuste:</td>
							    	<td> 
										<select name='idTipoAjuste' id='idTipoAjuste' onchange="GetDatosTipoAjuste();"  value='{TIPO_AJUSTE}' style='width:200px;'>
											{options_tipos_ajustes}					
										</select><sup>*</sup>
									</td> 
									<td align="right">
										<b>Interes (%):</b>
									</td>
									<td>
										 <input type="hidden" id="fInteres" name='fInteres' onblur="numero_parse_flotante(this.value);" readonly value='{INTERES}' style='width:200px;'/>
										 <label id="lblInteres">{interes}</label>
									</td>
								</tr>
								<tr>	
								</tr>
								<tr>
							   		<td>Importe:</td>
							    	<td>
							    	  <input type='text' id="fImporteTotal" name='fImporteTotal'  onblur="CalcularImportes(this.value)" onkeypress="return onEnterCalcularImporte(event);" value='{IMPORTE_TOTAL}' style='width:200px;'/><sup>*</sup>
							    	</td>
							    	<td align="right"><b>Importe Interes:</b></td>
							    	<td>
							    	  <input type= "hidden" id="fImporteTotalInteres" name='fImporteTotalInteres' onblur="numero_parse_entero(this.value);" value='{IMPORTE_TOTAL_INTERES}' readonly style='width:200px;'/>
							       	  <label id="lblImporteTotalInteres">{importe_total_interes}</label>
							    	 </td> 		    	
								</tr>
								<tr>
								</tr>
								<tr>
							   		<td align="right"><b>Importe IVA:</b></td>
							    	<td>
							    	  <input type= "hidden" id="fImporteTotalIVA" name='fImporteTotalIVA' onblur="numero_parse_flotante(this.value);" value='{IMPORTE_TOTAL_IVA}' readonly style='width:200px;'/>
							       	  <label id="lblImporteTotalIVA">{importe_total_iva}</label>	
							    	</td> 		    	
								</tr>			
								<tr>
							   		<td align="right"><b>Total:</b></td>
							    	<td>
							    	  <input type="hidden" id="fImporteTotalFinal" name='fImporteTotalFinal' onblur="numero_parse_flotante(this.value);" value='{IMPORTE_TOTAL_FINAL}' readonly style='width:200px;'/>
							    	  <label id="lblImporteTotalFinal">{importe_total_final}</label>
							       	</td> 		    	
								</tr>	
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

				</td>
			</tr>
		</tbody>	
		</table>
	</table>		
		
	</form>
	
</div>

</center>


<script>
	var message_default_comercio = "{message_default_comecio}";
	var message_default_cuenta 	= "{message_default_cuenta}";
	var message_default_planes 	= "{message_default_planes}";

	InputMask('dFechaConsumo','99/99/9999');
	InputMask('dFechaPresentacion','99/99/9999');
	
	document.getElementById('sNumeroComercio').focus(); 
	
	function saveDatos(){
		var Formu = document.forms['formCupones'];
		
		if(validarDatosForm())
		{				
			if(confirm('Esta seguro de realizar esta operacion?'))
			{
				document.getElementById('div_reimprimir_cupon').innerHTML = '';
				xajax_updateDatosAjustesComercios(xajax.getFormValues('formCupones'));
			}
		}		
	}
	
	
	
	var nav4 = window.Event ? true : false;
	
	
	//------------------------------------------------------------------------------------------------------------------------------------------------------------
	function GetDatosTipoAjuste()
	{
		var Formu = document.forms['formCupones'];		
		
		//alert("GetDatosTipoAjuste");
		xajax_getDatosAjustes(Formu.idTipoAjuste.value);
		//xajax_podonga();
	}
	
	
	function onEnterCalcularImporte(evt)
	{		
		// Backspace = 8, Enter = 13, ‘0? = 48, ‘9? = 57, ‘.’ = 46
		var key = nav4 ? evt.which : evt.keyCode;
		
		if(key == 13)
		{
				CalcularImportes(document.getElementById("fImporteTotal").value);
				return true;
		}else
		{
			return true;
		}
	}	

	
	function CalcularImportes(fImporte)
	{
		var Formu = document.forms['formCupones'];	
		
		if(!trim(fImporte))
		{
			return;
		}
		
		fImporte = parseFloat(fImporte);

		var fTasaInteres = Formu.fInteres.value;
		var fIntereses = (fImporte * (fTasaInteres/100)).toFixed(2);
		var fImporteInteres = parseFloat(fImporte) + parseFloat(fIntereses);	
		
		//alert("discrimina IVA: " + bDiscriminaIVA.value);
		
		if(Formu.bDiscriminaIVA.value == 1)
		{
			var fTasaIVA = Formu.fTasaIVA.value;
		}
		else
		{
			var fTasaIVA = 0;
		}
					
		var fImporteIVA = (fImporteInteres * (fTasaIVA/100)).toFixed(2);
		
		Formu.fImporteTotalInteres.value = fIntereses;
		Formu.fImporteTotalIVA.value = fImporteIVA;		
		Formu.fImporteTotalFinal.value = (parseFloat(fImporte) + parseFloat(fImporteIVA) + parseFloat(fIntereses)).toFixed(2);	
		
		
		document.getElementById("lblImporteTotalInteres").innerHTML = Formu.fImporteTotalInteres.value;
		document.getElementById("lblImporteTotalIVA").innerHTML = Formu.fImporteTotalIVA.value;	
		document.getElementById("lblImporteTotalFinal").innerHTML = Formu.fImporteTotalFinal.value;
		
		//alert(Formu.fImporteTotalIVA.value);
	}
	//------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	
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
		
		if(Formu.sNumeroComercio.value == ""){
			errores += 'El campo Numero Comercio es requerido.\n';
		}

		if(Formu.idPlan.value == 0 && Formu.idPlanPromocion.value == 0)
		{
			errores += 'Debe seleccionar un Plan o Promocion. \n';
		}
		
		if(Formu.fImporteTotal.value == "" || Formu.fImporteTotal.value == "0" || Formu.fImporteTotal.value == "0.00" || Formu.fImporteTotal.value == "0.0"){
			errores += 'El campo Importe es requerido. \n';
		}				

		
		if(Formu.idTipoMoneda.value == 0){
			errores += 'El campo Tipo Moneda es requerido. \n';
		}
		
		if( !trim(iCuotas.value))
			errores += "- El campo Cuotas es requerido.\n";
			
		if(idTipoAjuste.value == 0)
		errores += "- Selecciones un Tipo de Ajuste.\n";
		
		if( errores ) { alert('Han ocurrido los siguientes errores: \n' + errores); return false; } 
		else return true;
	}
	
	function resetDatosForm(){
		//window.location = "AdminComercios.php?action=new";
		bDiscriminaIVA.value = 0;
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


	



	
	function _imageLoading_(_div_){
		
		document.getElementById(_div_).innerHTML = "<img src='../includes/images/ajax-loader.gif' title='buscando' hspace='4'> buscando...";
		
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
		
		//_imageLoading_('div_datos_planes');
		
		//xajax_buscarDatosPromocionesPlanesComercio(_ico);
		
		//_closeWindow();
		__closeWindows('comercio');
		
	}	

	//Esta funcion se utiliza para cargar los datos del comercio cuando lo busco ingresando el nro en el textbox 
	function setDatosComercioN2(_ico,_razon_social,_nombre_fantasia,_cuit,_numero_comercio, Promociones_planes)
	{
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
		
		if(_numeroCuenta != '')
		{
			_imageLoading_('div_datos_comercio');			
			xajax_buscarDatosComercioPorNumeroAC_Maxi(_numeroCuenta);			
		}else
		{
			alert('debe ingresar un numero de comercio');
			document.getElementById('sNumeroComercio').focus();
			document.getElementById('div_datos_comercio').innerHTML = message_default_comercio;
		}

	}

	function setPromocionPlan(sTipo)
	{
		if(sTipo == "0")
			document.getElementById('idPlanPromocion').value = 0;  
		else
			document.getElementById('idPlan').value = 0;  			
	}
	
	function _print(){ 
		/*document.getElementById('impresiones').innerHTML = _printHTML ;*/ 
		
		window.print(); 
	}
	

</script>