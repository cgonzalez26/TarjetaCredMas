<center>

<div style="width:600px;">
	<div id='' style='width:600px;text-align:right;'>
		&nbsp;&nbsp;			
		<!--<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Limite' alt='Nuevo Limite' border='0' hspace='4' align='absmiddle'> Nuevo</a>
			&nbsp;&nbsp;			
		</div>-->
		<a href="Planes.php?_i={_ic}" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='regresar' alt='regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>

<form id="formPlanes" action="AdminPlanes.php" method="POST">	
	<input type="hidden" name="_op" id="_op" value="{_op}" />	
	<input type="hidden" name="_i" id="_i" value="{_i}" />	
	<input type="hidden" name="_ic" id="_ic" value="{_ic}" />	
   <table cellpadding="0" cellspacing="0" width="700" border="0" align="center" class="TablaGeneral">
  
   <tr>
    <td valign="top" style="padding-top:20px">
    
	    <table cellspacing="0" cellpadding="0" width="600" align="center" border="0" class="TablaGeneral">
			<tbody><tr>
				<td valign="middle" align="center" height="20" class="Titulo">
					PLANES	
				</td>
			</tr>
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
							<td class="subTitulo" align="left" height="30" colspan="5">
								<label id="">Datos del Plan:
								</label>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>Nro. Comercio :</span>
							</td>
							<td class="SubHead">
								<span>Comercio:</span>
							</td>
						</tr>
						
						<tr>
							<td valign="top">								
								{sNumeroComercio}								
							<td valign="top">
								{sNombreComercio}
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>Tipo Plan :</span>
							</td>
							<td class="SubHead">
								<span>Nombre:</span>
							</td>
						</tr>
						
						<tr>
							<td valign="top">								
								{sNombreTipoPlan}								
							<td valign="top">
								{sNombre}
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>Vigencia Desde:</span>
							</td>
							<td class="SubHead">
								<span>Vigencia Hasta:</span>
							</td>							
						</tr>
						<tr>
							<td class="SubHead">
								{dVigenciaDesde}
							</td>
							<td class="SubHead">
								{dVigenciaHasta}
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>Dia Cierre:</span>
							</td>		
							<td class="SubHead">
								<span>Dia Corrido Pago:</span>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								{iDiaCierre}
							</td>
							<td class="SubHead">
								{iDiaCorridoPago}
							</td>
						</tr>
						
						<tr>
							<td class="SubHead">
								<span>Arancel:</span>
							</td>
							<td class="SubHead">
								<span>Costo Financiero:</span>
							</td>							
						</tr>
						<tr>
							<td class="SubHead">
								{fArancel}
							</td>
							<td class="SubHead">
								{fCostoFinanciero}
							</td>
						</tr>

						<tr>
							<td class="SubHead">
								<span>Cant. Cuotas:</span>
							</td>
							<td class="SubHead">
								<span>Interes Usuario:</span>
							</td>							
						</tr>
						<tr>
							<td class="SubHead">
								{iCantidadCuotas}
							</td>
							<td class="SubHead">
								{fInteresUsuario}
							</td>
						</tr>

						</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td class="SubHeadRed" align="left" height="30">&nbsp;
						</td>
				</tr>
				<tr valign="top">
					<td class="SubHead">
						
					</td>
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
		
	</form>
</center>
<script type="text/javascript">
	
	

</script>