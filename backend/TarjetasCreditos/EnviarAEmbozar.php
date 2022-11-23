<?php 
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];
$aParametros = array();
$aParametros = getParametrosBasicos(1);

global $oMysql;
$sTarjetas = $_GET['sTarjetas'];
$operacion = $_GET['operacion'];
$mostrarEmbozar = "";
$mostrarReembozar = "";
$sTitulo = "";
if($operacion == 1){
	$mostrarEmbozar .= "style='display:inline'";
	$mostrarReembozar .= "style='display:none'";
	$sTitulo .= "Enviar a Embozar Tarjetas de Creditos";
}else{
	$mostrarReembozar .= "style='display:inline'";
	$mostrarEmbozar .= "style='display:none'";
	$sTitulo .= "Enviar a Reembozar Tarjetas de Creditos";
}

$optionsEmpresas = $oMysql->getListaOpciones( 'EmpresasEmbosadoras', 'id', 'sNombre');

	$oXajax=new xajax();	
	$oXajax->registerFunction("embozarTarjetasCreditos1");
	$oXajax->registerFunction("reembozarTarjetasCreditos");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

function embozarTarjetasCreditos1($form){
	GLOBAL $oMysql;	
	$oRespuesta = new xajaxResponse();
	$sTarjetas = $form['sTarjetas'];
	$aTarjetas = explode(",",$sTarjetas);
	
	$sePuedeEmbozar = false;
	$sTarjetasFallidas = "";
	foreach ($aTarjetas as $idTarjeta){
		$aTipoEstado =$oMysql->consultaSel("SELECT Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id={$idTarjeta}",true);
		if($aTipoEstado['idTipoEstadoTarjeta'] ==1){
			$sePuedeEmbozar = true;break;
		}else{
			$sTarjetasFallidas .= " La Tarjeta con Nro. ".$aTipoEstado['sNumeroTarjeta']. " no se pudo Embozar su estado es: ".$aTipoEstado['sEstado']."<br>";
		}
	}
	if($sePuedeEmbozar)	{
		$sNumeroPedido = generarNumeroPedidoDeLotes();
	    $setLote = "sNumeroPedido,idEmpresaEmbosadora,dFechaRegistro,idEmpleado,idTipoEstadoLoteEmbosaje";
	    //idTipoEstadoLoteEmbosaje=1 significa LOTE ENVIADO A EMBOZAR
	    $valuesLote = "'{$sNumeroPedido}',1,NOW(),{$_SESSION['id_user']},1";
		$ToAuditoryLote = "Insercion de Lotes de Embosajes ::: Empleado ={$_SESSION['id_user']}";
		$idLoteEmbosaje = $oMysql->consultaSel("CALL usp_InsertTable(\"LotesEmbosajes\",\"$setLote\",\"$valuesLote\",\"{$_SESSION['id_user']}\",\"41\",\"$ToAuditoryLote\");",true);   
		//$oRespuesta->alert($idLoteEmbosaje);
		
		$setEstadoLote = "idLoteEmbosaje,idEmpleado,idTipoEstadoLoteEmbosaje,dFechaRegistro,sMotivo";
		$valuesEstadoLote = "'{$idLoteEmbosaje}','{$_SESSION['id_user']}','1',NOW(),''";
		$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$idLoteEmbosaje} ::: estado=1";
		$idEstadoLoteEmbosaje =$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesEmbosajes\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"30\",\"$ToAuditoryEstadoLote\");",true); 	
		//$oRespuesta->alert($idEstadoLoteEmbosaje);
		$sTarjetasFallidas = "";
		$sTarjetasEmbozadas = "";
		$aTarjetasEmbozadas = array();
		foreach ($aTarjetas as $idTarjeta){
			$aTipoEstado =$oMysql->consultaSel("SELECT Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id={$idTarjeta}",true);
			if($aTipoEstado['idTipoEstadoTarjeta'] ==1){
				$setLoteTarjeta = "idLoteEmbosaje,idTarjeta,idtipoEstadoTarjeta";
				$valuesLoteTarjeta = "'{$idLoteEmbosaje}','{$idTarjeta}',1";
				$idLoteTarjeta = $oMysql->consultaSel("CALL usp_InsertValues(\"LotesTarjetas\",\"$setLoteTarjeta\",\"$valuesLoteTarjeta\");",true);		
				$aTarjetasEmbozadas[] = $aTipoEstado['sNumeroTarjeta'];
			}else{
				$sTarjetasFallidas .= " La Tarjeta con Nro. ".$aTipoEstado['sNumeroTarjeta']. " no se pudo Embozar su estado es: ".$aTipoEstado['sEstado'];
			}
		}
		if(count($aTarjetasEmbozadas) >0)
			$sTarjetasEmbozadas.= "Tarjetas Embozadas: ".implode(", ",$aTarjetasEmbozadas);
		$sMsje = "El Numero de Lote es : ".$sNumeroPedido." <br> La operacion se realizo correctamente.<br>";
		if($sTarjetasEmbozadas != "") $sMsje .= "<br>".$sTarjetasEmbozadas;
		if($sTarjetasFallidas != "") $sMsje .= "<br>".$sTarjetasFallidas;
	}else{
		$sMsje = "No se pudo generar un Lote de Embozo <br>" .$sTarjetasFallidas;
	}	
	$oRespuesta->assign("tdContent","innerHTML",$sMsje);
	$oRespuesta->assign("btnEmbozar","style.display","none");	  
	return  $oRespuesta;
}


