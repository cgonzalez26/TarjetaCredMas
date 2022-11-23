<style>
    div#impresiones { display: none; }
	div#impresionesCobranza { display: none; }
	@media print {
	
		div#BODY {display: none;}
	
		div#impresiones {	
			display: block;
			width: 100%;
		}
		
		div#impresionesLiquidacion{	
			display: block;
			width: 100%;
		}
	}

	.tituloLiquidacion
	{
		font-size:20px;
		text-align:center;
		font-weight:bold;
	}
	
	.tituloLiquidacionRight{
		font-size:16px;
		/*text-align:center;*/
		font-weight:bold;	
	}

	p{
		font-size:12px;
		text-align:justify;
		font-family:Verdana,Tahoma, Arial, Helvetica, sans-serif;
	}
	
	table.datos th {
		text-align: left;
		width: 160px;
		font-family:Verdana,Tahoma, Arial, Helvetica, sans-serif;
	}
	
	.datosLiquidacion
	{
		font-size:10px;
	}

	.Centrado
	{
		text-align:center;
	}
</style>

<body>
<center>
<div id="BODY">
<div id='' style='width:80%;text-align:right;margin-right:10px;margin-top:10px;'>
			<img src='{IMAGES_DIR}/print.gif' title='Imprimir Solicitud' alt='Imprimir Solicitud' border='0' hspace='4' align='absmiddle'> 
			<a href="#" onclick='javascript:imprimir();' style='text-decoration:none;font-weight:bold'>Imprimir</a>
			&nbsp;&nbsp;			
			<img src='{IMAGES_DIR}/back.png' title='Volver' alt='Volver' border='0' hspace='4' align='absmiddle'> 
			<a href="{URL_BACK}" style='text-decoration:none;font-weight:bold;'>Volver</a>
