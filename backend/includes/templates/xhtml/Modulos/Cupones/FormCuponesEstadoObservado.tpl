<form action="#" method="GET" name="formMarcarCuponObservado" id="formMarcarCuponObservado">
<table align="center" style="font-size:11px;" width="500"> 
	<tr>
		<td style=""> 
			<img src='{IMAGES_DIR}/searchPopin.png' alt='Cerrar' title='Cerrar' border='0' align="absmiddle">&nbsp;ESTABLECER OBSERVACION
		</td>
	</tr>
	<tr>
		<td align="left">
			<div style="font-family:Tahoma;font-size:14px;">Nro. Cupon: {NroCupon}</div>
		</td>
	</tr>
	<tr>
		<td align="left">
			<textarea name='sObservaciones' id='sObservaciones' style='width:510px;height:100px;'></textarea>
		</td>
	</tr>
	<tr>
		<td align="center">
			<input type="button" name="cmd_aceptar" id="cmd_aceptar" value="marcar como observado" style="padding:5px;" onclick="_marcarCuponesObservado_();"> 
			<input id="_i" name="_i" type="hidden" class="FormTextBox" style="width:50px;" value="{_i}">
		</td>
	</tr>
	<tr>
		<td align="center">
			<div id='message_operation'><div>
		</td>
	</tr>	
<table>
</form>

<script type="text/javascript">

	function _imageLoading_(_div_){
		
		document.getElementById(_div_).innerHTML = "<img src='../includes/images/ajax-loader.gif' title='buscando' hspace='4'> procesando...";
		
	}

	function _marcarCuponesObservado_(){
		
		var Formu = document.forms['formMarcarCuponObservado'];
		
		if(Formu.sObservaciones.value != ''){
			if(confirm("Esta seguro de marcar como observado el cupon: '{NroCupon}' ?")){
				_imageLoading_('message_operation');
				xajax_marcarCuponesObservado(xajax.getFormValues('formMarcarCuponObservado'));
			}			
		}else{
			alert('Debe ingresar motivo por el cual se cambia a estado observado el cupon');
		}

	}

</script>