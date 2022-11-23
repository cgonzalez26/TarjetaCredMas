<center>

<div style="width:800px;">
	<div id='' style='width:90%;text-align:right;'>
		<!--<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Comercio' border='0' hspace='4' align='absmiddle'>Guardar</a>
		&nbsp;&nbsp;-->
		<!--<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Limite' alt='Nuevo Limite' border='0' hspace='4' align='absmiddle'> Nuevo</a>
			&nbsp;&nbsp;			
		</div>-->
		<a href="Comercios.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='Buscar Limites' alt='Buscar Limites' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>

   <table cellpadding="0" cellspacing="0" width="800" border="0" align="center" class="TablaGeneral">
  
   <tr>
    <td valign="top" style="padding-top:20px">
    
	    <table cellspacing="0" cellpadding="0" width="90%" align="center" border="0" class="TablaGeneral">
			<tbody><tr>
				<td valign="middle" align="center" height="20" class="Titulo">
					COMERCIOS	
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
							<td class="SubHead">
								<span>Nro. Comercio:</span>
							</td>
							<td class="SubHead" colspan="3">
								<span style="font-size:24px;font-weight:bold;font-family:Times New Roman;">{sNumero}</span>
							</td>
						</tr>
		
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5">
								<label id="Solicitudes_plTituloTitular">Datos del Comercio:
								</label>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>Nombre Fantasia:</span>
							</td>
							<td class="SubHead">
								<span>Razon Social:</span>
							</td>								
							<td class="SubHead">
								<span>C.U.I.T.:</span>
							</td>		
							<td class="SubHead">
								<span>Forma Juridica:</span>
							</td>
							<td>
								<span>Inico Actividad:</span>
							</td>								
						</tr>
						
						<tr>
							<td valign="top">
								{sNombreFantasia}
							<td valign="top">
								{sRazonSocial}
							</td>														
							<td class="SubHead">
								{sCUIT}
							</td>
							<td class="SubHead">
								{sFormaJuridica}
							</td>	
							<td>
								{dFechaInicioActividad}
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>Sector:</span>
							</td>
							<td class="SubHead">
								<span>Ingresos Brutos:</span>
							</td>
							<td class="SubHead">
								<span>Domicilio Comercial:</span>
							</td>								
							<td class="SubHead">
								<span>Domicilio Solicitar Comp.:</span>
							</td>		
							<td class="SubHead">
								
							</td>

						</tr>
						<tr>
							<td class="SubHead">
								{sSector}
							</td>	
							<td valign="top">
								{sIngresoBrutoDGR}
							<td valign="top">
								{sDomicilioComercial}
							</td>														
							<td class="SubHead">
								{sDomicilioSolicitarComprobante}
							</td>
							<td>

							</td>
						</tr>						
						
						
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5">
								<label id="Solicitudes_plTituloTitular">Datos del Responsable:
								</label>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span>Nombre:</span>
							</td>
							<td class="SubHead">
								<span>Apellido:</span>
							</td>								
							<td class="SubHead">
								<span>Telefono:</span>
							</td>		
							<td class="SubHead">
								<span>Email:</span>
							</td>
							<td>
								<span>Fax:</span>
							</td>								
						</tr>
						
						<tr>
							<td valign="top">
								{sNombre}
							<td valign="top">
								{sApellido}
							</td>														
							<td class="SubHead">
								{sTelefono}
							</td>
							<td class="SubHead">
								{sMail}
							</td>	
							<td>
								{sFax}
							</td>
						</tr>
						
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5">
								<label> Condiciones del Comercio </label>
							</td>
						</tr>						
						<tr>
							<td class="SubHead">
								Condicion Comercio:
							</td>						
							<td>
								Rubro:
							</td>
							<td>
								SubRubro:
							</td>						
							<td class="SubHead">
								Condicion AFIP:
							</td>
							<td>
								Condicion D.G.R.:
							</td>
						</tr>
						<tr>
							<td valign="top">
									{sNombreCondicionComercio}
							</td>						
							<td valign="top">
									{sNombreRubro}
							</td>
							<td valign="top">
									{sNombreSubRubro}
							</td>
							<td valign="top">
									{sNombreCondicionAFIP}
							</td>								
							<td valign="top">
									{sNombreCondicionDGR}
							</td>							
													

						</tr>
						<tr>
							<td class="SubHead">
								Retenciones I.V.A.:
							</td>
							<td>
								Retenciones Ganancias:
							</td>

							<td class="SubHead">
								Retenciones D.G.R.:
							</td>
							<td class="SubHead">
								
							</td>
							<td class="SubHead">
								<!--Tipo Comercio:-->
							</td>
						</tr>
						<tr>
							<td valign="top">
									{sNombreRetencionGanancia}
							</td>
							<td valign="top">
									{sNombreRetencionIVA}
							</td>
	
							<td valign="top">
									{sNombreRetencionDGR}
							</td>
							<td valign="top">

							</td>
							<td valign="top">
									<!--{sNombreTipoComercio}-->
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

					</td>
				</tr>
				</table>
		

</center>