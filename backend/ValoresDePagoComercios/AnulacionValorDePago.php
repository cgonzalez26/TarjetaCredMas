<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$aParametros = array();

	$aParametros = getParametrosBasicos(1);
	$aParametros['IMAGES_DIR'] = $aParametros['JS_DIR'] . '/images';
	
	$template = "AnulacionValorDePago.tpl";
	
	$aParametros['ID'] =  $_GET["id"];
	$aParametros['NRO_COMERCIO'] =  $_GET["sNroComercio"];
	$aParametros['NRO_TRANSACCION'] =  $_GET["iNroTransaccion"];
	$aParametros['NRO_LIQUIDACION'] =  $_GET["sNroLiquidacion"];
	$aParametros['IMPORTE'] =  $_GET["fImporte"];
	
	#Obtener datos de TransLiquidaciones
	/* 
	...
	...
	...
	...
	*/
	
	$oXajax=new xajax();

	$oXajax->registerFunction("updateTransLiquidaciones");
				
	$oXajax->processRequest();
	$oXajax->printJavascript("../includes/xajax/");
	
	$aParametros['DHTMLX_WINDOW']=1;
	xhtmlHeaderPaginaGeneral($aParametros);		
	$aParametros['DISPLAY_NUEVO'] = "display:inline";  	

	
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/ValoresDePagoComercios/$template",$aParametros);	
		
	echo xhtmlFootPagina();

?>