</div>
<div id="divRecibo">
<table width="800px" border=0 cellspacing=0 cellpadding=2 style="font-family:Arial;font-size:11px;border:1px solid #000;">
	<tr>
    	<td colspan="2">
			<table width="100%" cellpadding="5" cellspacing="0" border="0">
				<tr>
					<td width="350" valign="top">
			        	<table width="100%" style="font-size:12px;">
			            	<tr>
			                	<td class="tituloLiquidacion">GRIVA S.R.L.</td>
			                </tr>
			                <tr><td>&nbsp;</td></tr>
			                <tr><td>&nbsp;</td></tr>
			                <tr><td>&nbsp;</td></tr>
			                 <tr><td>&nbsp;</td></tr>
			                <tr>
			                	<td align="center">Pedro Pardo 92- Salta Capital</td>
			                </tr>
			            </table>		
					</td>
					<td valign="top" width="60" align="center">
						<div style="font-family:Tahoma;font-size:32px;font-weight:bold;border-bottom:1px solid #000;border-right:1px solid #000;border-left:1px solid #000;text-align:center;"> A </div>
					</td>
					<td width="390" valign="top" align="right">
			        	<table style="font-size:12px;text-align:left;" width="370" align="right">
			            	<tr>
			                	<td align="left" colspan="2" class="tituloLiquidacionRight">CUENTA DE VENTA Y LIQUIDO PRODUCTO</td>
			                </tr>
			                <tr>
			                	<td>
			                    	Numero:
			                    </td>
			                    <td>
			                    	{NRO_LIQUIDACION}
			                    </td>
			                </tr>
			                <tr>
			                	<td>
			                    	Fecha:
			                    </td>
			                    <td>
			                    	{FECHA}
			                    </td>
			                </tr>
			                <tr>
			                	<td>CUIT:</td>
			                	<td>{CUIT}</td>
			                </tr>
			                <tr>
			                	<td>DGR:</td>
			                    <td>{DGR}</td>
			                </tr>
			                <tr>
			                	<td>Inicio de Actividades:</td>
			                    <td>{FECHA_INICIO_ACTIVIDADES}</td>
			                </tr>     
			                <tr>
			                	<td colspan="2">I.V.A. Responsable Inscripto</td>
			                </tr>                 
			            </table>		
					</td>
				</tr>
			</table>
        </td>
    </tr>
    <tr>
   	  <td colspan="2" style="border-bottom:1px double #000;border-top:1px solid #000;">
            <table width="100%" cellpadding="0" cellspacing="5" style="">
                    <tr>
                        <td>Se&ntilde;or(es): ...........................................................</td>
                    </tr>
                    <tr>
                        <td>Domicilio: ...........................................................</td>
                    </tr>
                    <tr>
                        <td>CUIT Nro.: ...........................................................</td>
                    </tr>
            </table>
        </td>    
    </tr>
    <tr>
    	<td>
        	<table width="100%">
            	<tr>
                	<th align="left" colspan="2">
                    	INGRESOS
                    </th>
                </tr>
                <tr>
                	<td width="100">&nbsp;</td>
                 	<td align="left">
                    	Consumos
                    </td>   
                </tr>
				<tr>
                	<th align="left" colspan="2">
                    	DEDUCCIONES
                    </th>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	Arancel
                    </td>   
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	IVA Arancel
                    </td>   
                </tr>
                 <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	Costo Financiero
                    </td>   
                </tr>
                 <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	IVA Costo Financiero
                    </td>   
                </tr>
                <tr>
                	<th align="left" colspan="2">
                    	TOTAL DEDUCCIONES
                    </th>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                	<th  align="left" colspan="2">
                    	RETENCIONES
                    </th>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	Ret. IVA
                    </td>   
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	Ret. Ganancias
                    </td>   
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	Ret. Ingresos Brutos
                    </td>   
                </tr>              
                 <tr>
                	<th align="left" colspan="2">
                    	TOTAL RETENCIONES
                    </th>
                </tr>
                  <tr>
                	<td colspan="2">&nbsp;</td>  
                </tr>
                <tr>
                	<th align="left" colspan="2">
                    	AJUSTES
                    </th>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	Ajustes
                    </td>   
                </tr>
                 <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	IVA Ajustes
                    </td>   
                </tr>
                 <tr>
                	<th align="left" colspan="2"> 
                    	TOTAL AJUSTES
                    </th>
                </tr>
                  <tr>
                	<td colspan="2">&nbsp;</td>  
                </tr>
                <tr>
                	<th align="left" colspan="2">
                    	IMPORTE NETO
                    </th>
                </tr>
            </table>
        </td>
        <td>
        	    <table width="150" border="0" align="right" style="border-left:1px solid #000;text-align:right;" border="1">
            	<tr>
                    <td colspan="" colspan="2" >&nbsp;</td>                         	
                </tr>
                <tr>
                	<td width="">&nbsp;</td>
                 	<td>
                    	<span style="float:left;"> $ </span>{Importe_Bruto}
                    </td>   
                </tr>
				<tr>
                    <td colspan="2">&nbsp;</td>                         	
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	<span style="float:left;"> $ </span>{Arancel}
                    </td>   
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	<span style="float:left;"> $ </span>{IVA_Arancel}
                    </td>   
                </tr>
                 <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	<span style="float:left;"> $ </span>{Costo_Financiero}
                    </td>   
                </tr>
                 <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	<span style="float:left;"> $ </span>{IVA_Costo_Financiero}
                    </td>   
                </tr>
                <tr> 
                    <td colspan="2">&nbsp;</td>                         	
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
                <tr> 
                    <td colspan="2">&nbsp;</td>                         	
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	<span style="float:left;"> $ </span>{Retenciones_IVA}
                    </td>   
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	<span style="float:left;"> $ </span>{Retenciones_Ganancias}
                    </td>   
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	<span style="float:left;"> $ </span>{Retenciones_Ing_Brutos}
                    </td>   
                </tr>              
                 <tr>  
                    <td colspan="2">&nbsp;</td>                         	
                </tr>
                  <tr>
                	<td colspan="2">&nbsp;</td>  
                </tr>
                <tr> 
                    <td colspan="2">&nbsp;</td>                         	
                </tr>
                <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	<span style="float:left;"> $ </span>{Ajustes}
                    </td>   
                </tr>
                 <tr>
                	<td>&nbsp;</td>
                 	<td>
                    	<span style="float:left;"> $ </span>{IVA_Ajuste}
                    </td>   
                </tr>
                 <tr> 
                    <td colspan="2">&nbsp;</td>                         	
                </tr>
                  <tr>
                	<td colspan="2">&nbsp;</td>  
                </tr>
                <tr>
                	<td>&nbsp;
                    	
                    </td>  
                    <td><span style="float:left;"> $ </span><strong>{Importe_Neto}</strong></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
<center>
</body>
 <script>
  function imprimir(){
  	 var tabla = document.getElementById('divRecibo').innerHTML; 
  	 document.getElementById('impresiones').innerHTML = tabla;
  	 
  	 window.print();
  }
  </script>