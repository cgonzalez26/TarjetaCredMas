<center>
	<form action="{FORM}" method="POST" id="formBuscadorObjetos" >

		<table  class='formulario'  style="width:550px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="4" class="cabecera"> Objetos de Sistemas </th> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right" style="width:130px">Descripcion: &nbsp;</th>
			 <td height="30"><input type="text" name="sNombreObjeto" id="sNombreObjeto" maxlength="10" value='{sNombreObjeto}'></td> 
			 <td colspan="2"></td>
		  </tr>
		  <tr>
		  	<th align="right">Unidad de Negocio:</th>
		  	<th><select id="idUnidadNegocioObjeto" name="idUnidadNegocioObjeto" class="FormTextBox">
					{optionsUnidadesNegocios}
				</select>
			</th>
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>
