<br>
<br>
<center>
<input type="hidden" id="id" name="id" value="{ID}">
<table class="TablaGeneral">
	<tr>
		<td align="right" class="Titulo">Nro. Comercio:</td>
		<td >{NRO_COMERCIO}</td>
	</tr>
	<tr>
		<td align="right" class="Titulo">Nro. Transaccion:</td>
		<td>{NRO_TRANSACCION}</td>
	</tr>
	<tr>
		<td align="right" class="Titulo">Nro. Liquidacion:</td>
		<td>{NRO_LIQUIDACION}</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>	
	<tr>
		<td align="right" class="Titulo">Importe:</td>
		<td>{IMPORTE}</td>
	</tr>
</table>
<br>
<table class="TablaGeneral">
	<tr>
		<td class="Titulo">Motivo de baja</td>		
	</tr>
	<tr>
		<td><textarea type="text" id="sObservaciones" name="sObservaciones"></textarea></td>		
	</tr>
	<tr>
		<td align="right"><input type="button" id="btnAceptar" value="Aceptar" onclick="anular();"></td>
	</tr>
</table>
</center>

<script type="text/javascript">
	function anular()
	{
		id = document.getElementById('id').value;
		sObservaciones = document.getElementById('sObservaciones').value;
				
		if(confirm("¿Desea anular este movimiento?"))
		{
			xajax_updateTransLiquidaciones(id, "B", sObservaciones);	
		}		
	}
</script>