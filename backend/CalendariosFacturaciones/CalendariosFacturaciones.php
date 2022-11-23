<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
	

	#Control de Acceso al archivo
	//if(!isLogin())
	//{
		//go_url("/index.php");
	//}
		
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	
	$oXajax=new xajax();
	
	$oXajax->registerFunction("_buscarCalendarioFacturacion");	
	$oXajax->registerFunction("updateDatosCalendarioFacturacion");		
	$oXajax->registerFunction("updateDatosCalendarioFacturacion");		
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
	
	xhtmlHeaderPaginaGeneral($aParametros);	
?>

<body style="background-color:#FFFFFF;">
<div id="BodyUser">

<form>
	<center id="formBuscadorCalendario>
		<div id="" style="width:75%;text-align:right;margin-right:10px;">
		<img hspace="4" border="0" align="absmiddle" alt="Guardar Grupo" title="Guardar" src='../includes/images/disk.png' >
		<a id="idGuardar" style="text-decoration:none;font-weight:bold;" href="javascript:saveDatos();">Guardar </a>
		<div id="botonNuevo" style="display:inline">
		<img hspace="4" border="0" align="absmiddle" alt="Nuevo Grupo" title="Nuevo Grupo" src='../includes/images/newOrder.png'>
		<a style="text-decoration:none;font-weight:bold" onclick="javascript:resetearCalendario();" href="#">Nuevo</a>
		</div>
		<img hspace="4" border="0" align="absmiddle" alt="Volver" title="Volver" src='../includes/images/back.png'>
		<a style="text-decoration:none;font-weight:bold;" href="../GruposAfinidades/AdminGruposAfinidades.php?idGrupoAfinidad=<? echo $_GET['idGrupoAfinidad']?>">Volver</a>
	</div>
	</center>
	
	<table  class='formulario'  style="width:450px !important;border:solid 1px #CCC !important;" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
		  	<th colspan="3" class="cabecera"> Caldendario de Facturacion </th>  
	  	</tr>
		  <tr>
		  		<th align="right">GrupoAfinidad:</th>
		  		<td><? echo $_GET['sNombre'];?></td>
		  		<td>&nbsp;</td>
		  </tr>
		  <tr>
			 <th width="30" height="30" align="right"style="width:130px">Buscar Periodo: &nbsp;</th>
			 <td height="30"><input type="text" name="dPeriodo" id="dPeriodo" maxlength="10"></td> 
		  	 <td align="center" colspan="2"><span style="width: 50px !important;">&nbsp;</span> <button name='buscar' onclick="buscarCalendario();return false"> Buscar </button></td>
		 </tr>		  
		</table>
</form>

<form id="formCalendario" method="POST" action="">
<center>
	

	<input type="hidden" name="condic" id="condic" value="CalendariosFacturaciones.dPeriodo">
	<input type="hidden" name="idGrupoAfinidad" id="idGrupoAfinidad" value="<? echo $_GET['idGrupoAfinidad']?>">
	<input type="hidden" name="sAccion"  id="sAccion" value="new">
	 
	
	
</center>

<center>

<br>
<br>
<br>
<br>

<div id="divPeriodo" style="display:block;width:900px">
	<table width="100%" class="TablaCalendario" border="0px" >
		<tr>
			<th width="100px" align="right">
				 Periodo:
			</th>
			<td>
				<input type='text' id='iPeriodoAplicar' name='iPediodoAplicar' size="10px">
			</td>
			<td align="center">
				<input  type="button" id="btnAplicar" name="btnAplicarPeriodo" value="Aplicar" onclick="aplicarPeriodo();"/>
			</td>
			<th width="100px" align="right">
				 Cierre:
			</th>
			<td>
				<input type='text' id='iCierreAplicar' name='iCierreAplicar' size="5px">
			</td>
			<td align="center">
				<input type="button" id="btnAplicarCierre" name="btnAplicarCierre" value="Aplicar"  onclick="aplicarDias('iCierreAplicar', 'dFechaCierre');"/>
			</td>
			<th width="100px" align="right">
				 Vencimiento:
			</th>
			<td>
				<input type='text' id='iVencimientoAplicar' name='iVencimientoAplicar' size="5px">
			</td>
			<td align="center">
				<input type="button" id="btnAplicarVencimiento" name="btnAplicarVencimiento" value="Aplicar" onclick="aplicarDias('iVencimientoAplicar', 'dFechaVencimiento');"/>
			</td>
			<th width="100px" align="right">
				 Mora:
			</th>
			<td>
				<input type='text' id='iMoraAplicar' name='iMoraAplicar' size="5px">
			</td>
			<td align="center">
				<input type="button" id="btnAplicar" name="btnAplicar" value="Aplicar"  onclick="aplicarDias('iMoraAplicar', 'dFechaMora');"/>
			</td>
		</tr>
	</table>
	<br>
