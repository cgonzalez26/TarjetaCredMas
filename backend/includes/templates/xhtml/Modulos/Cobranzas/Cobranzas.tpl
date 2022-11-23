<body style="background-color:#FFFFFF">
<div id="BODY">
<br />
<center>
	<div id='' style='width:860px;text-align:right;margin-right:10px;'>
		<div id="idBtotonGuardar" style="{DISPLAY_GUARDAR}">
			<img src='{IMAGES_DIR}/disk.png'  title='Guardar' alt='Guardar Grupo' border='0' hspace='4' align='absmiddle'> 
			<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
			&nbsp;&nbsp;			
			<img src='{IMAGES_DIR}/back.png' title='Buscar Grupo' alt='Buscar Grupo' border='0' hspace='4' align='absmiddle'> 
			<a href="Cobranzas.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
		</div>		
		<!--<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo' alt='Nuevo' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
			<img src='{IMAGES_DIR}/back.png' title='Buscar Grupo' alt='Buscar Grupo' border='0' hspace='4' align='absmiddle'> 
			<a href="Cobranzas.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
		</div>-->
	</div>
	<form id="formCobranzas" action="AdminCobranzas.php" method="POST">
		<input type="hidden" id="idCobranza" name="idCobranza" value="{ID_COBRANZA}" />		
		<input type="hidden" id="sEstado" name="sEstado" value="{ESTADO}" />
		<input type="hidden" id="idCuentaUsuario" name="idCuentaUsuario" value="{ID_CUENTA_USUARIO}" />
		<input type="hidden" id="sCodigo" name="sCodigo" value="{CODIGO}" />						
		<fieldset id='cuadroAjuste' style="height:550px;width:860px;border:1px solid #CCC;">
			<legend> Cobranzas</legend>			
			<table id='TablaDatosEmpleado' cellpadding="0" cellspacing="6" class="TablaGeneral" width="100%">
				<tr>
					<td class="subTitulo" height="30" align="left" colspan="6">
					<label id="">Datos Empleado:</label>
					</td>				
				</tr>
				<tr>	
					<td colspan="4">
						<div style='display:block;'><label style='width:120px;float:left;'>Fecha hora: </label>{fecha_hora}<label> </label></div>						
					</td>
				</tr>
				<tr>	
					<td colspan="4">
						<div style='display:block;'><label style='width:120px;float:left;'>Empleado: </label><label>{empleado} </label></div>						
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div style='display:block;'><label style='width:120px;float:left'>Oficina: </label><label>{oficina}</label></div>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div style='display:block;'><label style='width:120px;float:left'>Sucursal: </label>{sucursal}<label></label></div>
					</td>
				</tr>
			</table>
			<table id='TablaCuentaUsuario' cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%">
				<tr>
					<td class="subTitulo" height="30" align="left" colspan="4">
					<label id="">Cuenta:</label>
					</td>				
				</tr>				
				<tr>
					<th> (*)Numero Cuenta: </th>
					<td><input type='text' id="sNumeroCuenta" name='sNumeroCuenta' value='{NUMERO_CUENTA}' style='width:200px;'/></td>
			   		<td>
			   			<input id="search_cuenta" type="button" onclick="getCuentaUsuario(document.getElementById('sNumeroCuenta').value)" style="" value="Buscar" name="search_cuenta">
						<input id="advanced_search_cuenta" type="button" 
						onclick="mostrarBuscador('BuscarUsuario.php',700,500);" style="" value="busqueda avanzada" name="advanced_search_cuenta">
					</td>	
					<td>&nbsp;</td>			
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>	
				<tr>
					<td colspan="4">
						<div style="height:50px;text-align:left;" id="datos_cuenta">
							{datos_cuenta}
						</div>						
					</td>					
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>			
			</table>
			<table id='TablaCobranza' cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%">
			<tr>
				<td class="subTitulo" height="30" align="left" colspan="4">
				<label id="">Cobranza:</label>
				</td>
			</tr>
			<tr>			
				<th> (*)Tipo Moneda: </th>
				<td> 
					<select name='idTipoMoneda' id='idTipoMoneda' value='{TIPO_MONEDA}' " style='width:200px;'">
					{OPTIONS_TIPOS_MONEDAS}					
					</select>
				</td>
				<th> (*)Importe: </th>
				<td> 
					<input type="text" id="fImporte" name='fImporte' onblur="numero_parse_flotante(this.value);" value='{IMPORTE}' style='width:100px;'/>					
				</td> 		 					   		
			</tr>			
			<tr>
				<th>Fecha Cobranza:</th>
				<td>
					<input type="text" id="dFechaCobranza" name='dFechaCobranza' " readonly value='{FECHA_COBRANZA}' style='width:100px;'/>					
				</td>
				<td align="right"><b>Fecha Presentacion</b></td>
				<td><label id="dFechaPresentacion">{FECHA_PRESENTACION}</label></td>
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


