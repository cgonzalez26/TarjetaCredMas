
<center>
<!--<div id='BODY'>-->
<!--<center>
<div class='title_section' style='width:720px;'>
	&nbsp;&nbsp;Detalles de Solicitudes x Empleados
</div>
</center>-->

<!--{pathBrowser}-->
	<br />

<center>
<div id='div_message_operations' style='width:720px;'>
{message}
</div>
</center>

{buttons}

<div id='div_result_button'>
 	
</div>
<br />
<div id="div_result_search">
	{table}
</div>

<script type='text/javascript'>
	
	
	function printReportesDetallesSolicitudesEmpleados(){
		document.getElementById('impresiones').innerHTML = document.getElementById('div_result_search').innerHTML;
		window.print();
	}

	{javascript_adicional}
</script>



<!--</div>-->
</center>