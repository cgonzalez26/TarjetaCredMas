<center>
	<form action="Oficinas.php" method="POST" >
		<table  class='formulario'  style="width:450px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> <th colspan="2" class="cabecera"> Oficinas </th> </tr>
		   <tr>
			 <th width="30" height="30" align="right"style="width:120px">Sucursal: &nbsp;</th>
			 <td height="30">
			 	<select id="idScursal" name="idSucursal">
			 		{OPTIONS_SUCURSALES}
			 	</select>
			 </td> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right"style="width:120px">Buscar Oficina: &nbsp;</th>
			 <td height="30"><input type="text" name="nombre_u" maxlength="10" value='{nombre_u}'></td> 
		  </tr>
		   <tr>
			 <th width="30" height="30" align="right"style="width:120px">Estado: &nbsp;</th>
			 <td height="30">
			 	<select id="sEstado" name="sEstado">
				 	<option id="sSeleccionar" value="-1">Seleccionar</option>
			 		<option id="sAlta" value="A">Alta</option>
			 		<option id="sBaja" value="B">Baja</option>
			 	</select>
			 </td> 
		  </tr>
		  <tr>			
			 <td align="center" colspan="2"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
			<td>
				<input type="hidden" name="condic" value="Oficinas.sApodo">
			</td>
		 </tr>
		</table>
	</form>
