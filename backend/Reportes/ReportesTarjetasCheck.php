<?php
	define( 'BASE' , dirname( __FILE__ ) . '/../..');
	
	include_once(  BASE . '/_global.php' );
	
	include_once( CLASSES_DIR . '/_table.class.php' );
	
	include_once( CLASSES_DIR . '/_buttons.class.php' );
	
	//session_start();
	#Control de Acceso al archivo
	//if(!isLogin()){go_url("/index.php");}

	$configure = array();

	$configure = getParametrosBasicos(1);



	
	
	#botonera
	
	$buttons = new _buttons_('R');	
	
	$buttons->add_button('href','javascript:void(0);','imprimir','new');

	$buttons->set_width('800px;');
	
	
	
	//$searchHTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Bloques/BloqueBuscadorReportesSolicitudesEmpleados.tpl",$configure);	
	
	//$configure['search_form'] = $searchHTML;
	
	$oXajax=new xajax();
		
	$oXajax->register( XAJAX_FUNCTION ,"reportesTarjetasCheck");
	
	$oXajax->register( XAJAX_FUNCTION ,"procesarPolizasTACheck");

	$oXajax->processRequest();
	
	$oXajax->printJavascript("../includes/xajax/");	
	
	###################################################################################################################
	#seteo datos de filtro
	#creo conexion con base de datos de Accesos de sistemas, para obtener datos del empleado
	//$mysql_accesos = $mysql;
	//$mysql_accesos = new MySql();
	//$mysql_accesos->setServer('192.168.2.6','griva','griva');
	//$mysql_accesos->setDBName('AccesosSistemas');

	
	$configure['options_regiones']		=	$oMysql->getListaOpciones( 'Regiones', 'id', 'sNombre');
	$configure['options_sucursales']	=	$oMysql->getListaOpcionesCondicionado( 'idRegion', 'idSucursal', 'Sucursales', 'Sucursales.id', 'Sucursales.sNombre', 'idRegion','Sucursales.sEstado = \'A\'', '','');
	$configure['options_oficinas']		=	$oMysql->getListaOpcionesCondicionado( 'idSucursal', 'idOficina','Oficinas', 'Oficinas.id','Oficinas.sApodo','idSucursal','Oficinas.sEstado = \'A\'', '','');
	
	/*$sub_query = " WHERE Empleados.id = {$_SESSION['id_user']}";
	//$sub_query = " WHERE Empleados.id = 606";
	$user_online = $mysql_accesos->query("CALL usp_getEmpleados(\"$sub_query\");");*/

	$tableHTML = parserTemplate( TEMPLATES_XHTML_DIR . "/Modulos/Reportes/ReportesTarjetasCheck.tpl",$configure);	
	
	$configure['IMAGES_DIR'] = IMAGES_DIR;
	

	xhtmlHeaderPaginaGeneral($configure);
	
	echo xhtmlMainHeaderPagina($configure);
	
	echo $tableHTML;

	echo xhtmlFootPagina();

?>