<style>
.table_liquidaciones{}

.table_liquidaciones td{
	border:0px solid #FFF !important;
}

</style>
<br />
<table border='0' style='font-size:12px;' width="90%" align="center">
<tr><td>COMERCIO: {sRazonSocial}</td></tr>
<tr><td>Fecha Liquidacion: {dFecha}</td></tr>
<tr><td>Nro. Liquidacion: {sNumeroLiquidacion}</td></tr>
</table>
		
		<br><br>
		
		<center>
		
<!--<div style='height:300px; overflow:auto;'>-->
	<form action='javascript:void(0);' method='GET' name='form_detalles_liquidaciones' id='form_detalles_liquidaciones'>
		<table width='60%'  class='TablaCalendario'>
		<tr class='filaPrincipal'>
			<th class='borde' style='height:10px'>Planes/Promociones</th>			
			<th class='borde' style='height:10px'>Importe Neto</th>			
			<th class='borde' style='cursor:pointer;'><input type='checkbox' onchange='tildar_checkboxs( this.checked )' id='checkbox_principal' /></th>
		</tr>
		
		{tableRows}
		
		<tr>
			<td	 colspan="11"><br /><br />
			</td>
		</tr>			
		
		<tr>
			<td	 colspan="11">
				<table align='center' style="font-family:Tahoma;font-size:12px;" class="table_liquidaciones">
					<tr>
						<td valign='middle' align='left' colspan="4">
							Forma de Pago Convenida : {sNombreFormaPago}
						</td>
					</tr>	
					<tr>
						<td valign='middle' align='right'>
							Ultimo Numero Cheque(*) :
						</td>
						<td colspan='3'> 
							<input type='text' name='sNroCheque' id='sNroCheque' value='{sNroCheque}'> 
							<span style="color:#F00;"> </span>
						</td>			
					</tr>
					<!--<tr>
						
						<td valign='middle' align='right'>
							Fecha Emision(*) :
						</td>
						<td> 
							<input type='text' name='dFechaEmision' id='dFechaEmision' value='{dFechaEmision}' >
						</td>						
						<td valign='middle' align='right'>
							 Fecha de Pago :
						</td>
						<td> 
							<input type='text' name='dFechaPago' id='dFechaPago' value='{dFechaPago}' > 
						</td>
					</tr>-->
					<tr>
						<td valign='middle' align='right'>
							Banco :
						</td>
						<td colspan='3'> 
							<select name='idBanco' id='idBanco' style='width:400px !important;' >
								{optionsBancos}
							</select>
						</td>
					</tr>					
					<tr>
					    
					   <td valign='middle' align='right'> 
							Pagar a :
						</td>
						<td colspan='3'> 
							<input type='text' name='sReceptor' id='sReceptor' style="width:400px;" value='{sReceptor}'>
						</td>
					</tr>					
					
					<tr>
						<!--<td valign='middle' align='right'>
							Importe :
						</td>
						<td>
							<input type='text' name='fImporte' id='fImporte' value='{fImporte}'>
						</td>-->
						<td valign='middle' align='right'>
							 CBU Destino(*):
						</td>
						<td colspan="3"> 
							<input type='text' name='sCBUDestino' id='sCBUDestino' value='{sCBUDestino}' > 
						</td>			
					</tr>
					<tr>
					    
					   <td valign='middle' align='right'> 
							Observaciones :
						</td>
						<td colspan="3"> 
							<textarea name='sObservaciones' id='sObservaciones' style="width:400px;">{sObservaciones}</textarea>
						</td>
					</tr>
					<tr>
						<td valign='middle' align='center' colspan='4' style='text-align:center !important;'>
								<input type='hidden' name='_i' id='_i' value='{_i}'>
								<input type='hidden' name='_ic' id='_ic' value='{_ic}'>
								<input type='hidden' name='_fp' id='_fp' value='{_fp}'>
								<input type="hidden" name="_op" id="_op" value="{_op}" />
								{button_emitir_comprobante}
						</td>			
					</tr>
				</table>			
			</td>
		</tr>
		</table>
	</form>
<!--</div>-->
		</center>		
		
<script type='text/javascript'>

	function _emitir_comprobante_pago(){

		var form = document.forms['form_detalles_liquidaciones'];	

		var ok = confirm('Esta seguro de emitir compronte de pago ? ');

		if(ok){
			xajax_issuance_payment_values(xajax.getFormValues('form_detalles_liquidaciones'));
			//form.submit();
		}

	}
	
	function _printCHEQUES(){

		window.print();

	}
	
</script>		