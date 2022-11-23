<center>
	<form action="{FORM}" method="POST" >
		<table  class='formulario'  style="width:550px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="4" class="cabecera"> Comercios </th> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right" style="width:130px">Nro. Comercio: &nbsp;</th>
			 <td height="30"><input type="text" name="sNumero" id="sNumero" maxlength="9" value='{sNumero}'></td> 
			 <td colspan="2"></td>
		  </tr>
		  <tr>
		  	<th align="right">Razon Social:</th>
		  	<th><input type="text" name="sRazonSocial" id="sRazonSocial" value='{sRazonSocial}'></th>
		  	<th align="right">Nombre Fantasia:</th>
		  	<th><input type="text" name="sNombreFantasia" id="sNombreFantasia" value='{sNombreFantasia}'></th>
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>
</center>