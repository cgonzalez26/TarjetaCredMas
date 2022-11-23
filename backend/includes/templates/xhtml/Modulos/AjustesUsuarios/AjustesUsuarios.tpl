<body style="background-color:#FFFFFF">
<BR />
<center>
	<div id='' style='width:860PX;text-align:right;margin-right:10px;'>
		<div id="idBtotonGuardar" style="{DISPLAY_GUARDAR}">
			<img src='{IMAGES_DIR}/disk.png'  title='Guardar' alt='Guardar Grupo' border='0' hspace='4' align='absmiddle'> 
			<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
			&nbsp;&nbsp;			
			<img src='{IMAGES_DIR}/back.png' title='Buscar Grupo' alt='Buscar Grupo' border='0' hspace='4' align='absmiddle'> 
			<a href="AjustesUsuarios.php" style='text-decoration:none;font-weight:bold;'>Volver</a>			
		</div>		
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo' alt='Nuevo' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
		<img src='{IMAGES_DIR}/back.png' title='Buscar Grupo' alt='Buscar Grupo' border='0' hspace='4' align='absmiddle'> 
		<a href="AjustesUsuarios.php" style='text-decoration:none;font-weight:bold;'>Volver</a>			
		</div>		
	</div>
	<form id="formAjustesUsuarios" action="AdminAjustesUsuarios.php" method="POST">
		<input type="hidden" id="idAjusteUsuario" name="idAjusteUsuario" value="{ID_AJUSTE_USUARIO}" />
		<input type="hidden" id="fTasaIVA" name="fTasaIVA" value="{TASA_IVA}" />
		<input type="hidden" id="sEstado" name="sEstado" value="{ESTADO}" />
		<input type="hidden" id="idCuentaUsuario" name="idCuentaUsuario" value="{ID_CUENTA_USUARIO}" />
		<input type="hidden" id="sCodigo" name="sCodigo" value="{CODIGO}" />
		<input type="hidden" id="sClaseAjuste" name="sClaseAjuste" value="{CLASE_AJUSTE}" />
		<input type="hidden" id="fImporteAnterior" name="fImporteAnterior" value="{IMPORTE_ANTERIOR}" />
		<input type="hidden" id="bDiscriminaIVA" name="bDiscriminaIVA" value="{DISCRIMINA_IVA}" />
		
		<fieldset id='cuadroAjuste' style="height:550px;width:860px">
			<legend> Ajuste de Usuario</legend>			
			<table id='TablaAjusteUsuario' cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%">
				<tr>
					<td class="subTitulo" height="30" align="left" colspan="4">
					<label id="">Cuenta:</label>
					</td>				
				</tr>
				<tr>
					<th> (*)Numero Cuenta: </th>
					<td><input type='text' id="sNumeroCuenta" name='sNumeroCuenta' value='{NUMERO_CUENTA}' style='width:200px;'/> <sup>*</sup></td>
			   		<td>
			   			<input id="search_cuenta" type="button" onclick="getCuentaUsuario(document.getElementById('sNumeroCuenta').value)" style="" value="Buscar" name="search_cuenta">
						<input id="advanced_search_cuenta" type="button" 
						onclick="mostrarBuscador('BuscarUsuarioAjuste.php',700,500);" style="" value="busqueda avanzada" name="advanced_search_cuenta">
					</td>				
				</tr>
				<tr>
					<td colspan="4">
						<div style="height:50px;text-align:left;" id="datos_cuenta">
							{datos_cuenta}
						</div>						
					</td>					
				</tr>
				<tr>
					<td> &nbsp;</td>
				</tr>
			</table>
			<table id='TablaAjusteUsuario' cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%">
			<tr>
				<td class="subTitulo" height="30" align="left" colspan="4">
				<label id="">Ajuste:</label>
				</td>
			</tr>
			<tr>			
				<th> (*)Tasa IVA: </th>
				<td> 
					<select name='idTasaIVA' id='idTasaIVA' value='{TASA_IVA}' onchange= "GetTasaIVA(this.value);" style='width:200px;'">
					{OPTIONS_TASAS_IVA}					
					</select><sup>*</sup>
				</td> 					   		
			</tr>
			<tr>				
			</tr>
			<tr>
		    	<th>(*)Tipo Moneda:</th>
		    	<td> 
					<select name='idTipoMoneda' id='idTipoMoneda' value='{TIPO_MONEDA}' style='width:200px;'>
					{OPTIONS_TIPOS_MONEDAS}					
					</select> <sup>*</sup>
				</td>
				<th>(*)Cuotas:</th>
		    	<td>
		    	  <input type='text' id="iCuotas" name='iCuotas' onblur="numero_parse_entero(this.value);" value='{CUOTAS}' style='width:200px;'/>
		       	  <sup>*</sup>
		       	</td> 			
			</tr>
			<tr>		   		
			</tr>
			<tr>
				<th>(*)Tipo Ajuste:</th>
		    	<td> 
					<select name='idTipoAjuste' id='idTipoAjuste' onchange="GetDatosTipoAjuste();"  value='{TIPO_AJUSTE}' style='width:200px;'>
					{OPTIONS_TIPOS_AJUSTES}					
					</select> <sup>*</sup>
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
		   		<th>(*)Importe:</th>
		    	<td>
		    	  <input type='text' id="fImporteTotal" name='fImporteTotal'  onblur="CalcularImportes(this.value)" onkeypress="return onEnterCalcularImporte(event);" value='{IMPORTE_TOTAL}' style='width:200px;'/>
		       	 <sup>*</sup>
		    	</td>
		    	<td align="right"><b>Importe Interes:</b></td>
		    	<td>
		    	  <input type= "hidden" id="fImporteTotalInteres" name='fImporteTotalInteres' onblur="numero_parse_entero(this.value);" value='{IMPORTE_TOTAL_INTERES}' readonly style='width:200px;'/>
		       	  <label id="lblImporteTotalInteres">{importe_total_interes}</label>
		    	 </td> 		    	
			</tr>
			<tr>
				<th>Incluir Cuotas:</th>
				<td>
				<select id="iCantidadCuotas" name="iCantidadCuotas">
					<option id="iCantidadCuotas" value="1">1</option>
					<option id="iCantidadCuotas" value="2">2</option>
					<option id="iCantidadCuotas" value="3">3</option>
					<option id="iCantidadCuotas" value="4">4</option>
					<option id="iCantidadCuotas" value="5">5</option>
				</select>
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
			<tr>
				<td>&nbsp;</td>
			</tr>
			{OPTIONS_SUCURSALES}
			{OPTIONS_OFICINAS}
			{SELECT_EMPLEADOS}		
			</table>
		</fieldset>
	</form>
