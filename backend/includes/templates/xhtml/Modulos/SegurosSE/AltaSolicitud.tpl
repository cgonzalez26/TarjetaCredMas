<center>
	<div id='divBotonera' style='width:65%;text-align:right;margin-right:10px;'>
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Dar de Alta' border='0' hspace='4' align='absmiddle'> [F9] Guardar</a>
		&nbsp;&nbsp;			
	</div>
	<form id="formAltaSolicitud" action="AltaSolicitud.php" method="POST">
	 	<input type='hidden' name='idSolicitud' id="idSolicitud" value='{ID_SOLICITUD}' />
	 	<input type='hidden' name='hdnIdBIN' id="hdnIdBIN" value='{ID_BIN}' />
	 	<input type='hidden' name='sNumero' id="sNumero" value='{NUMERO_SOLICITUD}' />
	 	
	 	<input type='hidden' name='hdnLimiteCompra' id="hdnLimiteCompra" value='0' />
	 	<input type='hidden' name='hdnLimiteCredito' id="hdnLimiteCredito" value='0' />
	 	<input type='hidden' name='hdnLimiteFinanciacion' id="hdnLimiteFinanciacion" value='0' />
	 	<input type='hidden' name='hdnLimiteAdelanto' id="hdnLimiteAdelanto" value='0' />
	 	<input type='hidden' name='hdnLimitePrestamo' id="hdnLimitePrestamo" value='0' />
	 	<input type='hidden' name='hdnLimiteSMS' id="hdnLimiteSMS" value='0' />
	 	<input type='hidden' name='hdnLimiteGlobal' id="hdnLimiteGlobal" value='0' />
	 	<input type='hidden' name='hdnFechaCierre' id="hdnFechaCierre" value='0' />
	 	<input type='hidden' name='hdnFechaVencimiento' id="hdnFechaVencimiento" value='0' />
	 	<input type='hidden' name='hdnPeriodo' id="hdnPeriodo" value='0' />
	 	<input type='hidden' name='hdnFechaMora' id="hdnFechaMora" value='' />
	 	
	 	<input type='hidden' name='hdnTasaPunitorioPeso' id="hdnTasaPunitorioPeso" value='0' />
	 	<input type='hidden' name='hdnTasaFinanciacionPeso' id="hdnTasaFinanciacionPeso" value='0' />
	 	<input type='hidden' name='hdnTasaCompensatorioPeso' id="hdnTasaCompensatorioPeso" value='0' />
	 	<input type='hidden' name='hdnTasaFinanciacionDolar' id="hdnTasaFinanciacionDolar" value='0' />
	 	<input type='hidden' name='hdnTasaPunitorioDolar' id="hdnTasaPunitorioDolar" value='0' />
	 	<input type='hidden' name='hdnTasaCompensacionDolar' id="hdnTasaCompensacionDolar" value='0' />
	 	<input type='hidden' name='hdnTasaSobreMargen' id="hdnPorcentajeSobreMargen" value='0' />
	 	
	 	
	 	<input type='hidden' name='sPci' id="sPci" value='{sPci}' />
	 	<input type='hidden' name='sCadenaAll' id="sCadenaAll" value='{sCadenaAll}' />
	 	
	 	
	 	
		<fieldset id='cuadroOficina' style="height:350px;width:900px">
		<legend> Datos de la nueva Cuenta</legend>	
		    <table>
			  <tr> <th id="sMensajeMas" style="Color:red;font-family:Verdana;font-size:10pt;"></th></tr>
			</table>
			<table id='TablaCanal' cellpadding="0" cellspacing="0" class="TablaGeneral" width="920px" border="0">
			<tr>
			<td valign="top">
				<table id='TablaCanal' cellpadding="0" cellspacing="5" class="TablaGeneral" style="width:630px">
				<tr>
					<td align="left"> <b>(*)Grupo Afinidad: </b></td>
				</tr>
				<tr>
					<td> 
						<select id="idGrupoAfinidad" name="idGrupoAfinidad" style="width:200px" onchange="mostrarCalendario(this.value)">
						{optionsGruposAfinidades}
						</select>
					</td>
				</tr>
				<tr>
					<td><div id="divCalendario"></div></td>
				</tr>
				</table>
			</td>		
			<td valign="top">
				<table id='TablaCanal' cellpadding="0" cellspacing="5" class="TablaGeneral" width="300px" border="0">
				<tr>
					<td align="left" colspan="5"> <b>(*)Limite: </b></td>
				</tr>
				<tr>
					<td colspan="5"> 
						<select id="idLimite" name="idLimite" style="width:250px" onchange="mostrarLimite(this.value)">
						{optionsLimites}
						</select>
					</td>
				</tr>
				<tr>
					<th > Limite de Compra:</th>
					<td colspan="3"> <span id="lbliLimiteCompra" name="lbliLimiteCompra"></span></td>
				</tr>
				<tr>
					<th> Limite de Credito:</th>
					<td colspan="3"> <span id="lbliLimiteCredito" name="lbliLimiteCredito"></span></td>
				</tr>
				<tr>	
					<th> Limite de Financiacion:</th>
					<td style="width:20px"><span id="lbliLimitePorcentajeFinanciacion" name="lbliLimitePorcentajeFinanciacion"></span></td>
					<td style="width:10px">%</td>
					<td style="width:50px"><span id="lblLimiteFinanciacion">{LIMITE_FINANCIACION}</span></td>
				</tr>
				<tr>
					<th> Limite de Prestamo:</th>
					<td><span id="lbliLimitePorcentajePrestamo" name="lbliLimitePorcentajePrestamo"></span></td>
					<td>%</td>
					<td><span id="lblLimitePrestamo">{LIMITE_PRESTAMO}</span></td>
				</tr>
				<tr>	
					<th> Limite de Adelanto:</th>
					<td><span id="lbliLimitePorcentajeAdelanto" name="lbliLimitePorcentajeAdelanto" ></span></td>
					<td>%</td>
					<td><span id="lblLimiteAdelanto">{LIMITE_ADELANTO}</span></td>
				</tr>	
				<tr>	
					<th> Limite de SMS:</th>
					<td><span id="lbliLimitePorcentajeSMS" name="lbliLimitePorcentajeSMS"></span></td>
					<td>%</td>
					<td><span id="lblLimiteSMS">{LIMITE_SMS}</span></td>
				</tr>	
				<tr>
					<th> Limite de Global:</th>
					<td colspan="3"> <span id="lbliLimiteGlobal" name="lbliLimiteGlobal" value='{LIMITE_GLOBAL}' ></span></td>
				</tr>
				</table>
			</td>
			
			</tr>
			</table>	
			<table>
			  <tr> <th> Cuotas </th> <td> <select name="idPlanComercio" id="idPlanComercio" > 
			                               <option value="0"> Seleccionar.. </option> 
			                               {_OPTION_PLANES_} 
			                               </select> </td> </tr>
			</table>
			
		</fieldset>
	</form>
<script>
function mostrarLimite(idLimite){
	xajax_mostrarLimite(idLimite);
}

function mostrarCalendario(idGrupoAfinidad){
	xajax_mostrarCalendarioPorGrupoAfinidad(idGrupoAfinidad);
}

function saveDatos(){
	var Formu = document.forms['formAltaSolicitud'];
		
	if(validarDatosForm(Formu))
	{		
		if(confirm('Esta seguro de realizar esta operacion?'))
		{		
			CargandoLex('divBotonera','Procesando...');
			xajax_altaSolicitudSeguros(xajax.getFormValues('formAltaSolicitud'));
		}	
	}		
}

function validarDatosForm() 
{
	var Formu = document.forms['formAltaSolicitud'];
	var errores = '';
	 
	with (Formu)
	{
		if( idGrupoAfinidad.value == 0 )	
		errores += "- El campo Grupo Afinidad es requerido.\n";
		
		if( idLimite.value == 0 )	
		errores += "- El campo Limite es requerido.\n";		
		
		if (idPlanComercio.value == 0) 
		   errores += "- El cuota es requerido.\n";		
	}
	if( errores ) { alert(errores); return false; } 
	else return true;
}
</script>	