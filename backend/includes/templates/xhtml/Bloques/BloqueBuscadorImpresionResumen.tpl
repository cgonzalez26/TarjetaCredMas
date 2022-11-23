<center>
	<form action="ImpresionResumenes.php" method="POST" onsubmit="return validarDatosForm(this)">
	<input type='hidden' name='hdnIdGrupoAfinidad' id="hdnIdGrupoAfinidad" value='{ID_GRUPO_AFINIDAD}' />
	<input type='hidden' name='hdndPeriodo' id="hdndPeriodo" value='{PERIODO}' />
	
		<table  class='formulario'  style="width:600px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="5" border="0">
		  <tr> 
		  	 <th colspan="4" class="cabecera"> Impresion de Resumenes </th> 
		  </tr>
		  <tr>
		 	 <th> (*)Grupo Afinidad: </th> 
			 <th width="30" height="30" align="right" style="width:130px">
			 	<select id="idGrupoAfinidadImpresion" name="idGrupoAfinidadImpresion" onchange="xajax_cargarOptionsPeriodos(this.value)">{optionsGrupos}</select>
			 </th>			
			 <th> (*)Periodo Calendario: </th> 
			 <td width="30" height="30" align="right" style="width:130px" id="tdPeriodos">
			 	<select id="dPeriodoImpresion" name="dPeriodoImpresion">{optionsPeriodos}</select>
			 </td>
		  </tr>
		  <tr>
		 	 <th> Region: </th> 
			 <th width="30" height="30" align="right" style="width:130px">
			 	<select id="idRegionImpresion" name="idRegionImpresion">{optionsRegiones}</select>
			 </th>			
			 <th> Sucursal: </th> 
			 <td width="30" height="30" align="right" style="width:130px">
			 	<select id="idSucursalImpresion" name="idSucursalImpresion">{optionsSucursales}</select>
			 </td>
		  </tr>
		  <tr>			
			 <td align="center" colspan="2"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
			 <td colspan="2">&nbsp;
			 	<!--<a href="../../../Accesos/backend/Sucursales/SucursalesLeyenda.php">Configurar Leyenda para Resumen</a>-->
			 </td>
		 </tr>
		</table>
	</form>
</center>
<script>
{SCRIPT}

	function validarDatosForm(Formu) 
	{
		var errores = '';
		with (Formu)
		{
			if( idGrupoAfinidadImpresion.value == 0 )
			errores += "- El campo Grupo Afinidad es requerido.\n";			
			
			if( dPeriodoImpresion.value == 0 )
			errores += "- El campo Periodo Calendario es requerido.\n";						
		}
		if( errores ) { alert(errores); return false; } 
		else return true;
		
	}
</script>