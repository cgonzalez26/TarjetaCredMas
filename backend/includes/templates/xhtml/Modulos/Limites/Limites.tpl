<center>
	<div id='' style='width:75%;text-align:right;margin-right:10px'>
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Limite' border='0' hspace='4' align='absmiddle'> [F9] Guardar</a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Limite' alt='Nuevo Limite' border='0' hspace='4' align='absmiddle'> Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<a href="Limites.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='Buscar Limites' alt='Buscar Limites' border='0' hspace='4' align='absmiddle'> Volver</a>
	</div>
	<form id="formLimite" action="AdminLimites.php" method="POST">
	
		<input type="hidden" id="idLimite" name="idLimite" value="{ID_LIMITE}" />
		<input type="hidden" id="sEstado" name="sEstado" value="{ESTADO}" />
		<input type="hidden" id="iLimiteFinanciacion" name="iLimiteFinanciacion" value="{LIMITE_FINANCIACION}" />
		<input type="hidden" id="iLimitePrestamo" name="iLimitePrestamo" value="{LIMITE_PRESTAMO}" />
		<input type="hidden" id="iLimiteAdelanto" name="iLimiteAdelanto" value="{LIMITE_ADELANTO}" />
		
		<fieldset id='cuadroOficina' style="height:350px;width:650px">
			<legend> Datos del Limite</legend>			
			<table id='TablaCanal' cellpadding="0" cellspacing="5" class="TablaGeneral" width="650px">
			<tr>
				<th> Codigo: </th>
				<td> 
					<input id="sCodigo" name="sCodigo" value='{CODIGO}' type='text' style='width:200px;' readonly='readonly' />
				</td>
			</tr>
			<tr>
				<th> Descripcion: </th>
				<td class='borde'> <input id="sDescripcion" name="sDescripcion" value='{DESCRIPCION}' type='text' style='width:400px;' onKeyUp="aMayusculas(this.value,this.id)"/> <sup>*</sup> </td>
			</tr>
			<tr>
				<th> Limite de Compra:</th>
				<td> <input id="iLimiteCompra" name="iLimiteCompra" value='{LIMITE_COMPRA}' type='text' style='width:200px;' onKeyUp="this.value=numero_parse_entero(this.value)" onblur="calcularLimiteGlobal(true)"/> <sup>*</sup>&nbsp;&nbsp;Limite en 1 Pago</td>
			</tr>
			<tr>
				<th> Limite de Credito:</th>
				<td> <input id="iLimiteCredito" name="iLimiteCredito" value='{LIMITE_CREDITO}' type='text' style='width:200px;' onKeyUp="this.value=numero_parse_entero(this.value)" onblur="calcularLimiteGlobal(false)"/> <sup>*</sup>&nbsp;&nbsp;Limite en Cuotas</td>
			</tr>
			<tr>	
				<th> Limite de Financiacion:</th>
				<td> <input id="iLimitePorcentajeFinanciacion" name="iLimitePorcentajeFinanciacion" value='{LIMITE_PORCENTAJE_FINANCIACION}' type='text' style='width:80px;' onKeyUp="this.value=numero_parse_entero(this.value)" onblur="calcularLimite(this.value,'lblLimiteFinanciacion','iLimiteFinanciacion')"/> %
				<span id="lblLimiteFinanciacion">{LIMITE_FINANCIACION}</span></td>
			</tr>
			<tr>
				<th> Limite de Prestamo:</th>
				<td> <input id="iLimitePorcentajePrestamo" name="iLimitePorcentajePrestamo" value='{LIMITE_PORCENTAJE_PRESTAMO}' type='text' style='width:80px;' onKeyUp="this.value=numero_parse_entero(this.value)" onblur="calcularLimite(this.value,'lblLimitePrestamo','iLimitePrestamo')"/> %
				<span id="lblLimitePrestamo">{LIMITE_PRESTAMO}</span></td>
			</tr>
			<tr>	
				<th> Limite de Adelanto:</th>
				<td> <input id="iLimitePorcentajeAdelanto" name="iLimitePorcentajeAdelanto" value='{LIMITE_PORCENTAJE_ADELANTO}' type='text' style='width:80px;' onKeyUp="this.value=numero_parse_entero(this.value)" onblur="calcularLimite(this.value,'lblLimiteAdelanto','iLimiteAdelanto')"/> %
				<span id="lblLimiteAdelanto">{LIMITE_ADELANTO}</span></td>
			</tr>	
			<tr>
				<th> Limite de Global:</th>
				<td> <input id="iLimiteGlobal" name="iLimiteGlobal" value='{LIMITE_GLOBAL}' type='text' style='width:200px;' onKeyUp="this.value=numero_parse_entero(this.value)"/> <sup>*</sup></td>
			</tr>
			</table>
		</fieldset>
	</form>
