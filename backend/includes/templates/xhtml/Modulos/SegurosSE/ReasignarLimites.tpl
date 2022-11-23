<center>
	<form id="formLimites" action="" method="POST">
	 	<input type='hidden' name='idCuentaUsuario' id="idCuentaUsuario" value='{ID_CUENTA_USUARIO}' />
	 	<input type='hidden' name='idTarjetaCredito' id="idTarjetaCredito" value='{ID_TARJETA}' />
	 	<input type='hidden' name='idDetalleCuentaUsuario' id="idDetalleCuentaUsuario" value='{ID_DETALLE_CUENTA}' />	 	
	 	
	 	<input type='hidden' name='hdnLimiteCompra' id="hdnLimiteCompra" value='{LIMITE_COMPRA}' />
	 	<input type='hidden' name='hdnLimiteCredito' id="hdnLimiteCredito" value='{LIMITE_CREDITO}' />
	 	<input type='hidden' name='hdnLimiteFinanciacion' id="hdnLimiteFinanciacion" value='{LIMITE_FINANCIACION}' />
	 	<input type='hidden' name='hdnLimiteAdelanto' id="hdnLimiteAdelanto" value='{LIMITE_ADELANTO}' />
	 	<input type='hidden' name='hdnLimitePrestamo' id="hdnLimitePrestamo" value='{LIMITE_PRESTAMO}' />
	 	<input type='hidden' name='hdnLimiteSMS' id="hdnLimiteSMS" value='{LIMITE_SMS}' />
	 	<input type='hidden' name='hdnLimiteGlobal' id="hdnLimiteGlobal" value='{LIMITE_GLOBAL}' />	 	
	 	
	 	<input type='hidden' name='hdnRemanenteCuota' id="hdnRemanenteCuota" value='{REMANENTE_CUOTAS}' />	 	
	 	<input type='hidden' name='hdnRemanenteCompra' id="hdnRemanenteCompra" value='{REMANENTE_COMPRA}' />	 	
	 	<input type='hidden' name='hdnRemanenteAdelanto' id="hdnRemanenteAdelanto" value='{REMANENTE_ADELANTO}' />	 	
	 	<input type='hidden' name='hdnRemanentePrestamo' id="hdnRemanentePrestamo" value='{REMANENTE_PRESTAMO}' />	 	
	 	<input type='hidden' name='hdnRemanenteSMS' id="hdnRemanenteSMS" value='{REMANENTE_SMS}' />	 	
	 	<input type='hidden' name='hdnRemanenteGlobal' id="hdnRemanenteGlobal" value='{REMANENTE_GLOBAL}' />	
	 	<input type='hidden' name='hdnFechaCierre' id="hdnFechaCierre" value='{FECHA_CIERRE}' />	
	 		 	
	 	<input type='hidden' name='hdnPremio' id="hdnPremio" value='{PREMIO}' />		 	
	 	<input type='hidden' name='sPci' id="sPci" value='{sPci}' />	 	
	 	<input type='hidden' name='idLimiteNuevo' id="idLimiteNuevo" value='{ID_LIMITE_NUEVO}' />
	 	<input type='hidden' name='hdnFechaCierre' id="hdnFechaCierre" value='{FECHA_CIERRE}' />	 	
	 	<input type='hidden' name='sCadenaAll' id="sCadenaAll" value='{sCadenaAll}' />	 
	 	<input type='hidden' name='idPlanComercio' id="idPlanComercio" value='{idPlanComercio}' />	 		
	 	
		<fieldset id='cuadroOficina' style="height:180px;width:95%">
		<legend> Datos de la Cuenta y Limites:</legend>	
		<table id='TablaLimites' cellpadding="5" cellspacing="0" class="TablaGeneral" width="100%" border="0">
			<tr>
				<td align="left" colspan="2"> <b>Nro. Cuenta: </b>{NUMERO_CUENTA}</td>
								
			</tr>
			<tr>
				<td align="left" colspan="3"> <b>Titular: </b>{TITULAR}</td>				
			</tr>		
			<!--<tr> 
				<td align="left" colspan="3">
					<b> (*)Plan de Cuotas </b> <select name="idPlanComercio" id="idPlanComercio" > 
    	            <option value="0"> Seleccionar.. </option> 
                 	{_OPTION_PLANES_} 
                   </select> 
                </td>
			</tr>-->
			<tr> 
				<td align="left" colspan="3">
					<b> (*)Plan de Cuotas :   {DURACION}</b> 
                </td>
			</tr>		
			<tr>
				<td style="color:red">Monto = $&nbsp;{PREMIO}</td>
			</tr>
		</table>
			
		</fieldset>
		<table cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%" style="height:30px">
			<tr>
				<td align="center" valign="top">
				<input type="button" id="cmd_enviar" name="cmd_enviar" onclick="javascript:sendFormSolicitud();" value="Guardar" tabindex="84"/>			
				</td>
			</tr>
			<tr>
				<td align="center"><div id='divMessageOperacion' style='text-align:center;'></div></td>
			</tr>
		</table>
	</form>
<script>
	function cambiarLimites(){
		xajax_mostrarLimites(xajax.getFormValues('formLimites'));
	}
	
	function sendFormSolicitud(){
		var idPlanComercio = document.getElementById('idPlanComercio').value;
		if(idPlanComercio == 0){
			alert("El Plan de Cuotas es requerido");
			return;
		}
		/*var fPremio = parseFloat(document.getElementById('hdnPremio').value);
		var fRemanenteCuota = parseFloat(document.getElementById('hdnRemanenteCuota').value);
		if(fRemanenteCuota < fPremio){
			alert("El Remanente de Cuotas debe ser Mayor al Monto");
			return;
		}
		var idLimiteActual = document.getElementById('idLimiteActual').value;
		var idLimiteNuevo = document.getElementById('idLimite').value;
		if(idLimiteActual == idLimiteNuevo){
			alert("No ha cambiado de Limite seleccione otro para asignar uno nuevo");
			return;
		}*/
		
		if(confirm('Esta seguro de realizar esta operacion?'))
		{	
			document.getElementById("cmd_enviar").style.display = "none"; 
			viewMessageLoad('divMessageOperacion');		
			xajax_updateDatosCuentasLimites(xajax.getFormValues('formLimites'));
		}	
	}
	//xajax_mostrarLimite({ID_LIMITE});

	//xajax_mostrarCalendarioPorGrupoAfinidad({ID_GRUPO_AFINIDAD});
	
	shortcut.add("Backspace",function (){
				/*var t = event.srcElement.type;
				if( t == 'text') alert('estas en un input text');
				if( t == 'textarea' ) alert('estas en un  textarea');
				return true;*/
		},{
		'type':'keydown',
		'disable_in_input':true,
		'propagate':false,
		'target':document
	});
	
	shortcut.add("F5",function (){
			return true;
	},{
		'type':'keydown',
		'propagate':false,
		'target':document
	}); 
	
	/*shortcut.add("Enter",function (){
			return true;
	},{
		'type':'keydown',
		'propagate':false,
		'target':document
	}); */
</script>	