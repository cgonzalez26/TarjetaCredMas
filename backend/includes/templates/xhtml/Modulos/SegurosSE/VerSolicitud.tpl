<style>
table#TablaGeneral{
	font-family:Tahoma;
	font-size:12px;
	/*background:#FFF url(../includes/images/bg_lines.gif) repeat-x;*/
}

/*
table.TablaGeneral td.borde
{
	border: 1px solid #CCC;
}*/

/*Estilo para Tabla en General*/
table.TablaGeneral{
	font-family:Tahoma;
	font-size:12px;
	/*background:#FFF url(../includes/images/bg_lines.gif) repeat-x;*/
}

table.TablaGeneral tr.filaPrincipal th.borde{
	font-family:Tahoma;
	font-size:12px;	
	background:#CCC;
	border: 1px solid #CCC;
	/*background:#FFF url(../includes/images/bg_lines.gif) repeat-x;*/
}

fieldset .TablaGeneral{
	font-family:Tahoma;
	font-size:12px;
	/*background:#FFF url(../includes/images/bg_lines.gif) repeat-x;*/
}

fieldset .TablaGeneral th{
	font-family:Tahoma;
	font-size:12px;
	text-align:right;
	/*background:#FFF url(../includes/images/bg_lines.gif) repeat-x;*/
}

fieldset .TablaGeneral td span{
	font-family:Tahoma;
	font-size:12px;
	text-align:left;
	padding-left:10px;
}


