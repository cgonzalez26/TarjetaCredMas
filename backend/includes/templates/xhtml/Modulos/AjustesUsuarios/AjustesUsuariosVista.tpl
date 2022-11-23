<body style="background-color:#FFFFFF">
<center>
	<div id='' style='width:75%;text-align:right;margin-right:10px;'>
		<div id="idBtotonGuardar" style="{DISPLAY_GUARDAR}">
			<img src='{IMAGES_DIR}/disk.png'  title='Guardar' alt='Guardar Grupo' border='0' hspace='4' align='absmiddle'> 
			<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
			&nbsp;&nbsp;			
		</div>			
		<img src='{IMAGES_DIR}/back.png' title='Buscar Grupo' alt='Buscar Grupo' border='0' hspace='4' align='absmiddle'> 
		<a href="AjustesUsuarios.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
	<form id="formAjustesUsuarios" action="AdminAjustesUsuarios.php" method="POST">
		<fieldset id='cuadroAjuste' style="height:450px;width:40%">
			<legend> Ajuste de Usuario</legend>			
			<table id='TablaAjusteUsuario' cellpadding="0" cellspacing="5" class="TablaGeneral" width="860px">
				<tr>
					<td class="subTitulo" height="30" align="left" colspan="4">
					<label id="">Cuenta:</label>
					</td>				
				</tr>
				<tr>
					<td width="115px"> <b>Numero Cuenta:</b> </td>
					<td align="left" colspan="3">{NUMERO_CUENTA}</td>		
				</tr>
				<tr>
					<td colspan="4">
						<div style="height:50px;text-align:left;" id="datos_cuenta">
							{datos_cuenta}
						</div>						
					</td>					
				</tr>
				<tr>
					<td> &nbsp;</td>
				</tr>
			</table>
			<table id='TablaAjusteUsuario' cellpadding="0" cellspacing="5" class="TablaGeneral" width="860px">
			<tr>
				<td class="subTitulo" height="30" align="left" colspan="4">
				<label id="">Ajuste:</label>
				</td>
			</tr>
			<tr>			
				<td align="right"> <b>Fecha hora:</b> </td>
				<td> 					
					{FECHA_HORA}										
				</td> 					   		
			</tr>
			<tr>			
				<td align="right"> <b>Tasa IVA:</b> </td>
				<td> 					
					{NOMBRE_TASA_IVA}										
				</td> 					   		
			</tr>
			<tr>				
			</tr>
			<tr>
		    	<td align="right"><b>Tipo Moneda:</b></td>
		    	<td> 
					{NOMBRE_TIPO_MONEDA}						
				</td>
				<td align="right"><b>Cuotas:</b></td>
		    	<td>
		    	  {CUOTAS}
		       	</td> 			
			</tr>
			<tr>		   		
			</tr>
			<tr>
				<td align="right"><b>Tipo Ajuste:</b></td>
		    	<td> 					
					{NOMBRE_TIPO_AJUSTE}						
				</td> 
				<td align="right">
					<b>Interes (%):</b>
				</td>
				<td>	
					 {interes}
				</td>
			</tr>
			<tr>	
			</tr>
			<tr>
		   		<td align="right"><b>Importe:</b></td>
		    	<td>
		    	 {IMPORTE_TOTAL} 	 
		    	</td>
		    	<td align="right"><b>Importe Interes:</b></td>
		    	<td>
		    	  {IMPORTE_TOTAL_INTERES}		       	  
		    	 </td> 		    	
			</tr>
			<tr>
			</tr>
			<tr>
		   		<td align="right"><b>Importe IVA:</b></td>
		    	<td>
		    	  {IMPORTE_TOTAL_IVA}		       	 
		    	</td> 		    	
			</tr>			
			<tr>
		   		<td align="right"><b>Total:</b></td>
		    	<td>
		    	  {IMPORTE_TOTAL_FINAL}		    	 
		       	</td> 		    	
			</tr>		
			</table>
		</fieldset>
	</form>
</center>
</body>