<style>
.table_object {
    font-family: Tahoma,Times New Roman;
    text-align: center;
}

.table_object th {
    background: url("../includes/images/bc_bg.png") repeat-x scroll 50% 50% #F5F5F5;
    border-bottom: 1px solid #CCCCCC !important;
    border-left: 1px solid #CCCCCC !important;
    border-top: 1px solid #CCCCCC !important;
    border-right: 0px solid #CCCCCC !important;
    color: #911E79;
    font-family: Arial;
    font-size: 11px;
    height: 30px;
    line-height: 30px;
    margin: 0;
    padding: 0;
    text-align: center;
}

.table_object td {
    border-bottom: 1px solid #CCCCCC;
    border-left: 1px solid #CCCCCC;
    font-size: 11px;
    height: 25px;
    line-height: 25px;
    padding: 2px;
}
</style>
<center>

<div style="width:700px;">
	<div id='' style='width:700px;text-align:right;'>
		<a href="{url_back}" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='regresar' alt='regresar' border='0' hspace='4' align='absmiddle'> Volver
		</a>
	</div>
</div>


<table cellpadding="0" cellspacing="0" width="700" border="0" align="center" class="TablaGeneral">
<tr>
	<td valign="top" style="padding-top:20px">
		{table_detalles_cupones}
	</td>
</tr>
</table>

</center>
<script>

	var _importeCuota = {fImporte};
	var contador_cuotas = {contador_cuotas};

	function adelantarCuotas(){
		var Formu = document.forms['form_detalles_cupones'];
		var cantidadCuotasEstablecidas = parseInt(Formu.iCantidadCuotas.value);
		var montoTotal = _importeCuota * cantidadCuotasEstablecidas;
		
		if(cantidadCuotasEstablecidas <= contador_cuotas){
			var ok = confirm('Monto Total a Pagar: ' + montoTotal + '\n Esta seguro de realizar esta accion?');
		
			if(ok){
				xajax_adelantarCuotas(xajax.getFormValues('form_detalles_cupones'));
			}		
		}else{
			alert('La cantidad Maxima de cuotas que puede adelantar es ' + contador_cuotas);
		}
		

	

	}



</script>