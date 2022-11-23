<center>
<!--<div id='BODY'>-->

<!--<center>
<div class='title_section' style='width:720px;'>
	&nbsp;&nbsp;Reporte Solicitudes por Empleados
</div>
</center>-->

<!--{pathBrowser}-->

<center>
<div id='div_message_operations' style=''>
{message}
</div>
</center>

{buttons}

<center>
<br />
<div id="div_result_search">	
	<center>
	
	<div id='div_result_button' style="width:100%;text-align:left;x;font-family:Tahoma;font-size:12px;">
		{datos_operador}
	</div>
	<br />	
	
	<center>
	<div style="width:100%;text-align:left;x;font-family:Arial;font-size:16px;">
		<strong>Cobranzas</strong>
	</div>
	</center>
	<br />
	<table id='table_object' class='table_object' width='100%' cellspacing='0' cellpadding='0' align='center'>
		<thead> 
		<tr>		
			<th width="14%"> Nro. Recibo </th>
			<th width="8%">  Poliza </th>
			<th width="28%"> Asegurado </th>
			<th width="10%"> Dominio </th>
			<th width="8%">  Efectivo </th>
			<th width="8%">  Tarjeta </th>
			<th width="8%">  Ticket </th>
			<!--<th width="8%">  Descuento </th>-->
			<th width="8%">  R/Cobrado </th>
			<th width="8%">  S/Recibo </th>
		</tr>
		</thead>
		
		<tbody>
			{cobranzas_operador_seal}
		</tbody>
	</table>
	<br />	
	
	
	<div style="width:100%;text-align:left;x;font-family:Arial;font-size:16px;">
		<strong>Cobranzas de la Tarjeta</strong>
	</div>
	</center>
	<br />	
	<table id='table_object_tarjeta' class='table_object' width='100%' cellspacing='0' cellpadding='0' align='center'>
		<thead> 
		<tr>		
			<th width="10%"> Nro. Cuenta </th>
			<th width="62%">  Titular </th>
			<th width="10%"> Nro. Recibo </th>
			<th width="10%"> Fecha </th>
			<th width="8%">  Importe </th>
		</tr>
		</thead>
		
		<tbody>
			{cobranzas_operador_tarjeta}
		</tbody>
	</table>	
	<br />
	<table id='table_object_tarjeta' class='table_object' width='100%' cellspacing='0' cellpadding='0' align='center' style="background:#CCC;">		
		<tbody>
		<tr>
			<td align='right' colspan='4' width="92%"><strong>TOTAL GLOBAL</strong></td>
			<td class='' align='right'> {prefix} {importe_global}</td>
		</tr>
		</tbody>
	</table>	
</div>
</center>

<script type='text/javascript'>

	{javascript_adicional}
	
	function _printCobranzas(){
		
		document.getElementById('impresiones').innerHTML = document.getElementById('div_result_search_tarjeta').innerHTML ;
		
		window.print();
	}
	
	
	
</script>



<!--</div>-->
