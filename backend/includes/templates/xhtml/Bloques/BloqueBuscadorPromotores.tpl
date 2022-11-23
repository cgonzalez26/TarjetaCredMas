<center>
	<form action="Promotores.php" method="POST" >

		<table  class='formulario'  style="width:550px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="4" class="cabecera"> Promotores de Ventas </th> 
		  </tr>		 
		  <tr>
		  	<th align="right">Apellido:</th>
		  	<th><input type="text" name="sApellidoPromotor" id="sApellidoPromotor" value='{sApellidoPromotor}'></th>
		  	<th align="right">Nombres:</th>
		  	<th><input type="text" name="sNombrePromotor" id="sNombrePromotor" value='{sNombrePromotor}'></th>
		  </tr>
		  
		  <tr>
		  	<th align="right">Sucursal:</th>
		  	<td>
		  		<select id="idSucursalPromotor" name="idSucursalPromotor" class="FormTextBox">
					{optionsSucursales}
				</select>
			</td>	
		  	<th align="right">Oficina:</th>
		  	<td>
		  		<select id="idOficinaPromotor" name="idOficinaPromotor" class="FormTextBox">
					{optionsOficinas}
				</select>
			</td>	
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>