</div>

<?php 
	$sScript = "<script type='text/javascript'>";
	//$sScript="";
	$sDiv = "<div id='divCalendario' style='display:block;'>";
	$sFila = 
	"<table width='800px' class='TablaCalendario'>
		<tr class='filaPrincipal'>
			<th class='borde' style='height:25px'>Periodo</th>			
			<th class='borde' style='height:25px'>Cierre</th>
			<th class='borde' style='height:25px'>Vencimiento</th>	
			<th class='borde' style='height:25px'>Mora</th>	
			<th class='borde' style='height:25px'>Tasa Punitorio Peso</th>
			<th class='borde' style='height:25px'>Tasa Financiacion Peso</th>
			<th class='borde' style='height:25px'>Tasa Compensatorio Peso</th>
			<th class='borde' style='height:25px'>Tasa Financiacion Dolar</th>
			<th class='borde' style='height:25px'>Tasa Punitorio Dolar</th>
			<th class='borde' style='height:25px'>Tasa Compensacion Dolar</th>
			<th class='borde' style='height:25px'>Tasa Interes Adelantos</th>
		</tr>";
			
	
		for ($i=1; $i<= 12; $i++) 
		{			
			$sScript .= "InputMask('dFechaVencimiento".$i."','99/99/9999');InputMask('dFechaCierre".$i."','99/99/9999'); InputMask('dFechaMora".$i."','99/99/9999');";
			
			$sFila .= 
			"<tr>
				<td id='tdPeriodo".$i."'>
					<input class='textTabla' type='text' id='dPeriodo".$i."' name='dPeriodo".$i."' readonly />
					<input class='textTabla' type='hidden' name='idCalendario".$i."'  id='idCalendario".$i."' value='0'>
				</td>
				<td ><input class='textTabla' type='text' id='dFechaCierre".$i."' name='dFechaCierre".$i."' onblur='validarFechaCierre(this.value, $i)' /></td>				
				<td ><input class='textTabla' type='text' id='dFechaVencimiento".$i."' name='dFechaVencimiento".$i."' onblur='validarFechaVencimiento(this.value, $i)' /></td>
				<td ><input class='textTabla' type='text' id='dFechaMora".$i."' name='dFechaMora".$i."' onblur='validarFechaMora(this.value, $i)' /></td>												
				<td ><input class='textTabla' type='text' id='fTasaPunitorioPeso".$i."' name='fTasaPunitorioPeso".$i."' onblur='this.value=numero_parse_flotante(this.value)' /></td>
				<td ><input class='textTabla' type='text' id='fTasaFinanciacionPeso".$i."' name='fTasaFinanciacionPeso".$i."' onblur='this.value=numero_parse_flotante(this.value)' /></td>
				<td ><input class='textTabla' type='text' id='fTasaCompensatorioPeso".$i."' name='fTasaCompensatorioPeso".$i."' onblur='this.value=numero_parse_flotante(this.value)' /></td>
				<td ><input class='textTabla' type='text' id='fTasaFinanciacionDolar".$i."' name='fTasaFinanciacionDolar".$i."' onblur='this.value=numero_parse_flotante(this.value)' /></td>
				<td ><input class='textTabla' type='text' id='fTasaPunitorioDolar".$i."' name='fTasaPunitorioDolar".$i."' onblur='this.value=numero_parse_flotante(this.value)'/></td>
				<td ><input class='textTabla' type='text' id='fTasaCompensacionDolar".$i."' name='fTasaCompensacionDolar".$i."' onblur='this.value=numero_parse_flotante(this.value)'/></td>
				<td ><input class='textTabla' type='text' id='fTasaInteresAdelantos".$i."' name='fTasaInteresAdelantos".$i."' onblur='this.value=numero_parse_flotante(this.value)'/></td>
				</tr>";
		}
				
	$sFila .= "</table>";
	$sScript .= "</script>";

	echo $sDiv. $sFila . $sScript . "</div>";	
	//echo $sScript;
