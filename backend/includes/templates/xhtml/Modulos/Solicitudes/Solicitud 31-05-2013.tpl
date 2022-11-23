<body style="background-color:#FFFFFF">
<center>
	
    <!--<div id='' style='width:80%;text-align:right;margin-right:10px;'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Solicitud' border='0' hspace='4' align='absmiddle'> 
		<a href='javascript:sendFormSolicitud();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>Guardar </a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Grupo' alt='Nuevo Solicitud' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<img src='{IMAGES_DIR}/back.png' title='Buscar Grupo' alt='Buscar Solicitud' border='0' hspace='4' align='absmiddle'> 
		<a href="Solicitudes.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>-->
	
   <form action='solicitud.php' method='POST' id='formSolicitud' name='formSolicitud'>  
   <input type='hidden' name='Confirmar' id="Confirmar" value='1' />
   <input type='hidden' name='idSolicitud' id="idSolicitud" value='{ID_SOLICITUD}' />
   <input type='hidden' name='hdnIdBIN' id="hdnIdBIN" value='{ID_BIN}' />
   <input type='hidden' name='hdnDocumento' id="hdnDocumento" value='{DOCUMENTO}' />
   <input type='hidden' name='hdnidTipoDocumento' id="hdnidTipoDocumento" value='{ID_TIPODOC}' />
   <input type='hidden' name='hdnUrlBack' id="hdnUrlBack" value='{URL_BACK}' />   
   <input type='hidden' name='hdnExisteDocumento' id="hdnExisteDocumento" value='0' />   
   <input type='hidden' name='hdnIdCliente' id="hdnIdCliente" value='{ID_CLIENTE}' />   
   
   <table id="tablaSolicitud" cellpadding="0" cellspacing="0" width="800" border="0" align="center" class="TablaGeneral" {DISPLAY_FORMULARIO_SOLICITUD}>
  
   <tr>
    <td valign="top" style="padding-top:20px">
    
	    <table cellspacing="0" cellpadding="0" width="90%" align="center" border="0" class="TablaGeneral">
			<tbody><tr>
				<td valign="middle" align="center" height="20" class="Titulo">
					SOLICITUD DE TITULAR</td>
			</tr>
			<tr>
				<td align="left" bgcolor="#ffffff" style="height:20px;color:red;font-weight:bold">
				<? echo $msje; ?>
				</td>
			</tr>
			<tr>
				<td align="left">
				<span style="display:none"><input type="radio" id="rdbTipoPersona" name="rdbTipoPersona" value="1" onclick="setearCampos(1)" tabindex="1" {SELECTED_PERSONA_FISICA} />Persona F&iacute;sica
				<input type="radio" id="rdbTipoPersona" name="rdbTipoPersona" value="2" onclick="setearCampos(2)" tabindex="2" {SELECTED_PERSONA_JURIDICA} />Persona Jur&iacute;dica</span>
				<input type="button" id="btnBuscarCliente" name="btnBuscarCliente" onclick="buscarCliente();" value="Buscar Clientes" />
				</td>
			</tr>
			<tr>
				<td class="SubHead" align="left" bgcolor="#ffffff">
					<table id="TablaTitular" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
						<tbody>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5">
								<label id="Solicitudes_plCuenta">
								</label>
							</td>
						</tr>						
						<tr>
							<td>
								(*)Fecha de Presentaci&oacute;n:
							</td>
							<td>
								(*)Fecha de Solicitud
							</td>
							<td class="SubHead">
								N&uacute;mero:
							</td>	
							<td class="SubHead">
								(*)BIN:
							</td>
						</tr>
						<tr>
							<td valign="top">
							<input id="dFechaPresentacion" name="dFechaPresentacion" type="text" class="FormTextBox" style="width:200px;" onchange="validarFecha(this,'Fecha de Presentacion');" tabindex="3" value="{FECHA_PRESENTACION}">
							</td>
							<td valign="top">
							<input id="dFechaSolicitud" name="dFechaSolicitud" type="text" class="FormTextBox" style="width:200px;" onchange="validarFecha(this,'Fecha de Solicitud')" tabindex="4" value="{FECHA_SOLICITUD}">
							</td>	
							<td valign="top">
							<input id="sNumero" name="sNumero" type="text" class="FormTextBox" style="width:200px;" value="{NUMERO_SOLICITUD}" {READONLY_CAMPO}>
							</td>	
							<td valign="top">
							<select id="idBIN" name="idBIN" class="FormTextBox" style="width:200px;" {DISABLED_CAMPO}>
								{optionsBin}
							</select>
							</td>	
						</tr>
						<tr>							
							<td>
								Canal:								
							</td>
							<td class="SubHead">
								<span id="Solicitudes_plEmpleado_lblLabel">Promotor:</span>
							</td>	
							<td>Sucursal:</td>
							<td>Oficinas:</td>
							<td>Empleado:</td>
						</tr>
						<tr>
							<td valign="top">
								<select id="idCanal" name="idCanal" class="FormTextBox" style="width:200px;" tabindex="5">
								{optionsCanales}
								</select>
							</td>																																		
							<td class="SubHead">
								<select name="idPromotor" id="idPromotor" class="FormTextBox" style="width:200px;" tabindex="6">
								{optionsPromotores}
								</select>
							</td>
							<td width="150">
						  		<select name="idSucursal" id="idSucursal" style="width:150px;" tabindex="7">
						  		{optionsSucursales}
						  		</select>
						  	</td>
						  	<td width="150">
						  		<select name="idOficina" id="idOficina" style="width:150px;" tabindex="8">
						  		{optionsOficinas}
						  		</select>
						  	</td>
						  	<td>
						  		<select name="idEmpleado" id="idEmpleado" style="width:200px;" tabindex="9">
								{optionsEmpleados}
								</select>
						  	</td>
						</tr>	
						</tr>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="5">
								<label id="Solicitudes_plTituloTitular">Datos del Titular:
								</label>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span id="Solicitudes_plApellido_lblLabel">(*)Apellidos(de soltero/a):</span>
							</td>
							<td class="SubHead">
								<span id="Solicitudes_plNombre_lblLabel">(*)Nombre:</span>
							</td>								
							<td class="SubHead">
								<span id="Solicitudes_plEstadoCivil_lblLabel">(*)Estado Civil:</span>
							</td>		
							<td class="SubHead">
								<span id="Solicitudes_plNacionalidad_lblLabel">(*)Nacionalidad:</span>
							</td>
							<td>
								<span id="Solicitudes_plRazonSocial_lblLabel">Razon Social:</span>
							</td>								
						</tr>
						<tr>
							<td valign="top">
								<input id="sApellido" name="sApellido" type="text" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas_SinEspeciales(this.value,this.id);" value="{APELLIDO}" tabindex="10" maxlength="50"></td>
							<td valign="top">
								<input id="sNombre"  name="sNombre" type="text" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas_SinEspeciales(this.value,this.id);" value="{NOMBRE}" tabindex="11" maxlength="50">
							</td>														
							<td class="SubHead">
								<select name="idEstadoCivil" id="idEstadoCivil" class="FormTextBox" style="width:200px;" tabindex="12">
									{optionsEstadoCivil}
								</select>
							</td>
							<td class="SubHead">
								<select name="idNacionalidad" id="idNacionalidad" class="FormTextBox" style="width:200px;" tabindex="13">
									{optionsNacionalidad}
								</select>
							</td>	
							<td>
								<input id="sRazonSocial" name="sRazonSocial" type="text" class="FormTextBox" style="width:200px;" value="{RAZON_SOCIAL}" onKeyUp="aMayusculas(this.value,this.id)" tabindex="14"></td>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
								<span id="dnn_ctr608_Solicitudes_plTipoDocumento_lblLabel">(*)Tipo de Documento:</span>
							</td>
							<td class="SubHead">
								<span id="dnn_ctr608_Solicitudes_plNroDocumento_lblLabel">(*)N&uacute;mero de Documento:</span>
							</td>
							<td class="SubHead">
								<span id="Solicitudes_plCuit_lblLabel">(*)CUIT:</span>
							</td>
							<td class="SubHead">
								<span id="Solicitudes_plFechaNac_lblLabel">(*)Fecha de Nacimiento:</span>
							</td>
							<td class="SubHead">
								<span id="Solicitudes_Sexo_lblLabel">(*)Sexo:</span>
							</td>		
						</tr>
						<tr>
							<td class="SubHead" valign="top">
							<select id="idTipoDocumento" name="idTipoDocumento" class="FormTextBox" tabindex="15">
								{optionsTipoDoc}
							</select>
							</td>
							<td class="SubHead" valign="top">
								<input id="sDocumento" name="sDocumento" type="text" class="FormTextBox" onblur="this.value=numero_parse_entero(this.value);" value="{DOCUMENTO}" tabindex="16">
							</td>
							<td class="SubHead">
								<input name="sCuit" type="text" id="sCuit" class="FormTextBox" value="{CUIT}" tabindex="17">
							</td>
							<td class="SubHead">
								<input type="text" id="dFechaNacimiento" name="dFechaNacimiento" style="width:110px;" onblur="validarFecha(this,'Fecha de Nacimiento');" value="{FECHA_NACIMIENTO}" tabindex="18"/>
							</td>
							<td valign="top">
								<select id="idSexo" name="idSexo" style="width:120px;" tabindex="19" onchange="GenerarCuit(this.value);">
								{optionsSexos}
								</select>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
							<span id="Solicitudes_ApellidoConyuge_lblLabel">Apellido C&oacute;nyuge:</span>
							</td>
							<td class="SubHead">
							<span id="Solicitudes_NombreConyuge_lblLabel">Nombre C&oacute;nyuge:</span>
							</td>
							<td class="SubHead">
							<span id="Solicitudes_TipoDocConyuge_lblLabel">Tipo doc. C&oacute;nyuge:</span>
							</td>
							<td class="SubHead">
							<span id="Solicitudes_NumDocConyuge_lblLabel">N&uacute;mero doc. C&oacute;nyuge:</span>
							</td>
							<td class="SubHead">
							<span id="Solicitudes_plHijo_lblLabel">Hijos:</span>
							</td>
						</tr>
						<tr>
							<td class="SubHead">
							<input name="sApellidoConyuge" type="text" id="sApellidoConyuge" class="FormTextBox" onKeyUp="aMayusculas(this.value,this.id)" value="{APELLIDO_CONYUGE}" tabindex="20">
							</td>
							<td class="SubHead">
							<input name="sNombreConyuge" type="text" id="sNombreConyuge" class="FormTextBox" onKeyUp="aMayusculas(this.value,this.id)" value="{NOMBRE_CONYUGE}" tabindex="21">
							</td>						
							<td class="SubHead" valign="top">
								<select name="idTipoDocumentoConyuge" id="idTipoDocumentoConyuge" class="FormTextBox" tabindex="22">
									{optionsTipoDoc}
								</select>
							</td>
							<td class="SubHead" valign="top">
								<input name="sDocumentoConyuge" type="text" id="sDocumentoConyuge" class="FormTextBox" onblur="this.value=numero_parse_entero(this.value);" value="{DOCUMENTO_CONYUGE}" tabindex="23">
							</td>
							<td class="SubHead">
								<input name="iHijos" type="text" id="iHijos" class="FormTextBox" style="width:20px;" value="{HIJOS}" tabindex="24">
							</td>
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
					<div id="dnn_ctr608_Solicitudes_pnDomicilio">
						
						<table id="TablaDomicilio" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
							<tr>
								<td class="subTitulo" align="left" height="30" colspan="5">
									  <span id="Solicitudes_plTituloDomicilio">Datos del Domicilio del Titular:</span>
								</td>
							</tr>
							<tr>
								<td class="SubHead">
								<span id="Solicitudes_plProvincia_lblLabel">(*)Provincia:</span>
								</td>
								<td class="SubHead">
								  <span id="Solicitudes_plLocalidad_lblLabel">(*)Localidad:</span>
								</td>
								<td class="SubHead">
								  <span id="Solicitudes_plCPostal_lblLabel">(*)C.P.:</span>
								</td>
								
							</tr>
							<tr>
								<td class="SubHead" align="left">
									<select name="idProvinciaTitu" id="idProvinciaTitu" class="FormTextBox" tabindex="25">
										{optionsProviTitu}
									</select>
								</td>	
								<td class="SubHead" align="left">
									<select name="idLocalidadTitu" id="idLocalidadTitu" class="FormTextBox" tabindex="26">
										{optionsLocalidades}
									</select>
								<td class="SubHead" align="left">
									<input name="sCodigoPostalTitu" type="text" id="sCodigoPostalTitu" class="FormTextBox" onchange="copiarValor(sCodigoPostalResumen,this.value)" value="{CODIGO_POSTAL}" tabindex="27" maxlength="10">
								</td>
								
							</tr>
							<tr>
								<td class="SubHead">
								  <span id="Solicitudes_plCalleTitu_lblLabel">(*)Calle:</span>
								</td>
								<td class="SubHead">
								  <span id="Solicitudes_plNroTitu_lblLabel">Nro.:</span>
								</td>								
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Block:</span>
								</td>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Piso:</span>
								</td>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Departamento:</span>
								</td>								
							</tr>
							<tr>
								<td class="SubHead" align="left">
									<input name="sCalleTitu" type="text" id="sCalleTitu" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id)" onblur="copiarValor(sCalleResumen,this.value)" value="{CALLE}" tabindex="28" maxlength="45"/></td>
								<td class="SubHead" align="left">
									<input name="sNumeroCalleTitu" type="text" id="sNumeroCalleTitu" class="FormTextBox" style="width:50px;" onblur="copiarValor(sNumeroCalleResumen,this.value)" value="{NUMERO_CALLE}" tabindex="29" maxlength="6"/></td>												
								<td class="SubHead" align="left">
									<input name="sBlockTitu" type="text" id="sBlockTitu" class="FormTextBox" style="width:50px;" onblur="copiarValor(sBlockResumen,this.value)" value="{BLOCK}" tabindex="30" maxlength="4"/></td>
								<td class="SubHead" align="left">
									<input name="sPisoTitu" type="text" id="sPisoTitu" class="FormTextBox" style="width:50px;" onblur="copiarValor(sPisoResumen,this.value)" value="{PISO}" tabindex="31" maxlength="4"/></td>
								<td class="SubHead" align="left">
									<input name="sDepartamentoTitu" type="text" id="sDepartamentoTitu" class="FormTextBox" style="width:200px;" onblur="copiarValor(sDepartamentoResumen,this.value)" value="{DEPARTAMENTO}" tabindex="32" maxlength="4"/></td>	
							</tr>
							<tr>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Entre Calles:</span></td>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Barrio:</span></td>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Manzana:</span></td>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Lote:</span></td>
							</tr>
							<tr>
								<td class="SubHead" align="left">
									<input name="sEntreCalleTitu" type="text" id="sEntreCalleTitu" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id)" onblur="copiarValor(sEntreCalleResumen,this.value)"  value="{ENTRE_CALLE}" tabindex="33" maxlength="100"/></td>				
								<td class="SubHead" align="left">
									<input name="sBarrioTitu" type="text" id="sBarrioTitu" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id)" onblur="copiarValor(sBarrioResumen,this.value)"  value="{BARRIO}" tabindex="34" maxlength="45"/></td>
								<td class="SubHead" align="left">
									<input name="sManzanaTitu" type="text" id="sManzanaTitu" class="FormTextBox" style="width:50px;" onKeyUp="aMayusculas(this.value,this.id)" onblur="copiarValor(sManzanaResumen,this.value)" value="{MANZANA}" tabindex="35" maxlength="4"/></td>
								<td class="SubHead" align="left">
									<input name="sLoteTitu" type="text" id="sLoteTitu" class="FormTextBox" style="width:50px;" onKeyUp="aMayusculas(this.value,this.id)" onblur="copiarValor(sLoteResumen,this.value)" value="{LOTE}" tabindex="36" maxlength="4"/></td>	
							</tr>												
						</table>
					</div>
					</td>
				</tr>
				<tr>
					<td>
					<div id="dnn_ctr608_Solicitudes_pnResumen">
						<table id="TablaDomicilio" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
							<tr>
								<td class="subTitulo" align="left" height="30" colspan="5">
									  <span id="Solicitudes_plTituloDomicilio">Enviar Resumen:</span>
								</td>
							</tr>
								<tr>
								<td class="SubHead">
								<span id="Solicitudes_plProvincia_lblLabel">(*)Provincia:</span>
								</td>
								<td class="SubHead">
								  <span id="Solicitudes_plLocalidad_lblLabel">(*)Localidad:</span>
								</td>
								<td class="SubHead">
								  <span id="Solicitudes_plCPostal_lblLabel">(*)C.P.:</span>
								</td>								
							</tr>
							<tr>
								<td class="SubHead" align="left">
								<select name="idProvinciaResumen" id="idProvinciaResumen" class="FormTextBox" tabindex="37">
									{optionsProviResumen}
								</select>
								</td>	
								<td class="SubHead" align="left">
								<select name="idLocalidadResumen" id="idLocalidadResumen" class="FormTextBox" tabindex="38">
									{optionsLocalidadesResumen}
								</select>
								</td>
								<td class="SubHead" align="left">
									<input name="sCodigoPostalResumen" type="text" id="sCodigoPostalResumen" class="FormTextBox" value="{CP_RESUMEN}" tabindex="39" maxlength="10">
								</td>
								
							</tr>							
							<tr>
								<td class="SubHead">
								  <span id="Solicitudes_plCalleResumen_lblLabel">(*)Calle:</span>
								</td>
								<td class="SubHead">
								  <span id="Solicitudes_plNroResumen_lblLabel">Nro.:</span>
								</td>								
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Block:</span>
								</td>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Piso:</span>
								</td>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Departamento:</span>
								</td>								
							</tr>
							<tr>
								<td class="SubHead" align="left">
									<input name="sCalleResumen" type="text" id="sCalleResumen" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id)" value="{CALLE_RESUMEN}" tabindex="40" maxlength="45"/></td>
								<td class="SubHead" align="left">
									<input name="sNumeroCalleResumen" type="text" id="sNumeroCalleResumen" class="FormTextBox" style="width:50px;" value="{NUMERO_CALLE_RESUMEN}" tabindex="41" maxlength="6"/></td>												
								<td class="SubHead" align="left">
									<input name="sBlockResumen" type="text" id="sBlockResumen" class="FormTextBox" style="width:50px;" value="{BLOCK_RESUMEN}" tabindex="42" maxlength="4"/></td>
								<td class="SubHead" align="left">
									<input name="sPisoResumen" type="text" id="sPisoResumen" class="FormTextBox" style="width:50px;" value="{PISO_RESUMEN}" tabindex="43" maxlength="4"/></td>
								<td class="SubHead" align="left">
									<input name="sDepartamentoResumen" type="text" id="sDepartamentoResumen" class="FormTextBox" style="width:200px;" value="{DPTO_RESUMEN}" tabindex="44" maxlength="4"/></td>	
							</tr>
							<tr>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Entre Calles:</span></td>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Barrio:</span></td>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Manzana:</span></td>
								<td class="SubHead">
								  <span id="Solicitudes_plDomicilio_lblLabel">Lote:</span></td>
							</tr>
							<tr>
								<td class="SubHead" align="left">
								<input name="sEntreCalleResumen" type="text" id="sEntreCalleResumen" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id)" value="{ENTRE_CALLE_RESUMEN}" tabindex="45" maxlength="100"/></td>				
								<td class="SubHead" align="left">
								<input name="sBarrioResumen" type="text" id="sBarrioResumen" class="FormTextBox" style="width:200px;" value="{BARRIO_RESUMEN}" onKeyUp="aMayusculas(this.value,this.id)" tabindex="46" maxlength="50"/></td>
								<td class="SubHead" align="left">
								<input name="sManzanaResumen" type="text" id="sManzanaResumen" class="FormTextBox" style="width:50px;" value="{MANZANA_RESUMEN}" tabindex="47" maxlength="4"/></td>
								<td class="SubHead" align="left">
								<input name="sLoteResumen" type="text" id="sLoteResumen" class="FormTextBox" style="width:50px;" value="{LOTE_RESUMEN}" tabindex="48" maxlength="4"/></td>	
							</tr>	
						</table>	
					</div>
					</td>
				</tr>
				<tr>
					<td bgcolor="#ffffff">
					
					<div id="dnn_ctr608_Solicitudes_pnIngresos">
				
				<table id="TablaCondicion" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
					<tr>
						<td class="subTitulo" align="left" height="30" colspan="5">
						<span id="Solicitudes_plTituloIngresos">Datos Laborales:</span>
						</td>
					</tr>
					<tr>
						<td class="SubHead">
						    <span id="Solicitudes_plRazonSocial_lblLabel">(*)Raz&oacute;n social:</span>
						</td>
						<td class="SubHead">
						    <span id="Solicitudes_plCuitEmpleador_lblLabel">CUIT. Empleador:</span>
						</td>
						<td class="SubHead">
						    <span id="Solicitudes_plCondAFIP_lblLabel">(*)Condici&oacute;n AFIP:</span>
						</td>
						<td class="SubHead">
							<span id="Solicitudes_plCondLab_lblLabel">Condici&oacute;n Laboral:</span>
						</td>
						<td class="SubHead">
							<span id="Solicitudes_plReparticion_lblLabel">Repartici&oacute;n:</span>
						</td>
						
					</tr>	
						<tr>
						<td class="SubHead" align="left">
						<input name="sRazonSocialLab" type="text" id="sRazonSocialLab" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id)" value="{RAZON_SOCIAL_LAB}" tabindex="49"/>
						</td>
						<td class="SubHead" align="left">
						<input name="sCuitEmpleador" type="text" id="sCuitEmpleador" class="FormTextBox" style="width:200px;" value="{CUIT_EMPLEADOR}" tabindex="50"/>
						</td>
						<td class="SubHead" align="left">
							<select name="idCondicionAFIPLab" id="idCondicionAFIPLab" class="FormTextBox" style="width:200px;" value="{CONDICION_AFIP_LAB}" tabindex="51">
								{optionsTiposIva}
							</select>
						</td>
						<td class="SubHead" align="left">
							<select name="idCondicionLaboral" id="idCondicionLaboral" class="FormTextBox" style="width:200px;" tabindex="52" onchange="setearCondicionAfip(this.value)">
								{optionsCondicionesLab}
							</select>
						</td>	
						<td class="SubHead" align="left">
							<input name="sReparticion" type="text" id="sReparticion" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id)" value="{REPARTICION_LAB}" tabindex="53"/>
						</td>
					</tr>		
					<tr>
						<td class="SubHead">
						    <span id="Solicitudes_plActividad_lblLabel">Actividad:</span>
						</td>								
						</td>
						<td class="SubHead">
							<span id="Solicitudes_plCalle_lblLabel">Calle:</span>
						</td>
						<td class="SubHead">
						  	<span id="Solicitudes_plNro_lblLabel">Nro.:</span>
						</td>
						<td class="SubHead">
						  	<span id="Solicitudes_plBlock">Block:</span>
						</td>
						<td align="left">
							<table id="TablaCondicion" cellspacing="0" cellpadding="0" width="100%" border="0" class="TablaGeneral">
							<tr>
								<td class="SubHead">
								<span id="Solicitudes_plPiso_lblLabel">Piso:</span>
								</td>
								<td class="SubHead">
								 <span id="Solicitudes_plDpto_lblLabel">Oficina:</span>
								</td>
							</tr>
							</table>
						</td>
					</tr>	
					<tr>
						<td class="SubHead" align="left">
							<input name="sActividad" type="text" id="sActividad" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id)" value="{ACTIVIDAD_LAB}" tabindex="54"/>
						<td class="SubHead" align="left">
							<input name="sCalleLab" type="text" id="sCalleLab" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id)" value="{CALLE_LAB}" tabindex="55"/></td>
						<td class="SubHead" align="left">
							<input name="sNumeroCalleLab" type="text" id="sNumeroCalleLab" class="FormTextBox" style="width:50px;" value="{NUMERO_CALLE_LAB}" tabindex="56"/></td>
						<td class="SubHead" align="left">
							<input name="sBlockLab" type="text" id="sBlockLab" class="FormTextBox" style="width:30px;" value="{BLOCK_LAB}" tabindex="57"/></td>	
						<td>
							<table id="TablaCondicion" cellspacing="0" cellpadding="0" width="100%" border="0">
							<tr>	
							<td class="SubHead" align="left">
								<input name="sPisoLab" type="text" id="sPisoLab" class="FormTextBox" style="width:30px;" value="{PISO_LAB}" tabindex="58"/></td>
							<td class="SubHead" align="left">
								<input name="sOficinaLab" type="text" id="sOficinaLab" class="FormTextBox" style="width:30px;" value="{OFICINA_LAB}" tabindex="59"/></td>
							</tr>
							</table>
						</td>		
					</tr>
					<tr>
						<td class="SubHead">
						  <span id="Solicitudes_plBarrio">Barrio:</span>
						</td>
						<td class="SubHead">
							<span id="Solicitudes_plManzana_lblLabel">Manzana:</span>
						</td>
						<td class="SubHead">
							<span id="Solicitudes_plProvincia_lblLabel">(*)Provincia:</span>
						</td>
						<td class="SubHead">
						  <span id="Solicitudes_plLocalidad_lblLabel">(*)Localidad:</span>
						</td>
						<td class="SubHead">
						  <span id="Solicitudes_plCP">(*)CP.:</span>
						</td>
					</tr>	
						<tr>
						<td class="SubHead" align="left">
							<input name="sBarrioLab" type="text" id="sBarrioLab" class="FormTextBox" style="width:200px;" onKeyUp="aMayusculas(this.value,this.id)" value="{BARRIO_LAB}" tabindex="60"/></td>	
						<td class="SubHead" align="left">
							<input name="sManzanaLab" type="text" id="sManzanaLab" class="FormTextBox" style="width:30px;" onKeyUp="aMayusculas(this.value,this.id)" value="{MANZANA_LAB}" tabindex="61"/></td>								
						<td class="SubHead" align="left">
							<select name="idProvinciaLab" id="idProvinciaLab" class="FormTextBox" tabindex="62">
								{optionsProviLab}
							</select>
						</td>	
						<td class="SubHead" align="left">
							<select name="idLocalidadLab" id="idLocalidadLab" class="FormTextBox" style="width:200px" tabindex="63">
								{optionsLocalidadesLab}
							</select>
						</td>	
						<td class="SubHead" align="left">
						<input name="sCodigoPostalLab" type="text" id="sCodigoPostalLab" class="FormTextBox" style="width:100px;" value="{CP_LAB}" tabindex="64"/></td>	
					</tr>										
					<tr>
						<td class="SubHead">
						<span id="Solicitudes_plTelefonoLaboral1_lblLabel">(*)Telefono laboral 1:</span>
						</td>
						<td class="SubHead">
						  <span id="Solicitudes_plInterno_lblLabel">Interno 1:</span>
						</td>
						<td class="SubHead">
						  <span id="Solicitudes_plFechaIngreso">Fecha Ingreso 1:</span>
						</td>
						<td class="SubHead">
						<span id="Solicitudes_plCargo1_lblLabel">(*)Cargo 1:</span>
						</td>
						<td class="SubHead">
						  <span id="Solicitudes_plIngresoNetoMensual_lblLabel">Ingreso neto mensual 1:</span>
						</td>
					</tr>	
						<tr>
						<td class="SubHead" align="left">
						<input name="sTelLaboral1Prefijo" type="text" id="sTelLaboral1Prefijo" class="FormTextBox" style="width:50px;" onblur="this.value=numero_parse_entero(this.value);" value="{TEL1_PREFIJO}" tabindex="65" maxlength="4"/>&nbsp;-
						<input name="sTelLaboral1Numero" type="text" id="sTelLaboral1Numero" class="FormTextBox" style="width:120px;" onblur="this.value=numero_parse_entero(this.value);" value="{TEL1_NUMERO}" tabindex="66" maxlength="10"/></td>
						<td class="SubHead" align="left">
						<input name="sInterno1" type="text" id="sInterno1" class="FormTextBox" style="width:200px;" onblur="this.value=numero_parse_entero(this.value);" value="{INTERNO1}" tabindex="67"/></td>
						<td class="SubHead" align="left">
						<input name="dFechaIngreso1" type="text" id="dFechaIngreso1" class="FormTextBox" style="width:200px;" onblur="validarFecha(this,'Fecha de Ingreso 1')" value="{FECHA_INGRESO1}" tabindex="68"/></td>
						<td class="SubHead" align="left">
						<input name="sCargo1" type="text" id="sCargo1" class="FormTextBox" style="width:200px;" value="{CARGO1}" onKeyUp="aMayusculas(this.value,this.id)" tabindex="69"/></td>
						<td class="SubHead" align="left">
						<input name="fIngresoNetoMensual1" type="text" id="fIngresoNetoMensual1" class="FormTextBox" style="width:200px;" value="{ING_MESUAL1}" tabindex="70"/></td>
					</tr>
					<tr>
						<td class="SubHead">
						  <span id="Solicitudes_plTelefonoLaboral2">Telefono laboral 2:</span>
						</td>
						<td class="SubHead">
						<span id="Solicitudes_plInterno2_lblLabel">Interno 2:</span>
						</td>
						<td class="SubHead">
						  <span id="Solicitudes_plFechaIngreso2_lblLabel">Fecha ingreso 2:</span>
						</td>
						<td class="SubHead">
						  <span id="Solicitudes_plCargo2">Cargo 2:</span>
						</td>
						<td class="SubHead">
							<span id="Solicitudes_plIngresoNetoMensual_lblLabel">Ingreso neto mensual 2:</span>
						</td>
					</tr>	
						<tr>
						<td class="SubHead" align="left">
							<input name="sTelLaboral2Prefijo" type="text" id="sTelLaboral2Prefijo" class="FormTextBox" style="width:50px;" onblur="this.value=numero_parse_entero(this.value);" value="{TEL2_PREFIJO}" tabindex="71" maxlength="4"/>&nbsp;-
							<input name="sTelLaboral2Numero" type="text" id="sTelLaboral2Numero" class="FormTextBox" style="width:120px;" onblur="this.value=numero_parse_entero(this.value);" value="{TEL2_NUMERO}" tabindex="72" maxlength="10"/></td>
						<td class="SubHead" align="left">
							<input name="sInterno2" type="text" id="sInterno2" class="FormTextBox" style="width:200px;" value="{INTERNO2}" tabindex="73"/></td>
						<td class="SubHead" align="left">
							<input name="dFechaIngreso2" type="text" id="dFechaIngreso2" class="FormTextBox" style="width:200px;" onchange="validarFecha(this,'Fecha de Ingreso 2')" value="{FECHA_INGRESO2}" tabindex="74"/></td>
						<td class="SubHead" align="left">
							<input name="sCargo2" type="text" id="sCargo2" class="FormTextBox" style="width:200px;" value="{CARGO2}" onKeyUp="aMayusculas(this.value,this.id)" tabindex="75" /></td>
						<td class="SubHead" align="left">
							<input name="fIngresoNetoMensual2" type="text" id="fIngresoNetoMensual2" class="FormTextBox" style="width:200px;" value="{ING_MESUAL2}" tabindex="76"/></td>
					</tr>		
					</table>
					
					</div></td>
			</tr>
			<tr>
				<td bgcolor="#ffffff">
				
				<div id="dnn_ctr608_Solicitudes_pnIngresos">
			
				<table id="TablaCondicion" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
					<tr>
						<td class="subTitulo" align="left" height="30" colspan="5">
						<span id="dnn_ctr608_Solicitudes_plTituloIngresos_lblLabel">Otros Datos:</span>
						</td>
					</tr>
					<tr>
						<td></td>
						<td class="SubHead" width="200">
							<span id="dnn_ctr608_Solicitudes_plCondicionLaboral_lblLabel">Tel. fijo:</span>
						</td>
						<td class="SubHead" width="200">
							<span id="lblEmpresa">Celular:</span>								
						</td>
						<td class="SubHead">
						<span id="Solicitudes_plEmpresaCel_lblLabel">Empresas Celular:</span>
						</td>	
						<td class="SubHead">E-mail:</td>
					</tr>
					<tr>
						<td>PARTICULAR</td>
						<td class="SubHead" width="200" style="height:25px">
							<input name="sTelParticularFijoPrefijo" type="text" id="sTelParticularFijoPrefijo" class="FormTextBox" style="width:50px;" onblur="this.value=numero_parse_entero(this.value);" value="{TEL_PART_FIJO_PREFIJO}" tabindex="77" maxlength="4"/>&nbsp;-
							<input name="sTelParticularFijoNumero" type="text" id="sTelParticularFijoNumero" class="FormTextBox" style="width:120px;" onblur="this.value=numero_parse_entero(this.value);" value="{TEL_PART_FIJO_NUMERO}" tabindex="78" maxlength="10"/><br><br>
							
							
						</td>
						<td class="SubHead" width="200">
							<input name="sTelParticularMovilPrefijo" type="text" id="sTelParticularMovilPrefijo" class="FormTextBox" style="width:50px;" onblur="this.value=numero_parse_entero(this.value);" value="{TEL_PART_MOVIL_PREFIJO}" tabindex="79" maxlength="4"/>&nbsp;-
							<input name="sTelParticularMovilNumero" type="text" id="sTelParticularMovilNumero" class="FormTextBox" style="width:120px;" onblur="this.value=numero_parse_entero(this.value);" value="{TEL_PART_MOVIL_NUMERO}" tabindex="80" maxlength="10"/>
							
							<br/><span style="font-style:italic;font-size:7pt; " >Ejemplo: 387-4222222<span>
	    					<span style="font-style:italic;font-size:7pt;color: red;" >SIN "0" NI "15"<span>
						</td>
						<td>
						<select name="idEmpresaCelularTitular" id="idEmpresaCelularTitular" class="FormTextBox" style="width:200px;" tabindex="81">
							{optionsEmpresasCelulares}
						</select>
						<br/><br/>
						</td>
						<td><input name="sMail" type="text" id="sMail" class="FormTextBox" value="{MAIL}" tabindex="82"></td>	
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="SubHead" width="200">
							<span id="dnn_ctr608_Solicitudes_plCondicionLaboral_lblLabel">Tel. contacto:</span>
						</td>
						<td class="SubHead" width="200">
							<span id="lblEmpresa">Referencia Contacto:</span>
						</td>
						<td>&nbsp;</td>
					</tr>						
					<tr>
						<td>REFERENCIA</td>
						<td class="SubHead" width="200">
							<input name="sTelContactoPrefijo" type="text" id="sTelContactoPrefijo" class="FormTextBox" style="width:50px;" onblur="this.value=numero_parse_entero(this.value);" value="{TEL_CONTACTO_PREFIJO}" tabindex="83" maxlength="4"/>&nbsp;-
							<input name="sTelContactoNumero" type="text" id="sTelContactoNumero" class="FormTextBox" style="width:120px;" onblur="this.value=numero_parse_entero(this.value);" value="{TEL_CONTACTO_NUMERO}" tabindex="84" maxlength="10"/>
						</td>
						<td class="SubHead" width="200">
							<input name="sReferenciaContacto" type="text" id="sReferenciaContacto" class="FormTextBox" style="width:200px;" value="{REF_CONTACTO}" tabindex="85" onKeyUp="aMayusculas(this.value,this.id)"/>
						</td>
						<td>
						</td>
					</tr>
				</table>
				</div>
				</td>						
			</tr>				
			<tr><td style="height:10px"></td></tr>	
			<tr>
				<td colspan="2">
				<input type="checkbox" id="chkEnvioDomicilio" name="chkEnvioDomicilio" value="1" {CHECKED_ENVIO_DOMICILIO}/> El TITULAR solicita le envien los resumenes de cuenta a Domicilio, por lo que acepta se le debite mensualmente $3,00 en el mismo.
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<input type="checkbox" id="chkEnvioMail" name="chkEnvioMail" value="1" onclick="validarMailRequerido()" {CHECKED_ENVIO_MAIL}/> El TITULAR solicita le envien los resumenes de cuenta al siguiente E-mail:&nbsp;<span id="mailTitular"></span>
				</td>
			</tr>
			<tr>
				<td class="SubHeadRed" align="left" height="30">&nbsp;
					</td>
			</tr>
			<tr valign="top">
				<td class="SubHead">
					(*)Datos requeridos.
					</td>
			</tr>
			<tr valign="top">
				<td align="center">
					<input type="button" id="cmd_alta" name="cmd_alta" onclick="javascript:darAltaSolicitud();" value="Dar Alta" {MOSTRAR_DAR_ALTA} tabindex="83"/>&nbsp;&nbsp;
					<input type="button" id="cmd_enviar" name="cmd_enviar" onclick="javascript:sendFormSolicitud();" value="Guardar" {MOSTRAR_GUARDAR} tabindex="84"/>&nbsp;&nbsp;
					<input type="button" id="cmd_borrar" name="cmd_borrar" onclick="this.form.reset()" value="Borrar" {MOSTRAR_BORRAR} tabindex="85"/>
					<input type="button" id="cmd_volver" name="cmd_volver" onclick="window.location='{URL_PRINCIPAL}'" value="Volver" tabindex="86"/>
				</td>
			</tr>
			<tr><td style="height:20px"></td></tr>
		</tbody>
	</table>	
    
    </td>
  </tr>
  </table>
  
  </form>
  	
