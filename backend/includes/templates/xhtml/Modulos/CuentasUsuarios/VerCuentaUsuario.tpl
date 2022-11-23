<center>
	<div id='' style='width:65%;text-align:right;margin-right:10px;'>
		<a href="CuentasUsuarios.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='Volver a la Solicitud' alt='Volver a la Solicitud' border='0' hspace='4' align='absmiddle'> Volver</a>
	</div>
	<form id="form" action="" method="POST">
	 	<input type='hidden' name='idSolicitud' id="idSolicitud" value='{ID_SOLICITUD}' />
	 	
		<fieldset id='cuadroOficina' style="height:550px;width:900px">
		<legend> Datos de la Cuenta:</legend>	
		<table id='TablaCanal' cellpadding="5" cellspacing="0" class="TablaGeneral" width="920px" border="0">
		<tr>
			<td align="left" colspan="3"> <b>Nro. Cuenta: </b>{NUMERO_CUENTA}</td>				
		</tr>
		<tr>
			<td align="left" colspan="3"> <b>Titular: </b>{TITULAR}</td>				
		</tr>
		<tr>		
			<td align="left" colspan="3"> <b>Grupo Afinidad: </b>{GRUPO_AFINIDAD}</td>				
		</tr>
		<tr>
			<td class="subTitulo" align="left" height="30" colspan="5">
				<label id="Cuentas_Saldos">Saldos y Fechas:
				</label>
			</td>
		</tr>	
		<tr>
			<td colspan="3">
				<table id='TablaCanal' cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%" border="0">
				<tr>
					<th>Periodo:</th><td>&nbsp;{PERIODO_ACTUAL}</td>
					<th>Fecha Cierre:</th><td>&nbsp;{FECHA_CIERRE_ACTUAL}</td>
					<th>Fecha Vencimiento:</th><td align="left">&nbsp;{FECHA_VTO_ACTUAL}</td>
				</tr>
				<tr>
					<th>Saldo:</th><td>&nbsp;{SALDO_ACTUAL}</td>
					<th>Importe Total de Cobranzas:</th><td>&nbsp;{TOTAL_COBRANZAS_ACTUAL}</td>
					<th>Estado:</th><td>&nbsp;{ESTADO_CUENTA}</td>
				</tr>
				</table>
			</td>
		</tr>	
		<tr>
			<td class="subTitulo" align="left" height="30" colspan="5">
				<label id="Cuentas_Limites">Limites:
				</label>
			</td>
		</tr>	
		<tr>
			<td align="left" colspan="2"> <b>Limite:&nbsp;</b>{LIMITE}</td>
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
				<th style="width:250px"> Acumulado por Cuotas:</th>
				<td style="width:120px"> <span id="lblAcumuladoCuota" name="lblAcumuladoCuota">{ACUMULADO_CUOTAS}</span></td>
				<th style="width:250px"> Remanente de Limites de Cuotas:</th>
				<td style="width:120px"> <span id="lblRemanenteCuota" name="lblRemanenteCuota">{REMANENTES_CUOTAS}</td>
			</tr>
			<tr>
				<th> Acumulado en un Pago:</th>
				<td> <span id="lblAcumuladoUnPago" name="lblAcumuladoUnPago">{ACUMULADO_UNPAGO}</span></td>
				<th> Remanente de Limite de Compra:</th>
				<td> <span id="lblRemanenteCompra" name="lblRemanenteCompra">{REMANENTE_COMPRA}</span></td>
			</tr>
			<tr>
				<th>  Acumulado Adelantos en Efectivo:</th>
				<td> <span id="lblAcumuladoAdelanto" name="lblAcumuladoAdelanto">{ACUMULADO_ADELANTOS}</span></td>
				<th> Remanente de Limite de Adelantos en Efectivo:</th>
				<td> <span id="lblRemanenteAdelanto" name="lblRemanenteAdelanto">{REMANENTE_ADELANTO}</span></td>
			</tr>
			<tr>
				<th colspan="2"></th>
				<th> Remanente Global:</th>
				<td> <span id="lblRemanenteGlobal" name="lblRemanenteGlobal">{REMANENTE_GLOBAL}</span></td>
			</tr>
			</table>
			</td>
		</tr>
		</table>	
		</fieldset>
	</form>
<script>
	//xajax_mostrarLimite({ID_LIMITE});

	//xajax_mostrarCalendarioPorGrupoAfinidad({ID_GRUPO_AFINIDAD});

</script>	