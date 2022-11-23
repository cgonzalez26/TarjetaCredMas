<div id="BODY">
<center>
	<div id='' style='width:65%;text-align:right;margin-right:10px;'>
		<a href="CuentasUsuarios.php" style='text-decoration:none;font-weight:bold;'>
			<img src='{IMAGES_DIR}/back.png' title='Volver a la Solicitud' alt='Volver a la Solicitud' border='0' hspace='4' align='absmiddle'> Volver</a>
	</div>
	<form id="formResumen" action="" method="POST">
	 	<input type='hidden' name='idCuentaUsuario' id="idCuentaUsuario" value='{ID_CUENTA}' />
	 	<input type='hidden' name='hdnIdGrupoAfinidad' id="hdnIdGrupoAfinidad" value='{ID_GRUPO_AFINIDAD}' />
	 	<input type='hidden' name='hdndPeriodo' id="hdndPeriodo" value='{PERIODO}' />
	 	
	 	
	 
		<fieldset id='cuadroOficina' style="height:auto;width:900px">
		<legend> Resumen de la Cuenta:</legend>	
		<table cellpadding="5" cellspacing="0" class="TablaGeneral" width="400px" border="0" style="height:30px">
			<tr>
				<th align=><div id="sEstado" align="center"  style="display:block">Estado: {ESTADO} </div></th>
			<th align="left"><div id="iDiasMora" align="center"  style="display:block">Dias de Mora: {DIAS_MORA}</div></th>
			</tr>
		</table>
		<table cellpadding="5" cellspacing="0" class="TablaGeneral" width="920px" border="0" style="height:30px">
		<tr>
			<td style="width:150px;"><b>Mes: </b><select id="idPeriodo" name="idPeriodo" onchange="cambiarResumen(this.value, this.options[2].selected)">{optionsCalendario}</select></td>		
			<td><input id="eliminaResumen" name="eliminaResumen" type="button" onclick="eliminarResumen()" style="display:none" value="Eliminar Resumen">&nbsp;
				<input id="imprimirResumen" name="imprimirResumen" type="button" onclick="imprimirResumenPorCuenta()" style="display:none" value="Imprimir Resumen">
			</td>			
		</tr>
		</table>
		<table id='TablaResumen' cellpadding="5" cellspacing="0" class="TablaGeneral" width="920px" border="1">
		  <tr>
		    <td height="80">
				<table cellpadding="5" cellspacing="0" border="1" width="100%" class="TablaGeneral" >    	
					<tr><td width="50%" >Nombre y Apellido</td><td>Nro de Cuenta</td></tr>
					<tr><td id="tdTitular">{TITULAR}</td><td id="tdNumeroCuenta">{NUMERO_CUENTA}</td></tr>
			
				<!--<table cellpadding="5" cellspacing="0" border="0" width="100%"> 
				<tr>
					<td>-->
			
					<tr><td colspan="2">&nbsp;&nbsp;Datos del Credito</td></tr>
					<!--<tr><td>Limite de Compra</td><td>Limite Disponible</td></tr>
					<tr><td id="tdLimiteCompra">{LIMITE_COMPRA}</td><td id="tdRemanenteCompra">{REMANENTE_COMPRA}</td></tr>-->
					<tr><td width="50%">Limite de Credito</td><td>Credito disponible</td></tr>
					<tr><td id="tdLimiteCredito">{LIMITE_CREDITO}</td><td id="tdRemanenteCredito">{REMANENTE_CREDITO}</td></tr>
				</table>
					<!--<td>
						<table cellpadding="5" cellspacing="0" border="1" width="100%" class="TablaGeneral" >
						<tr><td colspan="2">Cash</td></tr>
						<tr><td>Limite en Efectivo</td><td>Limite Disponible</td></tr>
						<tr><td id="tdLimiteAdelanto">{LIMITE_ADELANTO}</td><td id="tdRemanenteAdelanto">{REMANENTE_ADELANTO}</td></tr>
						</table>
					</td>
					<td>&nbsp;
						<table cellpadding="5" cellspacing="0" border="1" width="100%" class="TablaGeneral" >
						<tr><td colspan="2">SMS</td></tr>
						<tr><td>Limite de Credito</td><td>Limite Disponible</td></tr>
						<tr><td id="tdLimiteSms">{LIMITE_SMS}</td><td id="tdRemanenteSms">{REMANENTE_SMS}</td></tr>
						</table>
					</td>
				</tr>
				</table>	-->
		    </td>
		    <td rowspan="2" valign="top" width="140">
		    	<table id='Tabladatos' cellpadding="5" cellspacing="0" class="TablaGeneral" width="130" border="1">
		    	<tr><td>Fecha de Cierre:</td></tr>
		    	<tr><td id="tdFechaCierre" style="font-weight:bold">{FECHA_CIERRE}</td></tr>
		    	<tr><td>Fecha de Vto.:</td></tr>
		    	<tr><td id="tdFechaVto" style="font-weight:bold">{FECHA_VTO}</td></tr>
		    	<tr><td>Importe a Pagar:</td></tr>
		    	<tr><td id="tdImporteTotal" style="font-weight:bold">{IMPORTE_TOTAL}</td></tr>
		    	<tr><td>Fecha Prox Cierre:</td></tr>
		    	<tr><td id="tdFechaCierreProx">{FECHA_CIERRE_PROX}</td></tr>
		    	<tr><td>Fecha Prox Vto.:</td></tr>
		    	<tr><td id="tdFechaVtoProx">{FECHA_VTO_PROX}</td></tr>
		    	<tr><td>Socio desde:</td></tr>
		    	<tr><td id="tdFechaIncio">{FECHA_INICIO}</td></tr>
		    	</table>
		    </td>
		  </tr>
		  <tr>
		    <td valign="top" id="tdTablaResumen">{TABLA_DATOS}</td>
		  </tr>
		</table>
	</form>
	<script>
		  //document.formResumen.idPeriodo.options[2].selected = true;
		 document.getElementById("formResumen").idPeriodo.options[2].selected = true;
		 
		  function cambiarResumen(idPeriodo, bPeriodoActualSeleccionado){
		 	 var idCuenta = document.getElementById("idCuentaUsuario").value;
		 	 //alert(idCuenta+' -- '+idPeriodo);
		 	 /*window.location ="Resumen.php?id="+idCuenta+"&idPeriodo="+idPeriodo;*/
		 	 
		 	 //alert(bPeriodoActualSeleccionado);
		 	 
		 	 xajax_cambiarResumen(idCuenta,idPeriodo, bPeriodoActualSeleccionado);
		 }
		 
		 
		 function eliminarResumen(){
	 	  	 var indice = document.getElementById("idPeriodo").selectedIndex;
	 	  	 var textoEscogido = document.getElementById("idPeriodo").options[indice].text;
		 	 var idCuenta = document.getElementById("idCuentaUsuario").value;
		 	 var idGrupoAfinidad = document.getElementById("hdnIdGrupoAfinidad").value;
		 	 
		 	 if(confirm("Esta seguro que desea eliminar el Resumen del Periodo "+textoEscogido+"?")){
		 	 	xajax_eliminarResumen(idGrupoAfinidad,idCuenta,textoEscogido);
		 	 }
		 }
		 
		 function imprimirResumenPorCuenta(){
		 	var idCuentaUsuario = document.getElementById("idCuentaUsuario").value;
		 	var indice = document.getElementById("idPeriodo").selectedIndex;
 	  	    var dPeriodo = document.getElementById("idPeriodo").options[indice].text;
 	  	    var idGrupoAfinidad = document.getElementById("hdnIdGrupoAfinidad").value;
 	  	    
	  	    var mensaje="Esta seguro de Reimprimir el Resumen del Periodo "+dPeriodo+"?"; 
  	     	if(confirm(mensaje)){
		 		xajax_imprimirResumen(idCuentaUsuario,idGrupoAfinidad,dPeriodo);
  	     	}
		 }
	</script>
		