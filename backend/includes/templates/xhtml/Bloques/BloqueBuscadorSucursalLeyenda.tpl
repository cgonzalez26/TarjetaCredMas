<center>
	<form action="SucursalesLeyenda.php" method="POST" >
	<input type="hidden" name="condic" value="Sucursales.sNombre">
		<table  class='formulario'  style="width:450px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> <th colspan="2" class="cabecera"> Sucursales </th> </tr>
		  <tr>
			 <th width="30" height="30" align="right"style="width:130px">Nombre: &nbsp;</th>
			 <td height="30"><input type="text" name="sNombreSucursal" id="sNombreSucursal" maxlength="10" value='{sNombreSucursal}'></td> 
		  </tr>
		  <tr>
		  	 <th width="30" height="30" align="right"style="width:130px">Region: &nbsp;</th>
		  	 <td height="30">
		  	 	<select id="idRegionSucursal" name="idRegionSucursal">
		  	 	{optionsRegiones}
		  	 	</select>
		  	 </td>
		  </tr>
		  <tr>
		  	 <th width="30" height="30" align="right"style="width:130px">Provincia: &nbsp;</th>
		  	 <td height="30">
		  	 	<select id="idProvinciaSucursal" name="idProvinciaSucursal">
		  	 	{optionsProvincias}
		  	 	</select>
		  	 </td>
		  </tr>
		  <tr>			
			 <td align="center" colspan="2">
			 	<span style="width: 50px !important;">
			 		&nbsp;
			 	</span>
			 	<button type='submit' name='buscar'> Buscar </button>			 	
			 </td>			
		 </tr>
		 <tr>
		 	<td colspan="2" align="center">
		 		<a href="../GruposAfinidades/ImpresionResumenes.php">Volver a Impresion de Resumenes</a>
		 	</td>
		 </tr>
		</table>
		<br>
	</form>
