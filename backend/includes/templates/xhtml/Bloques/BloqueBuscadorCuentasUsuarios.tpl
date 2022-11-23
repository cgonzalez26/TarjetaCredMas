<center>
	<form action="CuentasUsuarios.php" method="POST" >

		<table  class='formulario'  style="width:550px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="4" class="cabecera"> Cuentas de Usuarios </th> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right" style="width:130px">Nro. de Cuenta: &nbsp;</th>
			 <td height="30"><input type="text" name="sNumeroCuenta" id="sNumeroCuenta" maxlength="10" value='{sNumeroCuenta}'></td> 
			 <td colspan="2"></td>
		  </tr>
		  <tr>
		  	<th align="right">Tipo Documento:</th>
		  	<th><select id="idTipoDocumentoCuenta" name="idTipoDocumentoCuenta" class="FormTextBox">
					{optionsTipoDoc}
				</select>
			</th>
		  	<th align="right">Nro. Documento:</th>
		  	<th><input type="text" name="sDocumentoCuenta" id="sDocumentoCuenta" value='{sDocumentoCuenta}'></th>
		  </tr>
		  <tr>
		  	<th align="right">Apellido del Titular:</th>
		  	<th><input type="text" name="sApellidoCuenta" id="sApellidoCuenta" value='{sApellidoCuenta}'></th>
		  	<th align="right">Nombres del Titular:</th>
		  	<th><input type="text" name="sNombreCuenta" id="sNombreCuenta" value='{sNombreCuenta}'></th>
		  </tr>
		   <tr>
		 	 <th align="right"> Region: </th> 
			 <th width="30" height="30" align="right"style="width:130px">
			 	<select id="idRegionCuenta" name="idRegionCuenta">{optionsRegiones}</select>
			 </th>			
			 <th align="right"> Sucursal: </th> 
			 <td width="30" height="30" align="right"style="width:130px">
			 	<select id="idSucursalCuenta" name="idSucursalCuenta">{optionsSucursales}</select>
			 </td>
		  </tr>
		  <tr>
		  	 <th align="right"> Estados: </th> 
			 <th width="30" height="30" align="right"style="width:130px">
			 	<select id="idEstadoCuenta" name="idEstadoCuenta">{optionsEstadosCuentas}</select>
			 </th>
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>