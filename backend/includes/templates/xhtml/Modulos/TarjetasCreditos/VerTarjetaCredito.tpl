<center>
	<div id='' style='width:65%;text-align:right;margin-right:10px;'>
		<a href="Buscar.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='Volver Listado de Tarjetas de Creditos' alt='Volver Listado de Tarjetas de Creditos' border='0' hspace='4' align='absmiddle'> Volver</a>
	</div>
	<form id="form" action="" method="POST">
	 	
	<fieldset id='cuadroOficina' style="height:370px;width:900px">
	<legend> Datos de la Tarjeta de Credito:</legend>	
		<table id='TablaTarjeta' cellpadding="5" cellspacing="0" class="TablaGeneral" width="100%" border="0">
		<tr>
			<td align="left" colspan="3"> <b>Nro. Tarjeta Credito: </b>{NUMERO_TARJETA}</td>				
		</tr>
		<tr>
			<td align="left" colspan="3"> <b>Titular: </b>{TITULAR}</td>				
		</tr>
		<tr>
			<td align="left"> <b>Nro. de Cuenta: </b>{NUMERO_CUENTA}</td>
			<td align="left"> <b>Nro. Titular/Adic.: </b>{NUMERO_TITULAR}</td>
			<td align="left"> <b>Nro. Version.: </b>{NUMERO_VERSION}</td>
			<td align="left"> <b>Nro. Digito verificador: </b>{NUMERO_DIGITO_VERIFICADOR}</td>
		</tr>		
		<tr>
			<td align="left" colspan="3"> <b>Grupo Afinidad: </b>{GRUPO_AFINIDAD}</td>				
		</tr>
		<tr>
			<td align="left"> <b>Fecha Alta: </b>{FECHA_ALTA}</td>				
			<td align="left"> <b>Fecha Inicio Vigencia: </b>{FECHA_INICIO_VIGENCIA}</td>				
			<td align="left"> <b>Fecha Vto. Vigencia: </b>{FECHA_VTO_VIGENCIA}</td>				
		</tr>
		<tr>
			<td align="left"> <b>Fecha Embozo: </b>{FECHA_EMBOZO}</td>				
			<td align="left"> <b>Fecha Entrega al Usuario: </b>{FECHA_ENTREGA}</td>				
		</tr>
		<tr>
			<td align="left"> <b>Estado: </b>{ESTADO}</td>				
			<td align="left"> <b>Fecha de Estado Actual: </b>{FECHA_ESTADO}</td>				
		</tr>
		<tr><td style="height:10px">&nbsp;</td></tr>
		<tr>
			<td class="subTitulo" align="left" height="30" colspan="4">
				<label id="Solicitudes_plTituloTitular">Remanentes de Limites:
				</label>
			</td>
		</tr>
		<tr>
			<td align="left"> <b>Compra: </b>{REMANENTE_COMPRA}</td>				
			<td align="left"> <b>Credito: </b>{REMANENTE_CREDITO}</td>				
			<td align="left"> <b>Financiacion: </b>{REMANENTE_FINANCIACION}</td>				
		</tr>
		<tr>
			<td align="left"> <b>Adelanto: </b>{REMANENTE_ADELANTO}</td>				
			<td align="left"> <b>Prestamo: </b>{REMANENTE_PRESTAMO}</td>				
			<td align="left"> <b>Global: </b>{REMANENTE_GLOBAL}</td>				
		</tr>
		</table>		
	</fieldset>		
	</form>