<?
	define( 'BASE' , dirname( __FILE__ ) . '/../..');

	include_once(  BASE . '/_global.php' );
	
	include_once( CLASSES_DIR . '/_buttons.class.php' );	

	
	$configure = array();
	
	$configure = getParametrosBasicos(1);
	

	$xajax = new xajax();

	$xajax->registerFunction("updateEstadoLiquidacion");	
	$xajax->processRequest();
	$xajax->printJavascript("../includes/xajax/");
	
	$configure['DHTMLX_WINDOW']=1;
		
	$HTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/AjustesComercios/$template",$configure);	

	xhtmlHeaderPaginaGeneral($configure);
	
	echo xhtmlMainHeaderPagina($configure);
	
	//echo  $buttons->get_buttons();
	
	echo $HTML;

	echo xhtmlFootPagina();	
?>