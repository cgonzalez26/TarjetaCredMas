<?php 
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$idUser = $_SESSION['id_user'];
$TypeUser = $_SESSION['id_tuser'];
$aParametros = array();
$aParametros = getParametrosBasicos(1);

global $oMysql;
$sTarjetas = $_GET['sTarjetas'];

$optionsCorreos = $oMysql->getListaOpciones( 'Correos', 'id', 'sNombre');
	
	$oXajax=new xajax();	
	$oXajax->registerFunction("enviarACorreoTarjetasCreditos");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

function enviarACorreoTarjetasCreditos($form){
	GLOBAL $oMysql;	
	$oRespuesta = new xajaxResponse();
	$sTarjetas = $form['sTarjetas'];
	$aTarjetas = explode(",",$sTarjetas);
	
	$sePuedeEmbozar = false;
	$sTarjetasFallidas = "";
	foreach ($aTarjetas as $idTarjeta){
		$aTipoEstado =$oMysql->consultaSel("SELECT Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id={$idTarjeta}",true);
		if($aTipoEstado['idTipoEstadoTarjeta'] ==2){
			$sePuedeEmbozar = true;break;
		}else{
			$sTarjetasFallidas .= " La Tarjeta con Nro. ".$aTipoEstado['sNumeroTarjeta']. " no se pudo Enviar a Correo su estado es: ".$aTipoEstado['sEstado']."<br>";
		}
	}
	if($sePuedeEmbozar)	{
		$sNumeroPedido = generarNumeroPedidoDeLotesCorreo();
	    $setLote = "sNumeroPedido,idCorreo,dFechaRegistro,idEmpleado,idTipoEstadoLoteCorreo";
	    //idTipoEstadoLoteCorreo=1 significa EN DISTRIBUCION
	    $valuesLote = "'{$sNumeroPedido}',1,NOW(),{$_SESSION['id_user']},1";
		$ToAuditoryLote = "Insercion de Lotes de Correos Postales ::: Empleado ={$_SESSION['id_user']}";
		$idLoteCorreo = $oMysql->consultaSel("CALL usp_InsertTable(\"LotesCorreos\",\"$setLote\",\"$valuesLote\",\"{$_SESSION['id_user']}\",\"50\",\"$ToAuditoryLote\");",true);   
		//$oRespuesta->alert($idLoteCorreo);
		
		$setEstadoLote = "idLoteCorreo,idEmpleado,idTipoEstadoLoteCorreo,dFechaRegistro,sMotivo";
		$valuesEstadoLote = "'{$idLoteCorreo}','{$_SESSION['id_user']}','1',NOW(),''";
		$ToAuditoryEstadoLote = "Insercion Historial de Estados de Lotes Correos Postales ::: Empleado ={$_SESSION['id_user']} ::: idLoteCorreo={$idLoteCorreo} ::: estado=1";
		$idEstadoLoteCorreo =$oMysql->consultaSel("CALL usp_InsertTable(\"EstadosLotesCorreos\",\"$setEstadoLote\",\"$valuesEstadoLote\",\"{$_SESSION['id_user']}\",\"52\",\"$ToAuditoryEstadoLote\");",true); 		
		//$oRespuesta->alert($idEstadoLoteCorreo);
		$sTarjetasFallidas = "";
		$sTarjetasEnviadas = "";
		$aTarjetasEnviadas = array();
		foreach ($aTarjetas as $idTarjeta){
			$aTipoEstado =$oMysql->consultaSel("SELECT Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id={$idTarjeta}",true);
			if($aTipoEstado['idTipoEstadoTarjeta'] ==2){
				$setLoteTarjeta = "idLoteCorreo,idTarjeta,idTipoEstadoTarjeta";
				$valuesLoteTarjeta = "'{$idLoteCorreo}','{$idTarjeta}',3";
				$idLoteTarjeta = $oMysql->consultaSel("CALL usp_InsertValues(\"LotesCorreosTarjetas\",\"$setLoteTarjeta\",\"$valuesLoteTarjeta\");",true);			
				
				$set = "Tarjetas.idTipoEstadoTarjeta = '3'";
		    	$conditions = "Tarjetas.id = '{$idTarjeta}'";
				$ToAuditory = "Update Estado de Tarjeta de Credito ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=2";	
				$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$set\",\"$conditions\",\"{$_SESSION['id_user']}\",\"42\",\"$ToAuditory\");",true);    		
		
				$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
				$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','3',NOW(),''";
				$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=3";
				$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true); 
				$aTarjetasEnviadas[] = $aTipoEstado['sNumeroTarjeta'];
			}else{
				$sTarjetasFallidas .= " La Tarjeta con Nro. ".$aTipoEstado['sNumeroTarjeta']. " no se pudo Enviar a Correo su estado es: ".$aTipoEstado['sEstado'];
			}
			
			//$oRespuesta->alert($idEstadotarjeta);
		}
		if(count($aTarjetasEnviadas) >0)
			$sTarjetasEnviadas.= "Tarjetas Embozadas: ".implode(", ",$aTarjetasEnviadas);
		$sMsje = "El Numero de Lote es : ".$sNumeroPedido." <br> La operacion se realizo correctamente.<br>";
		if($sTarjetasEnviadas != "") $sMsje .= "<br>".$sTarjetasEnviadas;
		if($sTarjetasFallidas != "") $sMsje .= "<br>".$sTarjetasFallidas;
	}else{
		$sMsje = "No se pudo generar un Lote de Envio a Correo <br>" .$sTarjetasFallidas;
	}
	//$oRespuesta->assign("tdContent","innerHTML","El Numero de Lote es : $sNumeroPedido <br> La operacion se realizo correctamente");
	$oRespuesta->assign("tdContent","innerHTML",$sMsje);
	$oRespuesta->assign("btnEnviar","style.display","none");
	return  $oRespuesta;
}

?>
<script>

function validarDatosForm() 
{
	var Formu = document.forms['formEnviar'];
	var errores = '';
	 
	with (Formu)
	{
		if( idCorreo.value == 0 )	
		errores += "- El campo Correo Postal es requerido.\n";
	}
	if( errores ) { alert(errores); return false; } 
	else return true;
}

function enviarACorreosTarjetasCreditos(){		
	if(validarDatosForm()){		
		xajax_enviarACorreoTarjetasCreditos(xajax.getFormValues('formEnviar'));
	}
}
</script>
<body style="background-color:#ffffff;">

<form id="formEnviar" action="EnviarLoteACorreo.php" method="POST">
<input type="hidden" id="sTarjetas" name="sTarjetas" value="<? echo $sTarjetas;?>" />
<center>
	<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='0' bordercolor='#000000' width='98%' >
	<tr>
		<td align="center" style="height:25px"><b>Enviar a Correo Postal Tarjetas de Creditos</b></td>
	</tr>
	<tr><td style="height:20px">&nbsp;</td></tr>
	<tr>
		<td align="left" style="height:25px" id="tdContent"><span style="">(*)Correo Postal :&nbsp;
			<select id="idCorreo" name="idCorreo">
			<? echo $optionsCorreos; ?>
			</select></span>
		</td>
	</tr>
	<tr><td style="height:25px">&nbsp;</td></tr>
	<tr><td align="center" style="height:25px"><button type="button" onclick="enviarACorreosTarjetasCreditos();" id="btnEnviar" name="btnEnviar"> Enviar </button>
	<!--<button type="button" onclick="javascript:closeMessage();" >Cerrar </button>--></td></tr>
	</table>	
</center>
</form>
</body>
</html>