function reembozarTarjetasCreditos($form){
	GLOBAL $oMysql;	
	$oRespuesta = new xajaxResponse();
	$sTarjetas = $form['sTarjetas'];
	$aTarjetas = explode(",",$sTarjetas);
	
	$sePuedeEmbozar = false;
	$sTarjetasFallidas = "";
	foreach ($aTarjetas as $idTarjeta){
		$aTipoEstado =$oMysql->consultaSel("SELECT Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id={$idTarjeta}",true);
		if($aTipoEstado['idTipoEstadoTarjeta'] ==14){
			$sePuedeEmbozar = true;break;
		}else{
			$sTarjetasFallidas .= " La Tarjeta con Nro. ".$aTipoEstado['sNumeroTarjeta']. " no se pudo Reembozar su estado es: ".$aTipoEstado['sEstado']."<br>";
		}
	}
	if($sePuedeEmbozar)	{
		$sNumeroPedido = generarNumeroPedidoDeLotes();
	    $setLote = "sNumeroPedido,idEmpresaEmbosadora,dFechaRegistro,idEmpleado,idTipoEstadoLoteEmbosaje";
	    //idTipoEstadoLoteEmbosaje=1 significa LOTE ENVIADO A EMBOZAR
	    $valuesLote = "'{$sNumeroPedido}',1,NOW(),{$_SESSION['id_user']},1";
		$ToAuditoryLote = "Insercion de Lotes de Embosajes ::: Empleado ={$_SESSION['id_user']}";
		$idLoteEmbosaje = $oMysql->consultaSel("CALL usp_InsertTable(\"LotesEmbosajes\",\"$setLote\",\"$valuesLote\",\"{$_SESSION['id_user']}\",\"41\",\"$ToAuditoryLote\");",true);   
		//$oRespuesta->alert($idLoteEmbosaje);
		
		$setEstadoLote = "idLoteEmbosaje,idEmpleado,idTipoEstadoLoteEmbosaje,dFechaRegistro,sMotivo";
		$valuesEstadoLote = "'{$idLoteEmbosaje}','{$_SESSION['id_user']}','1',NOW(),''";
		$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Embosajes ::: Empleado ={$_SESSION['id_user']} ::: idLoteEmbosaje={$idLoteEmbosaje} ::: estado=1";
		$idEstadoLoteEmbosaje =$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesEmbosajes\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"30\",\"$ToAuditoryEstadoLote\");",true); 	
		//$oRespuesta->alert($idEstadoLoteEmbosaje);
		$sTarjetasFallidas = "";
		$sTarjetasEmbozadas = "";
		$aTarjetasEmbozadas = array();
		foreach ($aTarjetas as $idTarjeta){
			$aTipoEstado =$oMysql->consultaSel("SELECT Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id={$idTarjeta}",true);
			if($aTipoEstado['idTipoEstadoTarjeta'] ==14){
				$setTarjeta = "idTipoEstadoTarjeta=19";
			  	$conditionsTarjeta = "Tarjetas.id={$idTarjeta}";
			  	$ToAuditoryTarjeta = "Modificacion de Tarjetas de Creditos de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta}";		
				$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$setTarjeta\",\"$conditionsTarjeta\",\"{$_SESSION['id_user']}\",\"27\",\"$ToAuditoryTarjeta\");",true);  
				
				$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
				$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','19',NOW(),''";
				$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=19";
				$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true); 
				
				$setLoteTarjeta = "idLoteEmbosaje,idTarjeta,idtipoEstadoTarjeta";
				$valuesLoteTarjeta = "'{$idLoteEmbosaje}','{$idTarjeta}',1";
				$idLoteTarjeta = $oMysql->consultaSel("CALL usp_InsertValues(\"LotesTarjetas\",\"$setLoteTarjeta\",\"$valuesLoteTarjeta\");",true);		
				$aTarjetasEmbozadas[] = $aTipoEstado['sNumeroTarjeta'];
			}else{
				$sTarjetasFallidas .= " La Tarjeta con Nro. ".$aTipoEstado['sNumeroTarjeta']. " no se pudo Embozar su estado es: ".$aTipoEstado['sEstado'];
			}
		}
		if(count($aTarjetasEmbozadas) >0)
			$sTarjetasEmbozadas.= "Tarjetas Embozadas: ".implode(", ",$aTarjetasEmbozadas);
		$sMsje = "El Numero de Lote es : ".$sNumeroPedido." <br> La operacion se realizo correctamente.<br>";
		if($sTarjetasEmbozadas != "") $sMsje .= "<br>".$sTarjetasEmbozadas;
		if($sTarjetasFallidas != "") $sMsje .= "<br>".$sTarjetasFallidas;
	}else{
		$sMsje = "No se pudo generar un Lote de Embozo <br>" .$sTarjetasFallidas;
	}	
	$oRespuesta->assign("tdContent","innerHTML",$sMsje);
	$oRespuesta->assign("btnReembozar","style.display","none");
	  	
	return  $oRespuesta;
}
?>
<script>
function cerrarVentana(){
	parent.recargar(this);
}

