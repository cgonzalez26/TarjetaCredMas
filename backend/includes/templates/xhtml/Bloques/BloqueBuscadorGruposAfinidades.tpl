<center>
	<form action="GruposAfinidades.php" method="POST" >
	<input type="hidden" name="condic" value="GruposAfinidades.sNombre">
	
		<table  class='formulario'  style="width:450px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="2" class="cabecera"> Grupos Afinidades </th> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right"style="width:130px">Buscar grupo (nombre): &nbsp;</th>
			 <td height="30"><input type="text" name="nombre_u" maxlength="10" value='{nombre_u}'></td> 
		  </tr>
		  <tr>			
			 <td align="center" colspan="2"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>
</center>