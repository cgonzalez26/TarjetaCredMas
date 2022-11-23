<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

	session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();

	$aParametros = getParametrosBasicos(1);
	$aParametros['IMAGES_DIR'] = $aParametros['JS_DIR'] . '/images';
	
	$aParametros['_i'] = $_GET['_i'];
	$aParametros['NroCupon'] = $_GET['_n'];
	//var_export($_GET);die();
	
	$template = "FormCuponesEstadoObservado.tpl";
	 
	$oXajax=new xajax();
	
	$oXajax->registerFunction("marcarCuponesObservado");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	xhtmlHeaderPaginaGeneral($aParametros);	

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Cupones/$template",$aParametros);	

	echo xhtmlFootPagina();
?>