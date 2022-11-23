<center>
	<form action="{FORM}" method="POST" >
		<table  class='formulario'  style="width:600px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
			 <tr> 
			  	<th colspan="8" class="cabecera"> Buscar Comercio </th> 
			  </tr>
			<tr>
			  	<th align="right">Nro. Comercio:</th>
			  	<th><input type="text" name="sNumeroComercio" id="sNumeroComercio" value='{sNumeroComercio}'></th>		  	
				<th align="right">Nombre Fantasia:</th>
			  	<th><input type="text" name="sNombreFantasia" id="sNombreFantasia" value='{sNombreFantasia}'></th>
			  	<td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
			</tr>			 		  	
			<tr>
			  	<th colspan="4" align="center" > Numero de comercio </th>		  	 
			</tr>
			 <tr> 	 		  	
			  	<th align="right">Desde:</th>
			  	<th><input type="text" name="sNumeroDesde" id="sNumeroDesde" value='{sNumeroDesde}'></th>
	 			<th align="right">Hasta:</th>
			  	<th><input type="text" name="sNumeroHasta" id="sNumeroHasta" value='{sNumeroHasta}'></th>
			  	<td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscarRango'> Buscar </button></td>
			</tr>   		
		</table>
	</form>
</center>
	
