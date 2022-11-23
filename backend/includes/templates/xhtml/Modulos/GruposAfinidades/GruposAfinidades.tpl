<body style="background-color:#FFFFFF">
<center>
	<div id='' style='width:860px;text-align:right;'>
	    <img src='{IMAGES_DIR}/back.png' title='Buscar Grupo' alt='Buscar Grupo' border='0' hspace='4' align='absmiddle'> 
		<a href="../.Log/_LogMorosidad.php" style='text-decoration:none;font-weight:bold;'>Log. Morosidad</a> 
		{btn_morosidad}
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Grupo' border='0' hspace='4' align='absmiddle'> 
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo' alt='Nuevo' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<div id="botonCalendarios" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/Calendar.png' title='Calendarios' alt='Calendarios' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:MostrarCalendario();' style='text-decoration:none;font-weight:bold'>Calendarios</a>
			&nbsp;&nbsp;			
		</div>
		<img src='{IMAGES_DIR}/back.png' title='Buscar Grupo' alt='Buscar Grupo' border='0' hspace='4' align='absmiddle'> 
		<a href="GruposAfinidades.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
	
	<div id="resultado_morosidad" style="width:40%;text-align:left;">
	
	</div>
	<form id="formGrupo" action="AdminGruposAfinidades.php" method="POST">
		<input type="hidden" id="idGrupoAfinidad" name="idGrupoAfinidad" value="{ID_GRUPO_AFINIDAD}" />
		<input type="hidden" id="sEstado" name="sEstado" value="{ESTADO}" />
		
		<fieldset id='cuadroOficina' style="height:160px;width:860px">
			<legend> Datos del Grupo</legend>			
			<table id='TablaGrupoAfinidad' cellpadding="0" cellspacing="5" class="TablaGeneral" width="100%">
			<tr>
				<th> BIN: </th>
				<td> 
					<select name='idBin' id='idBin' style='width:200px;'>
					{OPTIONS_MULTIBIN}					
					</select> <sup>*</sup>
				</td>
				<th> Nombre: </th>
				<td class='borde'> <input id="sNombre" name="sNombre" value='{NOMBRE}' type='text' style='width:200px;'/> <sup>*</sup> </td>
			</tr>
			<tr>
		   		<th>Costo Renovaci&oacute;n:</th>
		    	<td><input type='text' id="fCostoRenovacion" name='fCostoRenovacion' onblur="this.value=numero_parse_flotante(this.value);" value='{COSTO_RENOVACION}' style='width:200px;'/> <sup>*</sup></td>	    
		    	<th>Cuotas Renovaci&oacute;n:</th>
		    	<td><input type='text' id="iCuotasRenovacion" name='iCuotasRenovacion' onblur="this.value=numero_parse_entero(this.value);" value='{CUOTAS_RENOVACION}' style='width:200px;'/> <sup>*</sup>		    	
		    	</td>  
			</tr>
			<tr>
		   		<th>Tasa Sobre Margen:</th>
		    	<td><input type='text' id="fTasaSobreMargen" name='fTasaSobreMargen' onblur="this.value=numero_parse_flotante(this.value);" value='{TASA_SOBRE_MARGEN}' style='width:200px;'/> <sup>*</sup></td>	    
		    	<th>Tasa Coeficiente Financiacion:</th>
		    	<td>
		    		<input type='text' id="fTasaCoeficienteFinanciacion" name='fTasaCoeficienteFinanciacion' onblur="this.value=numero_parse_flotante(this.value);" value='{TASA_COEFICIENTE_FINANCIACION}' 
					style='width:200px;'/> 
		    		<sup>*</sup>		    	
		    	</td>  
			</tr>
			<tr>
		   		<th>Nro. Modelo Resumen:</th>
		    	<td>
		    	  <input type='text' id="iNumeroModeloResumen" name='iNumeroModeloResumen' onblur="this.value=numero_parse_entero(this.value);" value='{NUMERO_MODELO_RESUMEN}' style='width:200px;'/>
		    	  <!--<select >  </select>-->
		        <sup>*</sup>
		    </td>	    		    				
		    <td colspan="2"></td>
			</tr>
			</table>
		</fieldset>
	</form>
</center>
</body>

