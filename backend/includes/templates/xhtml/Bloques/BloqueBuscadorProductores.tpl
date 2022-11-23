<center>
	<form action="ProductoresLiderar.php" name="formBuscadorProductores" method="POST"  >

		<table  class='formulario'  style="width:450px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> <th colspan="4" class="cabecera"> Productores </th> </tr>
		  <tr>
			 <th width="30" height="30" align="right">Buscar: &nbsp;</th>
			 <td height="30"><input type="text" name="sBuscarProductores" id="sBuscarProductores" maxlength="10" value='{sBuscarProductores}'></td> 
			 <!--<th width="30" height="30" align="right">Por: &nbsp;</th>-->
			 <td height="30" colspan="2">
	      		<select  name="condicProductores">
                    <option value="Productores.sNombre">Nombre</option> 
                    <option value="Productores.sApellido">Apellido</option> 
    	        </select>
			 </td>
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		</tr>
		</table>
	</form>
