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
	if($_GET['id']){	
		$sCondiciones = " WHERE CuentasUsuarios.id = {$_GET['id']}";
		$sqlDatos="Call usp_getCuentasUsuarios(\"$sCondiciones\");";		
		$rs = $oMysql->consultaSel($sqlDatos,true);
		
		$sCondicionesDetalles = " WHERE DetallesCuentasUsuarios.idCuentaUsuario = {$_GET['id']} ORDER BY DetallesCuentasUsuarios.id DESC";
		$sql = "CALL usp_getDetallesCuentasUsuarios(\"$sCondicionesDetalles\")";
		$rsDetalle = $oMysql->consultaSel($sql, true);
		
		$sCondiciones = " WHERE LimitesEstandares.id = {$rs['idLimiteEstandar']}";
		$sqlDatos="Call usp_getLimites(\"$sCondiciones\");";
		$rsLimite = $oMysql->consultaSel($sqlDatos,true);
		
		$sUsuario = "";
		if($rs['iTipoPersona'] == 1)
			$sUsuario .= $rs['sApellido'].', '.$rs['sNombre'];
		else 	
			$sUsuario .= $rs['sRazonSocial'];			
			
		$aParametros['NUMERO_CUENTA'] = $rs['sNumeroCuenta'];
		$aParametros['TITULAR'] = $sUsuario;
				
		$aPeriodo = explode("/",$rsDetalle['dPeriodo']);
		$aParametros['PERIODO_ACTUAL'] = $aPeriodo[1]."/".$aPeriodo[2];
		$aParametros['FECHA_CIERRE_ACTUAL'] = $rsDetalle['dFechaCierre'];
		$aParametros['FECHA_VTO_ACTUAL'] = $rsDetalle['dFechaVencimiento'];
		$aParametros['SALDO_ACTUAL'] = $rsDetalle['fSaldoAnterior'];
		$aParametros['TOTAL_COBRANZAS_ACTUAL'] = "0";
		$aParametros['ESTADO_CUENTA'] =$rsDetalle['sEstado'];
		
		$aParametros['LIMITE'] = $rs['sDescripcionLimite'];
		$aParametros['FECHA_LIMITE'] = $rs['dFechaRegistroLimite'];
		
		$aParametros['LIMITE_COMPRA'] = "$ ".$rsDetalle['fLimiteCompra'];
		$aParametros['LIMITE_CREDITO'] = "$ ".$rsDetalle['fLimiteCredito'];
		$aParametros['LIMITE_FINANCIACION'] = "$ ".$rsDetalle['fLimiteFinanciacion'];
		$aParametros['LIMITE_ADELANTO'] = "$ ".$rsDetalle['fLimiteAdelanto'];
		$aParametros['LIMITE_PRESTAMO'] = "$ ".$rsDetalle['fLimitePrestamo'];
		$aParametros['LIMITE_GLOBAL'] = "$ ".$rsDetalle['fLimiteGlobal'];
		
		$aParametros['LIMITE_PORCENTAJE_FINANCIACION'] = $rsLimite['iLimitePorcentajeFinanciacion'];
		$aParametros['LIMITE_PORCENTAJE_PRESTAMO'] = $rsLimite['iLimitePorcentajePrestamo'];
		$aParametros['LIMITE_PORCENTAJE_ADELANTO'] = $rsLimite['iLimitePorcentajeAdelanto'];
		
		$aParametros['ACUMULADO_CUOTAS'] = "$ ".$rsDetalle['fAcumuladoConsumoCuota'];
		$aParametros['ACUMULADO_UNPAGO'] = "$ ".$rsDetalle['fAcumuladoConsumoUnPago'];
		$aParametros['ACUMULADO_ADELANTOS'] = "$ ".$rsDetalle['fAcumuladoAdelanto'];
		
		$aParametros['REMANENTES_CUOTAS'] = "$ ".$rsDetalle['fRemanenteCredito'];
		$aParametros['REMANENTE_COMPRA'] = "$ ".$rsDetalle['fRemanenteCompra'];
		$aParametros['REMANENTE_ADELANTO'] = "$ ".$rsDetalle['fRemanenteAdelanto'];
		$aParametros['REMANENTE_GLOBAL'] = "$ ".$rsDetalle['fRemanenteGlobal'];
		
		$aParametros['ID_GRUPO_AFINIDAD'] = $rs['idGrupoAfinidad'];
		$aParametros['ID_LIMITE'] = $rs['idCuentaLimite'];
		$aParametros['GRUPO_AFINIDAD'] = $rs['sGrupoAfinidad'];
	}
	
	$oXajax=new xajax();
	$oXajax->registerFunction("mostrarLimite");
	$oXajax->registerFunction("mostrarCalendarioPorGrupoAfinidad");
	$oXajax->registerFunction("altaSolicitud");
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
	
	xhtmlHeaderPaginaGeneral($aParametros);	

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/CuentasUsuarios/VerCuentaUsuario.tpl",$aParametros);	

	echo xhtmlFootPagina();
?>