function validarDatosForm() 
{
	var Formu = document.forms['formEmbozar'];
	var errores = '';
	 
	with (Formu){
		if( idEmpresaEmbosadora.value == 0 )	
		errores += "- El campo Empresa Embosadora es requerido.\n";
	}
	if( errores ) { alert(errores); return false; } 
	else return true;
}

function embozarTarjetasCreditos(){
	if(validarDatosForm()){
		xajax_embozarTarjetasCreditos1(xajax.getFormValues('formEmbozar'));
	}
}

function reembozarTarjetasCreditos(){
	if(validarDatosForm()){
		xajax_reembozarTarjetasCreditos(xajax.getFormValues('formEmbozar'));
	}
}
</script>
<body style="background-color:#ffffff;">
<form id="formEmbozar" action="EnviarAEmbozar.php" method="POST">
<input type="hidden" id="sTarjetas"  name="sTarjetas" value="<? echo $sTarjetas;?>" />
<input type="hidden" id="operacion"  name="operacion" value="<? echo $operacion;?>" />

<center>
	<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='0' bordercolor='#000000' width='98%' >
	<tr>
		<td align="center" style="height:25px"><b><?echo $sTitulo;?></b></td>
	</tr>
	<tr><td style="height:20px">&nbsp;</td></tr>
	<tr>
		<td align="left" style="height:25px" id="tdContent">
			<span style="">(*)Empresa Embozadora :&nbsp;
			<select id="idEmpresaEmbosadora" name="idEmpresaEmbosadora">
			<? echo $optionsEmpresas; ?>
			</select></span>
		</td>
	</tr>
	<tr><td style="height:50px">&nbsp;</td></tr>
	<tr>
		<td align="center" style="height:25px"><button type="button" onclick="embozarTarjetasCreditos();" id="btnEmbozar" name="btnEmbozar" <? echo $mostrarEmbozar?> > Embozar </button>&nbsp;
		<button type="button" onclick="reembozarTarjetasCreditos();" id="btnReembozar" name="btnReembozar" <? echo $mostrarReembozar?> > Reembozar </button>
			<!--<button type="button" onclick="javascript:parent.closeWindows();" >Cerrar </button>--></td>
	</tr>
	</table>
</center>
</form>
</body>
</html>