<script type='text/javascript'>	
	InputMask("dFechaCobranza","99/99/9999");

	function saveDatos()
	{
		var Formu = document.forms['formCobranzas'];
		
		if(validarDatosForm(Formu))
		{		
			if(confirm('Esta seguro de realizar esta operacion?'))
			{		
				//window.print();
				xajax_updateDatosCobranzas(xajax.getFormValues('formCobranzas'));
			}	
		}		
	}
	
		
	function diferenciaFechas (pdFecha1, pdFecha2) 
	{   
   		//Obtiene dia, mes y año  
   		var fecha1 = new fecha( pdFecha1 );     
   		var fecha2 = new fecha( pdFecha2 );  
     
   		//Obtiene objetos Date  
   		var miFecha1 = new Date( fecha1.anio, fecha1.mes, fecha1.dia );  
   		var miFecha2 = new Date( fecha2.anio, fecha2.mes, fecha2.dia );  
  
   		//Resta fechas y redondea  
   		var diferencia = miFecha1.getTime() - miFecha2.getTime();  
   		var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));  
   		//var segundos = Math.floor(diferencia / 1000);  
   		
   		//alert ('La diferencia es de ' + dias + ' dias,\no ');  
     
   		return dias;  
	}  
	
	
	function validarDatosForm() 
	{
		var Formu = document.forms['formCobranzas'];
		var errores = '';
		 
		with (Formu)
		{										
			if(idCuentaUsuario.value == 0 )
			errores += "- Seleccione una Cuenta de Usuario.\n";		
			
			if( !trim(sNumeroCuenta.value) )
			errores += "- El campo Numero Cuenta es requerido.\n";			
			
			if(idTipoMoneda.value == 0)
			errores += "- Seleccione un Tipo de Moneda.\n";
		
			if(!trim(dFechaCobranza.value))
			{
				errores += "- El campo Fecha Cobranza es requerido.\n";
			}
			/*else
			{
				if(diferenciaFechas(document.getElementById('dFechaPresentacion').innerHTML, dFechaCobranza.value) >=7)
				{
					errores += "- La Fecha de Cobranza no puede ser anterior a 7 dias de la fecha actual.\n";
				}
			}*/

			
			if(!trim(fImporte.value))
			{
				errores += "- El campo Importe es requerido.\n";	
			}
			else
			{
				if(fImporte.value < 5)
				errores += "- El Importe debe se mayor a $5.\n";	
			}
			
			
	 	}
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	
	function getCuentaUsuario()
	{
		var Formu = document.forms['formCobranzas'];	
		if(trim(Formu.sNumeroCuenta.value))
		{
			xajax_getCuentaUsuario(Formu.sNumeroCuenta.value, true);	
		}			
	}
	
	
	/*var nav4 = window.Event ? true : false;
	
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
	
	}	*/

	function imprimir_()
	{
		
		//document.getElementById('impresionesCobranza').innerHTML = "Prueba";
		
  	  	//alert(document.getElementById('impresionesCobranza').innerHTML );
		window.print();		
		/*alert('si');*/
	}
	
	
	function resetDatosForm()
	{
		var Formu = document.forms['formCobranzas'];
		
		with (Formu)
		{
			idCuentaUsuario.value = 0;
			idCobranza.value = 0;
			document.getElementById("datos_cuenta").innerHTML = "<span style='color:#F00;font-size:11px;'>- ingrese numero de cuenta de usuario o identifiquelo desde busqueda avanzada</span>";
			sNumeroCuenta.value = "";
			idTipoMoneda.value = 0;
			fImporte.value = "";
			sEstado.value = "A";
			dFechaCobranza.value = "";
			dFechaPresentacion.innerHTML = "";			
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
	
	/*function _closeWindow1() { 
			//resetJsCache();
			_messageBox.close();	
	}	*/

	
	function GetTasaIVA(idTasaIVA)
	{
		xajax_getTasaIVA(idTasaIVA);		
	}
	
	
	function setDatosCuentaUsuario(_icu,_user,_tarjeta,_tipotarjeta,_version,_numero_cuenta,_li,_it, _fechaCierre_, _saldoAntedior_)
	{
		var string = '';
			
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left;\'>Usuario: </label><label>' + _user + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tarjeta: </label><label>' + _tarjeta + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Tipo Tarjeta: </label><label>' + _tipotarjeta + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>version: </label><label>' + _version + '</label></div>';
		//string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'></label><label>______________</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Ultimo Resumen: </label><label>' + _fechaCierre_ + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Importe: </label><label>' + _saldoAntedior_ + '</label></div>';
		
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
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Ultimo Resumen: </label><label>' + _fechaCierre_ + '</label></div>';
		string += '<div style=\'display:block;\'><label style=\'width:120px;float:left\'>Importe: </label><label>' + _saldoAntedior_ + '</label></div>';
		
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
		//alert(idWind);
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

function _closeWindows(_popup_)
{
	_popup_.close();
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

function recargar(){
	window.location ="Cobranzas.php";
}
</script>
