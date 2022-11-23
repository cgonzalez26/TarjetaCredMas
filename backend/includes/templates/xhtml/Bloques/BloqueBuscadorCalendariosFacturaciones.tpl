<center>
	<form action="CalendariosFacturaciones.php" method="POST" >
	<input type="hidden" name="condic" value="CalendariosFacturaciones.dPeriodo">
		<table  class='formulario'  style="width:450px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="2" class="cabecera"> Caldendario de Facturacion </th> 
		  </tr>
		  <tr>
		  		<td>
		  			GrupoAfinidad:
		  		</td>
		  		<td>
		  		{GRUPO_AFINIDAD}
		  		</td>
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right"style="width:130px">Periodo: &nbsp;</th>
			 <td height="30"><input type="text" name="nombre_u" maxlength="10" value='{nombre_u}'></td> 
		  </tr>
		  <tr>			
			 <td align="center" colspan="2"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>
</center>