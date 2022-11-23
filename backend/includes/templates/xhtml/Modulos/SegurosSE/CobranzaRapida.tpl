<body style="background-color:#FFFFFF">
<div id="BODY">
<br />
<center>	
	<form id="formCobranzas" action="CobranzaRapida.php" method="POST">
		<input type="hidden" id="idCobranza" name="idCobranza" value="{ID_COBRANZA}" />		
		<input type="hidden" id="sEstado" name="sEstado" value="{ESTADO}" />
		<input type="hidden" id="idCuentaUsuario" name="idCuentaUsuario" value="{ID_CUENTA_USUARIO}" />
		<input type="hidden" id="sCodigo" name="sCodigo" value="{CODIGO}" />		
			<div align="center" id="sMensaje"></div>	
			<table id='TablaCuentaUsuario' cellpadding="0" cellspacing="5" class="TablaGeneral" width="600px">
				<tr>
					<td class="subTitulo" height="30" align="left" colspan="4">
					<label id="">Cuenta:</label>
					</td>				
				</tr>					
				<tr>
					<td colspan="4">
						<div style="height:50px;text-align:left;" id="datos_cuenta">
							{datos_cuenta}
						</div>						
					</td>					
				</tr>	
				{MENSAJE}		
			</table>
			<table id='TablaCobranza' cellpadding="0" cellspacing="5" class="TablaGeneral" width="600px">
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
					<input type="text" id="fImporte" name='fImporte' onblur="numero_parse_flotante(this.value);" value='{TOTAL_A_PAGAR}' style='width:100px;'/>					
				</td> 		 					   		
			</tr>			
			<tr>
				<th>Fecha Cobranza:</th>
				<td>
					<input type="text" id="dFechaCobranza" name='dFechaCobranza'  readonly value='{FECHA_COBRANZA}' style='width:100px;'/>					
				</td>
				<td align="right"><b>Fecha Presentacion</b></td>
				<td><label id="dFechaPresentacion">{FECHA_PRESENTACION}</label></td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4" align="right">
					<div id="idBtotonGuardar" style="{DISPLAY_GUARDAR}">
			<img src='{IMAGES_DIR}/disk.png'  title='Guardar' alt='Guardar Grupo' border='0' hspace='4' align='absmiddle'> 
			<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
			</div>		
				</td>
			</tr>			
			</table>
		
	</div>
	</form>
</center>



<script type='text/javascript'>	
	//InputMask("dFechaCobranza","99/99/9999");

	function saveDatos()
	{
		var Formu = document.forms['formCobranzas'];
		
		if(validarDatosForm(Formu))
		{		
			if(confirm('Esta seguro de realizar esta operacion?'))
			{		
				viewMessageLoad('sMensaje');
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
			if(idTipoMoneda.value == 0)
			errores += "- Seleccione un Tipo de Moneda.\n";
		
			if(!trim(dFechaCobranza.value))
			{
				errores += "- El campo Fecha Cobranza es requerido.\n";
			}
			else
			{
				if(diferenciaFechas(document.getElementById('dFechaPresentacion').innerHTML, dFechaCobranza.value) >=7)
				{
					errores += "- La Fecha de Cobranza no puede ser anterior a 7 dias de la fecha actual.\n";
				}
			}

			
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
			document.getElementById("datos_cuenta").innerHTML = "";
			sNumeroCuenta.value = "";
			idTipoMoneda.value = 0;
			fImporte.value = "";
			sEstado.value = "A";
			dFechaCobranza.value = "";
			dFechaPresentacion.innerHTML = "";			
		}
	}
	
	
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

</script>
