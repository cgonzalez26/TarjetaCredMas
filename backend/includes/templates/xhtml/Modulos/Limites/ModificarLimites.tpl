<center>
	<form id="formLimites" action="" method="POST">
	 	<input type='hidden' name='idLimiteActual' id="idLimiteActual" value='{ID_LIMITE}' />
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
	 	
		<fieldset id='cuadroOficina' style="height:510px;width:95%">
		<legend> Datos de la Cuenta y Limites:</legend>	
		<table id='TablaLimites' cellpadding="5" cellspacing="0" class="TablaGeneral" width="100%" border="0">
		<tr>
			<td align="left"> <b>Nro. Cuenta: </b>{NUMERO_CUENTA}</td>						
			<td><b>Ultimo Periodo:</b>&nbsp;{PERIODO}</td>
			<td align="left"> <b>Titular: </b>{TITULAR}</td>							
		</tr>	
		<tr>
			<td class="subTitulo" align="left" height="30" colspan="5">
				<label id="Cuentas_Limites">Limites:
				</label>
			</td>
		</tr>	
		<tr>
			<td align="left" colspan="2"> <b>Limite:&nbsp;</b>
			<select id="idLimite" name="idLimite" onchange="cambiarLimites(this.value)">{optionsLimites}</select></td>
			<td><b>Fecha de Asignaci&oacute;n:</b>&nbsp;{FECHA_LIMITE}</td>
		</tr>
		<tr>
			<td colspan="4"	>
			<table id='TablaCanal' cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%" border="0">
			<tr>
				<th style="width:250px"> Limite de Compra:</th>
				<td style="width:120px"> <span id="lbliLimiteCompra">{LIMITE_COMPRA}</span></td>
				<th style="width:250px"> Limite de Financiacion:</th>
				<td style="width:120px"><span id="lbliLimitePorcentajeFinanciacion">{LIMITE_PORCENTAJE_FINANCIACION}</span>&nbsp;%&nbsp;&nbsp;<span id="lblLimiteFinanciacion">{LIMITE_FINANCIACION}</span></td>
			</tr>
			<tr>
				<th> Limite de Credito:</th>
				<td> <span id="lbliLimiteCredito">{LIMITE_CREDITO}</span></td>
				<th> Limite de Prestamo:</th>
				<td><span id="lbliLimitePorcentajePrestamo">{LIMITE_PORCENTAJE_PRESTAMO}</span>&nbsp;%&nbsp;&nbsp;<span id="lblLimitePrestamo">{LIMITE_PRESTAMO}</span></td>
			</tr>
			<tr>
				<th> Limite de Global:</th>
				<td> <span id="lbliLimiteGlobal" name="lbliLimiteGlobal">{LIMITE_GLOBAL}</span></td>								
				<th> Limite de Adelanto:</th>
				<td><span id="lbliLimitePorcentajeAdelanto" name="lbliLimitePorcentajeAdelanto">{LIMITE_PORCENTAJE_ADELANTO}</span>&nbsp;%&nbsp;&nbsp;<span id="lblLimiteAdelanto">{LIMITE_ADELANTO}</span></td>
			</tr>			
			<!--<tr>
				<td colspan="2"></td>	
				<th> Limite de SMS:</th>
				<td><span id="lbliLimitePorcentajeSMS" name="lbliLimitePorcentajeSMS">{LIMITE_PORCENTAJE_SMS}</span>&nbsp;%&nbsp;&nbsp;<span id="lblLimiteSMS">{LIMITE_SMS}</span></td>
			</tr>	-->
			
			</table>
			</td>		
		</tr>
		<tr>
			<td class="subTitulo" align="left" height="30" colspan="5">
				<label id="Cuentas_Limites">Disponibles:
				</label>
			</td>
		</tr>	
		<tr>
			<td colspan="4">
			<table id='TablaCanal' cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%" border="0">
			<tr>
				<th style="width:250px"> Remanente de Cuotas:</th>
				<td style="width:80px">$ <span id="lblRemanenteCuota" name="lblRemanenteCuota">{REMANENTE_CUOTAS}</td>
				<th style="width:240px"> Remanente de Prestamo:</th>
				<td style="width:80px"> $ <span id="lblRemanentePrestamo" name="lblRemanentePrestamo">{REMANENTE_PRESTAMO}</span></td>
			</tr>
			<tr>
				<th> Remanente de Compra:</th>
				<td>$ <span id="lblRemanenteCompra" name="lblRemanenteCompra">{REMANENTE_COMPRA}</span></td>
				<td colspan="2"></td>
				<!--<th> Remanente de Adelantos SMS:</th>
				<td>$ <span id="lblRemanenteSMS" name="lblRemanenteSMS">{REMANENTE_SMS}</span></td>-->
			</tr>
			<tr>
				<th> Remanente de Adelantos en Efectivo:</th>
				<td>$ <span id="lblRemanenteAdelanto" name="lblRemanenteAdelanto">{REMANENTE_ADELANTO}</span></td>
				<th> Remanente Global:</th>
				<td>$ <span id="lblRemanenteGlobal" name="lblRemanenteGlobal">{REMANENTE_GLOBAL}</span></td>				
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td class="subTitulo" align="left" height="30" colspan="5">
				<label id="Cuentas_Limites">Historial:</label>
			</td>
		</tr>	
		<tr>
			<td align="left" colspan="5" style="height:100px" valign="top">
			<div id="divHistorial" style="height:100px;overflow-y: scroll;border:1px solid #000">
			{HISTORIAL}
			</div>
			</td>
		</tr>	
		</table>
			
		</fieldset>
		<table cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%" style="height:30px">
		<tr>
			<td align="center" valign="top">
			<input type="button" id="cmd_enviar" name="cmd_enviar" onclick="javascript:sendFormSolicitud();" value="Guardar" tabindex="84"/>			
			</td>
		</tr>
		</table>
	</form>
<script>
	function cambiarLimites(){
		xajax_mostrarLimites(xajax.getFormValues('formLimites'));
	}
	
	function sendFormSolicitud(){
		/*if(document.getElementById('idLimiteActual').value == document.getElementById('idLimite').value){
			alert("No ha modificado el Limite seleccione otro por favor");
			return;
		}*/ //Se comento esto porque a lo mejor decido actualizar datos del  limite estandar y deberia poder elegir el mismo.
		if(confirm('Esta seguro de realizar esta operacion?'))
		{		
			xajax_updateDatosCuentasLimites(xajax.getFormValues('formLimites'));
		}	
	}
	//xajax_mostrarLimite({ID_LIMITE});

	//xajax_mostrarCalendarioPorGrupoAfinidad({ID_GRUPO_AFINIDAD});

</script>	