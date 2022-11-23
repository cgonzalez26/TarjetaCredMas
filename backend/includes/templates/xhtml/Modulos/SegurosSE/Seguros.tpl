<center>
<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->

<form action="" method="POST" id="formAdminUsu"> 
<div id="marco" style="width:{ANCHO}; border:solid 1px #CCCCCC;">

		<div class="titulo" style="background:#ccc;border:solid 1px #666"> {TITULO} </div>
		<span class="espacio"></span>
		<table id='sucursales_dependiente' class="formulario" >
		     <tr>
				<th class='borde' align="right">Nro Tarjeta :</th>
				<td   class='borde'>
				<input name="sNroTarjeta"  id="sNroTarjeta" value="" size="20" maxlength="20"/> 
		   		<sup>*</sup>
				</td>
		 	</tr>
		 	<tr>
				<th class='borde' align="right">CVC :</th>
				<td   class='borde'>
				<input name="sCvc"  id="sCvc" value="" size="5" maxlength="5"/> 
		   		<sup>*</sup>
				</td>
		 	</tr>
		</table>
		
		 <span class="espacio"></span>
		 <button onclick="" type="button"  id="btnOk" >OK</button>
		 <button onclick="" type="button"  id="btnNueva" >NUEVA</button>
</div>	
{OTROS_SCRIPT}

<input type="hidden" name="idPoliza" value="{ID_POL}" id="idPoliza">	
<input type="hidden" name="idPago" value="{ID_PAGO}" id="idPago">	
<input type="hidden" name="idCuota" value="{ID_CUOTA}" id="idCuota">	
</form>
</center>