</center>
</body>


<script type='text/javascript'>	
	InputMask("dFechaProceso","99/99/9999");

	function saveDatos()
	{
		Formu = document.forms['formAjustesUsuarios'];
		
		//var Formu = document.forms['formGrupo'];
		
			
		if(validarDatosForm(Formu))
		{		
			if(confirm('Esta seguro de realizar esta operacion?. Cuotas Incluidas: '+Formu.iCantidadCuotas.value+''))
			{		
				xajax_updateDatosAjustesUsuarios(xajax.getFormValues('formAjustesUsuarios'));
			}	
		}		
	}
	
		
	function validarDatosForm() 
	{
		var Formu = document.forms['formAjustesUsuarios'];
		var errores = '';
		 
		with (Formu)
		{				
			if(idCuentaUsuario.value == 0 )
			errores += "- Seleccione una Cuenta de Usuario.\n";		
			
			if( !trim(sNumeroCuenta.value) )
			errores += "- El campo Numero Cuenta es requerido.\n";			
			
			if(idTasaIVA.value == 0)
			errores += "- Seleccione una Tasa IVA.\n";	
							
			if(idTipoMoneda.value == 0)
			errores += "- Seleccione un Tipo de Moneda.\n";
		
			if( !trim(iCuotas.value))
			errores += "- El campo Cuotas es requerido.\n";
		
			if(idTipoAjuste.value == 0)
			errores += "- Selecciones un Tipo de Ajuste.\n";
			
			if(!trim(fImporteTotal.value))
			errores += "- El campo Importe es requerido.\n";
			
			if(!trim(fImporteTotalInteres.value))
			errores += "- El campo Importe Interes es requerido.\n";
		
			if(!trim(fImporteTotalIVA.value))
			errores += "- El campo Importe IVA es requerido.\n";
		}
		
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	
	function getCuentaUsuario(value_)
	{
		var Formu = document.forms['formAjustesUsuarios'];	
		
		if(trim(Formu.sNumeroCuenta.value))
		{
			//xajax_getCuentaUsuario(Formu.sNumeroCuenta.value);	
			xajax_buscarDatosUsuarioPorCuentaAU(value_);	
		}			
	}
	
	
	var nav4 = window.Event ? true : false;
	
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
		var Formu = document.forms['formAjustesUsuarios'];	
		
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
	
	
	function GetDatosTipoAjuste()
	{
		var Formu = document.forms['formAjustesUsuarios'];		
		
		//alert("GetDatosTipoAjuste");
		xajax_getDatosAjustes(Formu.idTipoAjuste.value);
		//xajax_podonga();
	}
	
	
	function resetDatosForm()
	{
		var Formu = document.forms['formAjustesUsuarios'];
		
		with (Formu)
		{
			idCuentaUsuario.value = 0;
			idAjusteUsuario.value = 0;
			document.getElementById("datos_cuenta").innerHTML = "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
			sNumeroCuenta.value = "";
			idTasaIVA.value = 0;
			idTipoMoneda.value = 0;
			iCuotas.value = "";
			idTipoAjuste.value = 0;
			fImporteTotal.value = "";
			fImporteTotalInteres.value = "";
			fImporteTotalIVA.value = "";					
			fInteres.value = "";
			fTasaIVA.value = 0;
			sEstado.value = "A";
			sCodigo.value = "";
			sClaseAjuste.value = "";
			fImporteAnterior.value = "";
			fImporteTotalFinal.value = "";
			bDiscriminaIVA.value = 0;
			
			document.getElementById("lblImporteTotalInteres").innerHTML = "";
			document.getElementById("lblImporteTotalIVA").innerHTML = "";
			document.getElementById("lblImporteTotalFinal").innerHTML = "";
		}
	}
	
	
	_messageBox = new DHTML_modalMessage();
	_messageBox.setShadowOffset(5);	
	
	function displayWindow(url_,ancho,alto) 
	{			
			_messageBox.setSource(url_);
			_messageBox.setCssClassMessageBox(false);
			_messageBox.setSize(ancho,alto);
			_messageBox.setShadowDivVisible(true);//Enable shadow for these boxes
			_messageBox.display();
	}
	
	function _closeWindow1() { 
			//resetJsCache();
			_messageBox.close();	
	}	

	
	function GetTasaIVA(idTasaIVA)
	{
		xajax_getTasaIVA(idTasaIVA);		
	}
	
	
	function setDatosCuentaUsuario(_icu,_user,_tarjeta,_tipotarjeta,_version,_numero_cuenta,_li,_it)
	{
		var string = '';
			
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left;\'>Usuario: </label><label>' + _user + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tarjeta: </label><label>' + _tarjeta + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tipo Tarjeta: </label><label>' + _tipotarjeta + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>version: </label><label>' + _version + '</label></div>';
		
		document.getElementById('datos_cuenta').innerHTML = string;
		//document.getElementById('div_limite_credito').innerHTML = _li;
		//document.getElementById('_icu').value = _icu;
		//document.getElementById('_it').value = _it;
		document.getElementById('sNumeroCuenta').value = _numero_cuenta;
		document.getElementById('idCuentaUsuario').value = _icu;
		
		__closeWindows2();
	}
	
	function setDatosCuentaUsuario2(_icu,_user,_tarjeta,_tipotarjeta,_version,_numero_cuenta,_li,_it, _fechaCierre_, _saldoAntedior_)
	{
		var string = '';
			
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left;\'>Usuario: </label><label>' + _user + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tarjeta: </label><label>' + _tarjeta + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tipo Tarjeta: </label><label>' + _tipotarjeta + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>version: </label><label>' + _version + '</label></div>';
		//string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'></label><label>______________</label></div>';
		//string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Ultimo Resumen: </label><label>' + _fechaCierre_ + '</label></div>';
		//string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Importe: </label><label>' + _saldoAntedior_ + '</label></div>';
		
		document.getElementById('datos_cuenta').innerHTML = string;
		//document.getElementById('div_limite_credito').innerHTML = _li;
		//document.getElementById('_icu').value = _icu;
		//document.getElementById('_it').value = _it;
		document.getElementById('sNumeroCuenta').value = _numero_cuenta;
		document.getElementById('idCuentaUsuario').value = _icu;
		
	}	

	
	
	function mostrarBuscador(sURL, iAncho, iAlto)
	{	 
		 createWindows(sURL,'Tarjeta','window_search');
	 
	}

	/*function doOnLoad() {
    dhxWins1 = new dhtmlXWindows();
    dhxWins1.enableAutoViewport(false);
    dhxWins1.attachViewportTo("dhtmlx_wins_body_content");
    dhxWins1.setImagePath("../../codebase/imgs/");
	}*/
	
	var dhxWins1;
	function createWindows(sUrl,sTitulo,idProyecto_)
	{
    var idWind = idProyecto_;
	//if(!dhxWins.window(idWind)){
     	dhxWins1 = new dhtmlXWindows();     	
	    dhxWins1.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
	    _popup_ = dhxWins1.createWindow(idWind, 250, 50, 700, 500);
	    _popup_.setText(sTitulo);
	    ///_popup_.center();
	    _popup_.button("close").attachEvent("onClick", _closeWindows);
		_url_ = sUrl;
	    _popup_.attachURL(_url_);
	//}
} 

function __closeWindows2(){
		 var idWind = "window_search";
		 
		 
		  var isWin = dhxWins1.isWindow(idWind);
		  
		  if(isWin){
		 	dhxWins1.window(idWind).close(); 	
		  }
		  
		  var isWin = dhxWins1.isWindow("window_search");
		  
		  if(isWin){
		 	dhxWins1.window("window_search").close(); 	
		  }		  		 
	}	
	
function _closeWindows(_popup_)
{
	_popup_.close();
	//recargar();
	//parent.dhxWins.close(); // close a window
}  	

function recargar(){
	window.location ="AdminAjustesUsuarios.php";
}
</script>
