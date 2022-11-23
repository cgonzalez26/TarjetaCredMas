<style type="text/css">
	.TablaImpresion
	{
		font-family:Arial;
		font-size:9px;
		/*background:#FFF url(../includes/images/bg_lines.gif) repeat-x;*/
	}
</style>
<center>
	<table cellpadding="0" cellspacing="0" class="TablaImpresion" width="730" border="0">
	<tr><td height="180">&nbsp;</td></tr>
	<tr>
		<td height="140" valign="top">
	 		<table id='TablaHeaderResumen' cellpadding="0" cellspacing="0" width="100%" border="0" class="TablaImpresion" style="font-size:12px;">
			  <tr>
			    <td style="padding-left:20px;width:250px"><p>{TITULAR}<br>
			    {DOMICILIO}
			    </td>
			  </tr>
			  <tr><td style='height:10px'></td></tr>
			  <tr>
			    <td style="padding-left:20px">
			    	<!--<img src="../includes/barcodegen/html/image.php?code=code128&o=2&t=30&r=1&text={CODIGO_BARRA}&f=2&a1=&a2=&rot=0&dpi=72&f1=Arial.ttf&f2=9" alt="ERROR" align="absmiddle" style="width:300px;"/>-->
			    	<img src="../includes/barcodegen/html/image.php?code=i25&o=2&t=40&r=1&text={CODIGO_BARRA}&f=2&a1=&a2=&rot=0&dpi=72&f1=Arial.ttf&f2=10" alt="ERROR" align="absmiddle" style="width:280px;"/>
			    </td>
			  </tr>
			  <tr>
			  	<td style="font-size:8px;" align="left">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{LEYENDA}
			  	</td>
			  </tr>
			</table>
 		</td>
		<td height="140" align="right" valign="top" style="width:340px">
			<table id='TablaHeaderResumen' cellpadding="0" cellspacing="0" border="0" class="TablaImpresion" style="font-size:12px;width:300px" align="right">
			  <tr>
			  	<td></td>
			  	<td>{PAGINA}</td>			  	
			  </tr>
			  <tr>
			  	<td style="width:80px">Razon Social:</td>
			  	<td>Empresa</td>			  	
			  </tr>
			  <tr>
			  	<td>CUIT: </td>
			  	<td>00-00000000-0</td>			  	
			  </tr>
			  <tr>
			  	<td>Casa Central: </td>
			  	<td>Pedro Pardo 92-Salta-Capital(4400)</td>			  	
			  </tr>
			  <tr>
			  	<td>Tel&eacute;fono:</td>
			  	<td>0387-4317368</td>			  	
			  </tr>
			 </table> 
		</td>
	</tr>
 	<tr> 	
 		<td height="30" style='border-bottom:1px solid #000' colspan="2">&nbsp;</td>
 	</tr>
 	<tr>
 		<td style='border-bottom:1px solid #000'>&nbsp;</td>
 		<td align="right" valign="top" style='border-bottom:1px solid #000'>
 			<table id='TablaHeaderResumen' cellpadding="0" cellspacing="0" border="0" class="TablaImpresion" style="font-size:12px;width:250px">
 			<tr>
 				<td>NRO. CUENTA:</td>
 				<td>{NUMERO_CUENTA}</td>
 			</tr>
 			<tr>
 				<td>VENCIMIENTO ACTUAL</td>
				<td>{FECHA_VTO}</td>
 			</tr>
 			<tr>
 				<td>CIERRE ACTUAL</td>
				<td>{FECHA_CIERRE}</td>
 			</tr>
 			<tr>
 				<td>SALDO ACTUAL </td>
				<td>{IMPORTE_TOTAL}</td>
 			</tr> 			
 			</table>
 		</td>
 	</tr>
 	<tr>
 		<td colspan="2" style='border-bottom:1px solid #000'>
	 		<table id='TablaResumen' cellpadding="0" cellspacing="0" class="TablaImpresion" width="100%" border="0">
	 		<tr>
	 			<td style="width:130px">VTO. ANTERIOR</td>
				<td>{FECHA_VTO_ANTERIOR}</td>
				<td>SALDO ANTERIOR  $</td>
				<td>{SALDO_ANTERIOR}</td>
				<td>PROXIMO CIERRE</td>
				<td>{FECHA_CIERRE_PROX}</td>
	 		</tr>
	 		<tr>
	 			<td style='border-bottom:1px solid #000'>CIERRE ANTERIOR</td>
	 			<td style='border-bottom:1px solid #000'>{FECHA_CIERRE_ANTERIOR}</td>
				<td colspan="2" style='border-bottom:1px solid #000'>&nbsp;</td>
				<td style='border-bottom:1px solid #000'>PROXIMO VTO.</td>
				<td style='border-bottom:1px solid #000'>{FECHA_VTO_PROX}</td>
	 		</tr>
	 		<tr>
	 			<td>LIMITEs: COMPRA $</td>
				<td>{LIMITE_COMPRA}</td>
				<td>CREDITO  $</td>
				<td>{LIMITE_CREDITO}</td>
				<td>ADELANTO  $</td>
				<td>{LIMITE_ADELANTO}</td>
	 		</tr>
	 		</table>
 		</td>
 	</tr>
 	<tr>
	     <td valign="top" style="padding-left:0px;padding-top:5px" colspan="2">{TABLA_DATOS}</td>
	 </tr> 
	</table>
