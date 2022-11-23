<center>
	<form action="CanalesVentas.php" method="POST" >
	
		<table  class='formulario'  style="width:450px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="2" class="cabecera"> Canales de Ventas </th> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right"style="width:130px">Codigo: &nbsp;</th>
			 <td height="30"><input type="text" id="sCodigo" name="sCodigo" maxlength="10" value='{sCodigo}'></td> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right"style="width:130px">Canal (nombre): &nbsp;</th>
			 <td height="30"><input type="text" id="sNombre" name="sNombre" maxlength="10" value='{sNombre}'></td> 
		  </tr>
		  <tr>			
			 <td align="center" colspan="2"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>