?>

</form>


<script type="text/javascript">

	var gsMensajeFechaVencimiento = "";
	var gsMensajeFechaCierre = "";
	var gsMensajeFechaMora = "";
	
	function buscarCalendario()
	{
		xajax__buscarCalendarioFacturacion(xajax.getFormValues('formCalendario'), document.getElementById('dPeriodo').value);
		//xajax_updateDatosCalendarioFacturacion(xajax.getFormValues('formCalendario'));
	}
	
	
	function editarGrupoAfinidad(idGrupoAfinidad){
		window.location ="../AdminGruposAfinidades.php?idGrupoAfinidad="+ idGrupoAfinidad;
	}
	
	
	function validarFechaVencimiento(dFecha, iPeriodo)
	{	
		if(!validaFecha(dFecha))
		{
			var iPeriodo = document.getElementById("dPeriodo" + iPeriodo).value;
			gsMensajeFechaVencimiento = "Periodo " + iPeriodo + " - Revise la fecha de vencimiento.\n";			
		}
		else
		{
			gsMensajeFechaVencimiento = "";			
		}
	}	
	
	function validarFechaCierre(dFecha, iPeriodo)
	{			
		if(!validaFecha(dFecha))
		{
			var iPeriodo = document.getElementById("dPeriodo" + iPeriodo).value;
			gsMensajeFechaCierre = "Periodo " + iPeriodo + " - Revise la fecha de cierre.\n";			
		}
		else
		{
			gsMensajeFechaCierre = "";			
		}	
	}
	
	function validarFechaMora(dFecha, iPeriodo)
	{	
		if(!validaFecha(dFecha))
		{
			var iPeriodo = document.getElementById("dPeriodo" + iPeriodo).value;
			gsMensajeFechaMora = "Periodo " + iPeriodo + " - Revise la fecha de Mora.\n";			
		}
		else
		{
			gsMensajeFechaMora = "";			
		}
	}
	
		
	function resetearCalendario()
	{
		for(i=1;i<=12;i++)
		{
			document.getElementById("idCalendario" + i).value = "0";
			document.getElementById("dPeriodo" + i).value = "";
			document.getElementById("dFechaVencimiento" + i).value = "";
			document.getElementById("dFechaMora" + i).value = "";
			document.getElementById("dFechaCierre" + i).value = "";
			document.getElementById("fTasaPunitorioPeso" + i).value = "";
			document.getElementById("fTasaFinanciacionPeso" + i).value = "";
			document.getElementById("fTasaCompensatorioPeso" + i).value = "";
			document.getElementById("fTasaFinanciacionDolar" + i).value = "";
			document.getElementById("fTasaPunitorioDolar" + i).value = "";
			document.getElementById("fTasaCompensacionDolar" + i).value = "";
			document.getElementById("fTasaInteresAdelantos" + i).value = "";
		}		
		
		document.getElementById("sAccion").value = "new";
		
		div = document.getElementById("divPeriodo");
		div.style.display = "block";
	}

	
	
	function aplicarPeriodo()
	{	
		if(document.getElementById("iPeriodoAplicar").value.length < 4)
		{
			alert("Ingrese correctamente el periodo (yyyy)");
			return;
		}
		
		var iPeriodo = document.getElementById("iPeriodoAplicar").value;						
		var sMes = "";	
		
		for(i = 1; i <=12; i++)
		{			
			if(i < 10)
			{
				sMes = "0" + i;
			}
			else
			{
				sMes = i;
			}
			
			document.getElementById("dPeriodo" + i).value  = sMes+"/"+ iPeriodo;
			//alert(document.getElementById("dPeriodo" + i).value);
			
		}		
	}
	
	
	function aplicarDias(txt, txtAplicar)
	{	
		var iDia = document.getElementById(txt).value; 
				
		if(document.getElementById(txt).value < 0 || document.getElementById(txt).value > 31)
		{
			alert("Ingrese correctamente el dia de cierre");
			return;
		}
		
		var iPeriodo = document.getElementById("iPeriodoAplicar").value;	

		if(document.getElementById("iPeriodoAplicar").value.length < 4)
		{
			alert("Ingrese correctamente el periodo (yyyy)");
			return;
		}
			
		var sMes = "";	
		
		for(i = 1; i <=12; i++)
		{			
			if(i < 10)
			{
				sMes = "0" + i;
			}
			else
			{
				sMes = i;
			}
			
			document.getElementById(txtAplicar + i).value  = iDia + "/" + sMes+"/"+ iPeriodo;
			//alert(document.getElementById("dPeriodo" + i).value);
		}		
	}
	
	function saveDatos()
	{		
		if(!validarDatosPeriodo())
		{
			return;
		}
		
		var Formu = document.forms['formCalendario'];		
		xajax_updateDatosCalendarioFacturacion(xajax.getFormValues('formCalendario'));				
	}
	
	
	function validarDatosPeriodo()
	{
		var sPeriodo = "";
		var sMensaje = "";
		
		for(i=1; i<=12; i++)
		{		
			//alert(document.getElementById("dFechaVencimiento" + i).value);
			sPeriodo = document.getElementById("dPeriodo" + i).value;							
			
			if(document.getElementById("dPeriodo" + i).value == "")
			{
				sMensaje += "El campo Periodo es obligatorio. \n";
			}
			
			if (document.getElementById("dFechaVencimiento" + i).value == "")
			{
				sMensaje += "Periodo " + sPeriodo + ". El campo Fecha Vencimiento es obligatorio. \n";
			}		

			if (document.getElementById("dFechaCierre" + i).value == "")
			{
				sMensaje += "Periodo " + sPeriodo + ". El campo Fecha Cierre es obligatorio. \n";
			}		
			
			if (document.getElementById("dFechaMora" + i).value == "")
			{
				sMensaje += "Periodo " + sPeriodo + ". El campo Fecha Mora es obligatorio. \n";
			}		
			
			dPeriodo = "01/" + document.getElementById("dPeriodo" + i).value;
			dFechaCierre = document.getElementById("dFechaCierre" + i).value;
			dFechaVencimiento = document.getElementById("dFechaVencimiento" + i).value;
			dFechaMora = document.getElementById("dFechaMora" + i).value;
			
			sMensaje += validarRangoDeFechas(dFechaCierre, dFechaVencimiento, 'Fecha de cierre', 'Fecha de vencimiento', sPeriodo);		
			sMensaje += validarRangoDeFechas(dPeriodo, dFechaVencimiento, 'Fecha de periodo', 'Fecha de vencimiento', sPeriodo);	
			sMensaje += validarRangoDeFechas(dFechaVencimiento, dFechaMora, 'Fecha de vencimiento', 'Fecha de Mora', sPeriodo);	
			sMensaje += validarRangoDeFechas(dPeriodo, dFechaCierre, 'Fecha de periodo', 'Fecha de cierre', sPeriodo);	
			
			if (document.getElementById("fTasaPunitorioPeso" + i).value == "")
			{
				sMensaje += "Periodo " + sPeriodo + ". El campo Tasa Punitorio Peso es obligatorio. \n";
			}
			
			if (document.getElementById("fTasaFinanciacionPeso" + i).value == "")
			{
				sMensaje += "Periodo " + sPeriodo + ". El campo Tasa Financiacion Peso es obligatorio. \n";
			}
			
			if (document.getElementById("fTasaCompensatorioPeso" + i).value == "")
			{
				sMensaje += "Periodo " + sPeriodo + ". El campo Tasa Compensatorio Peso es obligatorio. \n";
			}
			
			if (document.getElementById("fTasaFinanciacionDolar" + i).value == "")
			{
				sMensaje += "Periodo " + sPeriodo + ". El campo Tasa Financiacion Dolar es obligatorio. \n";
			}
			
			if (document.getElementById("fTasaPunitorioDolar" + i).value == "")
			{
				sMensaje += "Periodo " + sPeriodo + ". El campo Tasa Punitorio Dolar es obligatorio. \n";
			}
			
			if (document.getElementById("fTasaCompensacionDolar" + i).value == "")
			{
				sMensaje += "Periodo " + sPeriodo + ". El campo Tasa Compensacion Dolar es obligatorio. \n";
			}
			
			if (document.getElementById("fTasaInteresAdelantos" + i).value == "")
			{
				sMensaje += "Periodo " + sPeriodo + ". El campo Tasa Interes para Adelantos es obligatorio. \n";
			}
		}
		
		sMensaje =  gsMensajeFechaVencimiento + gsMensajeFechaCierre + gsMensajeFechaMora + sMensaje;
		
		if(sMensaje)
		{
			alert(sMensaje);
			return false;			
		}
		
		return true;
	}

