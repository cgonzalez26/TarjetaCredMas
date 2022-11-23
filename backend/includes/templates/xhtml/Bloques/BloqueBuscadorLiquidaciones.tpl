<form action="{FORM}" method="POST"><center>
	<div style="width:800px;">
		<fieldset style="border-top:2px solid #000;border-right:0px solid #CCC;border-bottom:2px solid #000;border-left:0px solid #CCC;">
		<legend style="text-align:left;border:0px solid #FFF;"><img src='{IMAGES_DIR}/search32.png' title='buscar' alt='buscar' hspace='4' align='absmiddle' /> LISTADO DE LIQUIDACIONES A COMERCIOS</legend>	
		
		<table style="width:680px !important;font-size:11px;" cellspacing="2" cellpadding="2" border="0">
		 <tr>
		  	<td align="right" width="140">Nro. Comercio:</td>
		  	<td width=""><input type="text" name="sNumeroComercio" id="sNumeroComercio" value='{sNumeroComercio}'></td>
		 </tr>
		 <tr>
		  	<td align="right" width="140">Nombre Fantasia:</td>
		  	<td width="150"><input type="text" name="sNombreFantasia" id="sNombreFantasia" value='{sNombreFantasia}'></td>
		  	<td align="right" width="140">Razon Social:</td>
		  	<td width="150"><input type="text" name="sRazonSocial" id="sRazonSocial" value='{sRazonSocial}'></td>
		 </tr>
		 <tr>
		  	<td align="right" width="140">Nro. Liquidacion:</td>
		  	<td width="150"><input type="text" name="sNumeroLiquidacion" id="sNumeroLiquidacion" value='{sNumeroLiquidacion}'></td>
		  	<td colspan="2"></td>
		 </tr>
		 <tr>
		  	<td align="right" width="140">DESDE:</td>
		  	<td width="150"><input type="text" name="dFechaDesde" id="dFechaDesde" value='{dFechaDesde}'></td>
		  	<td align="right" width="140">HASTA:</td>
		  	<td width="150"><input type="text" name="dFechaHasta" id="dFechaHasta" value='{dFechaHasta}'></td>
		 </tr>
		 <tr>
			<td align="center" colspan="4">
				&nbsp;
			</td>
		 </tr>		 
		 <tr>
			<td align="center" colspan="4">
				<span style="width: 50px !important;">&nbsp;</span> <button type='submit' name='buscar'> Buscar </button>
				<!--<button type='submit' name='cmd_search' style="width:120px;padding:5px;"> Buscar </button>-->
				<input type="hidden" name="cmd_search" id="cmd_search" value="1" />
			</td>
		 </tr>
		 </table>		
		</fieldset>
	</div>
</center>
	</form>
	<br />
<script type="text/javascript">
	InputMask('dFechaDesde','99/99/9999');
	InputMask('dFechaHasta','99/99/9999');
</script>