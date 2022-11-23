<center>
	<form action="{FORM_BACK}" method="POST" >

		<table  class='formulario'  style="width:550px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="4" class="cabecera"> Tarjetas de Creditos de Usuarios </th> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right" style="width:130px">Nro. de Cuenta: &nbsp;</th>
			 <td height="30"><input type="text" name="sNumeroCuentaTarjeta" id="sNumeroCuentaTarjeta" maxlength="16" value='{sNumeroCuentaTarjeta}'></td> 
			 <th align="right">Nro. de Tarjeta:</th>
			 <td height="30"><input type="text" name="sNumeroTarjeta" id="sNumeroTarjeta" maxlength="16" value='{sNumeroTarjeta}'></td> 
		  </tr>
		  <tr>
		  	<th align="right">Tipo Documento:</th>
		  	<th><select id="idTipoDocumentoTarjeta" name="idTipoDocumentoTarjeta" class="FormTextBox">
					{optionsTipoDoc}
				</select>
			</th>
		  	<th align="right">Nro. Documento:</th>
		  	<th><input type="text" name="sDocumentoTarjeta" id="sDocumentoTarjeta" value='{sDocumentoTarjeta}'></th>
		  </tr>
		  <tr>
		  	<th align="right">Apellido del Titular:</th>
		  	<th><input type="text" name="sApellidoTarjeta" id="sApellidoTarjeta" value='{sApellidoTarjeta}'></th>
		  	<th align="right">Nombres del Titular:</th>
		  	<th><input type="text" name="sNombreTarjeta" id="sNombreTarjeta" value='{sNombreTarjeta}'></th>
		  </tr>
		  <tr>
		  	<th align="right">Estado:</th>
		  	<td colspan="3">
		  		<select id="idTipoEstadoTarjeta" name="idTipoEstadoTarjeta" style="width:250px">
		  		{optionsTipoEstadoTarjeta}
		  		</select>
		  	</td>
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>