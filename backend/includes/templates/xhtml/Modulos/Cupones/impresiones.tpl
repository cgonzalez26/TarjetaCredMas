<style>
	table.printCUPONES{
		font-family:Tahoma;
		font-size:12px;
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
	   /*border-style: dotted; 
	   border-width: 1px; 
	   border-color: 660033;*/ 
	   font-family: verdana, arial; 
	   font-size: 10pt;
	   /*border-right:1px dotted #660033; */
	} 

	.Centrado
	{
		text-align:center
	}
	
	.izquierdaTexto{
		text-align:left;
	}
</style>

<table width="700px"  align="left">
	<tr>
    	<td class="punteado" style="padding-left:5px; padding-right:20px; width:350px; vertical-align:top;">
        	<table class="printCUPONES">
				<tr>
                	<td style="font-size:14px;"> ENTIDAD </td><td style=" width:30px"> </td>
        			<td> Fecha {date_now} hora: {hours_now} </td>        
    			</tr>
			</table>
            <p style="text-decoration:underline">CRONOGRAMA DE VENCIMIENTOS DE CUOTAS</p>
            <table class="printCUPONES">
                <tr>
                    <td><P></P></td>
                    <td td style=" width:30px"></td>
                    <td> Sucursal: {idSucursal} </td>       
                </tr>
                <tr>
                    <td> Cuenta N&deg;: {sNumeroCuenta}</P></td>
                    <td td style=" width:30px"> </td>
                    <td> Precio Total: $ {importeTOTAL} </td>
                </tr>
            </table>
            <br/>
            <table  border=1 cellspacing=0 cellpadding=2 bordercolor="666633" class="printCUPONES" align="center">
                <tr>
                    <th> Cta. N&deg;</th>
                    <th> Fecha Vto. </th>
                    <th> Nom.</th>
                    <th> Importe Cuota </th>
                </tr>
                {tableRowsCuotas}
               <!--<tr>
                    <td>1</td>
                    <td>15/05/2011</td>
                    <td>$</td>
                    <td>100,00</td>
                </tr>-->
            </table>	
            <div style="width:400px"><p>
            Estimado Cliente: le informamos que UD. estar&aacute; recibiendo
            en forma mensual en su domicilio , un &uacute;nico aviso de
            Vencimiento que reflejar&aacute; aquellas cuotas que venzan en 
            dicho per&iacute;odo. <br />
            Autorizo expresamente a GRIVA S.R.L., a que por mi cuenta y orden abone al comercio adherido que corresponda, el importe de este pr&eacute;stamo seg&uacute;n lo convenido en el contrato correspondiente
            </p></div>
            <br/>
            <p class="izquierdaTexto"><label style="float:left;width:150px;">Firma</label>:..................................</p>
            <p class="izquierdaTexto"><label style="float:left;width:150px;">Aclaracion</label>:..................................</p>
            <p class="izquierdaTexto"><label style="float:left;width:150px;">Tipo y Nro. Doc.</label>:..................................</p>

            <p>________________________________________________</p>
            <table class="printCUPONES">
            <tr>
                <td>Cupon: {sNumeroCupon}</td>
                <td style="width:30px"></td>	
                <td>Por pesos: $ {importeTOTAL}</td>
            </tr>    
            <tr>
                <td>Cuenta N&deg;: {sNumeroCuenta}</td>
                <td td style=" width:30px"></td>
                <td> Sucursal {idSucursal}</td>
            </tr>
        	</table>
            </br>

            <table class="printCUPONES">
                <tr>
                    <td> Lugar y fecha : </td>
                    <td>{fecha_hoy_en_letras}</td>
                </tr>
            </table>
            </br>
			<div style="width:400px">
                <p>
                    A la vista pagar&eacute;(mos) sin protesto ( Art. 50 Dec. Ley
                    5965/63) a GRIVA S.R.L. o a su orden la cantidad de Pesos
                    {importe_en_letras} por igual valor recibido a
                    mi/nuestra entera satisfacci&oacute;n de conformidad con lo
                    dispuesto por los art&iacute;culos 36.103 y concordantes del Decreto
                    Ley 5965/63. Ampliamos el plazo legal m&aacute;ximo dentro del cual podr&aacute;
                    ser presentado para su pago el presente pagar&eacute; hasta el d&iacute;a 
                    {fecha_en_letra_plazo_presentacion}
                </p>
        	</div>
            <p>Lugar de pago:</p>
            <p>Solicitante {cartel_razon_social_cuit}</p>
            <p>Firma:.............................................................</p>
            <!--<p>Aclaraci&oacute;n</p>
            <p>Manuscrita:.....................................................</p>-->
            <p>Aclaraci&oacute;n: {sTitular}</p>
            <p>Documento N&deg;: {sTipoDocumento} {sNumeroDocumento} </p>
            <p>Domicilio: {sDomicilio}<br />
			<!--<p>Domicilio: {sCalle} {sNumeroCalle} BLOCK: {sBlock}  Piso: {sPiso}  Dpto.:{sDepartamento}<br />-->
						<!--<table id="TablaDomicilio" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">

							<tr>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Calle:</span>
								</td>
								<td>
								  <span id="Solicitudes_plNro_lblLabel">Nro.:</span>
								</td>								
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Block:</span>
								</td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Piso:</span>
								</td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Departamento:</span>
								</td>								
							</tr>
							<tr>
								<td align="left">
									{sCalle}</td>
								<td align="left">
									{sNumeroCalle}</td>												
								<td align="left">
									{sBlock}</td>
								<td align="left">
									{sPiso}</td>
								<td align="left">
									{sDepartamento}</td>	
							</tr>
							<tr>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Entre Calles:</span></td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Manzana:</span>
								</td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Lote:</span>
								</td>
								<td>
								  
								</td>
							</tr>
							<tr>
								<td align="left">
									{sEntreCalles}</td>				
								<td align="left">
									{sManzana}</td>
								<td align="left">
									{sLote}</td>	
								
							</tr>												
						</table>-->	            
	            </p>
            <p>{sProvinciaTitular}, {sLocalidadTitular}</p>
            
          </td>
        <td valign="top" style="padding-left:20px;margin-left:15px !important;" width="350">
        <p></p>
        <p></p>
        <p></p>
        <br />
                <p>ENTIDAD</p>
                <table class="printCUPONES">
                   <tr>
                       <td>Fecha: {date_now}</td>
                       <td td style=" width:30px"></td>
                       <td>Hora: {hours_now}</td>
                   </tr>
                </table>
                <p style="text-decoration:underline">CRONOGRAMA DE VENCIMIENTOS DE CUOTAS</p>
                <p>                    
                    Sucursal: {idSucursal}<br/>
                    Cuenta N&deg;: {sNumeroCuenta}<br/>
                    Estado: Aprobada<br/>
                    Precio Total: $ {importeTOTAL}<br/>    
                </p>
                <table border=1 cellspacing=0 cellpadding=2 bordercolor="666633" class="printCUPONES" align="center">
                    <tr>
                        <th> Cta. N&deg;</th>
                        <th> Fecha Vto. </th>
                        <th> Nom.</th>
                        <th> Importe Cuota </th>
                    </tr>
                    {tableRowsCuotas}

                </table>
    			<br />    		
    			
    			<br />
    			<br />
    			
            <p class="izquierdaTexto"><label style="float:left;width:150px;">Firma</label>:..................................</p>
            <p class="izquierdaTexto"><label style="float:left;width:150px;">Aclaracion</label>:..................................</p>
            <p class="izquierdaTexto"><label style="float:left;width:150px;">Tipo y Nro. Doc.</label>:..................................</p>              
	            
                <br />
                <div style="width:400px">
                    <p>
			            Estimado Cliente: le informamos que UD. estar&aacute; recibiendo
			            en forma mensual en su domicilio , un &uacute;nico aviso de
			            Vencimiento que reflejar&aacute; aquellas cuotas que venzan en 
			            dicho per&iacute;odo.
                    </p>
                </div>	
                <br/>
                
                <br />
                <br />               
                
                <!--<br/>               
                <p class="Centrado">..................................................................</p>
                <p style="text-align:center">Firma cliente</p>
                <p></p>-->
	            <p>Lugar de pago:</p>
	            <p>Solicitante {cartel_razon_social_cuit}</p>
	            <p>Firma:.............................................................</p>
	            <!--<p>Aclaraci&oacute;n</p>
	            <p>Manuscrita:.....................................................</p>-->
	            <p>Aclaraci&oacute;n: {sTitular}</p>
	            <p>Documento N&deg;: {sTipoDocumento} {sNumeroDocumento}       </p>
	            <p>Domicilio: {sDomicilio}<br />
	            <!--<p>Domicilio: {sCalle} {sNumeroCalle} BLOCK: {sBlock}  Piso: {sPiso}  Dpto.:{sDepartamento}<br />-->
						<!--<table id="TablaDomicilio" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">

							<tr>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Calle:</span>
								</td>
								<td>
								  <span id="Solicitudes_plNro_lblLabel">Nro.:</span>
								</td>								
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Block:</span>
								</td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Piso:</span>
								</td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Departamento:</span>
								</td>								
							</tr>
							<tr>
								<td align="left">
									</td>
								<td align="left">
									</td>												
								<td align="left">
									</td>
								<td align="left">
									</td>
								<td align="left">
									</td>	
							</tr>-->
							<!--<tr>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Entre Calles:</span></td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Manzana:</span>
								</td>
								<td>
								  <span id="Solicitudes_plDomicilio_lblLabel">Lote:</span>
								</td>
							</tr>-->
							<!--<tr>
								<td align="left">
									{sEntreCalles}</td>				
								<td align="left">
									{sManzana}</td>
								<td align="left">
									{sLote}</td>	
									
							</tr>												
						</table>-->	            
	            </p>
	            <p>{sProvinciaTitular}, {sLocalidadTitular}</p>
        </td>
  </tr>
</table>
