<center>
	<form action="{FORM}" method="POST" >
		<table  class='formulario'  style="width:550px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		 <tr> 
		  	<th colspan="4" class="cabecera"> Ajustes de Usuarios </th> 
		  </tr>
		<tr>
		  	<th align="right">Nro. Cuenta:</th>
		  	<th><input type="text" name="sNroCuenta" id="sNroCuenta" value='{sNroCuenta}'></th>		  	
		</tr>   
		<tr>
		  	<th align="right">Apellido:</th>
		  	<th><input type="text" name="sApellido" id="sApellido" value='{sApellido}'></th>
		  	<th align="right">Nombres:</th>
		  	<th><input type="text" name="sNombre" id="sNombre" value='{sNombre}'></th>
		</tr>
		<tr>
		  	<th align="right">Tipo Ajuste:</th>
		  	<th><select id="idTipoAjuste" name="idTipoAjuste" class="FormTextBox">
					{OPTIONS_TIPOS_AJUSTES}
				</select>
			</th>
		</tr>
		<tr>
		  	<th align="right">Desde:</th>
		  	<th><input type="text" name="dFechaDesde" id="dFechaDesde" value='{dFechaDesde}'></th>
		  	<th align="right">Hasta:</th>
		  	<th><input type="text" name="dFechaHasta" id="dFechaHasta" value='{dFechaHasta}'></th>
		</tr>
		<tr>
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		</tr>
		</table>
	</form>
</center>
	
	<script type="text/javascript">
		InputMask('dFechaDesde','99/99/9999');
		InputMask('dFechaHasta','99/99/9999');
	</script>
