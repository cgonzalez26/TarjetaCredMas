<body style="background-color:#FFFFFF">
<div id="BODY">
<center>
	<div id='' style='width:75%;text-align:right;margin-right:10px;'>
		<div id="idBtotonGuardar" style="{DISPLAY_GUARDAR}">
			<img src='{IMAGES_DIR}/disk.png'  title='Guardar' alt='Guardar Grupo' border='0' hspace='4' align='absmiddle'> 
			<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
			&nbsp;&nbsp;			
		</div>			
		<img src='{IMAGES_DIR}/back.png' title='Buscar Grupo' alt='Buscar Grupo' border='0' hspace='4' align='absmiddle'> 
		<a href="Cobranzas.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
	<form id="formCobranzas" action="AdminCobranzas.php" method="POST">
		<input type="hidden" id="idCobranza" name="idCobranza" value="{ID_COBRANZA}" />		
		<input type="hidden" id="sEstado" name="sEstado" value="{ESTADO}" />
		<input type="hidden" id="idCuentaUsuario" name="idCuentaUsuario" value="{ID_CUENTA_USUARIO}" />
		<input type="hidden" id="sCodigo" name="sCodigo" value="{CODIGO}" />		
				
		<fieldset id='cuadroAjuste' style="height:500px;width:40%">
			<legend> Cobranzas</legend>			
			<table id='TablaDatosEmpleado' cellpadding="0" cellspacing="6" class="TablaGeneral" width="860px">
				<tr>
					<td class="subTitulo" height="30" align="left" colspan="6">
					<label id="">Datos Empleado :</label>
					</td>				
				</tr>
				<tr>	
					<td colspan="4">
						<div style='display:block;'><label style='width:120px;float:left;'>Fecha hora: </label>{fecha_hora}<label> </label></div>						
					</td>
				</tr>
				<tr>	
					<td colspan="4">
						<div style='display:block;'><label style='width:120px;float:left;'>Atendido por: </label><label>{empleado} </label></div>						
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div style='display:block;'><label style='width:120px;float:left'>Oficina: </label><label>{oficina}</label></div>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div style='display:block;'><label style='width:120px;float:left'>Sucursal: </label>{sucursal}<label></label></div>
					</td>
				</tr>
			</table>
			<table id='TablaCuentaUsuario' cellpadding="0" cellspacing="5" class="TablaGeneral" width="860px">
				<tr>
					<td class="subTitulo" height="30" align="left" colspan="4">
					<label id="">Cuenta:</label>
					</td>				
				</tr>				
				<tr>
					<th  width="150px"> Numero Cuenta: </th>
					<td><label>{NUMERO_CUENTA}</label></td>					
			   		<td>
					</td>	
					<td>&nbsp;</td>			
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>	
				<tr>
					<td colspan="4">
						<div style="height:50px;text-align:left;" id="datos_cuenta">
							{datos_cuenta}
						</div>						
					</td>					
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>			
			</table>
			<table id='TablaCobranza' cellpadding="0" cellspacing="5" class="TablaGeneral" width="860px">
			<tr>
				<td class="subTitulo" height="30" align="left" colspan="4">
				<label id="">Cobranza:</label>
				</td>
			</tr>
			<tr>			
				<th> Tipo Moneda: </th>
				<td> 
					{NOMBRE_MONEDA}					
				</td>
				<th> Importe: </th>
				<td> 
					<label>{IMPORTE}</label>					
				</td> 		 					   		
			</tr>			
			<tr>
				<th>Fecha Cobranza:</th>
				<td>					
					<label>{FECHA_COBRANZA}</label>				
				</td>
				<td align="right"><b>Fecha Presentacion</b></td>
				<td><label id="dFechaPresentacion">{FECHA_PRESENTACION}</label></td>
			</tr>			
			</table>
		</fieldset>
	</form>
</center>




