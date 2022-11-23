<center>
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
                				<td  width="" align="left" class="datosSecundarios"><b>Empleado:</b></td>
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
</center>