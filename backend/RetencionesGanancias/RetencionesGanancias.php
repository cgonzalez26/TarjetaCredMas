<?php
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );

session_start();
#Control de Acceso al archivo
//if(!isLogin()){go_url("/index.php");}



$configure = array();

$configure = getParametrosBasicos(1);

$configure['DHTMLX_GRID'] = 1;

$configure['DHTMLX_GRID_PROCESOR'] = 1;

$configure['DHTMLX_MENU'] = 1;

xhtmlHeaderPaginaGeneral($configure);	

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/RetencionesGanancias/RetencionesGanancias.tpl",$configure);

echo xhtmlFootPagina();
?>