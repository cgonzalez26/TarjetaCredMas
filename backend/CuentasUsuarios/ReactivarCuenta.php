<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
	
	function reactivarCuenta($form){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		
		//Actualizamos los Etsados de Cuenta y Tarjeta
		$result = $oMysql->consultaSel("CALL usp_darAltaCuentaUsuario(\"{$form['idCuentaUsuario']}\",\"{$_SESSION['id_user']}\");",true);
		if($result == 'OK'){
			
			$idGrupoAfinidad = $oMysql->consultaSel("SELECT CuentasUsuarios.idGrupoAfinidad FROM CuentasUsuarios WHERE id='{$form['idCuentaUsuario']}'",true);
			//Obtenemos el Periodo Actual para la Cuenta
			$dPeriodoCalendarioActual = $oMysql->consultaSel("SELECT CalendariosFacturaciones.dPeriodo
					FROM CalendariosFacturaciones
					WHERE CalendariosFacturaciones.idGrupoAfinidad = {$idGrupoAfinidad}
					AND CalendariosFacturaciones.dFechaCierre > NOW()
					ORDER BY CalendariosFacturaciones.dPeriodo ASC
					LIMIT 0,1", true);
			
			$rsDetalle = $oMysql->consultaSel("SELECT DetallesCuentasUsuarios.id,
				DetallesCuentasUsuarios.dPeriodo,
				DATE_FORMAT(DetallesCuentasUsuarios.dPeriodo, '%m-%Y') as 'dPeriodoFormatFile' 
				FROM DetallesCuentasUsuarios 
				WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$form['idCuentaUsuario']} 
				AND DetallesCuentasUsuarios.dPeriodo = '{$dPeriodoCalendarioActual}' LIMIT 0,1",true);
				
			if(!$rsDetalle){ //Nos fijamos si tiene Detalle de Cuenta en el Periodo Actual
				
				//Sino tiene obtenemos el Ultimo Periodo existente de la Cuenta
				$aPeriodoViejo = $oMysql->consultaSel("SELECT DetallesCuentasUsuarios.dPeriodo,
						DATE_FORMAT(DetallesCuentasUsuarios.dPeriodo, '%m-%Y') as 'dPeriodoFormatFile'  
						FROM DetallesCuentasUsuarios WHERE DetallesCuentasUsuarios.idCuentaUsuario={$form['idCuentaUsuario']} ORDER BY dPeriodo DESC LIMIT 0,1",true);
				
				//Cerramos el Ultimo Periodo de la Cuenta de Usuario e Insertamos ua fila en Detalle de Cuenta para el Periodo Actual 					
				$sql = "call usp_cerrarPeriodo(\"{$form['idCuentaUsuario']}\",\"{$_SESSION['id_user']}\",\"{$aPeriodoViejo['dPeriodo']}\",\"$dPeriodoCalendarioActual\",1)"; //1=Reactivar
				
				$rs = $oMysql->consultaSel($sql,true);	
				$okResumen = true;
				if($rs){
					//Si se pudo cerrar correctamente el Periodo viejo de la Cuenta generamos el Archivo XML
					generarXmlResumenPorCuenta($form['idCuentaUsuario'],$aPeriodoViejo['dPeriodo'],$aPeriodoViejo['dPeriodoFormatFile']);						
				}else{
					$okResumen = false;
				}
				if(!$okResumen){
					$oRespuesta->alert("No se pudo cerrar el ultimo Periodo de la Cuenta, revise por favor");
				}else{
					//$oRespuesta->alert("Se pudo cerrar el ultimo Periodo de la Cuenta");
					$oRespuesta->alert("La Cuenta se pudo reactivar correctamente.");
				}
			}else{
				$oRespuesta->alert("La Cuenta se pudo reactivar correctamente.");
			}		
			
			//$sMsje = "La Cuenta se pudo Reactivar correctamente.<br> Desea Reasignar los Limites de la Cuenta?";
			$oRespuesta->assign("btnReasignarLimite","style.display","inline");
		}else{
			$sMsje = "La operacion NO se pudo realizar.";
		}	
		
		$oRespuesta->assign("btnConfirmar","style.display","none");		
		$oRespuesta->assign("tdContent","innerHTML",$sMsje);	
		$form['idCuentaUsuario'] = base64_encode($form['idCuentaUsuario']);
		$oRespuesta->assign("idCuentaUsuario","value",$form['idCuentaUsuario']);
		
		return $oRespuesta;		
	}
	
	$_GET['id'] = base64_decode($_GET['id']);
	$idCuentaUsuario = $_GET['id'];	
	$sNumero = $_GET['sNumero'];
	
	$oXajax=new xajax();
	$oXajax->registerFunction("reactivarCuenta");
	$oXajax->processRequest();
	$oXajax->printJavascript( "../includes/xajax/");
	
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";
	$sTitulo = "Reactivar Cuenta de Usuario";
?>

<body style="background-color:#ffffff;">
<center>
<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div>-->

<form  method='POST' name='form' id='form'>
    <!--<div style="width:350px;height:30px;font-family:Tahoma;font-weight:bold;font-size:8pt;text-align:left;" id="divMessageUser"></div>-->
    <input type="hidden" name="idCuentaUsuario" id="idCuentaUsuario" value="<?=$idCuentaUsuario?>">
    <input type="hidden" name="idGrupoAfinidad" id="idGrupoAfinidad" value="<?=$idGrupoAfinidad?>">    
	<input type="hidden" name="idTipoEstadoCuentaActual" id="idTipoEstadoCuentaActual" value="<?=$idTipoEstadoCuenta?>"> 
	
	<table id="TablaReactivar" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
	<tr>
		<td align="center" style="font-weight:bold"><? echo $sTitulo;?></td>
	</tr>
	<tr>
		<td>
			<table id="subTablaMotivo" cellspacing="5" cellpadding="0" width="100%" border="0" class="TablaGeneral">
			<tr><td style="height=10px"></td></tr>
			<tr><td>Nro. de Cuenta: &nbsp;<? echo $sNumero;?></td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td id="tdContent">&iquest;Desea Reactivar esta Cuenta?</td>
			</tr>			
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center">
			<div style="width:350px;text-align:center;">
			<button  type="button" onclick="xajax_reactivarCuenta(xajax.getFormValues('form'));" id="btnConfirmar" name="btnConfirmar"> Confirmar </button> 
			<button  type="button" onclick="reasignarLimites();" id="btnReasignarLimite" name="btnReasignarLimite" style="display:none"> Reasignar Limite </button> 
			</div>
		</td>
	</tr>
	</table>
    
</form>	
<script>
function reasignarLimites(){
	var idCuenta = document.getElementById('idCuentaUsuario').value;
	parent.createWindows('../Limites/ReasignarLimites.php?id='+idCuenta,'Tarjeta',2,'LIM',800, 620);
}

</script>