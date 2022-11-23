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
</style>
<center>

<div style="width:700px;">
	<div id='' style='width:700px;text-align:right;'>
		<a href="{url_back}" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='regresar' alt='regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>

<fieldset id='cuadroAjuste' style="width:860px;border:1px solid #CCC;">
	<legend> Cupones</legend>
   <table cellpadding="0" cellspacing="0" width="100%" border="0" align="center" class="TablaGeneral">
  
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
							<td colspan="4" style="font-weight:bold;font-family:Times New Roman;font-size:24px;">
								Nro. :{sNumeroCupon}
							</td>
						</tr>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">Cuenta:</label>
							</td>
						</tr>

						<tr>
							<td width="113">
								<span>Cuenta:</span>
							</td>
							<td colspan="3" align="left">
								<span style="">{sNumeroCuenta}</span>
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
							<td width="113">
								<span>Comercio:</span>
							</td>
							<td colspan="3" align="left">
								<span style="">{sNumeroComercio}</span>
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
							<td style="width:140px">
								<span>(*)Cantidad Cuotas:</span>
							</td>
							<td colspan="3">
								{iCantidadCuota}
							</td>
						</tr>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">Datos Cupon:</label>
							</td>
						</tr>
						<!--<tr>
							<td>
								<span style="font-size:14px;font-weight:bold;">Limite Credito:</span>
							</td>
							<td colspan="3">
								<div id="div_limite_credito" style="font-size:14px;font-weight:bold;">{fLimiteCredito}</div>
							</td>
						</tr>-->
						<tr>
							<td>
								<span>Importe:</span>
							</td>
							<td colspan="3">
								{fImporte}
							</td>
						</tr>
						<tr>
							<td>
								<span>Nro. Cupon:</span>
							</td>
							<td>
								{sNumeroCupon}
							</td>
							<td>
								<span>Tipo Moneda:</span>
							</td>
							<td>
								{sNombreTipoMoneda}
							</td>
						</tr>
						<tr>
							<td>
								<span>Fecha Cupon:</span>
							</td>
							<td>
								{dFechaConsumo}
							</td>
							<td>
								<span>Fecha Presentacion:</span>
							</td>
							<td>
								{dFechaPresentacion}
							</td>
						</tr>						
						<tr>
							<td>
								<span>Nro. Terminal:</span>
							</td>
							<td colspan="3">
								{sNumeroTerminal}
							</td>
						</tr>
						<tr>
							<td>
								<span>Observaciones:</span>
							</td>
							<td colspan="3">
								{sObservacion}
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
				<td class="SubHead">&nbsp;</td>
			</tr>
			<tr valign="top">
				<td align="center">
						<!--<input type="button" id="cmd_alta" name="cmd_alta" onclick="javascript:darAltaSolicitud();" value="Dar Alta" {MOSTRAR_DAR_ALTA} tabindex="81"/>&nbsp;&nbsp;
						<input type="button" id="cmd_enviar" name="cmd_enviar" onclick="javascript:sendFormSolicitud();" value="Guardar" {MOSTRAR_GUARDAR} tabindex="82"/>&nbsp;&nbsp;
						<input type="button" id="cmd_borrar" name="cmd_borrar" onclick="this.form.reset()" value="Borrar" {MOSTRAR_BORRAR} tabindex="83"/>
						<input type="button" id="cmd_volver" name="cmd_volver" onclick="window.location='{URL_PRINCIPAL}'" value="Volver" tabindex="84"/>-->
				</td>
			</tr>
		</table>
	</td>
	</tr>
	</table>	
</fieldset>

</center>
<script>

	



</script>