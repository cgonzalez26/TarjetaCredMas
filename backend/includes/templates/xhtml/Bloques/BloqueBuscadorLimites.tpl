<center>
	<form action="Limites.php" name="formBuscadorEmpleados" method="POST"  >

		<table  class='formulario'  style="width:450px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> <th colspan="4" class="cabecera"> Limites Estandares de Usuarios </th> </tr>
		  <tr>
			 <th width="30" height="30" align="right">Buscar: &nbsp;</th>
			 <td height="30"><input type="text" name="valorLimite" maxlength="10" value='{valorLimite}'></td> 
			 <!--<th width="30" height="30" align="right">Por: &nbsp;</th>-->
			 <td height="30" colspan="2">
	      		<select  name="condicLimite"">
                    <option value="LimitesEstandares.sCodigo">Codigo</option> 
                    <option value="LimitesEstandares.sdescripcion">Descripcion</option> 
					<option value="LimitesEstandares.iLimiteGlobal">Limite Global</option> 
    	        </select>
			 </td>
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		</tr>
		</table>
	</form>
