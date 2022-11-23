<style>

.table_buscador{
	font-family:Tahoma;
	font-size:11px;
}

</style>

<center>
	<form action="{FORM}" method="POST" >
		<table  class='formulario'  style="width:700px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="4" class="cabecera"> Planes </th> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right" style="width:130px">Nombre: &nbsp;</th>
			 <td height="30"><input type="text" name="sNombre" id="sNombre" value='{sNombre}'></td> 
			 <td colspan="2"></td>
		  </tr>
		  <tr>			
			 <td align="center" colspan="4">
			 	<span style="width: 50px !important;">&nbsp;</span> 
			 	<button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>
</center>