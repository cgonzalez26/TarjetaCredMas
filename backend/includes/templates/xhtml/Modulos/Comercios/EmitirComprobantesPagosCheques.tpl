
<center>
<div id='' style='width:600px;text-align:right;margin-right:10px;'>
	<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Cheque' border='0' hspace='4' align='absmiddle'> 
	<a href='javascript:issuance_payment_values();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] GUARDAR </a>
	&nbsp;&nbsp;			
	<a style="text-decoration:none;font-weight:bold;" href="../LiquidacionComercios/Liquidaciones.php">
		<img hspace="4" border="0" align="absmiddle" alt="regresar" title="regresar" src="../includes/images/back.png"> VOLVER
	</a>
</div>

<div id='divMessageCheques' style='width:600px;text-align:left;height:20px;'></div>

</center>
<br />
<center>
<form method='POST' name= 'form_liquidaciones_comercios' id='form_liquidaciones_comercios' action='javascript:void(0);'>

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
				<input type='text' name='sNroCheque' id='sNroCheque' value='{sNumeroCheque}'> 
			</td>			
		</tr>
		<tr>
			
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
		</tr>
		
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
			<td valign='middle' align='right'>
				Importe :
			</td>
			<td>
				<input type='text' name='fImporte' id='fImporte' value='{fImporte}'>
			</td>
			<td valign='middle' align='right'>
				 CBU Destino(*):
			</td>
			<td> 
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
			</td>			
		</tr>
	</table>	

</form>
</center>

<script type="text/javascript">

	var fecha_emision_default = '{fecha_emision_default}';
	var fecha_pago_default = '{fecha_pago_default}';

	function issuance_payment_values(){
		
		var ERROR = '';
		
		ERROR = checkFormCheques();
		
		if(ERROR == ''){
			if(confirm("Desea Emitir Valor de Pago?")){
				
				xajax_issuance_payment_values(xajax.getFormValues('form_liquidaciones_comercios'));
			}					
		}else{
			alert('Han sucedido los siguientes errores: \n' + ERROR);
		}
		

	}
	
	function checkFormCheques(){
		var form = document.forms['form_liquidaciones_comercios'];
		var error = '';
		
		if(form.sNroCheque.value == ''){
			error = error + '-Campo Numero Cheque Obligatorio \n';			
		}
		
		if(form.dFechaEmision.value == ''){
			error = error + '-Campo Fecha Emision Obligatorio \n';			
		}
		
		if(form.dFechaPago.value == ''){
			error = error + '-Campo Fecha Pago Obligatorio \n';			
		}
		
		if(form.idBanco.value == 0){
			error = error + '-Campo Banco Obligatorio \n';			
		}
		
		if(form.fImporte.value == 0){
			error = error + '-Campo Importe Obligatorio \n';			
		}
		
		if(form.sCBUDestino.value == 0){
			error = error + '-Campo sCBU Destino Obligatorio \n';			
		}
		
		return error;
		
	}
	
	function resetForm(){
		var form = document.forms['form_liquidaciones_comercios'];
		
		
		form.sNroCheque.value = '';
		
		//form.dFechaEmision.value = '';
		
		//form.dFechaPago.value = '';
		
		form.idBanco.value = 0;
		
		form.fImporte.value = 0;
		
		form.sCBUDestino.value = 0;
		
	}
	
	

</script>