<form action="{FORM}" method="POST"><center>
	<div style="width:700px;">
		<fieldset style="border-top:2px solid #000;border-right:0px solid #CCC;border-bottom:2px solid #000;border-left:0px solid #CCC;">
		<legend style="text-align:left;border:0px solid #FFF;">Cobranzas</legend>	
		
		<table style="width:680px !important;font-size:11px;" cellspacing="0" cellpadding="0" border="0">
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
				<button type='submit' name='buscar' style="width:120px;padding:5px;"> Buscar </button>
			</td>
		 </tr>
		 </table>		
		</fieldset>
	</div>
</center>
	</form>
<script type="text/javascript">
	InputMask('dFechaDesde','99/99/9999');
	InputMask('dFechaHasta','99/99/9999');
</script>