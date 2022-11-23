<body>
<center>
<div id="BODY">
	<div id='' style='width:100%;text-align:right;margin-right:10px;margin-top:10px;'>
			<img src='{IMAGES_DIR}/print.gif' title='Imprimir Contrato' alt='Imprimir Contrato' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:imprimirContrato();' style='text-decoration:none;font-weight:bold'>Imprimir Contrato</a>
			&nbsp;
			<img src='{IMAGES_DIR}/print.gif' title='Imprimir Solicitud' alt='Imprimir Solicitud' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:imprimir();' style='text-decoration:none;font-weight:bold'>Imprimir</a>
			&nbsp;
			<img src='{IMAGES_DIR}/back.png' title='Volver' alt='Volver' border='0' hspace='4' align='absmiddle'> 
			<a href="{URL_BACK}" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>

   <form action='solicitud.php' method='POST' name='formSolicitud' id='formSolicitud' style='display:inline;'>  
   <input type='hidden' name='Confirmar' id="Confirmar" value='1' />
   <input type='hidden' name='idSolicitud' id="idSolicitud" value='{ID_SOLICITUD}' />
   <div id="divResumen">
   <table cellpadding="0" cellspacing="0" width="800" border="0" align="center" class="TablaGeneral">
  
   <tr>
    <td valign="top" style="padding-top:30px">
	    <table cellspacing="0" cellpadding="0" width="95%" align="center" border="0">
			<tbody><tr>
				<td valign="middle" align="center" height="10" class="Titulo">
					SOLICITUD DE TITULAR</td>
			</tr>
			<tr>
				<td align="left" bgcolor="#ffffff" style="height:20px;color:red;font-weight:bold">&nbsp;</td>
			</tr>
			<tr><td>Solicitud de Emisi&oacute;n de Tarjeta N&deg;: {NUMERO_SOLICITUD}</td></tr>
			<tr>
				<td align="left" bgcolor="#ffffff">
					<table id="TablaTitular" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
						<tbody>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5" style="background:#DEDEDE;">
								<label id="Solicitudes_plCuenta">Sucursal:&nbsp;{SUCURSAL}&nbsp;&nbsp;&nbsp;Oficina:&nbsp;{OFICINA}&nbsp;&nbsp;&nbsp;Empleado:&nbsp;{EMPLEADO}
								</label>
							</td>
						</tr>						
						<tr>
							<td><span id="Solicitudes_plFechaPresentacion_lblLabel">Fecha de Presentaci&oacute;n:</span></td>
							<td><span id="Solicitudes_plFechaSolicitud_lblLabel">Fecha de Solicitud:</span></td>
							<td><span id="Solicitudes_plBin_lblLabel">BIN:</span></td>
							<td>Canal:</td>
							<td><span id="Solicitudes_plEmpleado_lblLabel">Promotor:</span></td>	
						</tr>
						<tr>
							<td valign="top" class="negrita">{FECHA_PRESENTACION}</td>
							<td valign="top" class="negrita">{FECHA_SOLICITUD}</td>	
							<td valign="top" class="negrita">{BIN}</td>	
							<td valign="top" class="negrita">{CANAL}</td>																																		
							<td class="negrita">{PROMOTOR}</td>
						</tr>	
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5" style="background:#DEDEDE;border-bottom:1px solid #000">
								Datos del Titular:
							</td>
						</tr>
						<tr>
							<td><span id="Solicitudes_plApellido_lblLabel">Apellidos(de soltero/a):</span></td>
							<td><span id="Solicitudes_plNombre_lblLabel">Nombre:</span></td>								
							<td><span id="Solicitudes_plEstadoCivil_lblLabel">Estado Civil:</span></td>		
							<td><span id="Solicitudes_plFechaNac_lblLabel">Nacionalidad:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">Razon Social:</span></td>								
						</tr>
						<tr>
							<td valign="top" class="negrita">{APELLIDO}</td>
							<td valign="top" class="negrita">{NOMBRE}</td>														
							<td class="negrita">{ESTADO_CIVIL}</td>
							<td class="negrita">{NACIONALIDAD}</td>	
							<td class="negrita">{RAZON_SOCIAL}</td>
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
						<tr>
							<td><span id="Solicitudes_plFechaNac_lblLabel">Apellido C&oacute;nyuge:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">Nombre C&oacute;nyuge:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">Tipo doc. C&oacute;nyuge:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">N&uacute;mero doc. C&oacute;nyuge:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">Hijos:</span></td>
						</tr>
						<tr>
							<td class="negrita">{APELLIDO_CONYUGE}</td>
							<td class="negrita">{NOMBRE_CONYUGE}</td>						
							<td valign="top" class="negrita">{TIPO_DOCUMENTO_CONYUGE}</td>
							<td valign="top" class="negrita">{DOCUMENTO_CONYUGE}</td>
							<td class="negrita">{HIJOS}</td>
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
								<td class="subTitulo" align="left" height="30" colspan="5" style="background:#DEDEDE;border-bottom:1px solid #000">
									  <span id="Solicitudes_plTituloDomicilio">Datos del Domicilio del Titular:</span>
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
					<td>
						<table id="TablaDomicilio" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
							<tr>
								<td class="subTitulo" align="left" height="30" colspan="5" style="background:#DEDEDE;border-bottom:1px solid #000">
									  <span id="Solicitudes_plTituloDomicilio">Enviar Resumen:</span>
								</td>
							</tr>
							<tr>
								<td><span id="Solicitudes_plProvincia_lblLabel">Provincia:</span></td>
								<td><span id="Solicitudes_plLocalidad_lblLabel">Localidad:</span></td>
								<td><span id="Solicitudes_plCPostal_lblLabel">C.P.:</span></td>								
							</tr>
							<tr>
								<td align="left" class="negrita">{PROVINCIA_RESUMEN}</td>	
								<td align="left" class="negrita">{LOCALIDAD_RESUMEN}</td>
								<td align="left" class="negrita">{CP_RESUMEN}</td>								
							</tr>							
							<tr>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Calle:</span></td>
								<td><span id="Solicitudes_plNro_lblLabel">Nro.:</span></td>								
								<td><span id="Solicitudes_plDomicilio_lblLabel">Block:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Piso:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Departamento:</span></td>								
							</tr>
							<tr>
								<td align="left" class="negrita">{CALLE_RESUMEN}</td>
								<td align="left" class="negrita">{NUMERO_CALLE_RESUMEN}</td>												
								<td align="left" class="negrita">{BLOCK_RESUMEN}</td>
								<td align="left" class="negrita">{PISO_RESUMEN}</td>
								<td align="left" class="negrita">{DPTO_RESUMEN}</td>	
							</tr>
							<tr>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Entre Calles:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Barrio:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Manzana:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Lote:</span></td>
							</tr>
							<tr>
								<td align="left" class="negrita">{ENTRE_CALLE_RESUMEN}</td>				
								<td align="left" class="negrita">{BARRIO_RESUMEN}</td>
								<td align="left" class="negrita">{MANZANA_RESUMEN}</td>
								<td align="left" class="negrita">{LOTE_RESUMEN}</td>	
							</tr>	
						</table>	
					</td>
				</tr>
				<tr>
					<td bgcolor="#ffffff">
						<table id="TablaCondicion" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
							<tr>
								<td class="subTitulo" align="left" height="30" colspan="5" style="background:#DEDEDE;border-bottom:1px solid #000">
								<span id="Solicitudes_plTituloIngresos">Datos Laborales:</span>
								</td>
							</tr>
							<tr>
								<td><span id="Solicitudes_plRazonSocial_lblLabel">Raz&oacute;n social:</span></td>
								<td><span id="Solicitudes_plCuitEmpleador_lblLabel">CUIT. Empleador:</span></td>								
								<td><span id="Solicitudes_plCondAFIP_lblLabel">Condici&oacute;n AFIP:</span></td>
								<td><span id="Solicitudes_plCondAFIP_lblLabel">Condici&oacute;n Laboral:</span></td>
								<td><span id="Solicitudes_plReparticion_lblLabel">Repartici&oacute;n:</span></td>
							</tr>	
								<tr>
								<td align="left" class="negrita">{RAZON_SOCIAL_LAB}</td>
								<td align="left" class="negrita">{CUIT_EMPLEADOR}</td>
								<td align="left" class="negrita">{CONDICION_AFIP_LAB}</td>
								<td align="left" class="negrita">{CONDICION_LAB}</td>	
								<td align="left" class="negrita">{REPARTICION_LAB}</td>
							</tr>		
							<tr>
								<td><span id="Solicitudes_plActividad_lblLabel">Actividad:</span></td>								
								<td><span id="Solicitudes_plCalle_lblLabel">Calle:</span></td>
								<td><span id="Solicitudes_plNro_lblLabel">Nro.:</span></td>
								<td><span id="Solicitudes_plBlock">Block:</span></td>
								<td>
									<table id="TablaCondicion" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
									<tr>
										<td><span id="Solicitudes_plPiso_lblLabel">Piso:</span></td>
										<td><span id="Solicitudes_plDpto_lblLabel">Oficina:</span></td>
									</tr>
									</table>
								</td>
							</tr>	
							<tr>
								<td align="left" class="negrita">{ACTIVIDAD_LAB}</td>
								<td align="left" class="negrita">{CALLE_LAB}</td>
								<td align="left" class="negrita">{NUMERO_CALLE_LAB}</td>
								<td align="left" class="negrita">{BLOCK_LAB}</td>	
								<td>
									<table id="TablaCondicion" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
									<tr>	
									<td align="left" class="negrita">{PISO_LAB}</td>
									<td align="left" class="negrita">{OFICINA_LAB}</td>
									</tr>
									</table>
								</td>		
							</tr>
							<tr>
								<td><span id="Solicitudes_plBarrio">Barrio:</span></td>
								<td><span id="Solicitudes_plManzana_lblLabel">Manzana:</span></td>
								<td><span id="Solicitudes_plProvincia_lblLabel">Provincia:</span></td>
								<td><span id="Solicitudes_plLocalidad_lblLabel">Localidad:</span></td>
								<td><span id="Solicitudes_plCP">CP.:</span></td>
							</tr>	
								<tr>
								<td align="left" class="negrita">{BARRIO_LAB}</td>	
								<td align="left" class="negrita">{MANZANA_LAB}</td>								
								<td align="left" class="negrita">{PROVINCIA_LAB}</td>	
								<td align="left" class="negrita">{LOCALIDAD_LAB}</td>	
								<td align="left" class="negrita">{CP_LAB}</td>	
							</tr>										
							<tr>
								<td><span id="Solicitudes_plTelefonoLaboral1_lblLabel">Telefono laboral 1:</span></td>
								<td><span id="Solicitudes_plInterno_lblLabel">Interno 1:</span></td>
								<td><span id="Solicitudes_plFechaIngreso">Fecha Ingreso 1:</span></td>
								<td><span id="Solicitudes_plCargo1_lblLabel">Cargo 1:</span></td>
								<td><span id="Solicitudes_plIngresoNetoMensual_lblLabel">Ingreso neto mensual 1:</span></td>
							</tr>	
								<tr>
								<td align="left" class="negrita">{TEL1}</td>
								<td align="left" class="negrita">{INTERNO1}</td>
								<td align="left" class="negrita">{FECHA_INGRESO1}</td>
								<td align="left" class="negrita">{CARGO1}</td>
								<td align="left" class="negrita">{ING_MESUAL1}</td>
							</tr>
							<tr>
								<td><span id="Solicitudes_plTelefonoLaboral2">Telefono laboral 2:</span></td>
								<td><span id="Solicitudes_plInterno2_lblLabel">Interno 2:</span></td>
								<td><span id="Solicitudes_plFechaIngreso2_lblLabel">Fecha ingreso 2:</span></td>
								<td><span id="Solicitudes_plCargo2">Cargo 2:</span></td>
								<td><span id="Solicitudes_plIngresoNetoMensual_lblLabel">Ingreso neto mensual 2:</span></td>
							</tr>	
								<tr>
								<td align="left" class="negrita">{TEL2}</td>
								<td align="left" class="negrita">{INTERNO2}</td>
								<td align="left" class="negrita">{FECHA_INGRESO2}</td>
								<td align="left" class="negrita">{CARGO2}</td>
								<td align="left" class="negrita">{ING_MESUAL2}</td>
							</tr>		
							</table>
					
					</td>
			</tr>
			<tr>
				<td bgcolor="#ffffff">
					<table id="TablaCondicion" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5" style="background:#DEDEDE;border-bottom:1px solid #000">
							<span id="dnn_ctr608_Solicitudes_plTituloIngresos_lblLabel">Otros Datos:</span>
							</td>
						</tr>
						<tr>
							<td width="120"></td>
							<td width="180"><span id="lblTelefonoFijo">Tel. fijo:</span></td>
							<td width="180"><span id="lblCelular">Celular:</span></td>
							<td width="180"><span id="lblEmpresaCelular">Empresas Celular:</span></td>	
							<td><span id="lblMail">E-mail:</span></td>	
						</tr>
						<tr>
							<td class="negrita">PARTICULAR</td>
							<td class="negrita">{TEL_PART_FIJO}</td>
							<td class="negrita">{TEL_PART_MOVIL}</td>
							<td class="negrita">{EMPRESA_CELULAR}</td>
							<td class="negrita">{MAIL}</td>							
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td width="200">
								<span id="dnn_ctr608_Solicitudes_plCondicionLaboral_lblLabel">Tel. contacto:</span>
							</td>
							<td width="200">
								<span id="lblEmpresa">Referencia Contacto:</span>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>						
						<tr>
							<td>REFERENCIA</td>
							<td width="200" class="negrita">{TEL_CONTACTO}</td>
							<td width="200" class="negrita">{REF_CONTACTO}</td>
							<td></td>
							<td></td>
						</tr>
					</table>
				</td>						
			</tr>	
			<tr>
				<td class="SubHeadRed" align="left" height="20">&nbsp;</td>
			</tr>			
			<!--<tr valign="top">
				<td align="center">
					<input type="button" id="cmd_volver" name="cmd_volver" onclick="window.location='{URL_BACK}'" value="Volver"/>
				</td>
			</tr>
			<tr><td style="height:20px"></td></tr>-->
		</tbody>
	</table>	
    
    </td>
  </tr>
  </table>
  </div>
  <div id="divFooterSolicitud" style="display:none">
  	  <table id="tablaFooter" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
  	  <tr>
  	      <td width="10%">&nbsp;</td><td width="30%">.................................................................................</td><td width="20%">&nbsp;</td>
  	      <td width="30%">.................................................................................</td><td width="10%">&nbsp;</td>
  	   </tr>
  	  <tr>
  		  <td width="10%">&nbsp;</td><td width="30%" align="center">Firma</td><td width="20%"></td><td width="30%" align="center">Aclaracion</td><td width="10%">&nbsp;</td>
  	  </tr>
  	  </table>
  </div>	
  </form>
    
  <div id="divSolicitudContrato" style="display:none;">
      {SOLICITUD_CONTRATO}
  </div>
  <script>
  function imprimir(){
  	 var tabla = document.getElementById('divResumen').innerHTML; 
  	 var tablaFooter = document.getElementById('divFooterSolicitud').innerHTML;
  	 document.getElementById('impresiones').innerHTML = tabla+tablaFooter;
  	 
  	 window.print();
  }
  
  function imprimirContrato(){
  	 var tabla = document.getElementById('divSolicitudContrato').innerHTML; 
  	 document.getElementById('impresiones').innerHTML = tabla;// +tablaFooter;
  	 
  	 window.print();
  }
  </script>