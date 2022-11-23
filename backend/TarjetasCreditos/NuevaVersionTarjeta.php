<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
	
	$sTarjetas = $_GET['sTarjetas'];
	
	$aTarjetasCreditos = explode(",",$sTarjetas);
	$aTarjetas = array();
	foreach ($aTarjetasCreditos as $idTarjeta){
		$aTipoEstado =$oMysql->consultaSel("SELECT Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id={$idTarjeta}",true);
		$aTarjetas[] = $aTipoEstado['sNumeroTarjeta'];
	}
	$sNumerosTarjetas = implode(", ",$aTarjetas);
	
	function nuevasVersionesTarjetasCreditos($form){ //NUEVAS VERSIONES DE TARJETAS DE CREDITOS
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$aTarjetas = explode(",",$form['sTarjetas']);
		$sMensaje = "";
		foreach ($aTarjetas as $idTarjeta){
			$aTipoEstado =$oMysql->consultaSel("SELECT Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id={$idTarjeta}",true);
			if($aTipoEstado['idTipoEstadoTarjeta'] ==10 || $aTipoEstado['idTipoEstadoTarjeta'] ==11 || $aTipoEstado['idTipoEstadoTarjeta'] ==12){
				
				$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
				$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','18',NOW(),''";
				$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=18";
				$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true); 
				
				$sCondiciones = " WHERE Tarjetas.id ={$idTarjeta}";
				$sqlDatos="Call usp_getTarjetas(\"$sCondiciones\");";
				$rs = $oMysql->consultaSel($sqlDatos,true);
				
				$sNumero = substr($rs['sNumeroTarjeta'],0,13);  	
			  	$sNumeroTarjeta = $sNumero . "01";
			  	$sNumeroTarjeta = $sNumeroTarjeta .luhn($sNumeroTarjeta);
			  	
			  	$setTarjeta = "idUsuario,idCuentaUsuario,idBIN,idTipoTarjeta,sNumeroTarjeta,iVersion,dVigenciaDesde,dVigenciaHasta,dFechaRegistro,sCodigoSeguridad,idTipoEstadoTarjeta";
			  	$valuesTarjeta = "'{$rs['idUsuario']}','{$rs['idCuentaUsuario']}','{$rs['idBIN']}',1,'{$sNumeroTarjeta}',1,'{$rs['dVigenciaDesde_sinFormat']}','{$rs['dVigenciaHasta_sinFormat']}',NOW(),'{$rs['sCodigoSeguridad']}',1";
			  	$ToAuditoryTarjeta = "Insercion de una Tarjeta de Credito ::: Empleado ={$_SESSION['id_user']} ::: idCuenta ={$rs['idCuentaUsuario']}";
			  	$idTarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"Tarjetas\",\"$setTarjeta\",\"$valuesTarjeta\",\"{$_SESSION['id_user']}\",\"26\",\"$ToAuditoryTarjeta\");",true);
			  	//$oRespuesta->alert("idTarjeta = ".$idTarjeta);
			  	
			  	//idTipoEstadoTarjeta = 1 es TITULAR
			  	$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
				$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','1',NOW(),''";
				$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=1";
				$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true);  
				$sMensaje .= "La Tarjeta con Nro. ".$aTipoEstado['sNumeroTarjeta']. " se pudo generar su Nueva Version correctamente.<br>";
			}else{
				$sMensaje .="La Tarjeta con Nro. ".$aTipoEstado['sNumeroTarjeta']. " no se pudo generar una Nueva Version su estado es: ".$aTipoEstado['sEstado']."<br>";
			}
		}		
		$oRespuesta->assign("tdContent","innerHTML",$sMensaje);
		$oRespuesta->assign("btnConfirmar","style.display","none");
		//$oRespuesta->redirect("Buscar.php");
		return  $oRespuesta;
	}

	$oXajax=new xajax();	
	$oXajax->registerFunction("nuevasVersionesTarjetasCreditos");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
?>

<body style="background-color:#ffffff;">

<form id="formNuevaVersion" action="NuevaVersionTarjeta.php" method="POST">
<input type="hidden" id="sTarjetas"  name="sTarjetas" value="<? echo $sTarjetas;?>" />
<center>
	<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='0' bordercolor='#000000' width='98%' >
	<tr>
		<td align="center" style="height:25px"><b>Nuevas Versiones de Tarjetas de Creditos</b></td>
	</tr>
	<tr><td style="height:20px">&nbsp;</td></tr>
	<tr>
		<td align="left" style="height:25px" id="tdContent"><span style="">Tarjetas de Creditos :&nbsp;
		<? echo $sNumerosTarjetas;?>
		</td>
	</tr>
	<tr><td style="height:25px">&nbsp;</td></tr>
	<tr><td align="center" style="height:25px"><button type="button" onclick="xajax_nuevasVersionesTarjetasCreditos(xajax.getFormValues('formNuevaVersion'));" id="btnConfirmar" name="btnConfirmar"> Confirmar </button>
	<!--<button type="button" onclick="javascript:closeMessage();" >Cerrar </button>--></td></tr>
	</table>	
</center>
</form>
</body>
</html>