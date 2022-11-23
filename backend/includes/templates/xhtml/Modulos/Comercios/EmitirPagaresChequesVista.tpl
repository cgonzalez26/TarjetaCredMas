
<center>
<div id='' style='width:600px;text-align:right;margin-right:10px;'>
	&nbsp;&nbsp;			
	<a style="text-decoration:none;font-weight:bold;" href="../LiquidacionComercios/Liquidaciones.php">
		<img hspace="4" border="0" align="absmiddle" alt="regresar" title="regresar" src="../includes/images/back.png"> VOLVER
	</a>
</div>

<div id='divMessageCheques' style='width:600px;text-align:left;height:20px;'></div>

</center>
<br />
<center>


	<table align='center' style="font-family:Tahoma;font-size:12px;">
		<tr>
			<td valign='middle' align='left' colspan="4">
				Comercio : {sNombreComercio}
				<br />
				Forma de Pago Convenida : {sNombreFormaPago}
			</td>
		</tr>	
	
	
		<tr>
			<td valign='middle' align='right'>
				Numero Serie(*) :
			</td>
			<td colspan='3'> 
				{sNumeroCheque}
			</td>			
		</tr>
		<tr>
			
			<td valign='middle' align='right'>
				Fecha Emision(*) :
			</td>
			<td> 
				{dFechaEmision}
			</td>						
			<td valign='middle' align='right'>
				 Fecha de Pago :
			</td>
			<td> 
				{dFechaPago}
			</td>
		</tr>
		
		<tr>
			<td valign='middle' align='right'>
				Banco :
			</td>
			<td colspan='3'>
				{sNombreBanco}
			</td>
		</tr>					
		<tr>
		    
		   <td valign='middle' align='right'> 
				Pagar a :
			</td>
			<td colspan='3'> 
				{sReceptor}
			</td>
		</tr>					
		
		<tr>
			<td valign='middle' align='right'>
				Importe :
			</td>
			<td>
				{fImporte}
			</td>
			<td valign='middle' align='right'>
				 CBU Destino(*):
			</td>
			<td> 
				{sCBUDestino}
			</td>			
		</tr>
		<tr>
		    
		   <td valign='middle' align='right'> 
				Observaciones :
			</td>
			<td colspan="3"> 
				{sObservaciones}
			</td>
		</tr>
		<tr>
			<td valign='middle' align='center' colspan='4' style='text-align:center !important;'>

			</td>			
		</tr>
	</table>	

