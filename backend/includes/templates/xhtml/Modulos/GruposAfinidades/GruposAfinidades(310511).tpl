<body style="background-color:#FFFFFF">
<center>
	<div id='' style='width:75%;text-align:right;margin-right:10px;'>
		<img src='{IMAGES_DIR}/disk.png' title='Guardar' alt='Guardar Grupo' border='0' hspace='4' align='absmiddle'> 
		<a href='javascript:saveDatos();' style='text-decoration:none;font-weight:bold;' id='idGuardar'>[F9] Guardar </a>
		&nbsp;&nbsp;			
		<div id="botonNuevo" style="{DISPLAY_NUEVO}">
			<img src='{IMAGES_DIR}/newOrder.png' title='Nuevo Grupo' alt='Nuevo Grupo' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:resetDatosForm();' style='text-decoration:none;font-weight:bold'>Nuevo</a>
			&nbsp;&nbsp;			
		</div>
		<img src='{IMAGES_DIR}/back.png' title='Buscar Grupo' alt='Buscar Grupo' border='0' hspace='4' align='absmiddle'> 
		<a href="GruposAfinidades.php" style='text-decoration:none;font-weight:bold;'>Volver</a>
	</div>
	<form id="formGrupo" action="AdminGruposAfinidades.php" method="POST">
		<input type="hidden" id="idGrupoAfinidad" name="idGrupoAfinidad" value="{ID_GRUPO_AFINIDAD}" />
		<input type="hidden" id="sEstado" name="sEstado" value="{ESTADO}" />
		
		<fieldset id='cuadroOficina' style="height:350px;width:40%">
			<legend> Datos del Grupo</legend>			
			<table id='TableCustomer' cellpadding="0" cellspacing="5" class="TableCustomer" width="860px">
			<tr>
				<th class='borde'> Afinidad: </th>
				<td> 
					<select name='idTipoAfinidad' id='idTipoAfinidad' style='width:200px;'>
					{OPTIONS_AFINIDADES}
					</select> <sup>*</sup>
				</td>
				<th> BIN: </th>
				<td> 
					<select name='idBin' id='idBin' style='width:200px;'>
					{OPTIONS_MULTIBIN}					
					</select> <sup>*</sup>
				</td>
			</tr>
			<tr>
				<th class='borde'> Nombre: </th>
				<td class='borde'> <input id="sNombre" name="sNombre" value='{NOMBRE}' type='text'/> <sup>*</sup> </td>
				<th class='borde'> Porc. Compra Peso: </th>
				<td class='borde'> <input id="fPorcentajeCompraPeso" name="fPorcentajeCompraPeso" onblur="this.value=numero_parse_flotante(this.value);" value='{PORCENTAJE_COMPRA_PESO}' type='text'/> <sup>*</sup> </td>
			</tr>
			<tr>
		   		<th class='borde'>Porc. C&eacute;dito Peso:</th>
		    	<td><input type='text' id="fPorcentajeCreditoPeso" name='fPorcentajeCreditoPeso' onblur="this.value=numero_parse_flotante(this.value);" value='{PORCENTAJE_CREDITO_PESO}'/> <sup>*</sup></td>	    
		    	<th>Porc. financiaci&oacute; Peso:</th>
		    	<td class='borde'><input type='text' id="fPorcentajeFinanciacionPeso" name='fPorcentajeFinanciacionPeso' onblur="this.value=numero_parse_flotante(this.value);" value='{PORCENTAJE_FINANCIACION_PESO}'/> <sup>*</sup>		    	
		    	</td>  
			</tr>
			<tr>
		   		<th class='borde'>Porc. Adelanto Peso:</th>
		    	<td><input type='text' id="fPorcentajeAdelantoPeso" name='fPorcentajeAdelantoPeso' onblur="this.value=numero_parse_flotante(this.value);" value='{PORCENTAJE_ADELANTO_PESO}'/> <sup>*</sup></td>	  
		    	<th>Porc. Prestamo :</th>
		    	<td class='borde'><input type='text' id="fPorcentajePrestamo" name='fPorcentajePrestamo' onblur="this.value=numero_parse_flotante(this.value);" value='{PORCENTAJE_PRESTAMO}'/> <sup>*</sup>		  
		    	</td>  
			</tr>
			<tr>
		   		<th class='borde'>Porcentaje SMS:</th>
		    	<td><input type='text' id="fPorcentajeSMS" name='fPorcentajeSMS' onblur="this.value=numero_parse_flotante(this.value);" value='{PORCENTAJE_SMS}'/> <sup>*</sup></td>	    
		    	<th>Fecha cierre:</th>
		    	<td class='borde'><input type='text' id="dFechaCierre" name='dFechaCierre'  value='{FECHA_CIERRE}'/> <sup>*</sup>		    	
		    	</td>  
			</tr>
			<tr>
		   		<th class='borde'>Fecha Vencimiento:</th>
		    	<td><input type='text' id="dFechaVencimiento" name='dFechaVencimiento' value='{FECHA_VENCIMIENTO}'/> <sup>*</sup></td>	    
		    	<th>Porc. Sobre Margen:</th>
		    	<td class='borde'><input type='text' id="fPorcentajeSobreMargen" name='fPorcentajeSobreMargen' onblur="this.value=numero_parse_flotante(this.value);" value='{PORCENTAJE_SOBRE_MARGEN}'/> <sup>*</sup>
		    	</td>  
			</tr>
			<tr>
		   		<th class='borde'>Costo Renovaci&oacute;n:</th>
		    	<td><input type='text' id="fCostoRenovacion" name='fCostoRenovacion' onblur="this.value=numero_parse_flotante(this.value);" value='{COSTO_RENOVACION}'/> <sup>*</sup></td>	    
		    	<th>Cuotas Renovaci&oacute;n:</th>
		    	<td class='borde'><input type='text' id="iCuotasRenovacion" name='iCuotasRenovacion' onblur="this.value=numero_parse_entero(this.value);" value='{CUOTAS_RENOVACION}'/> <sup>*</sup>		    	
		    	</td>  
			</tr>
			<tr>
		   		<th class='borde'>D&iacute;as Moroso:</th>
		    	<td><input type='text' id="iDiasMoroso" name='iDiasMoroso'  onblur="this.value=numero_parse_entero(this.value);" value='{DIAS_MOROSO}'/> <sup>*</sup></td>	    
		    	<th>D&iacute;as Inhabilitado:</th>
		    	<td class='borde'><input type='text' id="iDiasInhabilitado" name='iDiasInhabilitado' onblur="this.value=numero_parse_entero(this.value);" value='{DIAS_INHABILITADO}'/> <sup>*</sup>		    	
		    	</td>  
			</tr>
			<tr>
		   		<th class='borde'>D&iacute;as previsionado:</th>
		    	<td><input type='text' id="iDiasPrevisionado" name='iDiasPrevisionado'  onblur="this.value=numero_parse_entero(this.value);" value='{DIAS_PREVISIONADO}'/> <sup>*</sup></td>	    
		    	<th>Porc. Compra Dolar:</th>
		    	<td class='borde'><input type='text' id="fPorcentajeCompraDolar" name='fPorcentajeCompraDolar' onblur="this.value=numero_parse_flotante(this.value);" value='{PORCENTAJE_COMPRA_DOLAR}'/> <sup>*</sup>		    	
		    	</td>  
			</tr>
			<tr>
		   		<th class='borde'>Nro. Modelo Resumen:</th>
		    	<td><input type='text' id="iNumeroModeloResumen" name='iNumeroModeloResumen' onblur="this.value=numero_parse_entero(this.value);" value='{NUMERO_MODELO_RESUMEN}'/> <sup>*</sup></td>	    		    				<td colspan="2"></td>
			</tr>
			</table>
		</fieldset>
		
		----------
		<table>
			<tr>
				<td>
					{TABLA_PERIODOS}						
				</td>
			</tr>
		</table>			
	</form>