<script type='text/javascript'>	

	var gsMensajeFechaVencimiento = "";
	var gsMensajeFechaCierre = "";

	//InputMask("dFechaCierre","99/99/9999");
	//InputMask("dFechaVencimiento","99/99/9999");

	
	
	function MostrarCalendario()
	{
		var idGrupoAfinidad = document.getElementById("idGrupoAfinidad").value;
		var sNombre = document.getElementById("sNombre").value;
		
		if(idGrupoAfinidad == 0)
		{
			alert("Debe seleccionar un Grupo para poder ver sus calendarios");
			return;
		}
		
		window.location ="../CalendariosFacturaciones/CalendariosFacturaciones.php?idGrupoAfinidad="+ idGrupoAfinidad + "&sNombre=" + sNombre;		
	}
	
	/*function reemplazaar()
	{
		Formu.fPorcentajeCompraPeso.replace(",", ".");
		Formu.fPorcentajeCreditoPeso.replace(",", ".");
		Formu.fPorcentajeFinanciacionPeso.replace(",", ".");
		Formu.fPorcentajeAdelantoPeso.replace(",", ".");
		Formu.fPorcentajePrestamo.replace(",", ".");
		Formu.fPorcentajeSMS.replace(",", ".");
		Formu.fPorcentajeSobreMargen.replace(",", ".");
		Formu.fCostoRenovacion.replace(",", ".");
		Formu.fPorcentajeCompraDolar.replace(",", ".");
	}*/
	
	
	
	
	
	function saveDatos()
	{
		var Formu = document.forms['formGrupo'];
		
		if(validarDatosForm(Formu))
		{		
			if(confirm('Esta seguro de realizar esta operacion?'))
			{		
				reemplazar();
				xajax_updateDatosGrupoAfinidad(xajax.getFormValues('formGrupo'));
			}	
		}		
	}

	
	function validarDatosForm() 
	{
		var Formu = document.forms['formGrupo'];
		var errores = '';
		 
		with (Formu)
		{
			//if( idTipoAfinidad.value == 0 )	
			//errores += "- El campo Afinidad es requerido.\n";
			
			//if( idBin.value == 0 )	
			//errores += "- El campo BIN es requerido.\n";
			
			if( !trim(sNombre.value) )
			errores += "- El campo Nombre es requerido.\n";			
			
			if( !trim(fCostoRenovacion.value) )
			errores += "- El campo Costo Renovacion es requerido.\n";
						
			//if(fCostoRenovacion.value == 0)
			//errores += "- Valor invalido para el campo Costo Renovacion.\n";			
			
			if( !trim(iCuotasRenovacion.value) )
			errores += "- El campo Cuotas Renovacion es requerido.\n";
			
			//if(iCuotasRenovacion.value == 0)
			//errores += "- Valor invalido para el campo Cuotas Renovacion.\n";
			
	
			//if( !trim(fPorcentajeCompraDolar.value) )
			//errores += "- El campo Porcentaje Compra Dolar es requerido.\n";
		
			//if(fPorcentajeCompraDolar.value == 0)
			//errores += "- Valor invalido para el campo Porc. Compra Dolar.\n";
			
						
			if( !trim(iNumeroModeloResumen.value) )
			errores += "- El campo Numero Modelo Resumen es requerido.\n";
			
			//if(iNumeroModeloResumen.value == 0)
			//errores += "- Valor invalido para el campo Numero Modelo Resumen.\n";
		
			if( !trim(fTasaSobreMargen.value) )
			errores += "- El campo Tasa Sobre Margen es requerido.\n";
			
			//if(fTasaSobreMargen.value == 0)
			//errores += "- Valor invalido para el campo Tasa Sobre Margen.\n";
		
			if( !trim(fTasaCoeficienteFinanciacion.value) )
			errores += "- El campo Tasa Coeficiente Financiacion es requerido.\n";
			
			//if(fTasaCoeficienteFinanciacion.value == 0)
			//errores += "- Valor invalido para el campo Tasa Coeficiente Financiacion.\n";
		}
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	
	function resetDatosForm()
	{
		var Formu = document.forms['formGrupo'];
		
		Formu.idGrupoAfinidad.value = 0;
		//Formu.idTipoAfinidad.value = 0;
		Formu.idBin.value = 0;
		//Formu.idTipoAfinidad.value = "";
		Formu.idBin.value = "";
		Formu.sNombre.value = "";
		/*Formu.fPorcentajeCompraPeso.value = "";
		Formu.fPorcentajeCreditoPeso.value = "";
		Formu.fPorcentajeFinanciacionPeso.value = "";
		Formu.fPorcentajeAdelantoPeso.value = "";
		Formu.fPorcentajePrestamo.value = "";
		Formu.fPorcentajeSMS.value = "";
		Formu.dFechaCierre.value = "";
		Formu.dFechaVencimiento.value = "";
		Formu.fPorcentajeSobreMargen.value = "";*/
		Formu.fCostoRenovacion.value = "";
		Formu.iCuotasRenovacion.value = "";
		/*Formu.iDiasMoroso.value = "";
		Formu.iDiasInhabilitado.value = "";
		Formu.iDiasPrevisionado.value = "";
		Formu.fPorcentajeCompraDolar.value = "";*/
		Formu.iNumeroModeloResumen.value = "";
		Formu.fTasaSobreMargen.value = "";
		Formu.fTasaCoeficienteFinanciacion.value = "";
	}
	
	function _imageLoading_(){
		
		document.getElementById('resultado_morosidad').innerHTML = "<img src='{IMAGES_DIR}/ajax-loader.gif' title='buscando' hspace='4'> corriendo proceso de morosidad, espere un momento...";
		
	}

	
	function proccessMorosidadUsuarios(_i){
		
		var ok = confirm('Esta seguro de ejecutar proceso de morosidad?');
		
		if(ok){
			_imageLoading_();
			
			var _valor = prompt("Ingrese el importe Minimo : "," ");
			
			xajax_proccessMorosidadUsuarios(_i,_valor);
			//xajax__morosidadUsuarios(_i);
		}
	}

</script>
