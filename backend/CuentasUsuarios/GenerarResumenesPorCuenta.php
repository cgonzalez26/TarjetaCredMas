<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);	
	
	function generarResumenesPorCuenta($sCuentas){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		//$oRespuesta->alert($sCuentas);
		$aCuentas = explode(",",$sCuentas);
		
		$dPeriodo = "";
		$dPeriodoFormat = "";
		$rtdo = "";
		$sTabla = "";
		$msje = "";
		$sBody = "";
		foreach ($aCuentas as $idCuentaUsuario){
			//$iTieneresumen= $oMysql->consultaSel("SELECT iTieneResumen FROM CalendariosFacturaciones WHERE idGrupoAfinidad ={$idgrupo} AND dPeriodo='{$dPeriodo}'",true);
			$rsCuenta = $oMysql->consultaSel("SELECT DetallesCuentasUsuarios.dPeriodo as 'dPeriodo',DATE_FORMAT(DetallesCuentasUsuarios.dPeriodo, '%m/%Y') as 'dPeriodoFormat',DATE_FORMAT(DetallesCuentasUsuarios.dPeriodo, '%m-%Y') as 'dPeriodoFormatFile',CuentasUsuarios.sNumeroCuenta,InformesPersonales.sApellido as 'sApellido', InformesPersonales.sNombre as 'sNombre' 
							FROM DetallesCuentasUsuarios 
							LEFT JOIN CuentasUsuarios ON CuentasUsuarios.id=DetallesCuentasUsuarios.idCuentaUsuario							
							LEFT JOIN SolicitudesUsuarios ON SolicitudesUsuarios.id=CuentasUsuarios.idSolicitud
					        LEFT JOIN InformesPersonales ON InformesPersonales.idSolicitudUsuario=SolicitudesUsuarios.id  
							WHERE CuentasUsuarios.id={$idCuentaUsuario}
							AND DetallesCuentasUsuarios.iEmiteResumen=0
							LIMIT 0,1",true);
			$dPeriodo = $rsCuenta['dPeriodo'];
			$dPeriodoFormat = $rsCuenta['dPeriodoFormat'];
			$dPeriodoFormatFile = $rsCuenta['dPeriodoFormatFile'];
			
			$sql = "call usp_generarResumenPorCuenta(\"{$idCuentaUsuario}\",\"{$_SESSION['id_user']}\",\"{$dPeriodo}\")";
			//$oRespuesta->alert($sql);					
			$rs = $oMysql->consultaSel($sql,true);	

			if(!$rs){
				$rtdo = "ERROR";
			}else{
				$rtdo = "OK";
			}
			
			$sSigno = "";
			if($rtdo == 'OK'){
				generarXmlResumenPorCuenta($idCuentaUsuario,$dPeriodo,$dPeriodoFormatFile);
				$sSigno .= "<img src='../includes/images/ok.png' alt='' border=0>";
			}else{
				$sSigno .= "<img src='../includes/images/cancelar.gif' alt='' border=0>";
			}
			$sTitular = $rsCuenta['sApellido'].", ".$rsCuenta['sNombre'];
			$sBody .= "<tr><td>{$rsCuenta['sNumeroCuenta']}</td><td>{$sTitular}</td><td>{$rsCuenta['dPeriodoFormat']}</td><td align='center'>{$sSigno}</td></tr>";					
		}	
		if($sBody != ""){
			$sTabla = "
				<tr><td align='center'>Cuenta</td><td>Titular</td><td align='center'>Periodo</td><td align='center'>Resultado</td></tr>".$sBody;
		}
		$msje .= "<table class='TablaGeneral' cellspacing='0' cellpadding='0' border='1' width='100%'>
			{$sTabla}
			</table><br>";			
		$oRespuesta->assign("tdContent","innerHTML",$msje);
		$oRespuesta->assign("btnGenerar","style.display","none");
		$oRespuesta->assign("btnGenerarXml","style.display","none");
		
		return  $oRespuesta;
	}
	
	function generarResumenesPorCuentaSoloXml($sCuentas){
		GLOBAL $oMysql;	
		$oRespuesta = new xajaxResponse();
		//$oRespuesta->alert($sCuentas);
		$aCuentas = explode(",",$sCuentas);
		
		$dPeriodo = "";
		$dPeriodoFormat = "";
		$rtdo = "";
		$sTabla = "";
		$msje = "";
		$sBody = "";
		foreach ($aCuentas as $idCuentaUsuario){
			$rsCuenta = $oMysql->consultaSel("SELECT DetallesCuentasUsuarios.dPeriodo as 'dPeriodo',DATE_FORMAT(DetallesCuentasUsuarios.dPeriodo, '%m/%Y') as 'dPeriodoFormat',DATE_FORMAT(DetallesCuentasUsuarios.dPeriodo, '%m-%Y') as 'dPeriodoFormatFile',CuentasUsuarios.sNumeroCuenta,InformesPersonales.sApellido as 'sApellido', InformesPersonales.sNombre as 'sNombre' 
							FROM DetallesCuentasUsuarios 
							LEFT JOIN CuentasUsuarios ON CuentasUsuarios.id=DetallesCuentasUsuarios.idCuentaUsuario							
							LEFT JOIN SolicitudesUsuarios ON SolicitudesUsuarios.id=CuentasUsuarios.idSolicitud
					        LEFT JOIN InformesPersonales ON InformesPersonales.idSolicitudUsuario=SolicitudesUsuarios.id  
							WHERE CuentasUsuarios.id={$idCuentaUsuario}	
							##AND DetallesCuentasUsuarios.iEmiteResumen=1						
							ORDER BY DetallesCuentasUsuarios.id ASC LIMIT 0,1",true);
			$dPeriodo = $rsCuenta['dPeriodo'];
			$dPeriodoFormat = $rsCuenta['dPeriodoFormat'];
			$dPeriodoFormatFile = $rsCuenta['dPeriodoFormatFile'];
			
			$rtdo = "OK";
			$sSigno = "";
			if($rtdo == 'OK'){
				//$oRespuesta->alert($idCuentaUsuario."   ".$dPeriodo."   ".$dPeriodoFormatFile);
				generarXmlResumenPorCuenta($idCuentaUsuario,$dPeriodo,$dPeriodoFormatFile);
				$sSigno .= "<img src='../includes/images/ok.png' alt='' border=0>";
			}else{
				$sSigno .= "<img src='../includes/images/cancelar.gif' alt='' border=0>";
			}
			$sTitular = $rsCuenta['sApellido'].", ".$rsCuenta['sNombre'];
			$sBody .= "<tr><td>{$rsCuenta['sNumeroCuenta']}</td><td>{$sTitular}</td><td>{$rsCuenta['dPeriodoFormat']}</td><td align='center'>{$sSigno}</td></tr>";					
		}	
		if($sBody != ""){
			$sTabla = "
				<tr><td align='center'>Cuenta</td><td>Titular</td><td align='center'>Periodo</td><td align='center'>Resultado</td></tr>".$sBody;
		}
		$msje .= "<table class='TablaGeneral' cellspacing='0' cellpadding='0' border='1' width='100%'>
			{$sTabla}
			</table><br>";			
		$oRespuesta->assign("tdContent","innerHTML",$msje);
		$oRespuesta->assign("btnGenerar","style.display","none");
		$oRespuesta->assign("btnGenerarXml","style.display","none");
		return  $oRespuesta;
	}
	
	$oXajax=new xajax();
	$oXajax->setCharEncoding('ISO-8859-1');
    $oXajax->configure('decodeUTF8Input',true);
	$oXajax->registerFunction("generarResumenesPorCuenta");
	$oXajax->registerFunction("generarResumenesPorCuentaSoloXml");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	//$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);	
	
	?>
	<style>
	.TablaGeneral{
		font-family:Tahoma;
		font-size:11px;
	}
	.TablaGeneral th{
		font-family:Tahoma;
		font-size:11px;
	}
	</style>	
<body style="background-color:#ffffff;">
<center>
	<!--<div style='text-align:right;'><a href='javascript:closeMessage();'>[X]</a></div><br />-->
<table class='TablaGeneral' align='center' cellpadding='5' cellspacing='0' border='0' bordercolor='#000000' width='98%' >
<tr>
	<td align="center" style="height:25px" colspan="2"><b>Generar Resumenes</b></td>
</tr>
<tr>
	<td id="tdContent">
		<table class='TablaGeneral' align='center' cellpadding='0' cellspacing='0' border='1' bordercolor='#000000' width='100%' >
		<?php		
		$aCuentas = explode(",",$_GET['sCuentas']);
		$sCuentas = "";
		$sBody = "";
		$sTabla = "";
		foreach ($aCuentas as $idCuentaUsuario){
			$rsCuenta = $oMysql->consultaSel("SELECT DetallesCuentasUsuarios.dPeriodo as 'dPeriodo',DATE_FORMAT(DetallesCuentasUsuarios.dPeriodo, '%m/%Y') as 'dPeriodoFormat',DATE_FORMAT(DetallesCuentasUsuarios.dPeriodo, '%m-%Y') as 'dPeriodoFormatFile',CuentasUsuarios.sNumeroCuenta,InformesPersonales.sApellido as 'sApellido', InformesPersonales.sNombre as 'sNombre' 
							FROM DetallesCuentasUsuarios 
							LEFT JOIN CuentasUsuarios ON CuentasUsuarios.id=DetallesCuentasUsuarios.idCuentaUsuario							
							LEFT JOIN SolicitudesUsuarios ON SolicitudesUsuarios.id=CuentasUsuarios.idSolicitud
					        LEFT JOIN InformesPersonales ON InformesPersonales.idSolicitudUsuario=SolicitudesUsuarios.id  
							WHERE CuentasUsuarios.id={$idCuentaUsuario}
							AND DetallesCuentasUsuarios.iEmiteResumen=0
							LIMIT 0,1",true);
			$sTitular = $rsCuenta['sApellido'].", ".$rsCuenta['sNombre'];
			$sBody .= "<tr><td>{$rsCuenta['sNumeroCuenta']}</td><td>{$sTitular}</td><td>{$rsCuenta['dPeriodoFormat']}</td><td>&nbsp;</td></tr>";	
		}
		$sCuentas .= implode(",",$aCuentasUsuarios);
		if($sBody != ""){
			$sTabla = "<tr><td align='center'>Cuenta</td><td>Titular</td><td align='center'>Periodo</td><td align='center'>Resultado</td></tr>".$sBody;
		}
		echo $sTabla;
		?>
		</table>
	</td>
</tr>
<tr><td align="center" style="height:25px"><button type="button" onclick="xajax_generarResumenesPorCuenta('<?=$_GET['sCuentas']?>');" id="btnGenerar" name="btnGenerar"> Generar </button>
<?
	$sBotonXml = "";
	if(in_array($_SESSION['id_user'],array(296,436)))
		$sBotonXml = "<button id='btnGenerarXml' name='btnGenerarXml' type='button' onclick=\"xajax_generarResumenesPorCuentaSoloXml('{$_GET['sCuentas']}');\"> Generar Resumen Solo Xml</button> &nbsp";
	if($sBotonXml !="") echo $sBotonXml;
?></td></tr>
</table>	
</center>
</body>
</html>