table .TablaGeneral td div#sCodigo{
	text-align:left;
	font-size:18px;
	font-weight:bold;
}
</style>
<div id="divResumen">
   <table cellpadding="0" cellspacing="0" width="800" border="0" align="center" class="TablaGeneral">
  
   <tr>
    <td valign="top" style="padding-top:30px">
	    <table cellspacing="0" cellpadding="0" width="95%" align="center" border="0" class="TablaGeneral">
			<tbody>
			<tr><td>Solicitud de Emisi&oacute;n de Tarjeta N&deg;: {NUMERO_SOLICITUD}</td></tr>
			<tr><td style="height:10px"></td></tr>
			<tr>
				<td align="left" bgcolor="#ffffff" style="height:400px">
				{TEXTO_CONTRATO}
				</td>
			</tr>
			<tr>
				<td align="left" bgcolor="#ffffff">
					<table id="TablaTitular" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
						<tbody>														
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5" style="background:#DEDEDE">
								<strong>DATOS PERSONALES DEL TITULAR:</strong>
							</td>
						</tr>
						<tr>
							<td><span id="Solicitudes_plApellido_lblLabel">Apellidos:</span></td>
							<td><span id="Solicitudes_plNombre_lblLabel">Nombre:</span></td>								
							<td><span id="Solicitudes_plEstadoCivil_lblLabel">Estado Civil:</span></td>		
							<td><span id="Solicitudes_plFechaNac_lblLabel">Nacionalidad:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel" {MOSTRAR_RAZON_SOCIAL}>Razon Social:</span></td>								
						</tr>
						<tr>
							<td valign="top" class="negrita">{APELLIDO}</td>
							<td valign="top" class="negrita">{NOMBRE}</td>														
							<td class="negrita">{ESTADO_CIVIL}</td>
							<td class="negrita">{NACIONALIDAD}</td>	
							<td class="negrita" {MOSTRAR_RAZON_SOCIAL}>{RAZON_SOCIAL}</td>
							</td>
						</tr>
						<tr>
							<td><span id="dnn_ctr608_Solicitudes_plTipoDocumento_lblLabel">Tipo de Documento:</span></td>
							<td><span id="dnn_ctr608_Solicitudes_plNroDocumento_lblLabel">N&uacute;mero de Documento:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">CUIT:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">Fecha de Nacimiento:</span></td>
							<td><span id="Solicitudes_Sexo_lblLabel">Sexo:</span></td>		
						</tr>
						<tr>
							<td valign="top" class="negrita">{TIPO_DOCUMENTO}</td>
							<td valign="top" class="negrita">{DOCUMENTO}</td>
							<td class="negrita">{CUIT}</td>
							<td class="negrita">{FECHA_NACIMIENTO}</td>
							<td valign="top" class="negrita">{SEXO}</td>
						</tr>						
						</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left">
					</td>
				</tr>
				<tr>
					<td bgcolor="#ffffff">
						<table id="TablaDomicilio" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
							<tr>
								<td class="subTitulo" align="left" height="30" colspan="5" style="background:#DEDEDE">
									  <span id="Solicitudes_plTituloDomicilio"><strong>DATOS DEL DOMICILIO DEL TITULAR:</strong></span>
								</td>
							</tr>
							<tr>
								<td><span id="Solicitudes_plProvincia_lblLabel">Provincia:</span></td>
								<td><span id="Solicitudes_plLocalidad_lblLabel">Localidad:</span></td>
								<td><span id="Solicitudes_plCPostal_lblLabel">C.P.:</span></td>
								
							</tr>
							<tr>
								<td align="left" class="negrita">{PROVINCIA}</td>	
								<td align="left" class="negrita">{LOCALIDAD}</td>
								<td align="left" class="negrita">{CODIGO_POSTAL}</td>
								
							</tr>
							<tr>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Calle:</span></td>
								<td><span id="Solicitudes_plNro_lblLabel">Nro.:</span></td>								
								<td><span id="Solicitudes_plDomicilio_lblLabel">Block:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Piso:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Departamento:</span></td>								
							</tr>
							<tr>
								<td align="left" class="negrita">{CALLE}</td>
								<td align="left" class="negrita">{NUMERO_CALLE}</td>												
								<td align="left" class="negrita">{BLOCK}</td>
								<td align="left" class="negrita">{PISO}</td>
								<td align="left" class="negrita">{DEPARTAMENTO}</td>	
							</tr>
							<tr>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Entre Calles:</span></td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Barrio:</span></td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Manzana:</span></td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Lote:</span></td>
							</tr>
							<tr>
								<td align="left" class="negrita">{ENTRE_CALLE}</td>				
								<td align="left" class="negrita">{BARRIO}</td>
								<td align="left" class="negrita">{MANZANA}</td>
								<td align="left" class="negrita">{LOTE}</td>	
							</tr>												
						</table>
					</td>
				</tr>
				
				<tr>
				<td bgcolor="#ffffff">
					<table id="TablaCondicion" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5" style="background:#DEDEDE">
							<span id="dnn_ctr608_Solicitudes_plTituloIngresos_lblLabel"><strong>OTROS DATOS:</strong></span>
							</td>
						</tr>
						<tr>
							<td width="180"><span id="lblTelefonoFijo">Tel. fijo:</span></td>
							<td width="180"><span id="lblCelular">Celular:</span></td>
							<td width="180"><span id="lblEmpresaCelular">Empresas Celular:</span></td>	
						</tr>
						<tr>
							<td class="negrita">{TEL_PART_FIJO}</td>
							<td class="negrita">{TEL_PART_MOVIL}</td>
							<td class="negrita">{EMPRESA_CELULAR}</td>
						</tr>						
					</table>
				</td>						
				</tr>	
				<tr><td class="SubHeadRed" align="left" height="20">&nbsp;</td></tr>
				<tr {MOSTRAR_ENVIO_DOMICILIO}>
					<td colspan="2" style="padding-left:5px">El TITULAR solicita le envien los resumenes de cuenta a Domicilio.</td>
				</tr>
				<tr {MOSTRAR_ENVIO_MAIL}>
					<td colspan="2" style="padding-left:5px">El TITULAR solicita le envien los resumenes de cuenta al siguiente E-mail:&nbsp;<span id="mailTitular">{MAIL}</span></td>
				</tr>							
				<tr><td class="SubHeadRed" align="left" height="20">&nbsp;</td></tr>
				<tr><td style="padding-left:5px">{LUGAR_FECHA_EMPLEADO}</td></tr>
				<tr><td class="SubHeadRed" align="left" height="20">&nbsp;</td></tr>
				<tr>
					<td>
					<table id="tablaFooter" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
				  	  <tr>
				  	      <td width="40%">FIRMA TITULAR: ...............................................</td>
				  	      <td width="40%">NOMBRE Y APELLIDO: .................................................</td>
				  	      <td width="20%">DNI: ..............................</td>
				  	   </tr>
				  	  </table>
					</td>
				</tr>
			</tbody>
		</table>	
    
    </td>
  </tr>
  </table>
  </div>
  <div id="divFooterSolicitud" >
  	  
  </div>	