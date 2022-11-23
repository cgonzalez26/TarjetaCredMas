<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	session_start();
	
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
	
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
	
	/* Opciones configurables */
	$Pagina = intval(cd_paramGlobal('Pagina'));
	$CampoOrden = cd_paramGlobal('CampoOrden');
	$TipoOrden = cd_paramGlobal('TipoOrden');
	
	$aParametros['ID_LIMITE'] = 0;

	if($_GET['id'])
	{		
		$sCondiciones = " WHERE LimitesEstandares.id = {$_GET['id']}";
		$sqlDatos="Call usp_getLimites(\"$sCondiciones\");";
		
		$rs = $oMysql->consultaSel($sqlDatos,true);
		
		//var_export($rs); die();
		
		$aParametros['ID_LIMITE'] = $_GET['id'];
		$aParametros['DESCRIPCION'] = html_entity_decode($rs['sDescripcion']);
		$aParametros['CODIGO'] = $rs['sCodigo'];
		$aParametros['ESTADO'] = $rs['sEstado'];
		$aParametros['LIMITE_COMPRA'] = $rs['iLimiteCompra'];
		$aParametros['LIMITE_CREDITO'] = $rs['iLimiteCredito'];
		$aParametros['LIMITE_PORCENTAJE_FINANCIACION'] = $rs['iLimitePorcentajeFinanciacion'];
		$aParametros['LIMITE_FINANCIACION'] = $rs['iLimiteFinanciacion'];
		$aParametros['LIMITE_PORCENTAJE_PRESTAMO'] = $rs['iLimitePorcentajePrestamo'];
		$aParametros['LIMITE_PRESTAMO'] = $rs['iLimitePrestamo'];
		$aParametros['LIMITE_PORCENTAJE_ADELANTO'] = $rs['iLimitePorcentajeAdelanto'];
		$aParametros['LIMITE_ADELANTO'] = $rs['iLimiteAdelanto'];
		$aParametros['LIMITE_PORCENTAJE_SMS'] = $rs['iLimitePorcentajeSMS'];
		$aParametros['LIMITE_SMS'] = $rs['iLimiteSMS'];
		$aParametros['LIMITE_GLOBAL'] = $rs['iLimiteGlobal'];
		
	}else{
		$sqlDatos = "SELECT sCodigo FROM LimitesEstandares ORDER BY id DESC LIMIT 0,1";
		$sCodigo = $oMysql->consultaSel($sqlDatos,true);
		$sCodigo = (int)$sCodigo +1;
		$aParametros['CODIGO'] = $sCodigo;
	}
	if($_GET['action'] == 'new'){
		$aParametros['DISPLAY_NUEVO'] = "display:none";
	}else{	
		$aParametros['DISPLAY_NUEVO'] = "display:inline";
	}
		
	//$aParametros['DHTMLX_WINDOW']=1;

	$oXajax=new xajax();

	$oXajax->registerFunction("updateDatosLimites");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");	
	
	
	xhtmlHeaderPaginaGeneral($aParametros);		
	
	
	if($_GET['optionEditar'] == 1) //Edicion de Limite
		echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Limites/Limites.tpl",$aParametros);
	else
		echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Limites/VerLimites.tpl",$aParametros);
	
	echo xhtmlFootPagina();
?>
