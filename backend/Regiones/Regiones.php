<?php
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

$configure = array();

$configure = getParametrosBasicos(1);

$configure['DHTMLX_GRID'] = 1;

$configure['DHTMLX_GRID_PROCESOR'] = 1;

$configure['DHTMLX_MENU'] = 1;

 
//$oXajax=new xajax();
//$oXajax->registerFunction("updateDatosSolicitud");
//$oXajax->processRequest();
//$oXajax->printJavascript("../includes/xajax/");



xhtmlHeaderPaginaGeneral($configure);	

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Regiones/Regiones.tpl",$configure);

echo xhtmlFootPagina();

?>