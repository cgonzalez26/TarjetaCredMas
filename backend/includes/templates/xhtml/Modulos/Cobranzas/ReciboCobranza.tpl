<style>
    div#impresiones { display: none; }
	div#impresionesCobranza { display: none; }
	@media print {
	
		div#BODY {display: none;}
	
		div#impresiones {	
			display: block;
			width: 100%;
		}
		
		div#impresionesCobranza{	
			display: block;
			width: 100%;
		}
	}

	.tituloCobranza
	{
		font-size:12px !important;;
		text-align:right;
	}
	
	.datosCobranza
	{
		font-size:12px !important;
		text-align:justify;
		font-family:Verdana,Tahoma, Arial, Helvetica, sans-serif;
	}
	
	.datosSecundarios
	{
		font-size:8px !important;;
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
	
	
	.punteado
	{ 	
	   border-right:1px dotted #660033;	  
	} 
	
	.linea
	{ 	
	   border-top:1px #660033;	  
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
<div id="divRecibo" style="width:800px">
<table height="50px"><tr><td>&nbsp;</td></tr></table>
<table width="730px" cellpadding="8" cellspacing="8">
	<tr>
    	<td class="" width="50%">
        	<table width="100%">
                <tr>
                    <td  colspan="2" align="center"  style="background-color:#CCC"><b>TARJETA</b></td>
                </tr>
                 <tr>
                	<td colspan="2">
                		<table cellpadding="3" cellspacing="3">
                			<tr>
                				<td width="" align="left" class="datosSecundarios"><b>Oficina:</b></td>
			                     <td width="" align="left" class="datosSecundarios">{OFICINA}</td>        			              			                  			
                				 <td width="" align="left" class="datosSecundarios"><b>Sucursal:</b></td>
                    			 <td  width=""  align="left" class="datosSecundarios">{SUCURSAL}</td>   
                				<td  width="" align="left" class="datosSecundarios"><b>Atendido por:</b></td>
                    			<td width="" align="left" class="datosSecundarios">{EMPLEADO}</td>      
                			</tr>
                			<tr>
                				<td  height="10px" colspan="6">________________________________</td>
                			</tr>
                		</table>
                	</td>                	
                </tr>                  
                <tr>
                    <td align="left" class="datosCobranza"><b>Fecha:</b></td>
                    <td align="left" class="datosCobranza">{FECHA_REGISTRO}</td>                 
                </tr>
                <tr>
                	<td align="left" class="datosCobranza"><b>Cliente:</b></td>
                    <td  class="datosCobranza">{CLIENTE}</td>     
                </tr>
                <tr>
                    <td align="left" class="datosCobranza"><b>Nro. Cuenta:</b></td>
                    <td  class="datosCobranza">{NUM_CUENTA}</td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                </tr>
                <tr>
                    <td align="left" class="datosCobranza"><b>Nro. Recibo:</b></td>
                    <td  class="datosCobranza">{NUM_RECIBO}</td>                    
                </tr>
                 <tr>
                    <td colspan="2">&nbsp;</td>     
                </tr>
                <tr>
                    <td align="left"  class="datosCobranza">	
                        <b>Cantidad:</b>
                    </td>
                    <td class="datosCobranza">{CANTIDAD}</td>
                </tr>
                <tr>
                    <td align="left"  class="datosCobranza">	
                        <b>Importe: $</b>
                    </td>
                    <td  class="datosCobranza">{IMPORTE}</td>
                </tr>               
            </table>
            <table width="100%">
            	<tr>
            		<td>&nbsp;</td>
            	</tr>
             	<tr>
                <td>&nbsp;</td>
                	<td height="10" style="padding-left:50px">
			    	<img src="../includes/barcodegen/html/image.php?code=i25&o=2&t=20&r=1&text={CODIGO_BARRA}&f=2&a1=&a2=&rot=0&dpi=72&f1=Arial.ttf&f2=9" alt="ERROR" align="absmiddle"/>
			    	<!--<img src="../includes/Image_Barcode/imagen.php?num='{CODIGO_BARRA}'" alt="ERROR" align="absmiddle" style="width:250px;height:15px" /><br>
			    	{CODIGO_BARRA}--></td>
                </tr>
            </table>
        </td>
        <td  width="50%">
        	<table width="100%">
                <tr>
                    <td  colspan="2" align="center" style="background-color:#CCC"><b>TARJETA</b></td>
                </tr>               
                 <tr>
                	<td colspan="2">
                		<table cellpadding="3" cellspacing="3">
                			<tr>
                				<td width="" align="left" class="datosSecundarios"><b>Oficina:</b></td>
			                     <td width="" align="left" class="datosSecundarios">{OFICINA}</td>        			              			                  			
                				 <td width="" align="left" class="datosSecundarios"><b>Sucursal:</b></td>
                    			 <td  width=""  align="left" class="datosSecundarios">{SUCURSAL}</td>   
                				<td  width="" align="left" class="datosSecundarios"><b>Atendido por:</b></td>
                    			<td width="" align="left" class="datosSecundarios">{EMPLEADO}</td>      
                			</tr>
                			<tr>
                				<td  height="10px" colspan="6">________________________________</td>
                			</tr>
                		</table>
                	</td>                	
                </tr>             
                <tr>
                    <td align="left" class="datosCobranza"><b>Fecha:</b></td>
                    <td align="left" class="datosCobranza">{FECHA_REGISTRO}</td>                 
                </tr>
                <tr>
                	<td align="left" class="datosCobranza"><b>Cliente:</b></td>
                    <td  class="datosCobranza">{CLIENTE}</td>     
                </tr>
                <tr>
                    <td align="left" class="datosCobranza"><b>Nro. Cuenta:</b></td>
                    <td  class="datosCobranza">{NUM_CUENTA}</td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                </tr>
                <tr>
                    <td align="left" class="datosCobranza"><b>Nro. Recibo:</b></td>
                    <td  class="datosCobranza">{NUM_RECIBO}</td>                    
                </tr>
                 <tr>
                    <td colspan="2">&nbsp;</td>     
                </tr>
                <tr>
                    <td align="left"  class="datosCobranza">	
                        <b>Cantidad:</b>
                    </td>
                    <td class="datosCobranza">{CANTIDAD}</td>
                </tr>
                <tr>
                    <td align="left"  class="datosCobranza">	
                        <b>Importe: $</b>
                    </td>
                    <td  class="datosCobranza">{IMPORTE}</td>
                </tr>
            </table>
             <table width="100%">
            	<tr>
            		<td>&nbsp;</td>
            	</tr>
             	<tr>
                <td>&nbsp;</td>
                	<td height="10" style="padding-left:50px">
			    	<img src="../includes/barcodegen/html/image.php?code=i25&o=2&t=20&r=1&text={CODIGO_BARRA}&f=2&a1=&a2=&rot=0&dpi=72&f1=Arial.ttf&f2=9" alt="ERROR" align="absmiddle"/>
			    	<!--<img src="../includes/Image_Barcode/imagen.php?num='{CODIGO_BARRA}'" alt="ERROR" align="absmiddle" style="width:250px;height:15px" /><br>
			    	{CODIGO_BARRA}--></td>
                </tr>
            </table>
        </td>
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