</center>
</body>

<script type='text/javascript'>	

	InputMask("dFechaCierre","99/99/9999");
	InputMask("dFechaVencimiento","99/99/9999");

	function reemplazaar()
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
	}
	
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
			if( idTipoAfinidad.value == 0 )	
			errores += "- El campo Afinidad es requerido.\n";
			
			if( idBin.value == 0 )	
			errores += "- El campo BIN es requerido.\n";
			
			if( !trim(sNombre.value) )
			errores += "- El campo Nombre es requerido.\n";
		
			if( !trim(fPorcentajeCompraPeso.value) )			
			errores += "- El campo Porc. Compra peso es requerido.\n";
				
			if(fPorcentajeCompraPeso.value == 0)
			errores += "- Valor invalido para el campo Porc. Compra Peso.\n";
			
			
			if( !trim(fPorcentajeCreditoPeso.value) )
			errores += "- El campo Porc. Credito Peso es requerido.\n";
				
			if(fPorcentajeCreditoPeso.value == 0)
			errores += "- Valor invalido para el campo Porc. Credito Peso.\n";
			
					
			if( !trim(fPorcentajeFinanciacionPeso.value) )
			errores += "- El campo porc. Financiacion Peso es requerido.\n";
			
			if(fPorcentajeFinanciacionPeso.value == 0)
			errores += "- Valor invalido para el campo Porc. Financiacion.\n";
			
			
			if( !trim(fPorcentajeAdelantoPeso.value) )
			errores += "- El campo Porc. Adelanto Peso es requerido.\n";
			
			if(fPorcentajeAdelantoPeso.value == 0)
			errores += "- Valor invalido para el campo Porc. Adelanto Peso.\n";
			
			
			if( !trim(fPorcentajePrestamo.value) )
			errores += "- El campo Porc. Prestamo es requerido.\n";
			
			if(fPorcentajePrestamo.value == 0)
			errores += "- Valor invalido para el campo Porc. Prestamo.\n";
			
			
			if( !trim(fPorcentajeSMS.value) )
			errores += "- El campo Porcentaje SMS es requerido.\n";
			
			
			if(fPorcentajeSMS.value == 0)
			errores += "- Valor invalido para el campo Porc. SMS.\n";
			
			
			if( !trim(dFechaCierre.value))
			errores += "- El campo Fecha Cierre es requerido.\n";
		
			if( !trim(dFechaVencimiento.value) )
			errores += "- El campo Fecha Vencimiento es requerido.\n";
		
			
			if( !trim(fPorcentajeSobreMargen.value) )
			errores += "- El campo Porc. Sobre Margen es requerido.\n";
		
			if(fPorcentajeSobreMargen.value == 0)
			errores += "- Valor invalido para el campo Porc. Sobre Margen.\n";
						
			
			if( !trim(fCostoRenovacion.value) )
			errores += "- El campo Costo Renovacion es requerido.\n";
						
			if(fCostoRenovacion.value == 0)
			errores += "- Valor invalido para el campo Costo Renovacion.\n";
			
			
			
			if( !trim(iCuotasRenovacion.value) )
			errores += "- El campo Cuotas Renovacion es requerido.\n";
			
			if(iCuotasRenovacion.value == 0)
			errores += "- Valor invalido para el campo Cuotas Renovacion.\n";
			
			
			if( !trim(iDiasMoroso.value) )
			errores += "- El campo Dias Moroso es requerido.\n";
			
			if(iDiasMoroso.value == 0)
			errores += "- Valor invalido para el campo Dias Moroso.\n";
			
			
			if( !trim(iDiasInhabilitado.value) )
			errores += "- El campo Dias Inhabilitado es requerido.\n";
		
			if(iDiasInhabilitado.value == 0)
			errores += "- Valor invalido para el campo Dias Inhabilitado.\n";
			
			
			if( !trim(iDiasPrevisionado.value) )
			errores += "- El campo Dias Previsionados es requerido.\n";
			
			if(iDiasPrevisionado.value == 0)
			errores += "- Valor invalido para el campo Dias Previsionado.\n";
			
			
			if( !trim(fPorcentajeCompraDolar.value) )
			errores += "- El campo Porcentaje Compra Dolar es requerido.\n";
		
			if(fPorcentajeCompraDolar.value == 0)
			errores += "- Valor invalido para el campo Porc. Compra Dolar.\n";
			
						
			if( !trim(iNumeroModeloResumen.value) )
			errores += "- El campo Cuotas Renovacion es requerido.\n";
			
			if(iNumeroModeloResumen.value == 0)
			errores += "- Valor invalido para el campo Numero Modelo Resumen.\n";
		}
		if( errores ) { alert(errores); return false; } 
		else return true;
	}
	
	
	function resetDatosForm()
	{
		var Formu = document.forms['formGrupo'];
		
		Formu.idGrupoAfinidad.value = 0;
		Formu.idTipoAfinidad.value = 0;
		Formu.idBin.value = 0;
		Formu.idTipoAfinidad.value = "";
		Formu.idBin.value = "";
		Formu.sNombre.value = "";
		Formu.fPorcentajeCompraPeso.value = "";
		Formu.fPorcentajeCreditoPeso.value = "";
		Formu.fPorcentajeFinanciacionPeso.value = "";
		Formu.fPorcentajeAdelantoPeso.value = "";
		Formu.fPorcentajePrestamo.value = "";
		Formu.fPorcentajeSMS.value = "";
		Formu.dFechaCierre.value = "";
		Formu.dFechaVencimiento.value = "";
		Formu.fPorcentajeSobreMargen.value = ""; 
		Formu.fCostoRenovacion.value = "";
		Formu.iCuotasRenovacion.value = "";
		Formu.iDiasMoroso.value = "";
		Formu.iDiasInhabilitado.value = "";
		Formu.iDiasPrevisionado.value = "";
		Formu.fPorcentajeCompraDolar.value = "";
		Formu.iNumeroModeloResumen.value = "";
	}

	

</script>
