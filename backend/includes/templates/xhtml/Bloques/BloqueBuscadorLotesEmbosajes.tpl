<center>
	<form action="RecepcionEmbozo.php" method="POST" >
	
		<table  class='formulario'  style="width:450px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="4" class="cabecera"> Lotes de Embosajes </th> 
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right"style="width:130px">Nro.Lote: &nbsp;</th>
			 <td height="30"><input type="text" id="sNumeroPedidoEmbosaje" name="sNumeroPedidoEmbosaje" maxlength="10" value='{sNumeroPedidoEmbosaje}'></td> 
			 <th width="30" height="30" align="right"style="width:130px">Estado: &nbsp;</th>
			 <td height="30">
			 	<select id="idTipoEstadoLoteEmbosaje" name="idTipoEstadoLoteEmbosaje" style="">{optionsTipoeEstadoeLotesEmbosajes}</select>
			 </td> 
		  </tr>
		  <tr>			
			 <td align="center" colspan="4"><span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button></td>
		 </tr>
		</table>
	</form>
