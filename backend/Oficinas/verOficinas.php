<?
define( 'BASE' , dirname( __FILE__ ) . '/../..');
include_once(  BASE . '/_global.php' );
include_once( CLASSES_DIR . '/_table.class.php' );

#Control de Acceso al archivo
if(!isLogin()){go_url("/index.php");}

$aParametros = array();
$aParametros = getParametrosBasicos(1);	

$oXajax=new xajax();
$oXajax->setCharEncoding('ISO-8859-1');
$oXajax->configure('decodeUTF8Input',true);
$oXajax->registerFunction("mostrarCoberturasporProvincia");
$oXajax->processRequest();
$oXajax->printJavascript("../includes/xajax/");

xhtmlHeaderPaginaGeneral($aParametros);	

echo parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Oficinas/VerOficinas.tpl",$aParametros);

?>