</center>
</body>
  <script>  
  {SCRIPT} 
  InputMask('dFechaPresentacion','99/99/9999');
  InputMask('dFechaSolicitud','99/99/9999');
  InputMask('dFechaNacimiento','99/99/9999');
  InputMask('dFechaIngreso1','99/99/9999');
  InputMask('dFechaIngreso2','99/99/9999');  
  //document.formSolicitud.rdbTipoPersona[0].checked=true;
  document.formSolicitud.dFechaPresentacion.focus(); 
  
  function validarMailRequerido(){
  	  if(document.getElementById("sMailRepetir").value == ""){
  	  	  alert("- El campo E-mail es requerido para el envio de Resumenes.\n");			
		  document.getElementById("sMail").focus();
		  document.getElementById("chkEnvioMail").checked= false;
		  document.getElementById("mailTitular").innerHTML = "";
		  return;
  	  }else{
  	  	  document.getElementById("mailTitular").innerHTML = document.getElementById("sMailRepetir").value;
  	  }
  }
  
  function darAltaSolicitud(){
  	if(!validarForm()){
  	 	return;  	 	
  	}
  	if(confirm("¿Esta seguro que desea dar de Alta la Solicitud?"))	{
  		xajax_updateDatosSolicitud(xajax.getFormValues('formSolicitud'),2);
  	}
  }
  
  function sendFormSolicitud(){
  	 if(!validarForm()){
  	 	return;  	 	
  	 }  	 
  	 //alert('paso');
  	 xajax_updateDatosSolicitud(xajax.getFormValues('formSolicitud'),1);
  }
  
  function aMayusculas_SinEspeciales(obj,id){
  	 //var RegExPattern = /[a-zA-Z]/; 
  	 
  	 //if(obj.match(RegExPattern)){
  	 	obj = obj.replace(/([^a-zA-ZÁÉÍÓÚáéíóú\t\s]+)/,'');
  	 	obj = obj.toUpperCase();
	 	document.getElementById(id).value = obj;
  	 //}
  }
  
  function setearCondicionAfip(CondLaboral){
  	  if(CondLaboral == 1){
  	  	 document.getElementById("Solicitudes_plCondAFIP_lblLabel").innerHTML = "Condici&oacute;n AFIP:";	
  	  }else{
  	  	 document.getElementById("Solicitudes_plCondAFIP_lblLabel").innerHTML = "(*)Condici&oacute;n AFIP:";	
  	  }
  	  if(CondLaboral == 4 || CondLaboral == 5 ){
   	  	 document.getElementById("Solicitudes_plCalle_lblLabel").innerHTML = "(*)Calle:";
   	  	 document.getElementById("Solicitudes_plNro_lblLabel").innerHTML = "(*)Nro.:";
  	  }else{
  	  	 document.getElementById("Solicitudes_plCalle_lblLabel").innerHTML = "Calle:";
  	  	 document.getElementById("Solicitudes_plNro_lblLabel").innerHTML = "Nro.:";
  	  }
  }
  
  function validarForm(){
  	 var form = document.getElementById('formSolicitud');
	 var errores = "";
	 with (form){
	 	
		if (dFechaPresentacion.value == ""){
			alert("- El campo Fecha de Presentacion es requerido.\n");
			dFechaPresentacion.focus();
			return false;
		}
		if(!validarFecha(dFechaPresentacion, 'Fecha de Presentacion')){
			dFechaPresentacion.focus(); 
			return false;
		}
		if(!validarFecha(dFechaSolicitud,'Fecha de Solicitud')){
			dFechaSolicitud.focus(); 
			return false;
		}		
		{VALIDACION_PRESENTACION_SOLICITUD}
				
		if (sApellido.value == ""){
			alert("- El campo Apellido del Titular es requerido.\n");
			sApellido.focus();return false;
		}
		if (sNombre.value == ""){
			alert("- El campo Nombre del Titular es requerido.\n");
			sNombre.focus();return false;
		}
		if (idEstadoCivil.value == 0){
			alert("- El campo Estado Civil del Titular es requerido.\n");
			idEstadoCivil.focus();return false;
		}
		if (idNacionalidad.value == 0){		
			alert("- El campo Nacionalidad del Titular es requerido.\n");
			idNacionalidad.focus();return false;
		}		
		if(rdbTipoPersona[1].checked){
			if (sRazonSocial.value == 0){
				alert("- El campo Razon Social del Titular es requerido.\n");
				sRazonSocial.focus();return false;
			}
		}
		if (idTipoDocumento.value == 0){
			alert("- El campo Tipo de Documento del Titular es requerido.\n");
			idTipoDocumento.focus();return false;
		}
		if (sDocumento.value == ""){			
			alert("- El campo Numero de Documento es requerido.\n");
			sDocumento.focus();return false;
		}		
		if (sDocumento.value == "0"){			
			alert("- El campo Numero de Documento no debe ser 0.\n");
			sDocumento.focus();return false;
		}		
		if(!validarDNI(sDocumento)){
			alert("- El campo Numero de Documento no es valido.\n");
			sDocumento.focus();return false;
		}
		
		if (sCuit.value == ""){
			alert("- El campo CUIT del Titular es requerido.\n");
			sCuit.focus();return false;
		}
		
		/*if(!validarCuitTitu(sCuit)){
			sCuit.focus();return false;
		}*/
		
		if(rdbTipoPersona[0].checked){
			if (dFechaNacimiento.value == ""){
				alert("- El campo Fecha de Nacimiento del Titular es requerido.\n");
				dFechaNacimiento.focus();return false;
			}
			if(!validaEdadValidaDeSolicitud(dFechaNacimiento.value)){
				dFechaNacimiento.focus();return false;
			}
		}
		if (idSexo.value == 0){			
			alert("- El campo Sexo del Titular es requerido.\n");			
			idSexo.focus();return false;
		}
		if (sMail.value != ""){			
			if(!validaMail(sMail.value)){
				alert("- El campo E-mail del Titular no es valido.\n");			
				sMail.focus();return false;
			}
		}
		if (idProvinciaTitu.value == 0){
			alert("- El campo Provincia del Titular es requerido.\n");
			idProvinciaTitu.focus();return false;
		}
		if (idLocalidadTitu.value == 0){
			alert("- El campo Localidad del Titular es requerido.\n");
			idLocalidadTitu.focus();return false;
		}
		if (sCodigoPostalTitu.value == ""){
			alert("- El campo Codigo Postal del Titular es requerido.\n");
			sCodigoPostalTitu.focus();return false;
		}
		if (sCalleTitu.value == ""){
			alert("- El campo Calle del Titular es requerido.\n");
			sCalleTitu.focus();return false;
		}
		if (idProvinciaResumen.value == 0){
			alert("- El campo Provincia de Resumen es requerido.\n");
			sCalleTitu.focus();return false;
		}
		if (idLocalidadResumen.value == 0){
			alert("- El campo Localidad de Resumen es requerido.\n");
			idLocalidadResumen.focus();return false;
		}
		if (sCodigoPostalResumen.value == ""){
			alert("- El campo Codigo Postal de Resumen es requerido.\n");
			sCodigoPostalResumen.focus();return false;
		}
		if (sCalleResumen.value == ""){
			alert("- El campo Calle de Resumen es requerido.\n");
			sCalleResumen.focus();return false;
		}
		if (sRazonSocialLab.value == ""){
			alert("- El campo Razon Social en Datos Laborales es requerido.\n");				
			sRazonSocialLab.focus();return false;
		}
		if(idCondicionLaboral.value != 1){	
			if (idCondicionAFIPLab.value == 0){
				alert("- El campo Condicion AFIP en Datos Laborales es requerido.\n");
				idCondicionAFIPLab.focus();return false;
			}
		}
		if((idCondicionLaboral.value==4) || (idCondicionLaboral.value==5)){
			if(sCalleLab.value == ""){
				alert("- El campo Calle en Datos Laborales es requerido.\n");				
				sCalleLab.focus();return false;
			}
			if(sNumeroCalleLab.value == ""){
				alert("- El campo Nro. en Datos Laborales es requerido.\n");				
				sNumeroCalleLab.focus();return false;
			}
		}		
		if (idProvinciaLab.value == 0){
			alert("- El campo Provincia en Datos Laborales es requerido.\n");
			idProvinciaLab.focus();return false;
		}
		if (idLocalidadLab.value == 0){
			alert("- El campo Localidad en Datos Laborales es requerido.\n");
			idLocalidadLab.focus();return false;
		}
		if (sCodigoPostalLab.value == ""){
			alert("- El campo Codigo Postal en Datos Laborales es requerido.\n");	
			sCodigoPostalLab.focus();return false;		
		}
		if (sTelLaboral1Prefijo.value == "" || sTelLaboral1Numero.value == ""){
			alert("- El campo Telefono Laboral 1 en Datos Laborales es requerido.\n");	
			if(sTelLaboral1Prefijo.value == ""){
				sTelLaboral1Prefijo.focus();return false;
			}else{
				if(sTelLaboral1Numero.value == ""){	
					sTelLaboral1Numero.focus();return false;		
				}
			}
		}
		if(dFechaIngreso1.value != ""){
			if(!validarFecha(dFechaIngreso1,'Fecha de Ingreso 1')){
				dFechaIngreso1.focus();	return false;
			}	
		}	 
		if(dFechaIngreso2.value != ""){
			if(!validarFecha(dFechaIngreso2,'Fecha de Ingreso 2')){
				dFechaIngreso2.focus();	return false;
			}	
		}	 
		if (sCargo1.value == ""){
			alert("- El campo Cargo 1 en Datos Laborales es requerido.\n");	
			sCargo1.focus();return false;		
		}
		if((sTelParticularFijoNumero.value == "")&&(sTelParticularMovilNumero.value == "")){
			alert("- Debe suministrar un Telefono Particular Fijo o Celular.\n");	
			if(sTelParticularFijoPrefijo.value == ""){
				sTelParticularFijoPrefijo.focus();return false;
			}else{
				if(sTelParticularFijoNumero.value == ""){
					sTelParticularFijoNumero.focus();return false;	
				}
			}
		}
		if((sTelParticularFijoNumero.value == "")&&(sTelParticularMovilNumero.value == "")){
			if(sTelContactoNumero.value == ""){
				alert("- El campo Telefono Contacto es requerido.\n");
				if(sTelContactoPrefijo.value == ""){
					sTelContactoPrefijo.focus();return false;
				}else{
					if(sTelContactoNumero.value == ""){
						sTelContactoNumero.focus();return false;	
					}
				}
			}
			if(sReferenciaContacto.value == ""){
				alert("- El campo Referencia Contacto es requerido.\n");
				sReferenciaContacto.focus();return false;
			}
		}
		
		if(!document.getElementById("chkEnvioDomicilio").checked && !document.getElementById("chkEnvioMail").checked){
			alert("- Debe seleccionar al menos una forma de envio de Resumenes.\n");
			return false;
		}
	 }
	 return true;
	
  }
  
  function recargarFormSolicitud(){
  	 var form = document.getElementById('formSolicitud');
  	 form.reset(); 
  }
  
  function copiarValor(object, valor){
  	object.value = valor;
  }
  
  function validarDNI(obj){
		if(obj.value.length>8 || obj.value.length<7){
			alert("El Numero de Documento es invalido");
			return false;
		}		
		return true;	
  }

  function validarCuitTitu(obj){
		if(!validaCuit(obj.value)){
			alert("El Numero de CUIT no es valido.");
			return false;
		}
		var numeroDni = document.getElementById("sDocumento").value;
		if(obj.value.indexOf(numeroDni)<0){
			alert("El Numero de Documento y Cuit del Titular no son consistentes, verifique.");
			return false;
		}
		return true;
  }
	
  function validarFecha(obj,nombreObj){
  	 if(obj.value != "" && obj.value != "__/__/____"){
		if(!validaFecha(obj.value)){
			alert('-La Fecha '+nombreObj+' no es valida.\n');
			return false;
		}
		return true;
  	 }
  }
	
	function calcularEdad_original(Fecha){
		var aFecha = Fecha.split('/');
		var FechaFormat = aFecha[1]+"/"+aFecha[0]+"/"+aFecha[2]; //Format: mm/dd/aaaa
		fecha = new Date(FechaFormat);
		fechaActual = new Date();
		edad = parseInt((fechaActual -fecha)/365/24/60/60/1000);
		return edad;
	}
	
	function calcularEdad(fecha) {
        var fechaActual = new Date()
        var array_fecha = fecha.split("/");
        var ano
        ano = parseInt(array_fecha[2], 10);
        if (isNaN(ano))
            return false
        var mes
        mes = parseInt(array_fecha[1], 10);
        if (isNaN(mes))
            return false
        var dia
        dia = parseInt(array_fecha[0], 10);
        if (isNaN(dia))
            return false
        edad = fechaActual.getFullYear() - ano - 1;

        if (fechaActual.getMonth() + 1 - mes < 0) {

        }
        if (fechaActual.getMonth() + 1 - mes > 0) {
            edad = edad + 1
        }

        if (fechaActual.getUTCDate() - dia >= 0) {
            edad = edad + 1
        }		
        return edad;
    }
	
	function validaEdadValidaDeSolicitud(fecha){
		var edad = calcularEdad(fecha);
		if((edad>80)||(edad<18)){
			alert("EL Titular no tiene la edad valida para solicitar la Tarjeta. La edad del Titular es "+edad);
			return false;
		}
		return true;
	}
	
	function setearCampos(tipoPersona){
		var Formu = document.getElementById('formSolicitud');
		if(tipoPersona == 1){//Persona fisica
			/*Formu.sApellido.value = "";
			Formu.sNombre.value = "";*/
			Formu.sRazonSocial.disabled = true; 
			Formu.idEstadoCivil.value = 0;
			Formu.idEstadoCivil.disabled = false;
			Formu.dFechaNacimiento.disabled = false;
			Formu.sApellidoConyuge.disabled = false;
			Formu.sNombreConyuge.disabled = false;
			Formu.idTipoDocumentoConyuge.disabled = false;
			Formu.sDocumentoConyuge.disabled = false;
			Formu.iHijos.disabled = false;		
			document.getElementById("Solicitudes_plRazonSocial_lblLabel").innerHTML = "Razon Social:";
			document.getElementById("Solicitudes_plFechaNac_lblLabel").innerHTML = "(*)Fecha de Nacimiento";	

		}else{ //Persona Juridica
			/*Formu.sApellido.value = "-";
			Formu.sNombre.value = "-";*/
			Formu.sRazonSocial.disabled=false; 
			Formu.idEstadoCivil.value=7;
			Formu.idEstadoCivil.disabled=true;
			Formu.dFechaNacimiento.disabled=true;
			Formu.sApellidoConyuge.disabled=true;
			Formu.sNombreConyuge.disabled=true;
			Formu.idTipoDocumentoConyuge.disabled=true;
			Formu.sDocumentoConyuge.disabled=true;
			Formu.iHijos.disabled=true;	
			document.getElementById("Solicitudes_plRazonSocial_lblLabel").innerHTML = "(*)Razon Social:";
			document.getElementById("Solicitudes_plFechaNac_lblLabel").innerHTML = "Fecha de Nacimiento";
		}
	}

	function hoy(){
	    var fechaActual = new Date();
	    dia = fechaActual.getDate();
	    mes = fechaActual.getMonth() +1;
	    anno = fechaActual.getFullYear();
	    if (dia <10) dia = "0" + dia;
	    if (mes <10) mes = "0" + mes;  
	    fechaHoy = dia + "/" + mes + "/" + anno;
	    return fechaHoy;
	}
	
	function validaFechaPresentacion(dFechaPresentacion){
		var dFechaActual = hoy();
		//alert(dFechaPresentacion +'------'+dFechaActual);
		if(mayorfecha(dFechaPresentacion,dFechaActual)){
			alert("No puede ingresar una Fecha de Presentacion Mayor a la Fecha Actual");	
			return false;
		}
		var dFechaSolicitud = document.getElementById('dFechaSolicitud').value;
		if(mayorfecha(dFechaSolicitud,dFechaPresentacion)){
			alert("No puede ingresar una Fecha de Presentacion Menor a la Fecha de Solicitud");	
			return false;			
		}		
		if(DiferenciaFechas(dFechaPresentacion,dFechaActual) >31){ //menos de un Mes
			alert("La Fecha de Presentacion no debe ser Menor a un Mes de la Fecha Actual");	
			return false;	
		}
		return true;
	}
	
	function validaFechaSolicitud(dFechaSolicitud){
		var dFechaActual = hoy();
		if(DiferenciaFechas(dFechaSolicitud,dFechaActual) >31){ //menos de un Mes
			alert("La Fecha de Solicitud no debe ser Menor a un Mes de la Fecha Actual");	
			return false;	
		}
		return true;
	}	
	
		
	var dhxWins;
	function createWindows(sUrl,sTitulo,idProyecto_,tipo_,width,height){
	    var idWind = "window_"+tipo_;
		//if(!dhxWins.window(idWind)){
	     	dhxWins = new dhtmlXWindows();     	
		    dhxWins.setImagePath("../includes/grillas/dhtmlxWindows/sources/imgs/");	  
		    _popup_ = dhxWins.createWindow(idWind, 250, 50, width, height);
		    _popup_.setText(sTitulo);
		    ///_popup_.center();
		    _popup_.button("close").attachEvent("onClick", closeWindows);
			_url_ = sUrl;
		    _popup_.attachURL(_url_);
		//}
	} 
	
	function closeWindows(_popup_){
		_popup_.close();
	}  	


	function buscarCliente(){
		createWindows('buscarClientes.php','Tarjeta',2,'cliente', 740, 500);
	}
	
	function setDatosCliente(idCliente){
		
		xajax_setDatosCliente(idCliente);
		document.getElementById("cmd_enviar").style.display="inline";
		var isWin = dhxWins.isWindow("window_cliente");
		  
	  	if(isWin){
	 		dhxWins.window("window_cliente").close(); 	
		}		  		 
	}
	
	function GenerarCuit(idTipo){
		var sDocumento = document.getElementById("sDocumento").value;
		xajax_getCuil(idTipo,sDocumento)
	}
  </script>