//ejemplo de como usar num de fechas	
function numDias(d,m,a)
{
  m = (m + 9) % 12;
  a = a - Math.floor(m/10);
  return 365*a+Math.floor(a/4)-Math.floor(a/100)+Math.floor(a/400)
            +Math.floor((m*306+5)/10)+d-1 
}

function dateComapreTo(yy1, mm1, dd1, yy2, mm2, dd2) 
{
	var f1 =  new Date(yy1, mm1, dd1);
	var f2 =  new Date(yy2, mm2, dd2);
	return f1.getTime() - f2.getTime();
}	

function validarRangoDeFechas(pdFechaDesde, pdFechaHasta, psNombreFechaDesde, psNombreFechaHasta, sPeriodo)
{		
	sMensaje = "";
	
	//alert("desde " + pdFechaDesde + " - hasta " + pdFechaHasta);
	
	var sDesde = pdFechaDesde;
	var sHasta = pdFechaHasta;	
		
	var aFDesde = sDesde.split('/');
	var aFHasta = sHasta.split('/');
		 
	//alert(psNombreFechaDesde + " " + sDesde);
	 
	if(sDesde != "" && sHasta != "" )
	{
	 	 //var iResultado = numDias(parseInt(aFHasta[0]),parseInt(aFHasta[1]),parseInt(aFHasta[2])) - numDias(parseInt(aFDesde[0]),parseInt(aFDesde[1]),parseInt(aFDesde[2]));
	 	 var iResultado = dateComapreTo(aFDesde[2], aFDesde[1], aFDesde[0], aFHasta[2],aFHasta[1], aFHasta[0]);
	 	 	
	 	  	 
	 	 if(iResultado >= 0) // La primer fecha es mayor; < 0 la 1er fecha es menor; 0 Son iguales
	 	 {
	 	 	sMensaje = "Periodo " + sPeriodo + " - La " + psNombreFechaDesde + " no puede ser mayor o igual a la " + psNombreFechaHasta + ". \n";
	 	 }    
	 }
	 
	 return sMensaje;
}

