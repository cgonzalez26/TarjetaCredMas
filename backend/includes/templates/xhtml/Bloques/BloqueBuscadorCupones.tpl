<center>
	<form action="{FORM}" method="POST" >
		<table  class='formulario'  style="width:550px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="4" class="cabecera"> {TituloBuscador} </th> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right" style="width:130px">Nro. Comercio: &nbsp;</th>
			 <td height="30"><input type="text" name="sNumeroComercio" id="sNumeroComercio" maxlength="9" value='{sNumeroComercio}'></td> 
		  	<th align="right">Nro. Cuenta Usuario:</th>
		  	<th><input type="text" name="sNumeroCuentaUsuario" id="sNumeroCuentaUsuario" value='{sNumeroCuentaUsuario}'></th>
		  </tr>
		  <tr>
		  	<!--<th align="right">Razon Social:</th>
		  	<th colspan="3"><input type="text" name="sRazonSocial" id="sRazonSocial" value='{sRazonSocial}'></th>-->
		  	<th align="right">Nombre Fantasia:</th>
		  	<th colspan="3"><input type="text" name="sNombreFantasia" id="sNombreFantasia" value='{sNombreFantasia}' style="width:400px;"></th>
		  </tr>
		  <tr>
		  	<th align="right">Apellido Titular:</th>
		  	<th><input type="text" name="sApellidoTitular" id="sApellidoTitular" value='{sApellidoTitular}'></th>
		  	<th align="right">Nombre Titular:</th>
		  	<th><input type="text" name="sNombreTitular" id="sNombreTitular" value='{sNombreTitular}'></th>
		  </tr>
	      <!--<tr>
		  	<th align="right">Nro. Cuenta Usuario:</th>
		  	<th><input type="text" name="sNumeroCuentaUsuario" id="sNumeroCuentaUsuario" value='{sNumeroCuentaUsuario}'></th>
		  	<th align="right">Nro. Tarjeta:</th>
		  	<th><input type="text" name="sNumeroTarjeta" id="sNumeroTarjeta" value='{sNumeroTarjeta}'></th>
		  </tr>-->
		  <tr>
		  	<th align="right">Consumo Desde:</th>
		  	<th><input type="text" name="dFechaConsumoDesde" id="dFechaConsumoDesde" value='{dFechaConsumoDesde}'></th>
		  	<th align="right">Consumo Hasta:</th>
		  	<th><input type="text" name="dFechaConsumoHasta" id="dFechaConsumoHasta" value='{dFechaConsumoHasta}'></th>
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>
</center>