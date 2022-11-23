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
	
	function renovarTarjetasCreditos1($form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		$aTarjetas = explode(",",$form['sTarjetas']);
		$sMensaje = "";
		foreach ($aTarjetas as $idTarjeta){
			
			$sqlDatos="SELECT DATE_FORMAT(Tarjetas.dVigenciaHasta, '%d/%m/%Y') as 'dVigenciaHasta',Tarjetas.idTipoEstadoTarjeta,TiposEstadosTarjetas.sNombre as 'sEstado',Tarjetas.sNumeroTarjeta FROM Tarjetas LEFT JOIN TiposEstadosTarjetas ON TiposEstadosTarjetas.id=Tarjetas.idTipoEstadoTarjeta WHERE Tarjetas.id ={$idTarjeta}";
			$aTarjeta = $oMysql->consultaSel($sqlDatos,true);
			$aVigenciaHasta = explode("/",$aTarjeta['dVigenciaHasta']);
			$sFechaActual = date("d/m/Y"); 
			$aFechaActual = explode("/",$sFechaActual);
			if($aFechaActual[1] >= $aVigenciaHasta[1] && $aFechaActual[2] >= $aVigenciaHasta[2] && $aTarjeta['idTipoEstadoTarjeta'] == 8){
			  	$setTarjeta = "dVigenciaDesde=NOW(),dVigenciaHasta=DATE_ADD(NOW(), INTERVAL 2 YEAR),dFechaRegistro=NOW(),idTipoEstadoTarjeta=1";
			  	$conditionsTarjeta = "Tarjetas.id={$idTarjeta}";
			  	$ToAuditoryTarjeta = "Modificacion de Tarjetas de Creditos de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta}";		
				$id = $oMysql->consultaSel("CALL usp_UpdateTable(\"Tarjetas\",\"$setTarjeta\",\"$conditionsTarjeta\",\"{$_SESSION['id_user']}\",\"27\",\"$ToAuditoryTarjeta\");",true);  
			  	
			  	//idTipoEstadoTarjeta = 1 es TITULAR
			  	$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
				$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','17',NOW(),''";
				$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=17";
				$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true);  
				//$oRespuesta->alert("idEstadotarjeta = ".$idEstadotarjeta);
				
			  	$setEstado = "idTarjeta,idEmpleado,idTipoEstadoTarjeta,dFechaRegistro,sMotivo";
				$valuesEstado = "'{$idTarjeta}','{$_SESSION['id_user']}','1',NOW(),''";
				$ToAuditoryEstado = "Insercion Historial de Estados Tarjetas de Creditos ::: Empleado ={$_SESSION['id_user']} ::: idTarjeta={$idTarjeta} ::: estado=1";
				$idEstadotarjeta = $oMysql->consultaSel("CALL usp_InsertTable(\"EstadosTarjetas\",\"$setEstado\",\"$valuesEstado\",\"{$_SESSION['id_user']}\",\"29\",\"$ToAuditoryEstado\");",true);  			
				//$oRespuesta->alert("idEstadotarjeta = ".$idEstadotarjeta);
				$sMensaje .= "La Tarjeta con Nro. ".$aTarjeta['sNumeroTarjeta']. " se pudo Renovar correctamente.<br>";
			}else{
				if($aFechaActual[1] < $aVigenciaHasta[1] || $aFechaActual[2] < $aVigenciaHasta[2]){
					$sMensaje .="La Tarjeta con Nro. ".$aTarjeta['sNumeroTarjeta']. " no se pudo Renovar su fecha de Vencimiento es: ".$aTarjeta['dVigenciaHasta']."<br>";
				}else{	
					if($aTarjeta['idTipoEstadoTarjeta'] != 8)
						$sMensaje .="La Tarjeta con Nro. ".$aTarjeta['sNumeroTarjeta']. " no se pudo Renovar su Estado es: ".$aTarjeta['sEstado']."<br>";
				}
			}
		}		
		$oRespuesta->assign("tdContent","innerHTML",$sMensaje);
		$oRespuesta->assign("btnConfirmar","style.display","none");
		//$oRespuesta->redirect("Buscar.php");
		return  $oRespuesta;
	}


	$oXajax=new xajax();	
	$oXajax->registerFunction("renovarTarjetasCreditos1");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
?>

<body style="background-color:#ffffff;">

<form id="formRenovacion" action="RenovacionTarjetasCreditos.php" method="POST">
<input type="hidden" id="sTarjetas"  name="sTarjetas" value="<? echo $sTarjetas;?>" />
<center>
	<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->
	<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='0' bordercolor='#000000' width='98%' >
	<tr>
		<td align="center" style="height:25px"><b>Renovaciones de Tarjetas de Creditos</b></td>
	</tr>
	<tr><td style="height:20px">&nbsp;</td></tr>
	<tr>
		<td align="left" style="height:25px" id="tdContent"><span style="">Tarjetas de Creditos :&nbsp;
		<? echo $sNumerosTarjetas;?>
		</td>
	</tr>
	<tr><td style="height:25px">&nbsp;</td></tr>
	<tr><td align="center" style="height:25px"><button type="button" onclick="xajax_renovarTarjetasCreditos1(xajax.getFormValues('formRenovacion'));" id="btnConfirmar" name="btnConfirmar"> Confirmar </button>
	<!--<button type="button" onclick="javascript:closeMessage();" >Cerrar </button>--></td></tr>
	</table>	
</center>
</form>
</body>
</html>