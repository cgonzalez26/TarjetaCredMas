<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	
	$aParametros = array();

	$aParametros = getParametrosBasicos(1);
	
		
	$idTransLiquidacion = $_GET["id"];
	
	$template = "DatosValorDePago.tpl";
	
	$sqlDatos="Call usp_getDatosValoresDePago(\"{$idTransLiquidacion}\");";
	
	$result = $oMysql->consultaSel($sqlDatos,true);
	
	$aParametros["IMPORTE"] = $result["fImporte"];
	$aParametros["COMERCIO"] = $result["sRazonSocial"];
	$aParametros["PLAN"] = $result["sPlan"];
	$aParametros["NRO_COMERCIO"] = $result["sNroComercio"];
	$aParametros["NRO_LIQUIDACION"] = $result["sNroLiquidacion"];
	
	echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/ValoresDePagoComercios/$template",$aParametros);	
		
	echo xhtmlFootPagina();

?>
