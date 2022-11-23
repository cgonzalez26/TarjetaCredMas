   <div id="divResumen">
   <table cellpadding="0" cellspacing="0" width="800" border="0" align="center" class="TablaGeneral">
  
   <tr>
    <td valign="top" style="padding-top:30px">
	    <table cellspacing="0" cellpadding="0" width="95%" align="center" border="0" style='font-family:Tahoma;'>
			<tbody><tr>
				<td valign="middle" align="center" height="10" class="Titulo">
					SOLICITUD DE TITULAR</td>
			</tr>
			<tr>
				<td align="left" bgcolor="#ffffff" style="height:20px;color:red;font-weight:bold">&nbsp;</td>
			</tr>
			<tr><td>Solicitud de Emisi&oacute;n de Tarjeta N&deg;: {sNumero}</td></tr>
			<tr>
				<td align="left" bgcolor="#ffffff">
					<table id="TablaTitular" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
						<tbody>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5" style="background:#DEDEDE;">
								<label id="Solicitudes_plCuenta">
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
							<td valign="top" class="negrita">{dFechaPresentacion}</td>
							<td valign="top" class="negrita">{dFechaSolicitud}</td>	
							<td valign="top" class="negrita">{idBIN}</td>	
							<td valign="top" class="negrita">{sCanal}</td>																																		
							<td class="negrita">{sPromotor}</td>
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
							<td valign="top" class="negrita">{sApellido}</td>
							<td valign="top" class="negrita">{sNombre}</td>														
							<td class="negrita">{sEstadoCivil}</td>
							<td class="negrita">{sNacionalidad}</td>	
							<td class="negrita">{sRazonSocial}</td>
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
							<td valign="top" class="negrita">{sTipoDocumento}</td>
							<td valign="top" class="negrita">{sDocumento}</td>
							<td class="negrita">{sCUIT}</td>
							<td class="negrita">{dFechaNacimiento}</td>
							<td valign="top" class="negrita">{sSexo}</td>
						</tr>
						<tr>
							<td><span id="Solicitudes_plFechaNac_lblLabel">Apellido C&oacute;nyuge:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">Nombre C&oacute;nyuge:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">Tipo doc. C&oacute;nyuge:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">N&uacute;mero doc. C&oacute;nyuge:</span></td>
							<td><span id="Solicitudes_plFechaNac_lblLabel">Hijos:</span></td>
						</tr>
						<tr>
							<td class="negrita">{sApellidoConyuge}</td>
							<td class="negrita">{sNombreConyuge}</td>						
							<td valign="top" class="negrita">{sTipoDocumentoConyuge}</td>
							<td valign="top" class="negrita">{sDocumentoConyuge}</td>
							<td class="negrita">{iHijos}</td>
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
								<td align="left" class="negrita">{sProvincias}</td>	
								<td align="left" class="negrita">{sLocalidad}</td>
								<td align="left" class="negrita">{sCodigoPostal}</td>
								
							</tr>
							<tr>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Calle:</span></td>
								<td><span id="Solicitudes_plNro_lblLabel">Nro.:</span></td>								
								<td><span id="Solicitudes_plDomicilio_lblLabel">Block:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Piso:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Departamento:</span></td>								
							</tr>
							<tr>
								<td align="left" class="negrita">{sCalle}</td>
								<td align="left" class="negrita">{sNumeroCalle}</td>												
								<td align="left" class="negrita">{sBlock}</td>
								<td align="left" class="negrita">{sPiso}</td>
								<td align="left" class="negrita">{sDepartamento}</td>	
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
								<td align="left" class="negrita">{sEntreCalle}</td>				
								<td align="left" class="negrita">{sBarrio}</td>
								<td align="left" class="negrita">{sManzana}</td>
								<td align="left" class="negrita">{sLote}</td>	
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
								<td align="left" class="negrita">{sProvinciaResumen}</td>	
								<td align="left" class="negrita">{sLocalidadResumen}</td>
								<td align="left" class="negrita">{sCodigoPostalResumen}</td>								
							</tr>							
							<tr>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Calle:</span></td>
								<td><span id="Solicitudes_plNro_lblLabel">Nro.:</span></td>								
								<td><span id="Solicitudes_plDomicilio_lblLabel">Block:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Piso:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Departamento:</span></td>								
							</tr>
							<tr>
								<td align="left" class="negrita">{sCalleResumen}</td>
								<td align="left" class="negrita">{sNumeroCalleResumen}</td>												
								<td align="left" class="negrita">{sBlockResumen}</td>
								<td align="left" class="negrita">{sPisoResumen}</td>
								<td align="left" class="negrita">{sDepartamentoResumen}</td>	
							</tr>
							<tr>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Entre Calles:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Barrio:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Manzana:</span></td>
								<td><span id="Solicitudes_plDomicilio_lblLabel">Lote:</span></td>
							</tr>
							<tr>
								<td align="left" class="negrita">{sEntreCalleResumen}</td>				
								<td align="left" class="negrita">{sBarrioResumen}</td>
								<td align="left" class="negrita">{sManzanaResumen}</td>
								<td align="left" class="negrita">{sLoteResumen}</td>	
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
								<td align="left" class="negrita">{sRazonSocialLab}</td>
								<td align="left" class="negrita">{sCUITEmpleador}</td>
								<td align="left" class="negrita">{sCondicionAFIP}</td>
								<td align="left" class="negrita">{sCondicionLaboral}</td>	
								<td align="left" class="negrita">{sReparticion}</td>
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
								<td align="left" class="negrita">{sActividad}</td>
								<td align="left" class="negrita">{sCalleLab}</td>
								<td align="left" class="negrita">{sNumeroCalleLab}</td>
								<td align="left" class="negrita">{sBlockLab}</td>	
								<td>
									<table id="TablaCondicion" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
									<tr>	
									<td align="left" class="negrita">{sPisoLab}</td>
									<td align="left" class="negrita">{sOficinaLab}</td>
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
								<td align="left" class="negrita">{sBarrioLab}</td>	
								<td align="left" class="negrita">{sManzanaLab}</td>								
								<td align="left" class="negrita">{sLocalidadLaboral}</td>	
								<td align="left" class="negrita">{sLocalidadLaboral}</td>	
								<td align="left" class="negrita">{sCodigoPostalLab}</td>	
							</tr>										
							<tr>
								<td><span id="Solicitudes_plTelefonoLaboral1_lblLabel">Telefono laboral 1:</span></td>
								<td><span id="Solicitudes_plInterno_lblLabel">Interno 1:</span></td>
								<td><span id="Solicitudes_plFechaIngreso">Fecha Ingreso 1:</span></td>
								<td><span id="Solicitudes_plCargo1_lblLabel">Cargo 1:</span></td>
								<td><span id="Solicitudes_plIngresoNetoMensual_lblLabel">Ingreso neto mensual 1:</span></td>
							</tr>	
								<tr>
								<td align="left" class="negrita">{sTelefonoLaboral1}</td>
								<td align="left" class="negrita">{sInterno1}</td>
								<td align="left" class="negrita">{dFechaIngreso1}</td>
								<td align="left" class="negrita">{sCargo1}</td>
								<td align="left" class="negrita">{fIngresoNetoMensual1}</td>
							</tr>
							<tr>
								<td><span id="Solicitudes_plTelefonoLaboral2">Telefono laboral 2:</span></td>
								<td><span id="Solicitudes_plInterno2_lblLabel">Interno 2:</span></td>
								<td><span id="Solicitudes_plFechaIngreso2_lblLabel">Fecha ingreso 2:</span></td>
								<td><span id="Solicitudes_plCargo2">Cargo 2:</span></td>
								<td><span id="Solicitudes_plIngresoNetoMensual_lblLabel">Ingreso neto mensual 2:</span></td>
							</tr>	
								<tr>
								<td align="left" class="negrita">{sTelefonoLaboral2}</td>
								<td align="left" class="negrita">{sInterno2}</td>
								<td align="left" class="negrita">{dFechaIngreso2}</td>
								<td align="left" class="negrita">{sCargo2}</td>
								<td align="left" class="negrita">{fIngresoNetoMensual2}</td>
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
							<td class="negrita">{sTelefonoParticularFijo}</td>
							<td class="negrita">{sTelefonoParticularCelular}</td>
							<td class="negrita">{sEmpresaCelular}</td>
							<td class="negrita">{sMail}</td>							
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
							<td width="200" class="negrita">{sTelefonoContacto}</td>
							<td width="200" class="negrita">{sReferenciaContacto}</td>
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