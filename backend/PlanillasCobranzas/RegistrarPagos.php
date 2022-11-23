<?php 
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );
	
	$idUser = $_SESSION['ID_USER'];
	$TypeUser = $_SESSION['TYPE_USER'];	

	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}
	global $oMysql;
	$aParametros = array();
	$aParametros = getParametrosBasicos(1);
	
	$oXajax = new xajax();
	$oXajax->setCharEncoding('ISO-8859-1');
	$oXajax->configure('decodeUTF8Input',true);
	$oXajax->register( XAJAX_FUNCTION , 'CargarDatosCobranza');
	$oXajax->register( XAJAX_FUNCTION , 'CargarCobranzaActual');	
	$oXajax->register( XAJAX_FUNCTION , 'updatePlanillaCobranza');	
	
	$oXajax->processRequest();					
	$oXajax->printJavascript( "../includes/xajax/");
	
	$aParametros['DHTMLX_CALENDAR'] = 1;
	$aParametros['DHTMLX_GRID'] = 1;
	$aParametros['DHTMLX_GRID_FILTER'] = 1;
	$aParametros['DHTMLX_MENU'] = 1;
	$aParametros['DHTMLX_GRID_PROCESOR'] = 1;
	$aParametros['DHTMLX_GRID_MATH'] = 1;
	//$idCobrador =  $_SESSION['ID_USER'];
	$idCobrador = 297;
	$sCondicion = "PlanillasCobranzas.idCobrador ={$idCobrador} AND (PlanillasCobranzas.idEstadoCobranza=1 OR PlanillasCobranzas.idEstadoCobranza=2)";	
	$aParametros['optionsPlanillasCobranzas'] = $oMysql->getListaOpciones("PlanillasCobranzas","PlanillasCobranzas.id","PlanillasCobranzas.sCodigo",'',$sCondicion,'Seleccionar..','');
	
	xhtmlHeaderPaginaGeneral($aParametros);	
	
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/PlanillasCobranzas/CobranzaActual.tpl",$aParametros);
	
	echo xhtmlFootPagina();
?>