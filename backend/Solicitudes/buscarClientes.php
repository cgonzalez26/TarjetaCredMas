<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	include_once(  BASE . '/_global.php' );

	session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();

	$aParametros = getParametrosBasicos(1);
	$aParametros['IMAGES_DIR'] = $aParametros['JS_DIR'] . '/images';
	
	$template = "buscarClientes.tpl";
	$aParametros['optionsTipoDoc'] = $oMysql->getListaOpciones( 'TiposDocumentos', 'id', 'sNombre');
	 
	$oXajax=new xajax();
	
	$oXajax->registerFunction("buscarDatosClientes");
	
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");

	xhtmlHeaderPaginaGeneral($aParametros);	

	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Solicitudes/$template",$aParametros);	

	echo xhtmlFootPagina();
?>