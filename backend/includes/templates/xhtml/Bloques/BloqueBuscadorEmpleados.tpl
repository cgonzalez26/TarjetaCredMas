<center>
	<form action="Empleados.php" name="formBuscadorEmpleados" method="POST"  >

		<table  class='formulario'  style="width:450px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> <th colspan="4" class="cabecera"> Empleados </th> </tr>
		  <tr>
			 <th width="30" height="30" align="right">Buscar: &nbsp;</th>
			 <td height="30"><input type="text" name="nombre_u" maxlength="10" value='{nombre_u}'></td> 
			 <!--<th width="30" height="30" align="right">Por: &nbsp;</th>-->
			 <td height="30" colspan="2">
	      		<select  name="condic"">
                    <option value="Empleados.sNombre">Nombre</option> 
                    <option value="Empleados.sApellido">Apellido</option> 
					<option value="Empleados.sMail">E-mail</option> 
					<option value="Empleados.sLogin" selected>Login</option> 
					<option value="Oficinas.sApodo">Oficina</option> 
					<option value="Sucursales.sNombre">Sucursal</option> 
    	        </select>
			 </td>
		  </tr>
		   <tr>
		   <th width="30" height="30" align="right">Estado: &nbsp;</th>
		  	<td>
		  		<select id="sEstado" name="sEstado">
		  			<option id="sTodos" value="T">TODOS</option>
		  			<option id="sAlta" value="A">ALTA</option>
		  			<option id="sBaja" value="B">BAJA</option>
		  		</select>
		  	</td>
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		</tr>
		</table>
	</form>
