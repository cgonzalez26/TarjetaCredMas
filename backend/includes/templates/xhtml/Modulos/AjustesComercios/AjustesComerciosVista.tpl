<center>

<div id="CUPONES">

<div style="width:700px;">
	<div style='width:700px;text-align:right;'>
	
		<a href="AjustesComercios.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='regresar' alt='regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>

<form id="formCupones" action="AdminPlanes.php" method="POST" name="formCupones">	
	<input type="hidden" name="_op" id="_op" value="{_op}" />	
	<input type="hidden" name="_i" id="_i" value="{_i}" />	
	<input type="hidden" name="_ic" id="_ic" value="{_ic}" />
	<input type="hidden" id="bDiscriminaIVA" name="bDiscriminaIVA" value="{DISCRIMINA_IVA}" />	
	<input type="hidden" id="fTasaIVA" name="fTasaIVA" value="{TASA_IVA}" />
			
	<table cellpadding="0" cellspacing="0" width="700" border="0" align="center" class="TablaGeneral">
	<tr>
		<td align="right">
			<div id="div_reimprimir_cupon" style="width:700px;align:right;">
			</div>    
		</td>
	</tr>
	<tr>
	<td valign="top" style="padding-top:20px">
	
	    <table cellspacing="0" cellpadding="0" width="700" align="center" border="0" class="TablaGeneral">
		<tbody>
			<tr>
				<td valign="middle" align="left" height="20" class="Titulo">
					AJUSTES DE COMERCIOS	
				</td>
			</tr>
			<tr>
				<td class="SubHead" align="left" bgcolor="#ffffff">
						<table id="TablaTitular" cellspacing="5" cellpadding="0" width="700" border="0" class="TablaGeneral">
						<tbody>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">COMERCIO:</label>
							</td>
						</tr>
						<tr>
							<td>
								&nbsp;
							</td>
							<td colspan="3">
								&nbsp;								
							</td>
						</tr>						
						<tr>
							<td colspan="4" align="right">
								<center>
								<div style="width:700px;text-align:left;" id="div_datos_comercio">
									{datos_comercio}
								</div>
								</center>
							</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>
						</tr>
						<tr><td></td></tr>
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">Planes / Promociones</label>
							</td>
						</tr>
						<tr>
					    	<td>{TITULO_PLAN_PROMO}</td>
					    	<td>{NOMBRE_PLAN_PROMO}</td>
							
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>	
						<tr>
							<td class="subTitulo" align="left" height="30" colspan="4">
								<label id="">Datos del Ajuste:</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>	
							<tr>			
								<td align="right"><b>Tasa IVA:</b> </td>
									<td> 
										{NOMBRE_TASA_IVA}					
									</td> 					   		
								</tr>
								<tr>				
								</tr>
								<tr>
							    	<td align="right"><b>Tipo Moneda:<b></td>
							    	<td> 									
										{NOMBRE_TIPO_MONEDA}														
									</td>
									<td align="right"><b>Cuotas:<b></td>
							    	<td>
							    	 	{CUOTAS}
							       	</td> 			
								</tr>
								<tr>		   		
								</tr>
								<tr>
									<td align="right"><b>Tipo Ajuste:<b></td>
							    	<td> 										
											{NOMBRE_TIPO_AJUSTE}					
									</td> 
									<td align="right">
										<b>Interes (%):</b>
									</td>
									<td>
										 <label id="lblInteres">{interes}</label>
									</td>
								</tr>
								<tr>	
								</tr>
								<tr>
							   		<td align="right"><b>Importe:<b></td>
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
						</tbody>
						</table>					
				</td>
			</tr>
			<tr>
				<td class="SubHeadRed" align="left" height="30">&nbsp;</td>
			</tr>
			<tr valign="top">
				<td align="center">

				</td>
			</tr>
		</tbody>	
		</table>
	</table>		
		
	</form>
</div>

</center>