/*function validarRangoDeFechas(pdFechaDesde, pdFechaHasta, psNombreFechaDesde, psNombreFechaHasta, sPeriodo)
{
	sMensaje = "";
	
	//alert("desde " + pdFechaDesde + " - hasta " + pdFechaHasta);
	
	var sDesde = pdFechaDesde;
	var sHasta = pdFechaHasta;	
		
	var aFDesde = sDesde.split('/');
	var aFHasta = sHasta.split('/');
		 
	 //alert(psNombreFechaDesde + " " + sDesde);
	 
	if(sDesde != "" && sHasta != "" )
	{
	 	 var iResultado = numDias(parseInt(aFHasta[0]),parseInt(aFHasta[1]),parseInt(aFHasta[2])) - numDias(parseInt(aFDesde[0]),parseInt(aFDesde[1]),parseInt(aFDesde[2]));
	 	 
	 	 //alert(psNombreFechaDesde + " " + iResultado);
	 	 
	 	 if(iResultado <= 0)
	 	 {
	 	 	    sMensaje = "Periodo " + sPeriodo + " - La " + psNombreFechaDesde + " no puede ser mayor o igual a la " + psNombreFechaHasta + ". \n";
	 	 }    
	 }
	 
	 return sMensaje;
}*/

</script>

<?php // echo xhtmlFootPagina();?>