</center>
<script>
	document.getElementById('sDescripcion').focus(); 
	
	function saveDatos(){
		var Formu = document.forms['formCanal'];
		if(validarDatosForm(Formu))
		{		
			if(confirm('Esta seguro de realizar esta operacion?'))
			{		
				xajax_updateDatosLimites(xajax.getFormValues('formLimite'));
			}	
		}		
	}

	
	function validarDatosForm(){
		var Formu = document.forms['formLimite'];
		var errores = '';
		 
		with (Formu){
			if(!trim(sDescripcion.value))
				errores += "- El campo Descripcion es requerido.\n";			
				
			if(!trim(iLimiteCompra.value))
				errores += "- El campo Limite de Compra es requerido.\n";			
				
			if(!trim(iLimiteCredito.value))
				errores += "- El campo Limite de Credito es requerido.\n";			
			
			if(!trim(iLimiteGlobal.value))
				errores += "- El campo Limite de Global es requerido.\n";					
		}		
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	function resetDatosForm(){
		window.location = "AdminLimites.php?action=new";
	}
	
	function calcularLimiteGlobal(cambioCompra){
		var iLimiteCredito = 0;
		var iLimiteCompra = 0;
		if(document.getElementById('iLimiteCredito').value != "") iLimiteCredito = parseInt(document.getElementById('iLimiteCredito').value);
		if(document.getElementById('iLimiteCompra').value != "") iLimiteCompra = parseInt(document.getElementById('iLimiteCompra').value);
		document.getElementById('iLimiteGlobal').value = iLimiteCompra+iLimiteCredito;
		
		if(cambioCompra){
			recalcularLimites();
		}
	}
	
	function calcularLimite(porcentaje,campo1,campo2){
		var iLimiteCompra = document.getElementById('iLimiteCompra').value;
		if(porcentaje != ""){
			document.getElementById(campo1).innerHTML = Math.round((parseFloat(porcentaje)/100) * parseFloat(iLimiteCompra));
			document.getElementById(campo2).value = Math.round((parseFloat(porcentaje)/100) * parseFloat(iLimiteCompra));
		}
	}
	
	function recalcularLimites(){
		var iLimiteCompra = parseInt(document.getElementById('iLimiteCompra').value);
		if(document.getElementById('iLimiteFinanciacion').value != ""){			
			document.getElementById('lblLimiteFinanciacion').innerHTML = Math.round((parseFloat(document.getElementById('iLimitePorcentajeFinanciacion').value)/100) * parseFloat(iLimiteCompra));
			document.getElementById('iLimiteFinanciacion').value = Math.round((parseFloat(document.getElementById('iLimitePorcentajeFinanciacion').value)/100) * parseFloat(iLimiteCompra));
		}
		if(document.getElementById('iLimitePrestamo').value != ""){			
			document.getElementById('lblLimitePrestamo').innerHTML = Math.round((parseFloat(document.getElementById('iLimitePorcentajePrestamo').value)/100) * parseFloat(iLimiteCompra));
			document.getElementById('iLimitePrestamo').value = Math.round((parseFloat(document.getElementById('iLimitePorcentajePrestamo').value)/100) * parseFloat(iLimiteCompra));
		}
		if(document.getElementById('iLimiteAdelanto').value != ""){			
			document.getElementById('lblLimiteAdelanto').innerHTML = Math.round((parseFloat(document.getElementById('iLimitePorcentajeAdelanto').value)/100) * parseFloat(iLimiteCompra));
			document.getElementById('iLimiteAdelanto').value = Math.round((parseFloat(document.getElementById('iLimitePorcentajeAdelanto').value)/100) * parseFloat(iLimiteCompra));
		}
	}
</script>
