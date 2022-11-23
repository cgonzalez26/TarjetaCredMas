<style>
div#impresion_cuota {
	background-color: #FFF;	
	margin: 0 auto;
	overflow-x: hidden;
	position: relative;
	font-size: 8pt;
	top:-0px;
	left: -0px;
	height:100%;
	width:100%;
}

div#saltopagina{ 
			display:block; 
			page-break-before:always; 
			}
div#sDetalleImprimible table{ width:80%;border:solid 1px #CCC;}
</style>


<div id='impresion_cuota' style='clear:both; width:800px; padding-left:14.15px'>
<!-- funca en la laser
	<div id="fImporte" style="top:5px !important;position:relative;width:200px;left:580px;text-align:left;font-family:Tahoma;font-size:11pt;">
		{fImporte}
	</div>
	<div id="sMesEmision" style="top:9px !important;position:relative;width:100%;left:180px;text-align:left;font-family:Tahoma;font-size:9pt;">
	{iDiaEmision} 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;    
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	{sMesEmision}  
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	{iAnioEmision}
	</div>
	
	<div id="sMesCobro" style="top:15px !important;position:relative;width:100%;left:170px;text-align:left;font-family:Tahoma;font-size:9pt;display:block;">
	{iDiaPagar}  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;    {sMesPagar}  
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
	{iAnioPagar}
	</div>
	<div id="sAPagar" style="top:25px !important;position:relative;width:200px;left:205px;text-align:left;font-family:Tahoma;font-size:9pt;">
		{sAPagar}
	</div>
	<div id="sImporte" style="top:35px !important;position:relative;width:200px;left:225px;text-align:left;font-family:Tahoma;font-size:9pt;">
		{sImporte}
	</div>
-->
<!--
	<div id="fImporte" style="top:5px !important;position:relative;width:150px;left:660px;text-align:left;font-family:Tahoma;font-size:11pt;">
		{fImporte}
	</div>
	<div id="sMesEmision" style="top:9px !important;position:relative;width:100%;left:180px;text-align:left;font-family:Tahoma;font-size:9pt;">
	{iDiaEmision} 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;    
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	{sMesEmision}  
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	{iAnioEmision}
	</div>
	
	<div id="sMesCobro" style="top:15px !important;position:relative;width:100%;left:95px;text-align:left;font-family:Tahoma;font-size:9pt;display:block;">
	{iDiaPagar}  
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;    
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;    
	{sMesPagar}  
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	{iAnioPagar}
	</div>
	<div id="sAPagar" style="top:25px !important;position:relative;width:200px;left:130px;text-align:left;font-family:Tahoma;font-size:9pt;">
		{sAPagar}
	</div>
	<div id="sImporte" style="top:35px !important;position:relative;width:200px;left:180px;text-align:left;font-family:Tahoma;font-size:9pt;">
		{sImporte}
	</div>
-->
	
	<div id="fImporte" style="top:5px !important;position:relative;width:200px;left:567px;text-align:left;font-family:sans-serif;font-size:11pt;">
		{fImporte}
	</div>
	<div id="sMesEmision" style="top:10px !important;position:relative;width:100%;left:60px;text-align:left;font-family:sans-serif;font-size:10pt;">
	<table style="width:100%;"> 
		<tr> 
		     <td width="20%" style="font-family:sans-serif;font-size:10pt;">{iDiaEmision}</td>
			 <td width="20%" style="font-family:sans-serif;font-size:10pt;">{sMesEmision}</td>
			 <td width="60%" style="font-family:sans-serif;font-size:10pt;">{iAnioEmision}</td> 
	    </tr> 
	</table>
	<!-- CAMBIOS EL 10/06/2011 EN DIV sMesEmision: top:15px -->
	<!--<br>
   60Ancho;12;20;63

	{iDiaEmision} 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;    
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	{sMesEmision}  
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	{iAnioEmision}-->
	</div>
	
	<div id="sMesCobro" style="top:11px !important;position:relative;width:100%;left:-5px;text-align:left;font-family:sans-serif;font-size:10pt;display:block;">
	<table style="width:100%;" > 
		<tr> 
		     <td width="10%" style="font-family:sans-serif;font-size:10pt;">{iDiaPagar}</td>
			 <td width="50%" style="font-family:sans-serif;font-size:10pt;">{sMesPagar}</td>
			 <td width="40%" style="font-family:sans-serif;font-size:10pt;">{iAnioPagar}</td> 
	    </tr> 
	</table>
	<!--<br>
	{iDiaPagar}  
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;    
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;    
	{sMesPagar}  
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	{iAnioPagar}-->
	</div>
	<div id="sAPagar" style="top:20px !important;position:relative;width:200px;left:30px;text-align:left;font-family:sans-serif;font-size:10pt;">
		{sReceptor}
	</div>
	<div id="sImporte" style="top:25px !important;position:relative;width:450px;left:92px;text-align:left;font-family:sans-serif;font-size:10pt;">
		{sImporte}
	</div>
	
</div>