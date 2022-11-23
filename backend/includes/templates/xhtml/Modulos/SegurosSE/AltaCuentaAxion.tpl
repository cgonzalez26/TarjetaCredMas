<center>
	<form id="formCuenta" action="" method="POST">
	
	    <input type='hidden' name='idSolicitud' id="idSolicitud" value='{ID_SOLICITUD}' />
	    <input type='hidden' name='idLimite' id="idLimite" value='{ID_LIMITE}' />
	    <input type='hidden' name='idGrupoAfinidad' id="idGrupoAfinidad" value='{ID_GRUPO_AFINIDAD}' />
	    <input type='hidden' name='hdnIdBIN' id="hdnIdBIN" value='{ID_BIN}' />
	 	<input type='hidden' name='sNumero' id="sNumero" value='{NUMERO_SOLICITUD}' />    
	 	<input type='hidden' name='hdnTasaSobreMargen' id="hdnTasaSobreMargen" value='{TASA_SOBRE_MAREN}' />
	 		 	
	 	<input type='hidden' name='hdnFechaCierre' id="hdnFechaCierre" value='{hdnFechaCierre}' />
	 	<input type='hidden' name='hdnFechaVencimiento' id="hdnFechaVencimiento" value='{hdnFechaVencimiento}' />
	 	<input type='hidden' name='hdnPeriodo' id="hdnPeriodo" value='{hdnPeriodo}' />
	 	<input type='hidden' name='hdnFechaMora' id="hdnFechaMora" value='{hdnFechaMora}' />
	 	
	 	
	 	<input type='hidden' name='hdnTasaPunitorioPeso' id="hdnTasaPunitorioPeso" value='{hdnTasaPunitorioPeso}' />
	 	<input type='hidden' name='hdnTasaFinanciacionPeso' id="hdnTasaFinanciacionPeso" value='{hdnTasaFinanciacionPeso}' />
	 	<input type='hidden' name='hdnTasaCompensatorioPeso' id="hdnTasaCompensatorioPeso" value='{hdnTasaCompensatorioPeso}' />
	 	<input type='hidden' name='hdnTasaFinanciacionDolar' id="hdnTasaFinanciacionDolar" value='{hdnTasaFinanciacionDolar}' />
	 	<input type='hidden' name='hdnTasaPunitorioDolar' id="hdnTasaPunitorioDolar" value='{hdnTasaPunitorioDolar}' />
	 	<input type='hidden' name='hdnTasaCompensacionDolar' id="hdnTasaCompensacionDolar" value='{hdnTasaCompensacionDolar}' />
	 	
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
	 		 	
	 	<input type='hidden' name='hdnPremio' id="hdnPremio" value='{PREMIO}' />		 	
	 	<input type='hidden' name='sPci' id="sPci" value='{sPci}' />
	 	<input type='hidden' name='sCadenaAll' id="sCadenaAll" value='{sCadenaAll}' />	 	
	 	<input type='hidden' name='idPlanComercio' id="idPlanComercio" value='{idPlanComercio}' />	 	
	 	
	 	
	 	
		<fieldset id='cuadroOficina' style="height:180px;width:95%">
		<legend> Datos de la Solicitud:</legend>	
		<table id='TablaLimites' cellpadding="5" cellspacing="0" class="TablaGeneral" width="100%" border="0">
			<tr>
				<td align="left" colspan="2"> <b>Nro. Solicitud: </b>{NUMERO_SOLICITUD}</td>
								
			</tr>
			<tr>
				<td align="left" colspan="3"> <b>Titular del Seguro: </b>{TITULAR} <b>Titular Tarjeta: </b> {TITULAR}</td>				
			</tr>		
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
				<td align="center" valign="top" id="btnGuardar">
				    <button type="button" id="cmd_enviar" name="cmd_enviar" onclick="javascript:sendFormSolicitud();" tabindex="84"> Confirmar Cuenta </button>		
				</td>
			</tr>
		</table>
	</form>
<script>
	
	function sendFormSolicitud(){
		var idPlanComercio = document.getElementById('idPlanComercio').value;
		if(idPlanComercio == 0){
			alert("El Plan de Cuotas es requerido");
			return;
		}
		if(confirm('Esta seguro de realizar esta operacion?'))
		{		
			CargandoLex('btnGuardar','Procesando...');
			xajax_AltaCuentaTarjeta(xajax.getFormValues('formCuenta'));
		}	
	}
	
			
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
</script>	